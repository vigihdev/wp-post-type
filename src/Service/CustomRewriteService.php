<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\Service\CustomRewriteInterface;
use WP;
use WP_Post;

final class CustomRewriteService implements CustomRewriteInterface
{
    private const CUSTOM_REWRITE = 'custom_rewrite';
    private const CATEGORY_SLUG = 'category_slug';
    private const POST_SLUG = 'post_slug';

    public function __construct(
        private readonly array $postTypes,
        private readonly array $queryVars,
        private readonly array $taxonomyNames,
    ) {}

    public function register(): void
    {

        $this->registerQueryVars();
        $this->addRewriteRule();
        $this->registerRequestParser();
        $this->registerAutoFlush();
    }

    private function registerRequestParser(): void
    {
        add_action('parse_request', function (WP $wp): void {
            if (!$this->isCustomRewriteRequest($wp)) {
                return;
            }

            $category_slug = (string) ($wp->query_vars[self::CATEGORY_SLUG] ?? '');
            $post_slug = (string) ($wp->query_vars[self::POST_SLUG] ?? '');

            if (empty($post_slug)) {
                return;
            }

            $this->resolvePostType($wp, $post_slug, $category_slug);
        });
    }

    private function isCustomRewriteRequest(WP $wp): bool
    {
        return isset(
            $wp->query_vars[self::CUSTOM_REWRITE],
            $wp->query_vars[self::CATEGORY_SLUG],
            $wp->query_vars[self::POST_SLUG]
        );
    }

    private function resolvePostType(WP $wp, string $post_slug, string $category_slug): void
    {
        foreach ($this->postTypes as $postType) {
            $args = [
                'name'           => $post_slug,
                'post_type'      => $postType,
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'tax_query'      => [
                    [
                        'taxonomy' => $this->queryVars[0],
                        'field'    => 'slug',
                        'terms'    => $category_slug,
                    ],
                ],
            ];

            $query = new \WP_Query($args);

            if ($query->have_posts()) {
                $this->setPostQueryVars($wp, $postType, $post_slug);
                $this->cleanupCustomVars($wp);
                return;
            }
        }
    }

    private function registerAutoFlush(): void
    {

        add_action('wp_insert_post', function ($post_ID, $post, $update) {
            if (!$update && $post instanceof WP_Post && in_array($post->post_type, $this->postTypes)) {
                flush_rewrite_rules();
            }
        }, 10, 3);

        add_action('post_updated', function ($post_ID, $post_after, $post_before) {
            if ($post_after instanceof WP_Post && in_array($post_after->post_type, $this->postTypes)) {
                flush_rewrite_rules();
            }
        }, 10, 3);

        add_action('delete_post', function ($post_ID) {
            $post = get_post($post_ID);
            if ($post instanceof WP_Post && in_array($post->post_type, $this->postTypes)) {
                flush_rewrite_rules();
            }
        });
    }

    private function isPublishedPost(object $post): bool
    {
        return isset($post->post_status) && $post->post_status === 'publish';
    }

    private function setPostQueryVars(WP $wp, string $postType, string $post_slug): void
    {
        $wp->query_vars = [
            'post_type' => $postType,
            'name' => $post_slug,
            $postType => $post_slug,
        ];
    }

    private function cleanupCustomVars(WP $wp): void
    {
        unset(
            $wp->query_vars[self::CUSTOM_REWRITE],
            $wp->query_vars[self::CATEGORY_SLUG],
            $wp->query_vars[self::POST_SLUG]
        );
    }

    private function addRewriteRule(): void
    {

        add_action('init', function (): void {

            $taxonomys = [];
            $terms = get_terms(array(
                'taxonomy' => $this->taxonomyNames,
                'fields'     => 'slugs',
                'number'     => 500,
                'orderby'    => 'count',
                'order'      => 'DESC',
                'hide_empty' => false,
            ));

            if ($terms && !is_wp_error($terms) && !empty($terms)) {
                array_push($taxonomys, ...$terms);
            }

            $termRegex = implode('|', $taxonomys);
            add_rewrite_rule(
                sprintf('^(%s)/([^/]+)/?$', $termRegex),
                sprintf(
                    'index.php?%s=1&%s=$matches[1]&%s=$matches[2]',
                    self::CUSTOM_REWRITE,
                    self::CATEGORY_SLUG,
                    self::POST_SLUG
                ),
                'top'
            );
        });
    }

    private function registerQueryVars(): void
    {
        add_filter('query_vars', function (array $vars): array {
            $coreVars = [
                self::CUSTOM_REWRITE,
                self::CATEGORY_SLUG,
                self::POST_SLUG
            ];

            $customVars = array_filter($this->queryVars, 'is_string');

            return array_merge($vars, $coreVars, $customVars);
        });
    }

    public function toArray(): array
    {
        return [
            'post_types' => $this->postTypes,
            'query_vars' => $this->queryVars
        ];
    }
}

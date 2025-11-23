<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\Service\CustomRewriteInterface;
use WP;

final class CustomRewriteService implements CustomRewriteInterface
{

    private const CUSTOM_REWRITE = 'custom_rewrite';
    private const CATEGORY_SLUG = 'category_slug';
    private const POST_SLUG = 'post_slug';

    public function __construct(
        private readonly array $postTypes,
        private readonly array $queryVars
    ) {}

    public function register(): void
    {

        $this->registerQueryVars();
        $this->addRewriteRule();

        add_action('parse_request', function (WP $wp) {

            if (
                isset($wp->query_vars[self::CUSTOM_REWRITE]) &&
                isset($wp->query_vars[self::CATEGORY_SLUG]) &&
                isset($wp->query_vars[self::POST_SLUG])
            ) {
                $category_slug = $wp->query_vars[self::CATEGORY_SLUG];
                $post_slug = $wp->query_vars[self::POST_SLUG];

                foreach ($this->postTypes as $postType) {
                    if (is_string($postType)) {
                        $kota_post = get_page_by_path($post_slug, OBJECT, $postType);
                        if ($kota_post) {
                            $wp->query_vars['post_type'] = $postType;
                            $wp->query_vars[$postType] = $post_slug;
                            $wp->query_vars['name'] = $post_slug;
                            unset($wp->query_vars[self::CUSTOM_REWRITE]);
                            unset($wp->query_vars[self::CATEGORY_SLUG]);
                            unset($wp->query_vars[self::POST_SLUG]);
                            return;
                        }
                    }
                }
            }
        });
    }

    private function addRewriteRule(): void
    {
        add_action('init', function () {
            add_rewrite_rule(
                '^([^/]+)/([^/]+)/?$',
                'index.php?custom_rewrite=1&category_slug=$matches[1]&post_slug=$matches[2]',
                'top'
            );
        });
    }

    private function registerQueryVars(): void
    {
        add_filter('query_vars', function (array $vars): array {
            $vars[] = self::CUSTOM_REWRITE;
            $vars[] = self::CATEGORY_SLUG;
            $vars[] = self::POST_SLUG;

            foreach ($this->queryVars as $queryVar) {
                if (is_string($queryVar)) {
                    $vars[] = $queryVar;
                }
            }
            return $vars;
        });
    }

    public function toArray(): array
    {
        return [];
    }
}

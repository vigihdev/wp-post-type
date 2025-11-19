<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\PostTypeServiceInterface;
use Vigihdev\WpPostType\Contracts\PostTypeArgsInterface;

final class PostTypeService implements PostTypeServiceInterface
{
    private array $registered = [];

    public function register(string $postType, array $config): void
    {
        $result = register_post_type($postType, $config);

        if (!is_wp_error($result)) {
            $this->registered[$postType] = $result;
        }
    }

    public function registerFromArgs(PostTypeArgsInterface $args): void
    {
        $config = [
            'labels' => $args->getLabels(),
            'public' => $args->isPublic(),
            'supports' => $args->getSupports(),
            'taxonomies' => $args->getTaxonomies(),
            'rewrite' => $args->getRewrite(),
        ];

        $this->register($args->getPostType(), $config);
    }

    public function isRegistered(string $postType): bool
    {
        return isset($this->registered[$postType]) || post_type_exists($postType);
    }

    public function getPostType(string $postType): ?\WP_Post_Type
    {
        return $this->registered[$postType] ?? null;
    }
}

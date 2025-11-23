<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\Service\CustomPermalikInterface;


final class CustomPermalikService implements CustomPermalikInterface
{

    public function __construct(
        private readonly array $postTypesTaxonomys
    ) {}

    public function register(): void
    {
        add_filter('post_type_link', function ($permalink, $post, $leavename) {

            foreach ($this->postTypesTaxonomys as $postType => $taxonomy) {
                if (is_string($postType) && is_string($taxonomy)) {

                    if ($post->post_type == $postType && get_post_status($post) != 'draft') {
                        $kategori = get_the_terms($post->ID, $taxonomy);
                        if ($kategori && !is_wp_error($kategori)) {
                            $kategori_slug = $kategori[0]->slug;
                            $permalink = home_url("/{$kategori_slug}/{$post->post_name}/");
                        }
                    }
                }
            }
            return $permalink;
        }, 10, 3);
    }

    public function toArray(): array
    {
        return $this->postTypesTaxonomys;
    }
}

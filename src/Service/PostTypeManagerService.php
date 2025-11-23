<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\ArrayAbleInterface;
use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\Contracts\Service\PostTypeManagerInterface;

final class PostTypeManagerService implements PostTypeManagerInterface, ArrayAbleInterface
{
    /** @var PostTypeBuilderInterface[] */
    private array $builders = [];

    public function __construct(iterable $postTypes)
    {
        foreach ($postTypes as $pt) {
            if ($pt instanceof PostTypeBuilderInterface) {
                $this->builders[] = $pt;
            }
        }
    }

    /**
     * Jalankan semua register_post_type()
     */
    public function register(): void
    {
        foreach ($this->builders as $builder) {
            register_post_type(
                $builder->getPostType(),
                $builder->build()->toArray()
            );
        }
    }

    /**
     * Untuk debugging atau dev mode
     */
    public function toArray(): array
    {
        return array_map(fn($pt) => $pt->build()->toArray(), $this->builders);
    }
}

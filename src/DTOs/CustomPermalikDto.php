<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleInterface;
use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\Contracts\RewriteTagInterface;
use Vigihdev\WpPostType\Contracts\Service\CustomPermalikInterface;

final class CustomPermalikDto implements CustomPermalikInterface
{

    public function __construct(
        private readonly PostTypeBuilderInterface $builder,
        private readonly RewriteTagInterface $rewriteTag
    ) {}

    public function toArray(): array
    {
        return [
            $this->builder->getPostType() => $this->rewriteTag->getTag()
        ];
    }
}

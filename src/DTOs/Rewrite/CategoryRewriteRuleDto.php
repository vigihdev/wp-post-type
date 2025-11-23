<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs\Rewrite;

use Vigihdev\WpPostType\Contracts\PostTypeBuilderInterface;
use Vigihdev\WpPostType\Contracts\RewriteRuleInterface;
use Vigihdev\WpPostType\DTOs\RewriteRuleDto;

final class CategoryRewriteRuleDto
{

    public static function create(PostTypeBuilderInterface $postType): RewriteRuleInterface
    {
        $type = $postType->getPostType();
        return RewriteRuleDto::fromArray([
            'regex' => '^([a-z0-9-]+)/([a-z0-9-]+)/?$',
            'redirect' => "index.php?post_type={$type}&name=\$matches[2]",
            'position' => 'top',
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\RewriteManagerServiceInterface;
use Vigihdev\WpPostType\DTOs\RewriteRuleDto;

/**
 * Service untuk handle Rewrite Rules
 */
final class RewriteManagerService
{
    /** @var RewriteRuleDto[] */
    private array $rules = [];

    public function __construct(iterable $rewriteRules)
    {
        foreach ($rewriteRules as $rule) {
            $this->rules[] = $rule;
        }
    }

    public function applyRules(): void
    {
        foreach ($this->rules as $rule) {
            add_rewrite_rule(
                $rule->getRegex(),
                $rule->getRedirect(),
                $rule->getPosition() // “top” or “bottom”
            );
        }
    }
}

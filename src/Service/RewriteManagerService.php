<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\RewriteRuleInterface;
use Vigihdev\WpPostType\Contracts\RewriteTagInterface;
use Vigihdev\WpPostType\Contracts\Service\RewriteManagerInterface;
use Vigihdev\WpPostType\DTOs\RewriteRuleDto;
use Vigihdev\WpPostType\DTOs\RewriteTagDto;

/**
 * Service untuk handle Rewrite Rules
 */
final class RewriteManagerService implements RewriteManagerInterface
{

    /** @var RewriteRuleDto[]|RewriteTagDto[] */
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

            if ($rule instanceof RewriteTagInterface) {
                add_rewrite_tag(
                    $rule->getTag(),
                    $rule->getRegex(),
                    $rule->getQuery()
                );
            }

            if ($rule instanceof RewriteRuleInterface) {
                add_rewrite_rule(
                    $rule->getRegex(),
                    $rule->getRedirect(),
                    $rule->getPosition() // “top” or “bottom”
                );
            }
        }
    }
}

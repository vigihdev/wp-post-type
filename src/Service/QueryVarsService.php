<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Service;

use Vigihdev\WpPostType\Contracts\Service\QueryVarsInterface;

final class QueryVarsService implements QueryVarsInterface
{

    public function __construct(
        private readonly array $queryVars
    ) {}


    public function register(): void
    {
        add_filter('query_vars', function ($vars) {
            foreach ($this->queryVars as $query) {
                if (is_string($query)) {
                    $vars[] = $query;
                }
            }
            return $vars;
        });
    }

    public function getQueryVars(): array
    {
        return $this->queryVars;
    }
}

<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

interface RewriteRuleInterface
{

    public function getRegex(): string;
    public function getRedirect(): string;
    public function getPosition(): string;
}

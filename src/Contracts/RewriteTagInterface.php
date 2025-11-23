<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts;

interface RewriteTagInterface
{

    public function getQuery(): string;
    public function getRegex(): string;
    public function getTag(): string;
}

<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts\Service;

interface RewriteManagerInterface
{

    public function applyRules(): void;
}

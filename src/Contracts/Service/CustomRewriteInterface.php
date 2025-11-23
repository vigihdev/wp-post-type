<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\Contracts\Service;

use Vigihdev\WpPostType\Contracts\RegisterInterface;

interface CustomRewriteInterface extends RegisterInterface
{

    public function toArray(): array;
}

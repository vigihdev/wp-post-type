<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use InvalidArgumentException;
use Vigihdev\WpPostType\Contracts\ArrayAbleDtoInterface;
use Vigihdev\WpPostType\Contracts\RewriteRuleInterface;

final class RewriteRuleDto implements ArrayAbleDtoInterface, RewriteRuleInterface
{
    public function __construct(
        private readonly string $regex,
        private readonly string $redirect,
        private readonly string $position = 'top'
    ) {}

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getRedirect(): string
    {
        return $this->redirect;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function toArray(): array
    {
        return [
            'regex' => $this->regex,
            'redirect' => $this->redirect,
            'position' => $this->position,
        ];
    }

    public static function fromArray(array $data): static
    {
        try {
            return new self(
                regex: $data['regex'],
                redirect: $data['redirect'],
                position: $data['position'] ?? 'top'
            );
        } catch (\Throwable $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace Vigihdev\WpPostType\DTOs;

use Vigihdev\WpPostType\Contracts\ArrayAbleDtoInterface;
use Vigihdev\WpPostType\Contracts\RewriteTagInterface;

final class RewriteTagDto implements ArrayAbleDtoInterface, RewriteTagInterface
{
    public function __construct(
        private readonly string $tag,
        private readonly string $regex = '([^/]+)',
        private readonly string $query = ''
    ) {}

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getRegex(): string
    {
        return $this->regex;
    }

    public function getQuery(): string
    {
        return $this->query ?: $this->tag;
    }

    public function toArray(): array
    {
        return [
            'tag' => $this->tag,
            'regex' => $this->regex,
            'query' => $this->query,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            tag: $data['tag'],
            regex: $data['regex'] ?? '([^/]+)',
            query: $data['query'] ?? ''
        );
    }
}

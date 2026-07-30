<?php

namespace Htorres\BlossomTest\Dto;

class ApiResponseDto
{
    public function __construct(
        public readonly int $count,
        public readonly ?int $pages,
        public readonly ?string $next,
        public readonly ?string $prev,
        public readonly array $results,
    ) {}

    public static function fromArray(array $data, string $dtoClass): self
    {
        $results = array_map(fn($item) => $dtoClass::fromArray($item), $data['results']);

        return new self(
            count: $data['info']['count'],
            pages: $data['info']['pages'],
            next: $data['info']['next'],
            prev: $data['info']['prev'],
            results: $results,
        );
    }
}

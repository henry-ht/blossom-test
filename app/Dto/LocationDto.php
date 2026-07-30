<?php

namespace Htorres\BlossomTest\Dto;

class LocationDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $type,
        public readonly string $dimension,
        public readonly array $residents,
        public readonly string $url,
        public readonly string $created,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            type: $data['type'],
            dimension: $data['dimension'],
            residents: $data['residents'],
            url: $data['url'],
            created: $data['created'],
        );
    }
}

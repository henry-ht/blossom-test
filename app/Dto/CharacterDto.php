<?php

namespace Htorres\BlossomTest\Dto;

class CharacterDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $status,
        public readonly string $species,
        public readonly string $type,
        public readonly string $gender,
        public readonly string $image,
        public readonly string $url,
        public readonly string $created,
        public readonly array $origin,
        public readonly array $location,
        public readonly array $episode,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            status: $data['status'],
            species: $data['species'],
            type: $data['type'],
            gender: $data['gender'],
            image: $data['image'],
            url: $data['url'],
            created: $data['created'],
            origin: $data['origin'],
            location: $data['location'],
            episode: $data['episode'],
        );
    }
}

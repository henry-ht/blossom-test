<?php

namespace Htorres\BlossomTest\Dto;

class EpisodeDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $airDate,
        public readonly string $episode,
        public readonly array $characters,
        public readonly string $url,
        public readonly string $created,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            airDate: $data['air_date'],
            episode: $data['episode'],
            characters: $data['characters'],
            url: $data['url'],
            created: $data['created'],
        );
    }
}

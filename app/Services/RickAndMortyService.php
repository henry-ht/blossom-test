<?php

namespace Htorres\BlossomTest\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Htorres\BlossomTest\Dto\ApiResponseDto;
use Htorres\BlossomTest\Dto\CharacterDto;
use Htorres\BlossomTest\Dto\EpisodeDto;
use Htorres\BlossomTest\Dto\LocationDto;

class RickAndMortyService
{
    private const BASE_URL = 'https://rickandmortyapi.com/api/';

    private Client $http;

    public function __construct(?Client $http = null)
    {
        $this->http = $http ?? new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => 10.0,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    // ── Characters ──

    public function getCharacters(array $filters = [], int $page = 1): ApiResponseDto
    {
        return $this->get('character', $filters, $page, CharacterDto::class);
    }

    public function getCharacter(int|string $id): CharacterDto
    {
        $data = $this->request('GET', "character/{$id}");
        return CharacterDto::fromArray($data);
    }

    // ── Locations ──

    public function getLocations(array $filters = [], int $page = 1): ApiResponseDto
    {
        return $this->get('location', $filters, $page, LocationDto::class);
    }

    public function getLocation(int|string $id): LocationDto
    {
        $data = $this->request('GET', "location/{$id}");
        return LocationDto::fromArray($data);
    }

    // ── Episodes ──

    public function getEpisodes(array $filters = [], int $page = 1): ApiResponseDto
    {
        return $this->get('episode', $filters, $page, EpisodeDto::class);
    }

    public function getEpisode(int|string $id): EpisodeDto
    {
        $data = $this->request('GET', "episode/{$id}");
        return EpisodeDto::fromArray($data);
    }

    // ── Internals ──

    private function get(string $endpoint, array $filters, int $page, string $dtoClass): ApiResponseDto
    {
        $query = array_merge($filters, ['page' => $page]);
        try {
            $data = $this->request('GET', $endpoint, ['query' => $query]);
        } catch (\RuntimeException $e) {
            if ($e->getCode() === 404) {
                return new ApiResponseDto(count: 0, pages: 1, next: null, prev: null, results: []);
            }
            throw $e;
        }
        return ApiResponseDto::fromArray($data, $dtoClass);
    }

    private function request(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->http->request($method, $uri, $options);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Rick and Morty API error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }
}

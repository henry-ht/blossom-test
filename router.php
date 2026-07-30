<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helpers.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip base path prefix if present
$base = basePath();
if ($base && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base)) ?: '/';
}

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Accept');

if ($method === 'OPTIONS') {
    http_response_code(204);
    exit;
}

function jsonResponse(mixed $data, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function jsonError(string $message, int $status = 400): void
{
    jsonResponse(['error' => $message], $status);
}

// ── Routes ──

// GET /api/characters
if ($method === 'GET' && $uri === '/api/characters') {
    $requestedPage = (int) ($_GET['page'] ?? 1);
    $filters = $_GET;
    unset($filters['page']);

    if (!empty($filters['protagonists'])) {
        unset($filters['protagonists']);
        $ids = [1, 2, 3, 4, 5];
        $characters = array_map(fn($id) => rickandmorty()->getCharacter($id), $ids);

        foreach ($filters as $key => $value) {
            $characters = array_filter($characters, function ($c) use ($key, $value) {
                return isset($c->$key) && strcasecmp($c->$key, $value) === 0;
            });
        }

        jsonResponse([
            'count' => count($characters),
            'pages' => 1,
            'results' => array_values($characters),
        ]);
    }

    $response = rickandmorty()->getCharacters($filters, $requestedPage);
    jsonResponse($response);
}

// GET /api/characters/{id}
if ($method === 'GET' && preg_match('#^/api/characters/(\d+)$#', $uri, $matches)) {
    jsonResponse(rickandmorty()->getCharacter((int) $matches[1]));
}

// GET /api/locations
if ($method === 'GET' && $uri === '/api/locations') {
    $page = (int) ($_GET['page'] ?? 1);
    jsonResponse(rickandmorty()->getLocations([], $page));
}

// GET /api/locations/{id}
if ($method === 'GET' && preg_match('#^/api/locations/(\d+)$#', $uri, $matches)) {
    jsonResponse(rickandmorty()->getLocation((int) $matches[1]));
}

// GET /api/episodes
if ($method === 'GET' && $uri === '/api/episodes') {
    $page = (int) ($_GET['page'] ?? 1);
    jsonResponse(rickandmorty()->getEpisodes([], $page));
}

// GET /api/episodes/{id}
if ($method === 'GET' && preg_match('#^/api/episodes/(\d+)$#', $uri, $matches)) {
    jsonResponse(rickandmorty()->getEpisode((int) $matches[1]));
}

// Serve PHP / static files for non-API routes
$filePath = __DIR__ . $uri;
if ($uri === '/') {
    $filePath = __DIR__ . '/index.php';
}
if (is_file($filePath)) {
    require $filePath;
    return true;
}

// 404
jsonError('Not found', 404);

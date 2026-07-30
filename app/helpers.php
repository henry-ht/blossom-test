<?php

use Htorres\BlossomTest\Services\RickAndMortyService;

function basePath(): string
{
    static $path = null;

    if ($path === null) {
        $env = parse_ini_file(__DIR__ . '/../.env');
        $path = $env['BASE_PATH'] ?? '';
    }

    return $path;
}

function rickandmorty(): RickAndMortyService
{
    static $instance = null;

    if ($instance === null) {
        $instance = new RickAndMortyService();
    }

    return $instance;
}

function dd(mixed ...$vars): never
{
    foreach ($vars as $var) {
        dump($var);
    }
    exit(1);
}

function dump(mixed ...$vars): void
{
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
}

function isViteDev(): bool
{
    $sock = @fsockopen('localhost', 5173, $errno, $errstr, 0.1);
    if ($sock) {
        fclose($sock);
        return true;
    }
    return false;
}

function asset(string $path): string
{
    if (isViteDev()) {
        return "http://localhost:5173/src/{$path}";
    }

    $manifestPath = __DIR__ . '/../dist/.vite/manifest.json';

    if (!file_exists($manifestPath)) {
        return basePath() . '/dist/assets/' . $path;
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);
    $entry = $manifest['src/js/app.js'] ?? null;

    if ($entry === null) {
        return basePath() . '/dist/assets/' . $path;
    }

    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if ($ext === 'css') {
        $file = $entry['css'][0] ?? $path;
    } else {
        $file = $entry['file'] ?? $path;
    }

    return basePath() . '/dist/' . $file;
}

function viteClient(): string
{
    return 'http://localhost:5173/@vite/client';
}

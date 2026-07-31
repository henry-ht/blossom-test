# Blossom Test

PHP application built with Tailwind CSS, Vite and Alpine.js that consumes the public Rick and Morty API.

## Requirements

- PHP >= 8.3
- Node.js (with npm)
- Composer

## Installation

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Copy and configure the environment file
cp .env.example .env
```

### `.env` configuration

| Variable          | Description                                          | Example        |
| ----------------- | ---------------------------------------------------- | -------------- |
| `BASE_PATH`       | Base path where the app lives (empty if at root).    | `/blossom-test`|
| `API_PER_PAGE`    | Number of characters per page.                       | `10`           |
| `PAGINATION_TYPE` | `normal` (pagination) or `infinite` (infinite scroll).| `normal`       |

## Local server (development mode)

```bash
npm run dev
```

This starts in parallel:

1. The PHP server (`php -S localhost:8000 router.php`) at `http://localhost:8000`.
2. Vite (hot reload) on port `5173`.

If port 8000 is already in use, free it with:

```bash
npm run kill
```

## Building assets

```bash
npm run build
```

Generates the compiled files (CSS/JS and Vite manifest) inside the `dist/` folder. Without building, the app uses Vite in development mode.

## Hosting deployment

Upload the project to your server (Apache) with `mod_rewrite` enabled:

- Include the hidden `.htaccess` file.
- The `.env` file is not uploaded via git; create it manually on the hosting.
- If the app lives at the domain root, leave `BASE_PATH=` empty.
- Adjust `API_PER_PAGE` and `PAGINATION_TYPE` to your preferences.

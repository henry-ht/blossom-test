# Blossom Test

Aplicación PHP con Tailwind CSS, Vite y Alpine.js que consume la API pública de Rick and Morty.

## Requisitos

- PHP >= 8.3
- Node.js (con npm)
- Composer

## Instalación

```bash
# Instalar dependencias de PHP
composer install

# Instalar dependencias de JavaScript
npm install

# Copiar y configurar el archivo de entorno
cp .env.example .env
```

### Configuración del `.env`

| Variable           | Descripción                                             | Ejemplo        |
| ------------------ | ------------------------------------------------------- | -------------- |
| `BASE_PATH`        | Ruta base donde vive la app (vacío si es la raíz).      | `/blossom-test`|
| `API_PER_PAGE`     | Cantidad de personajes por página.                      | `10`           |
| `PAGINATION_TYPE`  | `normal` (paginación) o `infinite` (scroll infinito).   | `normal`       |

## Servidor local (modo desarrollo)

```bash
npm run dev
```

Esto levanta en paralelo:

1. El servidor PHP (`php -S localhost:8000 router.php`) en `http://localhost:8000`.
2. Vite (hot reload) en el puerto `5173`.

Si el puerto 8000 ya está ocupado, libéralo con:

```bash
npm run kill
```

## Compilar assets

```bash
npm run build
```

Genera los archivos compilados (CSS/JS y manifest de Vite) dentro de la carpeta `dist/`. Sin compilar, la app usa Vite en modo desarrollo.

## Despliegue en hosting

Sube el proyecto al servidor (Apache) con `mod_rewrite` activado:

- Incluye el archivo oculto `.htaccess`.
- El `.env` no se sube por git; créalo a mano en el hosting.
- Si la app está en la raíz del dominio, deja `BASE_PATH=` vacío.
- Ajusta `API_PER_PAGE` y `PAGINATION_TYPE` según prefieras.

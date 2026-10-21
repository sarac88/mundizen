# Imágenes de la demo

Estas imágenes están versionadas en el repo a propósito: son las que usa el seeder
para reconstruir la demo siempre igual, sin depender de descargas externas.

Van de la mano del fixture `../data/demo.json`, que guarda los usuarios y anuncios
y apunta a los archivos de esta carpeta.

## Flujo de trabajo

1. Retocas la demo desde la propia aplicación en local (textos, precios, fotos).
2. `php artisan demo:export` congela ese estado: reescribe `demo.json` y copia
   aquí cualquier imagen nueva que hayas subido.
3. Commiteas y haces push.
4. En el servidor, `php artisan migrate:fresh --seed` devuelve exactamente eso.

## Estructura

```
assets/
  ads/
    manuales/      01.jpg, 02.jpg, ...
    energeticas/
    cursos/
    productos/
  avatars/         01.jpg, 02.jpg, ...
```

Las subcarpetas de `ads/` son las categorías del modelo `Ad`. El seeder coge las
fotos de la carpeta que corresponde a la categoría del anuncio.

## Convenciones

- Numeradas `01.jpg`, `02.jpg`, ... sin huecos.
- Anuncios: 800x600. Avatares: 400x400. JPEG.
- Mantenerlas ligeras (< 150 KB); van en el repo.

## Cómo cambiar una imagen

Sustituye el archivo manteniendo el nombre, o añade uno nuevo con el siguiente
número de la carpeta. No hace falta tocar código.

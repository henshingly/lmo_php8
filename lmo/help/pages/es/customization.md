# Personalizar el LMO

1. [Iconos de equipo](#1-iconos-de-equipo)
2. [CSS propio](#2-css-propio)
3. [Plantillas](#3-plantillas)
4. [Integrar el LMO en páginas web existentes](#4-integrar-el-lmo-en-paginas-web-existentes)

Además del [editor de diseño](#options/3-el-editor-de-diseno), puedes adaptar el LMO con iconos de equipo, tu propio CSS y un sencillo sistema de plantillas.

---

## 1. Iconos de equipo

Con pequeños escudos de club das mejor aspecto al LMO. El LMO encuentra los archivos automáticamente:

- Copia los iconos en `img/teams/small/`.
- El nombre de archivo debe coincidir con el nombre del equipo (también puntos o espacios). Solo el carácter `/` no está permitido; simplemente omítelo en el nombre de archivo.
- Algunos addons muestran iconos ampliados. Colócalos en `img/teams/big/`.
- Los formatos permitidos son PNG, GIF y JPG.

> **Apache 2:** Quita todos los caracteres especiales de los nombres de archivo; solo se permiten letras y cifras.

---

## 2. CSS propio

Si los ajustes del editor de diseño no bastan, edita el archivo `template/style.css`. Se carga automáticamente y sobrescribe el editor de diseño. Edítalo con un editor de texto y, si hace falta, compruébalo con el [validador CSS del W3C](https://jigsaw.w3.org/css-validator/).

---

## 3. Plantillas

Una plantilla es un archivo HTML complementado con comentarios HTML de la forma `<!--Nombre-->`. El LMO sustituye cada comentario por la parte correspondiente de su salida. Con la posición de los comentarios decides dónde aparece cada cosa. Si omites un comentario, esa parte no aparece. También puedes usar varias plantillas para el mismo LMO.

Las plantillas están en la carpeta `template/` (`lmo-standard-komplett.tpl.php` y `lmo-standard.tpl.php`). Para los addons hay más plantillas, p. ej. en `template/mini/` y `template/viewer/`.

| Comentario | Contenido |
|---|---|
| `<!--Titel-->` | Texto del título del LMO |
| `<!--Stylesheet-->` | La hoja de estilos |
| `<!--Newsticker-->` | El ticker de noticias integrado |
| `<!--Kalender-->` | Enlace de navegación al calendario |
| `<!--Ergebnisse-->` | Enlace de navegación a los resultados |
| `<!--Tabelle-->` | Enlace de navegación a la clasificación |
| `<!--Spielplan-->` | Enlace de navegación al calendario de partidos |
| `<!--Kreuztabelle-->` | Enlace de navegación a la tabla cruzada |
| `<!--Fieberkurve-->` | Enlace de navegación a la curva de forma |
| `<!--Ligastatistik-->` | Enlace de navegación a las estadísticas de la liga |
| `<!--Spielerstatistik-->` | Enlace de navegación a las estadísticas de jugadores |
| `<!--Tippspiel-->` | Enlace de navegación al juego de pronósticos |
| `<!--Info-->` | Enlace de navegación a la página de información, **no lo quites** |
| `<!--Hauptteil-->` | Parte principal del LMO |
| `<!--Savehtml-->` | Enlaces para las versiones de impresión bajo resultados o clasificación |
| `<!--Sprachauswahl-->` | Selección de idioma |
| `<!--Ligenuebersicht-->` | Enlace al resumen de ligas |
| `<!--LetzteAuswertung-->` | Fecha de la última evaluación de la liga elegida |
| `<!--Berechnungszeit-->` | Tiempo de cálculo |
| `<!--Infolink-->` | Aviso de copyright, **no puede eliminarse** (véase [Aviso legal](#getting-started/7-aviso-legal)) |

Procura que se genere HTML correcto. Puedes comprobarlo con el [validador HTML del W3C](https://validator.w3.org/).

Según cómo integres el LMO necesitas una de dos plantillas: un **documento HTML completo** para la llamada directa, o una plantilla con **solo la parte HTML** para la inclusión mediante `include`.

---

## 4. Integrar el LMO en páginas web existentes

Puedes llamar al LMO directamente o incluirlo en tus páginas mediante `include`.

### Llamada directa

Llama al LMO mediante `lmo.php`. Qué plantilla se usa se define en este archivo. Por defecto es `lmo-standard-komplett.tpl.php`, un documento HTML completo.

La llamada directa también sirve para un **iframe**:

```html
<iframe src="URL-del-LMO/lmo.php" width="ancho" height="alto" style="border:0"></iframe>
```

Con el ancho y el alto tienes que experimentar, por desgracia; es una de las desventajas de los iframes.

Con parámetros en la URL se empieza directamente en una vista concreta, p. ej. `lmo.php?file=liga.l98` para empezar con una liga.

Para una segunda plantilla, copia `lmo.php`, renómbrala (p. ej. `lmoneu.php`) y cambia en ella la llamada a la plantilla. Así accedes al „nuevo" LMO con `lmoneu.php`.

### Include

Más cómoda es la inclusión mediante `include` en una página PHP existente:

```php
<?php include("RutaAlLMO/lmo.php"); ?>
```

Ten en cuenta lo siguiente:

- **`RutaAlLMO` es una ruta de archivo, no una URL.** `include("http://www.misitio.es/lmo/lmo.php");` no funciona.
- Una liga que debe abrirse de inmediato en lugar del resumen de ligas se indica **antes** del include: `$file = "NombreDeLaLiga.l98";`
- Por defecto se carga `lmo-standard.tpl.php` (sin „komplett"). No es un documento HTML completo; el resto de las partes provienen de tu página.
- En la primera línea de tu página debe figurar:

  ```php
  <?php if (session_id() == "") session_start(); ?>
  ```

- Si tu página aún no usa `<!DOCTYPE html>`, añádelo. Indica también el juego de caracteres en el `<head>`: `<meta charset="utf-8">`
- Incluye en el `<head>` la hoja de estilos del LMO:

  ```html
  <link rel="stylesheet" href="RutaAlLMO/lmo-style-nc.php">
  <style>@import url('RutaAlLMO/lmo-style.php');</style>
  ```

Con el mismo método puedes usar varias plantillas.

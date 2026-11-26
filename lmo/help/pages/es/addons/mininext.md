# Mininext

1. [Configuración](#1-configuracion)
2. [Integración](#2-integracion)
3. [Plantillas](#3-plantillas)

![Captura de Mininext](./assets/media/mininext.png)

El script Mininext muestra el próximo partido de un equipo en un bloque compacto que se integra fácilmente en cualquier página existente. Además se muestran, en orden descendente por fecha, los enfrentamientos anteriores de los equipos implicados a partir del archivo.

---

## 1. Configuración

El addon Mininext se configura mediante la gestión de addons del LMO. Para cada integración individual se pueden pasar parámetros adicionales.

### Gestión de addons

En la gestión de addons haz clic en **mini**. Se pueden controlar los siguientes parámetros básicos:

| Parámetro | Significado |
|---|---|
| `mininext_withArchiv` | Búsqueda en el archivo activada/desactivada |
| `mininext_unGreedy` | Búsqueda difusa activada/desactivada; une nombres de equipo de sonido parecido |
| `mininext_barWidth` | Ancho de la barra de V/E/D |
| `mininext_standardTemplate` | Plantilla predeterminada si no se indica ninguna |

### Parámetros

Mediante URL (iframe) o como variables de include puedes pasar los siguientes valores:

| Parámetro | Significado |
|---|---|
| `file` | Nombre de archivo de la liga, p. ej. `bundesliga.l98` |
| `folder` | Carpeta de archivo para buscar partidos anteriores. Consejo: crea una subcarpeta propia por liga en lugar de poner todo directamente en la carpeta de archivo. |
| `a` | Número del equipo A. Solo es necesario si no hay equipo favorito en el archivo de la liga. |
| `b` | Número del rival. No es necesario para el próximo partido, solo si se debe mostrar un enfrentamiento concreto. |
| `mini_template` | Plantilla a usar. Si se omite: plantilla predeterminada. |

---

## 2. Integración

Hay dos formas. La primera es la preferible; la segunda solo está pensada para servidores sin soporte de PHP o archivos `.html`.

### Integrar mediante include

Define los parámetros directamente como variables PHP, *dentro de un bloque PHP* (ábrelo con `<?php` si hace falta):

```php
$file="liga1.l98";
$folder="archiv/First_Team";
```

Fíjate en el `$` delante del nombre, las comillas alrededor de las cadenas y el punto y coma final. Solo el nombre de la liga es obligatorio. Después integra el addon:

```php
include("RutaAlLMO/addon/mini/lmo-mininext.php");
```

`RutaAlLMO` es la ruta absoluta o relativa al directorio del LMO.

> **Atención:** Nunca uses una URL, nada de `include("http://www.../lmo-mininext.php");`. Indica siempre una **ruta de archivo**.

> **Nota:** Si no usas sesiones en tu página, añade `<?php session_start(); ?>` como primera línea del archivo.

### Integrar mediante iframe

Solo si el método include no funciona. Los parámetros forman parte de la URL de origen:

```html
<iframe src="URLDelLMO/addon/mini/lmo-mininext.php?file=liga1.l98&folder=archiv/First_Team"
  style="border:0" width="ancho" height="alto" scrolling="no"></iframe>
```

`URLDelLMO` es la dirección web de tu LMO. Con `ancho` y `alto` tienes que experimentar. El primer parámetro se separa con `?`, los siguientes con `&`.

---

## 3. Plantillas

Igual que con el LMO, puedes adaptar la estructura y el diseño de Mininext. Las plantillas están en el subdirectorio `mini` de la carpeta `template`. La predeterminada es `mininext.tpl.php` (modificable en la gestión de addons). Puedes crear tantas plantillas como quieras (extensión `.tpl.php`).

### El próximo partido

| Marcador | Significado |
|---|---|
| `<!--gameTxt-->` | Encabezado |
| `<!--gameDate-->` | Fecha del próximo partido |
| `<!--gameTime-->` | Hora del próximo partido |
| `<!--countDown-->` | Cuenta atrás hasta el próximo partido |
| `<!--homeName-->` | Nombre del equipo local |
| `<!--homeNameMiddle-->` | Nombre de longitud media del equipo local |
| `<!--homeNameShort-->` | Nombre corto del equipo local |
| `<!--homeTore-->` | Goles del equipo local (desde LMO 4.0.2) |
| `<!--imgHomeBig-->` | Icono grande del equipo local |
| `<!--imgHomeSmall-->` | Icono pequeño del equipo local |
| `<!--guestName-->` | Nombre del equipo visitante |
| `<!--guestNameMiddle-->` | Nombre de longitud media del equipo visitante |
| `<!--guestNameShort-->` | Nombre corto del equipo visitante |
| `<!--guestTore-->` | Goles del equipo visitante (desde LMO 4.0.2) |
| `<!--imgGuestBig-->` | Icono grande del equipo visitante |
| `<!--imgGuestSmall-->` | Icono pequeño del equipo visitante |
| `<!--gameNote-->` | Nota del partido |
| `<!--ligaDatum-->` | Fecha de la última modificación de la liga |
| `<!--copy-->` | Aviso de copyright, **¡no debe modificarse ni eliminarse!** |

### Enfrentamientos anteriores

**Fuera de `<!-- BEGIN/END matches -->`:**

| Marcador | Significado |
|---|---|
| `<!--matchesText-->` | Encabezado de los partidos anteriores |
| `<!--winCount-->` / `<!--drawCount-->` / `<!--lostCount-->` | Número de victorias locales / empates / victorias visitantes |
| `<!--winTxt-->` / `<!--drawTxt-->` / `<!--lostTxt-->` | Etiquetas de victorias/empates/derrotas (p. ej. V, E, D) |
| `<!--winWidth-->` / `<!--drawWidth-->` / `<!--lostWidth-->` | Ancho de la barra de victorias/empates/derrotas |
| `<!-- BEGIN matches -->` | Inicio del bloque repetido. **¡Respeta los espacios antes de BEGIN y después de matches!** |
| `<!-- END matches -->` | Fin del bloque repetido. **¡Respeta los espacios antes de END y después de matches!** |

**Solo dentro de `<!-- BEGIN/END matches -->`:**

| Marcador | Significado |
|---|---|
| `<!--class-->` | Resaltado en color del partido |
| `<!--date-->` | Fecha del partido |
| `<!--time-->` | Hora del partido |
| `<!--hTore-->` | Goles locales |
| `<!--gTore-->` | Goles visitantes |
| `<!--where-->` | Partido en casa o fuera |
| `<!--matchingName-->` | Con búsqueda difusa activa: el nombre de equipo encontrado |

### El partido anterior

| Marcador | Significado |
|---|---|
| `<!--previous_gameTxt-->` | Encabezado |
| `<!--previous_gameDate-->` | Fecha del partido anterior |
| `<!--previous_gameTime-->` | Hora del partido anterior |
| `<!--previous_homeName-->` | Nombre del equipo local |
| `<!--previous_homeNameMiddle-->` | Nombre de longitud media del equipo local |
| `<!--previous_homeNameShort-->` | Nombre corto del equipo local |
| `<!--previous_imgHomeBig-->` | Icono grande del equipo local |
| `<!--previous_imgHomeSmall-->` | Icono pequeño del equipo local |
| `<!--previous_guestName-->` | Nombre del equipo visitante |
| `<!--previous_guestNameMiddle-->` | Nombre de longitud media del equipo visitante |
| `<!--previous_guestNameShort-->` | Nombre corto del equipo visitante |
| `<!--previous_imgGuestBig-->` | Icono grande del equipo visitante |
| `<!--previous_imgGuestSmall-->` | Icono pequeño del equipo visitante |

Adapta el código HTML a tu gusto, pero cuida de que sea HTML/CSS correcto.

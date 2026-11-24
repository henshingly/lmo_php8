# TopTipper

1. [Requisitos del sistema](#1-requisitos-del-sistema)
2. [Archivos explicados](#2-archivos-explicados)
3. [Descarga](#3-descarga)

![Vista de TopTipper](./assets/media/toptipper.png)

El addon TopTipper muestra de forma compacta y clara la clasificación actual del juego de pronósticos.

---

## 1. Requisitos del sistema

- Un LMO 4 funcionando, desde Beta 3, con el juego de pronósticos activado

---

## 2. Archivos explicados

La descarga contiene 4 archivos.

**`toptipper.php`**
Está en la carpeta `addon/tipp/`.

**`kal.tip`**
Está en la carpeta `config/tipp/`. Es el archivo de configuración. Puedes renombrarlo siempre que se conserve la extensión `*.tip` y el nuevo nombre se tenga en cuenta al integrarlo.

Contenido del archivo:

```
[config]
modus=1              // leave mode at 1, may still be useful
anzahl_tipper=10     // number of tippers in the display
all=0                // 0 or 1: 0 shows the file, 1 overall
file=erg_dfb.l98     // your league
template=standard    // template name without the extension *.tpl.php
```

(`modus`: déjalo en 1; `anzahl_tipper`: número de participantes mostrados; `all`: 0 muestra el archivo, 1 la clasificación general; `file`: tu liga; `template`: nombre de la plantilla sin la extensión `*.tpl.php`.)

**`standard.tpl.php`**
Está en la carpeta `template/tipp/`. Puedes diseñar la plantilla libremente. Marcadores disponibles:

| Marcador | Significado |
|---|---|
| `<!--Link-->` | Enlace al juego de pronósticos |
| `<!--Lmo-->` | Enlace al LMO |
| `<!--Platz-->` | Puesto de los participantes |
| `<!--Name-->` | Nombre de los participantes |
| `<!--Punkte-->` | Puntos de los participantes |

**`tipp.php`**
Está directamente en el directorio raíz de tu LMO. Sirve para integrar el script; adapta el contenido en consecuencia.

Ejemplo:

```php
<?php
$multi="kal";  // Se integra tu archivo adaptado kal.tip.
require(dirname(__FILE__) . '/init.php');
include(PATH_TO_ADDONDIR . "/tipp/toptipper.php");
?>
```

---

## 3. Descarga

- [TopTipper](https://www.liga-manager-online.org/forum/viewtopic.php?t=94)

> Con cada versión se incluyen instrucciones de instalación detalladas.

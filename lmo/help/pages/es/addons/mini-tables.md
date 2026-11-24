# Minitablas

1. [Parámetros de control](#1-parametros-de-control)
2. [Integración](#2-integracion)
3. [Plantillas](#3-plantillas)

![Vista de usuario](./assets/media/minitabs01.png)

El LMO permite mostrar clasificaciones o fragmentos de clasificaciones en páginas externas. Así puedes, por ejemplo, integrar en tu página de inicio una versión compacta de la clasificación actual. Qué detalles se muestran y qué aspecto tiene la tabla puedes configurarlo libremente mediante [plantillas](#3-plantillas).

---

## 1. Parámetros de control

Igual que en el ticker, las minitablas tienen varios parámetros de control.

| Parámetro | Significado |
|---|---|
| `mini_liga` | Nombre de archivo de la liga (con la extensión `.l98`) |
| `mini_platz` | ¿Alrededor de qué puesto debe centrarse el fragmento? Déjalo vacío para el equipo favorito. |
| `mini_ueber` | ¿Cuántos equipos mostrar por encima del elegido? |
| `mini_unter` | ¿Cuántos equipos mostrar por debajo del elegido? |
| `mini_template` | Nombre de la plantilla (sin extensión). Si no se indica, se usa `standard`. |

---

## 2. Integración

Hay dos formas de integrar minitablas. La primera es la preferible; la segunda solo está pensada para servidores sin soporte de PHP o archivos `.html`.

### Integrar mediante include

Los parámetros se definen directamente como variables PHP, *dentro de un bloque PHP* (ábrelo con `<?php` si hace falta):

```php
$mini_liga="liga1.l98";
$mini_ueber=3;          // 3 equipos por encima del equipo favorito
$mini_unter=2;          // 2 equipos por debajo del equipo favorito
$mini_template="all";   // usar la plantilla "all.tpl.php"
```

Fíjate en el `$` delante del nombre del parámetro, las comillas alrededor de las cadenas y el punto y coma final. Solo el nombre de la liga es obligatorio. Después integra la minitabla:

```php
include("RutaAlLMO/addon/mini/lmo-minitab.php");
```

`RutaAlLMO` es la ruta absoluta o relativa al directorio del LMO.

> **Atención:** Nunca uses una URL, nada de `include("http://www.../minitab.php");`, ¡porque no funciona! Indica siempre una **ruta de archivo**.

### Integrar mediante iframe

Solo si el método include no funciona. Los iframes tienen desventajas (compatibilidad de navegadores, usabilidad). Los parámetros forman parte de la URL de origen:

```html
<iframe src="URLDelLMO/addon/mini/lmo-minitab.php?mini_liga=liga1.l98&mini_ueber=3&mini_unter=2&mini_template=all"
  style="border:0" width="ancho" height="alto" scrolling="no"></iframe>
```

`URLDelLMO` es la dirección web de tu LMO. Con `ancho` y `alto` tienes que experimentar. El primer parámetro se separa con `?`, los siguientes con `&`.

---

## 3. Plantillas

Igual que con el propio LMO, puedes adaptar libremente la estructura y el diseño de las minitablas. Las plantillas están en el subdirectorio `mini` de la carpeta `template`. Sin parámetros de control se usa `standard.tpl.php`. Puedes crear tantas plantillas como quieras (extensión `.tpl.php`).

Están disponibles los siguientes marcadores:

| Marcador | Significado |
|---|---|
| `<!--Link-->` | Enlace a la clasificación completa en el LMO |
| `<!-- BEGIN Inhalt -->` | Inicio del bloque que se repite para cada equipo. **¡Respeta los espacios antes de BEGIN y después de Inhalt!** |
| `<!-- END Inhalt -->` | Fin del bloque repetido. **¡Respeta los espacios antes de END y después de Inhalt!** |
| `<!--Style-->` | Activa el resaltado de campeón, descendidos, etc. según el ajuste de la liga |
| `<!--Team-->` | Nombre corto del equipo |
| `<!--TeamLang-->` | Nombre completo del equipo |
| `<!--TeamMittel-->` | Nombre de longitud media del equipo |
| `<!--TeamBild-->` | Icono del equipo (si existe) |
| `<!--Teamnotiz-->` | Nota del equipo |
| `<!--Spiele-->` | Número de partidos |
| `<!--Punkte-->` | Puntos; con puntos negativos en la forma **+P:-P** |
| `<!--PlusTore-->` | Goles a favor |
| `<!--MinusTore-->` | Goles en contra |
| `<!--Tordifferenz-->` | Diferencia de goles |
| `<!--Siege-->` | Número de victorias |
| `<!--Unentschieden-->` | Número de empates |
| `<!--Niederlagen-->` | Número de derrotas |

Adapta el código HTML a tu gusto, pero cuida de que sea HTML/CSS correcto. En la plantilla `all.tpl.php` encontrarás todos los marcadores como ejemplo.

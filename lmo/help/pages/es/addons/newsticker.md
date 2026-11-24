# Ticker de noticias

1. [Parámetros de control](#1-parametros-de-control)
2. [Integración](#2-integracion)

![Vista de usuario](./assets/media/ticker01.png)

El LMO lleva integrado un ticker de noticias flexible que muestra resultados y notas como texto en movimiento que ahorra espacio. En el [editor de resultados](#edit-league/3-el-editor-de-resultados) puedes activar o desactivar el ticker por separado para cada liga. Aparece entonces en el área de usuarios sobre la liga correspondiente. También puedes integrarlo en cualquier lugar de tu web e incluso configurarlo para que varias ligas se reúnan en un mismo ticker.

---

## 1. Parámetros de control

Con estos parámetros controlas el comportamiento del ticker. En la [gestión de addons](#options/2-gestion-de-addons) puedes cambiar los valores predeterminados; valen para los tickers situados sobre las ligas y para cualquier ticker al que no se pasen parámetros propios.

| Parámetro | Valor | Significado |
|---|---|---|
| `standard_ligen` | nombre(s) de archivo | Nombres de archivo con la extensión `.l98`; separa varias ligas con comas |
| `tickerart` | `1` | Ticker de resultados |
| | `2` | Texto de ticker del LMO |
| | `3` | Ticker de resultados, solo equipo favorito |
| `tickertitel` | `0` | Ocultar el encabezado del ticker |
| | `1` | Mostrar el encabezado del ticker |
| `notizanzeigen` | `0` | Ocultar las notas de partido |
| | `1` | Mostrar las notas de partido |
| `breite` | número | Ancho del ticker (en número de letras) |
| `geschwindigkeit` | número | Velocidad de desplazamiento del ticker |

---

## 2. Integración

Hay dos formas de integrar el ticker de noticias. La primera es la preferible; la segunda solo está pensada para servidores sin soporte de PHP (cuando el LMO funciona en un servidor externo) o cuando usas un archivo `.html` (que normalmente PHP no procesa).

### Integrar mediante include

Los parámetros se definen directamente como variables PHP. Escríbelos uno tras otro *dentro de un bloque PHP* (ábrelo con `<?php` si hace falta):

```php
$tickerart="1";
$tickerligen="liga1.l98,liga2.l98";
```

Fíjate en el `$` delante del nombre del parámetro, las comillas alrededor de las cadenas y el punto y coma final. Solo tienes que indicar los parámetros que difieran de los ajustes predeterminados. Después integra el ticker:

```php
include("RutaAlLMO/addon/ticker/ticker.php");
```

`RutaAlLMO` es la ruta absoluta o relativa al directorio del LMO.

> **Atención:** Nunca uses una URL, es decir, nada de `include("http://www.../ticker.php");`, ¡porque no funciona! Indica siempre una **ruta de archivo**.

### Integrar mediante iframe

Usa este método solo si la variante include no funciona por algún motivo. Los iframes no son compatibles con todos los navegadores y tienen además desventajas de usabilidad. Aquí los parámetros forman parte de la URL de origen:

```html
<iframe src="URLDelLMO/addon/ticker/ticker.php?tickerart=1&tickerligen=liga1.l98,liga2.l98"
  style="border:0" width="ancho" height="alto" scrolling="no"></iframe>
```

`URLDelLMO` es la dirección web de tu LMO. Con `ancho` y `alto` tienes que experimentar un poco, por desgracia. El primer parámetro se separa con `?`, todos los siguientes con `&`.

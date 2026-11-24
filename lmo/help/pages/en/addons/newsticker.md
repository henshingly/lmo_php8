# News ticker

1. [Control parameters](#1-control-parameters)
2. [Integration](#2-integration)

![User view](./assets/media/ticker01.png)

The LMO has a flexible news ticker built in that shows results and notes as a space-saving scrolling bar. In the [results editor](#edit-league/3-the-results-editor) you can switch the ticker on or off separately for each league. It then appears in the user area above the respective league. You can also include it anywhere on your homepage and even configure it so that several leagues are combined in one ticker.

---

## 1. Control parameters

These parameters control the behaviour of the ticker. In the [add-on management](#options/2-add-on-management) you can change the default values; they apply to the tickers above the leagues and to every ticker that is not given its own control parameters.

| Parameter | Value | Meaning |
|---|---|---|
| `standard_ligen` | file name(s) | File names with the `.l98` extension; separate several leagues with commas |
| `tickerart` | `1` | Results ticker |
| | `2` | LMO ticker text |
| | `3` | Results ticker, favourite team only |
| `tickertitel` | `0` | Hide ticker heading |
| | `1` | Show ticker heading |
| `notizanzeigen` | `0` | Hide game notes |
| | `1` | Show game notes |
| `breite` | number | Width of the ticker (in number of letters) |
| `geschwindigkeit` | number | Scrolling speed of the ticker |

---

## 2. Integration

There are two ways to include the news ticker. The first is preferable; the second is only meant for servers without PHP support (when the LMO runs on an external server) or when you use an `.html` file (which is usually not processed by PHP).

### Including via include

The parameters are set directly as PHP variables. Write them one after another *inside a PHP block* (open it with `<?php` if necessary):

```php
$tickerart="1";
$tickerligen="liga1.l98,liga2.l98";
```

Note the `$` before the parameter name, the quotation marks around strings and the closing semicolon. You only have to specify the parameters that differ from the default settings. Then include the ticker:

```php
include("PathToLMO/addon/ticker/ticker.php");
```

`PathToLMO` is the absolute or relative path to the LMO directory.

> **Attention:** Never use a URL, so no `include("http://www.../ticker.php");`, because that does not work! Always specify a **file path**.

### Including via iframe

Use this method only if the include variant does not work for some reason. Iframes are not supported by all browsers and also have usability drawbacks. Here the parameters are part of the source URL:

```html
<iframe src="URLToLMO/addon/ticker/ticker.php?tickerart=1&tickerligen=liga1.l98,liga2.l98"
  style="border:0" width="width" height="height" scrolling="no"></iframe>
```

`URLToLMO` is the web address of your LMO. For `width` and `height` you unfortunately have to experiment a little. The first parameter is separated with `?`, all further ones with `&`.

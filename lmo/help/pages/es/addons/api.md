# API JSON y vista de liga

1. [Resumen](#1-resumen)
2. [API JSON](#2-api-json)
3. [Vista de liga](#3-vista-de-liga)

La extensión API hace utilizables los datos de tus ligas para otras páginas y programas: como **interfaz JSON** (solo lectura) y como **vista de liga** ya preparada, **generada en el servidor**, con diseños intercambiables. Ambas usan la misma lógica de cálculo que la interfaz normal del LMO; no hay un segundo cálculo mantenido por separado.

> **Nota:** La extensión API no forma parte del paquete del LMO, sino que es una **descarga aparte**. Descomprímela en tu directorio del LMO (crea `addon/api/` y `template/api/`).

---

## 1. Resumen

| Archivo | Finalidad |
|---|---|
| `addon/api/lmo-api.php` | Interfaz JSON (solo lectura) |
| `addon/api/init-api.php` | Inicialización ligera de la interfaz (sin sesión) |
| `template/api/lmo-liga.php` | Vista de liga completa en un solo archivo, con diseños (temas) |
| `template/api/themes/` | Diseños `karten` y `stadium` |

---

## 2. API JSON

Llamada: `addon/api/lmo-api.php?file=XXX.l98&resource=...`

La interfaz es de **solo lectura**, no requiere inicio de sesión, no establece cookies y permite consultas desde otros dominios (CORS). Las respuestas se almacenan en caché durante 60 segundos.

| Parámetro | Significado |
|---|---|
| `file` | Nombre de archivo de la liga con la extensión `.l98` (obligatorio, sin subcarpetas) |
| `resource` | Recurso deseado (véase abajo), por defecto `info` |
| `st` | Jornada, solo para `results` |
| `team` | Número de equipo como filtro, solo para `program` |
| `team1`, `team2` | Números de equipo, solo para `h2h` |
| `lang` | Idioma, p. ej. `Englisch` (nombre del archivo de idioma del LMO); si no, el idioma predeterminado |

| Recurso | Contenido |
|---|---|
| `info` | Metadatos de la liga |
| `table` | Clasificación (incl. campos adicionales específicos del deporte) |
| `results` | Resultados de una jornada |
| `program` | Calendario, opcionalmente de un equipo |
| `cross` | Tabla cruzada (todos los enfrentamientos como matriz) |
| `graph` | Evolución de la posición por jornada (curva de forma) |
| `h2h` | Enfrentamientos directos de dos equipos |

Ejemplo:

```
addon/api/lmo-api.php?file=1l_2024-25.l98&resource=table
```

---

## 3. Vista de liga

Llamada: `template/api/lmo-liga.php?file=XXX.l98&view=...&theme=...`

**Ejemplo en vivo:** [https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php](https://www.liga-manager-online.org/test/lmo_git/template/api/lmo-liga.php)

Este archivo sustituye a las páginas HTML individuales y genera la vista directamente en el servidor. La liga puede estar en una subcarpeta (p. ej. `file=dfb/04er-liga.l98`). Sin `file` muestra una selección clicable de todas las ligas y subcarpetas.

| Parámetro | Significado |
|---|---|
| `file` | Liga, opcionalmente con subcarpeta |
| `dir` | Subcarpeta cuyas ligas se quieren listar |
| `view` | `uebersicht` (por defecto), `tabelle`, `ergebnisse`, `spielplan`, `kreuztabelle`, `fieberkurve`, `direkte-duelle` |
| `theme` | Diseño: `karten` o `stadium` |
| `st`, `team`, `team1`, `team2` | como en la API JSON |
| `lang` | Idioma |

**Diseño propio:** Crea en `template/api/themes/` una carpeta nueva con un `theme.php` (estructura como `stadium/theme.php`, cuyo encabezado indica las variables disponibles). Opcionalmente un `meta.php` indica el nombre visible para el selector de diseños.

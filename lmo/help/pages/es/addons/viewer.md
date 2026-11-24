# Viewer

1. [Plantillas](#1-plantillas)

![Vista de usuario](./assets/media/viewer01.png)

El Viewer es un addon para LMO 4. Muestra los partidos de cualquier número de equipos para los XX días anteriores/siguientes a la fecha actual, entre ligas. Aunque se configura sobre todo en el área de administración, el Viewer es un script independiente que puedes integrar en cualquier lugar de tu sitio web. Mediante [plantillas](#1-plantillas) puedes diseñar libremente la salida.

---

## 1. Plantillas

Igual que con el LMO, puedes adaptar libremente la estructura y el diseño del Viewer. Las plantillas están en el directorio `template/viewer`, donde también encontrarás ejemplos.

### Variables globales

| Marcador | Significado |
|---|---|
| `<!--Titelzeile-->` | Línea de título configurada |
| `<!--VERSION-->` | Aviso de copyright con información de versión, **¡no debe modificarse ni eliminarse!** |

### Bloque de liga

| Marcador | Significado |
|---|---|
| `<!-- BEGIN Liga -->` / `<!-- END Liga -->` | Bloque de contenido de una liga. **¡Respeta los espacios antes de BEGIN y después de Liga!** |

Los siguientes marcadores solo tienen sentido dentro de `<!-- BEGIN/END Liga -->`:

| Marcador | Significado |
|---|---|
| `<!--Ligadatum-->` | Fecha de guardado de la liga |
| `<!--Liganame-->` | Nombre de la liga |
| `<!--ErgebnisLink-->` | Enlace a la vista general de resultados de la liga |
| `<!--Anfangsspieltag-->` / `<!--Endespieltag-->` | Primera y última jornada mostradas (solo con visualización por jornadas) |
| `<!--Spieltageminus-->` / `<!--Spieltageplus-->` | Número de jornadas mostradas hacia atrás/adelante (solo con visualización por jornadas) |
| `<!--Anfangsdatum-->` / `<!--Enddatum-->` | Número de días mostrados hacia atrás/adelante (solo con visualización por fechas) |

### Bloque de jornada

| Marcador | Significado |
|---|---|
| `<!-- BEGIN Spieltag -->` / `<!-- END Spieltag -->` | Bloque de contenido de una jornada (solo con visualización por jornadas). **¡Respeta los espacios antes de BEGIN y después de Spieltag!** |

Los siguientes marcadores solo tienen sentido dentro de `<!-- BEGIN/END Spieltag -->`:

| Marcador | Significado |
|---|---|
| `<!--AktSpieltag-->` | Esta jornada |
| `<!--AktSpieltagLink-->` | Enlace a la vista general de resultados de esta jornada |

### Bloque de contenido (partido)

| Marcador | Significado |
|---|---|
| `<!-- BEGIN Inhalt -->` / `<!-- END Inhalt -->` | Bloque de contenido de un partido. **¡Respeta los espacios antes de BEGIN y después de Inhalt!** |

Los siguientes marcadores solo tienen sentido dentro de `<!-- BEGIN/END Inhalt -->`:

| Marcador | Significado |
|---|---|
| `<!--Heim-->` / `<!--Gast-->` | Nombres de equipo con la longitud configurada |
| `<!--HeimLang-->` / `<!--GastLang-->` | Nombre largo del equipo |
| `<!--HeimMittel-->` / `<!--GastMittel-->` | Nombre de longitud media del equipo |
| `<!--HeimKurz-->` / `<!--GastKurz-->` | Nombre corto del equipo |
| `<!--ToreHeim-->` / `<!--ToreGast-->` | Goles de los equipos (por separado) |
| `<!--Tore-->` | Resultado del partido como `x:y` |
| `<!--Datum-->` | Fecha del partido |
| `<!--Uhrzeit-->` | Hora de inicio |
| `<!--Spieltag-->` | Jornada del partido |
| `<!--Iconheim-->` / `<!--Icongast-->` | Iconos de los equipos (pequeños) |
| `<!--IconMiddleheim-->` / `<!--IconMiddlegast-->` | Iconos de los equipos (medianos) |
| `<!--IconBigheim-->` / `<!--IconBiggast-->` | Iconos de los equipos (grandes) |
| `<!--IconBigheimalt-->` / `<!--IconBiggastalt-->` | Iconos de los equipos (grandes, alternativos) |
| `<!--Notiz-->` | Nota del partido |
| `<!--Tabellenlink-->` | Enlace a la clasificación |
| `<!--Spieltaglink-->` | Enlace a la vista de resultados de la jornada |
| `<!--Spielbericht-->` | Enlace a la crónica del partido |
| `<!--Zeilenklasse-->` | Resaltado de la fecha de hoy (`vRow` normal, `vRowHighlight` hoy) |
| `<!--Ligadatum-->` | Fecha de guardado de la liga |
| `<!--Liganame-->` | Nombre de la liga |

# Estadísticas de jugadores

1. [Configuración](#1-configuracion)

![Vista de usuario](./assets/media/spielerstatistik01.png)

Con este addon puedes registrar y publicar estadísticas de jugadores para Liga Manager Online. La configuración flexible permite usarlo en muchos deportes distintos.

Puedes crear tres tipos de columnas: **texto**, **números** y **fórmulas**. Por desgracia el orden de las columnas no se puede cambiar después, así que piénsalo bien antes de empezar. Tras crear los jugadores aparece debajo la alineación, donde introduces los valores correspondientes de cada jugador. En las columnas de fórmula puedes calcular con las columnas numéricas (p. ej. promedio de goles).

**Integrar fotos de jugadores**
Las fotos van en el directorio `img/spieler/small/`, con el nombre del jugador correspondiente. Cuida un tamaño de archivo razonable.

**Integrar enlaces de jugadores**
Para enlazar jugadores, crea en el área de administración una columna **«Enlace del jugador»** (o su equivalente en `lang/lmo-[idioma].txt`). Se puede guardar un enlace por jugador; si falta, no se enlaza nada.

**Integrar gráficos de columna**
En lugar de encabezados de texto también puedes usar iconos para las columnas. Para ello guarda una imagen **GIF** con el nombre de la columna en el directorio `img/spieler/`. Ya se incluyen ejemplos.

**Estadísticas de varios clubes con escudos**
Si usas **«Club»** (o su equivalente en `lmo-[idioma].txt`) como encabezado de columna, se activa la compatibilidad con clubes: selección desplegable, escudos de club (si existen) y enlaces a las páginas web de los clubes.

---

## 1. Configuración

### Vista del visitante

| Ajuste | Significado |
|---|---|
| Visualización por página | Número de entradas mostradas; `0` = sin límite |
| Preordenación | Columna por la que ordenar primero |
| Ordenación | Orden de la preordenación |
| Columna de ordenación adicional | Muestra una columna de ordenación aparte; si no, se ordena mediante los encabezados de la tabla |
| Visualización por club | Activa la división por clubes |
| Mostrar valores cero | Muestra también los campos vacíos; las cadenas se muestran siempre |

### Vista de administración

| Ajuste | Significado |
|---|---|
| Preordenación admin | Columna por la que ordenar primero |
| Administrador auxiliar | Da a los administradores auxiliares acceso a las estadísticas de jugadores |
| Administrador auxiliar (columnas) | Da además a los administradores auxiliares acceso a la gestión de columnas |

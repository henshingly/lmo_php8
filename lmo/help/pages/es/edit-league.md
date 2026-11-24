# Editar liga

1. [Crear una liga](#1-crear-una-liga)
2. [Abrir una liga](#2-abrir-una-liga)
3. [El editor de resultados](#3-el-editor-de-resultados)
4. [Ajustes básicos](#4-ajustes-basicos)
5. [Ordenación manual de la tabla](#5-ordenacion-manual-de-la-tabla)
6. [El editor de equipos](#6-el-editor-de-equipos)

---

## 1. Crear una liga

Pulsa **Nueva** en el menú para crear una liga nueva. El proceso tiene 4 pasos:

**Paso 1:** Define el **nombre de archivo** de la liga, sin ruta ni extensión, que ya están predefinidas. La entrada puede tener como máximo 28 caracteres. Dale a la liga un **nombre** claro, que aparece en las listas y como encabezado en el área de visitantes. Además del título conviene mencionar la temporada, p. ej. `1.ª Regional Villaperdida 2001/02`. Elige también si creas una **liga** (con puntos, tabla, etc.) o un **torneo eliminatorio** (play-off o similar). Pulsa **Siguiente**.

**Paso 2:** Define el **número de equipos**. En una liga indicas además el **número de jornadas** y los **partidos por jornada**. En los torneos eliminatorios esto no hace falta, ya que esos valores se deducen del número de equipos. Pulsa **Siguiente**.

**Paso 3:** En las ligas sigue ahora la **creación del calendario**. Puedes tomar un calendario de otra liga (solo posible en ligas con el mismo número de equipos, partidos y jornadas), generar un **calendario aleatorio** (el sistema conocido de LM98Free; solo posible en una liga „normal" en la que cada equipo juega un partido de ida y uno de vuelta contra cada rival, como en la Bundesliga) o prescindir de él. En los torneos eliminatorios defines aquí el **modo de juego** de cada ronda. Pulsa **Siguiente**.

**Paso 4:** ¡La **liga está guardada!** A continuación edita los [equipos](#6-el-editor-de-equipos), que de momento solo están numerados. Si has tomado el calendario de otra liga, echa antes un vistazo al área de visitantes para averiguar qué equipo corresponde a cada número.

---

## 2. Abrir una liga

Tras [iniciar sesión](#getting-started/6-inicio-cierre-de-sesion) ves directamente un resumen de todas las ligas disponibles. Alternativamente pulsa **Abrir** en el menú. Elige la liga que quieres editar. Los [administradores auxiliares](#options/administradores-auxiliares) solo ven las ligas habilitadas para ellos.

---

## 3. El editor de resultados

Tras [abrir una liga](#2-abrir-una-liga) llegas automáticamente al editor de resultados con la jornada actual. Con el menú de selección situado bajo el menú puedes abrir también otras jornadas.

**Fecha:** Arriba del todo puedes fijar la **fecha de inicio y de fin** de la jornada. El formato es `DD.MM.AAAA`. Asegúrate de introducir la fecha con dos cifras para el día y el mes y cuatro para el año, separadas por puntos. Junto a los campos de fecha, un botón abre un calendario emergente en el que eliges la fecha con un clic. Estas fechas solo se muestran a los visitantes si el [ajuste](#4-ajustes-basicos) **Fecha de la jornada** está activo.

**Horas de inicio:** A cada partido se le puede asignar una **hora de inicio**, también en el formato `DD.MM.AAAA`, y aquí también hay un botón para el calendario emergente. Si introduces una fecha pero no una hora, se toma la [hora de inicio predeterminada](#options/1-opciones-globales). Indica las horas en el formato `HH:MM` (hora y minuto con dos cifras, separados por `:`).

**Equipos:** Los equipos se eligen en las listas desplegables.

**Introducir resultados:** Lo más sencillo es usar los botones de flecha junto a los campos de resultado. También puedes escribir números directamente o usar las teclas de flecha mientras el cursor está en el campo. Con los decimales activados sigues introduciendo los resultados como números enteros; la conversión solo se ve en la salida.

**Final del partido:** En ligas con [final de partido abierto](#4-ajustes-basicos) o en torneos eliminatorios indicas cómo terminó el partido: normal (\_), tras prórroga/tiempo extra (t.p.) o en la tanda de penaltis (p.).

> **Nota:** En decisiones del tribunal deportivo que afectan tanto a puntos como a goles (p. ej. retirar una victoria) no necesitas el campo siguiente.

**Decisión de mesa verde:** Este campo normalmente no se necesita. Pero siempre hay decisiones del tribunal deportivo que dan la vuelta a los resultados. Independientemente del resultado introducido, aquí puedes ajustar una decisión sobre el vencedor. Los goles cuentan para la tabla tal como se han introducido, pero los puntos se rigen por este ajuste. Normalmente el tribunal dice, por ejemplo: 0:0 goles y gana el equipo X. La opción **resultado para ambos** vale cuando el tribunal decide el partido igual para ambos equipos (p. ej. 2:0 para los dos).

**Nota:** Aquí puedes introducir una nota sobre el partido, p. ej. el lugar. También puedes mencionar aquí una decisión normal del tribunal deportivo. Los casos especiales de decisiones de mesa verde no hace falta mencionarlos otra vez; se insertan automáticamente como nota.

**URL del acta:** Opcionalmente puedes añadir un enlace al acta del partido. Solo se muestra si **Enlazar actas** está activo en los [ajustes](#4-ajustes-basicos).

**Juego de pronósticos:** Si usas el [juego de pronósticos](#addon-betting-game), puedes excluir partidos concretos de la puntuación.

**Ajustes independientes de la jornada:** Bajo los partidos encuentras otros ajustes que puedes modificar directamente aquí.

**Jornada actual:** Aquí solo tienes que cambiar algo si la jornada que editas *no* debe marcarse como jornada actual, p. ej. al editar un partido aplazado o corregir un resultado antiguo. Elige entonces la jornada que debe considerarse actual. En otro caso deja el campo sin cambiar.

**Ticker de noticias:** Activa el ticker e introduce mensajes, uno por línea y sin líneas vacías.

Pulsa **Guardar jornada y ticker** para aplicarlo todo. Tus cambios son visibles de inmediato para los visitantes, ¡así que revisa una vez más!

> Si la [ordenación manual de la tabla](#5-ordenacion-manual-de-la-tabla) está activa: una ordenación manual previa de esta jornada o de las siguientes se descarta tras guardar.

---

## 4. Ajustes básicos

Aquí defines todos los ajustes de la liga. En los torneos eliminatorios solo se muestran las opciones relevantes.

**Valores básicos**
El **nombre de la liga** aparece en las listas y como encabezado en el área de visitantes, incluida la temporada, p. ej. `1.ª Regional Villaperdida 2001/02`. Además defines las **denominaciones de puntos y goles** (adaptables al deporte) y puedes activar **puntos/goles decimales**. Elige también el **equipo favorito** y los **equipos predeterminados para calendario, curva de forma y estadística**.

**Enlaces**
Decide si se enlazan las [páginas web de los equipos](#6-el-editor-de-equipos) (en la tabla) y las [actas](#3-el-editor-de-resultados) (en resultados y calendarios).

**Visualización/Aspecto**
Aquí decides qué quieres ofrecer a tus visitantes. Con **Vista inicial** determinas lo que ven primero los visitantes al cargar la liga. Puedes activar **fecha de la jornada** y **horas de inicio**; sin ninguna de las dos tampoco hay calendario. El **calendario** también se puede desactivar por separado. Con las horas de inicio activas, elige el **formato de visualización** deseado.

**Partido por el 3.er puesto** y **Permitir play-down** solo están disponibles en torneos eliminatorios. Aquí decides si hay una pequeña final y si (como es habitual en los play-down) también el perdedor puede pasar a la ronda siguiente.

La **tabla cruzada** y la **curva de forma** se pueden desactivar. La curva de forma se dibuja en el navegador y no necesita ninguna biblioteca del servidor. La tabla cruzada tiene poco sentido si no hay partidos de vuelta (p. ej. fase de grupos de un Mundial).

**Sistema de juego**
El sistema de juego contiene todos los ajustes relativos al modo de la liga.

- Los **puntos negativos** existen en ligas de 2 puntos; en ligas de 3 puntos ya no.
- **Final de partido abierto** solo hay que activarlo si tras un empate sigue una prórroga/tiempo extra y, en su caso, una tanda de penaltis.
- La columna de tabla **Empates** solo hace falta ocultarla si en tu liga no hay empates en absoluto.
- **Enfrentamiento directo** significa que, en caso de igualdad de puntos, se tiene en cuenta el enfrentamiento directo entre los equipos empatados.
- **Goles marcados antes que diferencia de goles** solo lo activas si en tu liga los goles marcados pesan más que la diferencia de goles, lo cual es bastante raro.
- La **ordenación manual de la tabla** solo debes permitirla en casos excepcionales, p. ej. con reglas especiales que este software no tiene en cuenta. Entonces puedes [corregir la tabla manualmente](#5-ordenacion-manual-de-la-tabla).

**Tabla**
Decide qué entradas de tu tabla (y de la curva de forma) se resaltan o se muestran:

- Tablas de la primera/segunda vuelta
- Tablas de local/visitante
- Campeón, ascenso, descenso
- Otras marcas (p. ej. puestos de Copa de la UEFA)

Un valor de `0` desactiva la marca correspondiente.

**Sistema de puntos**
Aquí defines la concesión de puntos. Con puntos negativos activados, los puntos de victoria son a la vez puntos negativos de derrota y viceversa; en caso de empate los puntos se cuentan para ambos lados.

**Número de jornadas y partidos**
Normalmente no necesitas esta función. Si tienes que cambiar después el número de jornadas o de partidos, puedes hacerlo aquí. ¡Pero antes haz una [copia de seguridad](#file-functions/3-descargar-enviar-por-correo-una-liga)! No disponible en torneos eliminatorios.

---

## 5. Ordenación manual de la tabla

Si has activado el [ajuste](#4-ajustes-basicos) **Permitir ordenación manual de la tabla**, en la parte inferior del [editor de resultados](#3-el-editor-de-resultados) aparece la opción **Tabla**. Púlsala para comprobar la tabla y corregirla manualmente si hace falta.

Elige bajo el menú la jornada cuya tabla quieres editar. La tabla se muestra tal como la ha calculado el software. Si todo es correcto, no tienes que hacer nada.

En caso contrario asigna nuevas posiciones a los equipos. Cada posición solo puede aparecer una vez (una función de JavaScript normalmente evita los duplicados automáticamente).

Después pulsa **Guardar tabla manual**. En el área de visitantes se muestra la tabla (y la curva de forma) según tus correcciones.

---

## 6. El editor de equipos

Aquí puedes introducir y cambiar los **nombres de los equipos**. La **abreviatura** puede tener como máximo 5 caracteres.

Si la federación impone puntos y goles de sanción o de bonificación, puedes introducirlos aquí; se tienen en cuenta en el cálculo de la tabla. También puedes fijar a partir de qué jornada surte efecto el cambio.

Si quieres enlazar páginas web de equipos, introduce las URL en la columna correspondiente. Los enlaces aparecen en la tabla si **Enlazar páginas web de equipos** está activo en los [ajustes](#4-ajustes-basicos).

> **Atención:** Para cada equipo hay funciones para **retirarlo** de la liga y para **añadir** un equipo nuevo **posteriormente**. *¡Haz antes una [copia de seguridad](#file-functions/3-descargar-enviar-por-correo-una-liga)!* Si usas el juego de pronósticos en esta liga, estas funciones pueden provocar fallos. Estas opciones no están disponibles en torneos eliminatorios.

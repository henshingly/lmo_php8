# Calendario ICS

1. [Resumen](#1-resumen)
2. [Abrir la página ICS](#2-abrir-la-pagina-ics)
3. [¿Descarga o suscripción?](#3-descarga-o-suscripcion)
4. [Suscribirse en aplicaciones de calendario](#4-suscribirse-en-aplicaciones-de-calendario)
5. [Preguntas frecuentes](#5-preguntas-frecuentes)

Con el addon ICS los visitantes pueden añadir los partidos de un equipo a su propio calendario (Google Calendar, Calendario de Apple, Outlook, Thunderbird y muchos más). Si el calendario se **suscribe**, los nuevos horarios y aplazamientos se actualizan automáticamente.

> **Nota:** El addon ICS no forma parte del paquete LMO, sino que es una **descarga aparte**: [Última versión en GitHub](https://github.com/henshingly/ics-calendar/releases/latest). Descomprímelo en tu directorio LMO (crea `addon/ics/`, `lang/ics/` y `config/ics/`).

---

## 1. Resumen

| Archivo | Función |
|---|---|
| `addon/ics/lmo-ics.php` | la página ICS: elegir liga, elegir equipo, crear archivo |
| `lang/ics/lang-<idioma>.txt` | textos en 14 idiomas |
| `config/ics/cfg.txt` | ajustes (duración del partido, recordatorio, URL en el evento, abreviar nombres de clubes) |

En la página se ajustan el equipo, la URL del evento, la duración del partido (minutos) y un recordatorio antes del inicio. Después aparecen el **enlace de descarga** y el **enlace de suscripción**.

---

## 2. Abrir la página ICS

* **Desde la tabla:** si en los ajustes básicos de la liga, en *Visualización → Enlaces*, está activada la opción **Enlazar calendario ICS**, aparece un pequeño icono de calendario detrás de cada equipo. Un clic abre la página ICS de ese equipo.
* **Directamente:** abrir `addon/ics/lmo-ics.php` y elegir liga y equipo.

---

## 3. ¿Descarga o suscripción?

| | Descarga (archivo `.ics`) | Suscripción (`webcal://`) |
|---|---|---|
| Efecto | importación única de los partidos actuales | el calendario queda conectado con el LMO |
| Cambios en el LMO | **no** llegan | se aplican automáticamente |
| Indicado para | importación única, dispositivos sin suscripciones | normalmente la mejor opción |

El enlace de suscripción empieza por `webcal://`, que es otra forma de escribir `https://`. En programas que no conocen `webcal://`, sustitúyelo por `https://` (o `http://` si el sitio no usa HTTPS).

---

## 4. Suscribirse en aplicaciones de calendario

Copia primero el enlace de suscripción de la página ICS. En el móvil suele bastar con tocar el enlace; la aplicación de calendario pregunta entonces si quieres suscribirte.

### Google Calendar (ordenador)

1. Abre [calendar.google.com](https://calendar.google.com).
2. Junto a **Otros calendarios** haz clic en **+** y elige **Desde URL**.
3. Pega el enlace cambiando `webcal://` por `https://`.
4. Haz clic en **Añadir calendario**.

El calendario aparece después también en la aplicación Google Calendar de Android con la misma cuenta. Google actualiza los calendarios suscritos con poca frecuencia; los cambios pueden tardar hasta un día.

### Calendario de Apple (iPhone e iPad)

1. **Ajustes → Calendario → Cuentas → Añadir cuenta → Otra → Añadir calendario suscrito**.
2. Pega el enlace, toca **Siguiente** y **Guardar**.

También puedes tocar el enlace `webcal://` y elegir **Suscribirse**.

### Calendario de Apple (Mac)

1. En Calendario: **Archivo → Nueva suscripción a calendario**.
2. Pega el enlace y haz clic en **Suscribirse**.
3. Ajusta el nombre y el intervalo de actualización (por ejemplo, cada hora o cada día).

### Microsoft Outlook (Windows, clásico)

1. **Archivo → Configuración de la cuenta → Configuración de la cuenta**.
2. Pestaña **Calendarios de Internet → Nuevo**.
3. Pega el enlace, haz clic en **Agregar** y asigna un nombre.

### Outlook en la web y nuevo Outlook

1. **Calendario → Agregar calendario → Suscribirse desde la web**.
2. Pega el enlace (si hace falta, con `https://` en lugar de `webcal://`), asigna un nombre e **Importar**.

La actualización puede tardar unas horas.

### Mozilla Thunderbird

1. Cambia a la vista de calendario y elige **Nuevo calendario** (símbolo más junto a «Calendario»).
2. Elige **En la red** y **Siguiente**.
3. Selecciona el formato **iCalendar (ICS)**, pega el enlace en **Ubicación**, **Siguiente** y asigna un nombre.
4. Con clic derecho en el calendario → **Propiedades** se ajusta el intervalo de actualización (por ejemplo, cada 30 minutos).

### Android sin cuenta de Google (y Calendario de Samsung)

Muchos calendarios de Android no permiten añadir suscripciones. La aplicación gratuita **ICSx⁵** (F-Droid o Play Store) se suscribe a enlaces ICS y los pone a disposición del calendario del dispositivo: abre la aplicación, toca **+**, pega el enlace y guarda.

### Otros programas

Nextcloud, GMX, web.de, IONOS y muchos otros servicios ofrecen una función como *suscribirse a un calendario*, *añadir calendario por URL* o *calendario de Internet*. Introduce allí el enlace, en caso de duda con `https://` al principio.

---

## 5. Preguntas frecuentes

**El calendario muestra los nuevos horarios con retraso.**
Lo decide la aplicación de calendario, no el LMO. Google y Outlook en la web actualizan poco; Apple y Thunderbird permiten configurar una actualización más frecuente.

**No veo partidos.**
El calendario solo contiene partidos con fecha. Debajo de la lista la página indica cuántos partidos sin fecha faltan.

**Las horas están desplazadas.**
Las horas se calculan con la zona horaria configurada en el LMO y se pasan al calendario en UTC. Comprueba la zona horaria en las opciones del LMO y en tu calendario.

**La suscripción no funciona.**
El enlace debe ser accesible desde fuera (sin protección con contraseña, no solo en una intranet). Pruébalo en el navegador con `https://` en lugar de `webcal://`: debería descargarse un archivo `.ics`.

**Quiero cambiar la duración del partido o el recordatorio.**
Cambia los valores en la página ICS y elige **Crear archivo ICS**. El enlace de suscripción contiene estos ajustes. Una suscripción existente debe volver a suscribirse con el nuevo enlace.

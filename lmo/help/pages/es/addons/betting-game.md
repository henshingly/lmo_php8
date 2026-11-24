# Juego de pronósticos (Tippspiel)

1. [Evaluación](#1-evaluacion)
2. [Boletín/Recordatorio](#2-boletin-recordatorio)
3. [Gestión de usuarios](#3-gestion-de-usuarios)
4. [Introducir pronósticos posteriormente](#4-introducir-pronosticos-posteriormente)
5. [Gestor de copias de seguridad](#5-gestor-de-copias-de-seguridad)
6. [Opciones](#6-opciones)

![Vista de pronósticos](./assets/media/tippspiel01.png)

El LMO 4 incluye un juego de pronósticos completo y flexible, basado en el addon de pronósticos para LMO 3 de Frank Albrecht.

---

## 1. Evaluación

Aquí evalúas las ligas en las que se pueden hacer pronósticos, es decir, a cada participante se le abonan los puntos conseguidos. Puedes evaluar cada liga y cada jornada por separado o todas las jornadas de una liga a la vez.

Si se pronostican varias ligas, aquí también puedes actualizar la **clasificación general**.

Aquí además creas y actualizas las **vistas de pronósticos**, con las que tus compañeros de juego pueden ver cómo han pronosticado los demás. Según el [ajuste de las opciones](#6-opciones), la vista solo se habilita cuando ha terminado la jornada.

---

## 2. Boletín/Recordatorio

Aquí puedes enviar a tus participantes distintos mensajes: un **boletín a todos**, **correos personales** a jugadores concretos o un **recordatorio** que les recuerda enviar sus pronósticos.

Todos los correos del juego de pronósticos (también la confirmación de registro, la activación y el correo de contraseña) se envían con el método de envío que hayas ajustado en las [opciones globales](#options/envio-de-correo-smtp) (PHP `mail()` o SMTP). Si los correos no llegan, configura allí un servidor SMTP y compruébalo con el correo de prueba.

Al enviar correo están disponibles los siguientes marcadores:

| Marcador | Significado |
|---|---|
| `[nick]` | Apodo del participante |
| `[pass]` | Enlace para restablecer la contraseña. Las contraseñas solo se guardan como hash y no pueden enviarse en texto plano. A través del enlace el participante establece una contraseña nueva. |
| `[name]` | Nombre real del participante |
| `[spiele]` | Solo en el recordatorio: lista todos los partidos pendientes en el periodo indicado |

---

## 3. Gestión de usuarios

Aquí gestionas a los participantes del juego de pronósticos: puedes **crear nuevos participantes**, **editar participantes** y **eliminar participantes**. De cada participante se pueden modificar los siguientes datos:

**Datos personales**
Contraseña, nombre, dirección, correo; bloqueado/activado.

**Suscripciones de correo**
¿Debe el participante recibir el boletín o el recordatorio?

**Equipo**
¿En qué equipo juega el participante? (solo con la opción de equipos activada)

**Ligas suscritas**
¿Qué ligas puede pronosticar el participante?

---

## 4. Introducir pronósticos posteriormente

Solo el **administrador completo** puede introducir o modificar pronósticos de un participante después del inicio o del final de un partido, por ejemplo si alguien no pudo enviar sus pronósticos a tiempo.

1. En la administración del juego de pronósticos elige **Introducir pronósticos posteriormente**.
2. Elige la liga. Se muestran todos los participantes que tienen un archivo de pronósticos para esta liga.
3. Pulsa **Editar pronósticos** en el participante deseado. Se abre la introducción normal de pronósticos de ese participante; un aviso rojo indica el modo de administrador.
4. Elige la jornada, introduce los pronósticos y guarda.
5. Después realiza de nuevo la [evaluación](#1-evaluacion).

Esto funciona para todos los tipos de liga (liga, torneo/KO) y todos los modos de pronóstico (resultado, tendencia, también con comodín). El bloqueo por tiempo solo se levanta para el administrador en este modo; los participantes solo pueden seguir pronosticando dentro del plazo.

**Registro:** Cada introducción posterior queda registrada en `config/tipp/nachtrag.php` (fecha, administrador, participante, liga, jornada). Las entradas también las ves directamente en el menú de administración del juego de pronósticos, en *Introducir pronósticos posteriormente*.

---

## 5. Gestor de copias de seguridad

Solo el **administrador completo** puede crear y restaurar copias de seguridad del juego de pronósticos. Una copia contiene la **carpeta de pronósticos** (pronósticos, evaluaciones, vistas, clasificación de clubes), el **archivo con los datos de los participantes** (`addon/tipp/lmo-tipperauth.php`) y las **reglas de puntuación** (`config/tipp/cfg.txt`) como archivo ZIP. Qué carpeta es la de pronósticos se define en las opciones, en *Rutas* (por defecto `addon/tipp/tipps/`). El gestor siempre usa ese ajuste.

**Crear una copia**

1. En la administración del juego de pronósticos elige **Gestor de copias de seguridad**.
2. Haz clic en **Crear copia de seguridad**. La copia aparece enseguida en la lista con fecha, tipo, número de archivos y tamaño.
3. Con **Descargar** guardas el ZIP en tu ordenador; con **Eliminar** lo quitas del servidor.

Las copias se guardan en la carpeta protegida `config/tipp/backup/` y solo se pueden descargar a través del gestor. El ZIP contiene `tippordner/`, `tipperdatei/`, `punkteregeln/`, un `info.txt` y un `manifest.json` con sumas de comprobación.

**Copia automática**

En *Ajustes* puedes indicar que se cree automáticamente una copia (tipo *Automática*) antes de cada evaluación en el área de administración y cuántas copias automáticas se conservan (0 = todas). Las copias automáticas más antiguas se eliminan; las manuales, nunca. La evaluación automática al introducir resultados no genera copia.

**Restaurar una copia**

1. En la lista, haz clic en **Restaurar** junto a la copia. Se comprueba por completo (estructura, nombres, sumas de comprobación).
2. Elige qué restaurar (carpeta de pronósticos, archivo de participantes, reglas) y cómo:
   - **Añadir y sobrescribir (recomendado):** los archivos que no están en la copia se conservan.
   - **Exactamente como en la copia:** los archivos de pronósticos, evaluaciones, vistas y clubes que no están en la copia se eliminan.
3. La vista previa muestra cuántos archivos son nuevos, se sobrescriben, no cambian o se eliminan.
4. Para confirmar, escribe la palabra **RESTAURAR** y haz clic en **Restaurar**.

Antes de sobrescribir, el gestor crea automáticamente una copia del estado actual (tipo *Antes de restaurar*). Si falla, o si la copia está dañada, no se cambia nada. Así también se puede deshacer una restauración. Los archivos se escriben y comprueban primero y después se intercambian.

**Subir una copia:** en un servidor nuevo puedes volver a subir un ZIP descargado. Se comprueba por completo antes de aceptarlo; otros archivos se rechazan.

Todas las acciones (crear, descargar, eliminar, subir, restaurar) aparecen en el **registro** al final de la página. En *Ajustes* defines tras cuántos días se eliminan automáticamente las entradas (0 = nunca). **Borrar registro** elimina todo el registro.

**Importante:** el archivo de participantes contiene datos de acceso y direcciones de correo. Trata las copias descargadas de forma confidencial. PHP necesita la extensión **Zip** y permiso de escritura en `config/tipp/` y en la carpeta de pronósticos. Si falta algo, el gestor lo indica. En Nginx el `.htaccess` de la carpeta de copias no actúa; bloquea `config/` en la configuración del servidor.

---

## 6. Opciones

Esta es el área más amplia e importante del juego de pronósticos. Lo mejor es configurar las opciones completamente una vez antes del inicio y no cambiarlas de forma significativa durante el juego.

**Modo de pronóstico**
Elige si se pronostica un resultado exacto o solo la tendencia (victoria/empate/derrota).

**Rutas**
Aquí figura la ruta donde el juego de pronósticos guarda sus datos. El valor predeterminado es `/tipps`; no lo cambies sin un buen motivo. Los datos de acceso de los participantes (apodos, hashes de contraseña, direcciones) están en `addon/tipp/lmo-tipperauth.php`. El archivo comienza con una línea de protección (`<?php exit; ?>`) que no debes eliminar y necesita permiso de escritura (666).

**Reparto de puntos**
Aquí configuras la concesión de puntos. Según el modo de pronóstico hay opciones distintas; en el modo tendencia hay lógicamente menos ajustes.

**Visualización**
Todo lo activado aquí aparece en la barra de navegación del juego de pronósticos.

**Reglas**
Fija el **plazo de pronóstico**, determina los **tamaños máximos de equipo** y con cuántos **días de antelación** se puede pronosticar. También puedes activar el **pronóstico comodín**: con él los participantes pueden elegir un partido por jornada en el que un pronóstico vale más puntos. El **factor de multiplicación** lo defines aquí.

**Registro**
Determina qué **datos** son obligatorios en el registro, si se realiza una **verificación por correo**, si recibes una **notificación** en los nuevos registros y si los nuevos participantes deben ser **activados** primero por ti.

**Envío de pronósticos**
Configura el aspecto del envío de pronósticos. En el modo resultado puedes mostrar **botones de flecha** (como en el editor de resultados). Para dar orientación a los participantes puedes mostrar las **tendencias pronosticadas** y los **pronósticos medios**.

> Hay dos variantes de envío: **por liga** (por liga y jornada) o **por fecha** (todos los partidos de varias ligas en un periodo). *Si desactivas ambas variantes, no es posible enviar pronósticos.*

También puedes decidir si las vistas de pronósticos se **actualizan automáticamente** al enviar pronósticos.

**Vista de pronósticos**
Elige cuándo se muestra la vista de pronósticos: inmediatamente tras la introducción, tras el plazo de pronóstico o solo tras introducir el resultado. Además determinas cuántos participantes se muestran por página.

**Tabla de pronósticos**
El juego de pronósticos calcula a partir de los pronósticos enviados una tabla para cada participante. Puedes publicar una tabla de todos los participantes o una según los puntos aportados.

**Tablas de puntuación**
Configura la visualización de la puntuación: solo la clasificación general o además clasificaciones individuales por liga. También decides qué datos personales (nombre real, apodo, dirección de correo) son visibles y con qué detalle se muestra el desglose de puntos.

**¿Qué cuenta en caso de empate a puntos?**
Aquí defines los llamados criterios de desempate: para participantes empatados a puntos se usan hasta tres criterios más, en orden de prioridad descendente.

**Evaluaciones adicionales**
> Decide qué se evalúa además automáticamente al introducir los resultados de la liga. Si lo activas, la actualización manual ya no es necesaria; con muchísimos participantes, sin embargo, pueden surgir problemas de tiempo de ejecución, porque este paso requiere mucho cálculo.

**Ligas con pronósticos**
Habilita aquí qué ligas pueden jugarse, todas o solo algunas seleccionadas. *Solo las ligas habilitadas pueden ser suscritas por los participantes.*

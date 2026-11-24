# Opciones

1. [Opciones globales](#1-opciones-globales)
2. [Gestión de addons](#2-gestion-de-addons)
3. [El editor de diseño](#3-el-editor-de-diseno)
4. [Gestión de usuarios](#4-gestion-de-usuarios)
5. [Archivo de ligas](#5-archivo-de-ligas)

---

## 1. Opciones globales

El comando de menú **Opciones** te lleva al área de opciones. Aquí defines los ajustes globales del script. Los administradores auxiliares no tienen acceso.

**Ajustes básicos:** idioma predeterminado, directorio de ligas, hora de inicio predeterminada, formato de las fechas de partido, correo del webmaster, envío de correo (PHP `mail()` o SMTP) y el orden de clasificación de las ligas en la selección de ligas.

**Opciones de tabla:** posición de la columna de puntos y tipo de presentación de la tabla.

**Visualización/Aspecto:** aquí decides qué componentes del LMO se muestran.

### Envío de correo (SMTP)

Todos los correos del LMO (enviar ligas por correo; en el juego de pronósticos registro, activación, correos de contraseña, boletines y recordatorios) usan los ajustes del apartado **Envío de correo**. Lo encuentras en los ajustes básicos, justo debajo del correo del webmaster. Solo el administrador completo ve y modifica estos ajustes.

| Ajuste | Significado |
|---|---|
| Método de envío | **PHP mail()** es el valor predeterminado y funciona si tu servidor puede enviar correo por sí mismo. Si los correos no llegan o acaban como spam, elige **Servidor SMTP**. Si falla el SMTP, el LMO intenta enviar el correo una vez más con `mail()` como alternativa. |
| Servidor, puerto, cifrado | Los datos te los da tu proveedor de correo. Lo habitual es STARTTLS con puerto 587 o SSL/TLS con puerto 465. Elige *ninguno (sin cifrar)* solo en casos excepcionales. |
| Usuario, contraseña | Datos de acceso del buzón, normalmente la dirección de correo. La contraseña no se vuelve a mostrar tras guardarla. Deja el campo vacío para conservarla o bórrala con la casilla. Lo mejor es usar un buzón propio solo para el envío. |
| Dirección de remitente | Opcional. Si está vacía se usa el correo del webmaster. Muchos proveedores solo permiten remitentes que coincidan con la cuenta SMTP. |
| Enviar correo de prueba | Envía con los valores introducidos en ese momento (también sin guardar) un correo de prueba al correo del webmaster, que debe estar guardado para ello. El correo de prueba solo se envía por SMTP, sin alternativa a `mail()`, para que los errores se vean. El resultado aparece junto al botón. |

**¿Dónde se guarda la contraseña?** Cifrada en `config/smtp/cfg.php`; la clave está en `config/smtp/key.php`. Ambos archivos están protegidos contra el acceso directo mediante una línea de protección. Ten en cuenta que la clave está en el mismo servidor: el cifrado protege de que el archivo de configuración quede legible por error (p. ej. en una copia de seguridad), pero no de alguien con acceso a todo el directorio del servidor. Abre el área de administración siempre que puedas por HTTPS. Con una conexión HTTP el LMO muestra un aviso.

---

## 2. Gestión de addons

La gestión de addons controla los addons que amplían el LMO con funciones adicionales. Está pensada para usuarios avanzados. Cambia aquí valores solo si el addon no tiene interfaz de configuración propia.

Elige el addon en el menú de selección y cambia directamente las variables de configuración. **No se comprueban las entradas**; valores erróneos pueden dejar el LMO inservible en el peor de los casos.

---

## 3. El editor de diseño

Con el editor de diseño adaptas colores y fuentes a tu página web. Lo encuentras en **Opciones → Editor de diseño**. Solo está disponible para el administrador completo. A la izquierda ajustas los valores; a la derecha ves al instante cómo queda una de tus ligas. No se aplica nada hasta que pulsas **Guardar cambios**.

### Estructura del editor

Los ajustes están organizados en pestañas. Todas las pestañas pertenecen a **un** formulario: tus entradas se conservan al cambiar de pestaña y un clic en *Guardar cambios* lo guarda todo.

| Pestaña | Contenido |
|---|---|
| Marco exterior | Fondo de página, fuente base, encabezado, menú principal y submenú del área exterior |
| Marco central | Área alrededor de cada vista con su propio encabezado, menú principal y submenú |
| Marco interior | Tablas: celdas normales, resaltados (p. ej. cabeceras de tabla) y enlaces |
| Tabla | Colores de las posiciones de la tabla (campeón, Liga de Campeones, Liga Europa, promoción, descenso) y tablas local/visitante |
| Área de torneo | Colores de ganadores y perdedores en cuadros de torneo (rondas eliminatorias) |
| Otras opciones | Tabla cruzada, calendario, fines de semana, curvas de forma, tamaños de fuente, subrayado de enlaces |
| Formularios | Campos de entrada y botones |

### La vista previa en vivo

A la derecha ves una liga real de tu instalación (debe existir al menos una liga). Cada cambio se muestra al instante, incluso sin guardar. Con los campos de selección de arriba eliges

- la **liga** con la que pruebas,
- la **vista** (tabla, resultados, calendarios, tabla cruzada, calendario) y
- el **ancho** (escritorio, tableta, smartphone). El diseño del LMO no se adapta automáticamente al ancho de pantalla, así que la vista estrecha puede desplazarse lateralmente.

**Hacer clic en vez de buscar:** si pasas el ratón sobre un área de la vista previa, se rodea de naranja y muestra su nombre (p. ej. „Marco central: menú principal"). Un clic abre la pestaña correspondiente y marca el campo. Los enlaces de la vista previa no se ejecutan.

### Ajustar colores y fuentes

Cada color se define de dos maneras: escribiendo un código hexadecimal (`#1b6b2f`, abreviado `#0a0`) o un nombre de color en inglés (`red`), o haciendo clic en el cuadro de color, que abre el selector de color del navegador.

En muchos campos van juntos dos colores: primero el de fondo y luego el de texto. Un campo vacío no define color y el navegador usa el suyo predeterminado. Además hay valores de borde (p. ej. `1px solid #000000`), la fuente (p. ej. `Verdana, sans-serif`) y el tamaño de fuente (p. ej. `13px` o `94%`).

> **Aviso de contraste:** Si el color de fondo y el de texto se parecen demasiado, el editor marca la fila y la pestaña con un símbolo de advertencia ⚠. Se recomienda un contraste de al menos 4,5 a 1. El aviso es solo una indicación; puedes guardar igualmente.

**Comprobación de entradas:** Al guardar se comprueban todos los valores. Los valores no válidos se ignoran y se conserva el anterior. Así los errores de escritura no pueden dañar la hoja de estilos.

### Esquemas de color

Encima del formulario eliges un **esquema de color** (Estándar, Verde césped, Rojo, Azul cielo, Naranja, Antracita, Púrpura, Turquesa, Burdeos). Un clic cambia de una vez marcos, menús, tabla cruzada y formularios al color principal elegido.

- **Oscuro:** usa la variante oscura del esquema.
- **Color propio:** abre una paleta de 108 colores. Allí eliges un color, usas el selector de color del navegador para cualquier color o escribes un código hexadecimal (confirma con Intro).
- **Estándar** restablece los colores originales del LMO.

Un esquema no modifica a propósito los colores de la tabla (campeón, ascenso/descenso) ni del área de torneo, porque tienen un significado fijo. Después puedes ajustar cada color a mano. Un esquema también solo vale tras *Guardar cambios*.

### Diseños guardados

Debajo del formulario gestionas tus propios diseños en el servidor, p. ej. uno de verano y otro de invierno.

- **Guardar como …** almacena los valores actuales con un nombre a tu elección (letras, cifras, espacios, `-` y `_`). Si el nombre ya existe, se te pregunta antes de sobrescribir.
- **Cargar** pasa el diseño elegido al formulario y a la vista previa. Los visitantes solo lo ven tras *Guardar cambios*.
- **Eliminar** borra el diseño elegido.

Los diseños se guardan como archivos de texto en `config/design/`. Para ello la carpeta `config` debe poder escribirse; la subcarpeta se crea automáticamente si hace falta.

### Exportar e importar

**Exportar** descarga el diseño actual (también con cambios sin guardar) como archivo `lmo-design-AAAAMMDD.json`; **Importar** carga un archivo así en el formulario. Así guardas un diseño, lo trasladas a otra instalación o lo compartes con otros operadores del LMO. Al importar solo se aceptan campos conocidos con valores válidos.

Hay además dos funciones auxiliares: **Valores estándar** restablece todos los campos a los valores originales (tras confirmación), **Descartar cambios** deshace todo desde el último guardado.

### Tus propias ampliaciones con style.css

Si el editor de diseño no basta, edita el archivo `template/style.css`. Sus reglas CSS se cargan automáticamente, sobrescriben los ajustes del editor de diseño y también se ven en la vista previa en vivo. Todos los ajustes del editor se guardan en `config/cfg.txt` (variables `lmo_…`) y se convierten en una hoja de estilos al llamar al LMO.

---

## 4. Gestión de usuarios

La gestión de usuarios se abre en **Opciones → Gestión de usuarios**. Primero ves todos los administradores y administradores auxiliares configurados. Para modificar uno, selecciona la cuenta, cambia los datos y pulsa **Guardar**. **Eliminar** borra una cuenta de forma irreversible.

En los administradores auxiliares defines además en **Ligas habilitadas** a qué ligas pueden acceder.

Una cuenta nueva se crea en el apartado **Añadir nuevo administrador**. Los campos están rellenados de antemano y la contraseña es aleatoria y puedes aceptarla. Después asigna sus derechos al nuevo administrador.

### Administradores auxiliares

Los administradores auxiliares introducen resultados, pero no tienen acceso a los ajustes delicados de la liga ni a las opciones globales. Práctico si colaboradores introducen los resultados actuales por ti.

### Administradores auxiliares ampliados

Si los derechos de un administrador auxiliar no bastan, puedes ampliarlos. Un administrador auxiliar ampliado es un administrador completo, pero solo para sus ligas:

- Puede gestionar por completo las ligas que se le han asignado.
- No tiene acceso a las opciones globales.

---

## 5. Archivo de ligas

Puedes guardar las ligas terminadas en el archivo integrado sin que la selección de ligas se haga demasiado larga. Crea en la carpeta `ligen/` un subdirectorio con un nombre claro (p. ej. `Bundesliga`) y mueve las ligas a él. Los directorios se pueden anidar tanto como quieras.

Si el ajuste correspondiente de las opciones globales está activo, tus visitantes ven el archivo con un enlace para cada subdirectorio. Para una descripción, crea en un directorio el archivo de texto `dir-descr.txt` (p. ej. „Todas las temporadas de la Bundesliga de 1963 a 2000"). Tras hacer clic en el enlace del directorio, los visitantes eligen las ligas como de costumbre. Las ligas archivadas se pueden seguir editando en el área de administración.

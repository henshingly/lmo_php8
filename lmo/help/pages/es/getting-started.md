# Primeros pasos

1. [Introducción](#1-introduccion)
2. [Requisitos del sistema](#2-requisitos-del-sistema)
3. [Instalación](#3-instalacion)
4. [Corregir permisos de archivo](#4-corregir-permisos-de-archivo)
5. [Instalación de actualización](#5-instalacion-de-actualizacion)
6. [Inicio/Cierre de sesión](#6-inicio-cierre-de-sesion)
7. [Aviso legal](#7-aviso-legal)

---

## 1. Introducción

¡Bienvenido al Liga Manager Online! Con este script ofreces a tus visitantes un servicio de resultados de tus ligas favoritas. Toda la gestión se hace directamente en el servidor: tú solo introduces los resultados y tus visitantes ven al instante las clasificaciones, estadísticas y calendarios actuales.

El área de administración se abre con `lmoadmin.php`. Conviene guardarla como marcador, porque por motivos de seguridad no hay ningún enlace a ella en el área de visitantes. Tus visitantes inician el LMO con el archivo `lmo.php`. Cómo integrarlo en tu página web se explica en [Personalización](#customization/4-integrar-el-lmo-en-paginas-web-existentes).

Cada enlace tiene una descripción emergente, por lo que normalmente no hacen falta más explicaciones de uso.

---

## 2. Requisitos del sistema

- **Servidor web:** Apache, Nginx u otro servidor web con PHP (Linux o Windows)
- **PHP:** versión **8.2 o superior**
- **Base de datos:** no hace falta, el LMO guarda todo en archivos (flat files)
- **Extensiones de PHP:** `mbstring`, `session` y `json` (preinstaladas en casi todos los alojamientos). Opcional: **Zip** para descargar todas las ligas y para adjuntos zip en el correo, **OpenSSL** para enviar correo por SMTP con cifrado (TLS/SSL). Las curvas de forma (liga y juego de pronósticos) se dibujan en el navegador y no necesitan la biblioteca GD.
- **Permisos de escritura:** PHP debe poder escribir en los directorios de ligas, configuración y salida. El instalador lo comprueba y ajusta los permisos cuando es posible.
- **Navegador:** un navegador actual con JavaScript activado

> **Nota para Apache 2:** Quita todos los caracteres especiales de los nombres de archivo de los iconos de equipo. Solo se permiten letras y cifras.

---

## 3. Instalación

La instalación se realiza por completo en el navegador; no tienes que introducir datos de FTP.

1. Descomprime el archivo ZIP y sube **todo el contenido** a tu servidor, conservando la estructura de directorios.
2. Abre el LMO en el navegador, p. ej. `https://www.tu-sitio.es/lmo/lmoadmin.php`. **La instalación se inicia automáticamente** y configura rutas, configuración y datos de acceso.
3. Tras una instalación correcta aparece el botón **Eliminar ahora la carpeta de instalación**. Púlsalo para que la carpeta `install` no se quede en el servidor.
4. Inicia sesión y cambia la contraseña de inmediato (véase [Inicio/Cierre de sesión](#6-inicio-cierre-de-sesion)).

Normalmente el LMO queda listo después. Si la instalación se interrumpe, comprueba primero los [permisos de archivo](#4-corregir-permisos-de-archivo).

### Instalación manual

> **Solo necesaria si la instalación automática no funciona.**

1. Copia el contenido de la carpeta `install` en el directorio de tu LMO y elimina después el archivo `install/install.php`.
2. Crea (o abre) el archivo `config/init-parameters.php` e introduce las dos rutas:

   ```php
   <?php
   $lmo_dateipfad = '/ruta/absoluta/al/lmo'; // ruta de archivo del LMO
   $lmo_url = 'https://www.tu-sitio.es/lmo'; // URL absoluta del LMO
   ```

   Si no conoces ninguna de las dos, pregunta a tu proveedor.
3. Establece los permisos de archivo como se describe en el apartado siguiente.

---

## 4. Corregir permisos de archivo

El LMO debe poder escribir en algunas carpetas y archivos. Si avisa de que algo no se puede escribir, establece los permisos (chmod) así:

![Establecer permisos (chmod)](./assets/media/manual_chmod.png)

**Directorios (777):**

- `ligen` y todos los subdirectorios
- `output`
- `config` y sus subdirectorios `config/viewer` y `config/smtp`
- `addon/spieler/stats`
- `addon/tipp/tipps` y todos los subdirectorios

**Archivos (666):**

- `config/lmo-auth.php`
- `addon/tipp/lmo-tipperauth.php`
- `config/smtp/cfg.php` y `config/smtp/key.php` (si existen)
- todos los archivos `cfg.txt` del directorio `config` y sus subdirectorios
- todas las ligas del directorio `ligen` y sus subdirectorios
- todos los archivos de `output`, `addon/spieler/stats` y `addon/tipp/tipps` (si existen)

---

## 5. Instalación de actualización

Al actualizar una instalación existente no se sobrescriben tus archivos de configuración ni tus ligas.

1. Haz primero una copia de seguridad de todo tu directorio del LMO (al menos `ligen`, `config` y `addon/tipp/tipps`).
2. Copia los archivos nuevos sobre los existentes. Tus personalizaciones (p. ej. en `template/` o `img/teams/`) se conservan mientras no sustituyas esos mismos archivos.
3. Abre el área de administración. El LMO indica **Actualización detectada**. Pulsa **Iniciar instalación de actualización**.
4. La actualización adapta la configuración. Entre otras cosas, las contraseñas de los participantes del juego de pronósticos se convierten a un almacenamiento seguro (con hash).
5. Después elimina la carpeta `install` con el botón **Eliminar ahora la carpeta de instalación**.

> **Nota:** Si la carpeta `config/smtp` no se puede escribir, el LMO te lo indica. Los ajustes SMTP solo se podrán guardar cuando se hayan establecido los permisos.

---

## 6. Inicio/Cierre de sesión

Al abrir `lmoadmin.php` aparece el formulario de acceso. Tras una instalación nueva están preestablecidos el usuario `admin` y la contraseña `lmo` (L, M, O en minúscula). **Cambia la contraseña lo antes posible** en [Opciones → Gestión de usuarios](#options/4-gestion-de-usuarios) para que nadie no autorizado obtenga acceso.

Con la sesión iniciada encontrarás en el menú la entrada **Cerrar sesión**. Úsala al final de cada sesión.

---

## 7. Aviso legal

> Este script se publica bajo los términos de la [GPL](https://www.gnu.org/licenses/gpl.txt). Esto significa que puedes usar, distribuir y modificar el script, pero no se ofrece ninguna garantía. **Los avisos de copyright deben conservarse en todos los casos y no pueden eliminarse ni modificarse.**

Aunque el software se ha desarrollado con cuidado, no se asume responsabilidad por errores o daños derivados de su uso.

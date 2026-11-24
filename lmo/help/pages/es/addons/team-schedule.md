# Calendario del equipo

1. [Requisitos del sistema](#1-requisitos-del-sistema)
2. [Configuración](#2-configuracion)
3. [Integración](#3-integracion)
4. [Descarga](#4-descarga)
5. [Historial de versiones](#5-historial-de-versiones)

![Vista del calendario del equipo](./assets/media/teampl01.png)

El addon permite generar el calendario de un equipo seleccionado como documento PDF, directamente mediante el enlace «Calendarios» del LMO.

---

## 1. Requisitos del sistema

- Un LMO 4 funcionando
- Addon Classlib de Tim Schumacher instalado (disponible en el archivo de addons), incluida la clase PDF de [Wayne Munro, R&OS Ltd](http://www.ros.co.nz/pdf) (contenida en la Classlib)

---

## 2. Configuración

El addon Calendario del equipo se configura mediante la gestión de addons del LMO.

### Gestión de addons

En la gestión de addons haz clic en **pdf**. Están disponibles los siguientes parámetros:

| Parámetro | Descripción |
|---|---|
| `linktarget` | Abre el PDF en una ventana nueva (p. ej. `_blank`) |
| `show_adobe_link` | Aviso sobre el lector de PDF con imagen: **0** = desactivado / **1** = activado |
| `homepage` | Muestra un texto en el margen, p. ej. la dirección de tu página web |
| `anzeige` | Ordenación por jornada / fecha: **0** / **1** |
| `format` | Formato de salida A4 horizontal / vertical: **0** / **1** |
| `teamfett` | Resaltar el equipo seleccionado: **0** = desactivado / **1** = activado |
| `teamnamen` | Nombre del equipo largo / corto / medio: **0** / **1** / **2** |
| `serie` | Ida/vuelta en 1 página / 2 páginas: **0** / **1** |

---

## 3. Integración

### Integrar en el LMO

> Establece los permisos de acceso (chmod):
> **Archivos:** `666` para todos los archivos `cfg.txt` del directorio `config` y sus subdirectorios

Abre el archivo `lmo-showprogram.php` e inserta el siguiente código debajo de la última línea (`} ?>`):

```php
<?
// Teamplan ADDON BEGIN
if (file_exists(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php'))
    include(PATH_TO_ADDONDIR.'/pdf/lmo-showprogram.inc.php');
// Teamplan ADDON END
?>
```

Tras la instalación aparece el nuevo enlace **Calendario como documento PDF** debajo de la ventana de selección «Calendarios».

> **Nota:** ¡El aviso de copyright con la información de versión **no** debe modificarse ni eliminarse!

---

## 4. Descarga

- [Calendario del equipo](http://www.liga-manager-online.de/lmo-forum/viewtopic.php?t=5489)

---

## 5. Historial de versiones

**1.0**

- Salida del calendario en formato PDF

**2.0**

- Ordenación de la salida
- Resaltado del equipo seleccionado
- Nombre del equipo y formato seleccionables
- Salida separada para ida y vuelta

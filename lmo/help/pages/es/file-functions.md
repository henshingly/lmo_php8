# Funciones de archivo

1. [Eliminar una liga](#1-eliminar-una-liga)
2. [Subir una liga](#2-subir-una-liga)
3. [Descargar/Enviar por correo una liga](#3-descargar-enviar-por-correo-una-liga)

---

## 1. Eliminar una liga

Si una liga está obsoleta o quieres sustituirla por una copia de seguridad, elige **Eliminar** en el menú y haz clic en la liga de la lista. Tras una pregunta de seguridad se **elimina definitivamente**. Ten, pues, cuidado.

---

## 2. Subir una liga

Con **Subir** transfieres una liga desde tu disco duro directamente a tu directorio de ligas. Elige una liga (`*.l98`) con **Examinar …** e inicia con **Iniciar subida** (haz clic solo una vez). Las ligas existentes no se sobrescriben: si el nombre de archivo ya existe, se numera; `liga.l98` pasa a ser `liga_1.l98`.

---

## 3. Descargar/Enviar por correo una liga

Para una copia de seguridad, editar sin conexión o pasar una liga a otra persona, elige **Descargar**. La pantalla muestra la lista de ligas dos veces:

- **Izquierda:** Un clic descarga la liga a tu disco duro. Con **Descargar todas las ligas a la vez** obtienes un archivo ZIP con todas las ligas listadas.
- **Derecha:** Un clic abre una ventana para introducir el correo del destinatario. La liga (o todas) se empaqueta en un archivo ZIP y se envía por correo. El remitente es la dirección de remitente indicada en las opciones o el correo del webmaster. El método de envío es el ajustado allí (PHP `mail()` o SMTP, véase [Envío de correo](#options/envio-de-correo-smtp)).

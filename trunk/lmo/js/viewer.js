/**
 * Javascript functions for the Viewer-Addon for Liga Manager Online 4
 *
 * @package viewer
 * @author Rene Marth/lmogroup
 */

/**
 * checks all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall check all boxes
 *
 */
function checkAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = true;
    }
  }
}
/**
 * unchecks all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall uncheck all boxes
 */
function uncheckAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = false;
    }
  }
}

/**
 * switches the state of all checkboxes in a form
 *
 *
 * @param elm  Object  Element of the form that shall switch all boxes
 */
function switchAll(elm) {
  for (var i = 0; i < elm.form.elements.length; i++) {
    if (elm.form.elements[i].type == "checkbox") {
      elm.form.elements[i].checked = !elm.form.elements[i].checked;
    }
  }
}

/**
 * turns on the by Matchday-Cobnfig-Items / turns off the by Date-Config-Items
 *
 *
 * @param elm  Object  Element to enable by Date
 */
function byDay (elm) {
  elm.form.anzahl_spieltage_vor.disabled=false;
  elm.form.anzahl_spieltage_zurueck.disabled=false;
  elm.form.anzahl_tage_plus.disabled=true;
  elm.form.anzahl_tage_minus.disabled=true;
}

/**
 * turns on the by Date-Config-Items / turns off the by Matchday-Cobnfig-Items
 *
 *
 * @param elm  Object  Element to enable by Matchday
 */
function byDate (elm) {
  elm.form.anzahl_spieltage_vor.disabled=true;
  elm.form.anzahl_spieltage_zurueck.disabled=true;
  elm.form.anzahl_tage_plus.disabled=false;
  elm.form.anzahl_tage_minus.disabled=false;
}
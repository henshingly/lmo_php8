/* Liga Manager Online 4
  *
  * https://www.liga-manager-online.org/lmo/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  * LMO Designeditor: klickbare Live-Vorschau, Export/Import, Standardwerte. Konfiguration kommt aus lmo-admindesign.php (window.LMO_DESIGN). */
(function () {
  'use strict';
  var C = window.LMO_DESIGN;
  if (!C) { return; }
  var $ = function (id) { return document.getElementById(id); };
  var form, frame, msgBox, cssFailed = false, timer = null, seq = 0, hl = null, hlLabel = null, saved = {};

  /* ---------- Pruefung (spiegelt lmo-designlib.php; massgeblich ist der Server) ---------- */
  function valid(key, v) {
    var m = /_(background|color|fontfamily|fontsize|border)[0-9]+$/.exec(key);
    if (typeof v !== 'string' || v.length > 60 || !m) { return false; }
    switch (m[1]) {
      case 'background': case 'color': return /^(#[0-9a-fA-F]{3,8}|[a-zA-Z]{3,20})?$/.test(v);
      case 'border': return /^[0-9a-zA-Z#%.,() -]{0,40}$/.test(v);
      case 'fontfamily': return /^[0-9a-zA-Z ,'-]{0,60}$/.test(v);
      case 'fontsize': return /^([0-9]{1,3}(\.[0-9]{1,2})?(px|pt|pc|em|rem|ex|%|cm|mm|in)?)?$/.test(v);
    }
    return false;
  }
  function isFlag(key) { return /underline1$/.test(key); }
  function field(key) { return $('de_' + key); }

  function say(text, bad) {
    if (!msgBox) { return; }
    msgBox.textContent = text || '';
    msgBox.style.color = bad ? '#b00' : '';
  }

  /* ---------- Farbfelder: Text <-> nativer Farbwaehler ---------- */
  var ctx = document.createElement('canvas').getContext('2d');
  function toHex(v) {
    if (!v) { return null; }
    ctx.fillStyle = '#010203';
    ctx.fillStyle = v;
    var r = ctx.fillStyle;
    if (r === '#010203' && v.toLowerCase() !== '#010203') { return null; }
    return /^#[0-9a-f]{6}$/i.test(r) ? r : null;
  }
  function syncPicker(input) {
    var pick = form.querySelector('input[type=color][data-for="' + input.id + '"]');
    if (!pick) { return; }
    var h = toHex(input.value);
    pick.value = h || '#000000';
    pick.classList.toggle('lmo-de-empty', !h);
  }

  /* ---------- Werte lesen / setzen ---------- */
  function setValue(key, v) {
    var el = field(key);
    if (!el) { return false; }
    if (isFlag(key)) { el.checked = (v === 'underline'); }
    else { el.value = v; syncPicker(el); }
    return true;
  }
  function snapshot() {
    var s = {};
    C.groups.forEach(function () {});
    Object.keys(C.defaults).forEach(function (k) {
      var el = field(k);
      if (el) { s[k] = isFlag(k) ? (el.checked ? 'underline' : '') : el.value; }
    });
    return s;
  }
  function applyValues(obj) {
    var n = 0;
    Object.keys(C.defaults).forEach(function (k) {
      if (!Object.prototype.hasOwnProperty.call(obj, k)) { return; }
      var v = obj[k];
      if (isFlag(k)) { if (v === 'underline' || v === '') { setValue(k, v); n++; } }
      else if (valid(k, v)) { setValue(k, v); n++; }
    });
    if (window.dolmoedit) { window.dolmoedit(); }
    schedule(0);
    return n;
  }

  /* ---------- Reiter ---------- */
  function showGroup(g) {
    var tabs = form.parentNode.querySelectorAll('.lmo-de-tabs a');
    var groups = form.querySelectorAll('.lmo-de-group');
    Array.prototype.forEach.call(tabs, function (a) { a.classList.toggle('lmo-de-on', a.getAttribute('data-group') === g); });
    Array.prototype.forEach.call(groups, function (d) { d.classList.toggle('lmo-de-on', d.getAttribute('data-group') === g); });
    var idx = C.groups.indexOf(g);
    if (idx >= 0) { $('lmo-de-show').value = idx; }
  }
  function focusField(group, key) {
    showGroup(group);
    var el = field(key);
    if (!el) { return; }
    var row = $('de-row-' + key);
    if (row && row.scrollIntoView) { row.scrollIntoView({ block: 'center', behavior: 'smooth' }); }
    if (row) {
      row.classList.add('lmo-de-flash');
      setTimeout(function () { row.classList.remove('lmo-de-flash'); }, 1600);
    }
    try { el.focus({ preventScroll: true }); } catch (e) { el.focus(); }
  }

  /* ---------- Live-Vorschau ---------- */
  function schedule(ms) {
    checkContrast();
    clearTimeout(timer);
    timer = setTimeout(updateCss, ms === undefined ? 200 : ms);
  }
  function updateCss() {
    if (!frame) { return; }
    var doc;
    try { doc = frame.contentDocument; } catch (e) { doc = null; }
    if (!doc || !doc.head || !doc.body || !doc.body.innerHTML) { return; }
    var my = ++seq;
    var fd = new FormData(form);
    fd.delete('save'); fd.delete('action'); fd.delete('todo'); fd.delete('show');
    fetch(C.css, { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { if (!r.ok) { throw new Error(r.status); } return r.text(); })
      .then(function (css) {
        if (my !== seq) { return; }
        var st = doc.getElementById('lmo-de-live');
        if (!st) {
          st = doc.createElement('style');
          st.id = 'lmo-de-live';
          doc.head.appendChild(st);
        }
        st.textContent = css;
        if (cssFailed) { cssFailed = false; say(''); }
      })
      .catch(function () { cssFailed = true; say(C.msg.css_error, true); });
  }

  function matchHot(el) {
    for (; el && el.nodeType === 1; el = el.parentElement) {
      for (var i = 0; i < C.hotspots.length; i++) {
        var h = C.hotspots[i];
        try { if (el.matches(h.sel)) { return { el: el, h: h }; } } catch (e) { /* ungueltiger Selektor */ }
      }
    }
    return null;
  }
  function hideHl() {
    if (hl) { hl.style.display = 'none'; }
    if (hlLabel) { hlLabel.style.display = 'none'; }
  }
  function attachHotspots() {
    var doc = frame.contentDocument;
    if (!doc || !doc.body) { return; }
    var st = doc.createElement('style');
    st.textContent = 'html,body{cursor:pointer!important}' +
      '#lmo-de-hl{position:absolute;z-index:99998;pointer-events:none;outline:2px dashed #f60;outline-offset:-2px;background:rgba(255,102,0,.10);display:none}' +
      '#lmo-de-hl-l{position:absolute;z-index:99999;pointer-events:none;background:#f60;color:#fff;font:12px/1.3 sans-serif;padding:2px 6px;border-radius:3px;white-space:nowrap;display:none}';
    doc.head.appendChild(st);
    hl = doc.createElement('div'); hl.id = 'lmo-de-hl';
    hlLabel = doc.createElement('div'); hlLabel.id = 'lmo-de-hl-l';
    doc.body.appendChild(hl); doc.body.appendChild(hlLabel);
    var win = frame.contentWindow;
    doc.addEventListener('mouseover', function (e) {
      var m = matchHot(e.target);
      if (!m) { hideHl(); return; }
      var r = m.el.getBoundingClientRect();
      var sx = win.pageXOffset, sy = win.pageYOffset;
      hl.style.cssText = 'display:block;left:' + (r.left + sx) + 'px;top:' + (r.top + sy) + 'px;width:' + r.width + 'px;height:' + r.height + 'px';
      hlLabel.textContent = m.h.label;
      hlLabel.style.display = 'block';
      var top = r.top + sy - 22;
      hlLabel.style.left = Math.max(2, r.left + sx) + 'px';
      hlLabel.style.top = (top < sy ? r.top + sy + 2 : top) + 'px';
    }, true);
    doc.addEventListener('mouseleave', hideHl, true);
    doc.addEventListener('click', function (e) {
      e.preventDefault(); e.stopPropagation();
      var m = matchHot(e.target);
      if (m) { focusField(m.h.group, m.h.field); }
    }, true);
    doc.addEventListener('submit', function (e) { e.preventDefault(); }, true);
  }
  function loadPreview() {
    var lg = $('lmo-de-league'), vw = $('lmo-de-view');
    if (!lg || !frame) { return; }
    try { localStorage.setItem('lmoDesignLeague', lg.value); localStorage.setItem('lmoDesignView', vw.value); } catch (e) { /* ohne Speicher */ }
    say(C.msg.loading);
    frame.src = 'lmo.php?file=' + encodeURIComponent(lg.value) + '&action=' + encodeURIComponent(vw.value);
  }


  /* ---------- Farbschemata ---------- */
  function rgb(h) { h = toHex(h) || '#000000'; return [parseInt(h.substr(1, 2), 16), parseInt(h.substr(3, 2), 16), parseInt(h.substr(5, 2), 16)]; }
  function hex(c) { return '#' + c.map(function (v) { v = Math.max(0, Math.min(255, Math.round(v))); return (v < 16 ? '0' : '') + v.toString(16); }).join(''); }
  function mix(a, b, t) { var x = rgb(a), y = rgb(b); return hex([x[0] * (1 - t) + y[0] * t, x[1] * (1 - t) + y[1] * t, x[2] * (1 - t) + y[2] * t]); }
  function lum(h) { var c = rgb(h).map(function (v) { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); }); return 0.2126 * c[0] + 0.7152 * c[1] + 0.0722 * c[2]; }
  function on(h) { var l = lum(h); return (l + 0.05) / 0.05 > 1.05 / (l + 0.05) ? '#000000' : '#ffffff'; }  /* Schwarz oder Weiss, je nach besserem Kontrast */
  /* Erzeugt alle Farbwerte der Rahmen, Menues, Kreuztabelle und Formulare aus einer Hauptfarbe.
     Tabellen- und Turnierfarben (Auf-/Abstieg usw.) bleiben unveraendert. */
  function schemeValues(P, dark) {
    var v = {}, k;
    if (!dark) {
      v = { main_background1: mix(P, '#ffffff', .87), main_color1: '#000000', main_color2: P,
        main_background4: P, main_color4: on(P), main_background5: P, main_color5: on(P),
        main_background6: '#eeeeee', main_color6: P, main_background7: '#eeeeee', main_color7: P,
        middle_background1: '#ffffff', middle_color1: '#000000', middle_background2: P, middle_color2: on(P),
        middle_background4: P, middle_color4: on(P), middle_background5: P, middle_color5: on(P),
        middle_background6: '#ffffff', middle_color6: P, middle_background7: '#ffffff', middle_color7: P,
        inner_background1: mix(P, '#ffffff', .96), inner_color1: '#000000', inner_background2: P, inner_color2: on(P),
        inner_background3: '', inner_color3: '',
        kreuzkal_background1: mix(P, '#ffffff', .87), kreuzkal_background2: '#eeeeee', kreuzkal_color1: '#dd0000',
        formular_background1: '#eeeeee', formular_color1: '#000000', formular_background2: '#eeeeee', formular_color2: P };
    } else {
      var lt = mix(P, '#ffffff', .72), mn = mix(P, '#000000', .3);
      v = { main_background1: mix(P, '#000000', .85), main_color1: '#e8e8e8', main_color2: lt,
        main_background4: mn, main_color4: '#ffffff', main_background5: mn, main_color5: '#ffffff',
        main_background6: mix(P, '#000000', .7), main_color6: lt, main_background7: mix(P, '#000000', .7), main_color7: lt,
        middle_background1: mix(P, '#000000', .78), middle_color1: '#e8e8e8', middle_background2: mn, middle_color2: '#ffffff',
        middle_background4: mn, middle_color4: '#ffffff', middle_background5: mn, middle_color5: '#ffffff',
        middle_background6: mix(P, '#000000', .7), middle_color6: lt, middle_background7: mix(P, '#000000', .7), middle_color7: lt,
        inner_background1: mix(P, '#000000', .72), inner_color1: '#e8e8e8', inner_background2: mn, inner_color2: '#ffffff',
        inner_background3: '', inner_color3: lt,
        kreuzkal_background1: mix(P, '#000000', .55), kreuzkal_background2: mix(P, '#000000', .8), kreuzkal_color1: '#ff8a80',
        formular_background1: mix(P, '#000000', .7), formular_color1: '#eeeeee', formular_background2: mix(P, '#000000', .6), formular_color2: '#ffffff' };
    }
    for (k in v) { if (v[k] && v[k].length === 4) { v[k] = hex(rgb(v[k])); } }
    return v;
  }
  function pickScheme(id, color) {
    var dark = $('lmo-de-dark').checked, v;
    if (id === 'std' && !dark) {
      v = {};
      Object.keys(schemeValues('#000099', false)).forEach(function (k) { v[k] = C.defaults[k]; });
    } else {
      v = schemeValues(color, dark);
    }
    applyValues(v);
    var chips = document.querySelectorAll('.lmo-de-chip');
    Array.prototype.forEach.call(chips, function (c) { c.classList.toggle('lmo-de-on', c.getAttribute('data-id') === id); });
    say(C.msg.scheme_done);
  }

  /* Farbpalette fuer "Eigene Farbe": 12 Farbtoene x 8 Stufen + Grautoene, dazu Browser-Farbwaehler und Hex-Feld */
  function hsl(h, sat, l) {
    sat /= 100; l /= 100;
    var a = sat * Math.min(l, 1 - l);
    var f = function (n) { var k = (n + h / 30) % 12; return l - a * Math.max(-1, Math.min(k - 3, 9 - k, 1)); };
    return hex([f(0) * 255, f(8) * 255, f(4) * 255]);
  }
  function initPalette(onPick) {
    var btn = $('lmo-de-custombtn'), pal = $('lmo-de-palette'), box = $('lmo-de-swatches');
    if (!btn || !pal) { return; }
    var colors = [], h, i;
    var lights = [18, 25, 32, 40, 48, 58, 68, 80];
    for (i = 0; i < lights.length; i++) {
      for (h = 0; h < 360; h += 30) { colors.push(hsl(h, i < 6 ? 75 : 65, lights[i])); }
    }
    for (i = 0; i < 12; i++) { colors.push(hsl(0, 0, Math.round(i * 100 / 11 * 0.9 + 4))); }
    colors.forEach(function (c) {
      var b = document.createElement('button');
      b.type = 'button'; b.title = c; b.style.background = c; b.setAttribute('data-c', c);
      b.addEventListener('click', function () { choose(c); });
      box.appendChild(b);
    });
    function choose(c) {
      $('lmo-de-custom').value = c; $('lmo-de-hex').value = c;
      Array.prototype.forEach.call(box.children, function (x) { x.classList.toggle('lmo-de-on', x.getAttribute('data-c') === c); });
      onPick(c);
    }
    btn.addEventListener('click', function (e) { e.stopPropagation(); pal.hidden = !pal.hidden; });
    pal.addEventListener('click', function (e) { e.stopPropagation(); });
    document.addEventListener('click', function () { pal.hidden = true; });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { pal.hidden = true; } });
    $('lmo-de-custom').addEventListener('input', function () { choose(this.value); });
    $('lmo-de-hex').addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { e.preventDefault(); this.dispatchEvent(new Event('change')); }   /* Enter wendet an, speichert aber nicht */
    });
    $('lmo-de-hex').addEventListener('change', function () {
      var v = this.value.trim(); if (v.charAt(0) !== '#') { v = '#' + v; }
      var c = toHex(v); if (c) { choose(c); }
    });
  }

  function initSchemes() {
    var box = $('lmo-de-chips');
    if (!box || !C.schemes) { return; }
    var last = { id: 'std', color: '#000099' };
    C.schemes.forEach(function (s) {
      var b = document.createElement('button');
      b.type = 'button'; b.className = 'lmo-de-chip'; b.title = s.name; b.setAttribute('data-id', s.id);
      b.style.background = 'linear-gradient(135deg,' + s.color + ' 50%,' + mix(s.color, '#ffffff', .87) + ' 50%)';
      b.addEventListener('click', function () { last = { id: s.id, color: s.color }; pickScheme(s.id, s.color); });
      box.appendChild(b);
    });
    $('lmo-de-dark').addEventListener('change', function () { pickScheme(last.id, last.color); });
    initPalette(function (c) { last = { id: 'custom', color: c }; pickScheme('custom', c); });
  }

  /* ---------- Kontrast-Warnung (WCAG, Ziel mindestens 4.5:1) ---------- */
  function checkContrast() {
    var warnGroups = {};
    Array.prototype.forEach.call(form.querySelectorAll('.lmo-de-color'), function (c) {
      c.parentNode.parentNode.classList.remove('lmo-de-lowc');
    });
    Array.prototype.forEach.call(form.querySelectorAll('tr[id^="de-row-"]'), function (row) {
      var inputs = row.querySelectorAll('.lmo-de-color input[type=text]');
      row.classList.remove('lmo-de-lowc'); row.removeAttribute('data-lowc');
      if (inputs.length !== 2) { return; }
      var bg = toHex(inputs[0].value), fg = toHex(inputs[1].value);
      if (!bg || !fg) { return; }
      var l1 = lum(bg), l2 = lum(fg), r = (Math.max(l1, l2) + 0.05) / (Math.min(l1, l2) + 0.05);
      if (r < 4.5) {
        row.classList.add('lmo-de-lowc');
        row.title = C.msg.contrast.replace('%s', r.toFixed(1));
        warnGroups[row.closest('.lmo-de-group').getAttribute('data-group')] = true;
      } else { row.removeAttribute('title'); }
    });
    Array.prototype.forEach.call(document.querySelectorAll('.lmo-de-tabs a'), function (a) {
      a.classList.toggle('lmo-de-warntab', !!warnGroups[a.getAttribute('data-group')]);
    });
  }

  /* ---------- Gespeicherte Designs (Server, config/design/) ---------- */
  function store(op, name, extra) {
    var fd = new FormData();
    if (op === 'save') { new FormData(form).forEach(function (v, k) { if (k.indexOf('xlmo_') === 0) { fd.append(k, v); } }); }
    fd.append('token', C.token); fd.append('op', op); fd.append('name', name || '');
    if (extra) { Object.keys(extra).forEach(function (k) { fd.append(k, extra[k]); }); }
    return fetch(C.store, { method: 'POST', body: fd, credentials: 'same-origin' })
      .then(function (r) { return r.json(); })
      .catch(function () { return { ok: false, error: 'net' }; });
  }
  function fillList(list, select) {
    var sel = $('lmo-de-saved');
    sel.innerHTML = '';
    if (!list || !list.length) {
      var o = document.createElement('option'); o.value = ''; o.textContent = C.msg.none; sel.appendChild(o); return;
    }
    list.forEach(function (it) {
      var o = document.createElement('option'); o.value = it.name; o.textContent = it.name; sel.appendChild(o);
    });
    if (select) { sel.value = select; }
  }
  function storeError(r) { say(r.error === 'name' ? C.msg.bad_name : C.msg.store_fail, true); }
  function initStore() {
    if (!$('lmo-de-saved')) { return; }
    store('list').then(function (r) { fillList(r.list); });
    $('lmo-de-savenew').addEventListener('click', function () {
      var name = prompt(C.msg.ask_name, $('lmo-de-saved').value || '');
      if (!name) { return; }
      name = name.trim();
      store('save', name).then(function (r) {
        if (!r.ok && r.error === 'exists') {
          if (!confirm(C.msg.overwrite.replace('%s', name))) { return null; }
          return store('save', name, { overwrite: 1 });
        }
        return r;
      }).then(function (r) {
        if (!r) { return; }
        if (!r.ok) { storeError(r); return; }
        fillList(r.list, name); say(C.msg.saved.replace('%s', name));
      });
    });
    $('lmo-de-load').addEventListener('click', function () {
      var name = $('lmo-de-saved').value; if (!name) { return; }
      store('load', name).then(function (r) {
        if (!r.ok) { storeError(r); return; }
        applyValues(r.values); say(C.msg.loaded.replace('%s', name));
      });
    });
    $('lmo-de-del').addEventListener('click', function () {
      var name = $('lmo-de-saved').value; if (!name) { return; }
      if (!confirm(C.msg.confirm_del)) { return; }
      store('delete', name).then(function (r) {
        if (!r.ok) { storeError(r); return; }
        fillList(r.list); say(C.msg.deleted.replace('%s', name));
      });
    });
  }

  /* ---------- Export / Import / Standard / Verwerfen ---------- */
  function doExport() {
    var data = { lmo_design: 1, created: new Date().toISOString(), values: snapshot() };
    var blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
    var a = document.createElement('a');
    var d = new Date(), p = function (n) { return (n < 10 ? '0' : '') + n; };
    a.href = URL.createObjectURL(blob);
    a.download = 'lmo-design-' + d.getFullYear() + p(d.getMonth() + 1) + p(d.getDate()) + '.json';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
    setTimeout(function () { URL.revokeObjectURL(a.href); }, 2000);
  }
  function doImport(file) {
    if (!file) { return; }
    if (file.size > 100000) { say(C.msg.export_bad, true); return; }
    var rd = new FileReader();
    rd.onload = function () {
      var o;
      try { o = JSON.parse(rd.result); } catch (e) { o = null; }
      if (!o || o.lmo_design !== 1 || !o.values || typeof o.values !== 'object') { say(C.msg.export_bad, true); return; }
      var n = applyValues(o.values);
      if (n === 0) { say(C.msg.export_bad, true); return; }
      say(C.msg.imported.replace('%d', n));
    };
    rd.readAsText(file);
  }

  function init() {
    form = $('lmo-de-form');
    if (!form) { return; }
    frame = $('lmo-de-frame');
    msgBox = $('lmo-de-msg');
    saved = snapshot();
    initSchemes();
    initStore();
    checkContrast();

    Array.prototype.forEach.call(form.querySelectorAll('.lmo-de-color input[type=text]'), syncPicker);
    form.addEventListener('input', function (e) {
      var t = e.target;
      if (t.type === 'color') {
        var tx = $(t.getAttribute('data-for'));
        tx.value = t.value; t.classList.remove('lmo-de-empty');
        if (window.dolmoedit) { window.dolmoedit(); }
      } else if (t.type === 'text' && t.classList.contains('lmo-formular-input') && t.parentNode.className === 'lmo-de-color') {
        syncPicker(t);
      }
      schedule();
    });
    form.addEventListener('change', function () { schedule(); });

    Array.prototype.forEach.call(document.querySelectorAll('.lmo-de-tabs a'), function (a) {
      a.addEventListener('click', function (e) { e.preventDefault(); showGroup(a.getAttribute('data-group')); });
    });

    $('lmo-de-export').addEventListener('click', doExport);
    $('lmo-de-import').addEventListener('click', function () { $('lmo-de-file').value = ''; $('lmo-de-file').click(); });
    $('lmo-de-file').addEventListener('change', function () { doImport(this.files[0]); });
    $('lmo-de-default').addEventListener('click', function () {
      if (!confirm(C.msg.confirm_def)) { return; }
      applyValues(C.defaults);
      say(C.msg.defaults);
    });
    $('lmo-de-discard').addEventListener('click', function () {
      if (!confirm(C.msg.confirm_disc)) { return; }
      applyValues(saved);
      say('');
    });

    if (frame) {
      var lg = $('lmo-de-league'), vw = $('lmo-de-view');
      try {
        var l = localStorage.getItem('lmoDesignLeague'), v = localStorage.getItem('lmoDesignView');
        if (l && lg.querySelector('option[value="' + l.replace(/"/g, '\\"') + '"]')) { lg.value = l; }
        if (v && vw.querySelector('option[value="' + v + '"]')) { vw.value = v; }
      } catch (e) { /* ohne Speicher */ }
      var wd = $('lmo-de-width');
      if (wd) { wd.addEventListener('change', function () { frame.style.width = wd.value; }); }
      lg.addEventListener('change', loadPreview);
      vw.addEventListener('change', loadPreview);
      frame.addEventListener('load', function () {
        if (!frame.contentDocument || !frame.contentDocument.body || frame.src === 'about:blank') { return; }
        attachHotspots();
        say(C.msg.ready);
        schedule(0);
      });
      loadPreview();
    }
  }
  if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', init); } else { init(); }
})();

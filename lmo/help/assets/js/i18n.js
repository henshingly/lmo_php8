/*
 * UI-Übersetzung (data-i18n) und Sprachumschalter.
 * Sprachen stehen in i18n/languages.json ("enabled": true schaltet eine Sprache in der Oberfläche frei).
 * Fehlende Schlüssel/Sprachen fallen auf die Kette aus languages.json ("fallback") zurück.
 */
class I18n {
    constructor() {
        this.config = { default: 'de', fallback: ['en', 'de'], languages: [] };
        this.translations = {};
        this.currentLanguage = 'de';
    }

    async init() {
        try {
            const r = await fetch('i18n/languages.json');
            if (r.ok) this.config = await r.json();
        } catch (e) { /* Standardkonfiguration */ }

        const enabled = this.enabledCodes();
        let lang = this.stored();
        if (!lang || !enabled.includes(lang)) lang = this.browserLanguage(enabled);
        this.currentLanguage = lang;

        await Promise.all([lang, ...this.config.fallback].map(l => this.loadLanguage(l)));
        this.renderSwitcher();
        this.updatePageLanguage();
    }

    enabledCodes() {
        return this.config.languages.filter(l => l.enabled).map(l => l.code);
    }

    // true, wenn für die Sprache Inhaltsseiten (pages/<code>/) vorhanden sind ("content": true in languages.json)
    hasContent(code) {
        const l = this.config.languages.find(x => x.code === code);
        return !!(l && l.content);
    }

    stored() {
        try { return localStorage.getItem('lmo-language'); } catch (e) { return null; }
    }

    browserLanguage(enabled) {
        const lang = (navigator.language || 'de').split('-')[0];
        return enabled.includes(lang) ? lang : this.config.default;
    }

    async setLanguage(lang) {
        try { localStorage.setItem('lmo-language', lang); } catch (e) { /* ignorieren */ }
        this.currentLanguage = lang;
        await this.loadLanguage(lang);
        this.updatePageLanguage();
        document.dispatchEvent(new CustomEvent('languageChanged', { detail: { language: lang } }));
    }

    async loadLanguage(lang) {
        if (this.translations[lang] !== undefined) return;
        try {
            const response = await fetch(`i18n/${lang}.json`);
            this.translations[lang] = response.ok ? await response.json() : null;
        } catch (e) {
            this.translations[lang] = null;
        }
    }

    lookup(lang, key) {
        let value = this.translations[lang];
        for (const k of key.split('.')) {
            if (value && typeof value === 'object' && k in value) value = value[k];
            else return undefined;
        }
        return typeof value === 'string' ? value : undefined;
    }

    t(key, defaultValue = key) {
        for (const lang of [this.currentLanguage, ...this.config.fallback]) {
            const v = this.lookup(lang, key);
            if (v !== undefined) return v;
        }
        return defaultValue;
    }

    renderSwitcher() {
        const langs = this.config.languages.filter(l => l.enabled);
        document.querySelectorAll('.lang-switch').forEach(box => {
            box.innerHTML = '';
            langs.forEach(l => {
                const b = document.createElement('button');
                b.type = 'button';
                b.className = 'btn btn-outline-light btn-sm language-btn';
                b.dataset.lang = l.code;
                b.title = l.name;
                b.setAttribute('aria-label', l.name);
                b.innerHTML = `<span class="fi fi-${l.flag}"></span>`;
                b.addEventListener('click', () => this.setLanguage(l.code));
                box.appendChild(b);
            });
        });
    }

    updatePageLanguage() {
        document.querySelectorAll('[data-i18n]').forEach(element => {
            const key = element.getAttribute('data-i18n');
            const translation = this.t(key, element.textContent);
            if (element.tagName === 'TITLE') {
                element.dataset.base = translation;
                if (!window.pageLoader || !window.pageLoader.pageTitle) document.title = translation;
            } else if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                element.placeholder = translation;
            } else {
                element.textContent = translation;
            }
        });
        document.querySelectorAll('.language-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === this.currentLanguage);
        });
        document.documentElement.lang = this.currentLanguage;
    }
}

window.i18n = new I18n();

class PageLoader {
    constructor() {
        this.contentArea = document.getElementById('content');
        this.currentPage = 'home';
        this.currentLanguage = window.i18n.currentLanguage;
        this.pageCache = {};

        this.pages = [
            'home',
            'docs',
            'getting-started',
            'options',
            'edit-league',
            'file-functions',
            'customization',
            'addons',
            'addon-betting-game',
            'addon-newsticker',
            'addon-mini-tables',
            'addon-mininext',
            'addon-player-stats',
            'addon-viewer',
            'addon-ics',
            'addon-api',
            'addon-club-schedule',
            'addon-team-comparison',
            'addon-team-schedule',
            'addon-pdf-schedule',
            'addon-top-tipper'
        ];

        this.addonPages = [
            'addon-betting-game',
            'addon-newsticker',
            'addon-mini-tables',
            'addon-mininext',
            'addon-player-stats',
            'addon-viewer',
            'addon-ics',
            'addon-api',
            'addon-club-schedule',
            'addon-team-comparison',
            'addon-team-schedule',
            'addon-pdf-schedule',
            'addon-top-tipper'
        ];

        this.addonSlugMap = {
            'addon-betting-game':    'betting-game',
            'addon-newsticker':      'newsticker',
            'addon-mini-tables':     'mini-tables',
            'addon-mininext':        'mininext',
            'addon-player-stats':    'player-stats',
            'addon-viewer':          'viewer',
            'addon-ics':             'ics',
            'addon-api':             'api',
            'addon-club-schedule':   'club-schedule',
            'addon-team-comparison': 'team-comparison',
            'addon-team-schedule':   'team-schedule',
            'addon-pdf-schedule':    'pdf-schedule',
            'addon-top-tipper':      'top-tipper'
        };

        this.pageSlugMap = {
            'home':            'home',     // → pages/{lang}/home.md
            'docs':            'index',    // → pages/{lang}/index.md
            'getting-started': 'getting-started',
            'options':         'options',
            'edit-league':     'edit-league',
            'file-functions':  'file-functions',
            'customization':   'customization',
            'addons':          'addons'    // → pages/{lang}/addons.md
        };

        this.init();
    }

    init() {
        var self = this;

        document.querySelectorAll('[data-page]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                self.loadPage(link.dataset.page);
            });
        });

        var toggle = document.getElementById('addons-toggle');
        if (toggle) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                if (self.isAddonsOpen()) {
                    // Already open: close the submenu (no page navigation)
                    self.closeAddons();
                } else {
                    // Closed: open submenu and load the addons overview page
                    self.openAddons();
                    self.loadPage('addons');
                }
            });
        }

        window.addEventListener('hashchange', function() {
            var t = self.parseHash(window.location.hash);
            if (t.page !== self.currentPage) self.loadPage(t.page, false, t.anchor, true);
            else if (t.anchor) self.scrollToAnchor(t.anchor);
        });

        // Links im Inhalt: "#seite", "#seite/anker" oder "#anker" (Anker auf der aktuellen Seite)
        this.contentArea.addEventListener('click', function(e) {
            var a = e.target.closest('a[href^="#"]');
            if (!a) return;
            e.preventDefault();
            var t = self.parseHash(a.getAttribute('href'), true);
            if (t.page === self.currentPage) {
                window.history.pushState(null, '', '#' + t.page + (t.anchor ? '/' + t.anchor : ''));
                self.scrollToAnchor(t.anchor);
            } else {
                self.loadPage(t.page, false, t.anchor);
            }
        });

        document.addEventListener('languageChanged', function(e) {
            self.currentLanguage = e.detail.language;
            self.loadPage(self.currentPage, true);
        });

        document.addEventListener('keydown', function(e) {
            if (!e.altKey) return;
            var map = {
                '1': 'home',
                '2': 'getting-started',
                '3': 'options',
                '4': 'edit-league',
                '5': 'file-functions',
                '6': 'customization',
                '7': 'addons'
            };
            if (map[e.key]) { self.loadPage(map[e.key]); e.preventDefault(); }
        });

        var t = this.parseHash(window.location.hash);
        this.loadPage(t.page, false, t.anchor, true);
    }

    // "#seite/anker" -> {page, anchor}; ein unbekannter erster Teil gilt als Anker der aktuellen Seite
    parseHash(hash, inContent) {
        var h = decodeURIComponent((hash || '').replace(/^#/, ''));
        var parts = h.split('/');
        if (this.pages.indexOf(parts[0]) !== -1) return { page: parts[0], anchor: parts.slice(1).join('/') };
        if (inContent && h) return { page: this.currentPage, anchor: h };
        return { page: 'home', anchor: '' };
    }

    scrollToAnchor(anchor) {
        var el = anchor ? document.getElementById(anchor) : null;
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        else window.scrollTo(0, 0);
    }

    static slug(text) {
        return text
            .toLowerCase()
            .replace(/[`*_]/g, '')
            .replace(/[äöüß]/g, function(c) { return {'ä':'ae','ö':'oe','ü':'ue','ß':'ss'}[c]; })
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    setPageTitle() {
        var h1 = this.contentArea.querySelector('h1');
        var base = (document.querySelector('title') || {}).dataset ? document.querySelector('title').dataset.base : '';
        this.pageTitle = h1 ? h1.textContent : '';
        document.title = (this.pageTitle ? this.pageTitle + ' – ' : '') + (base || 'LMO');
    }

    isAddonsOpen() {
        var s = document.getElementById('addons-submenu');
        return s && s.classList.contains('open');
    }

    openAddons() {
        var submenu = document.getElementById('addons-submenu');
        var toggle  = document.getElementById('addons-toggle');
        var chevron = toggle ? toggle.querySelector('.addon-chevron') : null;
        if (!submenu) return;
        submenu.classList.add('open');
        submenu.setAttribute('aria-hidden', 'false');
        if (toggle)  toggle.setAttribute('aria-expanded', 'true');
        if (chevron) chevron.classList.add('rotated');
    }

    closeAddons() {
        var submenu = document.getElementById('addons-submenu');
        var toggle  = document.getElementById('addons-toggle');
        var chevron = toggle ? toggle.querySelector('.addon-chevron') : null;
        if (!submenu) return;
        submenu.classList.remove('open');
        submenu.setAttribute('aria-hidden', 'true');
        if (toggle)  toggle.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.classList.remove('rotated');
    }

    toggleAddons() {
        this.isAddonsOpen() ? this.closeAddons() : this.openAddons();
    }

    async loadPage(page, forceReload, anchor, noPush) {
        if (this.pages.indexOf(page) === -1) page = 'home';

        var newHash = '#' + page + (anchor ? '/' + anchor : '');
        if (!noPush && window.location.hash !== newHash) window.history.pushState(null, '', newHash);

        var self = this;
        document.querySelectorAll('[data-page]').forEach(function(link) {
            link.classList.toggle('active', link.dataset.page === page);
        });

        var toggle = document.getElementById('addons-toggle');
        if (this.addonPages.indexOf(page) !== -1) {
            this.openAddons();
            if (toggle) toggle.classList.add('active');
        } else {
            if (toggle) toggle.classList.remove('active');
        }

        // Aktiven Eintrag in der (scrollbaren) Seitenleiste sichtbar halten
        setTimeout(function() {
            var act = document.querySelector('.sidebar-nav .addon-item.active');
            if (act && act.scrollIntoView) act.scrollIntoView({ block: 'nearest' });
        }, 50);

        this.contentArea.style.opacity = '0.5';

        try {
            var html = await this.fetchPage(page, forceReload);
            this.contentArea.innerHTML = html;
            this.contentArea.style.opacity = '1';
            this.currentPage = page;
            this.setPageTitle();
            window.i18n.updatePageLanguage();
            this.scrollToAnchor(anchor);
        } catch (err) {
            console.error('Error loading page:', err);
            this.contentArea.innerHTML =
                '<div class="alert alert-danger" role="alert">' +
                '<h4 class="alert-heading">Fehler beim Laden der Seite</h4>' +
                '<p>Die Seite konnte nicht geladen werden.</p>' +
                '<hr><p class="mb-0">' + err.message + '</p></div>';
            this.contentArea.style.opacity = '1';
        }
    }

    async fetchPage(page, forceReload) {
        var cacheKey = this.currentLanguage + '-' + page;
        if (!forceReload && this.pageCache[cacheKey]) return this.pageCache[cacheKey];

        var isAddon = this.addonPages.indexOf(page) !== -1;
        var slug    = isAddon ? this.addonSlugMap[page] : (this.pageSlugMap[page] || page);
        var dir     = isAddon
            ? 'pages/' + this.currentLanguage + '/addons'
            : 'pages/' + this.currentLanguage;
        var path    = dir + '/' + slug + '.md';

        // Inhalt: gewählte Sprache -> Standardsprache (de)
        var chain = [this.currentLanguage, window.i18n.config.default];
        var markdown = null;
        for (var i = 0; i < chain.length && markdown === null; i++) {
            if (chain.indexOf(chain[i]) !== i) continue;
            if (!window.i18n.hasContent(chain[i])) continue;
            var d = isAddon ? 'pages/' + chain[i] + '/addons' : 'pages/' + chain[i];
            markdown = await this.tryFetch(d + '/' + slug + '.md');
            if (markdown !== null && chain[i] !== this.currentLanguage) {
                markdown = '> ' + window.i18n.t('fallback_notice', 'Diese Seite ist in der gewählten Sprache noch nicht verfügbar.') + '\n\n' + markdown;
            }
        }

        if (markdown === null) {
            throw new Error('Seite nicht gefunden: ' + path);
        }

        var html = this.markdownToHtml(markdown);
        this.pageCache[cacheKey] = html;
        return html;
    }

    async tryFetch(path) {
        try {
            var r = await fetch(path);
            if (!r.ok) return null;
            return await r.text();
        } catch (e) {
            return null;
        }
    }

    markdownToHtml(markdown) {
        if (typeof marked !== 'undefined') {
            if (!this.markedReady) {
                marked.use({
                    renderer: {
                        heading: function(token) {
                            var text = token.text, depth = token.depth;
                            var id = PageLoader.slug(token.raw ? token.raw.replace(/^#+\s*/, '').replace(/\s*#*\s*$/, '') : text);
                            return '<h' + depth + ' id="' + id + '">' + this.parser.parseInline(token.tokens) + '</h' + depth + '>\n';
                        },
                        link: function(token) {
                            var href = token.href, title = token.title ? ' title="' + token.title + '"' : '';
                            var ext = /^https?:/i.test(href) ? ' target="_blank" rel="noopener"' : '';
                            return '<a href="' + href + '"' + title + ext + '>' + this.parser.parseInline(token.tokens) + '</a>';
                        },
                        table: function(token) {
                            var html = marked.Renderer.prototype.table.call(this, token);
                            return '<div class="table-responsive">' + html.replace('<table>', '<table class="table table-sm table-bordered">') + '</div>';
                        },
                        image: function(token) {
                            return '<img src="' + token.href + '" alt="' + (token.text || '') + '" class="img-fluid border rounded my-2 zoomable" tabindex="0" loading="lazy">';
                        }
                    }
                });
                this.markedReady = true;
            }
            return marked.parse(markdown);
        }

        var html = markdown
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        html = html.replace(/^### (.+?)$/gm, '<h3>$1</h3>');
        html = html.replace(/^## (.+?)$/gm,  '<h2>$1</h2>');
        html = html.replace(/^# (.+?)$/gm,   '<h1>$1</h1>');
        html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/\*(.+?)\*/g,     '<em>$1</em>');
        html = html.replace(/```([\s\S]*?)```/g, '<pre><code>$1</code></pre>');
        html = html.replace(/`([^`]+)`/g,     '<code>$1</code>');
        html = html.replace(/\[(.+?)\]\((.+?)\)/g, '<a href="$2" target="_blank">$1</a>');
        html = html.replace(/^[-*] (.+?)$/gm, '<li>$1</li>');
        html = html.replace(/(<li>[\s\S]*?<\/li>)/g, '<ul>$1</ul>');
        html = html.replace(/^\d+\. (.+?)$/gm, '<li>$1</li>');
        html = html.replace(/\n\n/g, '</p><p>');
        html = '<p>' + html + '</p>';
        html = html.replace(/<p>\s*(<h[1-6])/g, '$1');
        html = html.replace(/(<\/h[1-6]>)\s*<\/p>/g, '$1');
        html = html.replace(/<p>\s*<ul>/g, '<ul>');
        html = html.replace(/<\/ul>\s*<\/p>/g, '</ul>');
        html = html.replace(/<p>\s*<pre>/g, '<pre>');
        html = html.replace(/<\/pre>\s*<\/p>/g, '</pre>');
        return html;
    }
}

document.addEventListener('DOMContentLoaded', async function() {
    await window.i18n.init();
    window.pageLoader = new PageLoader();
});

/* Lightbox: Klick auf eingebettete Grafiken zeigt sie vergrößert über der Seite */
(function () {
    let box = null;
    function close() {
        if (box) { box.remove(); box = null; document.body.classList.remove('lightbox-open'); }
    }
    function open(img) {
        close();
        box = document.createElement('div');
        box.className = 'lightbox';
        box.setAttribute('role', 'dialog');
        box.setAttribute('aria-modal', 'true');
        const big = document.createElement('img');
        big.src = img.currentSrc || img.src;
        big.alt = img.alt || '';
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'lightbox-close';
        btn.setAttribute('aria-label', 'Close');
        btn.innerHTML = '&times;';
        box.append(big, btn);
        if (img.alt) {
            const cap = document.createElement('div');
            cap.className = 'lightbox-caption';
            cap.textContent = img.alt;
            box.append(cap);
        }
        box.addEventListener('click', close);
        document.body.append(box);
        document.body.classList.add('lightbox-open');
        btn.focus();
    }
    document.addEventListener('click', function (e) {
        const img = e.target.closest && e.target.closest('#content img');
        if (img) { e.preventDefault(); open(img); }
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') close();
        else if ((e.key === 'Enter' || e.key === ' ') && e.target.matches && e.target.matches('#content img')) {
            e.preventDefault(); open(e.target);
        }
    });
    window.addEventListener('hashchange', close);
})();

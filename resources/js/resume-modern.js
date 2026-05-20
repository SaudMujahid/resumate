import Alpine from 'alpinejs';

Alpine.data('resumeApp', () => ({
    hue: 220,
    customColor: '#2563eb',
    atsMode: false,
    fontFamily: 'sans',
    spacing: 'normal',
    sidebarWidth: 260,
    presets: [220, 162, 270, 340, 25, 195],

    get fontClass() {
        if (this.atsMode) return 'font-ats';
        return {
            sans: 'font-sans-custom',
            serif: 'font-serif-custom',
            mono: 'font-mono-custom',
        }[this.fontFamily] || 'font-sans-custom';
    },

    get spacingClasses() {
        const map = {
            compact: { sidebar: 'p-6 gap-6', main: 'p-8', section: 'mb-5' },
            normal: { sidebar: 'p-8 gap-8', main: 'p-10', section: 'mb-6' },
            spacious: { sidebar: 'p-10 gap-10', main: 'p-12', section: 'mb-8' },
        };
        return map[this.spacing] || map.normal;
    },

    get layoutStyle() {
        if (this.atsMode) {
            return 'max-width: 800px; display: block;';
        }
        return `max-width: 860px; display: grid; grid-template-columns: ${this.sidebarWidth}px 1fr;`;
    },

    init() {
        const saved = localStorage.getItem('resumeSettings_modern');
        if (!saved) return;

        try {
            const s = JSON.parse(saved);
            this.hue = s.hue ?? 220;
            this.atsMode = s.atsMode ?? false;
            this.fontFamily = s.fontFamily ?? 'sans';
            this.spacing = s.spacing ?? 'normal';
            this.sidebarWidth = s.sidebarWidth ?? 260;
            this.customColor = s.customColor ?? '#2563eb';
        } catch {
            // ignore corrupt localStorage
        }
    },

    saveSettings() {
        localStorage.setItem('resumeSettings_modern', JSON.stringify({
            hue: this.hue,
            atsMode: this.atsMode,
            fontFamily: this.fontFamily,
            spacing: this.spacing,
            sidebarWidth: this.sidebarWidth,
            customColor: this.customColor,
        }));
    },

    setHue(h) {
        this.hue = h;
        this.saveSettings();
    },

    updateCustomColor() {
        const hex = this.customColor;
        const r = parseInt(hex.slice(1, 3), 16) / 255;
        const g = parseInt(hex.slice(3, 5), 16) / 255;
        const b = parseInt(hex.slice(5, 7), 16) / 255;
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        let h = 0;
        if (max !== min) {
            const d = max - min;
            if (max === r) h = ((g - b) / d + (g < b ? 6 : 0)) * 60;
            else if (max === g) h = ((b - r) / d + 2) * 60;
            else h = ((r - g) / d + 4) * 60;
        }
        this.hue = Math.round(h);
        this.saveSettings();
    },

    initials(name) {
        if (!name) return '';
        const parts = name.trim().split(/\s+/).filter(Boolean);
        if (parts.length === 1) return parts[0][0]?.toUpperCase() || '';
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    },
}));

window.Alpine = Alpine;
Alpine.start();

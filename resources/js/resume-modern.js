import Alpine from "alpinejs";

Alpine.data("resumeApp", () => ({
    resume: {},
    roleTitle: "",
    hue: 220,
    customColor: "#2563eb",
    atsMode: false,
    fontFamily: "sans",
    spacing: "normal",
    spacingMultiplier: 1.0,
    autoSpace: true,
    sidebarWidth: 260,
    presets: [220, 162, 270, 340, 25, 195],

    fillPercentage: 100,
    isOverflowing: false,
    isUnderflowing: false,

    get fontClass() {
        if (this.atsMode) return "font-ats";
        return (
            {
                sans: "font-sans-custom",
                serif: "font-serif-custom",
                mono: "font-mono-custom",
            }[this.fontFamily] || "font-sans-custom"
        );
    },

    get spacingClasses() {
        const map = {
            compact: { sidebar: "p-5 gap-4", main: "p-6", section: "mb-4" },
            normal: { sidebar: "p-7 gap-6", main: "p-8", section: "mb-6" },
            spacious: { sidebar: "p-9 gap-8", main: "p-10", section: "mb-8" },
        };
        return map[this.spacing] || map.normal;
    },

    get layoutStyle() {
        if (this.atsMode) {
            return "max-width: 800px; display: block;";
        }
        return `max-width: 860px; display: grid; grid-template-columns: ${this.sidebarWidth}px 1fr;`;
    },

    init(initialResume) {
        if (initialResume) {
            this.resume = initialResume;

            // Initial headline calculation
            if (this.resume.experiences && this.resume.experiences[0]) {
                this.roleTitle = this.resume.experiences[0].title || "";
            } else if (this.resume.educations && this.resume.educations[0]) {
                this.roleTitle = this.resume.educations[0].degree || "";
            } else {
                this.roleTitle = "Professional";
            }
        }

        const saved = localStorage.getItem(
            "resumeSettings_readymade_modern_v2",
        );
        if (saved) {
            try {
                const s = JSON.parse(saved);
                this.hue = s.hue ?? 220;
                this.atsMode = s.atsMode ?? false;
                this.fontFamily = s.fontFamily ?? "sans";
                this.spacing = s.spacing ?? "normal";
                this.spacingMultiplier = s.spacingMultiplier ?? 1.0;
                this.autoSpace = s.autoSpace ?? true;
                this.sidebarWidth = s.sidebarWidth ?? 260;
                this.customColor = s.customColor ?? "#2563eb";
                if (s.resume) this.resume = s.resume;
            } catch {
                // ignore corrupt localStorage
            }
        }

        setTimeout(() => this.calculateA4Fit(), 300);
    },

    saveSettings() {
        localStorage.setItem(
            "resumeSettings_readymade_modern_v2",
            JSON.stringify({
                hue: this.hue,
                atsMode: this.atsMode,
                fontFamily: this.fontFamily,
                spacing: this.spacing,
                spacingMultiplier: this.spacingMultiplier,
                autoSpace: this.autoSpace,
                sidebarWidth: this.sidebarWidth,
                customColor: this.customColor,
                resume: this.resume,
            }),
        );
    },

    setHue(h) {
        this.hue = h;
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
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
        this.$nextTick(() => this.calculateA4Fit());
    },

    initials(name) {
        if (!name) return "";
        const parts = name.trim().split(/\s+/).filter(Boolean);
        if (parts.length === 1) return parts[0][0]?.toUpperCase() || "";
        return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
    },

    // In-sheet operations
    addExperience() {
        if (!this.resume.experiences) this.resume.experiences = [];
        this.resume.experiences.push({
            title: "Role / Focus",
            company: "Company Name",
            duration: "Period",
            bullets: ["Responsibility bullet point."],
        });
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delExperience(idx) {
        this.resume.experiences.splice(idx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    addExperienceBullet(expIdx) {
        if (!this.resume.experiences[expIdx].bullets) {
            this.resume.experiences[expIdx].bullets = [];
        }
        this.resume.experiences[expIdx].bullets.push(
            "New key milestone achievement.",
        );
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delExperienceBullet(expIdx, bIdx) {
        this.resume.experiences[expIdx].bullets.splice(bIdx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },

    addEducation() {
        if (!this.resume.educations) this.resume.educations = [];
        this.resume.educations.push({
            level: "Higher Education",
            degree: "Degree Program",
            school: "Institution",
            year: "2025",
            cgpa: "4.00",
        });
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delEducation(idx) {
        this.resume.educations.splice(idx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },

    addTechSkill() {
        if (!this.resume.skills) this.resume.skills = {};
        if (!this.resume.key_skills) this.resume.key_skills = [];
        this.resume.key_skills.push("Skill Item");
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delTechSkill(idx) {
        this.resume.key_skills.splice(idx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },

    addSoftSkill() {
        if (!this.resume.skills) this.resume.skills = {};
        if (!this.resume.additional_skills) this.resume.additional_skills = [];
        this.resume.additional_skills.push("Core Competency");
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delSoftSkill(idx) {
        this.resume.additional_skills.splice(idx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },

    addLang() {
        if (!this.resume.skills) this.resume.skills = {};
        if (!this.resume.skills.languages) this.resume.skills.languages = [];
        this.resume.skills.languages.push("Language");
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },
    delLang(idx) {
        this.resume.skills.languages.splice(idx, 1);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
    },

    calculateA4Fit() {
        const wrapper = document.getElementById("resume-surface-wrapper");
        if (!wrapper) return;

        const aside = wrapper.querySelector("aside");
        const main = wrapper.querySelector("main");

        if (!aside || !main) return;

        aside.style.justifyContent = "flex-start";
        main.style.justifyContent = "flex-start";

        const asideHeight = aside.scrollHeight;
        const mainHeight = main.scrollHeight;
        const maxContentHeight = Math.max(asideHeight, mainHeight);

        if (this.autoSpace) {
            aside.style.justifyContent = "space-between";
            main.style.justifyContent = "space-between";
        }

        const a4MaxHeightPx = wrapper.offsetHeight || 1123;
        const fill = Math.round((maxContentHeight / a4MaxHeightPx) * 100);

        this.fillPercentage = fill;
        this.isOverflowing = fill > 100;
        this.isUnderflowing = fill < 88;
    },
}));

window.Alpine = Alpine;
Alpine.start();

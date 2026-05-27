<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>

@vite(['resources/css/app.css', 'resources/js/resume-modern.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>
    [x-cloak] { display: none !important; }

    /* Absolute A4 Dimensions */
    .resume-shadow {
        width: 210mm;
        height: 297mm;
        min-height: 297mm;
        max-height: 297mm;
        box-shadow: 0 12px 60px rgba(0, 0, 0, 0.22);
    }

    aside, main {
        height: 100% !important;
        box-sizing: border-box !important;
    }

    .font-ats { font-family: Arial, Helvetica, sans-serif !important; }
    .font-sans-custom { font-family: 'DM Sans', sans-serif !important; }
    .font-serif-custom { font-family: 'DM Serif Display', serif !important; }
    .font-mono-custom { font-family: 'Courier New', monospace !important; }

    /* Visual hover controls styles */
    .item-wrapper {
        position: relative;
        transition: all 0.2s ease;
    }
    .no-print { user-select: none; }
    @media screen {
        .item-wrapper:hover {
            background-color: rgba(79, 70, 229, 0.04);
            box-shadow: 0 0 0 6px rgba(79, 70, 229, 0.04);
            border-radius: 4px;
        }
        .visual-handle-bar {
            position: absolute;
            left: -32px;
            top: 0;
            display: none;
            flex-direction: column;
            gap: 3px;
            z-index: 50;
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-radius: 6px;
            padding: 3px;
        }
        .item-wrapper:hover .visual-handle-bar {
            display: flex;
        }
        .handle-btn {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: none;
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            transition: all 0.15s;
        }
        .handle-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .handle-btn.btn-del:hover {
            background: #fee2e2;
            color: #ef4444;
        }
    }

    [contenteditable] { outline: none; border-radius: 2px; transition: background .12s; cursor: text; }
    [contenteditable]:hover { background: rgba(79, 70, 229, 0.08); }
    [contenteditable]:focus { background: rgba(79, 70, 229, 0.12); outline: 1px dashed hsl(220,70%,45%); }

    @media print {
        .no-print, .visual-handle-bar { display: none !important; }
        body { background: white !important; padding: 0 !important; }
        .resume-shadow { box-shadow: none !important; width: 210mm !important; height: 297mm !important; }
        .resume-page-wrap { padding: 0 !important; }
        [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
    }
</style>
</head>
<body class="bg-gray-100 min-h-screen font-sans-custom"
      x-data="resumeApp()"
      x-init="init(@js($resume))"
      :class="fontClass">

    <x-resume-toolbar template="modern" />

    <div class="pt-24 pb-12 px-4 resume-page-wrap">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300"
             id="resume-surface-wrapper"
             :style="layoutStyle">

            {{-- Sidebar --}}
            <aside class="text-white flex flex-col"
                   :class="atsMode ? 'hidden' : ''"
                   :style="`background: hsl(${hue}, 40%, 14%); justify-content: ${autoSpace ? 'space-between' : 'flex-start'}; gap: ${autoSpace ? '0px' : '24px'};` + (spacing === 'compact' ? 'padding:12mm 5mm;' : (spacing === 'spacious' ? 'padding:22mm 9mm;' : 'padding:16mm 7mm;'))">

                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl text-white font-serif-custom shadow-lg"
                         :style="`background: hsl(${hue}, 70%, 45%)`"
                         x-text="initials(resume.name)">
                    </div>
                    <h2 class="font-serif-custom text-lg text-center leading-tight mt-1" contenteditable="true" @blur="resume.name = $el.innerText; calculateA4Fit()" x-text="resume.name"></h2>
                    <p class="text-[10px] uppercase tracking-widest text-center font-medium opacity-80" contenteditable="true" @blur="roleTitle = $el.innerText; calculateA4Fit()" x-text="roleTitle"></p>
                </div>

                <!-- Contacts -->
                <div class="space-y-2">
                    <h3 class="text-[9px] font-bold uppercase tracking-[0.15em] pb-1.5 border-b border-white/10 opacity-70">Contact</h3>
                    <div class="text-xs opacity-90 break-all" contenteditable="true" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></div>
                    <template x-if="resume.phone">
                      <div class="text-xs opacity-90" contenteditable="true" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></div>
                    </template>
                    <template x-if="resume.city">
                      <div class="text-xs opacity-90" contenteditable="true" @blur="resume.city = $el.innerText; calculateA4Fit()" x-text="resume.city"></div>
                    </template>
                </div>

                <!-- Technical Skills -->
                <div class="space-y-2">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-b:1px solid rgba(255,255,255,0.1); padding-bottom:4px;">
                      <h3 class="text-[9px] font-bold uppercase tracking-[0.15em] opacity-70">Skills</h3>
                      <button class="no-print handle-btn" @click="addTechSkill()" style="font-size:8px; border:1px dashed rgba(255,255,255,0.3); width:auto; padding:0 4px; color:white;">+ Add</button>
                    </div>
                    <div class="space-y-2">
                        <template x-for="(skill, sIdx) in resume.skills.technical" :key="sIdx">
                            <div class="group/skill">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                  <div class="text-[11px] opacity-90" contenteditable="true" @blur="resume.skills.technical[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></div>
                                  <button class="no-print handle-btn btn-del" @click="delTechSkill(sIdx)" style="width:12px; height:12px; font-size:8px; color:white;">×</button>
                                </div>
                                <div class="h-0.5 bg-white/10 rounded-full overflow-hidden mt-1">
                                    <div class="h-full rounded-full transition-all duration-500" :style="`width: ${Math.max(60, 100 - (sIdx * 8))}%; background: hsl(${hue}, 70%, 65%)`"></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Soft Skills -->
                <div class="space-y-2" x-show="resume.skills.soft && resume.skills.soft.length > 0">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-b:1px solid rgba(255,255,255,0.1); padding-bottom:4px;">
                      <h3 class="text-[9px] font-bold uppercase tracking-[0.15em] opacity-70">Strengths</h3>
                      <button class="no-print handle-btn" @click="addSoftSkill()" style="font-size:8px; border:1px dashed rgba(255,255,255,0.3); width:auto; padding:0 4px; color:white;">+ Add</button>
                    </div>
                    <ul class="space-y-1 text-xs opacity-90">
                        <template x-for="(skill, sIdx) in resume.skills.soft" :key="sIdx">
                            <li class="group/soft" style="display:flex; justify-content:space-between; align-items:center;">
                                <span contenteditable="true" @blur="resume.skills.soft[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                                <button class="no-print handle-btn btn-del" @click="delSoftSkill(sIdx)" style="width:12px; height:12px; font-size:8px; color:white;">×</button>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Languages -->
                <div class="space-y-2" x-show="resume.skills.languages && resume.skills.languages.length > 0">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-b:1px solid rgba(255,255,255,0.1); padding-bottom:4px;">
                      <h3 class="text-[9px] font-bold uppercase tracking-[0.15em] opacity-70">Languages</h3>
                      <button class="no-print handle-btn" @click="addLang()" style="font-size:8px; border:1px dashed rgba(255,255,255,0.3); width:auto; padding:0 4px; color:white;">+ Add</button>
                    </div>
                    <div class="space-y-1">
                        <template x-for="(lang, lIdx) in resume.skills.languages" :key="lIdx">
                            <div class="flex justify-between items-center text-xs opacity-90 group/lang">
                                <span contenteditable="true" @blur="resume.skills.languages[lIdx] = $el.innerText; calculateA4Fit()" x-text="lang"></span>
                                <span style="display:flex; align-items:center; gap:4px;">
                                  <span class="text-[10px] opacity-60" x-text="lIdx === 0 ? 'Native' : (lIdx === 1 ? 'Fluent' : 'Intermediate')"></span>
                                  <button class="no-print handle-btn btn-del" @click="delLang(lIdx)" style="width:12px; height:12px; font-size:8px; color:white;">×</button>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </aside>

            {{-- Main Column --}}
            <main class="bg-white flex flex-col"
                  :class="atsMode ? 'max-w-[800px] mx-auto p-10' : ''"
                  :style="`justify-content: ${autoSpace ? 'space-between' : 'flex-start'}; gap: ${autoSpace ? '0px' : '24px'};` + (spacing === 'compact' ? 'padding:12mm 6mm;' : (spacing === 'spacious' ? 'padding:22mm 10mm;' : 'padding:16mm 8mm;'))">

                <!-- Header Identity Details -->
                <div class="border-b-2 border-gray-800 pb-3">
                    <h1 class="text-2xl leading-tight text-gray-900 font-serif-custom" contenteditable="true" @blur="resume.name = $el.innerText; calculateA4Fit()" x-text="resume.name"></h1>
                    <p class="text-[11px] uppercase tracking-wide mt-1 font-semibold text-gray-600" contenteditable="true" @blur="roleTitle = $el.innerText; calculateA4Fit()" x-text="roleTitle"></p>
                </div>

                <!-- Professional Summary -->
                <div x-show="resume.summary" class="item-wrapper">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] flex items-center gap-2 mb-2 text-gray-700">
                        Professional Summary
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </h3>
                    <p class="text-xs leading-relaxed text-gray-600" contenteditable="true" @blur="resume.summary = $el.innerText; calculateA4Fit()" x-text="resume.summary"></p>
                </div>

                <!-- Work Experience Timeline -->
                <div x-show="resume.experience && resume.experience.length > 0">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                      <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] flex items-center gap-2 text-gray-700" style="flex:1;">
                          Experience
                          <span class="flex-1 h-px bg-gray-200"></span>
                      </h3>
                      <button class="no-print handle-btn" @click="addJob()" style="font-size:8px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add Job</button>
                    </div>
                    
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <template x-for="(exp, expIdx) in resume.experience" :key="expIdx">
                            <div class="item-wrapper group/item">
                                
                                <!-- Hover handles -->
                                <div class="no-print visual-handle-bar">
                                  <button class="handle-btn btn-del" @click="delJob(expIdx)" title="Delete Job">×</button>
                                </div>

                                <div class="flex justify-between items-start mb-0.5 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-xs" contenteditable="true" @blur="exp.title = $el.innerText; calculateA4Fit()" x-text="exp.title"></h4>
                                        <p class="text-[11px] font-medium text-gray-600" contenteditable="true" @blur="exp.company = $el.innerText; calculateA4Fit()" x-text="exp.company"></p>
                                    </div>
                                    <div style="display:flex; align-items:center; gap:4px;">
                                      <span class="text-[9px] px-2 py-0.5 rounded-full text-white font-medium whitespace-nowrap bg-gray-800" contenteditable="true" @blur="exp.duration = $el.innerText; calculateA4Fit()" x-text="exp.duration"></span>
                                    </div>
                                </div>
                                
                                <!-- Bullet lists -->
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:2px;">
                                  <span class="no-print"></span>
                                  <button class="no-print handle-btn" @click="addBullet(expIdx)" style="font-size:7px; border:1px dashed #e2e8f0; width:auto; padding:0 3px;">+ Bullet</button>
                                </div>
                                <ul class="mt-1 space-y-1">
                                    <template x-for="(resp, rIdx) in exp.responsibilities" :key="rIdx">
                                        <li class="text-xs text-gray-600 pl-4 relative group/bullet">
                                            <span class="absolute left-0 text-[10px] mt-0.5 text-gray-800">▸</span>
                                            <span contenteditable="true" @blur="exp.responsibilities[rIdx] = $el.innerText; calculateA4Fit()" x-text="resp"></span>
                                            <button class="no-print handle-btn btn-del" @click="delBullet(expIdx, rIdx)" style="display:inline-flex; width:12px; height:12px; font-size:7px; vertical-align:middle; margin-left:4px;">×</button>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Academic Background -->
                <div x-show="resume.education && resume.education.length > 0">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                      <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] flex items-center gap-2 text-gray-700" style="flex:1;">
                          Education
                          <span class="flex-1 h-px bg-gray-200"></span>
                      </h3>
                      <button class="no-print handle-btn" @click="addEdu()" style="font-size:8px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add Edu</button>
                    </div>
                    
                    <div style="display:flex; flex-direction:column; gap:12px;">
                        <template x-for="(edu, eduIdx) in resume.education" :key="eduIdx">
                            <div class="flex gap-2 item-wrapper group/item">
                                
                                <div class="no-print visual-handle-bar">
                                  <button class="handle-btn btn-del" @click="delEdu(eduIdx)" title="Delete Academy">×</button>
                                </div>

                                <div class="w-2 h-2 rounded-full mt-1 shrink-0 bg-gray-800"></div>
                                <div style="flex:1;">
                                    <h4 class="font-semibold text-gray-900 text-xs">
                                        <span contenteditable="true" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></span>
                                        <template x-if="edu.major">
                                          <span class="font-normal text-gray-600"> in <span contenteditable="true" @blur="edu.major = $el.innerText; calculateA4Fit()" x-text="edu.major"></span></span>
                                        </template>
                                    </h4>
                                    <p class="text-[11px] text-gray-500 mt-0.5">
                                        <span contenteditable="true" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></span> &nbsp;·&nbsp; 
                                        <span contenteditable="true" @blur="edu.year = $el.innerText; calculateA4Fit()" x-text="edu.year"></span>
                                    </p>
                                    <div style="margin-top:2px;">
                                        <span class="inline-block text-[9px] font-medium text-white px-2 py-0.5 rounded-full bg-gray-700" contenteditable="true" @blur="edu.cgpa = $el.innerText; calculateA4Fit()" x-text="edu.cgpa ? 'CGPA ' + edu.cgpa : (edu.grade ? 'GPA ' + edu.grade : 'GPA N/A')"></span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Script acts as local fallback and guarantees immediate reactivity on page -->
    <script>
    if (!window.resumeApp) {
        // Ensure local function is accessible if Alpine is loaded purely locally
        window.resumeApp = function() {
            return {
                resume: {},
                roleTitle: '',
                hue: 220,
                customColor: '#2563eb',
                atsMode: false,
                fontFamily: 'sans',
                spacing: 'normal',
                spacingMultiplier: 1.0,
                autoSpace: true,
                sidebarWidth: 260,
                presets: [220, 162, 270, 340, 25, 195],
                
                fillPercentage: 100,
                isOverflowing: false,
                isUnderflowing: false,

                get fontClass() {
                    return {
                        sans: 'font-sans-custom',
                        serif: 'font-serif-custom',
                        mono: 'font-mono-custom'
                    }[this.fontFamily] || 'font-sans-custom';
                },

                get spacingClasses() {
                    const map = {
                        compact: { sidebar: 'p-5 gap-4', main: 'p-6' },
                        normal: { sidebar: 'p-7 gap-6', main: 'p-8' },
                        spacious: { sidebar: 'p-9 gap-8', main: 'p-10' }
                    };
                    return map[this.spacing] || map.normal;
                },

                get layoutStyle() {
                    if (this.atsMode) return 'max-width: 800px; display: block;';
                    return `max-width: 860px; display: grid; grid-template-columns: ${this.sidebarWidth}px 1fr;`;
                },

                init(initialResume) {
                    if (initialResume) {
                        this.resume = initialResume;
                        if (this.resume.experience && this.resume.experience[0]) {
                            this.roleTitle = this.resume.experience[0].title || '';
                        } else if (this.resume.education && this.resume.education[0]) {
                            this.roleTitle = this.resume.education[0].degree || '';
                        } else {
                            this.roleTitle = 'Professional';
                        }
                    }

                    const saved = localStorage.getItem('resumeSettings_modern');
                    if (saved) {
                        try {
                            const s = JSON.parse(saved);
                            this.hue = s.hue ?? 220;
                            this.atsMode = s.atsMode ?? false;
                            this.fontFamily = s.fontFamily ?? 'sans';
                            this.spacing = s.spacing ?? 'normal';
                            this.spacingMultiplier = s.spacingMultiplier ?? 1.0;
                            this.autoSpace = s.autoSpace ?? true;
                            this.sidebarWidth = s.sidebarWidth ?? 260;
                            this.customColor = s.customColor ?? '#2563eb';
                            if (s.resume) this.resume = s.resume;
                        } catch(e) {}
                    }

                    setTimeout(() => this.calculateA4Fit(), 300);
                },

                saveSettings() {
                    localStorage.setItem('resumeSettings_modern', JSON.stringify({
                        hue: this.hue,
                        atsMode: this.atsMode,
                        fontFamily: this.fontFamily,
                        spacing: this.spacing,
                        spacingMultiplier: this.spacingMultiplier,
                        autoSpace: this.autoSpace,
                        sidebarWidth: this.sidebarWidth,
                        customColor: this.customColor,
                        resume: this.resume
                    }));
                },

                addJob() {
                    if (!this.resume.experience) this.resume.experience = [];
                    this.resume.experience.push({
                        title: 'Role / Focus',
                        company: 'Company Name',
                        duration: 'Period',
                        responsibilities: ['Responsibility bullet point.']
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delJob(idx) {
                    this.resume.experience.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                addBullet(expIdx) {
                    if (!this.resume.experience[expIdx].responsibilities) {
                        this.resume.experience[expIdx].responsibilities = [];
                    }
                    this.resume.experience[expIdx].responsibilities.push('New key milestone achievement.');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delBullet(expIdx, bIdx) {
                    this.resume.experience[expIdx].responsibilities.splice(bIdx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addEdu() {
                    if (!this.resume.education) this.resume.education = [];
                    this.resume.education.push({
                        level: 'Higher Education',
                        degree: 'Degree Program',
                        school: 'Institution',
                        year: '2025',
                        cgpa: '4.00'
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delEdu(idx) {
                    this.resume.education.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addTechSkill() {
                    this.resume.skills.technical.push('Skill Item');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delTechSkill(idx) {
                    this.resume.skills.technical.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addSoftSkill() {
                    this.resume.skills.soft.push('Core Competency');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delSoftSkill(idx) {
                    this.resume.skills.soft.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addLang() {
                    this.resume.skills.languages.push('Language');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },
                delLang(idx) {
                    this.resume.skills.languages.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                initials(name) {
                    if (!name) return '';
                    const parts = name.trim().split(/\s+/).filter(Boolean);
                    if (parts.length === 1) return parts[0][0]?.toUpperCase() || '';
                    return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
                },

                calculateA4Fit() {
                    const wrapper = document.getElementById('resume-surface-wrapper');
                    if (!wrapper) return;
                    
                    const aside = wrapper.querySelector('aside');
                    const main = wrapper.querySelector('main');
                    
                    if (!aside || !main) return;
                    
                    aside.style.justifyContent = 'flex-start';
                    main.style.justifyContent = 'flex-start';
                    
                    const asideHeight = aside.scrollHeight;
                    const mainHeight = main.scrollHeight;
                    const maxContentHeight = Math.max(asideHeight, mainHeight);
                    
                    if (this.autoSpace) {
                        aside.style.justifyContent = 'space-between';
                        main.style.justifyContent = 'space-between';
                    }

                    const a4MaxHeightPx = wrapper.offsetHeight || 1123;
                    const fill = Math.round((maxContentHeight / a4MaxHeightPx) * 100);
                    
                    this.fillPercentage = fill;
                    this.isOverflowing = fill > 100;
                    this.isUnderflowing = fill < 88;
                }
            };
        };
    }
    </script>
</body>
</html>

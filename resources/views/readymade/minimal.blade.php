<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ ($resumeData['first_name'] ?? '') . ' ' . ($resumeData['last_name'] ?? '') }} — Resume</title>

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

    .font-ats { font-family: Arial, Helvetica, sans-serif !important; }
    .font-sans-custom { font-family: 'DM Sans', sans-serif !important; }
    .font-serif-custom { font-family: 'DM Serif Display', serif !important; }
    .font-mono-custom { font-family: 'Courier New', monospace !important; }

    /* Visual controls on hover */
    .item-wrapper {
        position: relative;
        transition: all 0.2s ease;
    }
    .no-print { user-select: none; }
    @media screen {
        .item-wrapper:hover {
            background-color: rgba(109, 40, 217, 0.03);
            box-shadow: 0 0 0 6px rgba(109, 40, 217, 0.03);
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
    [contenteditable]:hover { background: rgba(109, 40, 217, 0.08); }
    [contenteditable]:focus { background: rgba(109, 40, 217, 0.12); outline: 1px dashed hsl(270,70%,45%); }

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
      x-init="init(@js($resumeData))"
      :class="fontClass">

    <x-resume-toolbar template="modern" />

    <div class="pt-24 pb-12 px-4 resume-page-wrap">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300 flex flex-col justify-between"
             id="resume-surface-wrapper"
             :style="`padding: ${spacing === 'compact' ? '10mm 12mm' : (spacing === 'spacious' ? '18mm 20mm' : '14mm 16mm')}; font-size: ${spacing === 'compact' ? '11px' : (spacing === 'spacious' ? '13px' : '12px')}`">

            <!-- Core Header Identity Details -->
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-wider uppercase"
                    :style="`color: hsl(${hue}, 50%, 35%)`"
                    contenteditable="true"
                    @blur="updateName($el.innerText); calculateA4Fit()"
                    x-text="(resume.first_name || '') + ' ' + (resume.last_name || '')">
                </h1>

                <!-- Centered Contact details matching sample layout -->
                <div class="text-center text-xs text-gray-700 mt-2 font-medium flex flex-wrap justify-center items-center gap-1.5">
                    <span contenteditable="true" @blur="resume.address = $el.innerText; calculateA4Fit()" x-text="resume.address"></span>
                    <span class="text-gray-400">•</span>
                    <span contenteditable="true" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></span>
                    <span class="text-gray-400">•</span>
                    <span contenteditable="true" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></span>
                </div>
                <div class="text-center text-xs mt-1 font-medium text-gray-600" x-show="resume.website">
                    <span contenteditable="true" @blur="resume.website = $el.innerText; calculateA4Fit()" x-text="resume.website"></span>
                </div>
            </div>

            <!-- Horizontal Divider -->
            <hr class="border-t-2" :style="`border-color: hsl(${hue}, 40%, 85%); margin-top: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}; margin-bottom: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}`" />

            <!-- Professional Summary -->
            <div x-show="resume.summary" class="item-wrapper">
                <h2 class="text-xs font-bold uppercase tracking-widest mb-1" :style="`color: hsl(${hue}, 50%, 35%)`">Summary</h2>
                <p class="text-gray-700 leading-relaxed text-justify" contenteditable="true" @blur="resume.summary = $el.innerText; calculateA4Fit()" x-text="resume.summary"></p>
            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 40%, 90%); margin-top: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}; margin-bottom: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}`" />

            <!-- Work Experience -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Work Experience</h2>
                    <button class="no-print handle-btn text-[10px]" @click="addExperience()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Role</button>
                </div>

                <div class="space-y-4">
                    <template x-for="(exp, expIdx) in resume.experiences" :key="expIdx">
                        <div class="item-wrapper group/item relative">

                            <!-- Actions on Hover -->
                            <div class="no-print visual-handle-bar">
                                <button class="handle-btn btn-del" @click="delExperience(expIdx)" title="Delete Job">×</button>
                            </div>

                            <!-- Title on left, duration on right -->
                            <div class="flex justify-between items-start font-medium text-xs">
                                <div class="text-gray-900">
                                    <span class="font-bold" contenteditable="true" @blur="exp.title = $el.innerText; calculateA4Fit()" x-text="exp.title"></span>
                                    <span class="text-gray-400 font-normal">, </span>
                                    <span class="font-semibold text-gray-700" contenteditable="true" @blur="exp.company = $el.innerText; calculateA4Fit()" x-text="exp.company"></span>
                                </div>
                                <span class="text-gray-600 font-bold whitespace-nowrap" contenteditable="true" @blur="exp.period = $el.innerText; calculateA4Fit()" x-text="exp.period"></span>
                            </div>

                            <!-- Milestone Bullets -->
                            <ul class="list-disc pl-5 mt-1 space-y-0.5 text-gray-700">
                                <template x-for="(bullet, bIdx) in exp.bullets" :key="bIdx">
                                    <li class="relative group/bullet pl-1 text-xs leading-relaxed">
                                        <span contenteditable="true" @blur="exp.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                        <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delExperienceBullet(expIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                    </li>
                                </template>
                            </ul>

                            <!-- Inline add bullet -->
                            <div class="no-print mt-1 text-right">
                                <button class="handle-btn text-[9px] inline-flex" @click="addExperienceBullet(expIdx)" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Bullet</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 40%, 90%); margin-top: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}; margin-bottom: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}`" />

            <!-- Education -->
            <div>
                <div class="flex justify-between items-center mb-1">
                    <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Education</h2>
                    <button class="no-print handle-btn text-[10px]" @click="addEducation()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Degree</button>
                </div>

                <div class="space-y-3">
                    <template x-for="(edu, eduIdx) in resume.educations" :key="eduIdx">
                        <div class="item-wrapper group/item relative">

                            <div class="no-print visual-handle-bar">
                                <button class="handle-btn btn-del" @click="delEducation(eduIdx)" title="Delete Education">×</button>
                            </div>

                            <div class="flex justify-between items-start font-medium text-xs">
                                <span class="font-bold text-gray-900" contenteditable="true" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></span>
                                <span class="text-gray-600 font-bold whitespace-nowrap" contenteditable="true" @blur="edu.period = $el.innerText; calculateA4Fit()" x-text="edu.period"></span>
                            </div>
                            <div class="text-gray-700 font-medium text-xs mt-0.5" contenteditable="true" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></div>

                            <!-- Coursework bullets -->
                            <ul class="list-disc pl-5 mt-1 space-y-0.5 text-gray-700">
                                <template x-for="(bullet, bIdx) in edu.bullets" :key="bIdx">
                                    <li class="relative group/bullet pl-1 text-xs leading-relaxed">
                                        <span contenteditable="true" @blur="edu.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                        <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delEducationBullet(eduIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                    </li>
                                </template>
                            </ul>

                            <!-- Inline add bullet -->
                            <div class="no-print mt-1 text-right">
                                <button class="handle-btn text-[9px] inline-flex" @click="addEducationBullet(eduIdx)" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Bullet</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 40%, 90%); margin-top: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}; margin-bottom: ${spacing === 'compact' ? '6px' : (spacing === 'spacious' ? '14px' : '10px')}`" />

            <!-- Additional Information -->
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest mb-1.5" :style="`color: hsl(${hue}, 50%, 35%)`">Additional Information</h2>
                <ul class="list-disc pl-5 space-y-1 text-xs text-gray-700">
                    <li class="pl-1" x-show="resume.technical_skills">
                        <span class="font-bold">Technical Skills:</span>
                        <span contenteditable="true" @blur="resume.technical_skills = $el.innerText; calculateA4Fit()" x-text="resume.technical_skills"></span>
                    </li>
                    <li class="pl-1" x-show="resume.languages">
                        <span class="font-bold">Languages:</span>
                        <span contenteditable="true" @blur="resume.languages = $el.innerText; calculateA4Fit()" x-text="resume.languages"></span>
                    </li>
                    <li class="pl-1" x-show="resume.certifications">
                        <span class="font-bold">Certifications:</span>
                        <span contenteditable="true" @blur="resume.certifications = $el.innerText; calculateA4Fit()" x-text="resume.certifications"></span>
                    </li>
                    <li class="pl-1" x-show="resume.awards">
                        <span class="font-bold">Awards/Activities:</span>
                        <span contenteditable="true" @blur="resume.awards = $el.innerText; calculateA4Fit()" x-text="resume.awards"></span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- Script triggers immediate reactivity on page -->
    <script>
    if (!window.resumeApp) {
        window.resumeApp = function() {
            return {
                resume: {},
                hue: 282, // Matches beautiful Violet tone from the sample screenshot
                fontFamily: 'sans',
                spacing: 'normal',
                autoSpace: false,
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

                init(initialResume) {
                    if (initialResume) {
                        this.resume = initialResume;
                    }

                    const saved = localStorage.getItem('resumeSettings_readymade_modern');
                    if (saved) {
                        try {
                            const s = JSON.parse(saved);
                            this.hue = s.hue ?? 282;
                            this.fontFamily = s.fontFamily ?? 'sans';
                            this.spacing = s.spacing ?? 'normal';
                            this.autoSpace = s.autoSpace ?? false;
                            if (s.resume) this.resume = s.resume;
                        } catch(e) {}
                    }

                    setTimeout(() => this.calculateA4Fit(), 300);
                },

                saveSettings() {
                    localStorage.setItem('resumeSettings_readymade_modern', JSON.stringify({
                        hue: this.hue,
                        fontFamily: this.fontFamily,
                        spacing: this.spacing,
                        autoSpace: this.autoSpace,
                        resume: this.resume
                    }));
                },

                updateName(fullName) {
                    const parts = fullName.trim().split(/\s+/);
                    this.resume.first_name = parts[0] || '';
                    this.resume.last_name = parts.slice(1).join(' ') || '';
                    this.saveSettings();
                },

                addExperience() {
                    if (!this.resume.experiences) this.resume.experiences = [];
                    this.resume.experiences.push({
                        title: 'Role Title',
                        company: 'Company / Organization',
                        period: 'Period',
                        bullets: ['Milestone accomplishment or key responsibility.']
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
                    this.resume.experiences[expIdx].bullets.push('New key milestone achievement.');
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
                        degree: 'Degree Program',
                        school: 'School / Institution',
                        period: 'Period',
                        bullets: ['Relevant focus, specializations, or GPA details.']
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delEducation(idx) {
                    this.resume.educations.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addEducationBullet(eduIdx) {
                    if (!this.resume.educations[eduIdx].bullets) {
                        this.resume.educations[eduIdx].bullets = [];
                    }
                    this.resume.educations[eduIdx].bullets.push('Specialization coursework detail.');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delEducationBullet(eduIdx, bIdx) {
                    this.resume.educations[eduIdx].bullets.splice(bIdx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                calculateA4Fit() {
                    const wrapper = document.getElementById('resume-surface-wrapper');
                    if (!wrapper) return;

                    const contentHeight = wrapper.scrollHeight;
                    const a4Height = wrapper.offsetHeight || 1123;
                    const fill = Math.round((contentHeight / a4Height) * 100);

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

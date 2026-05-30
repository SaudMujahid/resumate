<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ ($resumeData['first_name'] ?? 'David') . ' ' . ($resumeData['last_name'] ?? 'Anderson') }} — Resume</title>

@vite(['resources/css/app.css', 'resources/js/resume-modern.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    .font-sans-custom { font-family: 'Inter', sans-serif !important; }
    .font-serif-custom { font-family: 'Playfair Display', serif !important; }
    .font-mono-custom { font-family: 'Courier New', monospace !important; }

    /* Visual controls on hover */
    .item-wrapper {
        position: relative;
        transition: all 0.2s ease;
    }
    .no-print { user-select: none; }
    @media screen {
        .item-wrapper:hover {
            background-color: rgba(15, 23, 42, 0.03);
            box-shadow: 0 0 0 6px rgba(15, 23, 42, 0.03);
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
    [contenteditable]:hover { background: rgba(15, 23, 42, 0.08); }
    [contenteditable]:focus { background: rgba(15, 23, 42, 0.12); outline: 1px dashed hsl(220,70%,45%); }

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

    <x-resume-toolbar template="minimal" />

    <div class="pt-24 pb-12 px-4 resume-page-wrap">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300 flex flex-col justify-between"
             id="resume-surface-wrapper"
             :style="`padding: ${spacing === 'compact' ? '12mm 14mm' : (spacing === 'spacious' ? '20mm 22mm' : '16mm 18mm')}; font-size: ${spacing === 'compact' ? '11px' : (spacing === 'spacious' ? '13px' : '12px')}`">

            <!-- Name and Contact Header Grid -->
            <div class="grid grid-cols-[1fr_auto] gap-6 items-start">
                <div>
                    <!-- Name on two lines matching layout -->
                    <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 leading-none uppercase font-serif-custom"
                        style="line-height: 0.95; white-space: pre-line;"
                        contenteditable="true"
                        @blur="updateName($el.innerText); calculateA4Fit()"
                        x-text="(resume.first_name || 'DAVID') + '\n' + (resume.last_name || 'ANDERSON')">
                    </h1>

                    <p class="text-xs tracking-widest uppercase font-bold text-gray-500 mt-4"
                       contenteditable="true"
                       @blur="resume.tagline = $el.innerText; calculateA4Fit()"
                       x-text="resume.tagline">
                    </p>
                </div>

                <!-- Right Contact Block -->
                <div class="text-right text-[11px] space-y-1.5 text-gray-700 font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <span contenteditable="true" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></span>
                        <span class="text-gray-400">📞</span>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <span contenteditable="true" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></span>
                        <span class="text-gray-400">✉️</span>
                    </div>
                    <div class="flex items-center justify-end gap-2" x-show="resume.website">
                        <span contenteditable="true" @blur="resume.website = $el.innerText; calculateA4Fit()" x-text="resume.website"></span>
                        <span class="text-gray-400">🌐</span>
                    </div>
                    <div class="flex items-center justify-end gap-2">
                        <span contenteditable="true" @blur="resume.address = $el.innerText; calculateA4Fit()" x-text="resume.address"></span>
                        <span class="text-gray-400">📍</span>
                    </div>
                </div>
            </div>

            <!-- Horizontal Divider Line -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 20%, 80%); margin-top: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}; margin-bottom: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}`" />

            <!-- About Me -->
            <div x-show="resume.summary" class="item-wrapper">
                <h2 class="text-xs font-bold tracking-[0.15em] uppercase mb-1.5 text-gray-900">About Me</h2>
                <p class="text-[10.5px] leading-relaxed text-gray-600 text-justify font-normal"
                   contenteditable="true"
                   @blur="resume.summary = $el.innerText; calculateA4Fit()"
                   x-text="resume.summary">
                </p>
            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 20%, 80%); margin-top: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}; margin-bottom: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}`" />

            <!-- Work Experience Timeline -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xs font-bold tracking-[0.15em] uppercase text-gray-900">Experience</h2>
                    <button class="no-print handle-btn text-[10px]" @click="addExperience()" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Position</button>
                </div>

                <div class="space-y-4">
                    <template x-for="(exp, expIdx) in resume.experiences" :key="expIdx">
                        <div class="item-wrapper group/item relative grid grid-cols-[100px_1fr] gap-4">

                            <!-- Actions on Hover -->
                            <div class="no-print visual-handle-bar">
                                <button class="handle-btn btn-del" @click="delExperience(expIdx)" title="Delete position">×</button>
                            </div>

                            <!-- Left: Date -->
                            <div class="text-[10px] font-bold text-gray-500 tracking-wide pt-0.5"
                                 contenteditable="true"
                                 @blur="exp.period = $el.innerText; calculateA4Fit()"
                                 x-text="exp.period">
                            </div>

                            <!-- Right: Title, Company & Description -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-900 uppercase"
                                    contenteditable="true"
                                    @blur="exp.title = $el.innerText; calculateA4Fit()"
                                    x-text="exp.title">
                                </h3>
                                <p class="text-[10px] font-bold text-gray-500 tracking-wide mt-0.5 uppercase"
                                   contenteditable="true"
                                   @blur="exp.company = $el.innerText; calculateA4Fit()"
                                   x-text="exp.company">
                                </p>

                                <ul class="list-disc pl-4 mt-1.5 space-y-1 text-gray-600">
                                    <template x-for="(bullet, bIdx) in exp.bullets" :key="bIdx">
                                        <li class="relative group/bullet pl-0.5 text-[10.5px] leading-normal text-justify">
                                            <span contenteditable="true" @blur="exp.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                            <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delExperienceBullet(expIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                        </li>
                                    </template>
                                </ul>

                                <div class="no-print mt-1.5">
                                    <button class="handle-btn text-[9px] inline-flex" @click="addExperienceBullet(expIdx)" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Bullet</button>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 20%, 80%); margin-top: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}; margin-bottom: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}`" />

            <!-- Two Column Split: Education & Expertise -->
            <div class="grid grid-cols-2 gap-8 items-start">

                <!-- Left: Education -->
                <div>
                    <div class="flex justify-between items-center mb-2.5">
                        <h2 class="text-xs font-bold tracking-[0.15em] uppercase text-gray-900">Education</h2>
                        <button class="no-print handle-btn text-[10px]" @click="addEducation()" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Edu</button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(edu, eduIdx) in resume.educations" :key="eduIdx">
                            <div class="item-wrapper group/item relative grid grid-cols-[70px_1fr] gap-3">
                                <div class="no-print visual-handle-bar">
                                    <button class="handle-btn btn-del" @click="delEducation(eduIdx)">×</button>
                                </div>
                                <div class="text-[10px] font-bold text-gray-500 pt-0.5" contenteditable="true" @blur="edu.period = $el.innerText; calculateA4Fit()" x-text="edu.period"></div>
                                <div>
                                    <h3 class="text-[10.5px] font-bold text-gray-900 uppercase leading-tight" contenteditable="true" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></h3>
                                    <p class="text-[10px] text-gray-500 font-bold tracking-wide uppercase mt-0.5" contenteditable="true" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right: Expertise (Skills with horizontal bars) -->
                <div>
                    <div class="flex justify-between items-center mb-2.5">
                        <h2 class="text-xs font-bold tracking-[0.15em] uppercase text-gray-900">Expertise</h2>
                        <button class="no-print handle-btn text-[10px]" @click="addSkill()" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Skill</button>
                    </div>

                    <div class="space-y-2.5">
                        <template x-for="(skill, sIdx) in parsedSkills" :key="sIdx">
                            <div class="flex items-center justify-between group/skill">
                                <span class="text-[11px] font-semibold text-gray-700" contenteditable="true" @blur="skill.name = $el.innerText" x-text="skill.name"></span>
                                <div class="flex items-center gap-3">
                                    <!-- Interactive slider bar -->
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden relative cursor-pointer" @click="adjustSkill(sIdx, $event)">
                                        <div class="h-full bg-gray-700 rounded-full transition-all duration-300" :style="`width: ${skill.level}%; background-color: hsl(${hue}, 15%, 35%)`"></div>
                                    </div>
                                    <button class="no-print handle-btn btn-del" @click="delSkill(sIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

            <!-- Divider -->
            <hr class="border-t" :style="`border-color: hsl(${hue}, 20%, 80%); margin-top: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}; margin-bottom: ${spacing === 'compact' ? '8px' : (spacing === 'spacious' ? '18px' : '13px')}`" />

            <!-- Two Column Split: Achievement & Reference -->
            <div class="grid grid-cols-2 gap-8 items-start">

                <!-- Left: Achievements -->
                <div>
                    <div class="flex justify-between items-center mb-2.5">
                        <h2 class="text-xs font-bold tracking-[0.15em] uppercase text-gray-900">Achievement</h2>
                        <button class="no-print handle-btn text-[10px]" @click="addAchievement()" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add</button>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(ach, achIdx) in resume.achievements" :key="achIdx">
                            <div class="item-wrapper group/item relative grid grid-cols-[70px_1fr] gap-3">
                                <div class="no-print visual-handle-bar">
                                    <button class="handle-btn btn-del" @click="delAchievement(achIdx)">×</button>
                                </div>
                                <div class="text-[10px] font-bold text-gray-500 pt-0.5" contenteditable="true" @blur="ach.period = $el.innerText; calculateA4Fit()" x-text="ach.period"></div>
                                <div>
                                    <h3 class="text-[10.5px] font-bold text-gray-900 uppercase leading-tight" contenteditable="true" @blur="ach.title = $el.innerText; calculateA4Fit()" x-text="ach.title"></h3>
                                    <p class="text-[10px] text-gray-500 leading-relaxed text-justify mt-0.5" contenteditable="true" @blur="ach.desc = $el.innerText; calculateA4Fit()" x-text="ach.desc"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Right: References -->
                <div>
                    <div class="flex justify-between items-center mb-2.5">
                        <h2 class="text-xs font-bold tracking-[0.15em] uppercase text-gray-900">Reference</h2>
                        <button class="no-print handle-btn text-[10px]" @click="addReference()" :style="`color: hsl(${hue}, 40%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add</button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="(ref, refIdx) in resume.references" :key="refIdx">
                            <div class="item-wrapper group/item relative text-[10px] leading-tight text-gray-600">

                                <div class="no-print visual-handle-bar">
                                    <button class="handle-btn btn-del" @click="delReference(refIdx)">×</button>
                                </div>

                                <h4 class="font-bold text-gray-900 uppercase" contenteditable="true" @blur="ref.name = $el.innerText" x-text="ref.name"></h4>
                                <p class="text-gray-500 font-bold tracking-wide uppercase mt-0.5" contenteditable="true" @blur="ref.title = $el.innerText" x-text="ref.title"></p>

                                <div class="mt-2 space-y-0.5 text-gray-500 font-medium">
                                    <div>P: <span contenteditable="true" @blur="ref.phone = $el.innerText" x-text="ref.phone"></span></div>
                                    <div class="break-all">E: <span contenteditable="true" @blur="ref.email = $el.innerText" x-text="ref.email"></span></div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
    if (!window.resumeApp) {
        window.resumeApp = function() {
            return {
                resume: {},
                parsedSkills: [],
                hue: 210, // Classic Slate Blue tone match
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

                        // Ensure structure matches minimal view
                        if (!this.resume.first_name) {
                            this.resume.first_name = 'DAVID';
                            this.resume.last_name = 'ANDERSON';
                        }
                        this.resume.tagline = this.resume.tagline || 'WEB & GRAPHIC DESIGNER';

                        // Initialize parsed expertise skills
                        if (this.resume.technical_skills && typeof this.resume.technical_skills === 'string') {
                            const raw = this.resume.technical_skills.split(',').map(s => s.trim()).filter(Boolean);
                            this.parsedSkills = raw.map((s, idx) => ({
                                name: s,
                                level: Math.max(50, 100 - (idx * 8))
                            }));
                        } else {
                            this.parsedSkills = [
                                { name: 'Wordpress', level: 90 },
                                { name: 'Adobe Photoshop', level: 85 },
                                { name: 'Microsoft Word', level: 80 },
                                { name: 'Adobe Illustrator', level: 75 },
                                { name: 'Adobe PowerPoint', level: 70 }
                            ];
                        }

                        // Seed default minimal achievements if missing
                        if (!this.resume.achievements) {
                            this.resume.achievements = [
                                { period: '2015 - 2016', title: 'LOGO DESIGN AWARDS', desc: 'International Graphic Design Awards - USA. Mapped for creative concept execution.' }
                            ];
                        }

                        // Seed default references matching layout image
                        if (!this.resume.references) {
                            this.resume.references = [
                                { name: 'MICHAEL DEEMER', title: 'CEO Director', phone: '+555 4545 5599', email: 'michaeldeemer@gmail.com' },
                                { name: 'PAUL ANDERSON', title: 'Account Manager', phone: '+555 4545 5599', email: 'paulanderson@gmail.com' }
                            ];
                        }
                    }

                    const saved = localStorage.getItem('resumeSettings_readymade_minimal');
                    if (saved) {
                        try {
                            const s = JSON.parse(saved);
                            this.hue = s.hue ?? 210;
                            this.fontFamily = s.fontFamily ?? 'sans';
                            this.spacing = s.spacing ?? 'normal';
                            this.autoSpace = s.autoSpace ?? false;
                            if (s.resume) this.resume = s.resume;
                            if (s.parsedSkills) this.parsedSkills = s.parsedSkills;
                        } catch(e) {}
                    }

                    setTimeout(() => this.calculateA4Fit(), 300);
                },

                saveSettings() {
                    localStorage.setItem('resumeSettings_readymade_minimal', JSON.stringify({
                        hue: this.hue,
                        fontFamily: this.fontFamily,
                        spacing: this.spacing,
                        autoSpace: this.autoSpace,
                        resume: this.resume,
                        parsedSkills: this.parsedSkills
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
                        title: 'POSITION TITLE',
                        company: 'COMPANY NAME - LOCATION',
                        period: 'Period Range',
                        bullets: ['Milestone accomplishment or contribution description.']
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
                    this.resume.experiences[expIdx].bullets.push('Added new key action metric milestone.');
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
                        degree: 'DEGREE / COURSE TITLE',
                        school: 'COLLEGE NAME - LOCATION',
                        period: 'Period Range'
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delEducation(idx) {
                    this.resume.educations.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addSkill() {
                    this.parsedSkills.push({ name: 'New Skill Focus', level: 80 });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delSkill(idx) {
                    this.parsedSkills.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                adjustSkill(idx, event) {
                    const rect = event.currentTarget.getBoundingClientRect();
                    const clickX = event.clientX - rect.left;
                    const percent = Math.round((clickX / rect.width) * 100);
                    this.parsedSkills[idx].level = Math.max(10, Math.min(100, percent));
                    this.saveSettings();
                },

                addAchievement() {
                    if (!this.resume.achievements) this.resume.achievements = [];
                    this.resume.achievements.push({
                        period: 'Year Range',
                        title: 'AWARD TITLE',
                        desc: 'Description detailing key competitive criteria or organization honors.'
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delAchievement(idx) {
                    this.resume.achievements.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addReference() {
                    if (!this.resume.references) this.resume.references = [];
                    this.resume.references.push({
                        name: 'REFERENCE NAME',
                        title: 'Position Title',
                        phone: '+555 1234 5678',
                        email: 'ref@example.com'
                    });
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delReference(idx) {
                    this.resume.references.splice(idx, 1);
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

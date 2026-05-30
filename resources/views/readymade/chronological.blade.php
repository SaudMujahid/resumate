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
    [contenteditable]:focus { background: rgba(109, 40, 217, 0.12); outline: 1px dashed hsl(185,70%,45%); }

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

    <x-resume-toolbar template="chronological" />

    <div class="pt-24 pb-12 px-4 resume-page-wrap">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300 flex flex-col justify-between"
             id="resume-surface-wrapper"
             :style="`padding: ${spacing === 'compact' ? '12mm 14mm' : (spacing === 'spacious' ? '20mm 22mm' : '16mm 18mm')}; font-size: ${spacing === 'compact' ? '11px' : (spacing === 'spacious' ? '13px' : '12px')}`">

            <!-- Header Content -->
            <div>
                <div class="flex justify-between items-start gap-4">
                    <!-- Name & Subtitle -->
                    <div class="flex-1 text-center">
                        <h1 class="text-3xl font-bold tracking-wider uppercase"
                            :style="`color: hsl(${hue}, 50%, 35%)`"
                            contenteditable="true"
                            @blur="updateName($el.innerText); calculateA4Fit()"
                            x-text="(resume.first_name || '') + ' ' + (resume.last_name || '')">
                        </h1>
                        <div class="text-xs font-semibold tracking-widest text-gray-500 mt-1 uppercase"
                             contenteditable="true"
                             @blur="resume.title = $el.innerText; calculateA4Fit()"
                             x-text="resume.title">
                        </div>
                    </div>

                    <!-- Optional Profile Picture -->
                    <div class="relative group/photo shrink-0 no-print" x-show="resume.photo || showPhotoUploader">
                        <div class="w-20 h-24 border-2 border-dashed border-gray-300 rounded overflow-hidden flex items-center justify-center relative cursor-pointer"
                             @click="$refs.photoInput.click()"
                             :class="resume.photo ? 'border-none' : 'bg-gray-50'">

                            <template x-if="resume.photo">
                                <img :src="resume.photo" class="w-full h-full object-cover" />
                            </template>
                            <template x-if="!resume.photo">
                                <span class="text-[9px] text-gray-400 font-semibold text-center p-1">Add Image</span>
                            </template>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/photo:opacity-100 transition-opacity">
                                <span class="text-white text-[10px]">Change</span>
                            </div>
                        </div>
                        <input type="file" x-ref="photoInput" class="hidden" accept="image/*" @change="uploadPhoto($event)">
                        <button x-show="resume.photo" @click.stop="resume.photo = ''; saveSettings();"
                                class="absolute -top-1.5 -right-1.5 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] shadow">
                            &times;
                        </button>
                    </div>
                </div>

                <!-- Horizontal Accent Bar -->
                <hr class="border-t-2 my-4" :style="`border-color: hsl(${hue}, 40%, 80%)`" />

                <!-- Professional Summary -->
                <div class="px-1">
                    <p class="text-gray-700 leading-relaxed text-sm text-justify italic font-medium"
                       contenteditable="true"
                       @blur="resume.summary = $el.innerText; calculateA4Fit()"
                       x-text="resume.summary">
                    </p>
                </div>

                <!-- Professional Experience -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-center gap-2">
                            <!-- Distinct Vertical Left Line Accent -->
                            <div class="w-[4px] h-5 rounded-sm" :style="`background-color: hsl(${hue}, 50%, 45%)`"></div>
                            <h2 class="text-sm font-bold uppercase tracking-wider" :style="`color: hsl(${hue}, 50%, 35%)`">Professional Experience</h2>
                        </div>
                        <button class="no-print handle-btn text-[10px]" @click="addExperience()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Role</button>
                    </div>

                    <div class="space-y-5 px-1">
                        <template x-for="(exp, expIdx) in resume.experiences" :key="expIdx">
                            <div class="item-wrapper group/item relative">

                                <div class="no-print visual-handle-bar">
                                    <button class="handle-btn btn-del" @click="delExperience(expIdx)" title="Delete Job">×</button>
                                </div>

                                <!-- Date (displayed above title/company) -->
                                <div class="text-xs italic font-bold text-gray-700"
                                     contenteditable="true"
                                     @blur="exp.period = $el.innerText; calculateA4Fit()"
                                     x-text="exp.period">
                                </div>

                                <!-- Company & Location -->
                                <div class="text-sm font-bold text-gray-900 mt-0.5 uppercase"
                                     contenteditable="true"
                                     @blur="exp.company = $el.innerText; calculateA4Fit()"
                                     x-text="exp.company">
                                </div>

                                <!-- Role Title -->
                                <div class="text-xs italic text-gray-600 font-semibold mt-0.5"
                                     contenteditable="true"
                                     @blur="exp.title = $el.innerText; calculateA4Fit()"
                                     x-text="exp.title">
                                </div>

                                <!-- Experience Bullets -->
                                <ul class="list-disc pl-5 mt-2 space-y-1.5 text-gray-700">
                                    <template x-for="(bullet, bIdx) in exp.bullets" :key="bIdx">
                                        <li class="relative group/bullet pl-1 text-xs leading-relaxed">
                                            <span contenteditable="true" @blur="exp.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                            <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delExperienceBullet(expIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                        </li>
                                    </template>
                                </ul>

                                <div class="no-print mt-1 text-right">
                                    <button class="handle-btn text-[9px] inline-flex" @click="addExperienceBullet(expIdx)" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Bullet</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Two Column Bottom Section (Education & Additional Skills) -->
                <div class="grid grid-cols-12 gap-8 mt-6">

                    <!-- Left Column: Education -->
                    <div class="col-span-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-[4px] h-5 rounded-sm" :style="`background-color: hsl(${hue}, 50%, 45%)`"></div>
                                <h2 class="text-sm font-bold uppercase tracking-wider" :style="`color: hsl(${hue}, 50%, 35%)`">Education</h2>
                            </div>
                            <button class="no-print handle-btn text-[10px]" @click="addEducation()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add</button>
                        </div>

                        <div class="space-y-4 px-1">
                            <template x-for="(edu, eduIdx) in resume.educations" :key="eduIdx">
                                <div class="item-wrapper group/item relative">

                                    <div class="no-print visual-handle-bar">
                                        <button class="handle-btn btn-del" @click="delEducation(eduIdx)" title="Delete Education">×</button>
                                    </div>

                                    <div class="text-xs italic font-bold text-gray-700"
                                         contenteditable="true"
                                         @blur="edu.period = $el.innerText; calculateA4Fit()"
                                         x-text="edu.period">
                                    </div>

                                    <div class="text-xs font-bold text-gray-900 mt-0.5 uppercase"
                                         contenteditable="true"
                                         @blur="edu.school = $el.innerText; calculateA4Fit()"
                                         x-text="edu.school">
                                    </div>

                                    <div class="text-xs text-gray-700 mt-0.5"
                                         contenteditable="true"
                                         @blur="edu.degree = $el.innerText; calculateA4Fit()"
                                         x-text="edu.degree">
                                    </div>

                                    <ul class="list-disc pl-5 mt-1 space-y-0.5 text-gray-600">
                                        <template x-for="(bullet, bIdx) in edu.bullets" :key="bIdx">
                                            <li class="relative group/bullet pl-1 text-[11px] leading-relaxed">
                                                <span contenteditable="true" @blur="edu.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                                <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delEducationBullet(eduIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                            </li>
                                        </template>
                                    </ul>

                                    <div class="no-print mt-1 text-right">
                                        <button class="handle-btn text-[9px] inline-flex" @click="addEducationBullet(eduIdx)" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Info</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Right Column: Additional Skills -->
                    <div class="col-span-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-[4px] h-5 rounded-sm" :style="`background-color: hsl(${hue}, 50%, 45%)`"></div>
                                <h2 class="text-sm font-bold uppercase tracking-wider" :style="`color: hsl(${hue}, 50%, 35%)`">Additional Skills</h2>
                            </div>
                            <button class="no-print handle-btn text-[10px]" @click="addAdditionalSkill()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Skill</button>
                        </div>

                        <div class="px-1">
                            <ul class="list-disc pl-5 space-y-3 text-xs text-gray-700">
                                <template x-for="(skill, sIdx) in resume.additional_skills" :key="sIdx">
                                    <li class="relative group/bullet pl-1 text-xs leading-relaxed">
                                        <span contenteditable="true" @blur="resume.additional_skills[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                                        <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delAdditionalSkill(sIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer Details (Centered Contact) -->
            <div class="mt-8">
                <hr class="border-t-2 mb-3" :style="`border-color: hsl(${hue}, 40%, 80%)`" />
                <div class="text-center text-xs text-gray-600 font-medium flex flex-wrap justify-center items-center gap-2">
                    <span contenteditable="true" @blur="resume.address = $el.innerText; calculateA4Fit()" x-text="resume.address"></span>
                    <span class="text-gray-400">•</span>
                    <span contenteditable="true" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></span>
                    <span class="text-gray-400">•</span>
                    <span contenteditable="true" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></span>
                </div>
            </div>

        </div>
    </div>

    <!-- Script triggers immediate reactivity on page -->
    <script>
    if (!window.resumeApp) {
        window.resumeApp = function() {
            return {
                resume: {},
                hue: 185, // Default teal-slate color matched directly to the uploaded template
                fontFamily: 'sans',
                spacing: 'normal',
                autoSpace: false,
                fillPercentage: 100,
                isOverflowing: false,
                isUnderflowing: false,
                showPhotoUploader: false, // Hidden by default to mirror the clean layout

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

                    // Strict matching defaults based on Richard Williams' Chronological resume
                    if (!this.resume.first_name) this.resume.first_name = 'Richard';
                    if (!this.resume.last_name) this.resume.last_name = 'Williams';
                    if (!this.resume.title) this.resume.title = 'Financial Advisor';
                    if (!this.resume.summary) this.resume.summary = 'Financial Advisor with 7+ years of experience delivering financial/investment advisory services to high value clients. Proven success in managing multi-million dollar portfolios, driving profitability, and increasing ROI through skillful strategic planning, consulting, and financial advisory services.';

                    if (!this.resume.address) this.resume.address = '3665 Margaret Street, Houston, TX 47587';
                    if (!this.resume.email) this.resume.email = 'RichardWilliams@gmail.com';
                    if (!this.resume.phone) this.resume.phone = '(770) 625-9669';
                    if (!this.resume.photo) this.resume.photo = '';

                    if (!this.resume.experiences || this.resume.experiences.length === 0) {
                        this.resume.experiences = [
                            {
                                period: 'January 2024–Present',
                                company: 'WELLS FARGO ADVISORS, Houston, TX',
                                title: 'Senior Financial Advisor',
                                bullets: [
                                    'Deliver financial advice to clients, proposing strategies to achieve short- and long-term objectives for investments, insurance, business and estate planning with minimal risk',
                                    'Develop, review, and optimize investment portfolios for 300+ high value clients with over $190M AUM (Assets Under Management)',
                                    'Ensure maximum client satisfaction by providing exceptional and personalized service, enhancing client satisfaction ratings from 88% to 99.9% in less than 6 months'
                                ]
                            },
                            {
                                period: 'September 2018–December 2023',
                                company: 'SUNTRUST INVESTMENT SERVICES, INC., New Orleans, LA',
                                title: 'Financial Advisor',
                                bullets: [
                                    'Served as knowledgeable financial advisor to clients, managing an over $20.75M investment portfolio of 90+ individual and corporate clients',
                                    'Devised and applied a new training and accountability program that increased productivity from #10 to #3 in the region in less than 2 year period',
                                    'Partnered with cross-functional teams in consulting with clients to provide asset management risk strategy and mitigation, which increased AUM by 50%'
                                ]
                            },
                            {
                                period: 'July 2014–August 2018',
                                company: 'MAVERICK CAPITAL MANAGEMENT, New Orleans, LA',
                                title: 'Financial Advisor',
                                bullets: [
                                    'Served as the primary point of contact for over 15 clients',
                                    'Managed the portfolios of several major clients with over $8.5M in total assets'
                                ]
                            }
                        ];
                    }

                    if (!this.resume.educations || this.resume.educations.length === 0) {
                        this.resume.educations = [
                            {
                                period: 'May 2014',
                                school: 'LOUISIANA STATE UNIVERSITY, Baton Rouge, LA',
                                degree: 'Bachelor of Science in Business Administration (concentration: finance)',
                                bullets: [
                                    'Honors: cum laude (GPA: 3.7/4.0)'
                                ]
                            }
                        ];
                    }

                    if (!this.resume.additional_skills || this.resume.additional_skills.length === 0) {
                        this.resume.additional_skills = [
                            'Proficient in MS Office (Word, Excel, PowerPoint) Outlook, MS Project, Salesforce, TFS Project Management, Webex',
                            'Fluent in English, Spanish, and French'
                        ];
                    }

                    const saved = localStorage.getItem('resumeSettings_chronological_empire');
                    if (saved) {
                        try {
                            const s = JSON.parse(saved);
                            this.hue = s.hue ?? 185;
                            this.fontFamily = s.fontFamily ?? 'sans';
                            this.spacing = s.spacing ?? 'normal';
                            this.autoSpace = s.autoSpace ?? false;
                            if (s.resume) this.resume = s.resume;
                        } catch(e) {}
                    }

                    setTimeout(() => this.calculateA4Fit(), 300);
                },

                saveSettings() {
                    localStorage.setItem('resumeSettings_chronological_empire', JSON.stringify({
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

                uploadPhoto(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.resume.photo = e.target.result;
                            this.saveSettings();
                            this.$nextTick(() => this.calculateA4Fit());
                        };
                        reader.readAsDataURL(file);
                    }
                },

                addExperience() {
                    if (!this.resume.experiences) this.resume.experiences = [];
                    this.resume.experiences.push({
                        period: 'Date Range',
                        company: 'COMPANY NAME, City, ST',
                        title: 'Job Role Title',
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
                    this.resume.experiences[expIdx].bullets.push('New milestone achievement.');
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
                        period: 'Graduation Date',
                        school: 'SCHOOL NAME, City, ST',
                        degree: 'Degree / Major details',
                        bullets: ['Specializations, coursework, or honors.']
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
                    this.resume.educations[eduIdx].bullets.push('GPA, major GPA, or focus honors.');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delEducationBullet(eduIdx, bIdx) {
                    this.resume.educations[eduIdx].bullets.splice(bIdx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addAdditionalSkill() {
                    if (!this.resume.additional_skills) this.resume.additional_skills = [];
                    this.resume.additional_skills.push('New professional expertise or tool.');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delAdditionalSkill(idx) {
                    this.resume.additional_skills.splice(idx, 1);
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

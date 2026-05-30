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
    [contenteditable]:focus { background: rgba(109, 40, 217, 0.12); outline: 1px dashed hsl(215,70%,45%); }

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

            <!-- Header Grid: Identity on Left, Photo Box on Right -->
            <div class="flex justify-between items-start gap-6">
                <div class="flex-1 text-left">
                    <h1 class="text-3xl font-bold tracking-tight uppercase"
                        :style="`color: hsl(${hue}, 50%, 30%)`"
                        contenteditable="true"
                        @blur="updateName($el.innerText); calculateA4Fit()"
                        x-text="(resume.first_name || '') + ' ' + (resume.last_name || '')">
                    </h1>

                    <div class="text-lg font-medium tracking-wide mt-1 text-gray-700"
                         contenteditable="true"
                         @blur="resume.title = $el.innerText; calculateA4Fit()"
                         x-text="resume.title || 'Administrative Assistant'">
                    </div>

                    <p class="text-gray-600 leading-relaxed text-sm mt-3 text-justify"
                       contenteditable="true"
                       @blur="resume.summary = $el.innerText; calculateA4Fit()"
                       x-text="resume.summary">
                    </p>
                </div>

                <!-- Interactive Profile Picture Box -->
                <div class="relative group/photo shrink-0 no-print" x-data="{ showUploadBtn: false }">
                    <div class="w-28 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center relative cursor-pointer"
                         @click="$refs.photoInput.click()"
                         :class="resume.photo ? 'border-none' : 'bg-gray-50'">

                        <template x-if="resume.photo">
                            <img :src="resume.photo" class="w-full h-full object-cover" />
                        </template>
                        <template x-if="!resume.photo">
                            <div class="text-center p-2">
                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="block text-[10px] font-semibold text-gray-500 mt-1">Add Photo</span>
                            </div>
                        </template>

                        <!-- Change photo overlay -->
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/photo:opacity-100 transition-opacity">
                            <span class="text-white text-xs font-medium">Change Photo</span>
                        </div>
                    </div>

                    <!-- Hidden file inputs -->
                    <input type="file" x-ref="photoInput" class="hidden" accept="image/*" @change="uploadPhoto($event)">

                    <!-- Delete photo button -->
                    <button x-show="resume.photo" @click.stop="resume.photo = ''; saveSettings();"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 transition">
                        &times;
                    </button>
                </div>

                <!-- Print representation of photo -->
                <div class="hidden print:block shrink-0" x-show="resume.photo">
                    <img :src="resume.photo" class="w-28 h-32 object-cover rounded-lg border border-gray-200" />
                </div>
            </div>

            <!-- Horizontal Divider Contact Line -->
            <div class="border-y-2 py-2 my-4 text-center text-xs text-gray-700 font-medium flex flex-wrap justify-center items-center gap-x-4 gap-y-1.5"
                 :style="`border-color: hsl(${hue}, 40%, 85%)`">
                <div class="flex items-center gap-1">
                    <span contenteditable="true" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone || '(123) 456-7895'"></span>
                </div>
                <span class="text-gray-400 font-normal">/</span>
                <div class="flex items-center gap-1">
                    <span contenteditable="true" @blur="resume.address = $el.innerText; calculateA4Fit()" x-text="resume.address || 'Chicago, IL 60622'"></span>
                </div>
                <span class="text-gray-400 font-normal">/</span>
                <div class="flex items-center gap-1">
                    <span contenteditable="true" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email || 'davidperez@gmail.com'"></span>
                </div>
                <span class="text-gray-400 font-normal">/</span>
                <div class="flex items-center gap-1">
                    <span contenteditable="true" @blur="resume.website = $el.innerText; calculateA4Fit()" x-text="resume.website || 'linkedin.com/in/davidperez'"></span>
                </div>
            </div>

            <!-- Two Column Layout content -->
            <div class="grid grid-cols-12 gap-8 flex-1 items-start">

                <!-- Left Column (Professional Experience) -->
                <div class="col-span-8 flex flex-col gap-4">
                    <div>
                        <div class="flex justify-between items-center mb-3 border-b-2 pb-1" :style="`border-color: hsl(${hue}, 50%, 35%)`">
                            <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Professional Experience</h2>
                            <button class="no-print handle-btn text-[10px]" @click="addExperience()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Role</button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(exp, expIdx) in resume.experiences" :key="expIdx">
                                <div class="item-wrapper group/item relative">

                                    <div class="no-print visual-handle-bar">
                                        <button class="handle-btn btn-del" @click="delExperience(expIdx)" title="Delete Job">×</button>
                                    </div>

                                    <div class="flex justify-between items-start font-medium text-xs">
                                        <div class="text-gray-900">
                                            <span class="font-bold text-sm" contenteditable="true" @blur="exp.title = $el.innerText; calculateA4Fit()" x-text="exp.title"></span>
                                            <div class="text-gray-600 mt-0.5 font-semibold">
                                                <span contenteditable="true" @blur="exp.company = $el.innerText; calculateA4Fit()" x-text="exp.company"></span>
                                            </div>
                                        </div>
                                        <span class="text-gray-600 font-bold whitespace-nowrap text-right" contenteditable="true" @blur="exp.period = $el.innerText; calculateA4Fit()" x-text="exp.period"></span>
                                    </div>

                                    <!-- Experience Bullets -->
                                    <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
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
                </div>

                <!-- Right Column (Education & Skills) -->
                <div class="col-span-4 flex flex-col gap-6">

                    <!-- Education Section -->
                    <div>
                        <div class="flex justify-between items-center mb-3 border-b-2 pb-1" :style="`border-color: hsl(${hue}, 50%, 35%)`">
                            <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Education</h2>
                            <button class="no-print handle-btn text-[10px]" @click="addEducation()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Add Degree</button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(edu, eduIdx) in resume.educations" :key="eduIdx">
                                <div class="item-wrapper group/item relative">

                                    <div class="no-print visual-handle-bar">
                                        <button class="handle-btn btn-del" @click="delEducation(eduIdx)" title="Delete Education">×</button>
                                    </div>

                                    <div class="font-medium text-xs">
                                        <div class="font-bold text-gray-900" contenteditable="true" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></div>
                                        <div class="text-gray-700 mt-0.5" contenteditable="true" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></div>
                                        <div class="text-gray-500 text-[11px] mt-0.5" contenteditable="true" @blur="edu.period = $el.innerText; calculateA4Fit()" x-text="edu.period"></div>
                                    </div>

                                    <!-- Education Bullets -->
                                    <ul class="list-disc pl-5 mt-1 space-y-0.5 text-gray-700">
                                        <template x-for="(bullet, bIdx) in edu.bullets" :key="bIdx">
                                            <li class="relative group/bullet pl-1 text-xs leading-relaxed">
                                                <span contenteditable="true" @blur="edu.bullets[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                                                <button class="no-print handle-btn btn-del inline-flex ml-1.5" @click="delEducationBullet(eduIdx, bIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                                            </li>
                                        </template>
                                    </ul>

                                    <div class="no-print mt-1 text-right">
                                        <button class="handle-btn text-[9px] inline-flex" @click="addEducationBullet(eduIdx)" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 0 4px; border-radius: 3px;">+ Bullet</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Key Skills (Pill Badges) -->
                    <div>
                        <div class="flex justify-between items-center mb-3 border-b-2 pb-1" :style="`border-color: hsl(${hue}, 50%, 35%)`">
                            <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Key Skills</h2>
                            <button class="no-print handle-btn text-[10px]" @click="addKeySkill()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Skill</button>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="(skill, sIdx) in resume.key_skills" :key="sIdx">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold border transition-all duration-150"
                                      :style="`border-color: hsl(${hue}, 50%, 65%); color: hsl(${hue}, 50%, 35%); background-color: hsl(${hue}, 30%, 98%)`">
                                    <span contenteditable="true" @blur="resume.key_skills[sIdx] = $el.innerText; saveSettings()" x-text="skill"></span>
                                    <button class="no-print text-red-500 hover:text-red-700 font-bold ml-1 text-xs focus:outline-none" @click="delKeySkill(sIdx)">&times;</button>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Additional Skills (Pill Badges) -->
                    <div>
                        <div class="flex justify-between items-center mb-3 border-b-2 pb-1" :style="`border-color: hsl(${hue}, 50%, 35%)`">
                            <h2 class="text-xs font-bold uppercase tracking-widest" :style="`color: hsl(${hue}, 50%, 35%)`">Additional Skills</h2>
                            <button class="no-print handle-btn text-[10px]" @click="addAdditionalSkill()" :style="`color: hsl(${hue}, 50%, 35%)`" style="border: 1px dashed currentColor; padding: 1px 6px; border-radius: 4px;">+ Skill</button>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <template x-for="(skill, sIdx) in resume.additional_skills" :key="sIdx">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-semibold border transition-all duration-150"
                                      :style="`border-color: hsl(${hue}, 40%, 65%); color: hsl(${hue}, 50%, 40%); background-color: hsl(${hue}, 20%, 99%)`">
                                    <span contenteditable="true" @blur="resume.additional_skills[sIdx] = $el.innerText; saveSettings()" x-text="skill"></span>
                                    <button class="no-print text-red-500 hover:text-red-700 font-bold ml-1 text-xs focus:outline-none" @click="delAdditionalSkill(sIdx)">&times;</button>
                                </span>
                            </template>
                        </div>
                    </div>

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
                hue: 215, // Default steel-blue tone matching David Pérez's aesthetic
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

                    // Fallback structures if initial data is empty
                    if (!this.resume.first_name) this.resume.first_name = 'David';
                    if (!this.resume.last_name) this.resume.last_name = 'Pérez';
                    if (!this.resume.title) this.resume.title = 'Administrative Assistant';
                    if (!this.resume.summary) this.resume.summary = 'Administrative Assistant with 6+ years of experience organizing presentations, preparing facility reports, and maintaining the utmost confidentiality. Possess a B.A. in History and expertise in Microsoft Excel. Looking to leverage my knowledge and experience into a role as Project Manager.';

                    if (!this.resume.phone) this.resume.phone = '(123) 456-7895';
                    if (!this.resume.address) this.resume.address = 'Chicago, IL 60622';
                    if (!this.resume.email) this.resume.email = 'davidperez@gmail.com';
                    if (!this.resume.website) this.resume.website = 'linkedin.com/in/davidperez';
                    if (!this.resume.photo) this.resume.photo = '';

                    if (!this.resume.experiences || this.resume.experiences.length === 0) {
                        this.resume.experiences = [
                            {
                                title: 'Administrative Assistant',
                                company: 'Redford & Sons, Chicago, IL',
                                period: 'Sep 20XX – Present',
                                bullets: [
                                    'Schedule and coordinate meetings, appointments, and travel arrangements for supervisors and managers',
                                    'Trained 2 administrative assistants during a period of company expansion to ensure attention to detail',
                                    'Developed new filing and organizational practices, saving the company $3,000 per year in contracted labor expenses',
                                    'Maintain utmost discretion when dealing with sensitive topics',
                                    'Coordinate travel arrangements, including booking travel itineraries and using travel management software'
                                ]
                            },
                            {
                                title: 'Secretary',
                                company: 'Bright Spot Ltd - Boston, MA',
                                period: 'Jun 20XX - Aug 20XX',
                                bullets: [
                                    'Typed documents such as correspondence, drafts, memos, and emails, and prepared 3 reports weekly for management',
                                    'Opened, sorted, and distributed incoming messages and correspondence',
                                    'Purchased and maintained office supply inventories, and always carefully adhered to budgeting practices',
                                    'Greeted visitors and helped them either find the appropriate person or schedule an appointment'
                                ]
                            }
                        ];
                    }

                    if (!this.resume.educations || this.resume.educations.length === 0) {
                        this.resume.educations = [
                            {
                                degree: 'Bachelor Of Arts in History',
                                school: 'River Brook University, Chicago, IL',
                                period: 'May 20XX',
                                bullets: ['Graduated magna cum laude']
                            }
                        ];
                    }

                    if (!this.resume.key_skills) {
                        this.resume.key_skills = ['Microsoft Office', 'HubSpot', 'MailChimp', 'Google Workspace', 'Salesforce', 'AI Automation'];
                    }

                    if (!this.resume.additional_skills) {
                        this.resume.additional_skills = ['Spanish (Intermediate)', 'Typing speed of 70 WPM', 'Bookkeeping', 'Calendar Management', 'Meeting Coordination'];
                    }

                    const saved = localStorage.getItem('resumeSettings_readymade_modern_v2');
                    if (saved) {
                        try {
                            const s = JSON.parse(saved);
                            this.hue = s.hue ?? 215;
                            this.fontFamily = s.fontFamily ?? 'sans';
                            this.spacing = s.spacing ?? 'normal';
                            this.autoSpace = s.autoSpace ?? false;
                            if (s.resume) this.resume = s.resume;
                        } catch(e) {}
                    }

                    setTimeout(() => this.calculateA4Fit(), 300);
                },

                saveSettings() {
                    localStorage.setItem('resumeSettings_readymade_modern_v2', JSON.stringify({
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

                addKeySkill() {
                    if (!this.resume.key_skills) this.resume.key_skills = [];
                    this.resume.key_skills.push('New Skill');
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                delKeySkill(idx) {
                    this.resume.key_skills.splice(idx, 1);
                    this.saveSettings();
                    this.$nextTick(() => this.calculateA4Fit());
                },

                addAdditionalSkill() {
                    if (!this.resume.additional_skills) this.resume.additional_skills = [];
                    this.resume.additional_skills.push('New Skill');
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

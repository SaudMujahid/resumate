<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>

<!-- Alpine.js Core -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@if(empty($forPdf))
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&family=Jost:wght@200;300;400;500;600&display=swap" rel="stylesheet">
@endif

<style>
:root {
  --ink: #0f0f0f;
  --mid: #555;
  --soft: #999;
  --rule: #e0ddd9;
  --accent: #2d6a4f;
  --accent-pale: #edf4f0;
  --bg: #faf9f7;
  
  /* Alpine Spacing variables */
  --spacing-scale: 1.0;
  --section-gap: calc(28px * var(--spacing-scale));
  --item-gap: calc(18px * var(--spacing-scale));
}

* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'Jost', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  padding: 88px 20px 60px; /* Offset for toolbar */
}

/* Bounding A4 Constraints */
.resume-page {
  width: 210mm;
  height: 297mm;
  min-height: 297mm;
  max-height: 297mm;
  margin: 0 auto;
  background: white;
  box-shadow: 0 4px 40px rgba(0,0,0,.08), 0 1px 3px rgba(0,0,0,.06);
  padding: 18mm 16mm;
  box-sizing: border-box;
  overflow: hidden;
  position: relative;
  display: flex;
  flex-direction: column;
}

/* Margin preset classes */
.spacing-compact {
  padding: 13mm 12mm !important;
  --section-gap: calc(20px * var(--spacing-scale)) !important;
  --item-gap: calc(12px * var(--spacing-scale)) !important;
}
.spacing-spacious {
  padding: 22mm 20mm !important;
  --section-gap: calc(34px * var(--spacing-scale)) !important;
  --item-gap: calc(22px * var(--spacing-scale)) !important;
}

/* Typography styles */
.font-ats { font-family: Arial, sans-serif !important; }
.font-sans-custom { font-family: 'Jost', sans-serif !important; }
.font-serif-custom { font-family: 'Playfair Display', serif !important; }
.font-mono-custom { font-family: 'Courier New', monospace !important; }

/* Dynamic Header */
.top-header {
  display: grid;
  grid-template-columns: 1fr auto;
  align-items: end;
  padding-bottom: 20px;
  border-bottom: 1.5px solid var(--ink);
  gap: 24px;
}
.th-name {
  font-family: 'Playfair Display', serif;
  font-size: calc(36px * var(--spacing-scale));
  font-weight: 500;
  line-height: 1.05;
  color: var(--ink);
  letter-spacing: -.02em;
}
.th-role {
  font-size: 11px;
  font-weight: 400;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--accent);
  margin-top: 6px;
}
.th-contact {
  text-align: right;
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.th-contact-item {
  font-size: 12px;
  color: var(--mid);
  font-weight: 300;
}

/* Layout Columns */
.body-cols {
  display: grid;
  grid-template-columns: 1fr 210px;
  gap: 0 40px;
  margin-top: 30px;
  flex: 1;
  overflow: hidden;
}

.body-main {
  display: flex;
  flex-direction: column;
  gap: var(--section-gap);
  height: 100%;
}

.body-aside {
  display: flex;
  flex-direction: column;
  gap: var(--section-gap);
  height: 100%;
  border-left: 1px solid var(--rule);
  padding-left: 24px;
}

/* Smart distributed spacing */
.body-cols.auto-space .body-main,
.body-cols.auto-space .body-aside {
  justify-content: space-between;
  gap: 0;
}

/* Sections */
.section { 
  display: flex;
  flex-direction: column;
}
.sec-label {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: var(--item-gap);
  display: flex;
  align-items: center;
  gap: 10px;
}
.sec-label::after {
  content: '';
  flex: 1;
  height: 1px;
  background: var(--rule);
}

.summary-text {
  font-size: 13.5px;
  font-weight: 300;
  line-height: 1.7;
  color: var(--mid);
}

/* Job elements */
.exp-item { 
  margin-bottom: var(--item-gap);
  position: relative;
}
.exp-item:last-child { margin-bottom: 0; }
.exp-row-1 { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; }
.exp-title-min {
  font-size: 14.5px;
  font-weight: 500;
  color: var(--ink);
}
.exp-dur-min {
  font-size: 11px;
  color: var(--soft);
  font-weight: 300;
  white-space: nowrap;
}
.exp-company-min {
  font-size: 12.5px;
  font-weight: 400;
  color: var(--accent);
  margin-top: 1px;
}
.exp-list { margin-top: 6px; padding-left: 0; list-style: none; display: flex; flex-direction: column; gap: 4px; }
.exp-list li {
  font-size: 12.5px;
  color: var(--mid);
  line-height: 1.55;
  font-weight: 300;
  padding-left: 14px;
  position: relative;
}
.exp-list li::before {
  content: '·';
  position: absolute;
  left: 2px;
  color: var(--accent);
  font-size: 16px;
  line-height: 1;
  top: 0;
}

/* Academy */
.edu-block { 
  margin-bottom: var(--item-gap);
  border-bottom: 1px solid var(--rule);
  padding-bottom: var(--item-gap);
  position: relative;
}
.edu-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.edu-level-tag {
  font-size: 8.5px;
  font-weight: 600;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 2px;
}
.edu-degree-min { font-size: 12.5px; font-weight: 500; color: var(--ink); line-height: 1.3; }
.edu-school-min { font-size: 11.5px; font-weight: 300; color: var(--mid); margin-top: 1px; }
.edu-year-min { font-size: 10.5px; color: var(--soft); margin-top: 1px; }
.edu-gpa-min {
  display: inline-block;
  margin-top: 4px;
  font-size: 9.5px;
  font-weight: 600;
  color: var(--accent);
  background: var(--accent-pale);
  padding: 1px 6px;
  border-radius: 2px;
  letter-spacing: .04em;
}

/* Skills */
.skill-list { display: flex; flex-direction: column; gap: 4px; }
.skill-line {
  font-size: 12px;
  font-weight: 300;
  color: var(--mid);
  padding-bottom: 4px;
  border-bottom: 1px solid var(--rule);
}
.skill-line:last-child { border-bottom: none; }

.soft-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.soft-tag {
  font-size: 10.5px;
  font-weight: 400;
  color: var(--mid);
  border: 1px solid var(--rule);
  padding: 2px 7px;
  border-radius: 2px;
}

.lang-stack { display: flex; flex-direction: column; gap: 6px; }
.lang-row-min { display: flex; justify-content: space-between; font-size: 12px; color: var(--ink); font-weight: 300; }
.lang-lvl-min { font-size: 10.5px; color: var(--soft); }

/* Visual handles hover styles */
.section-wrapper {
  position: relative;
  transition: all 0.2s ease;
}
.no-print {
  user-select: none;
}
@media screen {
  .section-wrapper:hover {
    background-color: rgba(45, 106, 79, 0.03);
    box-shadow: 0 0 0 6px rgba(45, 106, 79, 0.03);
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
  .section-wrapper:hover .visual-handle-bar {
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

/* contenteditable outline highlight */
[contenteditable] { outline: none; border-radius: 2px; transition: background .12s; cursor: text; }
[contenteditable]:hover { background: var(--accent-pale); }
[contenteditable]:focus { background: var(--accent-pale); outline: 1px dashed var(--accent); }

/* Print rules */
@media print {
  body { background: white; padding: 0; }
  .no-print, .visual-handle-bar { display: none !important; }
  .resume-page { box-shadow: none; margin: 0; padding: 18mm 16mm; width: 210mm; height: 297mm; }
  [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
}

@if(!empty($forPdf))
* { font-family: 'DejaVu Sans', sans-serif !important; }
.th-name { font-family: 'DejaVu Serif', serif !important; }
body { padding: 0 !important; background: white !important; }
.resume-page { box-shadow: none !important; }
@endif
</style>
</head>
<body x-data="resumeApp()" x-init="init(@js($resume))" :class="fontClass">

  @if(empty($forPdf))
  <x-resume-toolbar template="minimal" />
  @endif

  <!-- A4 Main Sheet -->
  <div class="resume-page"
       :class="[
         spacing === 'compact' && 'spacing-compact',
         spacing === 'spacious' && 'spacing-spacious'
       ]"
       :style="`--spacing-scale: ${spacingMultiplier};`"
       id="resume-page-surface">

    <!-- Top Header -->
    <div class="top-header">
      <div>
        <div class="th-name" contenteditable="true" spellcheck="false" @blur="resume.name = $el.innerText; calculateA4Fit()" x-text="resume.name"></div>
        <div class="th-role" contenteditable="true" spellcheck="false" @blur="roleTitle = $el.innerText; calculateA4Fit()" x-text="roleTitle"></div>
      </div>
      <div class="th-contact">
        <div class="th-contact-item" contenteditable="true" spellcheck="false" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></div>
        <template x-if="resume.phone">
          <div class="th-contact-item" contenteditable="true" spellcheck="false" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></div>
        </template>
        <template x-if="resume.city">
          <div class="th-contact-item" contenteditable="true" spellcheck="false" @blur="resume.city = $el.innerText; calculateA4Fit()" x-text="resume.city"></div>
        </template>
      </div>
    </div>

    <!-- Body Layout Columns -->
    <div class="body-cols" :class="autoSpace && 'auto-space'">

      <!-- Left Column (Main body) -->
      <div class="body-main">
        <template x-for="(sec, secIdx) in mainSections" :key="sec.id">
          <div x-show="sec.visible" class="section-wrapper">
            
            <!-- Floating Handles (no-print) -->
            <div class="no-print visual-handle-bar">
              <button class="handle-btn" @click="moveMainSec(secIdx, -1)" :disabled="secIdx === 0" title="Move Up">↑</button>
              <button class="handle-btn" @click="moveMainSec(secIdx, 1)" :disabled="secIdx === mainSections.length - 1" title="Move Down">↓</button>
              <button class="handle-btn btn-del" @click="sec.visible = false; calculateA4Fit()" title="Hide">👁</button>
            </div>

            <!-- About Section -->
            <template x-if="sec.id === 'summary' && resume.summary">
              <div class="section">
                <div class="sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name"></div>
                <div class="summary-text" contenteditable="true" spellcheck="false" @blur="resume.summary = $el.innerText; calculateA4Fit()" x-text="resume.summary"></div>
              </div>
            </template>

            <!-- Experience Section -->
            <template x-if="sec.id === 'experience' && resume.experience">
              <div class="section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div class="sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="flex:1;"></div>
                  <button class="no-print handle-btn" @click="addJob()" style="margin-bottom:var(--item-gap); font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add Job</button>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:var(--item-gap);">
                  <template x-for="(exp, expIdx) in resume.experience" :key="expIdx">
                    <div class="exp-item group/item">
                      
                      <!-- Item operations -->
                      <div class="no-print absolute -right-6 top-0 hidden group-hover/item:flex gap-1">
                        <button class="handle-btn btn-del" @click="delJob(expIdx)" title="Delete Item">×</button>
                      </div>

                      <div class="exp-row-1">
                        <div class="exp-title-min" contenteditable="true" spellcheck="false" @blur="exp.title = $el.innerText; calculateA4Fit()" x-text="exp.title"></div>
                        <div class="exp-dur-min" contenteditable="true" spellcheck="false" @blur="exp.duration = $el.innerText; calculateA4Fit()" x-text="exp.duration"></div>
                      </div>
                      <div class="exp-company-min" contenteditable="true" spellcheck="false" @blur="exp.company = $el.innerText; calculateA4Fit()" x-text="exp.company"></div>
                      
                      <!-- Bullet lists -->
                      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:4px;">
                        <span class="no-print"></span>
                        <button class="no-print handle-btn" @click="addBullet(expIdx)" style="font-size:8px; border:1px dashed #e2e8f0; width:auto; padding:0 4px;">+ Bullet</button>
                      </div>
                      <ul class="exp-list" x-show="exp.responsibilities && exp.responsibilities.length > 0">
                        <template x-for="(bullet, bIdx) in exp.responsibilities" :key="bIdx">
                          <li class="group/bullet">
                            <span contenteditable="true" spellcheck="false" @blur="exp.responsibilities[bIdx] = $el.innerText; calculateA4Fit()" x-text="bullet"></span>
                            <button class="no-print handle-btn btn-del" @click="delBullet(expIdx, bIdx)" style="display:inline-flex; width:12px; height:12px; font-size:8px; vertical-align:middle; margin-left:4px;">×</button>
                          </li>
                        </template>
                      </ul>
                    </div>
                  </template>
                </div>
              </div>
            </template>

          </div>
        </template>
      </div><!-- /body-main -->

      <!-- Right Column (Sidebar/Aside) -->
      <div class="body-aside">
        <template x-for="(sec, secIdx) in asideSections" :key="sec.id">
          <div x-show="sec.visible" class="section-wrapper">
            
            <!-- Floating Handles (no-print) -->
            <div class="no-print visual-handle-bar" style="left:auto; right:-32px;">
              <button class="handle-btn" @click="moveAsideSec(secIdx, -1)" :disabled="secIdx === 0" title="Move Up">↑</button>
              <button class="handle-btn" @click="moveAsideSec(secIdx, 1)" :disabled="secIdx === asideSections.length - 1" title="Move Down">↓</button>
              <button class="handle-btn btn-del" @click="sec.visible = false; calculateA4Fit()" title="Hide">👁</button>
            </div>

            <!-- Education Section -->
            <template x-if="sec.id === 'education' && resume.education">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div class="aside-sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="flex:1;"></div>
                  <button class="no-print handle-btn" @click="addEdu()" style="margin-bottom:14px; font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add</button>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:var(--item-gap);">
                  <template x-for="(edu, eduIdx) in resume.education" :key="eduIdx">
                    <div class="edu-block group/item">
                      <div class="no-print absolute -right-5 top-0 hidden group-hover/item:flex">
                        <button class="handle-btn btn-del" @click="delEdu(eduIdx)">×</button>
                      </div>
                      <div class="edu-level-tag" contenteditable="true" @blur="edu.level = $el.innerText" x-text="edu.level"></div>
                      <div class="edu-degree-min" contenteditable="true" spellcheck="false" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></div>
                      <div class="edu-school-min" contenteditable="true" spellcheck="false" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></div>
                      <div class="edu-year-min" contenteditable="true" spellcheck="false" @blur="edu.year = $el.innerText; calculateA4Fit()" x-text="edu.year"></div>
                      
                      <div style="margin-top:4px;">
                        <span class="edu-gpa-min" contenteditable="true" @blur="edu.cgpa = $el.innerText; calculateA4Fit()" x-text="edu.cgpa ? 'CGPA ' + edu.cgpa : (edu.grade ? 'GPA ' + edu.grade : 'GPA N/A')"></span>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </template>

            <!-- Technical Skills Section -->
            <template x-if="sec.id === 'skills' && resume.skills && resume.skills.technical">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div class="aside-sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="flex:1;"></div>
                  <button class="no-print handle-btn" @click="addTechSkill()" style="margin-bottom:14px; font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Skill</button>
                </div>
                <div class="skill-list">
                  <template x-for="(skill, sIdx) in resume.skills.technical" :key="sIdx">
                    <div class="skill-line group/skill" style="display:flex; justify-content:space-between; align-items:center;">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.technical[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                      <button class="no-print handle-btn btn-del" @click="delTechSkill(sIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                    </div>
                  </template>
                </div>
              </div>
            </template>

            <!-- Soft Skills Section -->
            <template x-if="sec.id === 'soft' && resume.skills && resume.skills.soft">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div class="aside-sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="flex:1;"></div>
                  <button class="no-print handle-btn" @click="addSoftSkill()" style="margin-bottom:14px; font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add</button>
                </div>
                <div class="soft-tags">
                  <template x-for="(skill, sIdx) in resume.skills.soft" :key="sIdx">
                    <span class="soft-tag" style="display:inline-flex; align-items:center; gap:4px;">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.soft[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                      <button class="no-print handle-btn btn-del" @click="delSoftSkill(sIdx)" style="width:10px; height:10px; font-size:8px;">×</button>
                    </span>
                  </template>
                </div>
              </div>
            </template>

            <!-- Languages Section -->
            <template x-if="sec.id === 'languages' && resume.skills && resume.skills.languages">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                  <div class="aside-sec-label" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="flex:1;"></div>
                  <button class="no-print handle-btn" @click="addLang()" style="margin-bottom:14px; font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Lang</button>
                </div>
                <div class="lang-stack">
                  <template x-for="(lang, lIdx) in resume.skills.languages" :key="lIdx">
                    <div class="lang-row-min group/lang">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.languages[lIdx] = $el.innerText; calculateA4Fit()" x-text="lang"></span>
                      <span style="display:flex; align-items:center; gap:4px;">
                        <span class="lang-lvl-min" x-text="lIdx === 0 ? 'Native' : (lIdx === 1 ? 'Fluent' : 'Intermediate')"></span>
                        <button class="no-print handle-btn btn-del" @click="delLang(lIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                      </span>
                    </div>
                  </template>
                </div>
              </div>
            </template>

          </div>
        </template>
      </div><!-- /body-aside -->

    </div><!-- /body-cols -->

  </div><!-- /resume-page -->

  <script>
  function resumeApp() {
    return {
      resume: {},
      roleTitle: '',
      atsMode: false,
      fontFamily: 'sans',
      spacing: 'normal',
      spacingMultiplier: 1.0,
      autoSpace: true,
      
      fillPercentage: 100,
      isOverflowing: false,
      isUnderflowing: false,

      // Sequential sections state
      mainSections: [
        { id: 'summary', name: 'About', visible: true },
        { id: 'experience', name: 'Experience', visible: true }
      ],

      asideSections: [
        { id: 'education', name: 'Education', visible: true },
        { id: 'skills', name: 'Skills', visible: true },
        { id: 'soft', name: 'Strengths', visible: true },
        { id: 'languages', name: 'Languages', visible: true }
      ],

      get fontClass() {
        return {
          sans: 'font-sans-custom',
          serif: 'font-serif-custom',
          mono: 'font-mono-custom'
        }[this.fontFamily] || 'font-sans-custom';
      },

      init(initialResume) {
        this.resume = initialResume;
        
        // Compute headline role
        if (this.resume.experience && this.resume.experience[0]) {
          this.roleTitle = this.resume.experience[0].title || '';
        } else if (this.resume.education && this.resume.education[0]) {
          this.roleTitle = this.resume.education[0].degree || '';
        } else {
          this.roleTitle = 'Professional';
        }

        // Restore custom preferences
        const saved = localStorage.getItem('resumeSettings_minimal');
        if (saved) {
          try {
            const s = JSON.parse(saved);
            this.fontFamily = s.fontFamily ?? 'sans';
            this.spacing = s.spacing ?? 'normal';
            this.spacingMultiplier = s.spacingMultiplier ?? 1.0;
            this.autoSpace = s.autoSpace ?? true;
            if (s.mainSections) this.mainSections = s.mainSections;
            if (s.asideSections) this.asideSections = s.asideSections;
          } catch(e) {}
        }

        // Trigger fit calculations
        setTimeout(() => this.calculateA4Fit(), 300);
      },

      saveSettings() {
        localStorage.setItem('resumeSettings_minimal', JSON.stringify({
          fontFamily: this.fontFamily,
          spacing: this.spacing,
          spacingMultiplier: this.spacingMultiplier,
          autoSpace: this.autoSpace,
          mainSections: this.mainSections,
          asideSections: this.asideSections
        }));
      },

      // Section sorting
      moveMainSec(idx, dir) {
        const target = idx + dir;
        if (target < 0 || target >= this.mainSections.length) return;
        const item = this.mainSections.splice(idx, 1)[0];
        this.mainSections.splice(target, 0, item);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
      },

      moveAsideSec(idx, dir) {
        const target = idx + dir;
        if (target < 0 || target >= this.asideSections.length) return;
        const item = this.asideSections.splice(idx, 1)[0];
        this.asideSections.splice(target, 0, item);
        this.saveSettings();
        this.$nextTick(() => this.calculateA4Fit());
      },

      // Sub-item insertions/deletions
      addJob() {
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

      // Fit occupancy budgeter
      calculateA4Fit() {
        const page = document.getElementById('resume-page-surface');
        if (!page) return;
        
        // Sum up standard rendered items
        const header = page.querySelector('.top-header');
        const cols = page.querySelector('.body-cols');
        
        if (!header || !cols) return;
        
        // Baseline height measurement without flex grow spacing stretch
        cols.classList.remove('auto-space');
        const contentHeight = header.offsetHeight + cols.scrollHeight + 30; // Margins/padding offset
        
        if (this.autoSpace) {
          cols.classList.add('auto-space');
        }

        const a4MaxHeightPx = page.offsetHeight || 1123;
        const fill = Math.round((contentHeight / a4MaxHeightPx) * 100);
        
        this.fillPercentage = fill;
        this.isOverflowing = fill > 100;
        this.isUnderflowing = fill < 88;
      }
    };
  }
  </script>
</body>
</html>

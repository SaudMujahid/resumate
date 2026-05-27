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
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
@endif

<style>
:root {
  --accent: #1a3a5c;
  --accent-rgb: 26,58,92;
  --stripe: #c9a84c;
  --stripe-light: #f5edd6;
  --text: #1f2937;
  --muted: #6b7280;
  --line: #d1d5db;
  --bg: #f4f3f0;
  
  /* Alpine Spacing variables */
  --spacing-scale: 1.0;
  --section-gap: calc(24px * var(--spacing-scale));
  --item-gap: calc(16px * var(--spacing-scale));
  --timeline-padding: calc(24px * var(--spacing-scale));
}

* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'Source Sans 3', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  padding: 88px 20px 40px; /* Offset for toolbar */
}

/* A4 Page Specifications */
.resume-page {
  width: 210mm;
  height: 297mm;
  min-height: 297mm;
  max-height: 297mm;
  margin: 0 auto;
  background: white;
  box-shadow: 0 8px 50px rgba(0,0,0,.18);
  box-sizing: border-box;
  overflow: hidden;
  position: relative;
  display: flex;
  flex-direction: column;
}

/* Margin preset classes */
.spacing-compact {
  padding: 0 !important;
  --section-gap: calc(18px * var(--spacing-scale)) !important;
  --item-gap: calc(12px * var(--spacing-scale)) !important;
}
.spacing-spacious {
  padding: 0 !important;
  --section-gap: calc(30px * var(--spacing-scale)) !important;
  --item-gap: calc(20px * var(--spacing-scale)) !important;
}

/* Typography styles */
.font-ats { font-family: Arial, sans-serif !important; }
.font-sans-custom { font-family: 'Source Sans 3', sans-serif !important; }
.font-serif-custom { font-family: 'Lora', serif !important; }
.font-mono-custom { font-family: 'Courier New', monospace !important; }

/* Header Band */
.header-band {
  background: var(--accent);
  color: white;
  padding: 30px 45px 26px;
  position: relative;
  overflow: hidden;
}
.header-band::before {
  content: '';
  position: absolute;
  top: 0; right: 0;
  width: 200px; height: 100%;
  background: rgba(255,255,255,.04);
  clip-path: polygon(40% 0, 100% 0, 100% 100%, 0% 100%);
}
.header-band::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 4px;
  background: var(--stripe);
}
.hb-name {
  font-family: 'Lora', serif;
  font-size: calc(32px * var(--spacing-scale));
  font-weight: 600;
  line-height: 1.1;
  letter-spacing: -.01em;
}
.hb-role {
  font-size: 12.5px;
  font-weight: 400;
  letter-spacing: .15em;
  text-transform: uppercase;
  color: var(--stripe);
  margin-top: 5px;
}
.hb-contact {
  display: flex;
  flex-wrap: wrap;
  gap: 6px 24px;
  margin-top: 14px;
}
.hb-contact-item {
  font-size: 12px;
  color: rgba(255,255,255,.85);
  display: flex;
  align-items: center;
  gap: 7px;
}
.hb-contact-item svg { color: var(--stripe); flex-shrink: 0; }

/* Body Layout Columns */
.body-layout {
  display: grid;
  grid-template-columns: 1fr 230px;
  gap: 0;
  flex: 1;
  overflow: hidden;
}
.body-main { 
  padding: 30px 36px 30px 45px; 
  border-right: 1px solid var(--line); 
  display: flex;
  flex-direction: column;
  gap: var(--section-gap);
  height: 100%;
}
.body-aside { 
  padding: 30px 24px 30px 24px; 
  display: flex;
  flex-direction: column;
  gap: var(--section-gap);
  height: 100%;
}

/* Smart spacing stretch */
.body-layout.auto-space .body-main,
.body-layout.auto-space .body-aside {
  justify-content: space-between;
  gap: 0;
}

/* Sections */
.sec-title {
  font-family: 'Lora', serif;
  font-size: calc(14.5px * var(--spacing-scale));
  font-weight: 600;
  color: var(--accent);
  padding-bottom: 6px;
  margin-bottom: var(--item-gap);
  border-bottom: 2px solid var(--stripe);
  letter-spacing: .01em;
}
.aside-sec-title {
  font-size: 9px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .14em;
  color: var(--accent);
  padding-bottom: 6px;
  margin-bottom: var(--item-gap);
  border-bottom: 2px solid var(--line);
}

.summary-text {
  font-size: 13.5px;
  line-height: 1.65;
  color: #374151;
}

/* Dynamic Timelines */
.timeline { 
  position: relative; 
  padding-left: var(--timeline-padding); 
  display: flex;
  flex-direction: column;
  gap: var(--item-gap);
}
.timeline::before {
  content: '';
  position: absolute;
  left: 5px; top: 6px; bottom: 0;
  width: 2px;
  background: var(--line);
}
.tl-item {
  position: relative;
}
.tl-dot {
  position: absolute;
  left: calc(var(--timeline-padding) * -1 + 1px); 
  top: 5px;
  width: 10px; height: 10px;
  border-radius: 50%;
  background: var(--stripe);
  border: 2px solid white;
  box-shadow: 0 0 0 2px var(--stripe);
}
.tl-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.tl-title {
  font-size: 14px;
  font-weight: 600;
  color: var(--text);
}
.tl-company {
  font-size: 12.5px;
  color: var(--accent);
  font-weight: 500;
  margin-top: 1px;
}
.tl-duration {
  font-size: 11px;
  color: white;
  background: var(--accent);
  padding: 2px 8px;
  border-radius: 3px;
  white-space: nowrap;
  flex-shrink: 0;
}
.tl-bullets { list-style: none; margin-top: 8px; display: flex; flex-direction: column; gap: 4px; }
.tl-bullets li {
  font-size: 12.5px;
  color: #4b5563;
  line-height: 1.5;
  padding-left: 14px;
  position: relative;
}
.tl-bullets li::before {
  content: '—';
  position: absolute;
  left: 0;
  color: var(--stripe);
  font-size: 10px;
  top: 1px;
}

/* Academy Aside */
.edu-item-aside { 
  margin-bottom: var(--item-gap); 
  padding-bottom: var(--item-gap); 
  border-bottom: 1px solid var(--line); 
  position: relative;
}
.edu-item-aside:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.edu-level {
  font-size: 8.5px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--stripe);
  margin-bottom: 2px;
}
.edu-degree-a { font-size: 12.5px; font-weight: 600; color: var(--text); line-height: 1.3; }
.edu-school-a { font-size: 11.5px; color: var(--muted); margin-top: 2px; }
.edu-meta-a { font-size: 11px; color: var(--muted); margin-top: 2px; }
.edu-chip {
  display: inline-block;
  margin-top: 4px;
  font-size: 9px;
  background: var(--stripe-light);
  color: #92680a;
  padding: 1px 6px;
  border-radius: 3px;
  font-weight: 600;
}

/* Skills tags */
.skill-tag-wrap { display: flex; flex-wrap: wrap; gap: 5px; }
.skill-tag {
  font-size: 11px;
  background: #f1f5f9;
  color: var(--accent);
  padding: 2px 8px;
  border-radius: 3px;
  font-weight: 500;
}
.lang-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 12px; color: var(--text); }
.lang-lev { font-size: 10.5px; color: var(--muted); }

/* Hover section handles */
.section-wrapper {
  position: relative;
  transition: all 0.2s ease;
}
@media screen {
  .section-wrapper:hover {
    background-color: rgba(26, 58, 92, 0.03);
    box-shadow: 0 0 0 6px rgba(26, 58, 92, 0.03);
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

/* contenteditable outline */
[contenteditable] { outline: none; border-radius: 2px; transition: background .15s; cursor: text; }
[contenteditable]:hover { background: rgba(201,168,76,.1); }
[contenteditable]:focus { background: rgba(201,168,76,.18); outline: 1.5px dashed var(--stripe); }

/* Print rules */
@media print {
  body { background: white; padding: 0; }
  .no-print, .visual-handle-bar { display: none !important; }
  .resume-page { box-shadow: none; margin: 0; width: 210mm; height: 297mm; }
  [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
}

@if(!empty($forPdf))
* { font-family: 'DejaVu Sans', sans-serif !important; }
.hb-name, .sec-title { font-family: 'DejaVu Serif', serif !important; }
body { padding: 0 !important; background: white !important; }
.resume-page { box-shadow: none !important; }
@endif
</style>
</head>
<body x-data="resumeApp()" x-init="init(@js($resume))" :class="fontClass">

  @if(empty($forPdf))
  <x-resume-toolbar template="chronological" />
  @endif

  <!-- A4 Main Sheet -->
  <div class="resume-page"
       :class="[
         spacing === 'compact' && 'spacing-compact',
         spacing === 'spacious' && 'spacing-spacious'
       ]"
       :style="`--spacing-scale: ${spacingMultiplier};`"
       id="resume-page-surface">

    <!-- Header Band -->
    <div class="header-band">
      <div class="hb-name" contenteditable="true" spellcheck="false" @blur="resume.name = $el.innerText; calculateA4Fit()" x-text="resume.name"></div>
      <div class="hb-role" contenteditable="true" spellcheck="false" @blur="roleTitle = $el.innerText; calculateA4Fit()" x-text="roleTitle"></div>
      
      <div class="hb-contact">
        <div class="hb-contact-item">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
          <span contenteditable="true" spellcheck="false" @blur="resume.email = $el.innerText; calculateA4Fit()" x-text="resume.email"></span>
        </div>
        <template x-if="resume.phone">
          <div class="hb-contact-item">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 19.79 19.79 0 01.21 7a2 2 0 012-2.18h3a2 2 0 012 1.72 12.6 12.6 0 00.57 2.57 2 2 0 01-.45 2.11L6.91 12a16 16 0 006 6l.42-.42a2 2 0 012.11-.45 12.6 12.6 0 002.57.57A2 2 0 0122 20z"/></svg>
            <span contenteditable="true" spellcheck="false" @blur="resume.phone = $el.innerText; calculateA4Fit()" x-text="resume.phone"></span>
          </div>
        </template>
        <template x-if="resume.city">
          <div class="hb-contact-item">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
            <span contenteditable="true" spellcheck="false" @blur="resume.city = $el.innerText; calculateA4Fit()" x-text="resume.city"></span>
          </div>
        </template>
      </div>
    </div>

    <!-- Body Layout Columns -->
    <div class="body-layout" :class="autoSpace && 'auto-space'">

      <!-- Main Column -->
      <div class="body-main">
        <template x-for="(sec, secIdx) in mainSections" :key="sec.id">
          <div x-show="sec.visible" class="section-wrapper">
            
            <!-- Floating Handles -->
            <div class="no-print visual-handle-bar">
              <button class="handle-btn" @click="moveMainSec(secIdx, -1)" :disabled="secIdx === 0" title="Move Up">↑</button>
              <button class="handle-btn" @click="moveMainSec(secIdx, 1)" :disabled="secIdx === mainSections.length - 1" title="Move Down">↓</button>
              <button class="handle-btn btn-del" @click="sec.visible = false; calculateA4Fit()" title="Hide">👁</button>
            </div>

            <!-- Profile Summary Section -->
            <template x-if="sec.id === 'summary' && resume.summary">
              <div class="section">
                <div class="sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name"></div>
                <div class="summary-text" contenteditable="true" spellcheck="false" @blur="resume.summary = $el.innerText; calculateA4Fit()" x-text="resume.summary"></div>
              </div>
            </template>

            <!-- Experience Timeline Section -->
            <template x-if="sec.id === 'experience' && resume.experience">
              <div class="section">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--stripe); padding-bottom:6px; margin-bottom:var(--item-gap);">
                  <div class="sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="border:none; margin:0; padding:0; flex:1;"></div>
                  <button class="no-print handle-btn" @click="addJob()" style="font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add Job</button>
                </div>
                
                <div class="timeline">
                  <template x-for="(exp, expIdx) in resume.experience" :key="expIdx">
                    <div class="tl-item group/item">
                      <div class="tl-dot"></div>
                      
                      <!-- Item operations -->
                      <div class="no-print absolute -right-6 top-0 hidden group-hover/item:flex gap-1">
                        <button class="handle-btn btn-del" @click="delJob(expIdx)" title="Delete Item">×</button>
                      </div>

                      <div class="tl-header">
                        <div>
                          <div class="tl-title" contenteditable="true" spellcheck="false" @blur="exp.title = $el.innerText; calculateA4Fit()" x-text="exp.title"></div>
                          <div class="tl-company" contenteditable="true" spellcheck="false" @blur="exp.company = $el.innerText; calculateA4Fit()" x-text="exp.company"></div>
                        </div>
                        <div class="tl-duration" contenteditable="true" spellcheck="false" @blur="exp.duration = $el.innerText; calculateA4Fit()" x-text="exp.duration"></div>
                      </div>

                      <!-- Bullet Lists -->
                      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:4px;">
                        <span class="no-print"></span>
                        <button class="no-print handle-btn" @click="addBullet(expIdx)" style="font-size:8px; border:1px dashed #e2e8f0; width:auto; padding:0 4px;">+ Bullet</button>
                      </div>
                      <ul class="tl-bullets" x-show="exp.responsibilities && exp.responsibilities.length > 0">
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

      <!-- Aside Column -->
      <div class="body-aside">
        <template x-for="(sec, secIdx) in asideSections" :key="sec.id">
          <div x-show="sec.visible" class="section-wrapper">
            
            <!-- Floating Handles -->
            <div class="no-print visual-handle-bar" style="left:auto; right:-32px;">
              <button class="handle-btn" @click="moveAsideSec(secIdx, -1)" :disabled="secIdx === 0" title="Move Up">↑</button>
              <button class="handle-btn" @click="moveAsideSec(secIdx, 1)" :disabled="secIdx === asideSections.length - 1" title="Move Down">↓</button>
              <button class="handle-btn btn-del" @click="sec.visible = false; calculateA4Fit()" title="Hide">👁</button>
            </div>

            <!-- Education Section -->
            <template x-if="sec.id === 'education' && resume.education">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--line); padding-bottom:6px; margin-bottom:var(--item-gap);">
                  <div class="aside-sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="border:none; margin:0; padding:0; flex:1;"></div>
                  <button class="no-print handle-btn" @click="addEdu()" style="font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add</button>
                </div>
                
                <div style="display:flex; flex-direction:column; gap:var(--item-gap);">
                  <template x-for="(edu, eduIdx) in resume.education" :key="eduIdx">
                    <div class="edu-item-aside group/item">
                      <div class="no-print absolute -right-5 top-0 hidden group-hover/item:flex">
                        <button class="handle-btn btn-del" @click="delEdu(eduIdx)">×</button>
                      </div>
                      <div class="edu-level" contenteditable="true" @blur="edu.level = $el.innerText" x-text="edu.level"></div>
                      <div class="edu-degree-a" contenteditable="true" spellcheck="false" @blur="edu.degree = $el.innerText; calculateA4Fit()" x-text="edu.degree"></div>
                      <div class="edu-school-a" contenteditable="true" spellcheck="false" @blur="edu.school = $el.innerText; calculateA4Fit()" x-text="edu.school"></div>
                      <div class="edu-meta-a" contenteditable="true" spellcheck="false" @blur="edu.year = $el.innerText; calculateA4Fit()" x-text="'Class of ' + edu.year"></div>
                      
                      <div style="margin-top:4px;">
                        <span class="edu-chip" contenteditable="true" @blur="edu.cgpa = $el.innerText; calculateA4Fit()" x-text="edu.cgpa ? 'CGPA ' + edu.cgpa : (edu.grade ? 'GPA ' + edu.grade : 'GPA N/A')"></span>
                      </div>
                    </div>
                  </template>
                </div>
              </div>
            </template>

            <!-- Technical Skills Section -->
            <template x-if="sec.id === 'skills' && resume.skills && resume.skills.technical">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--line); padding-bottom:6px; margin-bottom:var(--item-gap);">
                  <div class="aside-sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="border:none; margin:0; padding:0; flex:1;"></div>
                  <button class="no-print handle-btn" @click="addTechSkill()" style="font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Skill</button>
                </div>
                <div class="skill-tag-wrap">
                  <template x-for="(skill, sIdx) in resume.skills.technical" :key="sIdx">
                    <span class="skill-tag" style="display:inline-flex; align-items:center; gap:4px;">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.technical[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                      <button class="no-print handle-btn btn-del" @click="delTechSkill(sIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                    </span>
                  </template>
                </div>
              </div>
            </template>

            <!-- Soft Skills Section -->
            <template x-if="sec.id === 'soft' && resume.skills && resume.skills.soft">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--line); padding-bottom:6px; margin-bottom:var(--item-gap);">
                  <div class="aside-sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="border:none; margin:0; padding:0; flex:1;"></div>
                  <button class="no-print handle-btn" @click="addSoftSkill()" style="font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Add</button>
                </div>
                <div class="skill-tag-wrap">
                  <template x-for="(skill, sIdx) in resume.skills.soft" :key="sIdx">
                    <span class="skill-tag" style="display:inline-flex; align-items:center; gap:4px;">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.soft[sIdx] = $el.innerText; calculateA4Fit()" x-text="skill"></span>
                      <button class="no-print handle-btn btn-del" @click="delSoftSkill(sIdx)" style="width:12px; height:12px; font-size:8px;">×</button>
                    </span>
                  </template>
                </div>
              </div>
            </template>

            <!-- Languages Section -->
            <template x-if="sec.id === 'languages' && resume.skills && resume.skills.languages">
              <div class="aside-section">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--line); padding-bottom:6px; margin-bottom:var(--item-gap);">
                  <div class="aside-sec-title" contenteditable="true" @blur="sec.name = $el.innerText" x-text="sec.name" style="border:none; margin:0; padding:0; flex:1;"></div>
                  <button class="no-print handle-btn" @click="addLang()" style="font-size:9px; border:1px dashed #cbd5e1; width:auto; padding:1px 6px;">+ Lang</button>
                </div>
                <div>
                  <template x-for="(lang, lIdx) in resume.skills.languages" :key="lIdx">
                    <div class="lang-row group/lang">
                      <span contenteditable="true" spellcheck="false" @blur="resume.skills.languages[lIdx] = $el.innerText; calculateA4Fit()" x-text="lang"></span>
                      <span style="display:flex; align-items:center; gap:4px;">
                        <span class="lang-lev" x-text="lIdx === 0 ? 'Native' : (lIdx === 1 ? 'Fluent' : 'Intermediate')"></span>
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

    </div><!-- /body-layout -->

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

      mainSections: [
        { id: 'summary', name: 'Profile', visible: true },
        { id: 'experience', name: 'Work Experience', visible: true }
      ],

      asideSections: [
        { id: 'education', name: 'Education', visible: true },
        { id: 'skills', name: 'Technical Skills', visible: true },
        { id: 'soft', name: 'Soft Skills', visible: true },
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
        const saved = localStorage.getItem('resumeSettings_chronological');
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
        localStorage.setItem('resumeSettings_chronological', JSON.stringify({
          fontFamily: this.fontFamily,
          spacing: this.spacing,
          spacingMultiplier: this.spacingMultiplier,
          autoSpace: this.autoSpace,
          mainSections: this.mainSections,
          asideSections: this.asideSections
        }));
      },

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

      calculateA4Fit() {
        const page = document.getElementById('resume-page-surface');
        if (!page) return;
        
        const header = page.querySelector('.header-band');
        const cols = page.querySelector('.body-layout');
        
        if (!header || !cols) return;
        
        cols.classList.remove('auto-space');
        const contentHeight = header.offsetHeight + cols.scrollHeight + 10;
        
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

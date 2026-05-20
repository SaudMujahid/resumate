<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>
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
}
* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'Jost', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  padding: 80px 20px 60px;
}


/* ── RESUME ──────────────────────── */
.resume-page {
  max-width: 760px;
  margin: 0 auto;
  background: white;
  box-shadow: 0 4px 40px rgba(0,0,0,.08), 0 1px 3px rgba(0,0,0,.06);
  padding: 64px 72px;
}

/* ── TOP HEADER ──────────────────── */
.top-header {
  display: grid;
  grid-template-columns: 1fr auto;
  align-items: end;
  padding-bottom: 28px;
  border-bottom: 1.5px solid var(--ink);
  gap: 24px;
}
.th-name {
  font-family: 'Playfair Display', serif;
  font-size: 42px;
  font-weight: 400;
  line-height: 1.05;
  color: var(--ink);
  letter-spacing: -.02em;
}
.th-role {
  font-size: 12px;
  font-weight: 300;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--accent);
  margin-top: 8px;
}
.th-contact {
  text-align: right;
  display: flex;
  flex-direction: column;
  gap: 5px;
}
.th-contact-item {
  font-size: 12.5px;
  color: var(--mid);
  font-weight: 300;
}

/* ── BODY ────────────────────────── */
.body-cols {
  display: grid;
  grid-template-columns: 1fr 200px;
  gap: 0 48px;
  margin-top: 36px;
}

/* ── SECTION ─────────────────────── */
.section { margin-bottom: 34px; }
.sec-label {
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 16px;
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

/* ── SUMMARY ─────────────────────── */
.summary-text {
  font-size: 14px;
  font-weight: 300;
  line-height: 1.85;
  color: var(--mid);
}

/* ── EXPERIENCE ──────────────────── */
.exp-item { margin-bottom: 26px; }
.exp-item:last-child { margin-bottom: 0; }
.exp-row-1 { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; }
.exp-title-min {
  font-size: 15px;
  font-weight: 500;
  color: var(--ink);
}
.exp-dur-min {
  font-size: 11.5px;
  color: var(--soft);
  font-weight: 300;
  white-space: nowrap;
}
.exp-company-min {
  font-size: 13px;
  font-weight: 300;
  color: var(--accent);
  margin-top: 2px;
}
.exp-list { margin-top: 9px; padding-left: 0; list-style: none; display: flex; flex-direction: column; gap: 5px; }
.exp-list li {
  font-size: 13px;
  color: var(--mid);
  line-height: 1.65;
  font-weight: 300;
  padding-left: 16px;
  position: relative;
}
.exp-list li::before {
  content: '·';
  position: absolute;
  left: 4px;
  color: var(--accent);
  font-size: 18px;
  line-height: 1;
  top: 0;
}

/* ── ASIDE ───────────────────────── */
.aside-section { margin-bottom: 30px; }
.aside-sec-label {
  font-size: 9.5px;
  font-weight: 600;
  letter-spacing: .2em;
  text-transform: uppercase;
  color: var(--soft);
  margin-bottom: 14px;
  padding-bottom: 8px;
  border-bottom: 1px solid var(--rule);
}

/* Education */
.edu-block { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--rule); }
.edu-block:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.edu-level-tag {
  font-size: 9px;
  font-weight: 600;
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--accent);
  margin-bottom: 3px;
}
.edu-degree-min { font-size: 13px; font-weight: 500; color: var(--ink); line-height: 1.35; }
.edu-school-min { font-size: 12px; font-weight: 300; color: var(--mid); margin-top: 2px; }
.edu-year-min { font-size: 11px; color: var(--soft); margin-top: 2px; }
.edu-gpa-min {
  display: inline-block;
  margin-top: 5px;
  font-size: 10px;
  font-weight: 600;
  color: var(--accent);
  background: var(--accent-pale);
  padding: 1px 7px;
  border-radius: 2px;
  letter-spacing: .04em;
}

/* Skills */
.skill-list { display: flex; flex-direction: column; gap: 5px; }
.skill-line {
  font-size: 12.5px;
  font-weight: 300;
  color: var(--mid);
  padding-bottom: 5px;
  border-bottom: 1px solid var(--rule);
}
.skill-line:last-child { border-bottom: none; }

/* Languages */
.lang-stack { display: flex; flex-direction: column; gap: 8px; }
.lang-row-min { display: flex; justify-content: space-between; font-size: 12.5px; color: var(--ink); font-weight: 300; }
.lang-lvl-min { font-size: 11px; color: var(--soft); }

/* Soft Skills */
.soft-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.soft-tag {
  font-size: 11px;
  font-weight: 400;
  color: var(--mid);
  border: 1px solid var(--rule);
  padding: 3px 9px;
  border-radius: 2px;
}

/* ── CONTENTEDITABLE ─────────────── */
[contenteditable] { outline: none; border-radius: 2px; transition: background .12s; cursor: text; }
[contenteditable]:hover { background: var(--accent-pale); }
[contenteditable]:focus { background: var(--accent-pale); outline: 1px dashed var(--accent); }

/* ── PRINT ───────────────────────── */
@media print {
  body { background: white; padding: 0; }
  .toolbar { display: none !important; }
  .resume-page { box-shadow: none; padding: 48px 56px; }
  [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
}

/* PDF font override (DomPDF cannot load Google Fonts) */
@if(!empty($forPdf))
* { font-family: 'DejaVu Sans', sans-serif !important; }
.th-name {
  font-family: 'DejaVu Serif', serif !important;
}
body { padding: 0 !important; background: white !important; }
.resume-page { box-shadow: none !important; padding: 48px 56px !important; }
@endif
</style>
</head>
<body>

@if(empty($forPdf))
<x-resume-toolbar template="minimal" />
@endif


<!-- ═══ RESUME ═══ -->
<div class="resume-page">

  <!-- Top Header -->
  <div class="top-header">
    <div>
      <div class="th-name" contenteditable="true" spellcheck="false">{{ $resume['name'] }}</div>
      @if(!empty($resume['experience'][0]['title']))
        <div class="th-role" contenteditable="true" spellcheck="false">{{ $resume['experience'][0]['title'] }}</div>
      @elseif(!empty($resume['education'][0]['degree']))
        <div class="th-role" contenteditable="true" spellcheck="false">{{ $resume['education'][0]['degree'] }}</div>
      @endif
    </div>
    <div class="th-contact">
      <div class="th-contact-item" contenteditable="true" spellcheck="false">{{ $resume['email'] }}</div>
      @if(!empty($resume['phone']))
        <div class="th-contact-item" contenteditable="true" spellcheck="false">{{ $resume['phone'] }}</div>
      @endif
      @if(!empty($resume['city']))
        <div class="th-contact-item" contenteditable="true" spellcheck="false">{{ $resume['city'] }}</div>
      @endif
    </div>
  </div>

  <!-- Body -->
  <div class="body-cols">

    <!-- Left: Main -->
    <div class="body-main">

      <!-- Summary -->
      @if(!empty($resume['summary']))
      <div class="section">
        <div class="sec-label">About</div>
        <div class="summary-text" contenteditable="true" spellcheck="false">{{ $resume['summary'] }}</div>
      </div>
      @endif

      <!-- Experience -->
      @if(!empty($resume['experience']))
      <div class="section">
        <div class="sec-label">Experience</div>
        @foreach($resume['experience'] as $exp)
        <div class="exp-item">
          <div class="exp-row-1">
            <div class="exp-title-min" contenteditable="true" spellcheck="false">{{ $exp['title'] ?? '' }}</div>
            @if(!empty($exp['duration']))
            <div class="exp-dur-min" contenteditable="true" spellcheck="false">{{ $exp['duration'] }}</div>
            @endif
          </div>
          <div class="exp-company-min" contenteditable="true" spellcheck="false">{{ $exp['company'] ?? '' }}</div>
          @if(!empty($exp['responsibilities']))
          <ul class="exp-list">
            @foreach($exp['responsibilities'] as $resp)
            <li contenteditable="true" spellcheck="false">{{ $resp }}</li>
            @endforeach
          </ul>
          @endif
        </div>
        @endforeach
      </div>
      @endif

    </div><!-- /body-main -->

    <!-- Right: Aside -->
    <div class="body-aside">

      <!-- Education -->
      @if(!empty($resume['education']))
      <div class="aside-section">
        <div class="aside-sec-label">Education</div>
        @foreach($resume['education'] as $edu)
        <div class="edu-block">
          <div class="edu-level-tag">{{ $edu['level'] ?? '' }}</div>
          @if(!empty($edu['degree']))
            <div class="edu-degree-min" contenteditable="true" spellcheck="false">{{ $edu['degree'] }}@if(!empty($edu['major'])), {{ $edu['major'] }}@endif</div>
          @endif
          <div class="edu-school-min" contenteditable="true" spellcheck="false">{{ $edu['school'] ?? '' }}</div>
          @if(!empty($edu['year']))
            <div class="edu-year-min" contenteditable="true" spellcheck="false">{{ $edu['year'] }}</div>
          @endif
          @if(!empty($edu['cgpa']))
            <span class="edu-gpa-min">CGPA {{ $edu['cgpa'] }}</span>
          @elseif(!empty($edu['grade']))
            <span class="edu-gpa-min">GPA {{ $edu['grade'] }}</span>
          @endif
        </div>
        @endforeach
      </div>
      @endif

      <!-- Technical Skills -->
      @if(!empty($resume['skills']['technical']))
      <div class="aside-section">
        <div class="aside-sec-label">Skills</div>
        <div class="skill-list">
          @foreach($resume['skills']['technical'] as $skill)
          <div class="skill-line" contenteditable="true" spellcheck="false">{{ $skill }}</div>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Soft Skills -->
      @if(!empty($resume['skills']['soft']))
      <div class="aside-section">
        <div class="aside-sec-label">Strengths</div>
        <div class="soft-tags">
          @foreach($resume['skills']['soft'] as $skill)
          <span class="soft-tag" contenteditable="true" spellcheck="false">{{ $skill }}</span>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Languages -->
      @if(!empty($resume['skills']['languages']))
      <div class="aside-section">
        <div class="aside-sec-label">Languages</div>
        <div class="lang-stack">
          @foreach($resume['skills']['languages'] as $i => $lang)
          <div class="lang-row-min">
            <span contenteditable="true" spellcheck="false">{{ $lang }}</span>
            <span class="lang-lvl-min">{{ $i===0?'Native':($i===1?'Fluent':'Intermediate') }}</span>
          </div>
          @endforeach
        </div>
      </div>
      @endif

    </div><!-- /body-aside -->
  </div><!-- /body-cols -->
</div><!-- /resume-page -->

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
:root {
  --hue: 220;
  --accent: hsl(var(--hue), 70%, 45%);
  --accent-dark: hsl(var(--hue), 75%, 28%);
  --accent-mid: hsl(var(--hue), 55%, 38%);
  --sidebar-bg: hsl(var(--hue), 40%, 18%);
  --sidebar-sec: hsl(var(--hue), 35%, 24%);
  --sidebar-text: hsl(var(--hue), 20%, 85%);
  --sidebar-muted: hsl(var(--hue), 15%, 60%);
  --dot-active: hsl(var(--hue), 70%, 65%);
}
* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'DM Sans', sans-serif;
  background: #e8eaf0;
  min-height: 100vh;
  padding: 80px 20px 40px;
}


/* ── RESUME PAGE ───────────────────────────── */
.resume-page {
  max-width: 860px;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 260px 1fr;
  min-height: 1050px;
  box-shadow: 0 12px 60px rgba(0,0,0,.22);
  border-radius: 3px;
  overflow: hidden;
}

/* ── SIDEBAR ───────────────────────────────── */
.sidebar {
  background: var(--sidebar-bg);
  color: white;
  padding: 40px 26px;
  display: flex;
  flex-direction: column;
  gap: 32px;
}
.avatar-block {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
}
.avatar {
  width: 88px; height: 88px;
  border-radius: 50%;
  background: var(--accent);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'DM Serif Display', serif;
  font-size: 32px;
  color: white;
  letter-spacing: .02em;
  flex-shrink: 0;
}
.sidebar-name {
  font-family: 'DM Serif Display', serif;
  font-size: 20px;
  line-height: 1.25;
  text-align: center;
  color: white;
}
.sidebar-title {
  font-size: 12px;
  color: var(--dot-active);
  text-align: center;
  letter-spacing: .06em;
  text-transform: uppercase;
  margin-top: -8px;
}
.sidebar-section { display: flex; flex-direction: column; gap: 14px; }
.sidebar-section-title {
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .12em;
  color: var(--dot-active);
  padding-bottom: 8px;
  border-bottom: 1px solid hsla(0,0%,100%,.1);
}
.contact-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  font-size: 12.5px;
  color: var(--sidebar-text);
  line-height: 1.45;
}
.contact-icon {
  width: 18px;
  flex-shrink: 0;
  margin-top: 1px;
  color: var(--dot-active);
}
.skill-row { display: flex; flex-direction: column; gap: 9px; }
.skill-item { display: flex; flex-direction: column; gap: 5px; }
.skill-name {
  font-size: 12px;
  color: var(--sidebar-text);
  display: flex;
  justify-content: space-between;
}
.skill-bar-bg {
  height: 4px;
  background: hsla(0,0%,100%,.12);
  border-radius: 99px;
  overflow: hidden;
}
.skill-bar-fill {
  height: 100%;
  background: var(--dot-active);
  border-radius: 99px;
}
.dot-skills { display: flex; flex-direction: column; gap: 8px; }
.dot-skill-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; color: var(--sidebar-text); }
.dots { display: flex; gap: 4px; }
.dot {
  width: 7px; height: 7px;
  border-radius: 50%;
  background: hsla(0,0%,100%,.15);
}
.dot.on { background: var(--dot-active); }
.lang-list { display: flex; flex-direction: column; gap: 8px; }
.lang-item { font-size: 12.5px; color: var(--sidebar-text); display: flex; justify-content: space-between; }
.lang-level { font-size: 11px; color: var(--sidebar-muted); }

/* ── MAIN CONTENT ──────────────────────────── */
.main-content {
  background: white;
  padding: 44px 40px;
  display: flex;
  flex-direction: column;
  gap: 28px;
}
.main-header { border-bottom: 2.5px solid var(--accent); padding-bottom: 18px; }
.main-name {
  font-family: 'DM Serif Display', serif;
  font-size: 34px;
  line-height: 1.1;
  color: #111827;
}
.main-role {
  font-size: 13px;
  color: var(--accent-mid);
  font-weight: 500;
  letter-spacing: .05em;
  text-transform: uppercase;
  margin-top: 4px;
}
.section { display: flex; flex-direction: column; gap: 14px; }
.section-title {
  font-size: 10.5px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .12em;
  color: var(--accent-mid);
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-title::after {
  content: '';
  flex: 1;
  height: 1px;
  background: #e5e7eb;
}
.summary-text {
  font-size: 13.5px;
  line-height: 1.75;
  color: #374151;
}
.exp-item { display: flex; flex-direction: column; gap: 5px; padding-bottom: 18px; border-bottom: 1px solid #f3f4f6; }
.exp-item:last-child { border-bottom: none; padding-bottom: 0; }
.exp-header { display: flex; justify-content: space-between; align-items: flex-start; }
.exp-title { font-size: 14.5px; font-weight: 600; color: #111827; }
.exp-duration {
  font-size: 11.5px;
  color: white;
  background: var(--accent);
  padding: 2px 10px;
  border-radius: 99px;
  white-space: nowrap;
  margin-left: 8px;
  flex-shrink: 0;
}
.exp-company { font-size: 13px; color: var(--accent-mid); font-weight: 500; }
.exp-bullets { list-style: none; display: flex; flex-direction: column; gap: 5px; margin-top: 6px; }
.exp-bullets li {
  font-size: 13px;
  color: #4b5563;
  line-height: 1.6;
  padding-left: 14px;
  position: relative;
}
.exp-bullets li::before {
  content: '▸';
  position: absolute;
  left: 0;
  color: var(--accent);
  font-size: 10px;
  top: 3px;
}
.edu-grid { display: flex; flex-direction: column; gap: 14px; }
.edu-item {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: 12px;
  align-items: start;
}
.edu-dot {
  width: 10px; height: 10px;
  border-radius: 50%;
  background: var(--accent);
  margin-top: 5px;
  flex-shrink: 0;
}
.edu-degree { font-size: 14px; font-weight: 600; color: #111827; }
.edu-school { font-size: 12.5px; color: #6b7280; margin-top: 2px; }
.edu-meta { font-size: 12px; color: #9ca3af; margin-top: 3px; }
.edu-badge {
  display: inline-block;
  font-size: 10.5px;
  background: var(--accent);
  color: white;
  padding: 1px 8px;
  border-radius: 99px;
  margin-top: 4px;
}

/* ── CONTENTEDITABLE STYLING ───────────────── */
[contenteditable] {
  outline: none;
  border-radius: 3px;
  transition: background .15s;
  cursor: text;
}
[contenteditable]:hover { background: rgba(99,102,241,.06); }
[contenteditable]:focus { background: rgba(99,102,241,.1); outline: 1.5px dashed var(--accent); }

/* ── PRINT ─────────────────────────────────── */
@media print {
  body { background: white; padding: 0; }
  .toolbar { display: none !important; }
  .resume-page { box-shadow: none; max-width: 100%; border-radius: 0; }
  [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
}
</style>
</head>
<body>

<x-resume-toolbar template="modern" />

<!-- ═══════════════════════════════ RESUME ════════════════════ -->
<div class="resume-page" id="resume">

  <!-- ── SIDEBAR ── -->
  <div class="sidebar">

    <!-- Avatar + Name -->
    <div class="avatar-block">
      <div class="avatar" id="initials">{{ strtoupper(mb_substr(explode(' ', $resume['name'])[0], 0, 1)) }}{{ strtoupper(mb_substr(explode(' ', $resume['name'])[count(explode(' ', $resume['name']))-1], 0, 1)) }}</div>
      <div class="sidebar-name" contenteditable="true" spellcheck="false">{{ $resume['name'] }}</div>
      @if(!empty($resume['experience'][0]['title']))
        <div class="sidebar-title" contenteditable="true" spellcheck="false">{{ $resume['experience'][0]['title'] }}</div>
      @elseif(!empty($resume['education'][0]['degree']))
        <div class="sidebar-title" contenteditable="true" spellcheck="false">{{ $resume['education'][0]['degree'] ?? 'Student' }}</div>
      @endif
    </div>

    <!-- Contact -->
    <div class="sidebar-section">
      <div class="sidebar-section-title">Contact</div>
      <div class="contact-item">
        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['email'] }}</span>
      </div>
      @if(!empty($resume['phone']))
      <div class="contact-item">
        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 19.79 19.79 0 01.21 7a2 2 0 012-2.18h3a2 2 0 012 1.72 12.6 12.6 0 00.57 2.57 2 2 0 01-.45 2.11L6.91 12a16 16 0 006 6l.42-.42a2 2 0 012.11-.45 12.6 12.6 0 002.57.57A2 2 0 0122 20z"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['phone'] }}</span>
      </div>
      @endif
      @if(!empty($resume['city']))
      <div class="contact-item">
        <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['city'] }}</span>
      </div>
      @endif
    </div>

    <!-- Technical Skills -->
    @if(!empty($resume['skills']['technical']))
    <div class="sidebar-section">
      <div class="sidebar-section-title">Technical Skills</div>
      <div class="skill-row">
        @foreach($resume['skills']['technical'] as $i => $skill)
        @php $pct = max(60, 100 - ($i * 8)); @endphp
        <div class="skill-item">
          <div class="skill-name">
            <span contenteditable="true" spellcheck="false">{{ $skill }}</span>
          </div>
          <div class="skill-bar-bg"><div class="skill-bar-fill" style="width:{{ $pct }}%"></div></div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Soft Skills -->
    @if(!empty($resume['skills']['soft']))
    <div class="sidebar-section">
      <div class="sidebar-section-title">Soft Skills</div>
      <div class="dot-skills">
        @foreach($resume['skills']['soft'] as $i => $skill)
        <div class="dot-skill-item">
          <div class="dots">
            @for($d=0;$d<5;$d++)<div class="dot {{ $d < 4-($i%2) ? 'on' : '' }}"></div>@endfor
          </div>
          <span contenteditable="true" spellcheck="false">{{ $skill }}</span>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    <!-- Languages -->
    @if(!empty($resume['skills']['languages']))
    <div class="sidebar-section">
      <div class="sidebar-section-title">Languages</div>
      <div class="lang-list">
        @foreach($resume['skills']['languages'] as $i => $lang)
        <div class="lang-item">
          <span contenteditable="true" spellcheck="false">{{ $lang }}</span>
          <span class="lang-level">{{ $i === 0 ? 'Native' : ($i === 1 ? 'Fluent' : 'Intermediate') }}</span>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div><!-- /sidebar -->

  <!-- ── MAIN CONTENT ── -->
  <div class="main-content">

    <!-- Header -->
    <div class="main-header">
      <div class="main-name" contenteditable="true" spellcheck="false">{{ $resume['name'] }}</div>
      @if(!empty($resume['experience'][0]['title']))
        <div class="main-role" contenteditable="true" spellcheck="false">{{ $resume['experience'][0]['title'] }}@if(!empty($resume['experience'][0]['company'])) &nbsp;·&nbsp; {{ $resume['experience'][0]['company'] }}@endif</div>
      @elseif(!empty($resume['education'][0]['degree']))
        <div class="main-role" contenteditable="true" spellcheck="false">{{ $resume['education'][0]['degree'] }}@if(!empty($resume['education'][0]['school'])) &nbsp;·&nbsp; {{ $resume['education'][0]['school'] }}@endif</div>
      @endif
    </div>

    <!-- Summary -->
    @if(!empty($resume['summary']))
    <div class="section">
      <div class="section-title">Professional Summary</div>
      <div class="summary-text" contenteditable="true" spellcheck="false">{{ $resume['summary'] }}</div>
    </div>
    @endif

    <!-- Experience -->
    @if(!empty($resume['experience']))
    <div class="section">
      <div class="section-title">Experience</div>
      @foreach($resume['experience'] as $exp)
      <div class="exp-item">
        <div class="exp-header">
          <div>
            <div class="exp-title" contenteditable="true" spellcheck="false">{{ $exp['title'] ?? '' }}</div>
            <div class="exp-company" contenteditable="true" spellcheck="false">{{ $exp['company'] ?? '' }}</div>
          </div>
          @if(!empty($exp['duration']))
          <div class="exp-duration" contenteditable="true" spellcheck="false">{{ $exp['duration'] }}</div>
          @endif
        </div>
        @if(!empty($exp['responsibilities']))
        <ul class="exp-bullets">
          @foreach($exp['responsibilities'] as $resp)
          <li contenteditable="true" spellcheck="false">{{ $resp }}</li>
          @endforeach
        </ul>
        @endif
      </div>
      @endforeach
    </div>
    @endif

    <!-- Education -->
    @if(!empty($resume['education']))
    <div class="section">
      <div class="section-title">Education</div>
      <div class="edu-grid">
        @foreach($resume['education'] as $edu)
        <div class="edu-item">
          <div class="edu-dot"></div>
          <div>
            @if(!empty($edu['degree']))
              <div class="edu-degree" contenteditable="true" spellcheck="false">{{ $edu['degree'] }}@if(!empty($edu['major'])) in {{ $edu['major'] }}@endif</div>
            @else
              <div class="edu-degree" contenteditable="true" spellcheck="false">{{ $edu['level'] }}</div>
            @endif
            <div class="edu-school" contenteditable="true" spellcheck="false">{{ $edu['school'] ?? '' }}@if(!empty($edu['year'])) &nbsp;·&nbsp; {{ $edu['year'] }}@endif</div>
            @if(!empty($edu['cgpa']))
              <span class="edu-badge">CGPA {{ $edu['cgpa'] }}</span>
            @elseif(!empty($edu['grade']))
              <span class="edu-badge">GPA {{ $edu['grade'] }}</span>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div><!-- /main-content -->
</div><!-- /resume-page -->
<script>
// ── Initials sync ─────────────────────────────
const mainNameEl = document.querySelector('.main-content .main-name');
const sideNameEl = document.querySelector('.sidebar .sidebar-name');
const initialsEl = document.getElementById('initials');

</script>
</body>
</html>

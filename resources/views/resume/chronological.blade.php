<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Source+Sans+3:wght@300;400;500;600&display=swap" rel="stylesheet">
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
}
* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: 'Source Sans 3', sans-serif;
  background: var(--bg);
  min-height: 100vh;
  padding: 80px 20px 40px;
}

/* ── TOOLBAR ─────────────────────── */
.toolbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 999;
  background: var(--accent);
  padding: 10px 28px;
  display: flex;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
  box-shadow: 0 3px 14px rgba(0,0,0,.25);
}
.toolbar-label {
  font-size: 11px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .08em;
  color: rgba(255,255,255,.55);
}
.color-swatches { display: flex; gap: 7px; align-items: center; }
.swatch {
  width: 24px; height: 24px;
  border-radius: 4px;
  cursor: pointer;
  border: 2px solid transparent;
  transition: transform .15s, border-color .15s;
}
.swatch:hover { transform: scale(1.15); }
.swatch.active { border-color: white; }
.color-picker-wrap { display: flex; align-items: center; gap: 6px; cursor: pointer; }
.color-picker-wrap input[type=color] {
  width: 24px; height: 24px;
  border: 2px solid rgba(255,255,255,.4);
  border-radius: 4px;
  cursor: pointer;
  padding: 0;
  background: none;
}
.toolbar-sep { width: 1px; height: 26px; background: rgba(255,255,255,.2); }
.toolbar-btn {
  display: flex;
  align-items: center;
  gap: 7px;
  padding: 6px 14px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  border: 1.5px solid rgba(255,255,255,.3);
  background: transparent;
  color: white;
  text-decoration: none;
  transition: all .15s;
  font-family: 'Source Sans 3', sans-serif;
}
.toolbar-btn:hover { background: rgba(255,255,255,.12); }
.toolbar-btn.primary {
  background: var(--stripe);
  border-color: var(--stripe);
  color: white;
}
.toolbar-btn.primary:hover { opacity: .9; }
.edit-hint {
  margin-left: auto;
  font-size: 12px;
  color: rgba(255,255,255,.45);
  display: flex;
  align-items: center;
  gap: 5px;
}

/* ── RESUME PAGE ─────────────────── */
.resume-page {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  box-shadow: 0 8px 50px rgba(0,0,0,.18);
}

/* ── HEADER BAND ─────────────────── */
.header-band {
  background: var(--accent);
  color: white;
  padding: 42px 50px 36px;
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
  font-size: 38px;
  font-weight: 600;
  line-height: 1.1;
  letter-spacing: -.01em;
}
.hb-role {
  font-size: 14px;
  font-weight: 300;
  letter-spacing: .15em;
  text-transform: uppercase;
  color: var(--stripe);
  margin-top: 6px;
}
.hb-contact {
  display: flex;
  flex-wrap: wrap;
  gap: 6px 24px;
  margin-top: 18px;
}
.hb-contact-item {
  font-size: 13px;
  color: rgba(255,255,255,.8);
  display: flex;
  align-items: center;
  gap: 7px;
}
.hb-contact-item svg { color: var(--stripe); flex-shrink: 0; }

/* ── BODY LAYOUT ─────────────────── */
.body-layout {
  display: grid;
  grid-template-columns: 1fr 240px;
  gap: 0;
}
.body-main { padding: 38px 42px 38px 50px; border-right: 1px solid var(--line); }
.body-aside { padding: 38px 30px 38px 28px; }

/* ── SECTION TITLE ───────────────── */
.sec-title {
  font-family: 'Lora', serif;
  font-size: 16px;
  font-weight: 600;
  color: var(--accent);
  padding-bottom: 8px;
  margin-bottom: 18px;
  border-bottom: 2px solid var(--stripe);
  letter-spacing: .01em;
}
.aside-sec-title {
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .14em;
  color: var(--accent);
  padding-bottom: 8px;
  margin-bottom: 14px;
  border-bottom: 2px solid var(--line);
}

/* ── SUMMARY ─────────────────────── */
.summary-text {
  font-size: 14px;
  line-height: 1.8;
  color: #374151;
  margin-bottom: 34px;
}

/* ── TIMELINE EXPERIENCE ─────────── */
.timeline { position: relative; padding-left: 24px; }
.timeline::before {
  content: '';
  position: absolute;
  left: 5px; top: 6px; bottom: 0;
  width: 2px;
  background: var(--line);
}
.tl-item {
  position: relative;
  margin-bottom: 28px;
  padding-bottom: 28px;
  border-bottom: 1px dashed var(--line);
}
.tl-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.tl-dot {
  position: absolute;
  left: -24px; top: 5px;
  width: 12px; height: 12px;
  border-radius: 50%;
  background: var(--stripe);
  border: 2px solid white;
  box-shadow: 0 0 0 2px var(--stripe);
}
.tl-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.tl-title {
  font-size: 15px;
  font-weight: 600;
  color: var(--text);
}
.tl-company {
  font-size: 13.5px;
  color: var(--accent);
  font-weight: 500;
  margin-top: 2px;
}
.tl-duration {
  font-size: 12px;
  color: white;
  background: var(--accent);
  padding: 3px 10px;
  border-radius: 3px;
  white-space: nowrap;
  flex-shrink: 0;
}
.tl-bullets { list-style: none; margin-top: 10px; display: flex; flex-direction: column; gap: 5px; }
.tl-bullets li {
  font-size: 13.5px;
  color: #4b5563;
  line-height: 1.6;
  padding-left: 15px;
  position: relative;
}
.tl-bullets li::before {
  content: '—';
  position: absolute;
  left: 0;
  color: var(--stripe);
  font-size: 11px;
  top: 2px;
}

/* ── ASIDE: EDUCATION ────────────── */
.aside-section { margin-bottom: 30px; }
.edu-item-aside { margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid var(--line); }
.edu-item-aside:last-child { border-bottom: none; margin-bottom: 0; }
.edu-level {
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: var(--stripe);
  margin-bottom: 3px;
}
.edu-degree-a { font-size: 13.5px; font-weight: 600; color: var(--text); line-height: 1.3; }
.edu-school-a { font-size: 12.5px; color: var(--muted); margin-top: 3px; }
.edu-meta-a { font-size: 11.5px; color: var(--muted); margin-top: 3px; }
.edu-chip {
  display: inline-block;
  margin-top: 5px;
  font-size: 10.5px;
  background: var(--stripe-light);
  color: #92680a;
  padding: 1px 8px;
  border-radius: 3px;
  font-weight: 600;
}

/* ── ASIDE: SKILLS ───────────────── */
.skill-tag-wrap { display: flex; flex-wrap: wrap; gap: 5px; }
.skill-tag {
  font-size: 11.5px;
  background: #f1f5f9;
  color: var(--accent);
  padding: 3px 10px;
  border-radius: 3px;
  font-weight: 500;
}
.lang-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; font-size: 13px; color: var(--text); }
.lang-lev { font-size: 11px; color: var(--muted); }

/* ── CONTENTEDITABLE ─────────────── */
[contenteditable] { outline: none; border-radius: 2px; transition: background .15s; cursor: text; }
[contenteditable]:hover { background: rgba(201,168,76,.1); }
[contenteditable]:focus { background: rgba(201,168,76,.18); outline: 1.5px dashed var(--stripe); }

/* ── PRINT ───────────────────────── */
@media print {
  body { background: white; padding: 0; }
  .toolbar { display: none !important; }
  .resume-page { box-shadow: none; }
  [contenteditable]:hover, [contenteditable]:focus { background: transparent; outline: none; }
}
</style>
</head>
<body>

<!-- ═══ TOOLBAR ═══ -->
<div class="toolbar">
  <a href="{{ route('resumebuilder') }}" class="toolbar-btn">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
  <div class="toolbar-sep"></div>
  <span class="toolbar-label">Theme</span>
  <div class="color-swatches" id="swatches">
    <div class="swatch active" data-accent="#1a3a5c" data-stripe="#c9a84c" style="background:#1a3a5c" title="Navy Gold"></div>
    <div class="swatch" data-accent="#1e3a2f" data-stripe="#52a77a" style="background:#1e3a2f" title="Forest"></div>
    <div class="swatch" data-accent="#3b1a5c" data-stripe="#a87cd4" style="background:#3b1a5c" title="Plum"></div>
    <div class="swatch" data-accent="#5c1a1a" data-stripe="#d47c7c" style="background:#5c1a1a" title="Burgundy"></div>
    <div class="swatch" data-accent="#1a3a50" data-stripe="#4fc3d4" style="background:#1a3a50" title="Steel Teal"></div>
    <div class="swatch" data-accent="#2a2a2a" data-stripe="#e0a030" style="background:#2a2a2a" title="Charcoal"></div>
  </div>
  <div class="toolbar-sep"></div>
  <button class="toolbar-btn" onclick="window.print()">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
    Print
  </button>
  <a href="{{ route('resume.download') }}" class="toolbar-btn primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
    Download PDF
  </a>
  <div class="edit-hint">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    Click any text to edit
  </div>
</div>

<!-- ═══ RESUME ═══ -->
<div class="resume-page">

  <!-- Header Band -->
  <div class="header-band">
    <div class="hb-name" contenteditable="true" spellcheck="false">{{ $resume['name'] }}</div>
    @if(!empty($resume['experience'][0]['title']))
      <div class="hb-role" contenteditable="true" spellcheck="false">{{ $resume['experience'][0]['title'] }}</div>
    @elseif(!empty($resume['education'][0]['degree']))
      <div class="hb-role" contenteditable="true" spellcheck="false">{{ $resume['education'][0]['degree'] }}</div>
    @endif
    <div class="hb-contact">
      <div class="hb-contact-item">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['email'] }}</span>
      </div>
      @if(!empty($resume['phone']))
      <div class="hb-contact-item">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 19.79 19.79 0 01.21 7a2 2 0 012-2.18h3a2 2 0 012 1.72 12.6 12.6 0 00.57 2.57 2 2 0 01-.45 2.11L6.91 12a16 16 0 006 6l.42-.42a2 2 0 012.11-.45 12.6 12.6 0 002.57.57A2 2 0 0122 20z"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['phone'] }}</span>
      </div>
      @endif
      @if(!empty($resume['city']))
      <div class="hb-contact-item">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
        <span contenteditable="true" spellcheck="false">{{ $resume['city'] }}</span>
      </div>
      @endif
    </div>
  </div><!-- /header-band -->

  <!-- Body -->
  <div class="body-layout">

    <!-- Main Column -->
    <div class="body-main">

      <!-- Summary -->
      @if(!empty($resume['summary']))
      <div class="sec-title">Profile</div>
      <div class="summary-text" contenteditable="true" spellcheck="false">{{ $resume['summary'] }}</div>
      @endif

      <!-- Experience -->
      @if(!empty($resume['experience']))
      <div class="sec-title">Work Experience</div>
      <div class="timeline">
        @foreach($resume['experience'] as $exp)
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div class="tl-header">
            <div>
              <div class="tl-title" contenteditable="true" spellcheck="false">{{ $exp['title'] ?? '' }}</div>
              <div class="tl-company" contenteditable="true" spellcheck="false">{{ $exp['company'] ?? '' }}</div>
            </div>
            @if(!empty($exp['duration']))
            <div class="tl-duration" contenteditable="true" spellcheck="false">{{ $exp['duration'] }}</div>
            @endif
          </div>
          @if(!empty($exp['responsibilities']))
          <ul class="tl-bullets">
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

    <!-- Aside Column -->
    <div class="body-aside">

      <!-- Education -->
      @if(!empty($resume['education']))
      <div class="aside-section">
        <div class="aside-sec-title">Education</div>
        @foreach($resume['education'] as $edu)
        <div class="edu-item-aside">
          <div class="edu-level">{{ $edu['level'] ?? '' }}</div>
          @if(!empty($edu['degree']))
            <div class="edu-degree-a" contenteditable="true" spellcheck="false">{{ $edu['degree'] }}@if(!empty($edu['major'])) <br><span style="font-weight:400;font-size:12px">{{ $edu['major'] }}</span>@endif</div>
          @endif
          <div class="edu-school-a" contenteditable="true" spellcheck="false">{{ $edu['school'] ?? '' }}</div>
          @if(!empty($edu['year']))
            <div class="edu-meta-a" contenteditable="true" spellcheck="false">Class of {{ $edu['year'] }}</div>
          @endif
          @if(!empty($edu['cgpa']))
            <span class="edu-chip">CGPA {{ $edu['cgpa'] }}</span>
          @elseif(!empty($edu['grade']))
            <span class="edu-chip">GPA {{ $edu['grade'] }}</span>
          @endif
        </div>
        @endforeach
      </div>
      @endif

      <!-- Technical Skills -->
      @if(!empty($resume['skills']['technical']))
      <div class="aside-section">
        <div class="aside-sec-title">Technical Skills</div>
        <div class="skill-tag-wrap">
          @foreach($resume['skills']['technical'] as $skill)
          <span class="skill-tag" contenteditable="true" spellcheck="false">{{ $skill }}</span>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Soft Skills -->
      @if(!empty($resume['skills']['soft']))
      <div class="aside-section">
        <div class="aside-sec-title">Soft Skills</div>
        <div class="skill-tag-wrap">
          @foreach($resume['skills']['soft'] as $skill)
          <span class="skill-tag" contenteditable="true" spellcheck="false">{{ $skill }}</span>
          @endforeach
        </div>
      </div>
      @endif

      <!-- Languages -->
      @if(!empty($resume['skills']['languages']))
      <div class="aside-section">
        <div class="aside-sec-title">Languages</div>
        @foreach($resume['skills']['languages'] as $i => $lang)
        <div class="lang-row">
          <span contenteditable="true" spellcheck="false">{{ $lang }}</span>
          <span class="lang-lev">{{ $i===0?'Native':($i===1?'Fluent':'Intermediate') }}</span>
        </div>
        @endforeach
      </div>
      @endif

    </div><!-- /body-aside -->
  </div><!-- /body-layout -->
</div><!-- /resume-page -->

<script>
document.querySelectorAll('.swatch').forEach(s => {
  s.addEventListener('click', () => {
    document.querySelectorAll('.swatch').forEach(x => x.classList.remove('active'));
    s.classList.add('active');
    const root = document.documentElement;
    root.style.setProperty('--accent', s.dataset.accent);
    root.style.setProperty('--stripe', s.dataset.stripe);
    // Update toolbar bg
    document.querySelector('.toolbar').style.background = s.dataset.accent;
  });
});

document.querySelector('.color-picker-wrap input')?.addEventListener('input', function() {
  document.documentElement.style.setProperty('--accent', this.value);
  document.querySelector('.toolbar').style.background = this.value;
  document.querySelectorAll('.swatch').forEach(x => x.classList.remove('active'));
});
</script>
</body>
</html>
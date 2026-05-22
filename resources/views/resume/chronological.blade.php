<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>

@if(empty($forPdf))
@vite(['resources/css/app.css', 'resources/js/resume-chronological.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=Source+Sans+3:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
@endif

<style>
/* ── RESET & BASE ─────────────────── */
* { margin: 0; padding: 0; box-sizing: border-box; }
[x-cloak] { display: none !important; }

/* ── FONT FAMILIES ───────────────── */
.font-lora     { font-family: 'Lora', serif !important; }
.font-source   { font-family: 'Source Sans 3', sans-serif !important; }
.font-mono-cv  { font-family: 'DM Mono', monospace !important; }
.font-ats      { font-family: Arial, Helvetica, sans-serif !important; }

body {
    font-family: 'Source Sans 3', sans-serif;
    min-height: 100vh;
    background: #f0ede8;
}

/* ── RESUME PAGE ─────────────────── */
.resume-page {
    max-width: 860px;
    margin: 0 auto;
    background: white;
    box-shadow: 0 12px 60px rgba(0,0,0,.20);
    transition: box-shadow .3s;
}

/* ── HEADER BAND ─────────────────── */
.header-band {
    color: white;
    padding: 42px 50px 36px;
    position: relative;
    overflow: hidden;
}
.header-band::before {
    content: '';
    position: absolute;
    top: 0; right: 0;
    width: 220px; height: 100%;
    background: rgba(255,255,255,.05);
    clip-path: polygon(40% 0, 100% 0, 100% 100%, 0% 100%);
    pointer-events: none;
}
.header-band::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 4px;
}
.hb-name {
    font-family: 'Lora', serif;
    font-size: 38px;
    font-weight: 600;
    line-height: 1.1;
    letter-spacing: -.01em;
}
.hb-role {
    font-size: 13px;
    font-weight: 300;
    letter-spacing: .18em;
    text-transform: uppercase;
    margin-top: 6px;
    opacity: .85;
}
.hb-contact {
    display: flex;
    flex-wrap: wrap;
    gap: 6px 24px;
    margin-top: 18px;
}
.hb-contact-item {
    font-size: 13px;
    color: rgba(255,255,255,.82);
    display: flex;
    align-items: center;
    gap: 7px;
}
.hb-contact-item svg { flex-shrink: 0; }

/* ── BODY LAYOUT ─────────────────── */
.body-layout {
    display: grid;
    grid-template-columns: 1fr 240px;
}
.body-main {
    padding: 38px 42px 38px 50px;
    border-right: 1px solid #e5e7eb;
    min-width: 0;
}
.body-aside {
    padding: 38px 30px 38px 28px;
    min-width: 0;
}

/* ── ATS OVERRIDE ────────────────── */
.ats-layout .body-layout {
    display: block;
}
.ats-layout .body-main {
    padding: 32px 48px;
    border-right: none;
}
.ats-layout .body-aside {
    padding: 0 48px 32px;
    border-top: 1px solid #e5e7eb;
}
.ats-layout .header-band {
    padding: 32px 48px 28px;
}
.ats-layout .header-band::before { display: none; }

/* ── SECTION TITLES ──────────────── */
.sec-title {
    font-family: 'Lora', serif;
    font-size: 16px;
    font-weight: 600;
    padding-bottom: 8px;
    margin-bottom: 18px;
    border-bottom-width: 2px;
    border-bottom-style: solid;
    letter-spacing: .01em;
}
.aside-sec-title {
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .14em;
    padding-bottom: 8px;
    margin-bottom: 14px;
    border-bottom: 2px solid #e5e7eb;
    color: #6b7280;
}

/* ── SUMMARY ─────────────────────── */
.summary-text {
    font-size: 14px;
    line-height: 1.8;
    color: #374151;
    margin-bottom: 34px;
}

/* ── TIMELINE ────────────────────── */
.timeline { position: relative; padding-left: 24px; }
.timeline::before {
    content: '';
    position: absolute;
    left: 5px; top: 6px; bottom: 0;
    width: 2px;
    background: #e5e7eb;
}
.tl-item {
    position: relative;
    margin-bottom: 28px;
    padding-bottom: 28px;
    border-bottom: 1px dashed #e5e7eb;
}
.tl-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
.tl-dot {
    position: absolute;
    left: -24px; top: 5px;
    width: 12px; height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}
.tl-header { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
.tl-title { font-size: 15px; font-weight: 600; color: #1f2937; }
.tl-company { font-size: 13.5px; font-weight: 500; margin-top: 2px; }
.tl-duration {
    font-size: 12px;
    color: white;
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
    padding-left: 18px;
    position: relative;
}
.tl-bullets li::before {
    content: '—';
    position: absolute;
    left: 0;
    font-size: 11px;
    top: 2px;
    opacity: .6;
}

/* ── ASIDE: EDUCATION ────────────── */
.aside-section { margin-bottom: 28px; }
.edu-item-aside {
    margin-bottom: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid #f3f4f6;
}
.edu-item-aside:last-child { border-bottom: none; margin-bottom: 0; }
.edu-level {
    font-size: 9.5px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .1em;
    margin-bottom: 3px;
}
.edu-degree-a { font-size: 13.5px; font-weight: 600; color: #1f2937; line-height: 1.3; }
.edu-school-a { font-size: 12.5px; color: #6b7280; margin-top: 3px; }
.edu-meta-a   { font-size: 11.5px; color: #6b7280; margin-top: 3px; }
.edu-chip {
    display: inline-block;
    margin-top: 5px;
    font-size: 10.5px;
    padding: 2px 8px;
    border-radius: 3px;
    font-weight: 600;
}

/* ── ASIDE: SKILLS ───────────────── */
.skill-tag-wrap { display: flex; flex-wrap: wrap; gap: 5px; }
.skill-tag {
    font-size: 11.5px;
    background: #f1f5f9;
    padding: 3px 10px;
    border-radius: 3px;
    font-weight: 500;
}
.lang-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    font-size: 13px;
    color: #1f2937;
}
.lang-lev { font-size: 11px; color: #6b7280; }

/* ── CONTENTEDITABLE ─────────────── */
[contenteditable] { outline: none; border-radius: 2px; transition: background .15s; }
[contenteditable]:hover  { background: rgba(0,0,0,.04); }
[contenteditable]:focus  { background: rgba(0,0,0,.06); outline: 1.5px dashed rgba(0,0,0,.2); }

/* ── MOBILE ──────────────────────── */
@media (max-width: 700px) {
    body { padding-bottom: 20px; }
    .header-band {
        padding: 28px 22px 24px;
    }
    .hb-name { font-size: 26px; }
    .hb-role { font-size: 11px; }
    .hb-contact { gap: 4px 16px; }
    .hb-contact-item { font-size: 12px; }
    .body-layout {
        grid-template-columns: 1fr;
    }
    .body-main {
        padding: 24px 22px;
        border-right: none;
        border-bottom: 1px solid #e5e7eb;
    }
    .body-aside {
        padding: 24px 22px;
    }
    .ats-layout .body-main { padding: 24px 22px; }
    .ats-layout .body-aside { padding: 0 22px 24px; }
    .ats-layout .header-band { padding: 24px 22px; }
    .tl-title { font-size: 14px; }
    .tl-company { font-size: 12.5px; }
    .tl-bullets li { font-size: 12.5px; }
    .sec-title { font-size: 14px; }
}

@media (max-width: 480px) {
    .header-band { padding: 22px 16px 20px; }
    .hb-name { font-size: 22px; }
    .body-main, .body-aside { padding: 20px 16px; }
    .tl-header { flex-direction: column; gap: 6px; }
    .tl-duration { align-self: flex-start; }
}

/* ── PRINT ───────────────────────── */
@media print {
    body { background: white !important; padding: 0 !important; }
    .toolbar, .no-print { display: none !important; }
    .resume-page { box-shadow: none !important; }
    .body-layout { grid-template-columns: 1fr 240px !important; }
    .body-main { border-right: 1px solid #e5e7eb !important; padding: 38px 42px 38px 50px !important; }
    .body-aside { padding: 38px 30px 38px 28px !important; }
    [contenteditable]:hover, [contenteditable]:focus { background: transparent !important; outline: none !important; }
}

@if(!empty($forPdf))
* { font-family: 'DejaVu Sans', sans-serif !important; }
.hb-name, .sec-title { font-family: 'DejaVu Serif', serif !important; }
body { padding: 0 !important; background: white !important; }
.resume-page { box-shadow: none !important; }
@endif
</style>
</head>

<body class="pt-20 pb-12 px-4 transition-all"
      @if(empty($forPdf))
      x-data="resumeApp()"
      x-init="init()"
      :class="[fontClass, atsMode ? 'ats-layout' : '']"
      @endif
      >

    @if(empty($forPdf))
    <x-resume-toolbar template="chronological" />
    @endif

    @php
        $headlineTitle = $resume['experience'][0]['title'] ?? ($resume['education'][0]['degree'] ?? '');
        $headlineOrg   = $resume['experience'][0]['company'] ?? ($resume['education'][0]['school'] ?? null);
    @endphp

    <div class="resume-page">

        {{-- ═══ HEADER BAND ═══ --}}
        <div class="header-band"
             @if(empty($forPdf))
             :style="`background: hsl(${hue}, 38%, 18%); --stripe: hsl(${hue}, 55%, 55%);`"
             @else
             style="background: #1a3a5c;"
             @endif
             >
            <div class="hb-name" contenteditable="true" spellcheck="false">{{ $resume['name'] }}</div>

            @if($headlineTitle)
            <div class="hb-role"
                 @if(empty($forPdf)) :style="`color: hsl(${hue}, 55%, 68%)`" @else style="color: #c9a84c" @endif
                 contenteditable="true" spellcheck="false">
                {{ $headlineTitle }}@if($headlineOrg) &nbsp;·&nbsp; {{ $headlineOrg }}@endif
            </div>
            @endif

            <div class="hb-contact">
                <div class="hb-contact-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 55%, 65%)`" @else style="color:#c9a84c" @endif
                         ><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>
                    <span contenteditable="true" spellcheck="false">{{ $resume['email'] }}</span>
                </div>
                @if(!empty($resume['phone']))
                <div class="hb-contact-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 55%, 65%)`" @else style="color:#c9a84c" @endif
                         ><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013 7.18 19.79 19.79 0 01.21 7a2 2 0 012-2.18h3a2 2 0 012 1.72 12.6 12.6 0 00.57 2.57 2 2 0 01-.45 2.11L6.91 12a16 16 0 006 6l.42-.42a2 2 0 012.11-.45 12.6 12.6 0 002.57.57A2 2 0 0122 20z"/></svg>
                    <span contenteditable="true" spellcheck="false">{{ $resume['phone'] }}</span>
                </div>
                @endif
                @if(!empty($resume['city']))
                <div class="hb-contact-item">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 55%, 65%)`" @else style="color:#c9a84c" @endif
                         ><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                    <span contenteditable="true" spellcheck="false">{{ $resume['city'] }}</span>
                </div>
                @endif
            </div>

            {{-- Stripe accent bar (bottom of header) --}}
            <div class="absolute bottom-0 left-0 right-0 h-1"
                 @if(empty($forPdf)) :style="`background: hsl(${hue}, 55%, 55%)`" @else style="background:#c9a84c" @endif
                 ></div>
        </div>{{-- /header-band --}}

        {{-- ═══ BODY ═══ --}}
        <div class="body-layout">

            {{-- Main Column --}}
            <div class="body-main">

                {{-- Summary --}}
                @if(!empty($resume['summary']))
                <div class="sec-title"
                     @if(empty($forPdf))
                     :style="`color: hsl(${hue}, 38%, 22%); border-bottom-color: hsl(${hue}, 50%, 50%)`"
                     @else
                     style="color:#1a3a5c; border-bottom-color:#c9a84c"
                     @endif
                     >Profile</div>
                <div class="summary-text" contenteditable="true" spellcheck="false">{{ $resume['summary'] }}</div>
                @endif

                {{-- Experience --}}
                @if(!empty($resume['experience']))
                <div class="sec-title"
                     @if(empty($forPdf))
                     :style="`color: hsl(${hue}, 38%, 22%); border-bottom-color: hsl(${hue}, 50%, 50%)`"
                     @else
                     style="color:#1a3a5c; border-bottom-color:#c9a84c"
                     @endif
                     >Work Experience</div>
                <div class="timeline">
                    @foreach($resume['experience'] as $exp)
                    <div class="tl-item">
                        <div class="tl-dot"
                             @if(empty($forPdf)) :style="`background: hsl(${hue}, 50%, 52%); box-shadow: 0 0 0 2px hsl(${hue}, 50%, 52%)`"
                             @else style="background:#c9a84c; box-shadow:0 0 0 2px #c9a84c" @endif></div>
                        <div class="tl-header">
                            <div>
                                <div class="tl-title" contenteditable="true" spellcheck="false">{{ $exp['title'] ?? '' }}</div>
                                <div class="tl-company"
                                     @if(empty($forPdf)) :style="`color: hsl(${hue}, 38%, 32%)`" @else style="color:#1a3a5c" @endif
                                     contenteditable="true" spellcheck="false">{{ $exp['company'] ?? '' }}</div>
                            </div>
                            @if(!empty($exp['duration']))
                            <div class="tl-duration"
                                 @if(empty($forPdf)) :style="`background: hsl(${hue}, 38%, 22%)`" @else style="background:#1a3a5c" @endif
                                 contenteditable="true" spellcheck="false">{{ $exp['duration'] }}</div>
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

                {{-- ATS mode: Skills section in main column --}}
                @if(!empty($resume['skills']['technical']))
                @if(empty($forPdf))
                <div x-show="atsMode" x-cloak class="mt-8 pt-6 border-t border-gray-200">
                    <div class="sec-title" :style="`color: hsl(${hue}, 38%, 22%); border-bottom-color: hsl(${hue}, 50%, 50%)`">Skills & Competencies</div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        <span class="font-semibold">Technical:</span> {{ implode(', ', $resume['skills']['technical']) }}.
                        @if(!empty($resume['skills']['soft']))
                        <span class="font-semibold">Soft Skills:</span> {{ implode(', ', $resume['skills']['soft']) }}.
                        @endif
                        @if(!empty($resume['skills']['languages']))
                        <span class="font-semibold">Languages:</span> {{ implode(', ', $resume['skills']['languages']) }}.
                        @endif
                    </p>
                </div>
                @endif
                @endif

            </div>{{-- /body-main --}}

            {{-- Aside Column --}}
            <div class="body-aside">

                {{-- Education --}}
                @if(!empty($resume['education']))
                <div class="aside-section">
                    <div class="aside-sec-title"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 38%, 32%); border-bottom-color: hsl(${hue}, 30%, 85%)`" @endif
                         >Education</div>
                    @foreach($resume['education'] as $edu)
                    <div class="edu-item-aside">
                        <div class="edu-level"
                             @if(empty($forPdf)) :style="`color: hsl(${hue}, 50%, 45%)`" @else style="color:#c9a84c" @endif
                             >{{ $edu['level'] ?? '' }}</div>
                        @if(!empty($edu['degree']))
                        <div class="edu-degree-a" contenteditable="true" spellcheck="false">
                            {{ $edu['degree'] }}@if(!empty($edu['major'])) <br><span style="font-weight:400;font-size:12px">{{ $edu['major'] }}</span>@endif
                        </div>
                        @endif
                        <div class="edu-school-a" contenteditable="true" spellcheck="false">{{ $edu['school'] ?? '' }}</div>
                        @if(!empty($edu['year']))
                        <div class="edu-meta-a" contenteditable="true" spellcheck="false">Class of {{ $edu['year'] }}</div>
                        @endif
                        @if(!empty($edu['cgpa']))
                        <span class="edu-chip"
                              @if(empty($forPdf)) :style="`background: hsl(${hue}, 35%, 94%); color: hsl(${hue}, 40%, 30%)`"
                              @else style="background:#f5edd6;color:#92680a" @endif
                              >CGPA {{ $edu['cgpa'] }}</span>
                        @elseif(!empty($edu['grade']))
                        <span class="edu-chip"
                              @if(empty($forPdf)) :style="`background: hsl(${hue}, 35%, 94%); color: hsl(${hue}, 40%, 30%)`"
                              @else style="background:#f5edd6;color:#92680a" @endif
                              >GPA {{ $edu['grade'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Technical Skills --}}
                @if(!empty($resume['skills']['technical']))
                <div class="aside-section"
                     @if(empty($forPdf)) x-show="!atsMode" @endif
                     >
                    <div class="aside-sec-title"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 38%, 32%); border-bottom-color: hsl(${hue}, 30%, 85%)`" @endif
                         >Technical Skills</div>
                    <div class="skill-tag-wrap">
                        @foreach($resume['skills']['technical'] as $skill)
                        <span class="skill-tag"
                              @if(empty($forPdf)) :style="`background: hsl(${hue}, 30%, 95%); color: hsl(${hue}, 38%, 28%)`" @else style="background:#f1f5f9;color:#1a3a5c" @endif
                              contenteditable="true" spellcheck="false">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Soft Skills --}}
                @if(!empty($resume['skills']['soft']))
                <div class="aside-section"
                     @if(empty($forPdf)) x-show="!atsMode" @endif
                     >
                    <div class="aside-sec-title"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 38%, 32%); border-bottom-color: hsl(${hue}, 30%, 85%)`" @endif
                         >Soft Skills</div>
                    <div class="skill-tag-wrap">
                        @foreach($resume['skills']['soft'] as $skill)
                        <span class="skill-tag"
                              @if(empty($forPdf)) :style="`background: hsl(${hue}, 30%, 95%); color: hsl(${hue}, 38%, 28%)`" @else style="background:#f1f5f9;color:#1a3a5c" @endif
                              contenteditable="true" spellcheck="false">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Languages --}}
                @if(!empty($resume['skills']['languages']))
                <div class="aside-section">
                    <div class="aside-sec-title"
                         @if(empty($forPdf)) :style="`color: hsl(${hue}, 38%, 32%); border-bottom-color: hsl(${hue}, 30%, 85%)`" @endif
                         >Languages</div>
                    @foreach($resume['skills']['languages'] as $i => $lang)
                    <div class="lang-row">
                        <span contenteditable="true" spellcheck="false">{{ $lang }}</span>
                        <span class="lang-lev">{{ $i===0?'Native':($i===1?'Fluent':'Intermediate') }}</span>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>{{-- /body-aside --}}
        </div>{{-- /body-layout --}}
    </div>{{-- /resume-page --}}

@if(empty($forPdf))
<script>
function resumeApp() {
    return {
        hue: 215,
        atsMode: false,
        fontFamily: 'source',
        spacing: 'normal',

        get fontClass() {
            if (this.atsMode) return 'font-ats';
            return {
                'source': 'font-source',
                'serif':  'font-lora',
                'mono':   'font-mono-cv',
            }[this.fontFamily] || 'font-source';
        },

        init() {
            const saved = localStorage.getItem('resumeSettingsChronological');
            if (saved) {
                try {
                    const s = JSON.parse(saved);
                    this.hue        = s.hue        ?? 215;
                    this.atsMode    = s.atsMode    ?? false;
                    this.fontFamily = s.fontFamily ?? 'source';
                    this.spacing    = s.spacing    ?? 'normal';
                } catch(e) {}
            }
        },

        saveSettings() {
            localStorage.setItem('resumeSettingsChronological', JSON.stringify({
                hue:        this.hue,
                atsMode:    this.atsMode,
                fontFamily: this.fontFamily,
                spacing:    this.spacing,
            }));
        }
    }
}
</script>
@endif

</body>
</html>

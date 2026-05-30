<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Edit Resume — Resumate</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    /* ── system fonts only, no external requests ── */
    body { font-family: ui-sans-serif, system-ui, -apple-system, sans-serif; }
    .font-serif-display { font-family: ui-serif, Georgia, Cambria, serif; }

    /* ── editable field ── */
    .editable {
      outline: none;
      border-radius: 4px;
      transition: background .15s, box-shadow .15s;
      min-width: 40px;
      display: inline-block;
    }
    .editable:hover  { background: rgba(106,108,255,.06); }
    .editable:focus  { background: rgba(106,108,255,.10); box-shadow: 0 0 0 2px rgba(106,108,255,.3); }
    [contenteditable="true"]:empty:before {
      content: attr(data-placeholder);
      color: #BCBACF;
      pointer-events: none;
    }

    /* ── section block ── */
    .resume-section { position: relative; }
    .resume-section:hover .section-toolbar { opacity: 1; }
    .section-toolbar {
      opacity: 0;
      transition: opacity .2s;
      position: absolute;
      top: 0; right: 0;
    }

    /* ── bullet row ── */
    .bullet-row { display: flex; align-items: flex-start; gap: 8px; }
    .bullet-row:hover .bullet-del { opacity: 1; }
    .bullet-del { opacity: 0; transition: opacity .15s; }

    /* ── toolbar buttons ── */
    .tb-btn {
      width: 28px; height: 28px;
      border-radius: 6px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: background .15s;
      border: none;
      background: transparent;
    }
    .tb-btn:hover { background: rgba(106,108,255,.12); }
    .tb-btn.danger:hover { background: rgba(239,68,68,.12); }

    /* ── floating action bar ── */
    #action-bar {
      position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%);
      z-index: 50;
    }

    /* ── scrollbar ── */
    .page-scroll::-webkit-scrollbar { width: 5px; }
    .page-scroll::-webkit-scrollbar-thumb { background: #E2E0F0; border-radius: 99px; }

    /* ── Modern template specific ── */
    .tpl-modern .resume-name { font-size: 2.25rem; font-weight: 800; letter-spacing: -.03em; }
    .tpl-modern .section-title { color: #6A6CFF; font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .12em; border-bottom: 1.5px solid #6A6CFF; padding-bottom: 4px; margin-bottom: 12px; }

    /* ── Minimal template specific ── */
    .tpl-minimal .resume-name { font-size: 2rem; font-weight: 300; letter-spacing: .08em; text-transform: uppercase; }
    .tpl-minimal .section-title { font-size: .65rem; font-weight: 600; text-transform: uppercase; letter-spacing: .15em; color: #999; border-bottom: 1px solid #E5E5E5; padding-bottom: 3px; margin-bottom: 10px; }

    /* ── Chronological template specific ── */
    .tpl-chronological .resume-name { font-size: 2.1rem; font-weight: 700; font-family: ui-serif, Georgia, serif; }
    .tpl-chronological .section-title { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .1em; background: #F0EFF8; padding: 4px 10px; border-left: 3px solid #6A6CFF; margin-bottom: 12px; }
  </style>
</head>
<body class="bg-[#F4F3FB] min-h-screen" x-data="resumeEditor()" x-init="init()">

{{-- ══ TOP NAV ══ --}}
<nav class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-100 px-5 py-3 flex items-center justify-between">
  <div class="flex items-center gap-3">
    <a href="{{ url('/templates') }}" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
      <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </a>
    <span class="font-semibold text-[#3A2F6A] text-sm">Edit Ready-Made Resume</span>
  </div>
  <div class="flex items-center gap-2">
    {{-- Template switcher --}}
    <div class="hidden md:flex items-center gap-1 bg-[#F0EFF8] rounded-lg p-1">
      <template x-for="tpl in ['modern','minimal','chronological']" :key="tpl">
        <button @click="template = tpl"
                :class="template === tpl ? 'bg-white shadow text-[#6A6CFF] font-semibold' : 'text-[#A09EC0]'"
                class="px-3 py-1.5 rounded-md text-xs capitalize transition-all">
          <span x-text="tpl"></span>
        </button>
      </template>
    </div>
    <button @click="showPreview = !showPreview"
            class="px-3 py-2 rounded-lg text-xs font-semibold bg-[#F0EFF8] text-[#6A6CFF] hover:bg-[#E8E6F5] transition-colors">
      <span x-text="showPreview ? 'Edit' : 'Preview'"></span>
    </button>
  </div>
</nav>

{{-- ══ BODY ══ --}}
<div class="max-w-[900px] mx-auto px-4 py-8 pb-32 page-scroll">

  {{-- ── RESUME PAPER ── --}}
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden"
       :class="'tpl-' + template"
       :contenteditable="!showPreview">

    {{-- ── HEADER ── --}}
    <div class="px-10 pt-10 pb-7"
         :class="{
           'border-b-4 border-[#6A6CFF]': template === 'modern',
           'border-b border-gray-200': template === 'minimal',
           'bg-[#F8F7FC] border-b-2 border-[#6A6CFF]': template === 'chronological'
         }">
      <h1 class="resume-name font-serif-display text-[#1C1C3C] mb-1">
        <span class="editable" contenteditable="true" data-placeholder="First Name" x-text="data.first_name"
              @input="data.first_name = $event.target.innerText"></span>
        <span> </span>
        <span class="editable" contenteditable="true" data-placeholder="Last Name" x-text="data.last_name"
              @input="data.last_name = $event.target.innerText"></span>
      </h1>
      <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500 mt-2">
        <span class="editable" contenteditable="true" data-placeholder="Address" x-text="data.address"
              @input="data.address = $event.target.innerText"></span>
        <span class="editable" contenteditable="true" data-placeholder="Phone" x-text="data.phone"
              @input="data.phone = $event.target.innerText"></span>
        <span class="editable" contenteditable="true" data-placeholder="Email" x-text="data.email"
              @input="data.email = $event.target.innerText"></span>
        <span class="editable" contenteditable="true" data-placeholder="Website" x-text="data.website"
              @input="data.website = $event.target.innerText"></span>
      </div>
    </div>

    {{-- ── CONTENT ── --}}
    <div class="px-10 py-8 space-y-8">

      {{-- SUMMARY --}}
      <div class="resume-section" x-show="sections.summary">
        <div class="section-toolbar flex gap-1">
          <button class="tb-btn danger" title="Hide section" @click.stop="sections.summary = false" contenteditable="false">
            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="section-title">Summary</div>
        <p class="editable text-sm text-gray-700 leading-relaxed" contenteditable="true"
           data-placeholder="Write your summary..."
           x-text="data.summary" @input="data.summary = $event.target.innerText"></p>
      </div>

      {{-- EXPERIENCE --}}
      <div class="resume-section" x-show="sections.experience">
        <div class="section-toolbar flex gap-1">
          <button class="tb-btn danger" title="Hide section" @click.stop="sections.experience = false" contenteditable="false">
            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="section-title">Work Experience</div>
        <template x-for="(exp, ei) in data.experiences" :key="ei">
          <div class="mb-5 relative group/exp">
            {{-- Remove job --}}
            <button class="absolute -left-5 top-0 tb-btn danger opacity-0 group-hover/exp:opacity-100"
                    @click.stop="data.experiences.splice(ei, 1)" contenteditable="false" title="Remove job">
              <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
              </svg>
            </button>
            <div class="flex items-start justify-between gap-4">
              <div>
                <span class="font-semibold text-sm text-[#1C1C3C] editable" contenteditable="true"
                      x-text="exp.title" @input="exp.title = $event.target.innerText"></span>
                <span class="text-gray-400 text-sm"> , </span>
                <span class="text-sm text-gray-600 editable" contenteditable="true"
                      x-text="exp.company" @input="exp.company = $event.target.innerText"></span>
              </div>
              <span class="text-xs text-gray-400 whitespace-nowrap editable flex-shrink-0" contenteditable="true"
                    x-text="exp.period" @input="exp.period = $event.target.innerText"></span>
            </div>
            <ul class="mt-2 space-y-1 ml-4">
              <template x-for="(bullet, bi) in exp.bullets" :key="bi">
                <li class="bullet-row text-sm text-gray-700">
                  <span class="mt-1 text-[#6A6CFF] flex-shrink-0">•</span>
                  <span class="editable flex-1" contenteditable="true"
                        x-text="bullet" @input="exp.bullets[bi] = $event.target.innerText"></span>
                  <button class="bullet-del tb-btn danger flex-shrink-0" @click.stop="exp.bullets.splice(bi, 1)" contenteditable="false">
                    <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </li>
              </template>
              <li>
                <button class="text-[10px] text-[#6A6CFF]/60 hover:text-[#6A6CFF] mt-1 transition-colors" contenteditable="false"
                        @click.stop="exp.bullets.push('New bullet point')">+ add bullet</button>
              </li>
            </ul>
          </div>
        </template>
        <button class="text-xs text-[#6A6CFF]/70 hover:text-[#6A6CFF] font-medium transition-colors mt-1" contenteditable="false"
                @click.stop="data.experiences.push({ title: 'Job Title', company: 'Company Name', period: 'Start - End', bullets: ['Describe your achievement here.'] })">
          + Add Experience
        </button>
      </div>

      {{-- EDUCATION --}}
      <div class="resume-section" x-show="sections.education">
        <div class="section-toolbar flex gap-1">
          <button class="tb-btn danger" @click.stop="sections.education = false" contenteditable="false">
            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="section-title">Education</div>
        <template x-for="(edu, ei) in data.educations" :key="ei">
          <div class="mb-4 relative group/edu">
            <button class="absolute -left-5 top-0 tb-btn danger opacity-0 group-hover/edu:opacity-100"
                    @click.stop="data.educations.splice(ei, 1)" contenteditable="false">
              <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
              </svg>
            </button>
            <div class="flex items-start justify-between gap-4">
              <div>
                <div class="font-semibold text-sm text-[#1C1C3C] editable" contenteditable="true"
                     x-text="edu.degree" @input="edu.degree = $event.target.innerText"></div>
                <div class="text-sm text-gray-500 editable" contenteditable="true"
                     x-text="edu.school" @input="edu.school = $event.target.innerText"></div>
              </div>
              <span class="text-xs text-gray-400 whitespace-nowrap editable flex-shrink-0" contenteditable="true"
                    x-text="edu.period" @input="edu.period = $event.target.innerText"></span>
            </div>
            <ul class="mt-1 ml-4 space-y-0.5">
              <template x-for="(bullet, bi) in edu.bullets" :key="bi">
                <li class="bullet-row text-sm text-gray-600">
                  <span class="mt-1 text-[#6A6CFF] flex-shrink-0">•</span>
                  <span class="editable flex-1" contenteditable="true"
                        x-text="bullet" @input="edu.bullets[bi] = $event.target.innerText"></span>
                  <button class="bullet-del tb-btn danger flex-shrink-0" @click.stop="edu.bullets.splice(bi, 1)" contenteditable="false">
                    <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </li>
              </template>
              <li>
                <button class="text-[10px] text-[#6A6CFF]/60 hover:text-[#6A6CFF] mt-0.5 transition-colors"
                        contenteditable="false" @click.stop="edu.bullets.push('Add detail')">+ add detail</button>
              </li>
            </ul>
          </div>
        </template>
        <button class="text-xs text-[#6A6CFF]/70 hover:text-[#6A6CFF] font-medium transition-colors mt-1" contenteditable="false"
                @click.stop="data.educations.push({ degree: 'Degree Name', school: 'Institution', period: 'Year - Year', bullets: [] })">
          + Add Education
        </button>
      </div>

      {{-- ADDITIONAL INFO --}}
      <div class="resume-section" x-show="sections.additional">
        <div class="section-toolbar flex gap-1">
          <button class="tb-btn danger" @click.stop="sections.additional = false" contenteditable="false">
            <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
        <div class="section-title">Additional Information</div>
        <div class="space-y-2 text-sm text-gray-700">
          <div class="flex gap-2 items-start">
            <span class="font-semibold text-[#1C1C3C] flex-shrink-0">Technical Skills:</span>
            <span class="editable flex-1" contenteditable="true"
                  x-text="data.technical_skills" @input="data.technical_skills = $event.target.innerText"></span>
          </div>
          <div class="flex gap-2 items-start">
            <span class="font-semibold text-[#1C1C3C] flex-shrink-0">Languages:</span>
            <span class="editable flex-1" contenteditable="true"
                  x-text="data.languages" @input="data.languages = $event.target.innerText"></span>
          </div>
          <div class="flex gap-2 items-start">
            <span class="font-semibold text-[#1C1C3C] flex-shrink-0">Certifications:</span>
            <span class="editable flex-1" contenteditable="true"
                  x-text="data.certifications" @input="data.certifications = $event.target.innerText"></span>
          </div>
          <div class="flex gap-2 items-start">
            <span class="font-semibold text-[#1C1C3C] flex-shrink-0">Awards/Activities:</span>
            <span class="editable flex-1" contenteditable="true"
                  x-text="data.awards" @input="data.awards = $event.target.innerText"></span>
          </div>
        </div>
      </div>

      {{-- Restore hidden sections --}}
      <div class="flex flex-wrap gap-2 pt-2" contenteditable="false">
        <template x-for="[key, label] in [['summary','Summary'],['experience','Experience'],['education','Education'],['additional','Additional Info']]" :key="key">
          <button x-show="!sections[key]"
                  @click="sections[key] = true"
                  class="text-[11px] px-3 py-1.5 rounded-full bg-[#F0EFF8] text-[#6A6CFF] hover:bg-[#E8E6F5] transition-colors font-medium">
            + Restore <span x-text="label"></span>
          </button>
        </template>
      </div>

    </div>{{-- /content --}}
  </div>{{-- /paper --}}
</div>

{{-- ══ FLOATING ACTION BAR ══ --}}
<div id="action-bar">
  <div class="flex items-center gap-2 bg-white rounded-2xl shadow-2xl border border-gray-100 px-4 py-3">
    <span class="text-[11px] text-gray-400 mr-1 hidden md:block">Ready to use this?</span>

    {{-- Download JSON (simple local export) --}}
    <button @click="downloadJSON()"
            class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-medium bg-[#F0EFF8] text-[#6A6CFF] hover:bg-[#E8E6F5] transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
      </svg>
      Save Draft
    </button>

    {{-- Submit to generate route --}}
    <form method="POST" action="{{ route('resume.generate') }}" @submit.prevent="submitResume($event.target)">
      @csrf
      <input type="hidden" name="selected_template" :value="template">
      <input type="hidden" name="resume_json" :value="JSON.stringify(data)">
      <button type="submit"
              class="flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-bold bg-gradient-to-r from-[#6A6CFF] to-[#B06AFF] text-white shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
        Generate PDF
      </button>
    </form>
  </div>
</div>

<script>
function resumeEditor() {
  return {
    template: '{{ $selectedTemplate }}',
    showPreview: false,
    sections: {
      summary: true,
      experience: true,
      education: true,
      additional: true,
    },
    data: @json($resumeData),

    init() {
      // Restore any saved draft from localStorage
      const saved = localStorage.getItem('resumate_draft');
      if (saved) {
        try {
          const parsed = JSON.parse(saved);
          this.data = { ...this.data, ...parsed };
        } catch(e) {}
      }
      // Auto-save every 30s
      setInterval(() => this.autosave(), 30000);
    },

    autosave() {
      localStorage.setItem('resumate_draft', JSON.stringify(this.data));
    },

    downloadJSON() {
      this.autosave();
      const blob = new Blob([JSON.stringify(this.data, null, 2)], { type: 'application/json' });
      const a = document.createElement('a');
      a.href = URL.createObjectURL(blob);
      a.download = 'resumate-draft.json';
      a.click();
    },

    submitResume(form) {
      this.autosave();
      // Sync all contenteditable values before submitting
      form.querySelector('[name="resume_json"]').value = JSON.stringify(this.data);
      form.submit();
    }
  }
}
</script>
</body>
</html>

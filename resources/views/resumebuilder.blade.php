<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Resume Builder — Resumate</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    /* ── Input base ───────────────────────────── */
    .field-input {
      width: 100%;
      padding: 11px 16px;
      border: 1.5px solid #E2E0F0;
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 14.5px;
      color: #1C1C3C;
      background: #FAFAFA;
      transition: border-color .18s, box-shadow .18s, background .18s;
      outline: none;
    }
    .field-input::placeholder { color: #BCBACF; font-weight: 300; }
    .field-input:focus {
      border-color: #6A6CFF;
      background: white;
      box-shadow: 0 0 0 3px rgba(106,108,255,.12);
    }
    .field-input:focus-within { /* for wrappers */ }
    textarea.field-input { resize: vertical; line-height: 1.65; }

    /* ── Field label ──────────────────────────── */
    .field-label {
      display: block;
      font-family: 'Inter', sans-serif;
      font-size: 12.5px;
      font-weight: 600;
      color: #4A4870;
      margin-bottom: 6px;
      letter-spacing: .02em;
    }
    .opt-badge {
      font-size: 10.5px;
      font-weight: 400;
      color: #A09EC0;
      margin-left: 5px;
      letter-spacing: 0;
    }

    /* ── Section separator ────────────────────── */
    .field-separator {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 6px 0 2px;
    }
    .field-separator span {
      font-family: 'Inter', sans-serif;
      font-size: 11.5px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #A09EC0;
      white-space: nowrap;
    }
    .field-separator::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #E8E6F5;
    }

    /* ── Step dots (sidebar) ──────────────────── */
    .step-item { display: flex; align-items: center; gap: 13px; padding: 10px 12px; border-radius: 12px; transition: background .2s; }
    .step-item.active { background: rgba(106,108,255,.12); }
    .step-circle {
      width: 34px; height: 34px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 700;
      flex-shrink: 0;
      transition: all .25s;
    }
    .step-circle.done  { background: #22c55e; color: white; }
    .step-circle.active{ background: #6A6CFF; color: white; box-shadow: 0 3px 10px rgba(106,108,255,.4); }
    .step-circle.todo  { background: #F0EFF8; color: #A09EC0; }
    .step-name { font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 500; }
    .step-name.active { color: #3A2F6A; }
    .step-name.done   { color: #22c55e; }
    .step-name.todo   { color: #A09EC0; }

    /* ── Progress bar ─────────────────────────── */
    .prog-bar { height: 5px; border-radius: 99px; background: #E8E6F5; overflow: hidden; }
    .prog-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #6A6CFF, #B06AFF); transition: width .4s ease; }

    /* ── Nav buttons ──────────────────────────── */
    .btn-back {
      padding: 11px 22px;
      border-radius: 10px;
      border: 1.5px solid #E2E0F0;
      background: white;
      color: #6B6B8A;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      display: flex; align-items: center; gap: 7px;
      transition: all .15s;
    }
    .btn-back:hover { border-color: #A09EC0; background: #FAFAFA; }
    .btn-primary {
      padding: 11px 28px;
      border-radius: 10px;
      border: none;
      background: #6A6CFF;
      color: white;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex; align-items: center; gap: 8px;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(106,108,255,.3);
    }
    .btn-primary:hover { background: #5555EE; box-shadow: 0 6px 18px rgba(106,108,255,.4); transform: translateY(-1px); }
    .btn-generate {
      padding: 13px 32px;
      border-radius: 12px;
      border: none;
      background: linear-gradient(135deg, #6A6CFF, #B06AFF);
      color: white;
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      font-weight: 700;
      cursor: pointer;
      display: flex; align-items: center; gap: 9px;
      transition: all .18s;
      box-shadow: 0 5px 18px rgba(106,108,255,.35);
      letter-spacing: .01em;
    }
    .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(106,108,255,.5); }
    .btn-generate:disabled { opacity: .7; cursor: not-allowed; transform: none; }

    /* ── Error message ────────────────────────── */
    .err-msg { font-size: 12px; color: #ef4444; margin-top: 5px; display: none; }
    .field-input.has-error { border-color: #ef4444; }

    /* ── Scrollbar ────────────────────────────── */
    .right-panel::-webkit-scrollbar { width: 6px; }
    .right-panel::-webkit-scrollbar-track { background: transparent; }
    .right-panel::-webkit-scrollbar-thumb { background: #E2E0F0; border-radius: 99px; }
  </style>
</head>
<body class="font-[Inter] text-[#1C1C3C] bg-white">

@php
  $sections       = $sections ?? [];
  $currentPage    = $currentPage ?? 'choice';
  $currentSection = $currentSection ?? 0;
  $formData       = $formData ?? [];
  $selectedTemplate = $selectedTemplate ?? 'modern';
  $selectedOption   = $selectedOption ?? null;
  $totalSections    = count($sections);
  $isLastSection    = $currentSection === $totalSections - 1;
  $sectionData      = $sections[$currentSection] ?? [];
  $sectionProgress  = $totalSections > 0 ? round((($currentSection + 1) / $totalSections) * 100) : 0;
@endphp

{{-- ══════════════════════════════════ CHOICE PAGE ════════════════════════ --}}
@if($currentPage === 'choice')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] px-6">

  {{-- Close --}}
  <a href="{{ url('/templates') }}"
     class="fixed top-6 right-6 w-11 h-11 flex items-center justify-center rounded-full bg-white shadow-md hover:bg-[#FFB8C6] transition-all group z-50">
    <svg class="w-5 h-5 text-gray-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
  </a>

  <div class="max-w-xl w-full">
    <div class="text-center mb-10">
      <h1 class="font-['Playfair_Display'] text-5xl font-bold text-[#3A2F6A] mb-3">Let's Get Started</h1>
      <p class="text-[#3A2F6A]/60 text-lg font-light">How would you like to build your resume?</p>
    </div>

    <form action="{{ route('resumebuilder.navigate') }}" method="POST">
      @csrf
      <input type="hidden" name="selected_template" value="{{ $selectedTemplate }}">

      <div class="grid grid-cols-2 gap-5 mb-8">
        {{-- Create New --}}
        <label class="cursor-pointer group">
          <input type="radio" name="option" value="create" class="hidden peer" {{ $selectedOption === 'create' ? 'checked' : '' }}>
          <div class="bg-white rounded-2xl p-7 text-center border-2 border-transparent
                      peer-checked:border-[#6A6CFF] peer-checked:shadow-lg
                      shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#F2E9FF] peer-checked:bg-[#6A6CFF] flex items-center justify-center transition-colors">
              <svg class="w-8 h-8 text-[#6A6CFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
            </div>
            <h3 class="font-['Poppins'] text-xl font-semibold text-[#3A2F6A] mb-1">Create New</h3>
            <p class="text-sm text-[#3A2F6A]/55 font-light">Guided, section by section</p>
          </div>
        </label>

        {{-- Upload --}}
        <label class="cursor-pointer group">
          <input type="radio" name="option" value="upload" class="hidden peer" {{ $selectedOption === 'upload' ? 'checked' : '' }}>
          <div class="bg-white rounded-2xl p-7 text-center border-2 border-transparent
                      peer-checked:border-[#FFB8C6] peer-checked:shadow-lg
                      shadow-md hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-[#FFE9F5] flex items-center justify-center transition-colors">
              <svg class="w-8 h-8 text-[#FFB8C6]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
              </svg>
            </div>
            <h3 class="font-['Poppins'] text-xl font-semibold text-[#3A2F6A] mb-1">Upload Existing</h3>
            <p class="text-sm text-[#3A2F6A]/55 font-light">Import and enhance</p>
          </div>
        </label>
      </div>

      <div class="text-center">
        <button type="submit" name="action" value="proceed"
                class="px-12 py-4 rounded-xl font-['Inter'] font-bold text-lg bg-[#6A6CFF] text-white
                       shadow-lg shadow-[#6A6CFF]/30 hover:bg-[#5555EE] hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
          Proceed →
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════════════════════ BUILDER PAGE ═══════════════════════ --}}
@elseif($currentPage === 'builder')
<div class="min-h-screen flex h-screen overflow-hidden">

  {{-- ── LEFT SIDEBAR ─────────────────────────────────────────────────── --}}
  <div class="w-[280px] flex-shrink-0 flex flex-col p-6 overflow-y-auto bg-gradient-to-br {{ $sectionData['color'] ?? 'from-[#F2E9FF] to-[#FFE9F5]' }} transition-all duration-500">

    {{-- Brand --}}
    <div class="mb-8">
      <div class="font-['Playfair_Display'] text-2xl font-bold text-[#3A2F6A]">Resumate</div>
      <div class="text-xs text-[#3A2F6A]/50 mt-0.5 font-light">AI Resume Builder</div>
    </div>

    {{-- Overall progress --}}
    <div class="mb-6">
      <div class="flex justify-between text-xs mb-2 text-[#3A2F6A]/60 font-medium">
        <span>Progress</span>
        <span>{{ $currentSection + 1 }} / {{ $totalSections }}</span>
      </div>
      <div class="prog-bar">
        <div class="prog-fill" style="width: {{ $sectionProgress }}%"></div>
      </div>
    </div>

    {{-- Section steps --}}
    <div class="flex flex-col gap-1 mb-auto">
      @foreach($sections as $i => $sec)
        @php
          $state = $i < $currentSection ? 'done' : ($i === $currentSection ? 'active' : 'todo');
        @endphp
        <div class="step-item {{ $state === 'active' ? 'active' : '' }}">
          <div class="step-circle {{ $state }}">
            @if($state === 'done')
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            @else
              {{ $i + 1 }}
            @endif
          </div>
          <div>
            <div class="step-name {{ $state }}">{{ $sec['name'] }}</div>
            @if($state === 'active')
              <div class="text-[10.5px] text-[#6A6CFF]/70 font-light mt-0.5">{{ $sec['desc'] }}</div>
            @endif
          </div>
        </div>
      @endforeach
    </div>

    {{-- Template badge --}}
    <div class="mt-6 bg-white/60 rounded-xl p-4">
      <div class="text-[10px] font-bold uppercase tracking-widest text-[#3A2F6A]/40 mb-2">Template</div>
      <div class="flex items-center gap-2">
        <div class="w-8 h-10 bg-white rounded shadow-sm border border-[#E8E6F5] flex-shrink-0 overflow-hidden">
          <div class="h-1.5 bg-[#6A6CFF] w-full"></div>
          <div class="p-1 space-y-0.5">
            <div class="h-0.5 bg-gray-200 rounded"></div>
            <div class="h-0.5 bg-gray-200 rounded w-3/4"></div>
            <div class="h-0.5 bg-gray-100 rounded"></div>
            <div class="h-0.5 bg-gray-100 rounded w-1/2"></div>
          </div>
        </div>
        <div>
          <div class="text-sm font-semibold text-[#3A2F6A]">{{ ucfirst($selectedTemplate) }}</div>
          <div class="text-[11px] text-[#3A2F6A]/40">Active template</div>
        </div>
      </div>
    </div>

  </div>{{-- /sidebar --}}

  {{-- ── RIGHT PANEL ──────────────────────────────────────────────────── --}}
  <div class="flex-1 right-panel overflow-y-auto bg-white flex flex-col">

    {{-- Section Header --}}
    <div class="px-10 pt-10 pb-6 border-b border-gray-100">
      <div class="flex items-start justify-between">
        <div>
          <div class="text-[11px] font-bold uppercase tracking-widest text-[#6A6CFF]/70 mb-1">
            Section {{ $currentSection + 1 }} of {{ $totalSections }}
          </div>
          <h2 class="font-['Playfair_Display'] text-3xl font-bold text-[#3A2F6A]">
            {{ $sectionData['name'] ?? '' }}
          </h2>
          <p class="text-sm text-gray-400 mt-1 font-light">{{ $sectionData['desc'] ?? '' }}</p>
        </div>
        <a href="{{ url('/templates') }}"
           class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors ml-4 flex-shrink-0">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </a>
      </div>
    </div>

    {{-- Section Form --}}
    <div class="flex-1 px-10 py-8">

      {{-- Flash error --}}
      @if(session('error'))
      <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
        {{ session('error') }}
      </div>
      @endif

      {{-- ── Navigation form (Back / Continue) ── --}}
      <form method="POST" action="{{ route('resumebuilder.navigate') }}" id="sectionForm">
        @csrf
        <input type="hidden" name="current_section" value="{{ $currentSection }}">
        <input type="hidden" name="selected_template" value="{{ $selectedTemplate }}">

        {{-- Field grid --}}
        <div class="grid grid-cols-2 gap-x-6 gap-y-5">
          @foreach($sectionData['fields'] ?? [] as $field)

            {{-- Separator (not a real input) --}}
            @if(($field['type'] ?? '') === 'separator')
            <div class="col-span-2 mt-2">
              <div class="field-separator">
                <span>{{ $field['label'] }}</span>
              </div>
            </div>

            {{-- Textarea --}}
            @elseif(($field['type'] ?? '') === 'textarea')
            <div class="{{ ($field['span'] ?? 1) === 2 ? 'col-span-2' : '' }}">
              <label class="field-label">
                {{ $field['label'] }}
                @if(!($field['required'] ?? false))<span class="opt-badge">optional</span>@endif
              </label>
              <textarea
                name="{{ $field['id'] }}"
                class="field-input"
                placeholder="{{ $field['placeholder'] ?? '' }}"
                rows="{{ $field['rows'] ?? 4 }}"
                {{ ($field['required'] ?? false) ? 'required' : '' }}>{{ $formData[$field['id']] ?? '' }}</textarea>
            </div>

            {{-- Regular input --}}
            @else
            <div class="{{ ($field['span'] ?? 1) === 2 ? 'col-span-2' : '' }}">
              <label class="field-label">
                {{ $field['label'] }}
                @if(!($field['required'] ?? false))<span class="opt-badge">optional</span>@endif
              </label>
              <input
                type="{{ $field['type'] ?? 'text' }}"
                name="{{ $field['id'] }}"
                class="field-input"
                placeholder="{{ $field['placeholder'] ?? '' }}"
                value="{{ $formData[$field['id']] ?? '' }}"
                {{ ($field['required'] ?? false) ? 'required' : '' }}>
            </div>
            @endif

          @endforeach
        </div>

        {{-- Navigation buttons --}}
        <div class="flex items-center justify-between mt-10 pt-6 border-t border-gray-100">
          {{-- Back --}}
          @if($currentSection > 0)
          <button type="submit" name="action" value="prev" formnovalidate class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back
          </button>
          @else
          <div></div>
          @endif

          {{-- Continue --}}
          @if(!$isLastSection)
          <button type="submit" name="action" value="next" class="btn-primary">
            Continue
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <polyline points="9 18 15 12 9 6"/>
            </svg>
          </button>
          @endif
        </div>

      </form>

      {{-- ── Generate form (last section only) ── --}}
      @if($isLastSection)
      <form method="POST" action="{{ route('resume.generate') }}" id="generateForm">
        @csrf
        <input type="hidden" name="selected_template" value="{{ $selectedTemplate }}">

        {{-- All accumulated session data as hidden fields --}}
        @foreach($formData as $key => $value)
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        {{-- Generate button --}}
        <div class="flex justify-end">
          <button type="submit" class="btn-generate" id="generateBtn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            Generate Resume
          </button>
        </div>
      </form>
      @endif

    </div>{{-- /form area --}}
  </div>{{-- /right-panel --}}
</div>
@endif

{{-- ══════════════════════════════════ LOADING OVERLAY ════════════════════ --}}
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center backdrop-blur-sm">
  <div class="bg-white rounded-2xl px-12 py-10 max-w-sm w-full text-center shadow-2xl">
    <div class="relative w-16 h-16 mx-auto mb-5">
      <div class="w-16 h-16 rounded-full border-4 border-[#E8E6F5] absolute"></div>
      <div class="w-16 h-16 rounded-full border-4 border-[#6A6CFF] border-t-transparent animate-spin absolute"></div>
    </div>
    <h3 class="font-['Poppins'] text-xl font-bold text-[#3A2F6A] mb-2">Building Your Resume</h3>
    <p class="text-sm text-gray-400 font-light">AI is crafting your summary…</p>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Show loading overlay when generate is submitted
  const generateForm = document.getElementById('generateForm');
  if (generateForm) {
    generateForm.addEventListener('submit', function() {
      // Capture any live field values from the section form into generate form
      const sectionForm = document.getElementById('sectionForm');
      if (sectionForm) {
        sectionForm.querySelectorAll('input[name], textarea[name], select[name]').forEach(el => {
          if (!el.name || el.name.startsWith('_') || el.name === 'action' || el.name === 'current_section') return;
          // Only add if not already in generate form
          if (!generateForm.querySelector(`[name="${el.name}"]`)) {
            const hidden = document.createElement('input');
            hidden.type  = 'hidden';
            hidden.name  = el.name;
            hidden.value = el.value;
            generateForm.appendChild(hidden);
          } else {
            // Update the existing hidden field with live value
            generateForm.querySelector(`[name="${el.name}"]`).value = el.value;
          }
        });
      }
      document.getElementById('loadingOverlay').classList.remove('hidden');
      document.getElementById('generateBtn').disabled = true;
    });
  }

  // Also show overlay when continue/next is clicked (navigating sections)
  const continueBtn = document.querySelector('button[name="action"][value="next"]');
  if (continueBtn) {
    continueBtn.addEventListener('click', () => {
      // Small delay to let validation run first
      setTimeout(() => {
        const form = document.getElementById('sectionForm');
        if (form && form.checkValidity()) {
          document.getElementById('loadingOverlay').classList.remove('hidden');
        }
      }, 50);
    });
  }
});
</script>
</body>
</html>

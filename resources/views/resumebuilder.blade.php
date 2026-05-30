<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Resume Builder — Resumate</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    /* ── Input base ───────────────────────────── */
    .field-input {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid #E2E0F0;
      border-radius: 10px;
      font-family: 'Inter', sans-serif;
      font-size: 15px;           /* slightly larger for mobile tap */
      color: #1C1C3C;
      background: #FAFAFA;
      transition: border-color .18s, box-shadow .18s, background .18s;
      outline: none;
      -webkit-tap-highlight-color: transparent;
    }
    .field-input::placeholder { color: #BCBACF; font-weight: 300; }
    .field-input:focus {
      border-color: #6A6CFF;
      background: white;
      box-shadow: 0 0 0 3px rgba(106,108,255,.12);
    }
    textarea.field-input { resize: vertical; line-height: 1.65; }

    /* ── Field label ──────────────────────────── */
    .field-label {
      display: block;
      font-family: 'Inter', sans-serif;
      font-size: 13px;
      font-weight: 600;
      color: #4A4870;
      margin-bottom: 6px;
      letter-spacing: .02em;
    }
    .opt-badge {
      font-size: 11px;
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
      padding: 12px 22px;
      border-radius: 10px;
      border: 1.5px solid #E2E0F0;
      background: white;
      color: #6B6B8A;
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      font-weight: 500;
      cursor: pointer;
      display: flex; align-items: center; gap: 7px;
      transition: all .15s;
      -webkit-tap-highlight-color: transparent;
    }
    .btn-back:hover { border-color: #A09EC0; background: #FAFAFA; }
    .btn-back:active { transform: scale(0.98); }
    .btn-primary {
      padding: 12px 28px;
      border-radius: 10px;
      border: none;
      background: #6A6CFF;
      color: white;
      font-family: 'Inter', sans-serif;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      display: flex; align-items: center; gap: 8px;
      transition: all .18s;
      box-shadow: 0 4px 14px rgba(106,108,255,.3);
      -webkit-tap-highlight-color: transparent;
    }
    .btn-primary:hover { background: #5555EE; box-shadow: 0 6px 18px rgba(106,108,255,.4); transform: translateY(-1px); }
    .btn-primary:active { transform: scale(0.98) translateY(0); }
    .btn-generate {
      padding: 14px 32px;
      border-radius: 12px;
      border: none;
      background: linear-gradient(135deg, #6A6CFF, #B06AFF);
      color: white;
      font-family: 'Inter', sans-serif;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      display: flex; align-items: center; gap: 9px;
      transition: all .18s;
      box-shadow: 0 5px 18px rgba(106,108,255,.35);
      letter-spacing: .01em;
      -webkit-tap-highlight-color: transparent;
    }
    .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(106,108,255,.5); }
    .btn-generate:active { transform: scale(0.98) translateY(0); }
    .btn-generate:disabled { opacity: .7; cursor: not-allowed; transform: none; }

    /* ── Error message ────────────────────────── */
    .err-msg { font-size: 12px; color: #ef4444; margin-top: 5px; display: none; }
    .field-input.has-error { border-color: #ef4444; }

    /* ── Scrollbar ────────────────────────────── */
    .right-panel::-webkit-scrollbar { width: 6px; }
    .right-panel::-webkit-scrollbar-track { background: transparent; }
    .right-panel::-webkit-scrollbar-thumb { background: #E2E0F0; border-radius: 99px; }

    /* ── Mobile bottom bar safe-area ─────────── */
    .safe-bottom { padding-bottom: max(16px, env(safe-area-inset-bottom)); }
  </style>
</head>
<body class="font-[Inter] text-[#1C1C3C] bg-white antialiased">

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
<div class="min-h-[100dvh] flex items-center justify-center bg-gradient-to-br from-[#F2E9FF] to-[#FFE9F5] px-4 md:px-6 py-10">

  {{-- Close --}}
  <a href="{{ url('/templates') }}"
     class="fixed top-4 right-4 md:top-6 md:right-6 w-11 h-11 flex items-center justify-center rounded-full bg-white shadow-md hover:bg-[#FFB8C6] transition-all group z-50">
    <svg class="w-5 h-5 text-gray-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
  </a>

  <div class="max-w-xl w-full">
    <div class="text-center mb-8 md:mb-10">
      <h1 class="font-['Playfair_Display'] text-4xl md:text-5xl font-bold text-[#3A2F6A] mb-3">Let's Get Started</h1>
      <p class="text-[#3A2F6A]/60 text-base md:text-lg font-light">How would you like to build your resume?</p>
    </div>

    <form action="{{ route('resumebuilder.navigate') }}" method="POST" x-data="{ option: '{{ $selectedOption ?? '' }}' }">
      @csrf
      <input type="hidden" name="selected_template" value="{{ $selectedTemplate }}">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5 mb-8">
        {{-- Create New --}}
        <label class="cursor-pointer group">
          <input type="radio" name="option" value="create" class="hidden peer"
                 :checked="option === 'create'" @click="option = 'create'">
          <div class="bg-white rounded-2xl p-6 md:p-7 text-center border-2 border-transparent
                      peer-checked:border-[#6A6CFF] peer-checked:shadow-lg
                      shadow-md hover:shadow-xl active:scale-[0.98] transition-all duration-300">
            <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-4 rounded-2xl bg-[#F2E9FF] peer-checked:bg-[#6A6CFF] flex items-center justify-center transition-colors">
              <svg class="w-7 h-7 md:w-8 md:h-8 text-[#6A6CFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
            </div>
            <h3 class="font-['Poppins'] text-lg md:text-xl font-semibold text-[#3A2F6A] mb-1">Create New</h3>
            <p class="text-sm text-[#3A2F6A]/55 font-light">Guided, section by section</p>
          </div>
        </label>

      {{-- Edit Ready-Made --}}
      <label class="cursor-pointer group">
  <input type="radio" name="option" value="ready" class="hidden peer"
         :checked="option === 'ready'" @click="option = 'ready'">
  <div class="bg-white rounded-2xl p-6 md:p-7 text-center border-2 border-transparent
              peer-checked:border-[#FF8C6A] peer-checked:shadow-lg
              shadow-md hover:shadow-xl active:scale-[0.98] transition-all duration-300">
    <div class="w-14 h-14 md:w-16 md:h-16 mx-auto mb-4 rounded-2xl bg-[#FFF2E9] flex items-center justify-center">
      <svg class="w-7 h-7 md:w-8 md:h-8 text-[#FF8C6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                 m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
      </svg>
    </div>
    <h3 class="font-['Poppins'] text-lg md:text-xl font-semibold text-[#3A2F6A] mb-1">Edit Ready-Made</h3>
    <p class="text-sm text-[#3A2F6A]/55 font-light">Start from a filled template</p>
  </div>
</label>
      <div class="text-center">
        <button type="submit" name="action" value="proceed"
                class="w-full md:w-auto px-8 md:px-12 py-4 rounded-xl font-['Inter'] font-bold text-lg bg-[#6A6CFF] text-white
                       shadow-lg shadow-[#6A6CFF]/30 hover:bg-[#5555EE] hover:shadow-xl active:scale-[0.98] transition-all duration-200">
          Proceed →
        </button>
      </div>
    </form>
  </div>
</div>

{{-- ══════════════════════════════════ BUILDER PAGE ═══════════════════════ --}}
@elseif($currentPage === 'builder')
<div class="min-h-[100dvh] md:min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row"
     x-data="{ mobileMenuOpen: false }">

  {{-- ── MOBILE STICKY HEADER ─────────────────────────────────────────── --}}
  <div class="md:hidden sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-gray-100 px-4 py-3.5">
    <div class="flex items-center justify-between gap-3">
      <div class="flex items-center gap-3 min-w-0">
        <button type="button" @click="mobileMenuOpen = true"
                class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-gray-100 active:bg-gray-200 transition-colors flex-shrink-0">
          <svg class="w-5 h-5 text-[#3A2F6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
        <div class="min-w-0">
          <div class="text-[10px] font-bold uppercase tracking-widest text-[#6A6CFF]/70 mb-0.5">
            Step {{ $currentSection + 1 }} of {{ $totalSections }}
          </div>
          <h2 class="font-['Playfair_Display'] text-lg font-bold text-[#3A2F6A] truncate leading-tight">
            {{ $sectionData['name'] ?? '' }}
          </h2>
        </div>
      </div>
      <a href="{{ url('/templates') }}"
         class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 flex-shrink-0">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </a>
    </div>
  </div>

  {{-- ── MOBILE SLIDE-OUT SIDEBAR ─────────────────────────────────────── --}}
  <div x-show="mobileMenuOpen"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="-translate-x-full"
       x-transition:enter-end="translate-x-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="translate-x-0"
       x-transition:leave-end="-translate-x-full"
       class="md:hidden fixed inset-y-0 left-0 z-50 w-[280px] bg-white shadow-2xl overflow-y-auto"
       style="display: none;">
    <div class="p-6">
      <div class="flex items-center justify-between mb-8">
        <div class="font-['Playfair_Display'] text-2xl font-bold text-[#3A2F6A]">Resumate</div>
        <button @click="mobileMenuOpen = false" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
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
      <div class="flex flex-col gap-1">
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
      <div class="mt-6 bg-[#F8F7FC] rounded-xl p-4">
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
    </div>
  </div>

  {{-- Overlay for mobile menu --}}
  <div x-show="mobileMenuOpen"
       x-transition.opacity
       @click="mobileMenuOpen = false"
       class="md:hidden fixed inset-0 bg-black/30 z-40 backdrop-blur-sm"
       style="display: none;">
  </div>

  {{-- ── DESKTOP LEFT SIDEBAR ─────────────────────────────────────────── --}}
  <div class="hidden md:flex w-[280px] flex-shrink-0 flex-col p-6 overflow-y-auto bg-gradient-to-br {{ $sectionData['color'] ?? 'from-[#F2E9FF] to-[#FFE9F5]' }} transition-all duration-500">

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
  <div class="flex-1 right-panel overflow-y-auto bg-white flex flex-col pb-32 md:pb-0">

    {{-- Desktop Section Header --}}
    <div class="hidden md:block px-10 pt-10 pb-6 border-b border-gray-100">
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

    {{-- Mobile description (under header, above form) --}}
    <div class="md:hidden px-5 pt-4 pb-2">
      <p class="text-sm text-gray-400 font-light">{{ $sectionData['desc'] ?? '' }}</p>
    </div>

    {{-- Section Form --}}
    <div class="flex-1 px-5 md:px-10 py-6 md:py-8">

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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-0 md:gap-x-6 gap-y-5">
          @foreach($sectionData['fields'] ?? [] as $field)

            {{-- Separator (not a real input) --}}
            @if(($field['type'] ?? '') === 'separator')
            <div class="col-span-1 md:col-span-2 mt-2">
              <div class="field-separator">
                <span>{{ $field['label'] }}</span>
              </div>
            </div>

            {{-- Textarea --}}
            @elseif(($field['type'] ?? '') === 'textarea')
            <div class="{{ ($field['span'] ?? 1) === 2 ? 'md:col-span-2' : '' }}">
              <label class="field-label">
                {{ $field['label'] }}
                @if(!($field['required'] ?? false))<<span class="opt-badge">optional</span>@endif
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
            <div class="{{ ($field['span'] ?? 1) === 2 ? 'md:col-span-2' : '' }}">
              <label class="field-label">
                {{ $field['label'] }}
                @if(!($field['required'] ?? false))<<span class="opt-badge">optional</span>@endif
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

        {{-- Desktop Navigation buttons --}}
        <div class="hidden md:flex items-center justify-between mt-10 pt-6 border-t border-gray-100">
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

        {{-- Desktop Generate button --}}
        <div class="hidden md:flex justify-end mt-10 pt-6 border-t border-gray-100">
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

  {{-- ── MOBILE BOTTOM BAR ────────────────────────────────────────────── --}}
  <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-gray-100 px-5 py-4 z-40 safe-bottom shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
    {{-- Progress dots --}}
    <div class="flex justify-center items-center gap-2 mb-4">
      @foreach($sections as $i => $sec)
        @php
          $dotState = $i < $currentSection ? 'done' : ($i === $currentSection ? 'active' : 'todo');
        @endphp
        <div class="h-2 rounded-full transition-all duration-300
          {{ $dotState === 'active' ? 'w-6 bg-[#6A6CFF]' : ($dotState === 'done' ? 'w-2 bg-[#22c55e]' : 'w-2 bg-[#E2E0F0]') }}">
        </div>
      @endforeach
    </div>

    {{-- Mobile nav buttons --}}
    <div class="flex items-center gap-3">
      @if($currentSection > 0)
        <button type="submit" name="action" value="prev" form="sectionForm" formnovalidate
                class="btn-back flex-1 justify-center py-3.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          Back
        </button>
      @else
        <div class="flex-1"></div>
      @endif

      @if(!$isLastSection)
        <button type="submit" name="action" value="next" form="sectionForm"
                class="btn-primary flex-1 justify-center py-3.5">
          Continue
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="9 18 15 12 9 6"/>
          </svg>
        </button>
      @else
        <button type="submit" form="generateForm"
                class="btn-generate flex-1 justify-center py-3.5" id="generateBtnMobile">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
          </svg>
          Generate Resume
        </button>
      @endif
    </div>
  </div>{{-- /mobile bottom bar --}}

</div>
@endif

{{-- ══════════════════════════════════ LOADING OVERLAY ════════════════════ --}}
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black/40 z-[60] flex items-center justify-center backdrop-blur-sm px-4">
  <div class="bg-white rounded-2xl px-8 py-10 md:px-12 md:py-10 max-w-sm w-full text-center shadow-2xl">
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
  // Show loading overlay when generate is submitted (desktop)
  const generateForm = document.getElementById('generateForm');
  if (generateForm) {
    generateForm.addEventListener('submit', function() {
      syncLiveFieldsToGenerateForm();
      showLoading();
    });
  }

  // Mobile generate button
  const mobileGenerateBtn = document.getElementById('generateBtnMobile');
  if (mobileGenerateBtn) {
    mobileGenerateBtn.addEventListener('click', function(e) {
      // Let the form submit naturally, just show loading
      showLoading();
      this.disabled = true;
    });
  }

  // Also show overlay when continue/next is clicked (navigating sections)
  const continueBtn = document.querySelector('button[name="action"][value="next"]');
  if (continueBtn) {
    continueBtn.addEventListener('click', () => {
      setTimeout(() => {
        const form = document.getElementById('sectionForm');
        if (form && form.checkValidity()) {
          showLoading();
        }
      }, 50);
    });
  }

  function syncLiveFieldsToGenerateForm() {
    const sectionForm = document.getElementById('sectionForm');
    if (!sectionForm || !generateForm) return;
    sectionForm.querySelectorAll('input[name], textarea[name], select[name]').forEach(el => {
      if (!el.name || el.name.startsWith('_') || el.name === 'action' || el.name === 'current_section') return;
      const existing = generateForm.querySelector(`[name="${el.name}"]`);
      if (!existing) {
        const hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = el.name;
        hidden.value = el.value;
        generateForm.appendChild(hidden);
      } else {
        existing.value = el.value;
      }
    });
  }

  function showLoading() {
    document.getElementById('loadingOverlay').classList.remove('hidden');
    const btn = document.getElementById('generateBtn');
    if (btn) btn.disabled = true;
  }
});
</script>
</body>
</html>

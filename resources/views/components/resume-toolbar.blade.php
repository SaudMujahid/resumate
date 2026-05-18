{{--
  ┌─────────────────────────────────────────────────────────┐
  │  resources/views/components/resume-toolbar.blade.php    │
  │                                                         │
  │  Props:                                                 │
  │    template  – 'modern' | 'chronological' | 'minimal'  │
  └─────────────────────────────────────────────────────────┘
--}}
@props(['template' => 'modern'])

@php
/*
 * Each swatch carries a "vars" map: CSS-variable → value.
 * The JS reads this map and sets every entry on :root.
 * This is the single source of truth for all three systems.
 *
 * Modern      : { "--hue": "220" }
 * Chronological: { "--accent": "#1a3a5c", "--stripe": "#c9a84c",
 *                  "--toolbar-bg": "#1a3a5c" }
 * Minimal     : { "--accent": "#2d6a4f", "--accent-pale": "#edf4f0" }
 */
$swatchSets = [

    'modern' => [
        ['vars' => ['--hue' => '220'], 'bg' => 'hsl(220,70%,45%)', 'label' => 'Classic Blue',  'active' => true],
        ['vars' => ['--hue' => '162'], 'bg' => 'hsl(162,60%,38%)', 'label' => 'Emerald'],
        ['vars' => ['--hue' => '270'], 'bg' => 'hsl(270,55%,45%)', 'label' => 'Violet'],
        ['vars' => ['--hue' => '340'], 'bg' => 'hsl(340,65%,42%)', 'label' => 'Rose'],
        ['vars' => ['--hue' => '25'],  'bg' => 'hsl(25,75%,45%)',  'label' => 'Amber'],
        ['vars' => ['--hue' => '195'], 'bg' => 'hsl(195,70%,38%)', 'label' => 'Cyan'],
    ],

    'chronological' => [
        ['vars' => ['--accent' => '#1a3a5c', '--stripe' => '#c9a84c', '--toolbar-bg' => '#1a3a5c'],
         'bg' => '#1a3a5c', 'label' => 'Navy Gold',   'active' => true],
        ['vars' => ['--accent' => '#1e3a2f', '--stripe' => '#52a77a', '--toolbar-bg' => '#1e3a2f'],
         'bg' => '#1e3a2f', 'label' => 'Forest'],
        ['vars' => ['--accent' => '#3b1a5c', '--stripe' => '#a87cd4', '--toolbar-bg' => '#3b1a5c'],
         'bg' => '#3b1a5c', 'label' => 'Plum'],
        ['vars' => ['--accent' => '#5c1a1a', '--stripe' => '#d47c7c', '--toolbar-bg' => '#5c1a1a'],
         'bg' => '#5c1a1a', 'label' => 'Burgundy'],
        ['vars' => ['--accent' => '#1a3a50', '--stripe' => '#4fc3d4', '--toolbar-bg' => '#1a3a50'],
         'bg' => '#1a3a50', 'label' => 'Steel Teal'],
        ['vars' => ['--accent' => '#2a2a2a', '--stripe' => '#e0a030', '--toolbar-bg' => '#2a2a2a'],
         'bg' => '#2a2a2a', 'label' => 'Charcoal'],
    ],

    'minimal' => [
        ['vars' => ['--accent' => '#2d6a4f', '--accent-pale' => '#edf4f0'], 'bg' => '#2d6a4f', 'label' => 'Sage',        'active' => true],
        ['vars' => ['--accent' => '#1e4d8c', '--accent-pale' => '#edf2fb'], 'bg' => '#1e4d8c', 'label' => 'Slate Blue'],
        ['vars' => ['--accent' => '#6b3fa0', '--accent-pale' => '#f3edfb'], 'bg' => '#6b3fa0', 'label' => 'Mauve'],
        ['vars' => ['--accent' => '#8c3a1e', '--accent-pale' => '#fbedea'], 'bg' => '#8c3a1e', 'label' => 'Terracotta'],
        ['vars' => ['--accent' => '#3a5c6b', '--accent-pale' => '#edf2f4'], 'bg' => '#3a5c6b', 'label' => 'Steel'],
        ['vars' => ['--accent' => '#4a4a4a', '--accent-pale' => '#f2f2f2'], 'bg' => '#4a4a4a', 'label' => 'Charcoal'],
    ],

];

$swatches      = $swatchSets[$template] ?? $swatchSets['modern'];
$isDarkToolbar = $template === 'chronological';
$swatchShape   = $template === 'modern' ? 'border-radius:50%' : 'border-radius:4px';
$labelSets     = ['modern' => 'Color', 'chronological' => 'Theme', 'minimal' => 'Accent'];
$pickerLabel   = $labelSets[$template] ?? 'Color';

// Default custom-picker hex (matches first swatch)
$defaultHex    = match($template) {
    'modern'         => '#2563eb',
    'chronological'  => '#1a3a5c',
    'minimal'        => '#2d6a4f',
};
@endphp

{{-- ════════════════════════════════════════════════ STYLES ══ --}}
<style>
.rt-bar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 999;
  padding: 10px 24px;
  display: flex;
  align-items: center;
  gap: 14px;
  flex-wrap: wrap;
  @if($isDarkToolbar)
  background: var(--toolbar-bg, var(--accent));
  box-shadow: 0 3px 14px rgba(0,0,0,.25);
  @else
  background: #ffffff;
  border-bottom: 1px solid #e5e7eb;
  box-shadow: 0 2px 12px rgba(0,0,0,.07);
  @endif
}
.rt-sep {
  width: 1px; height: 26px;
  background: {{ $isDarkToolbar ? 'rgba(255,255,255,.2)' : '#e5e7eb' }};
}
.rt-label {
  font-size: 10.5px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .1em;
  color: {{ $isDarkToolbar ? 'rgba(255,255,255,.5)' : '#9ca3af' }};
}
.rt-swatches { display: flex; gap: 7px; align-items: center; }
.rt-swatch {
  width: 24px; height: 24px;
  cursor: pointer;
  border: 2px solid transparent;
  transition: transform .15s, border-color .15s;
  {{ $swatchShape }};
}
.rt-swatch:hover { transform: scale(1.18); }
.rt-swatch.active {
  border-color: {{ $isDarkToolbar ? 'white' : '#374151' }};
}
.rt-picker-wrap { display: flex; align-items: center; gap: 6px; }
.rt-picker-wrap input[type=color] {
  width: 24px; height: 24px;
  padding: 0;
  background: none;
  cursor: pointer;
  {{ $swatchShape }};
  border: {{ $isDarkToolbar ? '2px solid rgba(255,255,255,.35)' : '1.5px solid #d1d5db' }};
}
.rt-btn {
  display: flex;
  align-items: center;
  gap: 7px;
  padding: 7px 15px;
  border-radius: 7px;
  font-size: 13px;
  font-weight: 500;
  cursor: pointer;
  text-decoration: none;
  transition: all .15s;
  white-space: nowrap;
  @if($isDarkToolbar)
  border: 1.5px solid rgba(255,255,255,.28);
  background: transparent;
  color: white;
  @else
  border: 1.5px solid #e5e7eb;
  background: white;
  color: #374151;
  @endif
}
.rt-btn:hover {
  @if($isDarkToolbar)
  background: rgba(255,255,255,.12);
  @else
  border-color: #9ca3af; background: #f9fafb;
  @endif
}
/* Primary (Download) button — color injected by JS on load */
.rt-btn-primary {
  border-color: transparent !important;
  color: white !important;
}
.rt-hint {
  margin-left: auto;
  font-size: 11.5px;
  display: flex;
  align-items: center;
  gap: 5px;
  color: {{ $isDarkToolbar ? 'rgba(255,255,255,.4)' : '#9ca3af' }};
  font-weight: 300;
}
</style>

{{-- ════════════════════════════════════════════════ HTML ═══ --}}
<div class="rt-bar" id="rt-bar">

  {{-- Back --}}
  <a href="{{ route('resumebuilder') }}" class="rt-btn">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
      <polyline points="15 18 9 12 15 6"/>
    </svg>
    Back
  </a>

  <div class="rt-sep"></div>
  <span class="rt-label">{{ $pickerLabel }}</span>

  {{-- Swatches --}}
  <div class="rt-swatches" id="rt-swatches">
    @foreach($swatches as $sw)
    <div
      class="rt-swatch {{ !empty($sw['active']) ? 'active' : '' }}"
      style="background:{{ $sw['bg'] }}"
      title="{{ $sw['label'] }}"
      data-vars="{{ json_encode($sw['vars']) }}"
    ></div>
    @endforeach
  </div>

  {{-- Custom color picker --}}
  <div class="rt-picker-wrap">
    <input type="color" id="rt-custom" value="{{ $defaultHex }}" title="Custom colour">
    <span class="rt-label">Custom</span>
  </div>

  <div class="rt-sep"></div>

  {{-- Print --}}
  <button class="rt-btn" onclick="window.print()">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="6 9 6 2 18 2 18 9"/>
      <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
      <rect x="6" y="14" width="12" height="8"/>
    </svg>
    Print
  </button>

  {{-- Download --}}
  <a href="{{ route('resume.download') }}" class="rt-btn rt-btn-primary" id="rt-dl">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
      <polyline points="7 10 12 15 17 10"/>
      <line x1="12" y1="15" x2="12" y2="3"/>
    </svg>
    Download PDF
  </a>

  <div class="rt-hint">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
      <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
    </svg>
    Click any text to edit
  </div>
</div>

{{-- ════════════════════════════════════════════════ SCRIPT ══ --}}
<script>
(function () {
  const TEMPLATE     = @json($template);
  const IS_DARK_BAR  = @json($isDarkToolbar);
  const root         = document.documentElement;
  const bar          = document.getElementById('rt-bar');
  const dlBtn        = document.getElementById('rt-dl');

  /* ── Apply a vars map to :root and update reactive UI ─── */
  function applyVars(vars) {
    for (const [prop, val] of Object.entries(vars)) {
      if (prop === '--toolbar-bg') {
        // Chronological: toolbar itself changes colour
        if (bar) bar.style.background = val;
      } else {
        root.style.setProperty(prop, val);
      }
    }
    syncDownloadBtn(vars);
  }

  /* ── Keep Download button colour in sync ─────────────── */
  function syncDownloadBtn(vars) {
    if (!dlBtn) return;
    let colour;
    if (TEMPLATE === 'modern') {
      const hue = vars['--hue'] ?? '220';
      colour = `hsl(${hue},70%,45%)`;
    } else if (TEMPLATE === 'chronological') {
      colour = vars['--stripe'] ?? '#c9a84c';
    } else {
      // minimal
      colour = vars['--accent'] ?? '#2d6a4f';
    }
    dlBtn.style.background   = colour;
    dlBtn.style.borderColor  = colour;
  }

  /* ── Initialise: apply first (active) swatch on load ─── */
  const firstActive = document.querySelector('.rt-swatch.active');
  if (firstActive) applyVars(JSON.parse(firstActive.dataset.vars));

  /* ── Swatch clicks ───────────────────────────────────── */
  document.querySelectorAll('.rt-swatch').forEach(sw => {
    sw.addEventListener('click', () => {
      document.querySelectorAll('.rt-swatch').forEach(x => x.classList.remove('active'));
      sw.classList.add('active');
      applyVars(JSON.parse(sw.dataset.vars));
    });
  });

  /* ── Custom colour picker ────────────────────────────── */
  document.getElementById('rt-custom')?.addEventListener('input', function () {
    const hex = this.value;
    document.querySelectorAll('.rt-swatch').forEach(x => x.classList.remove('active'));

    if (TEMPLATE === 'modern') {
      applyVars({ '--hue': String(hexToHue(hex)) });

    } else if (TEMPLATE === 'chronological') {
      // Keep existing stripe, just update accent + toolbar
      const currentStripe = getComputedStyle(root).getPropertyValue('--stripe').trim()
                          || '#c9a84c';
      applyVars({ '--accent': hex, '--stripe': currentStripe, '--toolbar-bg': hex });

    } else {
      // minimal: derive a very pale tint automatically
      applyVars({ '--accent': hex, '--accent-pale': hexToPale(hex) });
    }
  });

  /* ── Helpers ─────────────────────────────────────────── */
  function hexToHue(hex) {
    const r = parseInt(hex.slice(1,3),16)/255;
    const g = parseInt(hex.slice(3,5),16)/255;
    const b = parseInt(hex.slice(5,7),16)/255;
    const max = Math.max(r,g,b), min = Math.min(r,g,b);
    if (max === min) return 0;
    const d = max - min;
    let h;
    if (max===r)      h = ((g-b)/d + (g<b?6:0)) * 60;
    else if (max===g) h = ((b-r)/d + 2) * 60;
    else              h = ((r-g)/d + 4) * 60;
    return Math.round(h);
  }

  // Mix hex colour with white at ~92% white to get a pale tint
  function hexToPale(hex) {
    const r = parseInt(hex.slice(1,3),16);
    const g = parseInt(hex.slice(3,5),16);
    const b = parseInt(hex.slice(5,7),16);
    const mix = v => Math.round(v + (255-v)*0.88);
    return '#' + [mix(r),mix(g),mix(b)].map(v=>v.toString(16).padStart(2,'0')).join('');
  }

})();
</script>

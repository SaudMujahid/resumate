{{--
  ┌─────────────────────────────────────────────────────────┐
  │  resources/views/components/resume-toolbar.blade.php    │
  │                                                         │
  │  Props:                                                 │
  │    template  – 'modern' | 'chronological' | 'minimal'  │
  │                                                         │
  │  Enriched with A4 fit gauges, auto-spacing toggles,     │
  │  and full interactive design controls.                 │
  └─────────────────────────────────────────────────────────┘
--}}
@props(['template' => 'modern'])

@php
$swatchSets = [
    'modern' => [
        ['vars' => ['--hue' => '220'], 'bg' => 'hsl(220,70%,45%)', 'label' => 'Classic Blue', 'active' => true],
        ['vars' => ['--hue' => '162'], 'bg' => 'hsl(162,60%,38%)', 'label' => 'Emerald'],
        ['vars' => ['--hue' => '270'], 'bg' => 'hsl(270,55%,45%)', 'label' => 'Violet'],
        ['vars' => ['--hue' => '340'], 'bg' => 'hsl(340,65%,42%)', 'label' => 'Rose'],
        ['vars' => ['--hue' => '25'],  'bg' => 'hsl(25,75%,45%)',  'label' => 'Amber'],
        ['vars' => ['--hue' => '195'], 'bg' => 'hsl(195,70%,38%)', 'label' => 'Cyan'],
    ],
    'chronological' => [
        ['vars' => ['--accent' => '#1a3a5c', '--stripe' => '#c9a84c', '--toolbar-bg' => '#1a3a5c'], 'bg' => '#1a3a5c', 'label' => 'Navy Gold',  'active' => true],
        ['vars' => ['--accent' => '#1e3a2f', '--stripe' => '#52a77a', '--toolbar-bg' => '#1e3a2f'], 'bg' => '#1e3a2f', 'label' => 'Forest'],
        ['vars' => ['--accent' => '#3b1a5c', '--stripe' => '#a87cd4', '--toolbar-bg' => '#3b1a5c'], 'bg' => '#3b1a5c', 'label' => 'Plum'],
        ['vars' => ['--accent' => '#5c1a1a', '--stripe' => '#d47c7c', '--toolbar-bg' => '#5c1a1a'], 'bg' => '#5c1a1a', 'label' => 'Burgundy'],
        ['vars' => ['--accent' => '#1a3a50', '--stripe' => '#4fc3d4', '--toolbar-bg' => '#1a3a50'], 'bg' => '#1a3a50', 'label' => 'Steel Teal'],
        ['vars' => ['--accent' => '#2a2a2a', '--stripe' => '#e0a030', '--toolbar-bg' => '#2a2a2a'], 'bg' => '#2a2a2a', 'label' => 'Charcoal'],
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
$pickerLabel   = ['modern' => 'Color', 'chronological' => 'Theme', 'minimal' => 'Accent'][$template] ?? 'Color';
$hasExtras     = true; // Always enable layout extras (A4 Spacing systems!)
$defaultHex    = match($template) {
    'chronological' => '#1a3a5c',
    'minimal'       => '#2d6a4f',
    default         => '#2563eb',
};
@endphp

<style>
.rt-bar {
  position: fixed; top: 0; left: 0; right: 0; z-index: 999;
  padding: 12px 24px;
  display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
  @if($isDarkToolbar)
    background: var(--toolbar-bg, var(--accent));
    box-shadow: 0 4px 20px rgba(0,0,0,.3);
  @else
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 2px 14px rgba(0,0,0,.06);
  @endif
}
.rt-sep { width: 1px; height: 26px; background: {{ $isDarkToolbar ? 'rgba(255,255,255,.2)' : '#e5e7eb' }}; }
.rt-label {
  font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: .08em;
  color: {{ $isDarkToolbar ? 'rgba(255,255,255,.6)' : '#6b7280' }};
}
.rt-swatches { display: flex; gap: 7px; align-items: center; }
.rt-swatch {
  width: 20px; height: 20px; cursor: pointer;
  border: 2px solid transparent;
  transition: transform .15s, border-color .15s;
  {{ $swatchShape }};
}
.rt-swatch:hover { transform: scale(1.18); }
.rt-swatch.active { border-color: {{ $isDarkToolbar ? 'white' : '#374151' }}; }
.rt-picker-wrap { display: flex; align-items: center; gap: 6px; }
.rt-picker-wrap input[type=color] {
  width: 20px; height: 20px; padding: 0;
  background: none; cursor: pointer;
  {{ $swatchShape }};
  border: {{ $isDarkToolbar ? '2px solid rgba(255,255,255,.35)' : '1.5px solid #d1d5db' }};
}
.rt-btn {
  display: flex; align-items: center; gap: 7px;
  padding: 6px 14px; border-radius: 8px;
  font-size: 12.5px; font-weight: 500;
  cursor: pointer; text-decoration: none;
  transition: all .15s; white-space: nowrap;
  @if($isDarkToolbar)
    border: 1.5px solid rgba(255,255,255,.28); background: transparent; color: white;
  @else
    border: 1.5px solid #e5e7eb; background: white; color: #374151;
  @endif
}
.rt-btn:hover {
  @if($isDarkToolbar) background: rgba(255,255,255,.12);
  @else border-color: #9ca3af; background: #f9fafb;
  @endif
}
.rt-btn-primary {
  border-color: transparent !important;
  color: white !important;
  background: #4f46e5;
  box-shadow: 0 4px 10px rgba(79, 70, 229, 0.2);
}
.rt-btn-primary:hover {
  background: #4338ca !important;
}
.rt-select {
  font-size: 11.5px; font-weight: 600;
  padding: 5px 8px; border-radius: 6px;
  cursor: pointer; outline: none; transition: all .15s;
  @if($isDarkToolbar)
    background: rgba(255,255,255,.12);
    border: 1.5px solid rgba(255,255,255,.25);
    color: white;
  @else
    background: white; border: 1.5px solid #e5e7eb; color: #374151;
  @endif
}
.rt-select:hover {
  @if($isDarkToolbar) background: rgba(255,255,255,.18);
  @else border-color: #9ca3af;
  @endif
}

/* Smart gauge formatting */
.rt-gauge-box {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 4px 12px;
  border-radius: 8px;
  font-size: 11.5px;
  font-weight: 600;
  background: {{ $isDarkToolbar ? 'rgba(255,255,255,0.08)' : 'rgba(15, 23, 42, 0.05)' }};
  border: 1px solid {{ $isDarkToolbar ? 'rgba(255,255,255,0.1)' : 'rgba(15, 23, 42, 0.08)' }};
}
.rt-gauge-bar {
  width: 50px;
  height: 6px;
  background: rgba(148, 163, 184, 0.2);
  border-radius: 3px;
  overflow: hidden;
}
.rt-gauge-fill {
  height: 100%;
  border-radius: 3px;
  transition: width 0.3s ease;
}
.rt-gauge-text {
  font-family: monospace;
}

/* Layout sliders */
.rt-slider-wrap { display: flex; align-items: center; gap: 7px; }
.rt-slider {
  width: 64px; height: 4px; border-radius: 9999px;
  appearance: none; cursor: pointer;
  background: {{ $isDarkToolbar ? 'rgba(255,255,255,.2)' : '#cbd5e1' }};
}

.rt-hint {
  margin-left: auto; font-size: 11.5px;
  display: flex; align-items: center; gap: 5px; font-weight: 400;
  color: {{ $isDarkToolbar ? 'rgba(255,255,255,.5)' : '#6b7280' }};
}

/* Theme variable integrations */
.gauge-perfect {
  --gauge-color: #10b981;
}
.gauge-underflow {
  --gauge-color: #f59e0b;
}
.gauge-overflow {
  --gauge-color: #ef4444;
}

@media print { .rt-bar { display: none !important; } }
</style>

<div class="rt-bar shadow-sm" id="rt-bar">

  {{-- Back --}}
  <a href="{{ route('resumebuilder') }}" class="rt-btn">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Wizard
  </a>

  <div class="rt-sep"></div>

  {{-- Swatches --}}
  <span class="rt-label">{{ $pickerLabel }}</span>
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
  <div class="rt-picker-wrap">
    <input type="color" id="rt-custom" value="{{ $defaultHex }}" title="Custom colour">
  </div>

  <div class="rt-sep"></div>

  {{-- Fonts --}}
  <span class="rt-label">Font</span>
  <select x-model="fontFamily" @change="saveSettings" class="rt-select">
    <option value="sans">DM Sans</option>
    <option value="serif">DM Serif</option>
    <option value="mono">Monospace</option>
  </select>

  {{-- Spacing Preset --}}
  <select x-model="spacing" @change="saveSettings(); $nextTick(() => calculateA4Fit())" class="rt-select">
    <option value="compact">Compact Margins</option>
    <option value="normal">Normal Margins</option>
    <option value="spacious">Spacious Margins</option>
  </select>

  <div class="rt-sep"></div>

  {{-- Visual Spacing Slider & Auto spacing --}}
  <div class="rt-slider-wrap">
    <span class="rt-label">Spacing</span>
    <input type="range" min="0.7" max="1.3" step="0.05" x-model.number="spacingMultiplier" @input="saveSettings(); calculateA4Fit()" class="rt-slider">
    <span style="font-size: 11px; opacity: 0.7; font-family: monospace; min-width: 28px;" x-text="Math.round(spacingMultiplier * 100) + '%'"></span>
  </div>

  <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; user-select: none; font-size: 12px; font-weight: 500; color: {{ $isDarkToolbar ? '#fff' : '#374151' }}">
    <input type="checkbox" x-model="autoSpace" @change="saveSettings(); $nextTick(() => calculateA4Fit())" style="width: 14px; height: 14px; accent-color: #4f46e5;">
    <span>Auto-Budget</span>
  </label>

  <div class="rt-sep"></div>

  {{-- Fit level indicator gauge --}}
  <div class="rt-gauge-box" :class="isOverflowing ? 'gauge-overflow' : (isUnderflowing ? 'gauge-underflow' : 'gauge-perfect')">
    <span class="rt-label" style="font-size: 9px; color: var(--gauge-color)">A4 Fill</span>
    <div class="rt-gauge-bar">
      <div class="rt-gauge-fill" :style="'width: ' + Math.min(fillPercentage, 100) + '%; background-color: var(--gauge-color);'"></div>
    </div>
    <span class="rt-gauge-text" :style="'color: var(--gauge-color)'" x-text="fillPercentage + '%'">100%</span>
  </div>

  {{-- Print --}}
  <button class="rt-btn" onclick="window.print()">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <polyline points="6 9 6 2 18 2 18 9"/>
      <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
      <rect x="6" y="14" width="12" height="8"/>
    </svg>
    Print Sheet
  </button>

  {{-- Download --}}
  <a href="{{ route('resume.download') }}" class="rt-btn rt-btn-primary" id="rt-dl">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
      <polyline points="7 10 12 15 17 10"/>
      <line x1="12" y1="15" x2="12" y2="3"/>
    </svg>
    Export PDF
  </a>

</div>

<script>
(function () {
  const TEMPLATE    = @json($template);
  const root        = document.documentElement;
  const bar         = document.getElementById('rt-bar');
  const dlBtn       = document.getElementById('rt-dl');

  function applyVars(vars) {
    for (const [prop, val] of Object.entries(vars)) {
      if (prop === '--toolbar-bg') { if (bar) bar.style.background = val; }
      else root.style.setProperty(prop, val);
    }
    syncDownloadBtn(vars);
  }

  function syncDownloadBtn(vars) {
    if (!dlBtn) return;
    const colour = TEMPLATE === 'modern'
      ? `hsl(${vars['--hue'] ?? '220'},70%,45%)`
      : TEMPLATE === 'chronological'
        ? (vars['--stripe'] ?? '#c9a84c')
        : (vars['--accent'] ?? '#2d6a4f');
    dlBtn.style.background = dlBtn.style.borderColor = colour;
  }

  const firstActive = document.querySelector('.rt-swatch.active');
  if (firstActive) {
    applyVars(JSON.parse(firstActive.dataset.vars));
  } else {
    syncDownloadBtn({ '--hue': '220', '--accent': '#4f46e5', '--stripe': '#c9a84c' });
  }

  document.querySelectorAll('.rt-swatch').forEach(sw => {
    sw.addEventListener('click', () => {
      document.querySelectorAll('.rt-swatch').forEach(x => x.classList.remove('active'));
      sw.classList.add('active');
      applyVars(JSON.parse(sw.dataset.vars));
      
      // Sync to local storage for persistence across pages
      const vars = JSON.parse(sw.dataset.vars);
      if (window.Alpine) {
        if (vars['--hue']) {
          Alpine.store('themeColor', { hue: vars['--hue'] });
        } else if (vars['--accent']) {
          root.style.setProperty('--accent', vars['--accent']);
          if (vars['--accent-pale']) root.style.setProperty('--accent-pale', vars['--accent-pale']);
          if (vars['--stripe']) root.style.setProperty('--stripe', vars['--stripe']);
        }
      }
    });
  });

  document.getElementById('rt-custom')?.addEventListener('input', function () {
    const hex = this.value;
    document.querySelectorAll('.rt-swatch').forEach(x => x.classList.remove('active'));
    if (TEMPLATE === 'modern') {
      applyVars({ '--hue': String(hexToHue(hex)) });
    } else if (TEMPLATE === 'chronological') {
      const stripe = getComputedStyle(root).getPropertyValue('--stripe').trim() || '#c9a84c';
      applyVars({ '--accent': hex, '--stripe': stripe, '--toolbar-bg': hex });
    } else {
      applyVars({ '--accent': hex, '--accent-pale': hexToPale(hex) });
    }
  });

  function hexToHue(hex) {
    const r = parseInt(hex.slice(1,3),16)/255, g = parseInt(hex.slice(3,5),16)/255, b = parseInt(hex.slice(5,7),16)/255;
    const max = Math.max(r,g,b), min = Math.min(r,g,b), d = max - min;
    if (!d) return 0;
    let h = max===r ? ((g-b)/d+(g<b?6:0))*60 : max===g ? ((b-r)/d+2)*60 : ((r-g)/d+4)*60;
    return Math.round(h);
  }

  function hexToPale(hex) {
    const mix = v => Math.round(parseInt(hex.slice(v,v+2),16) * .12 + 255 * .88);
    return '#' + [1,3,5].map(v => mix(v).toString(16).padStart(2,'0')).join('');
  }
})();
</script>

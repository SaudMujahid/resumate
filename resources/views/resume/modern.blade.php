<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>

@vite(['resources/css/app.css', 'resources/js/resume-modern.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>
    [x-cloak] { display: none !important; }

    .resume-shadow {
        box-shadow: 0 12px 60px rgba(0, 0, 0, 0.22);
    }

    .font-ats { font-family: Arial, Helvetica, sans-serif !important; }
    .font-sans-custom { font-family: 'DM Sans', sans-serif; }
    .font-serif-custom { font-family: 'DM Serif Display', serif; }
    .font-mono-custom { font-family: 'Courier New', monospace; }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; padding: 0 !important; }
        .resume-shadow { box-shadow: none !important; }
        .resume-page-wrap { padding: 0 !important; }
    }
</style>
</head>
<body class="bg-gray-100 min-h-screen font-sans-custom"
      x-data="resumeApp()"
      x-init="init()"
      :class="fontClass">

    <x-resume-toolbar template="modern" />

    @php
        $headlineTitle = $resume['experience'][0]['title'] ?? ($resume['education'][0]['degree'] ?? 'Student');
        $headlineOrg = $resume['experience'][0]['company'] ?? ($resume['education'][0]['school'] ?? null);
        $nameParts = preg_split('/\s+/', trim($resume['name'] ?? ''));
        $initials = count($nameParts) >= 2
            ? strtoupper(mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[count($nameParts) - 1], 0, 1))
            : strtoupper(mb_substr($nameParts[0] ?? 'U', 0, 1));
    @endphp

    <div class="pt-24 pb-12 px-4 resume-page-wrap">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300"
             :style="layoutStyle">

            {{-- Sidebar --}}
            <aside class="text-white flex flex-col"
                   :class="atsMode ? 'hidden' : spacingClasses.sidebar"
                   :style="`background: hsl(${hue}, 40%, 18%)`">

                <div class="flex flex-col items-center gap-3">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl text-white font-serif-custom shadow-lg"
                         :style="`background: hsl(${hue}, 70%, 45%)`">
                        {{ $initials }}
                    </div>
                    <h2 class="font-serif-custom text-xl text-center leading-tight">{{ $resume['name'] }}</h2>
                    <p class="text-xs uppercase tracking-widest text-center font-medium opacity-80">{{ $headlineTitle }}</p>
                </div>

                <div class="space-y-3">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] pb-2 border-b border-white/10 opacity-70">Contact</h3>
                    <div class="flex items-start gap-2.5 text-sm opacity-90">
                        <span class="break-all">{{ $resume['email'] }}</span>
                    </div>
                    @if(!empty($resume['phone']))
                    <div class="text-sm opacity-90">{{ $resume['phone'] }}</div>
                    @endif
                    @if(!empty($resume['city']))
                    <div class="text-sm opacity-90">{{ $resume['city'] }}</div>
                    @endif
                </div>

                @if(!empty($resume['skills']['technical']))
                <div class="space-y-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] pb-2 border-b border-white/10 opacity-70">Technical Skills</h3>
                    <div class="space-y-3">
                        @foreach($resume['skills']['technical'] as $i => $skill)
                        @php $pct = max(60, 100 - ($i * 8)); @endphp
                        <div>
                            <div class="text-xs mb-1.5 opacity-90">{{ $skill }}</div>
                            <div class="h-1 bg-white/10 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" :style="`width: {{ $pct }}%; background: hsl(${hue}, 70%, 65%)`"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($resume['skills']['soft']))
                <div class="space-y-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] pb-2 border-b border-white/10 opacity-70">Soft Skills</h3>
                    <ul class="space-y-2 text-sm opacity-90">
                        @foreach($resume['skills']['soft'] as $skill)
                        <li>{{ $skill }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(!empty($resume['skills']['languages']))
                <div class="space-y-4">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.15em] pb-2 border-b border-white/10 opacity-70">Languages</h3>
                    <div class="space-y-2">
                        @foreach($resume['skills']['languages'] as $i => $lang)
                        <div class="flex justify-between text-sm opacity-90">
                            <span>{{ $lang }}</span>
                            <span class="text-xs opacity-60">{{ $i === 0 ? 'Native' : ($i === 1 ? 'Fluent' : 'Intermediate') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>

            {{-- Main --}}
            <main class="bg-white flex flex-col"
                  :class="atsMode ? 'max-w-[800px] mx-auto p-10' : spacingClasses.main">

                <div class="border-b-2 border-gray-800 pb-5 mb-6">
                    <h1 class="text-3xl leading-tight text-gray-900 font-serif-custom">{{ $resume['name'] }}</h1>
                    <p class="text-sm uppercase tracking-wide mt-1.5 font-semibold text-gray-600">
                        {{ $headlineTitle }}
                        @if($headlineOrg)
                            &nbsp;·&nbsp; {{ $headlineOrg }}
                        @endif
                    </p>
                </div>

                @if(!empty($resume['summary']))
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-[0.15em] flex items-center gap-2 mb-3 text-gray-700">
                        Professional Summary
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </h3>
                    <p class="text-sm leading-relaxed text-gray-600">{{ $resume['summary'] }}</p>
                </div>
                @endif

                @if(!empty($resume['experience']))
                <div class="mb-6">
                    <h3 class="text-xs font-bold uppercase tracking-[0.15em] flex items-center gap-2 mb-4 text-gray-700">
                        Experience
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </h3>
                    <div class="space-y-5">
                        @foreach($resume['experience'] as $exp)
                        <div class="pb-5 border-b border-gray-100 last:border-0 last:pb-0">
                            <div class="flex justify-between items-start mb-1 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $exp['title'] ?? '' }}</h4>
                                    <p class="text-sm font-medium mt-0.5 text-gray-600">{{ $exp['company'] ?? '' }}</p>
                                </div>
                                @if(!empty($exp['duration']))
                                <span class="text-xs px-3 py-1 rounded-full text-white font-medium whitespace-nowrap bg-gray-800">{{ $exp['duration'] }}</span>
                                @endif
                            </div>
                            @if(!empty($exp['responsibilities']))
                            <ul class="mt-2.5 space-y-1.5">
                                @foreach($exp['responsibilities'] as $resp)
                                <li class="text-sm text-gray-600 pl-4 relative">
                                    <span class="absolute left-0 text-xs mt-1 text-gray-800">▸</span>
                                    {{ $resp }}
                                </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($resume['education']))
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-[0.15em] flex items-center gap-2 mb-4 text-gray-700">
                        Education
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </h3>
                    <div class="space-y-4">
                        @foreach($resume['education'] as $edu)
                        <div class="flex gap-3">
                            <div class="w-2.5 h-2.5 rounded-full mt-1.5 shrink-0 bg-gray-800"></div>
                            <div>
                                @if(!empty($edu['degree']))
                                    <h4 class="font-semibold text-gray-900">{{ $edu['degree'] }}@if(!empty($edu['major'])) <span class="font-normal text-gray-600">in {{ $edu['major'] }}</span>@endif</h4>
                                @else
                                    <h4 class="font-semibold text-gray-900">{{ $edu['level'] ?? 'Education' }}</h4>
                                @endif
                                <p class="text-sm text-gray-500 mt-0.5">{{ $edu['school'] ?? '' }}@if(!empty($edu['year'])) &nbsp;·&nbsp; {{ $edu['year'] }}@endif</p>
                                @if(!empty($edu['cgpa']))
                                    <span class="inline-block text-[11px] font-medium text-white px-2 py-0.5 rounded-full mt-1.5 bg-gray-700">CGPA {{ $edu['cgpa'] }}</span>
                                @elseif(!empty($edu['grade']))
                                    <span class="inline-block text-[11px] font-medium text-white px-2 py-0.5 rounded-full mt-1.5 bg-gray-700">GPA {{ $edu['grade'] }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($resume['skills']['technical']))
                <div x-show="atsMode" x-cloak class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-xs font-bold uppercase tracking-[0.15em] font-ats mb-3">Skills & Competencies</h3>
                    <p class="text-sm font-ats text-gray-800 leading-relaxed">
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

            </main>
        </div>
    </div>

    <script>
    function resumeApp() {
        return {
            hue: 220,
            atsMode: false,
            fontFamily: 'sans',
            spacing: 'normal',
            sidebarWidth: 260,

            get fontClass() {
                if (this.atsMode) return 'font-ats';
                return {
                    'sans': 'font-sans-custom',
                    'serif': 'font-serif-custom',
                    'mono': 'font-mono-custom'
                }[this.fontFamily] || 'font-sans-custom';
            },

get sidebarClass() {
    if (this.atsMode) return 'hidden';
    return 'flex flex-col ' + this.spacingClasses.sidebar;
},

get mainClass() {
    const map = {
        compact: 'max-w-[800px] mx-auto p-6 gap-5',
        normal:  'max-w-[800px] mx-auto p-10 gap-6',
        spacious:'max-w-[800px] mx-auto p-12 gap-8'
    };
    return this.atsMode
        ? (map[this.spacing] || map.normal)
        : this.spacingClasses.main;
},
            get layoutStyle() {
                if (this.atsMode) {
                    return 'max-width: 800px; margin-left: auto; margin-right: auto;';
                }
                return `max-width: 860px; display: grid; grid-template-columns: ${this.sidebarWidth}px 1fr;`;
            },

            init() {
                const saved = localStorage.getItem('resumeSettings');
                if (saved) {
                    const s = JSON.parse(saved);
                    this.hue = s.hue ?? 220;
                    this.atsMode = s.atsMode ?? false;
                    this.fontFamily = s.fontFamily ?? 'sans';
                    this.spacing = s.spacing ?? 'normal';
                    this.sidebarWidth = s.sidebarWidth ?? 260;
                }
            },

            saveSettings() {
                localStorage.setItem('resumeSettings', JSON.stringify({
                    hue: this.hue,
                    atsMode: this.atsMode,
                    fontFamily: this.fontFamily,
                    spacing: this.spacing,
                    sidebarWidth: this.sidebarWidth
                }));
            }
        }
    }
    </script>
</body>
</html>

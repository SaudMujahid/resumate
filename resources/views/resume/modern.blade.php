<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $resume['name'] }} — Resume</title>

@if(empty($forPdf))
    @vite(['resources/css/app.css', 'resources/js/resume-modern.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
@endif

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
    }

    @if(!empty($forPdf))
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'DejaVu Sans', sans-serif;
        background: white;
        padding: 0;
    }
    .resume-pdf-wrap {
        max-width: 860px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 260px 1fr;
        background: white;
    }
    .resume-pdf-sidebar {
        background: hsl(220, 40%, 18%);
        color: white;
        padding: 32px 26px;
        display: flex;
        flex-direction: column;
        gap: 28px;
    }
    .resume-pdf-main { padding: 40px; background: white; }
    .resume-pdf-sidebar h2,
    .resume-pdf-main h1 { font-family: 'DejaVu Serif', serif; }
    @endif
</style>
</head>
<body class="bg-gray-100 min-h-screen font-sans-custom"
      @if(empty($forPdf))
      x-data="resumeApp()"
      x-init="init()"
      :class="fontClass"
      @endif>

    @if(empty($forPdf))
    {{-- Toolbar --}}
    <div class="no-print fixed top-0 left-0 right-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center gap-3 flex-wrap">

            <a href="{{ route('resumebuilder') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>

            <div class="w-px h-6 bg-gray-300"></div>

            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" x-model="atsMode" @change="saveSettings" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                <span class="text-sm font-semibold" :class="atsMode ? 'text-emerald-700' : 'text-gray-700'">
                    <span x-show="!atsMode">ATS Safe Mode</span>
                    <span x-show="atsMode" x-cloak class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        ATS Mode Active
                    </span>
                </span>
            </label>

            <div class="w-px h-6 bg-gray-300"></div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Color</span>
                <template x-for="h in presets" :key="h">
                    <button type="button" @click="setHue(h)"
                            class="w-6 h-6 rounded-full border-2 transition-transform hover:scale-110"
                            :class="hue == h ? 'border-gray-800' : 'border-transparent'"
                            :style="`background: hsl(${h}, 70%, 45%)`"></button>
                </template>
                <div class="relative flex items-center gap-1 ml-1">
                    <input type="color" x-model="customColor" @input="updateCustomColor" class="w-7 h-7 rounded-full overflow-hidden border-0 p-0 cursor-pointer">
                    <span class="text-xs text-gray-500">Custom</span>
                </div>
            </div>

            <div class="w-px h-6 bg-gray-300"></div>

            <select x-model="fontFamily" @change="saveSettings" class="text-sm border-gray-300 rounded-md shadow-sm py-1">
                <option value="sans">DM Sans</option>
                <option value="serif">DM Serif</option>
                <option value="mono">Monospace</option>
            </select>

            <select x-model="spacing" @change="saveSettings" class="text-sm border-gray-300 rounded-md shadow-sm py-1">
                <option value="compact">Compact</option>
                <option value="normal">Normal</option>
                <option value="spacious">Spacious</option>
            </select>

            <template x-if="!atsMode">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Sidebar</span>
                    <input type="range" min="200" max="320" x-model.number="sidebarWidth" @change="saveSettings" class="w-20 h-1 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                </div>
            </template>

            <div class="flex-1"></div>

            <button type="button" @click="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
            <a href="{{ route('resume.download') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white rounded-lg hover:opacity-90 transition shadow-sm" :style="`background: hsl(${hue}, 70%, 45%)`">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Download PDF
            </a>
        </div>
    </div>
    @endif

    @php
        $headlineTitle = $resume['experience'][0]['title'] ?? ($resume['education'][0]['degree'] ?? 'Student');
        $headlineOrg = $resume['experience'][0]['company'] ?? ($resume['education'][0]['school'] ?? null);
        $nameParts = preg_split('/\s+/', trim($resume['name'] ?? ''));
        $initials = count($nameParts) >= 2
            ? strtoupper(mb_substr($nameParts[0], 0, 1) . mb_substr($nameParts[count($nameParts) - 1], 0, 1))
            : strtoupper(mb_substr($nameParts[0] ?? 'U', 0, 1));
    @endphp

    <div class="{{ empty($forPdf) ? 'pt-24 pb-12 px-4' : 'py-0 px-0' }}">
        <div class="mx-auto bg-white resume-shadow overflow-hidden transition-all duration-300 {{ !empty($forPdf) ? 'resume-pdf-wrap' : '' }}"
             @if(empty($forPdf))
             :style="layoutStyle"
             @endif>

            {{-- Sidebar --}}
            <aside class="text-white {{ !empty($forPdf) ? 'resume-pdf-sidebar' : '' }}"
                   @if(empty($forPdf))
                   :class="atsMode ? 'hidden' : 'flex flex-col ' + spacingClasses.sidebar"
                   :style="`background: hsl(${hue}, 40%, 18%)`"
                   @else
                   style="background: hsl(220, 40%, 18%)"
                   @endif>

                <div class="flex flex-col items-center gap-3">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl text-white font-serif-custom shadow-lg"
                         @if(empty($forPdf)) :style="`background: hsl(${hue}, 70%, 45%)`" @else style="background: hsl(220, 70%, 45%)" @endif>
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
                                @if(empty($forPdf))
                                <div class="h-full rounded-full transition-all duration-500" :style="`width: {{ $pct }}%; background: hsl(${hue}, 70%, 65%)`"></div>
                                @else
                                <div class="h-full rounded-full" style="width: {{ $pct }}%; background: hsl(220, 70%, 65%)"></div>
                                @endif
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
            <main class="bg-white flex flex-col {{ !empty($forPdf) ? 'resume-pdf-main' : '' }}"
                  @if(empty($forPdf)) :class="[atsMode ? 'max-w-[800px] mx-auto p-10' : spacingClasses.main + ' p-10']" @endif>

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

                @if(empty($forPdf) && !empty($resume['skills']['technical']))
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
</body>
</html>

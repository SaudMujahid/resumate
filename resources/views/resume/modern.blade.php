<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume['name'] }} - Resume</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f9f9f9; padding: 40px; }
        .resume { max-width: 800px; margin: auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .name { font-size: 36px; font-weight: 700; color: #1a1a1a; }
        .contact { color: #555; font-size: 14px; }
        .section-title { font-weight: 700; font-size: 18px; color: #6A6CFF; border-bottom: 2px solid #6A6CFF; padding-bottom: 5px; margin: 25px 0 15px; }
        .job, .edu { margin-bottom: 20px; }
        .job-title { font-weight: 600; font-size: 16px; }
        .company { color: #555; font-size: 14px; }
        ul { padding-left: 20px; }
        li { margin: 5px 0; font-size: 14px; }
        .skills-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .skill-tag { background: #6A6CFF; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; text-align: center; }
    </style>
</head>
<body>
<div class="resume">
    <div class="header">
        <div class="name">{{ $resume['name'] ?? 'Your Name' }}</div>
        <div class="contact">
            {{ $resume['email'] ?? '' }} | {{ $resume['phone'] ?? '' }} | {{ $resume['city'] ?? '' }}
        </div>
    </div>

    @if(!empty($resume['summary']))
    <p style="font-style: italic; color: #444;">{{ $resume['summary'] }}</p>
    @endif

    <div class="section-title">Experience</div>
    @foreach($resume['experience'] ?? [] as $exp)
    <div class="job">
        <div class="job-title">{{ $exp['title'] }}</div>
        <div class="company">{{ $exp['company'] }} <em>({{ $exp['duration'] }})</em></div>
        <ul>
            @foreach($exp['responsibilities'] ?? [] as $resp)
            <li>{{ $resp }}</li>
            @endforeach
        </ul>
    </div>
    @endforeach

    <div class="section-title">Education</div>
    @foreach($resume['education'] ?? [] as $edu)
    <div class="edu">
        <div><strong>{{ $edu['degree'] }}</strong> in {{ $edu['major'] ?? 'N/A' }}</div>
        <div>{{ $edu['school'] }} ({{ $edu['year'] ?? 'N/A' }})</div>
    </div>
    @endforeach

    <div class="section-title">Skills</div>
    <div class="skills-grid">
        @foreach(array_merge($resume['skills']['technical'] ?? [], $resume['skills']['soft'] ?? [], $resume['skills']['languages'] ?? []) as $skill)
        <div class="skill-tag">{{ $skill }}</div>
        @endforeach
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <a href="{{ url('/resume/download-pdf') }}" class="inline-block px-6 py-3 bg-[#6A6CFF] text-white rounded-lg hover:bg-[#5555FF]">
            Download PDF
        </a>
    </div>
</div>
</body>
</html>

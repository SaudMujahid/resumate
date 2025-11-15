<!-- Modern Responsive Editable Resume Template (Blade Compatible) -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume['name'] ?? 'Resume' }}</title>

    @vite(['resources/css/app.css'])

    <!-- Google Fonts cannot be used for pdf -->

    <!-- QuillJS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        body { background: #F9FAFB; font-family: 'DejaVu Sans', sans-serif; padding: 20px; }
        .resume-container { max-width: 900px; margin: auto; background: white; padding: 20px !important ; border-radius: 12px; box-shadow: none !important }

        /* Header */
        .header-box { background: rgba(255,198,106,0.75); padding: 40px 20px; border-radius: 12px; text-align: center; }
        .header-name { font-size: 40px; font-family: 'Poppins'; font-weight: 700; color: #222; }
        .header-profession { font-size: 22px; font-family: 'Inter'; font-weight: 600; color: #222; margin-top: 8px; }
        .header-summary { margin-top: 20px; font-size: 16px; color: #333; }

        /* Section Titles */
        .section-title { font-size: 22px; font-family: 'Inter'; font-weight: 700; color: #E5864B; margin-top: 40px; margin-bottom: 16px; }

        /* Two Column Layout */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }

        /* Experience */
        .job-title { font-weight: 700; font-size: 20px; color: #4B3B00; }
        .company { font-size: 16px; font-weight: 600; color: #4B3B00; margin-bottom: 8px; }
        .job-list li { margin-left: 20px; margin-bottom: 6px; font-size: 14px; }

        /* Education */
        .edu-entry { font-size: 18px; color: #4B3B00; margin-bottom: 12px; font-weight: 700; }

        /* Skills */
        .skill-item { font-size: 18px; font-weight: 700; color: #4B3B00; margin-bottom: 8px; display: flex; align-items: center; }
        .skill-dot { width: 9px; height: 9px; background: #4B3B00; border-radius: 50%; margin-right: 10px; }

        /* Buttons */
        .bottom-buttons { margin-top: 40px; display: flex; justify-content: center; gap: 20px; }
        .btn { padding: 12px 24px; background: #6A6CFF; color: #fff; border-radius: 8px; font-weight: 600; text-decoration: none; }
        .btn:hover { background: #5555FF; }

        section, div, .header-box { page-break-inside: avoid !important;}

        @media(max-width: 768px) {.two-col { grid-template-columns: 1fr; } }
        @media print { .bottom-buttons { display: none !important;} }
    </style>
</head>
<body>
    <div class="resume-container">

        <!-- HEADER AREA -->
        <div class="header-box">
            <div class="header-name" id="name">{{ $resume['name'] ?? 'Your Name' }}</div>
            <div class="header-profession" id="profession">{{ $resume['profession'] ?? 'Your Profession' }}</div>

            <div class="header-summary" id="summary">
                {{ $resume['summary'] ?? 'Write a short description about yourself.' }}
            </div>
        </div>

        <!-- MAIN SECTIONS -->
        <div class="two-col">

            <!-- LEFT COLUMN -->
            <div>
                <div class="section-title">WORK EXPERIENCE</div>
                @foreach($resume['experience'] ?? [] as $exp)
                    <div class="job-title">{{ $exp['title'] }}</div>
                    <div class="company">{{ $exp['company'] }} ({{ $exp['duration'] }})</div>
                    <ul class="job-list">
                        @foreach($exp['responsibilities'] ?? [] as $r)
                            <li>{{ $r }}</li>
                        @endforeach
                    </ul>
                @endforeach

                <div class="section-title">EDUCATION</div>
                @foreach($resume['education'] ?? [] as $edu)
                    <div class="edu-entry">
                        {{ $edu['degree'] }} — {{ $edu['school'] }} ({{ $edu['year'] }})<br>
                        <span style="font-size:14px; font-weight:400;">Major: {{ $edu['major'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <div class="section-title">CONTACT</div>
                <p style="font-size:18px; color:#4B3B00; font-weight:700;">
                    {{ $resume['phone'] }}<br>
                    {{ $resume['email'] }}<br>
                    {{ $resume['city'] }}
                </p>

                <div class="section-title">SKILLS</div>
                @foreach(array_merge($resume['skills']['technical'] ?? [], $resume['skills']['soft'] ?? [], $resume['skills']['languages'] ?? []) as $skill)
                <div class="skill-item"><span class="skill-dot"></span>{{ $skill }}</div>
                @endforeach
            </div>
        </div>

        <!-- BOTTOM BUTTONS -->
        <div class="bottom-buttons">
            <a href="{{ url('/resume/download-pdf') }}" class="btn">Download PDF</a>
            <a href="{{ url('/') }}" class="btn" style="background:#999;">Home</a>
        </div>

        <!-- Editable Areas Script (Quill.js) -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            // Add future editing functionality here if needed.
        </script>

    </div>
</body>
</html>


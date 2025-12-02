<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume - Chronological</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #f5f5f5;
            font-family: 'Poppins', sans-serif;
            padding: 15px;
            font-size: 10pt;
            line-height: 1.4;
        }
        .resume-wrapper {
            max-width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
            display: flex;
            overflow: hidden;
            position: relative;
            page-break-after: avoid;
        }
        .sidebar {
            width: 35%;
            background: #2c7a7b;
            color: white;
            padding: 30px 22px;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .main-content {
            width: 65%;
            padding: 30px 28px;
            background: white;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Editable Fields */
        [contenteditable="true"] {
            outline: none;
            position: relative;
        }
        [contenteditable="true"]:hover {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 3px;
            padding: 2px 4px;
            margin: -2px -4px;
        }
        [contenteditable="true"]:focus {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 3px;
            padding: 2px 4px;
            margin: -2px -4px;
        }
        .main-content [contenteditable="true"]:hover {
            background: rgba(44, 122, 123, 0.08);
        }
        .main-content [contenteditable="true"]:focus {
            background: rgba(44, 122, 123, 0.15);
        }

        /* Profile Image */
        .profile-image-container {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 16px;
            border: 3px solid rgba(255,255,255,0.3);
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
        }
        .profile-image-container:hover::after {
            content: 'Change Photo';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 10px;
            white-space: nowrap;
        }
        .profile-image { width: 100%; height: 100%; object-fit: cover; }
        .profile-placeholder {
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        .profile-name {
            font-size: 20pt;
            font-weight: 700;
            margin: 8px 0 3px;
            color: white;
            text-align: center;
            word-break: break-word;
            line-height: 1.2;
        }
        .profile-title {
            font-size: 11pt;
            font-weight: 600;
            color: #e6f7f7;
            text-align: center;
            margin-bottom: 18px;
            line-height: 1.3;
        }

        .section-title {
            font-size: 12pt;
            font-weight: 700;
            color: white;
            margin: 16px 0 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
        .contact-item {
            margin-bottom: 6px;
            font-size: 9pt;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            word-break: break-word;
            line-height: 1.3;
        }
        .contact-item strong { flex-shrink: 0; }
        .skill-item {
            margin-bottom: 5px;
            font-size: 9pt;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.3;
        }
        .skill-dot {
            width: 5px;
            height: 5px;
            background: white;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 3px;
        }

        /* Main Content */
        .main-title {
            font-size: 14pt;
            font-weight: 700;
            color: #1a1a1a;
            margin: 14px 0 10px 0;
            border-bottom: 2px solid #2c7a7b;
            padding-bottom: 4px;
            page-break-after: avoid;
        }
        .summary {
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            margin-bottom: 12px;
            page-break-after: avoid;
        }
        .experience-entry, .education-entry {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        .entry-title {
            font-size: 11pt;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
        }
        .entry-subtitle {
            font-size: 9.5pt;
            color: #2c7a7b;
            font-weight: 600;
            margin: 2px 0 3px;
            line-height: 1.3;
        }
        .entry-meta {
            font-size: 9pt;
            color: #666;
            margin-bottom: 3px;
            line-height: 1.3;
        }
        .entry-bullets {
            font-size: 9pt;
            color: #444;
            padding-left: 16px;
            list-style: disc;
            margin: 3px 0 0 0;
            line-height: 1.35;
        }
        .entry-bullets li {
            margin-bottom: 2px;
        }

        /* Two-column skills layout */
        .skills-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .skill-column { display: flex; flex-direction: column; gap: 5px; }
        .skill-column-title {
            font-size: 8.5pt;
            font-weight: 700;
            color: rgba(255,255,255,0.7);
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Color Variants */
        .sidebar.teal { background: #2c7a7b; }
        .sidebar.blue { background: #4B7BE5; }
        .sidebar.green { background: #4CAF50; }
        .sidebar.purple { background: #9C27B0; }
        .sidebar.orange { background: #FF9800; }
        .sidebar.red { background: #F44336; }
        .sidebar.gray { background: #607D8B; }
        .sidebar.navy { background: #1A237E; }

        .main-title.blue { border-bottom-color: #4B7BE5; }
        .entry-subtitle.blue { color: #4B7BE5; }
        .sidebar.blue .entry-subtitle { color: #2c7a7b; }
        .main-title.green { border-bottom-color: #4CAF50; }
        .entry-subtitle.green { color: #4CAF50; }
        .main-title.purple { border-bottom-color: #9C27B0; }
        .entry-subtitle.purple { color: #9C27B0; }
        .main-title.orange { border-bottom-color: #FF9800; }
        .entry-subtitle.orange { color: #FF9800; }
        .main-title.red { border-bottom-color: #F44336; }
        .entry-subtitle.red { color: #F44336; }
        .main-title.gray { border-bottom-color: #607D8B; }
        .entry-subtitle.gray { color: #607D8B; }
        .main-title.navy { border-bottom-color: #1A237E; }
        .entry-subtitle.navy { color: #1A237E; }

        /* Print & PDF Fix */
        @media print {
            body, html { margin: 0 !important; padding: 0 !important; }
            .resume-wrapper { box-shadow: none !important; margin: 0 !important; height: 297mm !important; }
            .no-print { display: none !important; }
            .sidebar, .main-content { overflow: visible !important; }
            [contenteditable] { background: transparent !important; outline: none !important; }
        }

        /* Control Bar */
        .control-bar {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 18px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            z-index: 1000;
            width: 240px;
        }
        .control-label {
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 12px;
            color: #333;
        }
        .color-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 16px;
        }
        .color-btn {
            width: 100%;
            aspect-ratio: 1;
            border: 3px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, border-color 0.2s;
        }
        .color-btn:hover {
            transform: scale(1.05);
        }
        .color-btn.active {
            border-color: #333;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #333;
        }
        .btn-primary {
            background: #2c7a7b;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            margin-bottom: 8px;
            transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }
        .btn-secondary {
            background: #666;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            display: block;
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn-secondary:hover { opacity: 0.9; }
        .hint {
            font-size: 11px;
            color: #666;
            font-style: italic;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

<input type="file" id="imageUpload" accept="image/*" style="display:none;">

<div class="resume-wrapper" id="resumeContent">
    <!-- LEFT SIDEBAR -->
    <div class="sidebar teal" id="sidebar">
        <div class="profile-image-container" onclick="document.getElementById('imageUpload').click()">
            <div class="profile-placeholder" id="profilePlaceholder">👤</div>
            <img class="profile-image" id="profileImage" style="display:none;" alt="Profile">
        </div>

        <div class="profile-name" contenteditable="true">{{ $resume['name'] ?? 'Your Name' }}</div>
        <div class="profile-title" contenteditable="true">{{ $resume['experience'][0]['title'] ?? 'Professional Title' }}</div>

        <div class="section-title">CONTACT</div>
        <div class="contact-item"><strong>📱</strong><span contenteditable="true">{{ $resume['phone'] ?? 'Not provided' }}</span></div>
        <div class="contact-item"><strong>✉️</strong><span contenteditable="true">{{ $resume['email'] ?? 'Not provided' }}</span></div>
        <div class="contact-item"><strong>📍</strong><span contenteditable="true">{{ $resume['city'] ?? 'Bangladesh' }}</span></div>

        <div class="section-title">SKILLS</div>
        <div class="skills-container">
            <div class="skill-column">
                <div class="skill-column-title">Technical</div>
                @if(!empty($resume['skills']['technical']))
                    @foreach($resume['skills']['technical'] as $skill)
                        <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">{{ trim($skill) }}</span></div>
                    @endforeach
                @else
                    <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">Add skills</span></div>
                @endif
            </div>
            <div class="skill-column">
                <div class="skill-column-title">Soft Skills</div>
                @if(!empty($resume['skills']['soft']))
                    @foreach($resume['skills']['soft'] as $skill)
                        <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">{{ trim($skill) }}</span></div>
                    @endforeach
                @else
                    <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">Add soft skills</span></div>
                @endif
            </div>
        </div>

        <div style="margin-top: 12px;">
            <div class="skill-column-title">Languages</div>
            @if(!empty($resume['skills']['languages']))
                @foreach($resume['skills']['languages'] as $skill)
                    <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">{{ trim($skill) }}</span></div>
                @endforeach
            @else
                <div class="skill-item"><span class="skill-dot"></span><span contenteditable="true">Add languages</span></div>
            @endif
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="main-title">Professional Summary</div>
        <div class="summary" contenteditable="true">{{ $resume['summary'] ?? 'Dedicated professional with strong technical and communication skills. Ready to contribute expertise to innovative projects.' }}</div>

        <div class="main-title">Experience</div>
        @if(!empty($resume['experience']))
            @foreach($resume['experience'] as $exp)
                <div class="experience-entry">
                    <div class="entry-title" contenteditable="true">{{ $exp['title'] ?? 'Role' }}</div>
                    <div class="entry-subtitle" contenteditable="true">
                        {{ $exp['company'] ?? '' }}
                        @if(!empty($exp['duration'])) • {{ $exp['duration'] }} @endif
                    </div>
                    @if(!empty($exp['responsibilities']))
                        <ul class="entry-bullets">
                            @foreach($exp['responsibilities'] as $bullet)
                                <li contenteditable="true">{{ trim($bullet) }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endforeach
        @else
            <div class="experience-entry">
                <div class="entry-title" contenteditable="true">Aspiring Developer</div>
                <div class="entry-subtitle" contenteditable="true">Personal Projects & Freelance • 2025 – Present</div>
                <ul class="entry-bullets">
                    <li contenteditable="true">Actively building real-world applications</li>
                    <li contenteditable="true">Continuously learning modern technologies</li>
                    <li contenteditable="true">Ready to contribute professionally</li>
                </ul>
            </div>
        @endif

        <div class="main-title">Education</div>
        @if(!empty($resume['education']))
            @foreach($resume['education'] as $edu)
                <div class="education-entry">
                    @if(isset($edu['degree']) && !empty($edu['degree']))
                        <div class="entry-title" contenteditable="true">
                            {{ $edu['degree'] }}
                            @if(!empty($edu['major'])) in {{ $edu['major'] }} @endif
                        </div>
                        <div class="entry-subtitle" contenteditable="true">
                            {{ $edu['school'] ?? '' }}
                            @if(!empty($edu['cgpa'])) • CGPA: {{ $edu['cgpa'] }} @endif
                        </div>
                        <div class="entry-meta" contenteditable="true">{{ $edu['year'] ?? '' }}</div>
                    @else
                        <div class="entry-title" contenteditable="true">{{ $edu['level'] ?? 'Education' }}</div>
                        <div class="entry-subtitle" contenteditable="true">
                            {{ $edu['school'] ?? '' }}
                            @if(!empty($edu['grade'])) • {{ $edu['grade'] }} @endif
                        </div>
                        <div class="entry-meta" contenteditable="true">{{ $edu['year'] ?? '' }}</div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="education-entry">
                <div class="entry-title" contenteditable="true">Bachelor's Degree (In Progress)</div>
                <div class="entry-subtitle" contenteditable="true">University Name</div>
            </div>
        @endif
    </div>
</div>

<!-- Control Bar -->
<div class="control-bar no-print">
    <div class="control-label">Sidebar Color</div>
    <div class="color-grid">
        <button class="color-btn active" data-color="teal" style="background:#2c7a7b;" title="Teal"></button>
        <button class="color-btn" data-color="blue" style="background:#4B7BE5;" title="Blue"></button>
        <button class="color-btn" data-color="green" style="background:#4CAF50;" title="Green"></button>
        <button class="color-btn" data-color="purple" style="background:#9C27B0;" title="Purple"></button>
        <button class="color-btn" data-color="orange" style="background:#FF9800;" title="Orange"></button>
        <button class="color-btn" data-color="red" style="background:#F44336;" title="Red"></button>
        <button class="color-btn" data-color="gray" style="background:#607D8B;" title="Gray"></button>
        <button class="color-btn" data-color="navy" style="background:#1A237E;" title="Navy"></button>
    </div>

    <button class="btn-primary" onclick="downloadPDF()">Download PDF</button>
    <button class="btn-secondary" onclick="location.href='/'">Home</button>

    <div class="hint">💡 <strong>Tip:</strong> Click any text to edit it. Changes are auto-saved!</div>
</div>

<script>
    // Restore saved color
    window.addEventListener('load', () => {
        const savedColor = sessionStorage.getItem('sidebarColor') || 'teal';
        applyColor(savedColor);

        const savedImage = sessionStorage.getItem('profileImage');
        if (savedImage) {
            document.getElementById('profileImage').src = savedImage;
            document.getElementById('profileImage').style.display = 'block';
            document.getElementById('profilePlaceholder').style.display = 'none';
        }
    });

    function applyColor(color) {
        const sidebar = document.getElementById('sidebar');
        sidebar.className = 'sidebar ' + color;

        document.querySelectorAll('.main-title').forEach(el => {
            el.className = 'main-title ' + (color !== 'teal' ? color : '');
        });
        document.querySelectorAll('.entry-subtitle').forEach(el => {
            el.className = 'entry-subtitle ' + (color !== 'teal' ? color : '');
        });

        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.color === color);
        });

        sessionStorage.setItem('sidebarColor', color);
    }

    // Color changer
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            applyColor(this.dataset.color);
        });
    });

    // Image upload
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('profileImage').src = ev.target.result;
                document.getElementById('profileImage').style.display = 'block';
                document.getElementById('profilePlaceholder').style.display = 'none';
                sessionStorage.setItem('profileImage', ev.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // PDF Download with proper margins
    function downloadPDF() {
        const element = document.getElementById('resumeContent');
        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'resume.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#ffffff',
                windowWidth: 794,
                windowHeight: 1123
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

</body>
</html>

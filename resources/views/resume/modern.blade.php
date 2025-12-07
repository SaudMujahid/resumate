<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F9FAFB;
            padding: 15px;
            min-height: 100vh;
        }

        .container {
            max-width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .resume-container {
            width: 100%;
            height: 100%;
            padding: 30px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Header */
        .header-box {
            padding: 25px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .header-box.orange { background: rgba(255, 198, 106, 0.75); }
        .header-box.blue { background: rgba(75, 123, 229, 0.99); }
        .header-box.green { background: rgba(76, 175, 80, 0.75); }
        .header-box.red { background: rgba(244, 67, 54, 0.75); }
        .header-box.purple { background: rgba(156, 39, 176, 0.75); }
        .header-box.amber { background: rgba(255, 152, 0, 0.75); }
        .header-box.teal { background: rgba(0, 150, 136, 0.75); }
        .header-box.gray { background: rgba(96, 125, 139, 0.75); }

        .profile-image-container {
            width: 100px;
            height: 100px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            border: 3px solid rgba(255, 255, 255, 0.4);
            cursor: pointer;
            position: relative;
        }

        .profile-image-container:hover::after {
            content: 'Change Photo';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 10px;
            white-space: nowrap;
        }

        .profile-image { width: 100%; height: 100%; object-fit: cover; }
        .profile-placeholder {
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
        }

        .header-content {
            flex: 1;
        }

        .header-name {
            font-size: 32px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #222;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
            line-height: 1.2;
        }

        .header-name:hover, .header-profession:hover, .header-summary:hover,
        .job-title:hover, .company:hover, .edu-entry:hover, .contact-info:hover,
        .skill-item:hover, [contenteditable="true"]:hover {
            background-color: rgba(0, 0, 0, 0.08);
        }

        .header-name:focus, .header-profession:focus, .header-summary:focus,
        .job-title:focus, .company:focus, .edu-entry:focus, .contact-info:focus,
        .skill-item:focus, [contenteditable="true"]:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .header-profession {
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #222;
            margin-top: 6px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .header-summary {
            margin-top: 12px;
            font-size: 13px;
            color: #333;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
            line-height: 1.4;
        }

        /* Section Titles */
        .section-title {
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #E5864B;
            margin-top: 16px;
            margin-bottom: 12px;
            page-break-after: avoid;
            border-bottom: 2px solid #E5864B;
            padding-bottom: 6px;
        }

        /* Two Column Layout */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            flex: 1;
        }

        /* Experience */
        .job-entry {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .job-title {
            font-weight: 700;
            font-size: 14px;
            color: #4B3B00;
            margin-bottom: 2px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .company {
            font-size: 12px;
            font-weight: 600;
            color: #4B3B00;
            margin-bottom: 6px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .job-list {
            margin-bottom: 10px;
            padding-left: 0;
        }

        .job-list li {
            margin-left: 16px;
            margin-bottom: 3px;
            font-size: 12px;
            color: #333;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
            list-style: disc;
        }

        /* Education */
        .edu-entry {
            font-size: 14px;
            color: #4B3B00;
            margin-bottom: 8px;
            font-weight: 700;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
            page-break-inside: avoid;
        }

        .edu-major {
            font-size: 12px;
            font-weight: 400;
            color: #333;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
            margin-bottom: 4px;
        }

        /* Contact */
        .contact-info {
            font-size: 12px;
            color: #333;
            margin-bottom: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
            line-height: 1.5;
        }

        .contact-label {
            font-weight: 600;
            color: #4B3B00;
        }

        /* Skills */
        .skill-item {
            font-size: 13px;
            font-weight: 600;
            color: #4B3B00;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .skill-dot {
            width: 7px;
            height: 7px;
            background: #4B3B00;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .skill-text {
            flex: 1;
        }

        /* Control Bar */
        .control-bar {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 240px;
            padding: 18px;
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
            background: #6A6CFF;
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
        /* fix cropping */
    @page {
        margin: 0;
        size: A4;
    }

    body {
        margin: 0;
        padding: 15px; /* This becomes your "page padding" */
    }

    .container {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        padding: 0;
        box-shadow: none !important;
    }
        /* Print Styles */
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .container { box-shadow: none; margin: 0; height: auto; }
            .resume-container { padding: 30px; overflow: visible; }
            .control-bar { display: none !important; }
            section, div, .header-box { page-break-inside: avoid !important; }
            [contenteditable] { background: transparent !important; outline: none !important; }
        }

        /* No overflow */
        [contenteditable="true"] { outline: none; }
    </style>
</head>
<body>

<input type="file" id="imageUpload" accept="image/*" style="display:none;">

<div class="container">
    <div class="resume-container" id="resumeContent">
        <!-- HEADER AREA -->
        <div class="header-box orange" id="headerBox">
            <div class="profile-image-container" onclick="document.getElementById('imageUpload').click()">
                <div class="profile-placeholder" id="profilePlaceholder">👤</div>
                <img class="profile-image" id="profileImage" style="display:none;" alt="Profile">
            </div>

            <div class="header-content">
                <div class="header-name" contenteditable="true">{{ $resume['name'] ?? 'Your Name' }}</div>
                <div class="header-profession" contenteditable="true">{{ $resume['experience'][0]['title'] ?? 'Professional Title' }}</div>
                <div class="header-summary" contenteditable="true">{{ $resume['summary'] ?? 'Dedicated professional with strong skills.' }}</div>
            </div>
        </div>

        <!-- MAIN SECTIONS -->
        <div class="two-col">
            <!-- LEFT COLUMN -->
            <div>
                <div class="section-title">WORK EXPERIENCE</div>
                @if(!empty($resume['experience']))
                    @foreach($resume['experience'] as $exp)
                        <div class="job-entry">
                            <div class="job-title" contenteditable="true">{{ $exp['title'] ?? 'Position' }}</div>
                            <div class="company" contenteditable="true">{{ $exp['company'] ?? 'Company' }}@if(!empty($exp['duration'])) • {{ $exp['duration'] }}@endif</div>
                            @if(!empty($exp['responsibilities']))
                                <ul class="job-list">
                                    @foreach($exp['responsibilities'] as $bullet)
                                        <li contenteditable="true">{{ trim($bullet) }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="job-entry">
                        <div class="job-title" contenteditable="true">Position</div>
                        <div class="company" contenteditable="true">Company Name</div>
                        <ul class="job-list">
                            <li contenteditable="true">Add your responsibilities</li>
                        </ul>
                    </div>
                @endif

                <div class="section-title">EDUCATION</div>
                @if(!empty($resume['education']))
                    @foreach($resume['education'] as $edu)
                        <div class="edu-entry">
                            @if(isset($edu['degree']) && !empty($edu['degree']))
                                <span contenteditable="true">{{ $edu['degree'] }}</span>
                            @else
                                <span contenteditable="true">{{ $edu['level'] ?? 'Education' }}</span>
                            @endif
                        </div>
                        <div class="edu-major" contenteditable="true">
                            {{ $edu['school'] ?? '' }}
                            @if(!empty($edu['year'])) • {{ $edu['year'] }} @endif
                            @if(!empty($edu['cgpa'])) • GPA: {{ $edu['cgpa'] }} @endif
                        </div>
                    @endforeach
                @else
                    <div class="edu-entry" contenteditable="true">Bachelor's Degree</div>
                    <div class="edu-major" contenteditable="true">University Name</div>
                @endif
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <div class="section-title">CONTACT</div>
                <div class="contact-info">
                    <div><span class="contact-label">📱 Phone:</span><br><span contenteditable="true">{{ $resume['phone'] ?? 'Not provided' }}</span></div>
                    <div style="margin-top: 6px;"><span class="contact-label">✉️ Email:</span><br><span contenteditable="true">{{ $resume['email'] ?? 'Not provided' }}</span></div>
                    <div style="margin-top: 6px;"><span class="contact-label">📍 Location:</span><br><span contenteditable="true">{{ $resume['city'] ?? 'Bangladesh' }}</span></div>
                </div>

                <div class="section-title">TECHNICAL SKILLS</div>
                <div id="technicalSkills">
                    @if(!empty($resume['skills']['technical']))
                        @foreach($resume['skills']['technical'] as $skill)
                            <div class="skill-item">
                                <span class="skill-dot"></span>
                                <span class="skill-text" contenteditable="true">{{ trim($skill) }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <span class="skill-dot"></span>
                            <span class="skill-text" contenteditable="true">Add technical skills</span>
                        </div>
                    @endif
                </div>

                <div class="section-title">SOFT SKILLS</div>
                <div id="softSkills">
                    @if(!empty($resume['skills']['soft']))
                        @foreach($resume['skills']['soft'] as $skill)
                            <div class="skill-item">
                                <span class="skill-dot"></span>
                                <span class="skill-text" contenteditable="true">{{ trim($skill) }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <span class="skill-dot"></span>
                            <span class="skill-text" contenteditable="true">Add soft skills</span>
                        </div>
                    @endif
                </div>

                <div class="section-title">LANGUAGES</div>
                <div id="languages">
                    @if(!empty($resume['skills']['languages']))
                        @foreach($resume['skills']['languages'] as $lang)
                            <div class="skill-item">
                                <span class="skill-dot"></span>
                                <span class="skill-text" contenteditable="true">{{ trim($lang) }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <span class="skill-dot"></span>
                            <span class="skill-text" contenteditable="true">Add languages</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Control Bar -->
<div class="control-bar no-print">
    <div class="control-label">Header Color</div>
    <div class="color-grid">
        <button class="color-btn" data-color="blue" style="background:#4B7BE5;" title="Blue"></button>
        <button class="color-btn active" data-color="orange" style="background:rgba(255, 198, 106, 0.75);" title="Orange"></button>
        <button class="color-btn" data-color="green" style="background:#4CAF50;" title="Green"></button>
        <button class="color-btn" data-color="red" style="background:#F44336;" title="Red"></button>
        <button class="color-btn" data-color="purple" style="background:#9C27B0;" title="Purple"></button>
        <button class="color-btn" data-color="amber" style="background:#FF9800;" title="Amber"></button>
        <button class="color-btn" data-color="teal" style="background:#009688;" title="Teal"></button>
        <button class="color-btn" data-color="gray" style="background:#607D8B;" title="Gray"></button>
    </div>

    <button class="btn-primary" onclick="downloadPDF()">Download PDF</button>
    <button class="btn-secondary" onclick="location.href='/'">Home</button>

    <div class="hint">💡 <strong>Tip:</strong> Click any text to edit it. Changes are auto-saved!</div>
</div>

<script>
    // Restore saved color
    window.addEventListener('load', () => {
        const savedColor = sessionStorage.getItem('resumeColor') || 'orange';
        applyColor(savedColor);

        const savedImage = sessionStorage.getItem('resumeProfileImage');
        if (savedImage) {
            document.getElementById('profileImage').src = savedImage;
            document.getElementById('profileImage').style.display = 'block';
            document.getElementById('profilePlaceholder').style.display = 'none';
        }
    });

    function applyColor(color) {
        const header = document.getElementById('headerBox');
        header.className = 'header-box ' + color;

        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.color === color);
        });

        sessionStorage.setItem('resumeColor', color);
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
                sessionStorage.setItem('resumeProfileImage', ev.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // PDF Download with no cropping
    function downloadPDF() {
        const element = document.getElementById('resumeContent');
        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'modern-resume.pdf',
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

    // Prevent Enter key from creating new lines
    document.querySelectorAll('[contenteditable="true"]').forEach(el => {
        el.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey && el.tagName !== 'LI') {
                e.preventDefault();
            }
        });
    });
</script>

</body>
</html>

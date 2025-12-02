<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            padding: 15px;
            min-height: 100vh;
        }

        .container {
            max-width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .resume-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .header-section {
            position: relative;
            width: 100%;
            padding: 35px 40px;
            display: flex;
            align-items: center;
            z-index: 1;
            transition: background-color 0.3s ease;
            flex-shrink: 0;
            page-break-inside: avoid;
        }

        .header-section.orange {
            background: rgba(255, 198, 106, 0.75);
        }

        .header-section.blue {
            background: rgba(75, 123, 229, 0.99);
        }

        .header-section.green {
            background: rgba(76, 175, 80, 0.75);
        }

        .header-section.red {
            background: rgba(244, 67, 54, 0.75);
        }

        .header-section.purple {
            background: rgba(156, 39, 176, 0.75);
        }

        .header-section.amber {
            background: rgba(255, 152, 0, 0.75);
        }

        .header-section.teal {
            background: rgba(0, 150, 136, 0.75);
        }

        .header-section.gray {
            background: rgba(96, 125, 139, 0.75);
        }

        .profile-image-container {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            border: 3px solid rgba(255, 255, 255, 0.4);
            cursor: pointer;
            position: relative;
            margin-right: 20px;
        }

        .profile-image-container:hover::after {
            content: 'Change';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.7);
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
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }

        .header-name {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 38px;
            line-height: 1.2;
            color: #ffffff;
            word-break: break-word;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .header-name:hover {
            background-color: rgba(0, 0, 0, 0.15);
        }

        .header-name:focus {
            outline: none;
            background-color: rgba(0, 0, 0, 0.25);
            box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.4);
        }

        .content-box {
            position: relative;
            width: 100%;
            padding: 30px 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .left-column {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .section {
            display: flex;
            flex-direction: column;
            gap: 12px;
            page-break-inside: avoid;
        }

        .section-title {
            font-family: 'Poppins';
            font-weight: 600;
            font-size: 16px;
            line-height: 1.3;
            color: rgba(75, 123, 229, 0.99);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(75, 123, 229, 0.99);
            padding-bottom: 6px;
        }

        .job-entry {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .job-title {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 14px;
            line-height: 1.3;
            color: #333333;
            cursor: text;
            padding: 3px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .job-title:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .job-title:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .company-info {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 12px;
            line-height: 1.4;
            color: #666666;
            cursor: text;
            padding: 3px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .company-info:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .company-info:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .job-description {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 11px;
            line-height: 1.4;
            color: #555;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
            margin-left: 10px;
        }

        .job-description:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .job-description:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .contact-item {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 12px;
            line-height: 1.5;
            color: #333333;
            cursor: text;
            padding: 3px;
            border-radius: 4px;
            transition: background-color 0.2s;
            word-break: break-word;
        }

        .contact-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .contact-item:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .contact-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .skill-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 8px;
        }

        .skill-dot {
            width: 6px;
            height: 6px;
            background: #1e1e1e;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .skill-text {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 12px;
            line-height: 1.4;
            color: #333333;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
            flex: 1;
        }

        .skill-text:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .skill-text:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .edu-entry {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .edu-degree {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 13px;
            line-height: 1.3;
            color: #333333;
            cursor: text;
            padding: 3px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edu-degree:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .edu-degree:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .edu-details {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 11px;
            line-height: 1.4;
            color: #666666;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edu-details:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .edu-details:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
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
            padding: 18px;
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

        /* Print Styles */
        @media print {
            body { background: white; padding: 0; margin: 0; }
            .container { box-shadow: none; margin: 0; height: auto; }
            .resume-wrapper { overflow: visible; }
            .control-bar { display: none !important; }
            .header-section, .content-box { page-break-inside: avoid !important; }
            [contenteditable] { background: transparent !important; outline: none !important; }
        }
    </style>
</head>
<body>

<input type="file" id="imageUpload" accept="image/*" style="display:none;">

<div class="container">
    <div class="resume-wrapper" id="resumeContent">
        <!-- HEADER SECTION -->
        <div class="header-section blue" id="headerSection">
            <div class="profile-image-container" onclick="document.getElementById('imageUpload').click()">
                <div class="profile-placeholder" id="profilePlaceholder">👤</div>
                <img class="profile-image" id="profileImage" style="display:none;" alt="Profile">
            </div>
            <div class="header-name" contenteditable="true">{{ $resume['name'] ?? 'Your Name' }}</div>
        </div>

        <!-- CONTENT BOX -->
        <div class="content-box">
            <!-- LEFT COLUMN -->
            <div class="left-column">
                <!-- Work Experience -->
                <div class="section">
                    <div class="section-title">WORK EXPERIENCE</div>
                    @if(!empty($resume['experience']))
                        @foreach($resume['experience'] as $exp)
                            <div class="job-entry">
                                <div class="job-title" contenteditable="true">{{ $exp['title'] ?? 'Position' }}</div>
                                <div class="company-info" contenteditable="true">{{ $exp['company'] ?? 'Company' }}@if(!empty($exp['duration'])) • {{ $exp['duration'] }}@endif</div>
                                @if(!empty($exp['responsibilities']))
                                    @foreach($exp['responsibilities'] as $bullet)
                                        <div class="job-description" contenteditable="true">• {{ trim($bullet) }}</div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="job-entry">
                            <div class="job-title" contenteditable="true">Position Title</div>
                            <div class="company-info" contenteditable="true">Company Name • Duration</div>
                        </div>
                    @endif
                </div>

                <!-- Technical Skills -->
                <div class="section">
                    <div class="section-title">TECHNICAL SKILLS</div>
                    @if(!empty($resume['skills']['technical']))
                        @foreach($resume['skills']['technical'] as $skill)
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text" contenteditable="true">{{ trim($skill) }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <div class="skill-dot"></div>
                            <div class="skill-text" contenteditable="true">Add technical skills</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="right-column">
                <!-- Contact -->
                <div class="section">
                    <div class="section-title">CONTACT</div>
                    <div class="contact-label">📱 Phone</div>
                    <div class="contact-item" contenteditable="true">{{ $resume['phone'] ?? 'Not provided' }}</div>
                    <div class="contact-label" style="margin-top: 8px;">✉️ Email</div>
                    <div class="contact-item" contenteditable="true">{{ $resume['email'] ?? 'Not provided' }}</div>
                    <div class="contact-label" style="margin-top: 8px;">📍 Location</div>
                    <div class="contact-item" contenteditable="true">{{ $resume['city'] ?? 'Bangladesh' }}</div>
                </div>

                <!-- Education -->
                <div class="section">
                    <div class="section-title">EDUCATION</div>
                    @if(!empty($resume['education']))
                        @foreach($resume['education'] as $edu)
                            <div class="edu-entry">
                                @if(isset($edu['degree']) && !empty($edu['degree']))
                                    <div class="edu-degree" contenteditable="true">{{ $edu['degree'] }}</div>
                                @else
                                    <div class="edu-degree" contenteditable="true">{{ $edu['level'] ?? 'Education' }}</div>
                                @endif
                                <div class="edu-details" contenteditable="true">
                                    {{ $edu['school'] ?? '' }}
                                    @if(!empty($edu['year'])) • {{ $edu['year'] }} @endif
                                    @if(!empty($edu['cgpa'])) • GPA: {{ $edu['cgpa'] }} @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="edu-entry">
                            <div class="edu-degree" contenteditable="true">Bachelor's Degree</div>
                            <div class="edu-details" contenteditable="true">University Name • Year</div>
                        </div>
                    @endif
                </div>

                <!-- Soft Skills -->
                <div class="section">
                    <div class="section-title">SOFT SKILLS</div>
                    @if(!empty($resume['skills']['soft']))
                        @foreach($resume['skills']['soft'] as $skill)
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text" contenteditable="true">{{ trim($skill) }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <div class="skill-dot"></div>
                            <div class="skill-text" contenteditable="true">Add soft skills</div>
                        </div>
                    @endif
                </div>

                <!-- Languages -->
                <div class="section">
                    <div class="section-title">LANGUAGES</div>
                    @if(!empty($resume['skills']['languages']))
                        @foreach($resume['skills']['languages'] as $lang)
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text" contenteditable="true">{{ trim($lang) }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="skill-item">
                            <div class="skill-dot"></div>
                            <div class="skill-text" contenteditable="true">Add languages</div>
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
        <button class="color-btn active" data-color="blue" style="background:#4B7BE5;" title="Blue"></button>
        <button class="color-btn" data-color="orange" style="background:rgba(255, 198, 106, 0.75);" title="Orange"></button>
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
        const savedColor = sessionStorage.getItem('minimalColor') || 'blue';
        applyColor(savedColor);

        const savedImage = sessionStorage.getItem('minimalProfileImage');
        if (savedImage) {
            document.getElementById('profileImage').src = savedImage;
            document.getElementById('profileImage').style.display = 'block';
            document.getElementById('profilePlaceholder').style.display = 'none';
        }
    });

    function applyColor(color) {
        const header = document.getElementById('headerSection');
        header.className = 'header-section ' + color;

        document.querySelectorAll('.color-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.color === color);
        });

        sessionStorage.setItem('minimalColor', color);
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
                sessionStorage.setItem('minimalProfileImage', ev.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // PDF Download with no cropping
    function downloadPDF() {
        const element = document.getElementById('resumeContent');
        const opt = {
            margin: [0, 0, 0, 0],
            filename: 'minimal-resume.pdf',
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
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
            }
        });
    });
</script>

</body>
</html>

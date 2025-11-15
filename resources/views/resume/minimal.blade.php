<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resume['name'] ?? 'Resume' }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #F9FAFB;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }

        .resume-container {
            max-width: 900px;
            margin: 0 auto 20px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header-box {
            background: rgba(255,198,106,0.75);
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .header-name {
            font-size: 40px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #222;
        }

        .header-profession {
            font-size: 22px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: #222;
            margin-top: 8px;
        }

        .header-summary {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        /* Section Titles */
        .section-title {
            font-size: 22px;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            color: #E5864B;
            margin-top: 40px;
            margin-bottom: 16px;
        }

        /* Two Column Layout */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-top: 20px;
        }

        /* Experience */
        .job-title {
            font-weight: 700;
            font-size: 20px;
            color: #4B3B00;
            margin-bottom: 4px;
        }

        .company {
            font-size: 16px;
            font-weight: 600;
            color: #4B3B00;
            margin-bottom: 8px;
        }

        .job-list {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .job-list li {
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
        }

        /* Education */
        .edu-entry {
            font-size: 18px;
            color: #4B3B00;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .edu-major {
            font-size: 14px;
            font-weight: 400;
            color: #666;
        }

        /* Contact */
        .contact-info {
            font-size: 18px;
            color: #4B3B00;
            font-weight: 700;
            line-height: 1.8;
        }

        /* Skills */
        .skill-item {
            font-size: 18px;
            font-weight: 700;
            color: #4B3B00;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .skill-dot {
            width: 9px;
            height: 9px;
            background: #4B3B00;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
        }

        /* Control Bar */
        .control-bar {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 20px;
            bottom: 20px;
        }

        .control-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .color-section {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .color-label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .color-palette {
            display: flex;
            gap: 8px;
        }

        .color-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .color-btn:hover {
            transform: scale(1.1);
            border-color: #333;
        }

        .color-btn.active {
            border-color: #333;
            transform: scale(1.15);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: #6A6CFF;
            color: white;
        }

        .btn-primary:hover {
            background: #5555FF;
        }

        .btn-secondary {
            background: #999;
            color: white;
        }

        .btn-secondary:hover {
            background: #777;
        }

        .icon {
            width: 18px;
            height: 18px;
        }

        /* Print Styles */
        @media print {
            body { background: white; padding: 0; }
            .resume-container { box-shadow: none; }
            .control-bar { display: none !important; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .two-col {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .control-content {
                flex-direction: column;
                align-items: stretch;
            }

            .color-section,
            .action-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="resume-container" id="resumeContent">
        <!-- HEADER AREA -->
        <div class="header-box" id="headerBox">
            <div class="header-name">{{ $resume['name'] ?? 'Your Name' }}</div>
            <div class="header-profession">{{ $resume['profession'] ?? 'Your Profession' }}</div>
            <div class="header-summary">
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
                        <span class="edu-major">Major: {{ $edu['major'] }}</span>
                    </div>
                @endforeach
            </div>

            <!-- RIGHT COLUMN -->
            <div>
                <div class="section-title">CONTACT</div>
                <div class="contact-info">
                    {{ $resume['phone'] ?? '+1 234 567 8900' }}<br>
                    {{ $resume['email'] ?? 'email@example.com' }}<br>
                    {{ $resume['city'] ?? 'City, State' }}
                </div>

                <div class="section-title">SKILLS</div>
                @foreach(array_merge($resume['skills']['technical'] ?? [], $resume['skills']['soft'] ?? [], $resume['skills']['languages'] ?? []) as $skill)
                <div class="skill-item">
                    <span class="skill-dot"></span>{{ $skill }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CONTROL BAR -->
    <div class="control-bar">
        <div class="control-content">
            <!-- Color Picker Section -->
            <div class="color-section">
                <div class="color-label">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                    Header Color:
                </div>
                <div class="color-palette">
                    <button class="color-btn active" style="background: rgba(255,198,106,0.75);" data-color="rgba(255,198,106,0.75)" title="Orange"></button>
                    <button class="color-btn" style="background: rgba(75,123,229,0.99);" data-color="rgba(75,123,229,0.99)" title="Blue"></button>
                    <button class="color-btn" style="background: rgba(76,175,80,0.75);" data-color="rgba(76,175,80,0.75)" title="Green"></button>
                    <button class="color-btn" style="background: rgba(244,67,54,0.75);" data-color="rgba(244,67,54,0.75)" title="Red"></button>
                    <button class="color-btn" style="background: rgba(156,39,176,0.75);" data-color="rgba(156,39,176,0.75)" title="Purple"></button>
                    <button class="color-btn" style="background: rgba(255,152,0,0.75);" data-color="rgba(255,152,0,0.75)" title="Amber"></button>
                    <button class="color-btn" style="background: rgba(0,150,136,0.75);" data-color="rgba(0,150,136,0.75)" title="Teal"></button>
                    <button class="color-btn" style="background: rgba(96,125,139,0.75);" data-color="rgba(96,125,139,0.75)" title="Gray"></button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button onclick="downloadPDF()" class="btn btn-primary">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download PDF
                </button>
                <a href="{{ url('/') }}" class="btn btn-secondary">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Home
                </a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // Color Picker Functionality
        const colorButtons = document.querySelectorAll('.color-btn');
        const headerBox = document.getElementById('headerBox');

        colorButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                colorButtons.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Change header background color
                const color = this.getAttribute('data-color');
                headerBox.style.background = color;
            });
        });

        // PDF Download Functionality
        function downloadPDF() {
            const element = document.getElementById('resumeContent');
            const opt = {
                margin: 0.5,
                filename: '{{ $resume["name"] ?? "Resume" }}'.replace(/\s+/g, '_') + '_Resume.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

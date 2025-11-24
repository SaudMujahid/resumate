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
            font-family: 'DejaVu Sans', sans-serif;
            background: #F9FAFB;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .resume-container {
            width: 100%;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        /* Header */
        .header-box {
            padding: 40px 20px;
            border-radius: 12px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .header-box.orange {
            background: rgba(255, 198, 106, 0.75);
        }

        .header-box.blue {
            background: rgba(75, 123, 229, 0.99);
        }

        .header-box.green {
            background: rgba(76, 175, 80, 0.75);
        }

        .header-box.red {
            background: rgba(244, 67, 54, 0.75);
        }

        .header-box.purple {
            background: rgba(156, 39, 176, 0.75);
        }

        .header-box.amber {
            background: rgba(255, 152, 0, 0.75);
        }

        .header-box.teal {
            background: rgba(0, 150, 136, 0.75);
        }

        .header-box.gray {
            background: rgba(96, 125, 139, 0.75);
        }

        .header-name {
            font-size: 40px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #222;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .header-name:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .header-name:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .header-profession {
            font-size: 22px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            color: #222;
            margin-top: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .header-profession:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .header-profession:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .header-summary {
            margin-top: 20px;
            font-size: 16px;
            color: #333;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .header-summary:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .header-summary:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
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
            margin-top: 40px;
        }

        /* Experience */
        .job-title {
            font-weight: 700;
            font-size: 20px;
            color: #4B3B00;
            margin-bottom: 4px;
            cursor: text;
            padding: 4px;
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

        .company {
            font-size: 16px;
            font-weight: 600;
            color: #4B3B00;
            margin-bottom: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .company:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .company:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .job-list {
            margin-bottom: 20px;
        }

        .job-list li {
            margin-left: 20px;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .job-list li:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .job-list li:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        /* Education */
        .edu-entry {
            font-size: 18px;
            color: #4B3B00;
            margin-bottom: 12px;
            font-weight: 700;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edu-entry:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .edu-entry:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .edu-major {
            font-size: 14px;
            font-weight: 400;
            cursor: text;
            padding: 2px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .edu-major:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .edu-major:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        /* Contact */
        .contact-info {
            font-size: 18px;
            color: #4B3B00;
            font-weight: 700;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .contact-info:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .contact-info:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        /* Skills */
        .skill-item {
            font-size: 18px;
            font-weight: 700;
            color: #4B3B00;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .skill-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .skill-item:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
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
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
            z-index: 1000;
        }

        .color-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-label {
            font-weight: 600;
            font-size: 12px;
            color: #333;
            writing-mode: vertical-rl;
            text-orientation: mixed;
            white-space: nowrap;
        }

        .color-palette {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .color-btn {
            width: 32px;
            height: 32px;
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

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Poppins', sans-serif;
            text-decoration: none;
            justify-content: center;
            background: #6A6CFF;
            color: white;
        }

        .btn:hover {
            background: #5555FF;
        }

        .btn-secondary {
            background: #999;
        }

        .btn-secondary:hover {
            background: #777;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .resume-container {
                box-shadow: none;
                margin-bottom: 0;
                border-radius: 0;
                padding: 40px;
                max-width: 100%;
            }

            .control-bar {
                display: none !important;
            }

            section, div, .header-box {
                page-break-inside: avoid !important;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .resume-container {
                padding: 30px;
            }

            .header-name {
                font-size: 32px;
            }

            .header-profession {
                font-size: 18px;
            }

            .control-bar {
                right: 10px;
                top: auto;
                bottom: 10px;
                transform: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="resume-container" id="resumeContent">
            <!-- HEADER AREA -->
            <div class="header-box orange" id="headerBox">
                <div class="header-name" contenteditable="true" id="name">Your Name</div>
                <div class="header-profession" contenteditable="true" id="profession">Your Profession</div>
                <div class="header-summary" contenteditable="true" id="summary">
                    Write a short description about yourself.
                </div>
            </div>

            <!-- MAIN SECTIONS -->
            <div class="two-col">
                <!-- LEFT COLUMN -->
                <div>
                    <div class="section-title">WORK EXPERIENCE</div>
                    <div id="workExperience">
                        <div class="job-title" contenteditable="true">Senior Software Engineer</div>
                        <div class="company" contenteditable="true">Tech Company Inc. (2020-2023)</div>
                        <ul class="job-list">
                            <li contenteditable="true">Led development of core product features</li>
                            <li contenteditable="true">Mentored junior developers and code reviews</li>
                            <li contenteditable="true">Improved application performance by 40%</li>
                        </ul>

                        <div class="job-title" contenteditable="true">Software Developer</div>
                        <div class="company" contenteditable="true">StartUp Co. (2018-2020)</div>
                        <ul class="job-list">
                            <li contenteditable="true">Built scalable web applications</li>
                            <li contenteditable="true">Collaborated with cross-functional teams</li>
                        </ul>
                    </div>

                    <div class="section-title">EDUCATION</div>
                    <div id="educationList">
                        <div class="edu-entry" contenteditable="true">
                            Bachelor of Computer Science — State University (2018)
                        </div>
                        <div class="edu-major" contenteditable="true">Major: Computer Science</div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div>
                    <div class="section-title">CONTACT</div>
                    <p class="contact-info">
                        <span contenteditable="true" id="phone">+1 (555) 123-4567</span><br>
                        <span contenteditable="true" id="email">your.email@example.com</span><br>
                        <span contenteditable="true" id="city">New York, NY</span>
                    </p>

                    <div class="section-title">SKILLS</div>
                    <div id="skillsList">
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>JavaScript & TypeScript
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>React & Vue.js
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Node.js & Express
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>SQL & NoSQL Databases
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Leadership & Communication
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Bar -->
    <div class="control-bar">
        <div class="color-section">
            <span class="color-label">Header Color:</span>
            <div class="color-palette">
                <button class="color-btn" style="background: rgba(75, 123, 229, 0.99);" data-color="blue" onclick="changeColor('blue')" title="Blue"></button>
                <button class="color-btn active" style="background: rgba(255, 198, 106, 0.75);" data-color="orange" onclick="changeColor('orange')" title="Orange"></button>
                <button class="color-btn" style="background: rgba(76, 175, 80, 0.75);" data-color="green" onclick="changeColor('green')" title="Green"></button>
                <button class="color-btn" style="background: rgba(244, 67, 54, 0.75);" data-color="red" onclick="changeColor('red')" title="Red"></button>
                <button class="color-btn" style="background: rgba(156, 39, 176, 0.75);" data-color="purple" onclick="changeColor('purple')" title="Purple"></button>
                <button class="color-btn" style="background: rgba(255, 152, 0, 0.75);" data-color="amber" onclick="changeColor('amber')" title="Amber"></button>
                <button class="color-btn" style="background: rgba(0, 150, 136, 0.75);" data-color="teal" onclick="changeColor('teal')" title="Teal"></button>
                <button class="color-btn" style="background: rgba(96, 125, 139, 0.75);" data-color="gray" onclick="changeColor('gray')" title="Gray"></button>
            </div>
        </div>

        <button class="btn" onclick="downloadPDF()">
            <span>⬇️</span> Download PDF
        </button>
        <a href="/" class="btn btn-secondary">
            <span>🏠</span> Home
        </a>
    </div>

    <script>
        let currentColor = 'orange';

        function changeColor(color) {
            const header = document.getElementById('headerBox');
            const buttons = document.querySelectorAll('.color-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.color-btn').classList.add('active');

            header.className = 'header-box ' + color;
            currentColor = color;
            sessionStorage.setItem('headerColor', color);
        }

        // Prevent Enter key from creating new lines in single-line fields
        document.querySelectorAll('[contenteditable="true"]').forEach(el => {
            // Only prevent enter for non-list items and non-summary fields
            if (!el.tagName.includes('LI') && el.id !== 'summary') {
                el.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                    }
                });
            }
        });

        function downloadPDF() {
            const element = document.getElementById('resumeContent');
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'modern-resume.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    allowTaint: true
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(opt).from(element).save();
        }

        // Store edits in session
        document.querySelectorAll('[contenteditable="true"]').forEach(el => {
            el.addEventListener('blur', () => {
                const key = el.id || el.className + '_' + el.textContent.substring(0, 20);
                sessionStorage.setItem(key, el.innerHTML);
            });
        });

        // Restore edits and color on page load
        window.addEventListener('load', () => {
            // Restore color
            const savedColor = sessionStorage.getItem('headerColor') || 'orange';
            const header = document.getElementById('headerBox');
            header.className = 'header-box ' + savedColor;

            const buttons = document.querySelectorAll('.color-btn');
            buttons.forEach(btn => {
                if (btn.getAttribute('data-color') === savedColor) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Restore edits
            document.querySelectorAll('[contenteditable="true"]').forEach(el => {
                const key = el.id || el.className + '_' + el.textContent.substring(0, 20);
                const stored = sessionStorage.getItem(key);
                if (stored) {
                    el.innerHTML = stored;
                }
            });
        });
    </script>
</body>
</html>

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
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .resume-wrapper {
            position: relative;
            width: 100%;
            background: #ffffff;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .header-section {
            position: relative;
            width: 100%;
            padding: 50px 60px;
            display: flex;
            align-items: flex-start;
            z-index: 1;
            transition: background-color 0.3s ease;
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

        .header-name {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 48px;
            line-height: 1.2;
            color: #ffffff;
            word-break: break-word;
        }

        .content-box {
            position: relative;
            width: 100%;
            padding: 50px 60px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        .left-column {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .section-title {
            font-family: 'Poppins';
            font-weight: 600;
            font-size: 28px;
            line-height: 1.3;
            color: rgba(75, 123, 229, 0.99);
            margin-bottom: 10px;
        }

        .job-entry {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .job-title {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 18px;
            line-height: 1.3;
            color: #333333;
        }

        .company-info {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 14px;
            line-height: 1.5;
            color: #666666;
        }

        .contact-item {
            font-family: 'Poppins';
            font-weight: 600;
            font-size: 14px;
            line-height: 1.6;
            color: #333333;
        }

        .skill-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .skill-dot {
            width: 7px;
            height: 7px;
            background: #1e1e1e;
            border-radius: 50%;
            margin-top: 6px;
            flex-shrink: 0;
        }

        .skill-text {
            font-family: 'Poppins';
            font-weight: 600;
            font-size: 14px;
            line-height: 1.5;
            color: #333333;
        }

        .edu-entry {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .edu-degree {
            font-family: 'Poppins';
            font-weight: 700;
            font-size: 16px;
            line-height: 1.3;
            color: #333333;
        }

        .edu-details {
            font-family: 'Poppins';
            font-weight: 400;
            font-size: 13px;
            line-height: 1.5;
            color: #666666;
        }

        /* Editing Styles */
        .editable {
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .editable:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .editable:focus {
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-items: center;
            z-index: 1000;
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

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .resume-wrapper {
                box-shadow: none;
                margin-bottom: 0;
                border-radius: 0;
                max-width: 100%;
            }

            .control-bar {
                display: none !important;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-box {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 40px;
            }

            .header-section {
                padding: 40px;
            }

            .header-name {
                font-size: 40px;
            }
        }

        @media (max-width: 768px) {
            .resume-wrapper {
                padding: 20px;
            }

            .header-section {
                padding: 30px;
            }

            .header-name {
                font-size: 32px;
            }

            .content-box {
                padding: 30px;
                gap: 30px;
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
        <div class="resume-wrapper" id="resumeContent">
            <div class="header-section blue" id="headerSection">
                <div class="header-name" contenteditable="true" data-field="name">Your Name</div>
            </div>

            <div class="content-box">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Work Experience -->
                    <div class="section">
                        <div class="section-title">WORK EXPERIENCE</div>
                        <div id="workExperience">
                            <div class="job-entry">
                                <div class="job-title editable" contenteditable="true">Job Title</div>
                                <div class="company-info editable" contenteditable="true">Company Name • Jan 2020 - Dec 2021</div>
                            </div>
                            <div class="job-entry">
                                <div class="job-title editable" contenteditable="true">Previous Job Title</div>
                                <div class="company-info editable" contenteditable="true">Previous Company • Jan 2018 - Dec 2019</div>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="section">
                        <div class="section-title">SKILLS</div>
                        <div id="skillsList">
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text editable" contenteditable="true">UI/UX Design</div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text editable" contenteditable="true">Web Development</div>
                            </div>
                            <div class="skill-item">
                                <div class="skill-dot"></div>
                                <div class="skill-text editable" contenteditable="true">Project Management</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <!-- Contact -->
                    <div class="section">
                        <div class="section-title">CONTACT</div>
                        <div class="contact-item editable" contenteditable="true">+1 (555) 123-4567</div>
                        <div class="contact-item editable" contenteditable="true">your.email@example.com</div>
                        <div class="contact-item editable" contenteditable="true">New York, NY</div>
                    </div>

                    <!-- Education -->
                    <div class="section">
                        <div class="section-title">EDUCATION</div>
                        <div id="educationList">
                            <div class="edu-entry">
                                <div class="edu-degree editable" contenteditable="true">Bachelor of Science</div>
                                <div class="edu-details editable" contenteditable="true">University Name • 2020</div>
                            </div>
                            <div class="edu-entry">
                                <div class="edu-degree editable" contenteditable="true">High School Diploma</div>
                                <div class="edu-details editable" contenteditable="true">High School Name • 2016</div>
                            </div>
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
                <button class="color-btn active" style="background: rgba(75, 123, 229, 0.99);" data-color="blue" onclick="changeColor('blue')" title="Blue"></button>
                <button class="color-btn" style="background: rgba(255, 198, 106, 0.75);" data-color="orange" onclick="changeColor('orange')" title="Orange"></button>
                <button class="color-btn" style="background: rgba(76, 175, 80, 0.75);" data-color="green" onclick="changeColor('green')" title="Green"></button>
                <button class="color-btn" style="background: rgba(244, 67, 54, 0.75);" data-color="red" onclick="changeColor('red')" title="Red"></button>
                <button class="color-btn" style="background: rgba(156, 39, 176, 0.75);" data-color="purple" onclick="changeColor('purple')" title="Purple"></button>
                <button class="color-btn" style="background: rgba(255, 152, 0, 0.75);" data-color="amber" onclick="changeColor('amber')" title="Amber"></button>
                <button class="color-btn" style="background: rgba(0, 150, 136, 0.75);" data-color="teal" onclick="changeColor('teal')" title="Teal"></button>
                <button class="color-btn" style="background: rgba(96, 125, 139, 0.75);" data-color="gray" onclick="changeColor('gray')" title="Gray"></button>
            </div>
        </div>

        <button class="btn btn-primary" onclick="downloadPDF()">
            <span>⬇️</span> Download PDF
        </button>
        <a href="/" class="btn btn-secondary" style="text-decoration: none;">
            <span>🏠</span> Home
        </a>
    </div>

    <script>
        let currentColor = 'blue';

        function changeColor(color) {
            const header = document.getElementById('headerSection');
            const buttons = document.querySelectorAll('.color-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.color-btn').classList.add('active');

            header.className = 'header-section ' + color;
            currentColor = color;
            sessionStorage.setItem('headerColor', color);
        }

        // Make all contenteditable elements work properly
        document.querySelectorAll('[contenteditable="true"]').forEach(el => {
            el.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                }
            });
        });

        function downloadPDF() {
            const element = document.getElementById('resumeContent');
            const opt = {
                margin: [10, 10, 10, 10],
                filename: 'resume.pdf',
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
                sessionStorage.setItem(el.getAttribute('data-field') || el.textContent, el.innerHTML);
            });
        });

        // Restore edits and color on page load
        window.addEventListener('load', () => {
            // Restore color
            const savedColor = sessionStorage.getItem('headerColor') || 'blue';
            const header = document.getElementById('headerSection');
            header.className = 'header-section ' + savedColor;

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
                const key = el.getAttribute('data-field') || el.textContent;
                const stored = sessionStorage.getItem(key);
                if (stored) {
                    el.innerHTML = stored;
                }
            });
        });
    </script>
</body>
</html>

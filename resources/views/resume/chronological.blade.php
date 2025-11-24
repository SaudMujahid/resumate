<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronological Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F9FAFB;
            font-family: 'DejaVu Sans', sans-serif;
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .resume-wrapper {
            background: white;
            position: relative;
            min-height: 1123px;
            display: flex;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        /* Left Sidebar */
        .sidebar {
            width: 366px;
            background: #3A8B84;
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease;
        }

        .sidebar.teal { background: #3A8B84; }
        .sidebar.blue { background: #4B7BE5; }
        .sidebar.green { background: #4CAF50; }
        .sidebar.purple { background: #9C27B0; }
        .sidebar.orange { background: #FF9800; }
        .sidebar.red { background: #F44336; }
        .sidebar.gray { background: #607D8B; }
        .sidebar.navy { background: #1A237E; }

        .profile-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            background: rgba(255,255,255,0.1);
            border: 3px solid rgba(255,255,255,0.3);
            cursor: pointer;
            position: relative;
        }

        .profile-image-container:hover::after {
            content: 'Click to change';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            background: rgba(0,0,0,0.7);
            padding: 5px 10px;
            border-radius: 4px;
            white-space: nowrap;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: rgba(255,255,255,0.5);
        }

        .profile-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 28px;
            line-height: 1.3;
            color: rgba(255, 255, 255, 0.94);
            margin-bottom: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .profile-name:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .profile-name:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .profile-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 20px;
            line-height: 1.3;
            color: rgba(255, 255, 255, 0.96);
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .profile-title:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .profile-title:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-section {
            margin-bottom: 40px;
        }

        .sidebar-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 1.3;
            color: rgba(255, 255, 255, 0.96);
            margin-bottom: 15px;
        }

        .contact-item {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .contact-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .contact-item:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .skill-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 1.5;
            color: #FFFFFF;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .skill-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .skill-item:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .skill-dot {
            width: 9px;
            height: 9px;
            background: #FFFFFF;
            border-radius: 50%;
            margin-right: 15px;
            margin-top: 6px;
            flex-shrink: 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 60px 50px;
        }

        .section {
            margin-bottom: 45px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 28px;
            line-height: 1.3;
            color: #222222;
            margin-bottom: 20px;
            border-bottom: 2px solid #E0E0E0;
            padding-bottom: 8px;
        }

        .experience-entry {
            margin-bottom: 25px;
        }

        .job-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 20px;
            line-height: 1.3;
            color: #222222;
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

        .company-info {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;
            line-height: 1.5;
            color: #666666;
            margin-bottom: 4px;
            cursor: text;
            padding: 4px;
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
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.6;
            color: #333333;
            margin-top: 8px;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .job-description:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .job-description:focus {
            outline: none;
            background-color: rgba(75, 123, 229, 0.15);
            box-shadow: inset 0 0 0 2px rgba(75, 123, 229, 0.4);
        }

        .education-entry {
            margin-bottom: 20px;
        }

        .edu-degree {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 18px;
            line-height: 1.3;
            color: #222222;
            margin-bottom: 4px;
            cursor: text;
            padding: 4px;
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
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
            cursor: text;
            padding: 4px;
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

        .about-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.6;
            color: #333333;
            cursor: text;
            padding: 4px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .about-text:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .about-text:focus {
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

        #imageUpload {
            display: none;
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
                border-radius: 0;
                max-width: 100%;
            }

            .control-bar {
                display: none !important;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .resume-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main-content {
                padding: 40px 30px;
            }

            .control-bar {
                right: 10px;
                top: auto;
                bottom: 10px;
                transform: none;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 30px 20px;
            }

            .sidebar {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <input type="file" id="imageUpload" accept="image/*">

    <div class="container">
        <div class="resume-wrapper" id="resumeContent">
            <!-- Left Sidebar -->
            <div class="sidebar teal" id="sidebar">
                <div class="profile-section">
                    <div class="profile-image-container" onclick="document.getElementById('imageUpload').click()">
                        <div class="profile-placeholder" id="profilePlaceholder">👤</div>
                        <img class="profile-image" id="profileImage" style="display: none;">
                    </div>

                    <div class="profile-name" contenteditable="true" id="name">Your Name</div>
                    <div class="profile-title" contenteditable="true" id="jobTitle">Job Title</div>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">CONTACT</div>
                    <div class="contact-item" contenteditable="true">+1 (555) 123-4567</div>
                    <div class="contact-item" contenteditable="true">your.email@example.com</div>
                    <div class="contact-item" contenteditable="true">New York, NY</div>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">SKILLS</div>
                    <div id="skillsList">
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>JavaScript & React
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Python & Django
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Project Management
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Team Leadership
                        </div>
                        <div class="skill-item" contenteditable="true">
                            <span class="skill-dot"></span>Problem Solving
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <div class="section">
                    <div class="section-title">EXPERIENCE</div>
                    <div class="experience-entry">
                        <div class="job-title" contenteditable="true">Senior Software Engineer</div>
                        <div class="company-info" contenteditable="true">Tech Company Inc. • Jan 2020 - Present</div>
                        <div class="job-description" contenteditable="true">
                            Led development of core product features, mentored junior developers, and improved application performance by 40%. Collaborated with cross-functional teams to deliver high-quality software solutions.
                        </div>
                    </div>
                    <div class="experience-entry">
                        <div class="job-title" contenteditable="true">Software Developer</div>
                        <div class="company-info" contenteditable="true">StartUp Co. • Jun 2017 - Dec 2019</div>
                        <div class="job-description" contenteditable="true">
                            Built scalable web applications and worked closely with designers to create intuitive user interfaces. Implemented automated testing to reduce bugs by 30%.
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">EDUCATION</div>
                    <div class="education-entry">
                        <div class="edu-degree" contenteditable="true">Bachelor of Computer Science</div>
                        <div class="edu-details" contenteditable="true">State University • Graduated 2017</div>
                    </div>
                    <div class="education-entry">
                        <div class="edu-degree" contenteditable="true">Relevant Certifications</div>
                        <div class="edu-details" contenteditable="true">AWS Certified Solutions Architect • 2019</div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">ABOUT ME</div>
                    <div class="about-text" contenteditable="true">
                        Passionate software engineer with 6+ years of experience building scalable web applications. Committed to writing clean, maintainable code and continuously learning new technologies. Strong communicator who thrives in collaborative environments.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Control Bar -->
    <div class="control-bar">
        <div class="color-section">
            <span class="color-label">Sidebar Color:</span>
            <div class="color-palette">
                <button class="color-btn active" style="background: #3A8B84;" data-color="teal" onclick="changeColor('teal')" title="Teal"></button>
                <button class="color-btn" style="background: #4B7BE5;" data-color="blue" onclick="changeColor('blue')" title="Blue"></button>
                <button class="color-btn" style="background: #4CAF50;" data-color="green" onclick="changeColor('green')" title="Green"></button>
                <button class="color-btn" style="background: #9C27B0;" data-color="purple" onclick="changeColor('purple')" title="Purple"></button>
                <button class="color-btn" style="background: #FF9800;" data-color="orange" onclick="changeColor('orange')" title="Orange"></button>
                <button class="color-btn" style="background: #F44336;" data-color="red" onclick="changeColor('red')" title="Red"></button>
                <button class="color-btn" style="background: #607D8B;" data-color="gray" onclick="changeColor('gray')" title="Gray"></button>
                <button class="color-btn" style="background: #1A237E;" data-color="navy" onclick="changeColor('navy')" title="Navy"></button>
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
        let currentColor = 'teal';

        function changeColor(color) {
            const sidebar = document.getElementById('sidebar');
            const buttons = document.querySelectorAll('.color-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.color-btn').classList.add('active');

            sidebar.className = 'sidebar ' + color;
            currentColor = color;
            sessionStorage.setItem('sidebarColor', color);
        }

        // Image upload handling
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.getElementById('profileImage');
                    const placeholder = document.getElementById('profilePlaceholder');

                    img.src = event.target.result;
                    img.style.display = 'block';
                    placeholder.style.display = 'none';

                    sessionStorage.setItem('profileImage', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Prevent Enter key from creating new lines in single-line fields
        document.querySelectorAll('[contenteditable="true"]').forEach(el => {
            if (!el.classList.contains('job-description') && !el.classList.contains('about-text')) {
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
                filename: 'chronological-resume.pdf',
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

        // Restore edits, color, and image on page load
        window.addEventListener('load', () => {
            // Restore color
            const savedColor = sessionStorage.getItem('sidebarColor') || 'teal';
            const sidebar = document.getElementById('sidebar');
            sidebar.className = 'sidebar ' + savedColor;

            const buttons = document.querySelectorAll('.color-btn');
            buttons.forEach(btn => {
                if (btn.getAttribute('data-color') === savedColor) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Restore profile image
            const savedImage = sessionStorage.getItem('profileImage');
            if (savedImage) {
                const img = document.getElementById('profileImage');
                const placeholder = document.getElementById('profilePlaceholder');
                img.src = savedImage;
                img.style.display = 'block';
                placeholder.style.display = 'none';
            }

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

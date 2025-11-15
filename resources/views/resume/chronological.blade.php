<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronological Resume</title>

    <!-- QuillJS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #F9FAFB;
            font-family: 'DejaVu Sans', sans-serif;
            padding: 20px;
        }

        .resume-wrapper {
            max-width: 1440px;
            margin: auto;
            background: white;
            position: relative;
            min-height: 1024px;
        }

        /* Left Sidebar */
        .sidebar {
            position: absolute;
            width: 366px;
            min-height: 953px;
            left: 38px;
            top: 54px;
            background: #3A8B84;
            padding: 20px;
        }

        .profile-section {
            text-align: center;
            margin-top: 180px;
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

        #name {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 30px;
            line-height: 45px;
            color: rgba(255, 255, 255, 0.94);
            margin-bottom: 8px;
        }

        #jobTitle {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 22px;
            line-height: 33px;
            color: rgba(255, 255, 255, 0.96);
        }

        .sidebar-section {
            margin-top: 50px;
        }

        .sidebar-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 30px;
            line-height: 45px;
            color: rgba(255, 255, 255, 0.96);
            margin-bottom: 20px;
        }

        #contact {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 22px;
            line-height: 33px;
            color: rgba(255, 255, 255, 0.95);
        }

        #skills {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 22px;
            line-height: 33px;
            color: #FFFFFF;
        }

        #skills p {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        #skills p::before {
            content: '';
            width: 9px;
            height: 9px;
            background: #FFFFFF;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
        }

        /* Main Content */
        .main-content {
            margin-left: 460px;
            padding: 68px 60px 40px 40px;
        }

        .section {
            margin-bottom: 50px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 32px;
            line-height: 48px;
            color: #222222;
            margin-bottom: 25px;
        }

        #experience, #education, #about {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 36px;
            color: #222222;
        }

        /* Quill Editor Styling */
        .ql-editor {
            padding: 0 !important;
            font-family: 'Poppins', sans-serif;
        }

        .ql-editor p {
            margin-bottom: 8px;
        }

        .ql-toolbar {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        /* Control Panel */
        .control-panel {
            position: fixed;
            top: 20px;
            left: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
        }

        .control-panel h3 {
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 700;
        }

        .color-picker-group {
            margin-bottom: 15px;
        }

        .color-picker-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 600;
        }

        .color-picker-group input[type="color"] {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn {
            padding: 12px 24px;
            background: #6A6CFF;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            margin-top: 10px;
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

        @media print {
            body { background: white; padding: 0; }
            .control-panel, .ql-toolbar, .btn { display: none !important; }
            .resume-wrapper { box-shadow: none; }
        }

        @media(max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                left: 0;
                top: 0;
            }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .control-panel {
                position: relative;
                margin-bottom: 20px;
            }
        }

        /* Hidden file input */
        #imageUpload {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Control Panel -->
    <div class="control-panel">
        <h3>Resume Controls</h3>

        <div class="color-picker-group">
            <label>Sidebar Color</label>
            <input type="color" id="sidebarColor" value="#3A8B84">
        </div>

        <button class="btn" onclick="downloadPDF()">Download PDF</button>
        <button class="btn btn-secondary" onclick="window.location.href='/'">Home</button>
    </div>

    <!-- Hidden Image Upload Input -->
    <input type="file" id="imageUpload" accept="image/*">

    <div class="resume-wrapper">
        <!-- Left Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="profile-section">
                <div class="profile-image-container" onclick="document.getElementById('imageUpload').click()">
                    <div class="profile-placeholder" id="profilePlaceholder">👤</div>
                    <img class="profile-image" id="profileImage" style="display: none;">
                </div>

                <div id="name"> {{ $resume['name'] ?? 'Your name' }} </div>
                <div id="jobTitle"> {{ $resume['title'] ?? 'Job Title' }} </div>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">CONTACT</div>
                <div id="contact">
                    <p> {{ $resume['phone'] ?? 'Phone Number' }}</p>
                    <p>{{ $resume['email'] ?? 'Email' }}</p>
                    <p><{{ $resume['city'] ?? 'city' }}/p>
                </div>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">SKILLS</div>
                <div id="skills">
                 @foreach(($resume['skills']['technical'] ?? []) as $skill)
                    <p>{{ $skill }}</p>
                @endforeach
                @foreach(($resume['skills']['soft'] ?? []) as $skill)
                    <p>{{ $skill }}</p>
                @endforeach
                @foreach(($resume['skills']['languages'] ?? []) as $skill)
                    <p>{{ $skill }}</p>
                @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="section">
                <div class="section-title">EXPERIENCE</div>
                <div id="experience">
                    <p><strong>Job Title</strong></p>
                    <p>Company Name</p>
                    <p>Dates of Employment</p>
                    <p style="font-size: 18px; font-weight: 400; margin-top: 10px;">Description of responsibilities and achievements</p>
                </div>
            </div>

            <div class="section">
                <div class="section-title">EDUCATION</div>
                <div id="education">
                    <p>Degree</p>
                    <p>University</p>
                    <p>City</p>
                </div>
            </div>

            <div class="section">
                <div class="section-title">ABOUT ME</div>
                <div id="about">
                    <p>Write a short description about yourself</p>
                </div>
            </div>
        </div>
    </div>

    <!-- QuillJS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Initialize Quill editors for each editable section
        const editors = {};
        const editableIds = ['name', 'jobTitle', 'contact', 'skills', 'experience', 'education', 'about'];

        editableIds.forEach(id => {
            const element = document.getElementById(id);
            editors[id] = new Quill(`#${id}`, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'size': ['small', false, 'large', 'huge'] }],
                        ['clean']
                    ]
                }
            });
        });

        // Sidebar color picker
        document.getElementById('sidebarColor').addEventListener('change', function(e) {
            document.getElementById('sidebar').style.background = e.target.value;
        });

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
                };
                reader.readAsDataURL(file);
            }
        });

        // PDF Download function
        function downloadPDF() {
            // Hide all Quill toolbars before printing
            const toolbars = document.querySelectorAll('.ql-toolbar');
            toolbars.forEach(toolbar => {
                toolbar.style.display = 'none';
            });

            window.print();

            // Show toolbars again after printing
            setTimeout(() => {
                toolbars.forEach(toolbar => {
                    toolbar.style.display = 'block';
                });
            }, 100);
        }
    </script>
</body>
</html>

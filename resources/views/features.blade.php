<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Resumate — Features</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <header class="header" role="banner">
      <a class="brand" href="features.html" aria-label="Resumate Home">
        <div class="logo" aria-hidden="true">
          <!-- small SVG logo -->
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="2" width="20" height="20" rx="5" fill="#A8E6CF"/>
            <path d="M7 9H17" stroke="#ffffff" stroke-width="1.6" stroke-linecap="round"/>
            <path d="M7 13H13" stroke="#ffffff" stroke-width="1.6" stroke-linecap="round"/>
          </svg>
        </div>
        <div>
          <h1>Resumate</h1>
          <div class="kicker">AI Resume Builder & Rating</div>
        </div>
      </a>

      <nav class="nav" role="navigation" aria-label="Main">
        <a href="features.html">Features</a>
        <a href="templates.html">Templates</a>
        <a href="mission.html">Mission</a>
        <a href="#" class="btn btn-primary" aria-current="page">Try Demo</a>
      </nav>
    </header>

    <main>
      <section class="hero">
        <div class="hero-card" aria-labelledby="features-hero">
          <div class="kicker">Why Resumate</div>
          <h2 id="features-hero" class="lead">Build resumes faster — and send the right message.</h2>
          <p class="small">We combine smart AI writing, job-matching signals, and clear feedback so every resume you make is tailored, concise, and recruiter-ready.</p>

          <div class="cta-row">
            <button class="btn btn-primary">Create resume</button>
            <button class="btn btn-ghost">See templates</button>
          </div>

          <div class="mt-8">
            <div class="kicker">Overall readiness</div>
            <div class="meter" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="72">
              <div style="flex:0 0 70px; text-align:center;">
                <strong style="font-size:18px">72</strong><div class="small">/100</div>
              </div>
              <div class="bar" aria-hidden="true"></div>
              <small>Score combines clarity, keyword match, grammar and layout.</small>
            </div>
          </div>
        </div>

        <aside class="hero-card">
          <div style="display:flex;flex-direction:column;gap:12px;">
            <div style="display:flex;gap:10px;align-items:center;">
              <!-- Small SVG -->
              <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(90deg,#FFD3B6,#A8E6CF);display:grid;place-items:center">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M4 7h16M4 12h10M4 17h16" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
              </div>
              <div>
                <strong>Smart suggestions</strong>
                <div class="small">AI-driven phrasing for summaries, bullets, and achievements.</div>
              </div>
            </div>

            <div style="display:flex;gap:10px;align-items:center;">
              <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(90deg,#D7BDE2,#FFAAA5);display:grid;place-items:center">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2v20M2 12h20" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
              </div>
              <div>
                <strong>Job-match scoring</strong>
                <div class="small">Compare your resume to job descriptions and get a relevance score.</div>
              </div>
            </div>

            <div style="display:flex;gap:10px;align-items:center;">
              <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(90deg,#FFAAA5,#FFD3B6);display:grid;place-items:center">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8" stroke="#fff" stroke-width="1.6"/></svg>
              </div>
              <div>
                <strong>PDF export & templates</strong>
                <div class="small">One-click professional export with printable, ATS-friendly templates.</div>
              </div>
            </div>

          </div>
        </aside>
      </section>

      <section aria-labelledby="core-features" class="mt-8">
        <h3 id="core-features" class="kicker">Core features</h3>
        <p class="lead">Everything you need to write, optimize, and export resumes that recruiters notice.</p>

        <div class="grid" style="margin-top:18px;">
          <article class="card" aria-labelledby="f1">
            <div class="icon" style="background:linear-gradient(135deg,var(--accent-1), #FFD3B6)">
              <!-- AI icon -->
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M12 7v10M7 12h10" stroke="#ffffff" stroke-width="1.7" stroke-linecap="round"/></svg>
            </div>
            <div>
              <h3 id="f1">AI content assistant</h3>
              <p>Generate tailored summaries, achievements, and concise bullet points with a single click. Choose tone and length for different job roles.</p>
            </div>
          </article>

          <article class="card" aria-labelledby="f2">
            <div class="icon" style="background:linear-gradient(135deg,#FFD3B6,#FFAAA5)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M3 7h18M3 12h12M3 17h18" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
            </div>
            <div>
              <h3 id="f2">Job-match & ATS scoring</h3>
              <p>Upload a job description and get a score that reflects keyword alignment, skill fit, and likely ATS pass rate.</p>
            </div>
          </article>

          <article class="card" aria-labelledby="f3">
            <div class="icon" style="background:linear-gradient(135deg,#D7BDE2,#A8E6CF)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M6 9l3 6 3-12 3 8 3-2" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <h3 id="f3">Grammar & clarity checks</h3>
              <p>In-line grammar suggestions plus readability improvements that keep content concise and professional.</p>
            </div>
          </article>

          <article class="card" aria-labelledby="f4">
            <div class="icon" style="background:linear-gradient(135deg,#A8E6CF,#D7BDE2)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M12 6v6l4 2" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div>
              <h3 id="f4">Version history & exports</h3>
              <p>Keep versions, compare edits, and export to PDF or share a secure web link for reviewers.</p>
            </div>
          </article>

          <article class="card" aria-labelledby="f5">
            <div class="icon" style="background:linear-gradient(135deg,#FFD3B6,#A8E6CF)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="#fff" stroke-width="1.6"/></svg>
            </div>
            <div>
              <h3 id="f5">Privacy & local export</h3>
              <p>Your resume data belongs to you — export locally and optionally run the rating model on-device for privacy-sensitive users.</p>
            </div>
          </article>

          <article class="card" aria-labelledby="f6">
            <div class="icon" style="background:linear-gradient(135deg,#FFAAA5,#D7BDE2)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none"><path d="M12 2l3 6 6 .5-4.5 3.5L19 21l-7-4-7 4 1.5-8.5L3 8.5 9 8z" stroke="#fff" stroke-width="1.2" stroke-linejoin="round" fill="none"/></svg>
            </div>
            <div>
              <h3 id="f6">Accessibility & ATS-safe templates</h3>
              <p>Templates prioritized for readability and ATS parsing to increase the chance your resume reaches a human reviewer.</p>
            </div>
          </article>
        </div>
      </section>

      <footer class="footer" role="contentinfo">
        <div>
          <strong>Resumate</strong>
          <div class="small">Built for students & early-career professionals</div>
        </div>
        <div class="small">© <span id="year"></span> Resumate — All rights reserved</div>
      </footer>
    </main>
  </div>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>

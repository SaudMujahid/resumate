<?php

/**
 * Resumate - AI-Powered Resume Builder
 * Main Entry Point
 *
 * This file serves as the main entry point for the Resumate application.
 * It demonstrates the core functionality and can be used for testing
 * and development purposes.
 *
 * Usage: php main.php [command]
 * Commands:
 *   --test         Run basic functionality tests
 *   --demo         Run demo analysis
 *   --help         Show this help message
 */

// Include Laravel's autoloader
require_once __DIR__ . '/vendor/autoload.php';

// ResumeAnalyzer utility class (inline)
class ResumeAnalyzer
{
    public function analyzeText(string $text): array
    {
        $results = [
            'word_count' => str_word_count(strip_tags($text)),
            'character_count' => strlen($text),
            'action_verbs_count' => $this->countActionVerbs($text),
            'structure_score' => $this->analyzeStructure($text),
            'ats_friendly_score' => $this->checkATSFriendliness($text)
        ];
        return $results;
    }

    private function countActionVerbs(string $text): int
    {
        $actionVerbs = ['achieved', 'improved', 'created', 'developed', 'implemented', 'designed', 'managed', 'led'];
        $text = strtolower($text);
        $count = 0;
        foreach ($actionVerbs as $verb) {
            $count += substr_count($text, $verb);
        }
        return $count;
    }

    private function analyzeStructure(string $text): int
    {
        $score = 0;
        $text = strtolower($text);
        $sections = ['experience', 'education', 'skills', 'summary', 'contact'];
        foreach ($sections as $section) {
            if (strpos($text, $section) !== false) {
                $score += 15;
            }
        }
        return min(100, $score);
    }

    private function checkATSFriendliness(string $text): int
    {
        $score = 100;
        if (!preg_match('/\b\d{4}\b/', $text)) $score -= 20; // No years
        if (!preg_match('/(experience|employment|work)/i', $text)) $score -= 20; // No work section
        return max(0, $score);
    }

    public function generateSuggestions(array $analysis): array
    {
        $suggestions = [];
        if ($analysis['word_count'] < 200) {
            $suggestions[] = "Consider adding more detailed descriptions of your experience.";
        }
        if ($analysis['action_verbs_count'] < 3) {
            $suggestions[] = "Use more action verbs to make your accomplishments more impactful.";
        }
        if ($analysis['structure_score'] < 50) {
            $suggestions[] = "Ensure your resume has clear sections with proper headings.";
        }
        if ($analysis['ats_friendly_score'] < 70) {
            $suggestions[] = "Make your resume more ATS-friendly with standard section headers.";
        }
        return $suggestions;
    }

    public function extractContactInfo(string $text): array
    {
        $contact = ['email' => null, 'phone' => null];
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches)) {
            $contact['email'] = $matches[0];
        }
        if (preg_match('/\+?[\d\s\-\(\)]{10,}/', $text, $matches)) {
            $contact['phone'] = trim($matches[0]);
        }
        return $contact;
    }
}

// Bootstrap Laravel (minimal)
$app = require_once __DIR__ . '/bootstrap/app.php';

// Parse command line arguments
$args = $argv;
array_shift($args); // Remove script name

$command = $args[0] ?? '--help';

echo "🎯 Resumate - AI-Powered Resume Builder\n";
echo "=======================================\n\n";

switch ($command) {
    case '--test':
        runTests();
        break;

    case '--demo':
        runDemo();
        break;

    case '--help':
    default:
        showHelp();
        break;
}

function showHelp()
{
    echo "Usage: php main.php [command]\n\n";
    echo "Commands:\n";
    echo "  --test         Run basic functionality tests\n";
    echo "  --demo         Run demo resume analysis\n";
    echo "  --help         Show this help message\n\n";
    echo "Examples:\n";
    echo "  php main.php --test\n";
    echo "  php main.php --demo\n\n";
    echo "For web application:\n";
    echo "  php artisan serve\n\n";
}

function runTests()
{
    echo "🧪 Running Resumate Tests...\n";
    echo "----------------------------\n\n";

    $testsPassed = 0;
    $testsFailed = 0;

    // Test 1: ResumeAnalyzer class instantiation
    try {
        $analyzer = new ResumeAnalyzer();
        echo "✅ Test 1: ResumeAnalyzer class instantiated successfully\n";
        $testsPassed++;
    } catch (Exception $e) {
        echo "❌ Test 1: Failed to instantiate ResumeAnalyzer - {$e->getMessage()}\n";
        $testsFailed++;
    }

    // Test 2: Text analysis functionality
    try {
        $analyzer = new ResumeAnalyzer();
        $sampleText = "I am a software engineer with experience in PHP and Laravel development.";

        $results = $analyzer->analyzeText($sampleText);

        if (isset($results['word_count']) && $results['word_count'] > 0) {
            echo "✅ Test 2: Text analysis working (Word count: {$results['word_count']})\n";
            $testsPassed++;
        } else {
            echo "❌ Test 2: Text analysis failed - invalid results\n";
            $testsFailed++;
        }
    } catch (Exception $e) {
        echo "❌ Test 2: Text analysis error - {$e->getMessage()}\n";
        $testsFailed++;
    }

    // Test 3: Contact extraction
    try {
        $analyzer = new ResumeAnalyzer();
        $contactText = "Contact: john.doe@email.com, Phone: +1-555-123-4567";

        $contact = $analyzer->extractContactInfo($contactText);

        if ($contact['email'] === 'john.doe@email.com') {
            echo "✅ Test 3: Contact extraction working (Email found)\n";
            $testsPassed++;
        } else {
            echo "❌ Test 3: Contact extraction failed - email not found\n";
            $testsFailed++;
        }
    } catch (Exception $e) {
        echo "❌ Test 3: Contact extraction error - {$e->getMessage()}\n";
        $testsFailed++;
    }

    // Test 4: Laravel environment check
    try {
        $appName = env('APP_NAME', 'Unknown');
        if ($appName !== 'Unknown') {
            echo "✅ Test 4: Laravel environment loaded (App: $appName)\n";
            $testsPassed++;
        } else {
            echo "❌ Test 4: Laravel environment not properly configured\n";
            $testsFailed++;
        }
    } catch (Exception $e) {
        echo "❌ Test 4: Laravel environment error - {$e->getMessage()}\n";
        $testsFailed++;
    }

    // Test 5: File system check
    $requiredFiles = [
        'composer.json',
        'package.json',
        'artisan',
        'README.md',
        'requirements.txt'
    ];

    $filesExist = 0;
    foreach ($requiredFiles as $file) {
        if (file_exists(__DIR__ . '/' . $file)) {
            $filesExist++;
        }
    }

    if ($filesExist === count($requiredFiles)) {
        echo "✅ Test 5: All required files present ($filesExist/" . count($requiredFiles) . ")\n";
        $testsPassed++;
    } else {
        echo "❌ Test 5: Missing files ($filesExist/" . count($requiredFiles) . " found)\n";
        $testsFailed++;
    }

    // Results summary
    echo "\n📊 Test Results:\n";
    echo "   Passed: $testsPassed\n";
    echo "   Failed: $testsFailed\n";
    echo "   Total:  " . ($testsPassed + $testsFailed) . "\n\n";

    if ($testsFailed === 0) {
        echo "🎉 All tests passed! Resumate is ready to use.\n\n";
        exit(0);
    } else {
        echo "⚠️  Some tests failed. Please check your configuration.\n\n";
        exit(1);
    }
}

function runDemo()
{
    echo "🚀 Running Resumate Demo...\n";
    echo "---------------------------\n\n";

    // Sample resume text
    $sampleResume = "
John Doe
Software Engineer

Contact Information:
Email: john.doe@email.com
Phone: +1 (555) 123-4567
LinkedIn: linkedin.com/in/johndoe

Professional Summary:
Experienced software engineer with 5+ years of expertise in full-stack development,
specializing in Laravel and React applications. Proven track record of delivering
high-quality software solutions.

Work Experience:
Senior Software Engineer | TechCorp Inc. | 2022 - Present
- Led development of microservices architecture serving 1M+ users
- Implemented CI/CD pipelines reducing deployment time by 60%
- Mentored junior developers and conducted code reviews

Software Engineer | StartupXYZ | 2020 - 2022
- Developed RESTful APIs using Laravel and Node.js
- Optimized database queries improving performance by 40%
- Collaborated with design team to implement responsive UI

Education:
Bachelor of Science in Computer Science
University of California, Berkeley | 2020
GPA: 3.8/4.0

Technical Skills:
- Programming: PHP, JavaScript, Python, Java
- Frameworks: Laravel, React, Vue.js, Node.js
- Databases: MySQL, PostgreSQL, MongoDB
- Tools: Git, Docker, AWS, Jenkins

Soft Skills:
- Problem Solving
- Team Leadership
- Communication
- Agile Development
";

    try {
        // Initialize analyzer
        $analyzer = new ResumeAnalyzer();

        echo "📄 Analyzing sample resume...\n\n";

        // Perform analysis
        $results = $analyzer->analyzeText($sampleResume);

        // Display results
        echo "📊 Analysis Results:\n";
        echo "   Word Count: {$results['word_count']}\n";
        echo "   Character Count: {$results['character_count']}\n";
        echo "   Action Verbs Found: {$results['action_verbs_count']}\n";
        echo "   Readability Score: " . number_format($results['readability_score'], 1) . "/100\n";
        echo "   Structure Score: {$results['structure_score']}/100\n";
        echo "   ATS-Friendly Score: {$results['ats_friendly_score']}/100\n\n";

        // Show keyword density
        echo "🔍 Keyword Density by Industry:\n";
        foreach ($results['keyword_density'] as $industry => $density) {
            echo "   " . ucfirst($industry) . ": " . number_format($density, 1) . "%\n";
        }
        echo "\n";

        // Generate suggestions
        $suggestions = $analyzer->generateSuggestions($results);

        if (!empty($suggestions)) {
            echo "💡 Improvement Suggestions:\n";
            foreach ($suggestions as $suggestion) {
                echo "   • $suggestion\n";
            }
            echo "\n";
        }

        // Extract contact info
        $contact = $analyzer->extractContactInfo($sampleResume);

        echo "📞 Extracted Contact Information:\n";
        echo "   Email: " . ($contact['email'] ?? 'Not found') . "\n";
        echo "   Phone: " . ($contact['phone'] ?? 'Not found') . "\n";
        echo "   LinkedIn: " . ($contact['linkedin'] ?? 'Not found') . "\n\n";

        echo "🎉 Demo completed successfully!\n\n";
        echo "💡 Try uploading a real resume through the web interface for AI-powered analysis!\n\n";

    } catch (Exception $e) {
        echo "❌ Demo failed: {$e->getMessage()}\n\n";
        echo "💡 Make sure all dependencies are installed and configured.\n\n";
        exit(1);
    }
}

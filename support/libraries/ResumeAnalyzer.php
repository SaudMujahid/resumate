<?php

/**
 * Resumate Resume Analyzer Utility Library
 *
 * This utility class provides helper methods for resume analysis,
 * text processing, and AI integration features.
 *
 * Usage:
 * $analyzer = new ResumeAnalyzer();
 * $results = $analyzer->analyzeText($resumeText);
 */

class ResumeAnalyzer
{
    /**
     * Keywords commonly found in successful resumes by industry
     */
    private const INDUSTRY_KEYWORDS = [
        'technology' => [
            'javascript', 'python', 'java', 'php', 'laravel', 'react', 'vue', 'node.js',
            'sql', 'mysql', 'postgresql', 'mongodb', 'git', 'docker', 'kubernetes',
            'aws', 'azure', 'linux', 'agile', 'scrum', 'ci/cd', 'api', 'rest'
        ],
        'business' => [
            'excel', 'powerpoint', 'word', 'outlook', 'crm', 'erp', 'sap', 'salesforce',
            'financial analysis', 'budgeting', 'forecasting', 'data analysis', 'reporting'
        ],
        'design' => [
            'photoshop', 'illustrator', 'figma', 'sketch', 'adobe', 'ui/ux', 'wireframing',
            'prototyping', 'user research', 'usability testing', 'responsive design'
        ],
        'marketing' => [
            'seo', 'sem', 'social media', 'content marketing', 'google analytics',
            'facebook ads', 'instagram', 'linkedin', 'brand management', 'campaign'
        ]
    ];

    /**
     * Action verbs that strengthen resume impact
     */
    private const ACTION_VERBS = [
        'achieved', 'improved', 'created', 'developed', 'implemented', 'designed',
        'managed', 'led', 'coordinated', 'established', 'increased', 'reduced',
        'optimized', 'streamlined', 'transformed', 'launched', 'delivered', 'executed'
    ];

    /**
     * Analyze text content for resume quality metrics
     *
     * @param string $text Resume text content
     * @return array Analysis results
     */
    public function analyzeText(string $text): array
    {
        $results = [
            'word_count' => $this->countWords($text),
            'character_count' => strlen($text),
            'keyword_density' => $this->calculateKeywordDensity($text),
            'action_verbs_count' => $this->countActionVerbs($text),
            'readability_score' => $this->calculateReadability($text),
            'structure_score' => $this->analyzeStructure($text),
            'ats_friendly_score' => $this->checkATSFriendliness($text)
        ];

        return $results;
    }

    /**
     * Count total words in text
     */
    private function countWords(string $text): int
    {
        return str_word_count(strip_tags($text));
    }

    /**
     * Calculate keyword density for different industries
     */
    private function calculateKeywordDensity(string $text): array
    {
        $text = strtolower($text);
        $density = [];

        foreach (self::INDUSTRY_KEYWORDS as $industry => $keywords) {
            $industryMatches = 0;
            $totalKeywords = count($keywords);

            foreach ($keywords as $keyword) {
                if (strpos($text, strtolower($keyword)) !== false) {
                    $industryMatches++;
                }
            }

            $density[$industry] = $totalKeywords > 0 ? ($industryMatches / $totalKeywords) * 100 : 0;
        }

        return $density;
    }

    /**
     * Count action verbs in the text
     */
    private function countActionVerbs(string $text): int
    {
        $text = strtolower($text);
        $count = 0;

        foreach (self::ACTION_VERBS as $verb) {
            $count += substr_count($text, $verb);
        }

        return $count;
    }

    /**
     * Calculate basic readability score
     * (Simplified Flesch Reading Ease approximation)
     */
    private function calculateReadability(string $text): float
    {
        $sentences = $this->countSentences($text);
        $words = $this->countWords($text);
        $syllables = $this->countSyllables($text);

        if ($sentences === 0 || $words === 0) {
            return 0;
        }

        // Simplified readability formula
        $score = 206.835 - (1.015 * ($words / $sentences)) - (84.6 * ($syllables / $words));

        // Normalize to 0-100 scale
        return max(0, min(100, $score));
    }

    /**
     * Count sentences in text
     */
    private function countSentences(string $text): int
    {
        return preg_match_all('/[.!?]+/', $text, $matches);
    }

    /**
     * Count syllables (simplified approximation)
     */
    private function countSyllables(string $text): int
    {
        $text = strtolower($text);
        $vowels = ['a', 'e', 'i', 'o', 'u', 'y'];
        $syllables = 0;

        $words = str_word_count($text, 1);

        foreach ($words as $word) {
            $wordSyllables = 0;
            $previousWasVowel = false;

            foreach (str_split($word) as $char) {
                $isVowel = in_array($char, $vowels);

                if ($isVowel && !$previousWasVowel) {
                    $wordSyllables++;
                }

                $previousWasVowel = $isVowel;
            }

            // Ensure at least one syllable per word
            $syllables += max(1, $wordSyllables);
        }

        return $syllables;
    }

    /**
     * Analyze resume structure quality
     */
    private function analyzeStructure(string $text): int
    {
        $score = 0;
        $text = strtolower($text);

        // Check for common resume sections
        $sections = [
            'experience', 'education', 'skills', 'summary', 'objective',
            'projects', 'certifications', 'achievements', 'contact'
        ];

        foreach ($sections as $section) {
            if (strpos($text, $section) !== false) {
                $score += 10;
            }
        }

        // Check for formatting indicators
        if (preg_match('/\b\d{4}\b/', $text)) $score += 10; // Years
        if (preg_match('/@/i', $text)) $score += 5; // Email
        if (preg_match('/\+?\d/', $text)) $score += 5; // Phone

        return min(100, $score);
    }

    /**
     * Check ATS (Applicant Tracking System) friendliness
     */
    private function checkATSFriendliness(string $text): int
    {
        $score = 100; // Start with perfect score
        $issues = 0;

        // Check for ATS-unfriendly elements
        if (preg_match('/[^\x20-\x7E]/', $text)) $issues += 20; // Non-ASCII characters
        if (preg_match('/^(.*?)$/m', $text, $matches) && strlen($matches[1] ?? '') > 100) $issues += 10; // Very long lines
        if (!preg_match('/\b\d{4}\b/', $text)) $issues += 15; // No years/dates
        if (!preg_match('/(experience|employment|work)/i', $text)) $issues += 20; // No work section

        // Check for keyword stuffing (simplified)
        $words = str_word_count($text, 1);
        $wordCount = count($words);
        $uniqueWords = count(array_unique($words));

        if ($wordCount > 0 && ($uniqueWords / $wordCount) < 0.3) {
            $issues += 15; // Low word diversity
        }

        return max(0, $score - $issues);
    }

    /**
     * Generate improvement suggestions based on analysis
     */
    public function generateSuggestions(array $analysis): array
    {
        $suggestions = [];

        // Word count suggestions
        if ($analysis['word_count'] < 200) {
            $suggestions[] = "Consider adding more detailed descriptions of your experience and achievements.";
        } elseif ($analysis['word_count'] > 800) {
            $suggestions[] = "Your resume might be too long. Consider condensing some sections.";
        }

        // Action verbs suggestions
        if ($analysis['action_verbs_count'] < 5) {
            $suggestions[] = "Use more action verbs (achieved, implemented, created) to make your accomplishments more impactful.";
        }

        // Readability suggestions
        if ($analysis['readability_score'] < 50) {
            $suggestions[] = "Improve readability by using shorter sentences and simpler language.";
        }

        // Structure suggestions
        if ($analysis['structure_score'] < 50) {
            $suggestions[] = "Ensure your resume has clear sections (Experience, Education, Skills) with proper headings.";
        }

        // ATS suggestions
        if ($analysis['ats_friendly_score'] < 70) {
            $suggestions[] = "Make your resume more ATS-friendly by including standard section headers and avoiding complex formatting.";
        }

        // Keyword suggestions
        $maxDensity = max($analysis['keyword_density']);
        if ($maxDensity < 20) {
            $suggestions[] = "Include more industry-specific keywords relevant to your target job roles.";
        }

        return $suggestions;
    }

    /**
     * Extract contact information from resume text
     */
    public function extractContactInfo(string $text): array
    {
        $contact = [
            'email' => null,
            'phone' => null,
            'linkedin' => null,
            'website' => null
        ];

        // Extract email
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $text, $matches)) {
            $contact['email'] = $matches[0];
        }

        // Extract phone (basic pattern)
        if (preg_match('/\+?[\d\s\-\(\)]{10,}/', $text, $matches)) {
            $contact['phone'] = trim($matches[0]);
        }

        // Extract LinkedIn
        if (preg_match('/linkedin\.com\/in\/[a-zA-Z0-9\-_]+/i', $text, $matches)) {
            $contact['linkedin'] = $matches[0];
        }

        // Extract website
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(?:\/[^\s]*)?/', $text, $matches)) {
            $contact['website'] = $matches[0];
        }

        return $contact;
    }
}

/*
 * Usage Examples:
 *
 * $analyzer = new ResumeAnalyzer();
 *
 * // Analyze resume text
 * $results = $analyzer->analyzeText($resumeText);
 * echo "Word count: " . $results['word_count'];
 *
 * // Get improvement suggestions
 * $suggestions = $analyzer->generateSuggestions($results);
 * foreach ($suggestions as $suggestion) {
 *     echo "- $suggestion\n";
 * }
 *
 * // Extract contact information
 * $contact = $analyzer->extractContactInfo($resumeText);
 * echo "Email: " . ($contact['email'] ?? 'Not found');
 */

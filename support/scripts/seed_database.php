<?php

/**
 * Resumate Database Seeder Script
 *
 * This script populates the database with sample data for testing and development.
 * Run this script after setting up your database configuration.
 *
 * Usage: php support/scripts/seed_database.php
 */

// Include Laravel's autoloader
require_once __DIR__ . '/../../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "🌱 Starting database seeding...\n";
echo "==================================\n\n";

// Clear existing data (optional - uncomment if needed)
// DB::statement('SET FOREIGN_KEY_CHECKS=0;');
// DB::table('users')->truncate();
// DB::statement('SET FOREIGN_KEY_CHECKS=1;');

try {
    // =============================================================================
    // CREATE SAMPLE USERS
    // =============================================================================

    echo "👤 Creating sample users...\n";

    $users = [
        [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Jane Smith',
            'email' => 'jane.smith@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    foreach ($users as $userData) {
        // Check if user already exists
        $existingUser = User::where('email', $userData['email'])->first();

        if (!$existingUser) {
            User::create($userData);
            echo "  ✅ Created user: {$userData['email']}\n";
        } else {
            echo "  ⚠️  User already exists: {$userData['email']}\n";
        }
    }

    // =============================================================================
    // CREATE SAMPLE RESUME DATA
    // =============================================================================

    echo "\n📄 Creating sample resume data...\n";

    // Load sample data from JSON file
    $sampleDataPath = __DIR__ . '/../data/sample_resume_data.json';

    if (file_exists($sampleDataPath)) {
        $sampleData = json_decode(file_get_contents($sampleDataPath), true);

        if (isset($sampleData['sample_resumes'])) {
            foreach ($sampleData['sample_resumes'] as $resumeData) {
                // Here you would typically save to resume_builders table
                // For now, we'll just show that we can load the data
                echo "  📋 Loaded resume for: {$resumeData['name']} ({$resumeData['title']})\n";
            }
        }
    } else {
        echo "  ⚠️  Sample data file not found: $sampleDataPath\n";
    }

    // =============================================================================
    // SEEDING COMPLETE
    // =============================================================================

    echo "\n🎉 Database seeding completed successfully!\n";
    echo "==================================\n\n";

    echo "Sample accounts created:\n";
    echo "• john.doe@example.com (password: password123)\n";
    echo "• jane.smith@example.com (password: password123)\n";
    echo "• bob.johnson@example.com (password: password123)\n\n";

    echo "Next steps:\n";
    echo "1. Start the development server: php artisan serve\n";
    echo "2. Visit http://localhost:8000\n";
    echo "3. Login with any of the sample accounts above\n\n";

} catch (Exception $e) {
    echo "\n❌ Error during database seeding:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n\n";

    echo "Troubleshooting:\n";
    echo "1. Make sure your database is configured correctly in .env\n";
    echo "2. Run 'php artisan migrate' first if tables don't exist\n";
    echo "3. Check database connection and permissions\n\n";

    exit(1);
}

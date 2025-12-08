#!/bin/bash

# =============================================================================
# Resumate - AI-Powered Resume Builder
# Automated Setup Script
# =============================================================================

echo "🚀 Starting Resumate Setup..."
echo "================================="

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to print status messages
print_status() {
    echo "✅ $1"
}

print_error() {
    echo "❌ $1"
}

print_warning() {
    echo "⚠️  $1"
}

# =============================================================================
# SYSTEM REQUIREMENTS CHECK
# =============================================================================

echo "🔍 Checking system requirements..."

# Check PHP
if command_exists php; then
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    if php -r "echo version_compare(PHP_VERSION, '8.2.0', '>=') ? 'yes' : 'no';"; then
        print_status "PHP $PHP_VERSION - OK"
    else
        print_error "PHP version must be 8.2.0 or higher. Current: $PHP_VERSION"
        exit 1
    fi
else
    print_error "PHP is not installed. Please install PHP 8.2+ first."
    exit 1
fi

# Check Composer
if command_exists composer; then
    print_status "Composer - OK"
else
    print_error "Composer is not installed. Please install Composer first."
    exit 1
fi

# Check Node.js
if command_exists node; then
    NODE_VERSION=$(node -v)
    print_status "Node.js $NODE_VERSION - OK"
else
    print_error "Node.js is not installed. Please install Node.js 18+ first."
    exit 1
fi

# Check npm
if command_exists npm; then
    NPM_VERSION=$(npm -v)
    print_status "npm $NPM_VERSION - OK"
else
    print_error "npm is not installed. Please install npm first."
    exit 1
fi

# Check Git
if command_exists git; then
    print_status "Git - OK"
else
    print_warning "Git is not installed. Some features may not work properly."
fi

echo ""

# =============================================================================
# PROJECT SETUP
# =============================================================================

echo "📦 Setting up project dependencies..."

# Install PHP dependencies
echo "Installing PHP dependencies..."
if composer install --no-interaction --optimize-autoloader; then
    print_status "PHP dependencies installed"
else
    print_error "Failed to install PHP dependencies"
    exit 1
fi

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
if npm install; then
    print_status "Node.js dependencies installed"
else
    print_error "Failed to install Node.js dependencies"
    exit 1
fi

echo ""

# =============================================================================
# ENVIRONMENT SETUP
# =============================================================================

echo "⚙️  Setting up environment..."

# Copy environment file
if [ ! -f .env ]; then
    if cp .env.example .env; then
        print_status "Environment file created"
    else
        print_error "Failed to create environment file"
        exit 1
    fi
else
    print_warning "Environment file already exists"
fi

# Generate application key
echo "Generating application key..."
if php artisan key:generate --no-interaction; then
    print_status "Application key generated"
else
    print_error "Failed to generate application key"
    exit 1
fi

echo ""

# =============================================================================
# DATABASE SETUP
# =============================================================================

echo "🗄️  Setting up database..."

# Run migrations
echo "Running database migrations..."
if php artisan migrate --force --no-interaction; then
    print_status "Database migrations completed"
else
    print_warning "Database setup skipped (check your .env configuration)"
fi

echo ""

# =============================================================================
# BUILD ASSETS
# =============================================================================

echo "🔨 Building frontend assets..."

# Build assets for production
if npm run build; then
    print_status "Frontend assets built successfully"
else
    print_error "Failed to build frontend assets"
    exit 1
fi

echo ""

# =============================================================================
# FINAL STEPS
# =============================================================================

echo "🎉 Setup completed successfully!"
echo "================================="
echo ""
echo "Next steps:"
echo "1. Configure your database settings in .env file"
echo "2. Add your Google Gemini API key to .env file:"
echo "   GEMINI_API_KEY=your_api_key_here"
echo "3. Start the development server:"
echo "   php artisan serve"
echo ""
echo "For development with hot reloading:"
echo "  npm run dev"
echo ""
echo "Happy coding! 🚀"

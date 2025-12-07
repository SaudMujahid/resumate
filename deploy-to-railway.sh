#!/bin/bash

# Railway Deployment Script for Resumate
# Run this script to deploy your Laravel app to Railway

echo "🚀 Deploying Resumate to Railway..."
echo ""

# Check if Railway CLI is installed
if ! command -v railway &> /dev/null; then
    echo "❌ Railway CLI is not installed. Please install it first:"
    echo "curl -fsSL https://railway.app/install.sh | sh"
    exit 1
fi

# Check if user is logged in to Railway
if ! railway whoami &> /dev/null; then
    echo "❌ You are not logged in to Railway. Please run:"
    echo "railway login"
    exit 1
fi

# Check if we're in a git repository
if ! git rev-parse --git-dir > /dev/null 2>&1; then
    echo "❌ This is not a git repository. Please initialize git and push to a remote repository first."
    exit 1
fi

echo "✅ Prerequisites check passed"
echo ""

# Create Railway project
echo "📦 Creating Railway project..."
railway init resumate --source .

# Link to the project (if it was created)
railway link

# Set environment variables
echo "🔧 Setting environment variables..."

# Read environment variables from railway-env-example.txt and set them
if [ -f "railway-env-example.txt" ]; then
    echo "Setting environment variables from railway-env-example.txt..."
    # Note: You'll need to manually set these in the Railway dashboard
    # as the CLI doesn't support setting all variables at once easily
    echo "⚠️  Please manually set environment variables in Railway dashboard"
    echo "   Copy them from: railway-env-example.txt"
else
    echo "❌ railway-env-example.txt not found"
    exit 1
fi

# Deploy
echo "🚀 Deploying to Railway..."
railway deploy

echo ""
echo "✅ Deployment initiated!"
echo ""
echo "📋 Next steps:"
echo "1. Go to https://railway.app/dashboard"
echo "2. Select your project"
echo "3. Set environment variables in the Variables tab"
echo "4. Wait for deployment to complete"
echo "5. Visit your app URL"
echo ""
echo "📖 See DEPLOYMENT.md for detailed instructions"

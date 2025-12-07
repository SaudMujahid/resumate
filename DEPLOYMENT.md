# Railway Deployment Guide

This guide will help you deploy the Resumate Laravel application to Railway.app.

## Prerequisites

1. A Railway account (https://railway.app)
2. Railway CLI installed (optional, but recommended)
3. Git repository pushed to GitHub/GitLab/Bitbucket

## Deployment Steps

### 1. Create a Railway Project

1. Go to https://railway.app and sign in
2. Click "New Project"
3. Choose "Deploy from GitHub" (or your preferred Git provider)
4. Select your repository containing this Laravel app
5. Railway will automatically detect it's a Laravel app and start deployment

### 2. Configure Environment Variables

In your Railway project dashboard:

1. Go to the "Variables" tab
2. Add the following environment variables (copy from `railway-env-example.txt`):

```
APP_NAME=Resumate
APP_ENV=production
APP_KEY=base64:3p1utKoVLEM1sPNBb5s9jyY1QA/odXRh2CWkGPm8lbA=
APP_DEBUG=false
APP_URL=${{RAILWAY_STATIC_URL}}

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@resumate.app"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

### 3. Database Setup

Railway automatically provisions a MySQL database for your project. The environment variables above will automatically connect to it.

### 4. Deploy

1. Push your code to your Git repository
2. Railway will automatically start building and deploying
3. The build process will:
   - Install PHP dependencies with Composer
   - Cache Laravel configurations
   - Install Node.js dependencies
   - Build frontend assets
   - Run database migrations
   - Start the Laravel server

### 5. Verify Deployment

1. Once deployment is complete, Railway will provide a URL (e.g., `https://resumate-production.up.railway.app`)
2. Visit the URL to verify your application is running
3. Check the Railway logs if there are any issues

## Troubleshooting

### Common Issues

1. **Database Connection Issues**: Make sure the PostgreSQL database is attached to your service in Railway
2. **Build Failures**: Check that all dependencies are properly specified in `composer.json`
3. **Environment Variables**: Ensure all required environment variables are set correctly
4. **Storage Permissions**: Laravel may need write permissions for storage directories

### Checking Logs

- Go to your Railway project dashboard
- Click on your service
- Go to the "Logs" tab to see build and runtime logs

### Useful Commands

If you need to run Laravel commands after deployment:

```bash
# Via Railway CLI
railway run php artisan migrate:status
railway run php artisan cache:clear

# Or connect to your database
railway connect
```

## Post-Deployment Tasks

1. **Update APP_URL**: Replace the APP_URL in environment variables with your actual Railway URL
2. **Set up Domain**: If you have a custom domain, configure it in Railway
3. **SSL Certificate**: Railway provides automatic SSL certificates
4. **Monitoring**: Set up monitoring and alerts as needed

## File Structure

The following files have been configured for Railway deployment:

- `railway.json`: Railway-specific configuration
- `nixpacks.toml`: Nixpacks build configuration
- `railway-env-example.txt`: Example environment variables

## Support

If you encounter issues:

1. Check Railway documentation: https://docs.railway.app/
2. Check Laravel deployment docs: https://laravel.com/docs/deployment
3. Review the logs in your Railway dashboard

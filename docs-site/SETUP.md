# Documentation Site Setup Guide

This guide will help you set up and deploy the documentation site to GitHub Pages.

## Prerequisites

- Node.js 20+ and npm
- PHP 8.2+ and Composer
- Git and GitHub account

## Local Development

1. **Install Dependencies**

   ```bash
   cd docs-site
   npm install
   composer install
   ```

2. **Build the Site**

   ```bash
   # Build HTML from Blade templates
   php build.php
   
   # Build CSS and JS assets
   npm run build
   ```

3. **Preview Locally**

   ```bash
   npm run preview
   ```

   This will start a local server where you can preview the built site.

## GitHub Pages Setup

1. **Enable GitHub Pages**

   - Go to your repository settings on GitHub (Settings → Pages)
   - Under "Source", select **"GitHub Actions"** (not "Deploy from a branch")
   - If you don't see "GitHub Actions" as an option, you may need to:
     - Make sure you have push access to the repository
     - Wait a few minutes after creating the repository
     - Try refreshing the page
   - The workflow will automatically build and deploy when you push to the main branch

2. **Verify Pages is Enabled**

   - After enabling, you should see a "GitHub Actions" badge or indicator in the Pages settings
   - The first deployment may take a few minutes to complete
   - Check the "Actions" tab to see the build progress

2. **Custom Domain (Optional)**

   - In the Pages settings, you can add a custom domain
   - Add a `CNAME` file in the `docs-site/source` directory with your domain name

## Manual Deployment

If you want to deploy manually:

1. Build the site:
   ```bash
   cd docs-site
   php build.php
   npm run build
   ```

2. The built files will be in `docs-site/build_local/`

3. You can then push the `build_local` directory to a `gh-pages` branch or use any static hosting service.

## Adding New Pages

1. Create a new Blade template in `docs-site/source/docs/your-page.blade.php`
2. Add the route to `docs-site/build.php` in the `$routes` array
3. Add a navigation link in `docs-site/source/_layouts/master.blade.php`
4. Build and deploy

## Structure

```
docs-site/
├── source/              # Source files
│   ├── _layouts/        # Layout templates
│   ├── docs/            # Documentation pages
│   └── resources/       # CSS and JS
├── build_local/         # Built static files (gitignored)
├── build.php            # PHP build script
├── package.json         # Node.js dependencies
├── composer.json        # PHP dependencies
└── vite.config.js       # Vite configuration
```

## Troubleshooting

### Build Errors

- Make sure all dependencies are installed: `npm install` and `composer install`
- Check PHP version: `php -v` (should be 8.2+)
- Check Node version: `node -v` (should be 20+)

### GitHub Actions Failures

- Check the Actions tab in your GitHub repository
- Ensure GitHub Pages is enabled in repository settings
- Verify the workflow file is in `.github/workflows/docs.yml`

### Assets Not Loading

- Make sure `npm run build` is run after `php build.php`
- Check that assets are in `build_local/assets/`
- Verify asset paths in the HTML are correct (`/assets/app.css`, etc.)


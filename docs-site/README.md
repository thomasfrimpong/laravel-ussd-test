# Documentation Site

This directory contains the documentation site for Laravel USSD package.

## Development

1. Install dependencies:
   ```bash
   npm install
   composer install
   ```

2. Build the site:
   ```bash
   php build.php
   npm run build
   ```

3. Preview locally:
   ```bash
   npm run preview
   ```

## Structure

- `source/` - Source files (Blade templates, CSS, JS)
- `build_local/` - Built static files (gitignored)
- `build.php` - PHP build script for processing Blade templates

## Deployment

The site is automatically built and deployed to GitHub Pages via GitHub Actions when changes are pushed to the main branch.


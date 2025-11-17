# GitHub Pages Setup Instructions

If you're getting the error "Get Pages site failed", follow these steps to enable GitHub Pages:

## Step-by-Step Setup

1. **Navigate to Repository Settings**
   - Go to your GitHub repository
   - Click on **Settings** (top menu bar)
   - Scroll down to **Pages** in the left sidebar

2. **Configure Pages Source**
   - Under "Source", you should see options like:
     - Deploy from a branch
     - GitHub Actions
   - **Select "GitHub Actions"** (this is required for our workflow)

3. **If "GitHub Actions" Option is Not Available**
   - Make sure you have admin/write access to the repository
   - The repository must not be archived
   - Try refreshing the page or waiting a few minutes
   - Some repositories may need to be public or have GitHub Actions enabled first

4. **Enable GitHub Actions (if needed)**
   - Go to Settings → Actions → General
   - Under "Workflow permissions", select:
     - "Read and write permissions"
     - "Allow GitHub Actions to create and approve pull requests" (optional)
   - Click "Save"

5. **Verify the Workflow**
   - Go to the **Actions** tab in your repository
   - You should see the "Build and Deploy Documentation" workflow
   - If it's not running, try pushing a commit to trigger it

6. **Check Deployment Status**
   - After the workflow runs successfully, go back to Settings → Pages
   - You should see a green checkmark and your site URL
   - The URL will be: `https://your-username.github.io/laravel-ussd-test/`

## Troubleshooting

### Error: "Get Pages site failed"
- **Solution**: Make sure you've selected "GitHub Actions" as the source in Pages settings
- Wait a few minutes after enabling and try again

### Error: "Not Found" when accessing the site
- **Solution**: 
  - Check the Actions tab to ensure the workflow completed successfully
  - Wait 5-10 minutes after deployment (GitHub Pages can take time to propagate)
  - Clear your browser cache

### Workflow Fails to Run
- **Solution**:
  - Check that the workflow file is in `.github/workflows/docs.yml`
  - Ensure the file has proper YAML syntax
  - Check the Actions tab for error messages

### Pages Shows "Not yet published"
- **Solution**:
  - Make sure the workflow has run at least once
  - Check that the build completed successfully
  - Verify the artifact was uploaded correctly

## Manual Alternative

If GitHub Actions deployment doesn't work, you can manually deploy:

1. Build the site locally:
   ```bash
   cd docs-site
   php build.php
   npm run build
   ```

2. Push the `build_local` directory to a `gh-pages` branch:
   ```bash
   git checkout --orphan gh-pages
   git rm -rf .
   cp -r docs-site/build_local/* .
   git add .
   git commit -m "Deploy documentation"
   git push origin gh-pages
   ```

3. In Pages settings, select "Deploy from a branch" and choose `gh-pages`


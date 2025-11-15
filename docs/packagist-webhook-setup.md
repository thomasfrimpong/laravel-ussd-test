# Packagist Auto-Update Webhook Setup

This guide explains how to set up automatic Packagist updates when you push changes to your GitHub repository.

## Method 1: Using Packagist Webhook (Recommended)

### Step 1: Get Your Packagist Webhook URL

1. Go to your package page on Packagist: https://packagist.org/packages/catalysteria/laravel-ussd
2. Click on **"Settings"** or look for the **"Update"** button
3. You'll see a webhook URL that looks like:
   ```
   https://packagist.org/api/update-package?username=YOUR_USERNAME&apiToken=YOUR_TOKEN
   ```
4. Copy this URL (you'll need it for Step 2)

### Step 2: Configure GitHub Webhook

1. Go to your GitHub repository: https://github.com/thomasfrimpong/laravel-ussd-test
2. Click on **Settings** → **Webhooks** → **Add webhook**
3. Fill in the webhook configuration:
   - **Payload URL**: Paste the Packagist webhook URL from Step 1
   - **Content type**: Select `application/json`
   - **Which events would you like to trigger this webhook?**: Select **"Just the push event"**
   - **Active**: Check the box
4. Click **"Add webhook"**

### Step 3: Test the Webhook

1. Make a small change to your repository (e.g., update README)
2. Commit and push the change
3. Go to GitHub repository → **Settings** → **Webhooks**
4. Click on your webhook to see recent deliveries
5. Check Packagist - it should automatically update within a few minutes

## Method 2: Using GitHub Actions (Alternative)

If you prefer using GitHub Actions, you can create a workflow that triggers Packagist updates.

### Create GitHub Actions Workflow

Create a file: `.github/workflows/packagist-update.yml`

```yaml
name: Update Packagist

on:
  push:
    branches:
      - initial-commit  # or your main branch
    tags:
      - 'v*'  # Trigger on version tags

jobs:
  update-packagist:
    runs-on: ubuntu-latest
    steps:
      - name: Update Packagist
        run: |
          curl -X POST https://packagist.org/api/update-package?username=${{ secrets.PACKAGIST_USERNAME }}&apiToken=${{ secrets.PACKAGIST_API_TOKEN }}
        env:
          PACKAGIST_USERNAME: ${{ secrets.PACKAGIST_USERNAME }}
          PACKAGIST_API_TOKEN: ${{ secrets.PACKAGIST_API_TOKEN }}
```

### Configure GitHub Secrets

1. Go to your GitHub repository → **Settings** → **Secrets and variables** → **Actions**
2. Click **"New repository secret"**
3. Add two secrets:
   - `PACKAGIST_USERNAME`: Your Packagist username
   - `PACKAGIST_API_TOKEN`: Your Packagist API token

### Get Your Packagist API Token

1. Go to Packagist: https://packagist.org/profile/
2. Click on **"Show API Token"**
3. Copy the token

## Method 3: Manual Update Script

You can also create a simple script to manually trigger updates:

### Create `scripts/update-packagist.sh`

```bash
#!/bin/bash

# Update Packagist package
curl -X POST "https://packagist.org/api/update-package?username=YOUR_USERNAME&apiToken=YOUR_TOKEN"

echo "Packagist update triggered!"
```

Make it executable:
```bash
chmod +x scripts/update-packagist.sh
```

## Troubleshooting

### Webhook Not Working?

1. **Check webhook deliveries**: GitHub → Settings → Webhooks → Click your webhook
2. **Verify URL**: Make sure the Packagist webhook URL is correct
3. **Check Packagist logs**: Look for any error messages on Packagist
4. **Test manually**: Try clicking "Update" button on Packagist to verify the URL works

### GitHub Actions Not Triggering?

1. **Check workflow runs**: GitHub → Actions tab
2. **Verify secrets**: Make sure `PACKAGIST_USERNAME` and `PACKAGIST_API_TOKEN` are set
3. **Check branch name**: Ensure the workflow triggers on your branch name

## Security Notes

- **Never commit API tokens** to your repository
- Use GitHub Secrets for sensitive information
- The webhook URL contains your API token - keep it private
- Consider using a read-only API token if possible

## Additional Resources

- [Packagist API Documentation](https://packagist.org/apidoc)
- [GitHub Webhooks Documentation](https://docs.github.com/en/developers/webhooks-and-events/webhooks)
- [GitHub Actions Documentation](https://docs.github.com/en/actions)


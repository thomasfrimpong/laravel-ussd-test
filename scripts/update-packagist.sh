#!/bin/bash

# Script to manually trigger Packagist update
# Usage: ./scripts/update-packagist.sh

# Configuration
PACKAGIST_USERNAME="${PACKAGIST_USERNAME:-}"
PACKAGIST_API_TOKEN="${PACKAGIST_API_TOKEN:-}"

# Check if credentials are provided
if [ -z "$PACKAGIST_USERNAME" ] || [ -z "$PACKAGIST_API_TOKEN" ]; then
    echo "Error: PACKAGIST_USERNAME and PACKAGIST_API_TOKEN must be set"
    echo "Usage: PACKAGIST_USERNAME=your_username PACKAGIST_API_TOKEN=your_token ./scripts/update-packagist.sh"
    exit 1
fi

# Update Packagist package
echo "Triggering Packagist update..."
RESPONSE=$(curl -s -w "\n%{http_code}" -X POST "https://packagist.org/api/update-package?username=${PACKAGIST_USERNAME}&apiToken=${PACKAGIST_API_TOKEN}")

HTTP_CODE=$(echo "$RESPONSE" | tail -n1)
BODY=$(echo "$RESPONSE" | sed '$d')

if [ "$HTTP_CODE" -eq 200 ]; then
    echo "✓ Packagist update triggered successfully!"
    echo "Response: $BODY"
else
    echo "✗ Failed to trigger Packagist update"
    echo "HTTP Code: $HTTP_CODE"
    echo "Response: $BODY"
    exit 1
fi


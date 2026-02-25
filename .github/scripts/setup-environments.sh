#!/bin/bash
set -e

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}Setting up GitHub environments and variables...${NC}"

# Check if gh CLI is installed
if ! command -v gh &> /dev/null; then
    echo "Error: GitHub CLI (gh) is not installed"
    echo "Install it from: https://cli.github.com/"
    exit 1
fi

# Check if authenticated
if ! gh auth status &> /dev/null; then
    echo "Error: Not authenticated with GitHub CLI"
    echo "Run: gh auth login"
    exit 1
fi

# Get repository info
REPO=$(gh repo view --json nameWithOwner -q .nameWithOwner)
echo -e "${GREEN}Repository: ${REPO}${NC}"

# Create 'gh' environment (GitHub Pages)
echo -e "${BLUE}Creating 'gh' environment...${NC}"
gh api \
  --method PUT \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/gh" \
  -f wait_timer=0 \
  -F prevent_self_review=false \
  -F reviewers='[]' \
  -F deployment_branch_policy='{"protected_branches":false,"custom_branch_policies":true}' \
  || echo "Environment 'gh' may already exist"

# Create 'aws' environment
echo -e "${BLUE}Creating 'aws' environment...${NC}"
gh api \
  --method PUT \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws" \
  -f wait_timer=0 \
  -F prevent_self_review=false \
  -F reviewers='[]' \
  -F deployment_branch_policy='{"protected_branches":false,"custom_branch_policies":true}' \
  || echo "Environment 'aws' may already exist"

# Set variables for AWS environment
echo -e "${BLUE}Setting AWS environment variables...${NC}"

# Prompt for AWS variables
read -p "Enter AWS Site URL (e.g., https://pauseurbaine.com): " AWS_SITE_URL
read -p "Enter AWS Base URL (e.g., https://pauseurbaine.com/): " AWS_BASE_URL

# Set AWS_SITE_URL variable
gh api \
  --method POST \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables" \
  -f name='AWS_SITE_URL' \
  -f value="${AWS_SITE_URL}" \
  2>/dev/null || \
gh api \
  --method PATCH \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables/AWS_SITE_URL" \
  -f name='AWS_SITE_URL' \
  -f value="${AWS_SITE_URL}"

echo -e "${GREEN}✓ Set AWS_SITE_URL=${AWS_SITE_URL}${NC}"

# Set AWS_BASE_URL variable
gh api \
  --method POST \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables" \
  -f name='AWS_BASE_URL' \
  -f value="${AWS_BASE_URL}" \
  2>/dev/null || \
gh api \
  --method PATCH \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables/AWS_BASE_URL" \
  -f name='AWS_BASE_URL' \
  -f value="${AWS_BASE_URL}"

echo -e "${GREEN}✓ Set AWS_BASE_URL=${AWS_BASE_URL}${NC}"

echo -e "${GREEN}✓ Environment setup complete!${NC}"
echo ""
echo "Environments created:"
echo "  - gh (GitHub Pages) - auto-deploys on push to main"
echo "  - aws (AWS) - manual deployment via workflow_dispatch"
echo ""
echo "To deploy to AWS, run:"
echo "  gh workflow run deploy.yml -f environment=aws"

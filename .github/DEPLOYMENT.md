# Deployment Guide

This project supports deployment to multiple environments with environment-specific configurations.

## Environments

### GitHub Pages (gh)
- **Auto-deploys**: On every push to `main` branch
- **URL**: Automatically configured by GitHub Pages
- **Use case**: Development/staging environment

### AWS (aws)
- **Manual deploy**: Via workflow dispatch
- **URL**: Configured via environment variables
- **Use case**: Production environment

## Initial Setup

### 1. Install GitHub CLI

```bash
# macOS
brew install gh

# Linux
curl -fsSL https://cli.github.com/packages/githubcli-archive-keyring.gpg | sudo dd of=/usr/share/keyrings/githubcli-archive-keyring.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/githubcli-archive-keyring.gpg] https://cli.github.com/packages stable main" | sudo tee /etc/apt/sources.list.d/github-cli.list > /dev/null
sudo apt update
sudo apt install gh

# Windows
winget install --id GitHub.cli
```

### 2. Authenticate with GitHub

```bash
gh auth login
```

### 3. Run Environment Setup Script

```bash
.github/scripts/setup-environments.sh
```

This will:
- Create `gh` and `aws` environments in your repository
- Prompt for AWS configuration variables
- Set up environment-specific variables

## Manual Environment Setup

If you prefer to set up environments manually:

### Create Environments

```bash
# Get your repository name
REPO=$(gh repo view --json nameWithOwner -q .nameWithOwner)

# Create 'gh' environment
gh api \
  --method PUT \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/gh"

# Create 'aws' environment
gh api \
  --method PUT \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws"
```

### Set AWS Variables

```bash
# Set AWS_SITE_URL
gh api \
  --method POST \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables" \
  -f name='AWS_SITE_URL' \
  -f value='https://pauseurbaine.com'

# Set AWS_BASE_URL
gh api \
  --method POST \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables" \
  -f name='AWS_BASE_URL' \
  -f value='https://pauseurbaine.com/'
```

## Deployment

### Deploy to GitHub Pages (Automatic)

Simply push to the `main` branch:

```bash
git push origin main
```

### Deploy to AWS (Manual)

#### Via GitHub CLI

```bash
gh workflow run deploy.yml -f environment=aws
```

#### Via GitHub UI

1. Go to Actions tab
2. Select "Deploy Hugo Site" workflow
3. Click "Run workflow"
4. Select `aws` from the environment dropdown
5. Click "Run workflow"

## Environment Variables

### GitHub Pages (gh)
No variables needed - automatically configured by GitHub Pages.

### AWS (aws)
- `AWS_SITE_URL`: The public URL of your site (e.g., `https://pauseurbaine.com`)
- `AWS_BASE_URL`: The base URL for Hugo (e.g., `https://pauseurbaine.com/`)

## Hugo Configuration

The site uses relative URLs by default (`relativeURLs: true` in `hugo.yaml`), making it portable across different domains and paths. The `baseURL` is overridden at build time based on the target environment.

## Workflow Details

The deployment workflow (`.github/workflows/deploy.yml`) includes:

1. **Build Job**: Builds the Hugo site with environment-specific baseURL
2. **Deploy Job**: Deploys to the selected environment
   - `deploy-gh`: Deploys to GitHub Pages
   - `deploy-aws`: Prepares artifact for AWS deployment

## Adding AWS Deployment Logic

To complete the AWS deployment, update the `deploy-aws` job in `.github/workflows/deploy.yml`:

```yaml
- name: Deploy to AWS
  run: |
    # Example: Deploy to S3
    aws s3 sync ./public s3://${{ secrets.AWS_S3_BUCKET }} --delete
    
    # Example: Invalidate CloudFront cache
    aws cloudfront create-invalidation \
      --distribution-id ${{ secrets.AWS_CLOUDFRONT_ID }} \
      --paths "/*"
```

You'll need to add AWS credentials as secrets:

```bash
gh secret set AWS_ACCESS_KEY_ID
gh secret set AWS_SECRET_ACCESS_KEY
gh secret set AWS_S3_BUCKET
gh secret set AWS_CLOUDFRONT_ID
```

## Troubleshooting

### Check Environment Configuration

```bash
# List environments
gh api "/repos/$(gh repo view --json nameWithOwner -q .nameWithOwner)/environments" | jq '.environments[].name'

# View AWS environment variables
gh api "/repos/$(gh repo view --json nameWithOwner -q .nameWithOwner)/environments/aws/variables" | jq
```

### View Workflow Runs

```bash
# List recent workflow runs
gh run list --workflow=deploy.yml

# View specific run
gh run view <run-id>

# View logs
gh run view <run-id> --log
```

### Update Environment Variables

```bash
REPO=$(gh repo view --json nameWithOwner -q .nameWithOwner)

# Update AWS_SITE_URL
gh api \
  --method PATCH \
  -H "Accept: application/vnd.github+json" \
  "/repos/${REPO}/environments/aws/variables/AWS_SITE_URL" \
  -f value='https://new-url.com'
```

## Local Testing

Test the build locally with different baseURLs:

```bash
cd pause-urbaine-website

# Test with GitHub Pages URL
hugo --baseURL "https://anthony.baschen.is/pause-urbaine/"

# Test with AWS URL
hugo --baseURL "https://pauseurbaine.com/"

# Test with relative URLs (default)
hugo
```

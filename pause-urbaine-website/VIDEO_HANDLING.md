# Video File Handling Strategy

## Overview

Video files are handled differently between development (GitHub Pages) and production (AWS S3) environments due to their large file sizes.

## Storage Strategy

### ❌ NOT Stored in Git
- Video files are excluded from Git repository via `.gitignore`
- Prevents repository bloat and slow clone times
- Reduces GitHub storage usage

### ✅ GitHub Pages (Development)
- Videos are **removed** from the build during deployment
- GitHub Actions workflow strips video files before upload
- Placeholder content or empty video elements are shown
- Suitable for testing layout and functionality

### ✅ AWS S3 (Production)
- Videos are stored directly in S3 bucket
- Served via CloudFront CDN for optimal performance
- Full video functionality available to end users

## File Locations

### Local Development
```
pause-urbaine-website/
└── static/
    └── videos/
        ├── README.md (documentation)
        └── (video files - gitignored)
```

### Production S3
```
s3://pauseurbaine.com/
└── videos/
    ├── InShot_20230124_174510282_1.mp4
    └── Teste1.mp4
```

## Workflow

### Adding New Videos

1. **Upload to S3 directly** (not via Git):
   ```bash
   aws s3 cp your-video.mp4 s3://pauseurbaine.com/videos/
   ```

2. **Reference in Hugo templates**:
   ```html
   <video controls poster="/images/video-poster.jpg">
     <source src="/videos/your-video.mp4" type="video/mp4">
     Your browser does not support the video tag.
   </video>
   ```

3. **For GitHub Pages testing**, use placeholder:
   ```html
   {{ if eq (getenv "HUGO_ENVIRONMENT") "production" }}
     <video controls>
       <source src="/videos/your-video.mp4" type="video/mp4">
     </video>
   {{ else }}
     <div class="video-placeholder">
       <p>Video will be available in production</p>
     </div>
   {{ end }}
   ```

### Deployment Process

#### GitHub Pages Deployment
1. Hugo builds the site
2. GitHub Actions removes all video files from `public/` directory
3. Site deployed without videos (lightweight)

#### AWS S3 Deployment
1. Hugo builds the site
2. Videos uploaded separately to S3 (manual or via separate workflow)
3. Full site with videos served via CloudFront

## Configuration Files

### .gitignore
```gitignore
# Video files (stored in S3, not in Git)
*.mp4
*.webm
*.mov
*.avi
*.mkv
*.flv
*.wmv
```

### GitHub Actions (.github/workflows/deploy.yml)
```yaml
- name: Remove video files from GitHub Pages build
  run: |
    find pause-urbaine-website/public -type f \
      \( -name "*.mp4" -o -name "*.webm" -o -name "*.mov" \
      -o -name "*.avi" -o -name "*.mkv" -o -name "*.flv" \
      -o -name "*.wmv" \) -delete
```

## Current Videos

| Filename | Size | Location | Purpose |
|----------|------|----------|---------|
| `InShot_20230124_174510282_1.mp4` | ~XX MB | S3 only | Salon showcase |
| `Teste1.mp4` | ~XX MB | S3 only | Test video |

## Best Practices

1. **Never commit video files to Git**
   - Use `.gitignore` to prevent accidental commits
   - If accidentally committed, remove from Git history

2. **Optimize videos before upload**
   - Compress videos to reduce file size
   - Use appropriate codecs (H.264 for MP4)
   - Consider multiple quality versions

3. **Use video posters**
   - Always provide a poster image for videos
   - Improves perceived load time
   - Better user experience

4. **Test on GitHub Pages**
   - Verify layout works without videos
   - Ensure placeholders are appropriate
   - Check responsive behavior

5. **CloudFront caching**
   - Videos are cached at edge locations
   - Set appropriate cache headers
   - Consider video streaming for large files

## Troubleshooting

### Video not showing on GitHub Pages
- **Expected behavior** - videos are intentionally removed
- Test video functionality on AWS production environment

### Video not showing on AWS
- Check S3 bucket permissions
- Verify CloudFront distribution settings
- Confirm video file path in template

### Accidentally committed video to Git
```bash
# Remove from Git but keep local file
git rm --cached path/to/video.mp4

# Remove from Git history (if already pushed)
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch path/to/video.mp4" \
  --prune-empty --tag-name-filter cat -- --all
```

## Future Enhancements

- [ ] Automated video upload to S3 via GitHub Actions
- [ ] Video transcoding pipeline (multiple formats/qualities)
- [ ] Lazy loading for videos
- [ ] Video streaming support (HLS/DASH)
- [ ] Thumbnail generation from videos

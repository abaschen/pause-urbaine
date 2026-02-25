# Video Files

Video files are **NOT stored in Git** due to their large size.

## Storage Locations

### Production (AWS S3)
- Videos are stored directly in the S3 bucket
- Path: `s3://pauseurbaine.com/videos/`
- Accessible via CloudFront CDN

### Development (GitHub Pages)
- Videos are not deployed to GitHub Pages
- Placeholder content is shown instead

## Adding New Videos

1. Upload videos directly to S3:
   ```bash
   aws s3 cp your-video.mp4 s3://pauseurbaine.com/videos/
   ```

2. Reference in templates:
   ```html
   <video controls>
     <source src="/videos/your-video.mp4" type="video/mp4">
     Your browser does not support the video tag.
   </video>
   ```

## Current Videos

- `InShot_20230124_174510282_1.mp4` - Salon showcase video
- `Teste1.mp4` - Test video

## Notes

- Videos are excluded from Git via `.gitignore`
- GitHub Actions workflow excludes videos from GitHub Pages deployment
- AWS deployment includes videos from S3

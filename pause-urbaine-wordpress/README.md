# Pause Urbaine WordPress

Fresh WordPress implementation for a simple one-page Pause Urbaine site.

## Local test with Podman

Start WordPress:

```bash
podman compose up -d
```

Open:

```text
http://localhost:8080
```

During WordPress setup, choose any admin login. After setup, activate the theme:

```text
Appearance -> Themes -> Pause Urbaine Single Page
```

Optional WP-CLI install:

```bash
podman compose --profile tools run --rm wpcli wp core install --url=http://localhost:8080 --title="Pause Urbaine" --admin_user=admin --admin_password=admin --admin_email=admin@example.test --skip-email
podman compose --profile tools run --rm wpcli wp theme activate pause-urbaine-single
```

If your Podman installation uses the standalone Compose wrapper, replace `podman compose` with `podman-compose`.

## Content model

- Articles: normal WordPress Posts. Add a featured image and text.
- Locations: `Locations` admin menu. Use one entry per salon, with Instagram and booking URL fields.
- Pricing: `Pricing` admin menu. Create categories like "Coupes / Brushing", then add services with prices.
- Shop details: `Appearance -> Customize -> Pause Urbaine Page`.

The front page is a single scrollable page. It automatically reads Locations, Pricing, Posts, and Customizer text. If no content exists yet, the theme shows starter defaults so the site is usable immediately.

## Importable theme

The theme folder is:

```text
theme/pause-urbaine-single
```

Zip that folder to upload it to a WordPress site, or keep using Docker where it is mounted directly.

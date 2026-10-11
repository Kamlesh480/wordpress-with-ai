#!/bin/bash
# Enables .htaccess overrides (needed for WordPress pretty permalinks)
# in the official wordpress:latest image, which ships with AllowOverride None.
# Docker Entrypoint Initdir scripts (docker-entrypoint.sh runs *.sh in this dir
# before starting Apache) — see https://hub.docker.com/_/wordpress
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Install wp-cli if not already present (image doesn't ship it by default).
if ! command -v wp >/dev/null 2>&1; then
  curl -fsSL -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
  chmod +x /usr/local/bin/wp
fi

# Raise PHP upload limits for local dev — the stock image defaults
# (upload_max_filesize=2M, post_max_size=8M) are too small for real theme
# zips, media uploads, or site backups/migrations.
cat > /usr/local/etc/php/conf.d/uploads.ini << 'EOF'
upload_max_filesize = 128M
post_max_size = 128M
memory_limit = 256M
max_execution_time = 300
EOF

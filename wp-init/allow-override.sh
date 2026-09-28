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

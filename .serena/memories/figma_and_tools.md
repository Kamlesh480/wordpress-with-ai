# Figma Access, MCP Tooling, and Local Dev Commands

## Figma

File key: `yUmP3AiIyUoSXWWK9qXW6A` (owned/imported by the user's own account — a different,
earlier file key the user didn't have edit access to was abandoned). Figma is on a
**Starter-tier plan with a tight rate limit (~20 MCP calls/month)** — be deliberate: prefer
reusing previously-pulled design data (summarized in these memories / earlier conversation)
over making fresh `get_design_context`/`get_metadata` calls. When a call is needed, prefer
`get_metadata` on a parent section first (cheap, gives layer names) over full
`get_design_context` (expensive, generates full code).

Top-level Figma page sections (each is a `<section>` node under canvas `0:1`, page "Page 1"):
- `2002:520` — "Blog Hub" (main listing, page 1)
- `2020:632` — "Paginated Blog Page" (listing, page 2+)
- `2020:630` — "Author Page"
- `2020:633` — "Category Page"
- `2020:631` — "Blog Page" (single post)

Large `get_metadata`/`get_design_context` results on a big section often exceed the tool's
token limit and get saved to a file instead — read that file with `jq -r '.[0].text'` and grep
for `name="..."` attributes to cheaply extract layer names without burning more API calls.

`.dc.html` exports at the repo root (see mem:project_overview) are a **free alternative** to
Figma API calls when the actual rendered text/structure is needed — they have real example
copy, unlike Figma's often-sparse metadata-only responses for large nodes.

## Novamira (abandoned)

Attempted first: an AI-WordPress bridge plugin + MCP server (real, GPL-licensed, from a
Dynamic.ooo/ThemeIsle-adjacent team). Had three real bugs: OAuth device-code flow requires
`WP_ENVIRONMENT_TYPE=local` (fixed via `WORDPRESS_CONFIG_EXTRA` in docker-compose.yml); the
CLI's device-code polling has a **hardcoded 30-second timeout** despite displaying "10
minutes"; and a PHP `strip_tags(null)` deprecation warning broke the OAuth approval page.
**Abandoned in favor of** `@automattic/mcp-wordpress-remote` via a WordPress Application
Password — this is what's configured in `.mcp.json` as `wordpress-local` today, pointed at
`http://localhost:8080/wp-json/mcp/novamira` (the endpoint path is a leftover name; it's the
Automattic MCP bridge actually serving it, not the old Novamira OAuth flow).

## Serena (code navigation + memory MCP, set up 2026-10-20)

Installed via `uvx --from git+https://github.com/oraios/serena serena ...` — no separate
install step; `uvx` fetches and runs it directly from GitHub. Registered as the `serena` MCP
server in this project's `.mcp.json` using `start-mcp-server --context claude-code --project .`.
Project config lives at `.serena/project.yml` (language server: `php`), and this project is
also registered in `~/.serena/serena_config.yml`'s global `projects:` list alongside several
other unrelated local repos (claimbridge-backend, claimbridge-dashboard, IWS-data-collector,
QA, kamlesh-portfolio) — do not remove those entries, they belong to other projects.

## Local WordPress management (wp-cli, inside the `bloghub_wp` container)

```
docker exec bloghub_wp wp <command> --allow-root
docker exec bloghub_wp php -l /var/www/html/wp-content/themes/blog-hub-new/<file>.php
```
Useful ones already used repeatedly: `wp theme mod set/get <key> <value>`,
`wp menu location assign`, `wp user meta update/get <id> <key> <value>`,
`wp term list category`, `wp post list --post_type=post --category_name=<slug>`.

Multi-line theme-mod/user-meta values don't survive a plain CLI string argument cleanly — use
`wp eval 'update_user_meta(...)'` or copy a file into the container with `docker cp` and
reference it, rather than fighting shell newline escaping.

## Packaging the theme zip

```
rm -f /Users/kamlesh/Documents/dev/wordpress/blog-hub.zip
rm -rf /tmp/theme-package && mkdir -p /tmp/theme-package
cp -R wp-content/themes/blog-hub-new /tmp/theme-package/blog-hub
cd /tmp/theme-package && find . -name ".DS_Store" -delete
zip -r -X /Users/kamlesh/Documents/dev/wordpress/blog-hub.zip blog-hub
rm -rf /tmp/theme-package
```
Always verify with `diff -rq` between the unzipped output and the live theme source before
telling the user it's ready — confirms no stale/missing files snuck in.

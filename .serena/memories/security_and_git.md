# Security, Git, and Deployment Constraints

## Public-repo secret hygiene (standing requirement)

The user explicitly required a thorough re-check that **no Claude/Anthropic token, API key, or
other internal secret** ever ends up in this repo, since it is meant to go/go public. Before any
push: `git diff --cached | grep -iE "api[_-]?key|secret|token|password|bearer|AKIA|-----BEGIN|sk-ant-|sk-proj-"`
and, for a first push, also scan full history with `git log -p --all | grep -iE ...` (same
pattern set). None found as of 2026-10-20 (4 commits, all original history included).

## What's git-ignored and why

- `blog-hub.zip` — the packaged theme; user explicitly does not want it committed, only placed
  as a file for manual upload. Rebuild it fresh each time rather than trying to diff/patch it.
- `wp-content/uploads/`, `.env`, `.env.local`, `.claude/settings.local.json`, `.mcp.json` (this
  file currently contains a **plaintext WordPress Application Password** for the local
  `wordpress-local` MCP server entry — fine since it's local-only credentials and the file is
  gitignored, but never copy that password elsewhere or commit a change that un-ignores this
  file).
- `wp-content/plugins/neve-pro-addon/license.json` — contains a real purchased Neve Pro license
  key. The plugin's own *code* is GPLv3 (confirmed via its readme.txt) and fine to publish, but
  the license key is a credential, not code — stays gitignored regardless of the code's license.
- `wp-content/wp-staging/` — WP-Staging plugin's auto-generated runtime cache/lock files, not
  project source. See mem:known_gotchas.

## GitHub remote setup (done 2026-10-20)

Repo: `https://github.com/Kamlesh480/wordpress-with-ai` — a **separate GitHub account**
(`Kamlesh480`, email `kamleshchhipa480@gmail.com`) from the machine's default SSH identity
(`kamlesh-afsv`, which does not have access to this repo). To avoid disturbing the user's
other GitHub SSH access on this machine, set up scoped-to-this-project-only:

- New SSH keypair: `~/.ssh/id_ed25519_kamlesh480` (does not touch the existing default
  `~/.ssh/id_ed25519` used for `kamlesh-afsv`).
- `~/.ssh/config` Host alias `github-kamlesh480` → `github.com`, using that key with
  `IdentitiesOnly yes`. Plain `git@github.com:...` URLs elsewhere are unaffected.
- This repo's remote: `git@github-kamlesh480:Kamlesh480/wordpress-with-ai.git` (note the
  **aliased host**, not plain `github.com`, in the remote URL — required for the SSH config
  alias to take effect).
- Git identity set **locally only** (`git config --local user.name/user.email`, not
  `--global`) to `Kamlesh480` / `kamleshchhipa480@gmail.com`, so other repos on this machine
  keep whatever global identity they already use.

If `git push`/`git pull` ever fails with a permission error on this repo again, first check
`git remote -v` still shows the `github-kamlesh480` alias (not plain `github.com`), and that
`ssh -T git@github-kamlesh480` still authenticates as `Kamlesh480`.

## Live-site deployment notes

Live site uses WP Rocket + host-level (Bluehost/Endurance) caching — both can independently
serve stale/broken pages after a theme switch; clearing WP Rocket's cache alone may not be
enough (a full deactivate/reactivate of WP Rocket forces a complete physical cache-folder wipe,
more thorough than the "Clear Cache" button). Host-level caching is identifiable via
`x-endurance-cache-level` / `x-nginx-cache: WordPress` response headers.

Settings > Reading must have: Homepage = the existing Elementor home page (untouched), Posts
page = the page meant to host Blog Hub (renders via `home.php`, see mem:project_overview).

This repository does not contain Python tooling (no `pyproject.toml`, `Pipfile`, or `requirements.txt`).

Dependency management for this project is handled via Composer (PHP) and npm (frontend). Use the following commands to install project dependencies:

- PHP dependencies: `composer install`
- Frontend dependencies: `npm ci` (or `npm install`)

If you need Python tooling for repository automation or CI, add a `pyproject.toml` or `requirements.txt` with exact pinned versions (`==`) for reproducibility.

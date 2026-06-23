# Design: Add Laravel 13 Support

**Date:** 2026-06-23
**Package:** `vntrungld/prometheus-exporter`
**Status:** Approved

## Goal

Add support for **Laravel 13** to the core exporter package, alongside the
existing Laravel 6–12 support. Laravel 12 is already supported; this work adds
13.

## Background

- Laravel 13 was released on 2026-03-17. It sets **PHP 8.3 as the minimum**
  (drops 8.2) and supports through PHP 8.5. It introduces **zero breaking
  changes to application code** from Laravel 12.
- The package's `ServiceProvider`, routes, facade, and metric types use only
  stable Laravel APIs (`illuminate/support`), so no source changes are
  anticipated.
- `orchestra/testbench 11` is the version matching Laravel 13: it requires
  Laravel `^13.x` and supports PHPUnit `^11.5.50 | ^12 | ^13`.
- The existing test suite uses `test_*` method naming (no `@test` /
  `@dataProvider` doc-comment metadata, no data providers) and a modern
  `phpunit.xml` schema, so it is PHPUnit 12-safe as written.

## Approach

**Purely additive: dependency-constraint + CI-matrix change. No source code
changes expected.**

Alternatives considered and rejected:

- **Modernize & drop old versions** (Laravel 6–10, PHP 7.4) to shrink the
  matrix — rejected: it is a breaking change for existing users and out of
  scope.
- **Constraint-only, skip CI** — rejected: it would advertise untested
  support. Additive + CI proves the support at no real cost.

The PHP constraint ceiling stays at `^8.4`. PHP 8.5 (due ~Nov 2026) is not yet
released and cannot be exercised in CI, so we do not add `^8.5` to the
constraint at this time.

## Changes

### 1. `composer.json`

- `require.illuminate/support`: append `|^13.0`
  (→ `^6.0|^7.0|^8.0|^9.0|^10.0|^11.0|^12.0|^13.0`)
- `require.php`: unchanged (`^7.4|^8.0|^8.1|^8.2|^8.3|^8.4`)
- `require-dev.orchestra/testbench`: append `|^11.0`
- `require-dev.phpunit/phpunit`: append `|^12.0`

### 2. `.github/workflows/tests.yml`

Add a Laravel 13.x matrix block mirroring the existing per-version style:

| php | laravel | testbench | phpunit |
|-----|---------|-----------|---------|
| 8.3 | 13.*    | 11.*      | 12.*    |
| 8.4 | 13.*    | 11.*      | 12.*    |

The `install dependencies` and `run tests` steps are unchanged — they already
parameterize on the matrix values.

### 3. `readme.md`

Update the Requirements line to include Laravel 13:

> Laravel 6.x, 7.x, 8.x, 9.x, 10.x, 11.x, 12.x, or 13.x

## Verification

- **Primary:** CI is the real test. The two new Laravel 13 matrix rows must go
  green.
- **Optional local smoke check:**
  ```bash
  composer require "illuminate/support:13.*" "orchestra/testbench:11.*" \
    "phpunit/phpunit:12.*" --no-update
  composer update --prefer-dist
  vendor/bin/phpunit
  ```
- Existing tests are version-agnostic; **no test changes are anticipated.**

## Risks & fallbacks

- **testbench 11 floors at PHP 8.3** — fine; the new matrix rows are 8.3/8.4.
- **PHPUnit 12 rejects `phpunit.xml`** — unlikely (schema is already modern).
  Fallback is a minor schema tweak, no logic change.
- **No new runtime code paths**, so production behavior is unchanged.

## Out of scope

- Dropping support for older Laravel/PHP versions.
- Adding `^8.5` to the PHP constraint (revisit once PHP 8.5 ships and is
  testable in CI).
- Any functional changes to metric types, collectors, or rendering.

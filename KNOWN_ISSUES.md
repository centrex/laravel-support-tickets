# Known Issues — laravel-support-tickets

_Last checked: 2026-08-02_

## Failing tests

No failing tests. `composer test:unit` (Pest) reports **2 passed** (4 assertions). Note the test suite is small (only 2 tests) relative to the surface area (tickets, replies, attachments, policies).

## Style / static-analysis debt

- `vendor/bin/rector --dry-run` — clean, no pending refactors.
- `vendor/bin/pint --test` — clean, no style violations.
- PHPStan (`level: max`) reports **134 errors**, and `phpstan-baseline.neon` is empty (0 bytes), so all 134 are live/unbaselined. Recurring patterns:
  - `src/Policies/TicketPolicy.php` — every method typehints `$user` as `App\Models\User`, a class that does not exist inside this package's namespace/analysis scope ("Class App\Models\User not found" / "invalid type App\Models\User" / "Access to property $id/$is_admin on an unknown class App\Models\User"), which cascades into most of the errors in this file.
  - `src/Models/Ticket.php`, `TicketReply.php`, `TicketAttachment.php` — repeated "Access to an undefined property" for `$status`, `$priority`, `$assigned_to`, `$user_id`, `$size` (properties phpstan can't see, likely relying on dynamic/magic Eloquent attributes without PHPDoc `@property` annotations), plus generic-type omissions on `HasMany`/`BelongsTo` return types (`TRelatedModel`, `TDeclaringModel` not specified) and untyped scope methods (`scopeOpen`, `scopeAssignedTo`, `scopeByPriority`).
- Note: the chained `composer test` script would run all four steps here without an early stop (rector and pint both currently pass), but `test:types` still fails with the 134 phpstan errors above, so `composer test` overall is red.

## TODO / FIXME markers

None found (`grep -rn "TODO\|FIXME" --include="*.php" src/ config/ database/` — no matches).

## Open GitHub issues

Not checked — the `gh` CLI is not installed in this environment.

# CLAUDE.md

Guidance for AI coding assistants working in this repository.

## Project
Offset, a wheel and rim web shop. Laravel 13 (PHP 8.3), Blade storefront, Filament 4 admin panel, a read-only Sanctum JSON API, Tailwind CSS 3, Vite. SQLite locally, Docker setup with MySQL and Nginx.

## Commands
- `php artisan test --compact`: test suite (PHPUnit 12, SQLite in memory); `--parallel` for the full run
- `vendor/bin/pint`: code style
- `vendor/bin/phpstan analyse`: Larastan, level 8, no baseline
- `npm run build`: production assets

## Code layout
- `app/Http/Controllers/Web` (shop) and `app/Http/Controllers/JsonApi` (API)
- `app/Actions/Checkout`: one class per business operation (`PlaceOrder`, `PayOrderByCard`)
- `app/Services`: `CartService`, `TotalsCalculator`, `ShippingCalculator`
- `app/Policies`, `app/Enums`, Form Requests in `app/Http/Requests`
- Money goes through `App\Support\Money` and the `@money` Blade directive; prices include VAT, and all VAT maths lives in `TotalsCalculator`.
- `public/js/app.js` is hand-written and committed, not built by Vite.

## Workflow
- One branch and one pull request per task, with small, focused commits.
- Commit and PR messages: short, plain sentence case, no `feat:`/`chore:` prefixes.
- Write tests only when behaviour is added or changed: a few focused ones that fail without the change.
- Run Pint, PHPStan and the tests before opening a PR. CI runs the same checks.
- Don't add dependencies without explaining why.

## Laravel rules
- **Validation:** Form Requests or `$request->validate()`. Never pass `$request->all()` to `create()`, `update()` or `fill()`.
- **Mass assignment:** every model defines `$fillable`. Never `$guarded = []`.
- **Sensitive fields:** models with secrets define `$hidden`. API responses go through API Resources that expose only what the client needs.
- **Queries:** eager-load relationships with `with()` (strict mode turns lazy loading into an error outside production) and paginate list endpoints. No raw SQL with interpolated values; use bindings.
- **Authorization:** any route that touches a user-owned record goes through a Policy (`$this->authorize()`) or a scoped query such as `$request->user()->orders()->findOrFail($id)`.
- **State changes** use POST, PUT, PATCH or DELETE with CSRF protection, never GET.
- **Comparisons:** strict `===` / `!==`; compare tokens and secrets with `hash_equals()`. Passwords only through `Hash::make()` / `Hash::check()`.
- **Money and stock:** multi-step writes (stock, order, payment) run inside `DB::transaction()`, with `lockForUpdate()` or atomic updates where concurrent requests could race.
- **Uploads:** validate type and size, and store with `store()` (random filename). Never keep the client's original filename.
- **Output:** escape with `{{ }}` in Blade. Use `{!! !!}` only for HTML the app generated itself or has sanitized.

## JavaScript rules
- `await` promises inside `try/catch`, and use `Promise.all` for independent requests instead of awaiting them one by one in a loop.
- Use `let`/`const`, never `var`.
- Clear any interval, timeout or listener you start when it is no longer needed.

@.claude/local-notes.md

# Changelog

All Notable changes to `laravel-auditable` will be documented in this file.

## v4.4.0 - 2022-02-09

- Laravel 9 Support #18

## v4.3.1 - 2021-06-03

- Don't touch updated_by if unauthenticated [#17]
- Fix [#16]

## v4.3.0 - 2020-09-09

- Add support for Laravel 8 [#10].

## v4.2.0 - 2020-07-03

- Add configurable creator and updater default values if not set.

## v4.1.0 - 2020-03-07

- Allow Laravel 7 #9, Fix #8.

## v4.0.1 - 2020-02-22

- Fix touch event of relation, not updating updated_by of related table.

## v4.0.0 - 2019-09-19

- Drop support for Laravel 5.8 and below.
- Add `AuditableWithDeletesTrait` to be used along with `SoftDeletes`.
- Add `restoring` event that sets `deleted_by` to null when restored.
- Fix [#7].

## v3.2.0 - 2019-09-04
- Add support for Laravel 6.

## v3.1.1 - 2019-08-27
- Add option to set custom user via auditUser property.

## v3.1.0 - 2019-08-27
- Add default value on relations.
- Add method to get user class.
- Use name attribute.
> Note: add name getter to present first & last name if needed.

## v3.0.0 - 2019-08-27
- Add auditing for delete events
  - New `deleted_by` column, `deleter` relationship and `deletedByName` accessor
  - Add `auditableWithDeletes()` and `dropAuditableWithDeletes()` methods for migrations
- Use `null` user ID if no user found instead of `0`
- Made column names configurable using model constants: `CREATED_BY`, `UPDATED_BY`, `DELETED_BY`
- Use `unsignedBigIncrements` for migration.
- Drop support for Laravel 5.7 and below.

## v2.0.1 - 2017-12-28
- Fix travis.
- Removed unused dev packages.
- Update docs.

## v2.0.0 - 2017-12-28
- Add auditable blueprint macro. [e0e18b5]
- Lock support to Laravel 5.5++. [e0e18b5]

## v1.1.3 - 2017-12-28
- Fix model events param type hint and doc. [893fa37]

## v1.1.2 - 2017-12-28
- Fix setting of updated_by value column when updating. [ca34c5f]

## v1.1.1 - 2017-06-09
- Use eager loading when fetching creator/udpater name.
- Fix N+1 query.

## v1.1.0 - 2017-01-05
- Add github templates.
- Update license.
- Fix git attributes.

## v1.0.0 - 2016-11-18
- Release stable version.
- Add [official docs](https://yajrabox.com/docs/laravel-auditable).

### v1.0.0-dev
- Register package to packagist.
- Update docs.
- Remove unused dev packages.

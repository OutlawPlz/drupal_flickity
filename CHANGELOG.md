# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

Log of unreleased changes.

_This release breaks compatibility with previous releases. Since we're in early
development, no upgrade path is provided._

### Added

- [#9](https://github.com/OutlawPlz/drupal_flickity/issues/9) - Support for
image field, added `ImageFlickityFormatter`.

### Changed

- [#10](https://github.com/OutlawPlz/drupal_flickity/issues/10) - Moved
`setGallerySize` in `advanced` options.
- The `options` are saved in database as plain text, formatted via Yaml. This
way future changes in Flickity options will be handled faster and easier.
- Changed `flickity.flickity.default.yml` to match new `options` format.

### Fixed

- Fixed typo in `flickity.routing.yml` and `flickity.install`.
- Fixed an erroneous requirements check. The `$phase` variable were not checked
correctly.

### Removed

- [#7](https://github.com/OutlawPlz/drupal_flickity/issues/7) - Removed
`getFormattedOptions()`, use `getOptions()`.

## v0.2.1

Released on **2018/02/22**.

### Fixed

- [#8](https://github.com/OutlawPlz/drupal_flickity/issues/8) - Flickity's
options are not set correctly and Flickity is initialize with default options.

## v0.2.0

Released on **2018/02/15**.

### Added

- Added Flickity Views style, it renders Views rows in a Flickity carousel.
- [#6](https://github.com/OutlawPlz/drupal_flickity/issues/6) - User can
override Flickity's options defined in field formatter by adding a reference
field called `field_flickity_options`.

### Changed

- Refactored `CHANGELOG.md` using _Keepachangelog.com_ advices.
- [#2](https://github.com/OutlawPlz/drupal_flickity/issues/2) - Logic is inside
the `view()` function, while `template_preprocess_flickity()` adds
`data-flickity-options` attribute.
- Refactoring `flickityInit.js`.

### Fixed

- [#4](https://github.com/OutlawPlz/drupal_flickity/issues/4) - Fixed layout
issue when field label is printed.

## v0.1.1

Released on **2017/03/23**.

### Fixed

- Fixed typo.
- Fixed Drupal is not defined for anonymous user.

## v0.1.0

Released on **2017/02/23**.

### Added

- Added libraries.yml file.
- Flickity config entity.
- Added Advanced options in Yaml format.
- Implemented Flickity field formatter.
- Added `flickityInit.js` file.
- Added cacheability metadata.
- Added description and README.
- Added CSS classes.

### Changed

- Improved options form.
- Move Flickity library to `libraries/` folder.

### Fixed

- Fixed getFormattedOptions().
- Fixed adaptiveHeight option.

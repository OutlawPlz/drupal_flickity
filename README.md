# Flickity

Provides Flickity library integration for Drupal 8.

## Quick Start

Start using Flickity in three steps.

1. Download latest Flickity module form [Github][20e977c5] or via Composer and
enable it as usual.
  ```sh
  composer require outlawplz/flickity
  ```

2. Download latest [Flickity][3bda2aad] library and copy it to the `libraries/`
folder found at Drupal root folder.
  ```sh
  # CSS file location
  /libraries/flickity/dist/flickity.min.css

  # JS file location
  /libraries/flickity/dist/flickity.pkgd.min.js
  ```

3. In a Reference Entity field select Flickity as display mode.

That's it. You're all set to start using Flickity.

  [20e977c5]: https://github.com/OutlawPlz/drupal_flickity "Github Flickity"
  [3bda2aad]: http://flickity.metafizzy.co/ "Flickity"

## Options

You can add new configurations or edit existing ones at **Configuration > User
interface > Flickity**. Common options are listed as fields, while advanced
options are stored in YAML format.

```yaml
# E.g.
imagesLoaded: true
groupCells: 2
lazyLoad: true
```

To learn more about Flickity options, check out the [official
documentation][f0125aff].

  [f0125aff]: http://flickity.metafizzy.co/options.html "Flickity options"

## Style

Flickity uses CSS to set cell sizing. This way you can alter the number of cell
visible at different display size using media queries.

```css
# Small screens
@media (max-width: 560px) {
  .field__item {
    width: 50%;
  }
}

# Wide screens
@media (min-width: 561px) {
  .field__item {
    width: 25%;
  }
}
```

To learn more about Flickity styling, check out the [official documentation][315007b3].

  [315007b3]: http://flickity.metafizzy.co/style.html "Flickity style"

(function (Drupal) {
  Drupal.behaviors.flickity = {
    attach: function (context, settings) {
      var elements = context.querySelectorAll('[data-flickity-options]')
      var options_id
      // For each element instantiate a new Flickity object.
      for (var i = elements.length, element; (element = elements[ --i ]);) {
        options_id = element.getAttribute('data-flickity-options')
        // If options_id is empty instantiate without options.
        if (!options_id) {
          new Flickity (element)
          continue
        }
        // Otherwise get the options from drupalSettins and instantiate Flickity.
        new Flickity (element, settings['flickity'][options_id])
      }
    }
  }
}(Drupal))

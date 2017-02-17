( function ( Drupal ) {

  Drupal.behaviors.flickity = {
    attach: function ( context, settings ) {

      var elements = context.querySelectorAll( '[data-flickity-options]' ),
          options;

      for ( var i = elements.length, element; i--, element = elements[ i ]; ) {

        var config = element.getAttribute( 'data-flickity-options' );

        if ( config ) {
          options = settings[ 'flickity' ][ config ];
          new Flickity( element, options);
        }
        else {
          new Flickity( element );
        }
      }
    }
  };

} ( Drupal ) );

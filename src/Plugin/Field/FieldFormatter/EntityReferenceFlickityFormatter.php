<?php
/**
 * @file
 * Contains \Drupal\flickity\Plugin\Field\FieldFormatter\EntityReferenceFlickityFormatter
 */

namespace Drupal\flickity\Plugin\Field\FieldFormatter;


use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\flickity\Entity\Flickity;

/**
 * Plugin implementation of the 'entity reference flickity' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_flickity",
 *   label = @Translation("Flickity"),
 *   description = @Translation("Display the referenced entities in a Flickity carousel."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceFlickityFormatter extends EntityReferenceEntityFormatter {

  /**
   * Returns a form to configure settings for the formatter.
   *
   * Invoked from \Drupal\field_ui\Form\EntityDisplayFormBase to allow
   * administrators to configure the formatter. The field_ui module takes care
   * of handling submitted form values.
   *
   * @param array $form
   *   The form where the settings form is being included in.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form elements for the formatter settings.
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $form = parent::settingsForm($form, $form_state);

    $form['flickity_config'] = array(
      '#title' => $this->t('Flickity configuration'),
      '#type' => 'select',
      '#options' => Flickity::getConfigList(),
      '#empty_option' => t('None (library default)'),
      '#default_value' => $this->getSetting('flickity_config')
    );

    return $form;
  }

  /**
   * Returns a short summary for the current formatter settings.
   *
   * If an empty result is returned, a UI can still be provided to display
   * a settings form in case the formatter has configurable settings.
   *
   * @return string[]
   *   A short summary of the formatter settings.
   */
  public function settingsSummary() {

    $config = $this->getSetting('flickity_config');

    if (empty($config)) {
      $config = $this->t('None (library default)');
    }

    $summary = parent::settingsSummary();
    $summary[] = $this->t('Flickity config: ' . $config);

    return $summary;
  }

  /**
   * Builds a renderable array for a fully themed field.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field values to be rendered.
   * @param string $langcode
   *   (optional) The language that should be used to render the field. Defaults
   *   to the current content language.
   *
   * @return array
   *   A renderable array for a themed field with its label and all its values.
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {

    $elements = parent::view($items, $langcode);
    $elements['#theme'] = 'flickity';

    return $elements;
  }

  /**
   * Defines the default settings for this plugin.
   *
   * @return array
   *   A list of default settings, keyed by the setting name.
   */
  public static function defaultSettings() {

    return array(
      'flickity_config' => ''
    ) + parent::defaultSettings();
  }
}
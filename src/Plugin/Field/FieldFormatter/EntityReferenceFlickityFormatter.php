<?php
/**
 * @file
 * Contains \Drupal\flickity\Plugin\Field\FieldFormatter\EntityReferenceFlickityFormatter
 */

namespace Drupal\flickity\Plugin\Field\FieldFormatter;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\Annotation\FieldFormatter;
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
    // Create the flickity_config option form.
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
    // If $config is empty, set the default.
    if (empty($config)) {
      $config = $this->t('None (library default)');
    }
    // Add current configuration to the $summary array.
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

    $elements = parent::view($items, $langcode); // Let Drupal do its things.
    $config_id = $this->getSetting('flickity_config');
    $entity = $elements['#object'];
    $field_name = 'field_flickity_options';
    // Override $config_id if the $entity has the field_flickity_options field.
    /** @var FieldableEntityInterface $entity */
    if ($entity instanceof FieldableEntityInterface && $entity->hasField($field_name)) {
      $field_value = $entity->get('field_flickity_options')->getValue()[0]['target_id'];
      $config_id = (empty($field_value) ? $config_id : $field_value);
    }
    // Set Flickity field formatter.
    $elements['#theme'] = 'flickity';
    $elements['#attached']['library'][] = 'flickity/flickity';
    $elements['#flickity_options'] = $config_id;
    // If $config_id is empty, we're done.
    if (empty($config_id)) {
      return $elements;
    }
    // Otherwise load the Flickity's options and set them into drupalSettings.
    $flickity_config = Flickity::load($config_id);
    $elements['#attached']['drupalSettings']['flickity'][$config_id] = $flickity_config->getFormattedOptions();
    $elements['#cache']['tags'] = Cache::mergeTags($elements['#cache']['tags'], $flickity_config->getCacheTagsToInvalidate());

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

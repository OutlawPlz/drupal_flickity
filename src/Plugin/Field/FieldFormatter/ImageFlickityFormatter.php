<?php

namespace Drupal\flickity\Plugin\Field\FieldFormatter;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\flickity\Entity\Flickity;

/**
 * Plugin implementation of the Image Flickity formatter.
 *
 * @FieldFormatter(
 *   id = "image_flickity",
 *   label = @Translation("Flickity"),
 *   description = @Translation("Display the images in a Flickity carousel."),
 *   field_types = {
 *     "image"
 *   }
 * )
 */
class ImageFlickityFormatter extends ImageFormatter
{
  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::settingsForm($form, $form_state);
    // Create the flickity_config option form.
    $form['flickity_config'] = array(
      '#title' => $this->t('Flickity configuration'),
      '#type' => 'select',
      '#options' => Flickity::getConfigList(),
      '#empty_option' => $this->t('None (library default)'),
      '#default_value' => $this->getSetting('flickity_config')
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary()
  {
    $config = $this->getSetting('flickity_config');
    // If $config is empty, set default options.
    if (empty($config)) {
      $config = $this->t('None (library default)');
    }
    // Add current configuration on the $summary array.
    $summary = parent::settingsSummary();
    $summary[] = $this->t('Using Flickity ' . $config . ' options.');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function view(FieldItemListInterface $items, $langcode = NULL)
  {
    $elements = parent::view($items, $langcode); // Let Drupal do its things.
    $config_id = $this->getSetting('flickity_config');
    $entity = $elements['#object'];
    $field_name = 'field_flickity_options';
    // Override $config_id if the $entity has the field_flickity_options field.
    /** @var FieldableEntityInterface $entity */
    if ($entity instanceof FieldableEntityInterface && $entity->hasField($field_name)) {
      $field_value = $entity->get($field_name)->getValue()[0]['target_id'];
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
    $elements['#attached']['drupalSettings']['flickity'][$config_id] = $flickity_config->getOptions();
    $elements['#cache']['tags'] = Cache::mergeTags($elements['#cache']['tags'], $flickity_config->getCacheTagsToInvalidate());

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings()
  {
    return array(
      'flickity_config' => NULL
    ) + parent::defaultSettings();
  }
}

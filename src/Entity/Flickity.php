<?php
/**
 * @file
 * Contains \Drupal\flickity\Entity\Flickity
 */

namespace Drupal\flickity\Entity;


use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\Annotation\ConfigEntityType;

/**
 * Defines the Flickity configuration entity.
 *
 * @ConfigEntityType(
 *   id = "flickity",
 *   label = @Translation("Flickity configuration"),
 *   handlers = {
 *     "list_builder" = "Drupal\flickity\FlickityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\flickity\Form\FlickityForm",
 *       "edit" = "Drupal\flickity\Form\FlickityForm",
 *       "delete" = "Drupal\flickity\Form\FlickityDeleteForm"
 *     }
 *   },
 *   config_prefix = "flickity",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/user-interface/flickity/{flickity}",
 *     "add-form" = "/admin/config/user-interface/flickity/add",
 *     "edit-form" = "/admin/config/user-interface/flickity/{flickity}/edit",
 *     "delete-form" = "/admin/config/user-interface/flickity/{flickity}/delete",
 *     "collection" = "/admin/config/user-interface/flickity"
 *   }
 * )
 */
class Flickity extends ConfigEntityBase implements FlickityInterface {

  /**
   * The machine name of this Flickity configuration.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of this Flickity configuration.
   *
   * @var string
   */
  protected $label;

  /**
   * An array of Flickity options.
   *
   * @var array
   */
  protected $options;


  /**
   * Gets the options.
   *
   * @return array
   *   The options array.
   */
  public function getOptions() {

    return $this->options;
  }

  /**
   * Gets the options formatted as Flickity options.
   *
   * @return array
   *   The options array ready to use as Flickity options.
   */
  public function getFormattedOptions() {

    $options = $this->options;

    if(!empty($options['advanced'])) {
      $options = array_merge($options, Yaml::decode($options['advanced']));
      unset($options['advanced']);
    }

    return $options;
  }

  /**
   * Gets the configuration list.
   *
   * @return array
   *   An array of Flickity configuration. The config ID is the key, and the
   *   config label the value.
   */
  public static function getConfigList() {

    $entities = Flickity::loadMultiple();
    $config_list = array();

    /** @var FlickityInterface $entity */
    foreach ($entities as $entity) {
      $config_list[$entity->get('id')] = $entity->get('label');
    }

    return $config_list;
  }
}

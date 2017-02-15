<?php
/**
 * @file
 * Contains \Drupal\flickity\Entity\Flickity
 */

namespace Drupal\flickity\Entity;


use Drupal\Core\Config\Entity\ConfigEntityBase;

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
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of this Flickity configuration.
   * @var string
   */
  protected $label;

  /**
   * An array of Flickity options.
   * @var array
   */
  protected $options;
}

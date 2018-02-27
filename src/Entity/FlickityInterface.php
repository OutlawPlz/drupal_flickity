<?php
/**
 * @file
 * Contains \Drupal\flickity\Entity\FlickityInterface
 */

namespace Drupal\flickity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

interface FlickityInterface extends ConfigEntityInterface {

  /**
   * Gets the options.
   *
   * @return array
   *   The options array.
   */
  public function getOptions();

  /**
   * Gets the configuration list.
   *
   * @return array
   *   An array of Flickity configurations. The config ID is the key, and the
   *   config label the value.
   */
  public static function getConfigList();
}

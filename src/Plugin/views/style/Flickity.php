<?php

namespace Drupal\flickity\Plugin\views\style;


use Drupal\Core\Annotation\Translation;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Annotation\ViewsStyle;
use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * @ViewsStyle(
 *   id = "flickity",
 *   title = @Translation("Flickity"),
 *   help = @Translation("Render a list of content in a Flickity carousel."),
 *   theme = "views_view_flickity",
 *   display_types = { "normal" }
 * )
 */
class Flickity extends StylePluginBase {

  /**
   * Whether or not this style uses a row plugin.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support grouping of rows.
   *
   * @var bool
   */
  protected $usesGrouping = FALSE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {

    $options =  parent::defineOptions();

    $options['flickity_config'] = array(
      'default' => ''
    );

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    parent::buildOptionsForm($form, $form_state);

    $form['flickity_config'] = array(
      '#title' => $this->t('Flickity'),
      '#description' => $this->t('Select Flickity options.'),
      '#required' => TRUE,
      '#type' => 'select',
      '#default_value' => $this->options['flickity_config'],
      '#options' => \Drupal\flickity\Entity\Flickity::getConfigList()
    );
  }
}
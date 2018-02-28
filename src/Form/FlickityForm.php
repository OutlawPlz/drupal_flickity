<?php
/**
 * @files
 * Contains \Drupal\flickity\Form\FlickityForm
 */

namespace Drupal\flickity\Form;

use Drupal\Component\Serialization\Yaml;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form handler for the Flickity configuration add and edit forms.
 */
class FlickityForm extends EntityForm {

  /**
   * Gets the actual form array to be built.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @return array
   *   The form structure.
   */
  public function form(array $form, FormStateInterface $form_state) {

    /** @var \Drupal\flickity\Entity\FlickityInterface $entity */
    $entity = $this->entity;
    $options = $entity->getOptions();
    $form = parent::form($form, $form_state);
    // Build $form with common options.
    $form = array(
      'label' => array(
        '#type' => 'textfield',
        '#title' => $this->t('Label'),
        '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
        '#default_value' => $entity->get('label'),
        '#required' => TRUE,
      ),
      'id' => array(
        '#type' => 'machine_name',
        '#default_value' => $entity->get('id'),
        '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
        '#machine_name' => array(
          'exists' => '\Drupal\flickity\Entity\Flickity::load',
          'source' => array('label')
        ),
        '#disabled' => !$entity->isNew(),
        '#description' => $this->t('')
      ),
      'info' => array(
        '#type' => 'item',
        '#description' => $this->t('To learn more abount Flickity options, check out the <a href="http://flickity.metafizzy.co/" target="_blank">official documentation</a>.')
      ),
      // Flickity's setup options.
      'setup' => array(
        '#type' => 'details',
        '#title' => $this->t('Setup'),
        '#open' => TRUE,
        // Cell Selector
        'cell_selector' => array(
          '#type' => 'textfield',
          '#title' => $this->t('Cell selector'),
          '#default_value' => $options['cellSelector'],
          '#description' => $this->t('Specify selector for cell elements. This is useful if you have other elements in your carousel elements that are not cells.')
        ),
        // Initial Index
        'initial_index' => array(
          '#type' => 'number',
          '#title' => $this->t('Initial index'),
          '#default_value' => $options['initialIndex'],
          '#min' => 0,
          '#description' => $this->t('Zero-based index of the initial selected cell.')
        ),
        // Resize
        'resize' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Resize'),
          '#default_value' => $options['resize'],
          '#description' => $this->t('Adjusts sizes and positions when window is resized.'),
        ),
      ),
      // Cell Position
      'cell_position' => array(
        '#type' => 'details',
        '#title' => $this->t('Cell position'),
        '#open' => TRUE,
        // Cell Align
        'cell_align' => array(
          '#type' => 'select',
          '#title' => $this->t('Cell align'),
          '#default_value' => $options['cellAlign'],
          '#description' => $this->t('Align cells within the carousel element.'),
          '#options' => array(
            'left' => $this->t('Left'),
            'center' => $this->t('Center'),
            'right' => $this->t('Right')
          ),
          '#empty_value' => ''
        ),
        // Contain
        'contain' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Contain'),
          '#default_value' => $options['contain'],
          '#description' => $this->t('Contains cells to carousel element to prevent excess scroll at beginning or end. Has no effect if wrapAround is true.'),
        )
      ),
      // Behaviur
      'behavior' => array(
        '#type' => 'details',
        '#title' => $this->t('Behavior'),
        '#open' => TRUE,
        // Draggable
        'draggable' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Draggable'),
          '#default_value' => $options['draggable'],
          '#description' => $this->t('Enable draggin and flicking.')
        ),
        // Free Scroll
        'free_scroll' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Free scroll'),
          '#default_value' => $options['freeScroll'],
          '#description' => $this->t('Enables content to be freely scrolled and flicked without aligning cells to an end position.')
        ),
        // Wrap Around
        'wrap_around' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Wrap around'),
          '#default_value' => $options['wrapAround'],
          '#description' => $this->t('At the end of cells, wrap-around to the other end for infinite scrolling.')
        ),
        // Auto Play
        'auto_play' => array(
          '#type' => 'number',
          '#title' => $this->t('Auto play'),
          '#default_value' => $options['autoPlay'],
          '#min' => 0,
          '#description' => $this->t('Milliseconds, set to 0 to disable. Automatically advances to the next cell. Auto-playing will pause when mouse is hovered over, and resume when mouse is hovered off. Auto-playing will stop when the carousel is clicked or a cell is selected.')
        ),
        // Adaptive Height
        'adaptive_height' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Adaptive height'),
          '#default_value' => $options['adaptiveHeight'],
          '#description' => $this->t('Changes height of carousel to fit height of selected slide.')
        )
      ),
      // User Interface
      'user_interface' => array(
        '#type' => 'details',
        '#title' => $this->t('User interface'),
        '#open' => TRUE,
        // Prev & Next Button
        'prev_next_buttons' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Prev/Next buttons'),
          '#default_value' => $options['prevNextButtons'],
          '#description' => $this->t('Creates and enables previous & next buttons.')
        ),
        // Page Dots
        'page_dots' => array(
          '#type' => 'checkbox',
          '#title' => $this->t('Page dots'),
          '#default_value' => $options['pageDots'],
          '#description' => $this->t('Creates and enables page dots. ')
        )
      )
    );
    // Remove previously defined options.
    unset($options['cellSelector'], $options['initialIndex'], $options['resize'],
        $options['cellAlign'], $options['contain'], $options['draggable'],
        $options['freeScroll'], $options['wrapAround'], $options['autoPlay'],
        $options['adaptiveHeight'], $options['prevNextButtons'], $options['pageDots']);
    // Define advanced options.
    $form['advanced_options'] = array(
      '#type' => 'details',
      '#title' => $this->t('Advanced options'),
      'advanced' => array(
        '#type' => 'textarea',
        '#title' => $this->t('Advanced'),
        '#default_value' => (empty($options) ? '' : Yaml::encode($options)),
        '#description' => t('Options in Yaml format.')
      )
    );

    return $form + parent::form($form, $form_state);
  }

  /**
   * Form submission handler for the 'save' action.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   * @return int
   *   Either SAVED_NEW or SAVED_UPDATED, depending on the operation performed.
   */
  public function save(array $form, FormStateInterface $form_state) {

    /** @var $entity \Drupal\flickity\Entity\FlickityInterface */
    $entity = $this->entity;
    // Prepare $options to save.
    $options = array(
      'cellSelector' => $form_state->getValue('cell_selector'),
      'initialIndex' => $form_state->getValue('initial_index'),
      'cellAlign' => $form_state->getValue('cell_align'),
      'resize' => $form_state->getValue('resize'),
      'contain' => $form_state->getValue('contain'),
      'draggable' => $form_state->getValue('draggable'),
      'freeScroll' => $form_state->getValue('free_scroll'),
      'wrapAround' => $form_state->getValue('wrap_around'),
      'autoPlay' => $form_state->getValue('auto_play'),
      'adaptiveHeight' => $form_state->getValue('adaptive_height'),
      'prevNextButtons' => $form_state->getValue('prev_next_buttons'),
      'pageDots' => $form_state->getValue('page_dots'),
    );
    // Merge $advanced_options into $options.
    $advanced_options = $form_state->getValue('advanced');
    if (!empty($advanced_options)) {
      $options = array_merge($options, Yaml::decode($advanced_options));
    }
    // Save $options & entity.
    $entity->set('options', Yaml::encode($options));
    $status = parent::save($form, $form_state);
    if ($status == SAVED_NEW) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been created.', array(
        '@label' => $entity->get('label')
      )));
    }
    elseif ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been updated.', array(
        '@label' => $entity->get('label')
      )));
    }
    // Redirect to collection.
    $form_state->setRedirect('entity.flickity.collection');

    return $status;
  }
}

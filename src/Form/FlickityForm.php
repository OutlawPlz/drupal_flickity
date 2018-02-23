<?php
/**
 * @files
 * Contains \Drupal\flickity\Form\FlickityForm
 */

namespace Drupal\flickity\Form;

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

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
      '#default_value' => $entity->get('label'),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $entity->get('id'),
      '#maxlength' => EntityTypeInterface::ID_MAX_LENGTH,
      '#machine_name' => array(
        'exists' => '\Drupal\flickity\Entity\Flickity::load',
        'source' => array('label')
      ),
      '#disabled' => !$entity->isNew(),
      '#description' => $this->t('')
    );

    $form['info'] = array(
      '#type' => 'item',
      '#description' => $this->t('To learn more abount Flickity options, check out the <a href="http://flickity.metafizzy.co/" target="_blank">official documentation</a>.')
    );

    $form['setup'] = array(
      '#type' => 'details',
      '#title' => $this->t('Setup'),
      '#open' => TRUE
    );

    $form['setup']['cell_selector'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cell selector'),
      '#default_value' => $options['cellSelector'],
      '#description' => $this->t('Specify selector for cell elements. This is useful if you have other elements in your carousel elements that are not cells.')
    );

    $form['setup']['initial_index'] = array(
      '#type' => 'number',
      '#title' => $this->t('Initial index'),
      '#default_value' => $options['initialIndex'],
      '#min' => 0,
      '#description' => $this->t('Zero-based index of the initial selected cell.')
    );

    $form['setup']['resize'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Resize'),
      '#default_value' => $options['resize'],
      '#description' => $this->t('Adjusts sizes and positions when window is resized.'),
    );

    $form['cell_position'] = array(
      '#type' => 'details',
      '#title' => $this->t('Cell position'),
      '#open' => TRUE
    );

    $form['cell_position']['cell_align'] = array(
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
    );

    $form['cell_position']['contain'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Contain'),
      '#default_value' => $options['contain'],
      '#description' => $this->t('Contains cells to carousel element to prevent excess scroll at beginning or end. Has no effect if wrapAround is true.'),
    );

    $form['behavior'] = array(
      '#type' => 'details',
      '#title' => $this->t('Behavior'),
      '#open' => TRUE
    );

    $form['behavior']['draggable'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Draggable'),
      '#default_value' => $options['draggable'],
      '#description' => $this->t('Enable draggin and flicking.')
    );

    $form['behavior']['free_scroll'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Free scroll'),
      '#default_value' => $options['freeScroll'],
      '#description' => $this->t('Enables content to be freely scrolled and flicked without aligning cells to an end position.')
    );

    $form['behavior']['wrap_around'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Wrap around'),
      '#default_value' => $options['wrapAround'],
      '#description' => $this->t('At the end of cells, wrap-around to the other end for infinite scrolling.')
    );

    $form['behavior']['auto_play'] = array(
      '#type' => 'number',
      '#title' => $this->t('Auto play'),
      '#default_value' => $options['autoPlay'],
      '#min' => 0,
      '#description' => $this->t('Milliseconds, set to 0 to disable. Automatically advances to the next cell. Auto-playing will pause when mouse is hovered over, and resume when mouse is hovered off. Auto-playing will stop when the carousel is clicked or a cell is selected.')
    );

    $form['behavior']['adaptive_height'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Adaptive height'),
      '#default_value' => $options['adaptiveHeight'],
      '#description' => $this->t('Changes height of carousel to fit height of selected slide.')
    );

    $form['user_interface'] = array(
      '#type' => 'details',
      '#title' => $this->t('User interface'),
      '#open' => TRUE
    );

    $form['user_interface']['prev_next_buttons'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Prev/Next buttons'),
      '#default_value' => $options['prevNextButtons'],
      '#description' => $this->t('Creates and enables previous & next buttons.')
    );

    $form['user_interface']['page_dots'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Page dots'),
      '#default_value' => $options['pageDots'],
      '#description' => $this->t('Creates and enables page dots. ')
    );

    $form['advanced_options'] = array(
      '#type' => 'details',
      '#title' => $this->t('Advanced options')
    );

    $form['advanced_options']['advanced'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Advanced'),
      '#default_value' => $options['advanced'],
      '#description' => t('Options in Yaml format.')
    );

    return $form;
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

    $entity->set('options', array(
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
      'advanced' => $form_state->getValue('advanced')
    ));

    $status = parent::save($form, $form_state);
    $replacement = array(
      '@label' => $entity->get('label')
    );

    if ($status == SAVED_NEW) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been created.', $replacement));
    }
    elseif ($status == SAVED_UPDATED) {
      drupal_set_message($this->t('Configuration <em>@label</em> has been updated.', $replacement));
    }

    $form_state->setRedirect('entity.flickity.collection');

    return $status;
  }
}

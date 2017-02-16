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
      '#description' => $this->t(''),
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

    $form['setup'] = array(
      '#type' => 'details',
      '#title' => $this->t('Setup'),
      '#open' => TRUE
    );

    $form['setup']['cell_selector'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Cell selector'),
      '#default_value' => $options['cellSelector'],
      '#description' => $this->t('Specify selector for cell elements. This is useful if you have other elements in your carousel elements that are not cells.'),
      '#required' => TRUE
    );

    $form['setup']['initial_index'] = array(
      '#type' => 'number',
      '#title' => $this->t('Initial index'),
      '#default_value' => $options['initialIndex'],
      '#min' => 0,
      '#description' => $this->t('Zero-based index of the initial selected cell.')
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
<?php

namespace Drupal\contactForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;
/**
 * Class DeleteForm.
 *
 * @package Drupal\contactForm\Form
 */
class DeleteForm extends ConfirmFormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'delete_form';
  }

  public $nid;

  public function getQuestion() {
    return t('Do you want to delete %nid?', array('%nid' => $this->nid));
  }

  public function getCancelUrl() {
    return new Url('contactForm.contact_list_form');
}
public function getDescription() {
    return t('Are you sure want to delete it!!');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {

     $this->id = $cid;
    return parent::buildForm($form, $form_state);
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
   $query = \Drupal::database();
    $query->delete('contact_form')
          ->condition('id',$this->id)
          ->execute();
          drupal_set_message("succesfully deleted");
    $form_state->setRedirect('contactForm.contact_list_form');
  }
}

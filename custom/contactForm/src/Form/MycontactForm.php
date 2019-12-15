<?php

namespace Drupal\contactForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class MycontactForm.
 *
 * @package Drupal\contactForm\Form
 */
class MycontactForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mycontact_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['n'])) {
        $query = $conn->select('contact_form', 'm')
            ->condition('id', $_GET['n'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['first_name']) && $_GET['n']) ? $record['first_name']:'',
      );

    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['last_name']) && $_GET['n']) ? $record['last_name']:'',
      );

    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['email']) && $_GET['n']) ? $record['email']:'',
      );

    $form['phonenumber'] = array (
      '#type' => 'textfield',
      '#title' => t('Phone nber:'),
      '#required' => TRUE,
      '#default_value' => (isset($record['phonenumber']) && $_GET['n']) ? $record['phonenumber']:'',
       );

    $form['status'] = array (
      '#type' => 'select',
      '#title' => ('Status'),
      '#options' => array(
        'Active' => t('Active'),
        'Inactive' => t('Inactive'),
        '#default_value' => (isset($record['status']) && $_GET['n']) ? $record['status']:'',
        ),
      );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {

         $name = $form_state->getValue('first_name');
		 $lname = $form_state->getValue('first_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('first_name', $this->t('First name should only contains characters!!'));
          }
          if(preg_match('/[^A-Za-z]/', $lname)) {
             $form_state->setErrorByName('last_name', $this->t('Last name should only contains characters!!'));
            }

          if (strlen($form_state->getValue('phonenumber')) < 10 ) {
            $form_state->setErrorByName('phonenumber', $this->t('your Phone nber must have 10 digits'));
           }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $fname=$field['first_name'];
    $lname=$field['last_name'];
    $email=$field['email'];
    $pnber=$field['phonenumber'];
    $status=$field['status'];

    if (isset($_GET['n'])) {
          $field  = array(
              'first_name'   => $fname,
			  'last_name'   => $lname,
              'email' =>  $email,
              'phonenumber' =>  $pnber,
              'status' => $status,
          );
          $query = \Drupal::database();
          $query->update('contact_form')
              ->fields($field)
              ->condition('id', $_GET['n'])
              ->execute();
          drupal_set_message("Contact successfully saved!!");
          $form_state->setRedirect('contactForm.contact_list_form');

      }

       else
       {
           $field  = array(
              'first_name'   => $fname,
			  'last_name'   => $lname,
              'email' =>  $email,
              'phonenumber' =>  $pnber,
              'status' => $status,
          );
           $query = \Drupal::database();
           $query ->insert('contact_form')
               ->fields($field)
               ->execute();
           drupal_set_message("Contact successfully saved!!");

           $response = new RedirectResponse("/contactform/list");
           $response->send();
       }
     }

}

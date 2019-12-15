<?php

namespace Drupal\contactForm\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provide validation tests for our custom form.
 */
class MycontactFormTest extends FormTestBase {

  public function validateForm() {
    $form = parent::getMockForm('mycontact_form');
	$email_address = 'anc@fdd.com';
    $form_state = (new FormState())
       ->setValue('email', $email_address);

    $form_validator->validateForm('mycontact_form', $form, $form_state);
    $this->assertTrue($form->validateForm($form, $form_state));
  }
}
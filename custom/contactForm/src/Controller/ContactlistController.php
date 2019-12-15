<?php

/**
* @file
* Contains \Drupal\contactForm\Controller\ContactlistController.php
*/

namespace Drupal\contactForm\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class ContactlistController.
 *
 * @package Drupal\contactForm\Controller
 */
class ContactlistController extends ControllerBase {

  /**
   * Contact Listing.
   *
   * @return form
   *  
   */
  public function contactlist() {
	  
   //create table header
    $header_table = array(
     'id'=>    t('SNo.'),
      'first_name' => t('First Name'),
	  'last_name' => t('Last Name'),
        'phonenumber' => t('Phone Number'),
        'status' => t('Status'),
        'opt' => t('operations'),
        'opt1' => t('operations'),
    );

//select records from table
    $query = \Drupal::database()->select('contact_form', 'cf');
      $query->fields('cf', ['id','first_name','last_name', 'phonenumber','status']);
      $result = $query->execute()->fetchAll();
        $rows=array();
		$i=1;
    foreach($result as $value){
        $del = Url::fromUserInput('/contactForm/form/delete/'.$value->id);
        $edit   = Url::fromUserInput('/contactForm?n='.$value->id);

      //All the data in rows
             $rows[] = array(
                'id' => $i,
                'first_name' => $value->first_name,
                'last_name' => $value->last_name,
                'phonenumber' => $value->phonenumber,
                'status' => $value->status,
                 \Drupal::l('Delete', $del),
                 \Drupal::l('Edit', $edit),
            );
			$i++;
    }
    //Listing of contacts in table format
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];

        return $form;
  }

}

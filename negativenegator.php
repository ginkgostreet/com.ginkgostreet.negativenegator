<?php

require_once 'negativenegator.civix.php';
use CRM_Negativenegator_ExtensionUtil as E;

define('CAN_ENTER_NEGATIVE', 'enter negative values in price fields');

/**
 * place info on price fields in a global so we
 * only have to look things up once.
 */
global $noNegative;

/**
 * Implements hook_civicrm_buildForm()
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm/
 *
 * @param string $formName
 * @param object $form
 * @return void
 */
function negativenegator_civicrm_buildForm($formName, &$form) {
  global $noNegative;

  // bail immediately if user has permission to enter negative values
  if (CRM_Core_Permission::check(CAN_ENTER_NEGATIVE)) {
    return;
  }

  if (is_null($noNegative)) {

    $noNegative = array();

    foreach ($form->_elements as $el) {
      $name = $el->_attributes['name'];
      if (substr($name, 0, 6) == 'price_') {
        try {
          $info = civicrm_api3('PriceField', 'getsingle', array(
            'id' => substr($name, 6),
            'return' => 'html_type,label',
          ));
          if ($info['html_type'] == 'Text') {
            $form->updateElementAttr($name, array(
              'class' => $el->_attributes['class'] . ' no-negative',
              'data-no-negative' => $info['label'],
            ));
            $noNegative[$name] = $info;
          }
        }
        catch (CiviCRM_API3_Exception $e) {
        }
      }
    }
    if (!empty($noNegative)) {
      $form->addFormRule('negativenegator_validate');
      CRM_Core_Resources::singleton()->addScriptFile('com.ginkgostreet.negativenegator', 'js/negativenegator.js');
    }
  }
}

/**
 * form rule: validate that price fields are non-negative
 *
 * @param array $values
 * @return bool|array
 */
function negativenegator_validate($values) {
  global $noNegative;

  if (empty($noNegative)) {
    return TRUE;
  }

  $errors = array();
  foreach ($noNegative as $name => $info) {
    if (!empty($values[$name]) && $values[$name] < 0) {
      $errors[$name] = "{$info['label']} cannot be negative.";
    }
  }
  return empty($errors) ? TRUE : $errors;
}

/**
 * Implements hook_civicrm_permission()
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_permission/
 *
 * @param array $permissions
 * @return void
 */
function negativenegator_civicrm_permission(&$permissions) {
  $permissions[CAN_ENTER_NEGATIVE] = array(
    'CiviContribute: ' . CAN_ENTER_NEGATIVE,
    'Allow negative values to be entered for price fields of type "Text / Numeric Quantity"',
  );
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function negativenegator_civicrm_config(&$config) {
  _negativenegator_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function negativenegator_civicrm_install() {
  _negativenegator_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function negativenegator_civicrm_enable() {
  _negativenegator_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function negativenegator_civicrm_navigationMenu(&$menu) {
  _negativenegator_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _negativenegator_civix_navigationMenu($menu);
} // */

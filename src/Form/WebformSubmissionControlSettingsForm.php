<?php

namespace Drupal\webform_submission_control\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform_submission_control\Util\WebformSubmissioControlUtil;

class WebformSubmissionControlSettingsForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'webform_submission_control_settings';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return ['webform_submission_control.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('webform_submission_control.settings');
    $util = new WebformSubmissioControlUtil();
    $webformOptions = $util->getWebformList();
    $roles = $util->getRoleList();

    $form['field_webform'] = [
      '#type' => 'select',
      '#title' => $this->t('Select the webforms to control'),
      '#description' => $this->t('These webforms will be forced to submit to an entity.'),
      '#options' => !empty($webformOptions) ? $webformOptions : 'No webform available',
      '#default_value' => $config->get('webform'),
      '#multiple' => TRUE,
    ];

    $form['field_role'] = [
      '#type' => 'select',
      '#title' => $this->t('Select the user roles to exclude'),
      '#description' => $this->t('These roles will not be restricted to submit these forms.'),
      '#options' => !empty($roles) ? $roles : '',
      '#default_value' => $config->get('role'),
      '#multiple' => TRUE,
    ];

    $form['field_message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message to display'),
      '#description' => $this->t('This message will be printed to prevent the user.'),
      '#default_value' => $config->get('message'),  
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::service('config.factory')
      ->getEditable('webform_submission_control.settings');
    $config->set('webform', $form_state->getValue('field_webform'));
    $config->set('message', $form_state->getValue('field_message'));
    $config->set('role', $form_state->getValue('field_role'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}

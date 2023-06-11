<?php

namespace Drupal\curso_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CursoConfigForm extends ConfigFormBase
{

  protected function getEditableConfigNames()
  {
    return [
      'curso_config.nuestra_configuracion'
    ];
  }

  public function getFormId()
  {
    return 'curso_config_nuestra_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $config = $this->config('curso_config.nuestra_configuracion');

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Name',
      '#default_value' => $config->get('name'),
    ];

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => 'Label',
      '#default_value' => $config->get('label'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    parent::submitForm($form, $form_state);

    $config = $this->config('curso_config.nuestra_configuracion');

    $config->set('name', $form_state->getValue('name'));
    $config->set('label', $form_state->getValue('label'));
    $config->save();
  }

}

<?php

namespace Drupal\curso_form\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CursoForm extends FormBase {

  /**
   * @var EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {

    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'curso_form_curso_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $node = $this->entityTypeManager->getStorage('node')->load(1);

    $form['checked'] = [
      '#type' => 'checkbox',
      '#title' => 'Check',
      '#description' => 'Si lo marcas veras el campo title',
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => 'Titulo',
      '#access' => $this->currentUser()->isAuthenticated(),
      '#states' => [
        'visible' => [
          ':input[name="checked"]' => [
            'checked' => TRUE,
          ]
        ]
      ]
    ];

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => 'Etiqueta',
    ];

    $form['referencia'] = [
      '#type' => 'entity_autocomplete',
      '#target_type' => 'taxonomy_term',
      '#tags' => TRUE,
//      '#default_value' => $node,
//      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => ['tags'],
      ],
      '#autocreate' => [
        'bundle' => 'tags',
      ],
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Enviar',
    ];

    return $form;
  }

  /**
   * Form validation handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    dpm($form_state->getValue('referencia'), 'referencia');

    $terms = $form_state->getValue('referencia');
    foreach ($terms as $term) {
      if (array_key_exists('entity', $term)) {
        $term['entity']->save();
      }
    }
  }

}

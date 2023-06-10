<?php

namespace  Drupal\curso_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\curso_module\Services\Repetir;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class CursoController extends ControllerBase
{

    /** @var Repetir */
    private $repetir;

    public function __construct(Repetir $repetir)
    {
        $this->repetir = $repetir;
    }

    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get(id: 'curso_module.repetir')
        );
    }

    public function home(NodeInterface $node)
    {

        $resultado = $this->repetir->repetir(palabra: 'curso ', cantidad: 5);

        return [
            '#theme' => 'curso_plantilla',
            '#etiqueta' => $node->label(),
            '#tipo' => $resultado,
        ];
    }

    public function formController(){

      $form = $this->formBuilder()->getForm('\Drupal\curso_module\Form\CursoForm');

      $build = [];

      $markup = ['#markup' => 'Esta es la pagina del formulario'];

      $build[] = $markup;
      $build[] = $form;

      return $build;
    }
}

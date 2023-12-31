<?php

namespace Drupal\curso_module\Services;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;

class Repetir
{
    /** @var MessengerInterface */
    private $messenger;

    /** @var EntityTypeManagerInterface */
    private $entityTypeManager;

    public function __construct(MessengerInterface $messenger, EntityTypeManagerInterface $entityTypeManager)
    {
        $this->messenger = $messenger;
        $this->entityTypeManager = $entityTypeManager;
    }

    public function repetir($palabra, $cantidad = 3)
    {
        $this->messenger->addError(message: 'Esto es un error del servicio repetir.');
        return str_repeat($palabra, $cantidad);
    }
}

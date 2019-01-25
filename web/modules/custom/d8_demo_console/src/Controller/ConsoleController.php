<?php

namespace Drupal\d8_demo_console\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ConsoleController.
 */
class ConsoleController extends ControllerBase {

  /**
   * Helloconsole.
   *
   * @return string
   *   Return Hello string.
   */
  public function helloConsole() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: helloConsole')
    ];
  }

}

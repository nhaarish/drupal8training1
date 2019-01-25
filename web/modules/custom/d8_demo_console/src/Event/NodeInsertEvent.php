<?php
namespace Drupal\d8_demo_console\Event;

use Symfony\Component\EventDispatcher\Event;
use Drupal\node\NodeInterface;

class NodeInsertEvent extends Event {
  public $node;
  public function __construct(NodeInterface $node) {
    $this->node = $node;
  }
}
<?php

namespace Drupal\d8_demo_console\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\node\NodeInterface;
use Drupal\d8_demo_console\Event\NodeInsertEvent;

/**
 * d8_demo_console event subscriber.
 */
class NodeInsertSubscriber implements EventSubscriberInterface {

  /**
   * The messenger.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Logger Factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $loggerFactory;


  /**
   * Constructs event subscriber.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger.
   */
  public function __construct(MessengerInterface $messenger, LoggerChannelFactory $loggerFactory) {
    $this->messenger = $messenger;
    $this->loggerFactory = $loggerFactory->get('d8_demo_console');
  }

  public function NodeInsertSubscriber(NodeInsertEvent $event) {
    $this->messenger->addStatus(__FUNCTION__);
    $this->loggerFactory->info($event->node->getTitle());
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      'node.insert' => ['nodeInsertSubscriber'],
    ];
  }

}

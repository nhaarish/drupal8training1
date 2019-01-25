<?php

namespace Drupal\d8_demo_console\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\node\Entity\Node;

/**
 * Provides a block cache example block.
 *
 * @Block(
 *   id = "d8_demo_console_block_cache_example",
 *   admin_label = @Translation("block cache example"),
 *   category = @Translation("Custom")
 * )
 */
class BlockCacheExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity.query service.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerAwareInterface
   */
  protected $entityQuery;

  /**
   * Constructs a new BlockCacheExampleBlock instance.
   *
   * @param array $configuration
   *   The plugin configuration, i.e. an array with configuration values keyed
   *   by configuration option name. The special key 'context' may be used to
   *   initialize the defined contexts by setting it to an array of context
   *   values keyed by context names.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Symfony\Component\DependencyInjection\ContainerAwareInterface $entity_query
   *   The entity.query service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, QueryFactory $entity_query) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityQuery = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = $this->entityQuery->get('node')->sort('created','DESC')->range(0,3)->execute();
    $nodes = node_load_multiple($query);
    foreach ($nodes as $node) {
      $output .= $node->title->value;
    }
    $build['content'] = [
      '#markup' => $output,
    ];    
    $build['#cache']['tags'] = ['node_list'];
    //$build['#cache']['tags'] = ['tag:1' 'tag:3','tag:2',]; For specific nodes
    return $build;
  }
}
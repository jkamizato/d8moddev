<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hello_world\HelloWorldSalutation as HelloWorldSalutationService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Hello World Salutation block.
 *
 * @Block(
 * id = "hello_world_salutation_block",
 * admin_label = @Translation("Hello world salutation"),
 * )
 */
class HelloWorldSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface, BlockPluginInterface {


  /**
   * The salutation service.
   *
   * @var \Drupal\hello_world\HelloWorldSalutation
   */
  protected $salutation;

  /**
   * HelloWorldSalutationBlock constructor.
   *
   * @param array $configuration
   *   Default configuration.
   * @param mixed $plugin_id
   *   Plugin id.
   * @param mixed $plugin_definition
   *   The plug definition.
   * @param \Drupal\hello_world\HelloWorldSalutation $salutation
   *   HelloWorldService.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, HelloWorldSalutationService $salutation) {
    $this->salutation = $salutation;
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('hello_world.salutation')
    );
  }

  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * If a block should not be rendered because it has no content, then this
   * method must also ensure to return no content: it must then only return an
   * empty array, or an empty array with #cache set (with cacheability metadata
   * indicating the circumstances for it being empty).
   *
   * @return array
   *   A renderable array representing the content of the block.
   *
   * @see \Drupal\block\BlockViewBuilder
   */
  public function build() {
    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

  /**
   * Default configuration.
   *
   * @return array
   *   List of configuration.
   */
  public function defaultConfiguration() {
    return [
      'enabled' => 1,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->defaultConfiguration();
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#description' => $this->t('Check this block if you wanna enable this feature'),
      '#default_value' => $config['enabled'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $this->configuration['enabled'] = $form_state->getValue('enabled');
  }

}

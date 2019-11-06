<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldSalutation;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * HelloWorldController Class.
 */
class HelloWorldController extends ControllerBase {

  /**
   * Hello World Salutation service.
   *
   * @var Drupal\hello_world\HelloWorldSalutation
   */
  protected $salutation;

  /**
   * HelloWorldController constructor.
   *
   * @param \Drupal\hello_world\HelloWorldSalutation $salutation
   *   Salutation Service.
   */
  public function __construct(HelloWorldSalutation $salutation) {
    $this->salutation = $salutation;
  }

  /**
   * Custom create with container.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Default ContainerInterface.
   *
   * @return \Drupal\Core\Controller\ControllerBase|static
   *   New static container with list of services.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hello_world.salutation')
    );
  }

  /**
   * Hello world render greetings.
   *
   * @return array
   *   Drupal render array.
   */
  public function helloWorld() {
    return [
      '#markup' => $this->salutation->getSalutation(),
    ];
  }

}

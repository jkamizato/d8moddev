<?php

namespace Drupal\Tests\hello_world\Controller;

use Drupal\hello_world\HelloWorldSalutation;
use Drupal\Tests\UnitTestCase;
use Drupal\hello_world\Controller\HelloWorldController;

/**
 * Simple HelloWorldTest Class.
 */
class HelloWorldControllerTest extends UnitTestCase {

  /**
   * Hello World Controller.
   *
   * @var Drupal\hello_world\Controller\HelloWorldController
   */
  protected $controller;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $salutation = $this->getMockBuilder(HelloWorldSalutation::class)->disableOriginalConstructor()->getMock();
    $this->controller = new HelloWorldController($salutation);
    parent::setUp();
  }

  /**
   * Data provider for simpleSum.
   *
   * @return array
   *   Array of data provider.
   */
  public function providerTestSimpleSum() {
    return [
      [2, 2, 4],
      [2, 3, 5],
      [0, -1, -1],
      [10, 20, 30],
      [10, -10, 0],
      [0, 0, 0],
    ];
  }

  /**
   * test SimpleSum method.
   *
   * @dataProvider providerTestSimpleSum
   */
  public function testSimpleSum($a, $b, $sum) {
    $this->assertEquals($sum, $this->controller->sum($a, $b));
  }

}

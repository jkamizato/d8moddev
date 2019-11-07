<?php


namespace Drupal\hello_world\Logger;


use Drupal\Core\Logger\RfcLoggerTrait;
use Psr\Log\LoggerInterface;

class MailLogger implements LoggerInterface {

  use RfcLoggerTrait;

  /**
   * {@inheritDoc}
   */
  public function log($level, $message, array $context = []) {
    
  }

}

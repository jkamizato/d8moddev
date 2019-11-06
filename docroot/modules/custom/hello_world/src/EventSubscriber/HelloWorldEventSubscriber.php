<?php

namespace Drupal\hello_world\EventSubscriber;

use Drupal\Core\Url;
use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * HelloWorldEventSubscriber custom redirect.
 */
class HelloWorldEventSubscriber implements EventSubscriberInterface {

  /**
   * Current user logged.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Current Route Match.
   *
   * @var Drupal\Core\Routing\CurrentRouteMatch
   */
  protected $currentRouteMatch;

  /**
   * HelloWorldEventSubscriber constructor.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $accountProxy
   *   Current User logged.
   * @param \Drupal\Core\Routing\CurrentRouteMatch $currentRouteMatch
   *   Current route match.
   */
  public function __construct(AccountProxyInterface $accountProxy, CurrentRouteMatch $currentRouteMatch) {
    $this->currentUser = $accountProxy;
    $this->currentRouteMatch = $currentRouteMatch;
  }

  /**
   * Returns an array of event names this subscriber wants to listen to.
   *
   * The array keys are event names and the value can be:
   *
   *  * The method name to call (priority defaults to 0)
   *  * An array composed of the method name to call and the priority
   *  * An array of arrays composed of the method names to call and respective
   *    priorities, or 0 if unset
   *
   * For instance:
   *
   *  * ['eventName' => 'methodName']
   *  * ['eventName' => ['methodName', $priority]]
   *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
   *
   * @return array
   *   The event names to listen to.
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['onRequest', 0];
    return $events;
  }

  /**
   * Redirect all non_grata user.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   {@inheritDoc}.
   */
  public function onRequest(GetResponseEvent $event) {
    $route_name = $this->currentRouteMatch->getRouteName();
    if ($route_name !== 'hello_world.hello') {
      return;
    }
    $roles = $this->currentUser->getRoles();
    if (in_array('non_grata', $roles)) {
      $url = Url::fromUri('internal:/');
      $event->setResponse(new LocalRedirectResponse($url->toString()));
    }
  }

}

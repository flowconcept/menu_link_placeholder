<?php

/**
 * @file
 * Contains \Drupal\Core\Menu\DefaultMenuLinkTreeManipulators.
 */

namespace Drupal\menu_link_placeholder\Menu;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Menu\DefaultMenuLinkTreeManipulators;
use Drupal\Core\Menu\MenuLinkInterface;

/**
 * {@inheritdoc}
 */
class MenuLinkPlaceholderMenuLinkTreeManipulators extends DefaultMenuLinkTreeManipulators {

    /**
     * Checks access for one menu link instance.
     *
     * @param \Drupal\Core\Menu\MenuLinkInterface $instance
     *   The menu link instance.
     *
     * @return \Drupal\Core\Access\AccessResultInterface
     *   The access result.
     */
    protected function menuLinkCheckAccess(MenuLinkInterface $instance) {
        $access_result = NULL;
        if ($this->account->hasPermission('link to any page')) {
            $access_result = AccessResult::allowed();
        }
        else {
            $url = $instance->getUrlObject();
            $route = $url->toUriString();

            // When no route name is specified, this must be an external link.
            if (!$url->isRouted() || $route == 'route:') {
                $access_result = AccessResult::allowed();
            }
            else {
                $access_result = $this->accessManager->checkNamedRoute($url->getRouteName(), $url->getRouteParameters(), $this->account, TRUE);
            }
        }
        return $access_result->cachePerPermissions();
    }

}

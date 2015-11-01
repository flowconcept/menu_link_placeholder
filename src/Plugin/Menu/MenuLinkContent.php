<?php

/**
 * @file
 * Contains \Drupal\menu_link_content\Plugin\Menu\MenuLinkContent.
 */

namespace Drupal\menu_link_placeholder\Plugin\Menu;

use Drupal\menu_link_content\Plugin\Menu\MenuLinkContent as OriginalMenuLinkContent;
use Drupal\Core\Url;

/**
 * Provides the menu link plugin for content menu links.
 */
class MenuLinkContent extends OriginalMenuLinkContent {
  public function hasLink() {
    return (bool) $this->getEntity()->getUrlObject();
  }

  /**
   * {@inheritdoc}
   */
  public function getUrlObject($title_attribute = TRUE) {
    if ($this->getEntity()->getUrlObject()) {
      $options = $this->getOptions();
      if ($title_attribute && $description = $this->getDescription()) {
        $options['attributes']['title'] = $description;
      }
      if (empty($this->pluginDefinition['url'])) {
        return new Url($this->pluginDefinition['route_name'], $this->pluginDefinition['route_parameters'], $options);
      }
      else {
        return Url::fromUri($this->pluginDefinition['url'], $options);
      }
    }
    else {
      // Because the edit link has custom access control we need to return a link the anon user has access to.
      return Url::fromUserInput('/');
    }
  }
}

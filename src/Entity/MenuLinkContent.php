<?php

/**
 * @file
 * Contains \Drupal\menu_link_content\Entity\MenuLinkContent.
 */

namespace Drupal\menu_link_placeholder\Entity;

use Drupal\menu_link_content\Entity\MenuLinkContent as OriginalMenuLinkContent;

/**
 * Defines the menu link content entity class.
 *
 * @property \Drupal\link\LinkItemInterface link
 * @property \Drupal\Core\Field\FieldItemList rediscover
 *
 * @ContentEntityType(
 *   id = "menu_link_content",
 *   label = @Translation("Custom menu link"),
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "storage_schema" = "Drupal\menu_link_content\MenuLinkContentStorageSchema",
 *     "access" = "Drupal\menu_link_content\MenuLinkContentAccessControlHandler",
 *     "form" = {
 *       "default" = "Drupal\menu_link_content\Form\MenuLinkContentForm",
 *       "delete" = "Drupal\menu_link_content\Form\MenuLinkContentDeleteForm"
 *     }
 *   },
 *   admin_permission = "administer menu",
 *   base_table = "menu_link_content",
 *   data_table = "menu_link_content_data",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid",
 *     "bundle" = "bundle"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/menu/item/{menu_link_content}/edit",
 *     "edit-form" = "/admin/structure/menu/item/{menu_link_content}/edit",
 *     "delete-form" = "/admin/structure/menu/item/{menu_link_content}/delete",
 *   }
 * )
 */
class MenuLinkContent extends OriginalMenuLinkContent {
  /**
   * {@inheritdoc}
   */
  public function getUrlObject() {
    if (isset($this->link->first()->uri)) {
      return $this->link->first()->getUrl();
    }
  }
}

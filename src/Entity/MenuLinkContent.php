<?php

/**
 * @file
 * Contains \Drupal\menu_link_content\Entity\MenuLinkContent.
 */

namespace Drupal\menu_link_placeholder\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\link\LinkItemInterface;
use Drupal\menu_link_content\MenuLinkContentInterface;
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

  /**
   * {@inheritdoc}
   */
  public function getPluginDefinition() {
    $definition = array();
    $definition['class'] = 'Drupal\menu_link_placeholder\Plugin\Menu\MenuLinkContent';
    $definition['menu_name'] = $this->getMenuName();

    if ($url_object = $this->getUrlObject()) {
      $definition['url'] = NULL;
      $definition['route_name'] = NULL;
      $definition['route_parameters'] = [];
      if (!$url_object->isRouted()) {
        $definition['url'] = $url_object->getUri();
      }
      else {
        $definition['route_name'] = $url_object->getRouteName();
        $definition['route_parameters'] = $url_object->getRouteParameters();
      }
      $definition['options'] = $url_object->getOptions();
    }

    // Empty menu link.
    else {
      $definition['url'] = NULL;
      $definition['route_name'] = NULL;
      $definition['route_parameters'] = [];
    }

    $definition['title'] = $this->getTitle();
    $definition['description'] = $this->getDescription();
    $definition['weight'] = $this->getWeight();
    $definition['id'] = $this->getPluginId();
    $definition['metadata'] = array('entity_id' => $this->id());
    $definition['form_class'] = '\Drupal\menu_link_content\Form\MenuLinkContentForm';
    $definition['enabled'] = $this->isEnabled() ? 1 : 0;
    $definition['expanded'] = $this->isExpanded() ? 1 : 0;
    $definition['provider'] = 'menu_link_content';
    $definition['discovered'] = 0;
    $definition['parent'] = $this->getParentId();

    return $definition;
  }
}

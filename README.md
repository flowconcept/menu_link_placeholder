# Description
This module makes it possible to create a menu item without a link. 

# How to use
- Install the module
- Add the contents of menu_link_placeholder.services.yml to your services.yml
- Change your menu.html.twig to have something like:

```
{% if item.no_link %}
  <span {{ item.url.attributes }}>{{ item.title|raw }}</span>
{% else %}
  {{ link(item.title, item.url) }}
{% endif %}
```
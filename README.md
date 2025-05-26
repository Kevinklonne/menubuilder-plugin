# Menu builder plugin

This plugin allows you to create and manage menus for your website.

### Features

- Create and manage menus
- Add menu items to a menu
- Duplicate a menu
- Include nested menu items
- Replace a menu item with nested menu items
- Add CSS classes to a menu or a menu item
- Add custom attributes to a menu item

## Installation

1. Install the plugin via the October CMS backend.
2. Create a new menu in the backend.
3. Add menu items to the menu.
4. Use the `RenderMenu` component to render the menu on your website.

## Usage

### RenderMenu component

The `RenderMenu` component renders a menu on your website. You can use it in a page or a layout.

```twig
{% component 'RenderMenu' %}
```

The component has one property:

- `menuCode` - The code of the menu to render. You can find the code in the backend when you edit a menu.

### Customizing the menu

You can customize the menu by overriding the `RenderMenu` component's partials.

The default partial is `components/rendermenu/default.htm`. You can copy this file to your theme and modify it to your liking.

The partial has access to the following variables:

- `menu` - The menu object.
- `menuItems` - The menu items.

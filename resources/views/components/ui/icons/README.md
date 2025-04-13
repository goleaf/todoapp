# UI Icons

This directory contains all the icon components used in the application. They are organized by icon set:

## Structure

- `heroicon/`
  - `outline/` - Heroicon outline variants
  - `solid/` - Heroicon solid variants
- `phosphor/` - Phosphor icons

## Usage

Icons can be used by referencing their path:

```blade
<x-ui.icons.heroicon.outline.check-circle />
<x-ui.icons.heroicon.solid.check-circle />
<x-ui.icons.phosphor.house-line />
```

Or through the icon component:

```blade
<x-ui.icon icon="heroicon-outline-check-circle" />
<x-ui.icon icon="heroicon-solid-check-circle" />
<x-ui.icon icon="phosphor-house-line" />
``` 
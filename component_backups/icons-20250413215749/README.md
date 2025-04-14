# UI Icons

This directory contains all the icon components used throughout the application.

## Structure

Icons are organized by type:

- `heroicon/outline/` - Heroicons Outline style
- `heroicon/solid/` - Heroicons Solid style
- `phosphor/` - Phosphor icons

## Usage

Icons can be used with the `x-ui.icon` component:

```blade
<x-ui.icon icon="heroicon-o-information-circle" class="w-5 h-5" />
<x-ui.icon icon="heroicon-s-check-circle" class="w-5 h-5" />
<x-ui.icon icon="phosphor-house-line" class="w-5 h-5" />
```

Or directly using their component paths:

```blade
<x-ui.icons.heroicon.outline.information-circle class="w-5 h-5" />
<x-ui.icons.heroicon.solid.check-circle class="w-5 h-5" />
<x-ui.icons.phosphor.house-line class="w-5 h-5" />
```

## Backwards Compatibility

For backwards compatibility, the following legacy paths are still supported:

- `x-ui.icon.heroicon-o-information-circle` → `x-ui.icons.heroicon.outline.information-circle`
- `x-ui.icon.heroicon-s-check-circle` → `x-ui.icons.heroicon.solid.check-circle`
- `x-ui.icon.phosphor-house-line` → `x-ui.icons.phosphor.house-line` 
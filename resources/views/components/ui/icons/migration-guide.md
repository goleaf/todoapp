# Icon Migration Guide

## Overview

We've consolidated all icon components into a single, organized directory structure. This makes it easier to:

- Find and use icons
- Maintain consistent styling
- Add new icon sets in the future

## New Structure

Old structure:
```
resources/views/components/ui/icon/phosphor-*.blade.php
resources/views/components/ui/icon/phosphor/*.blade.php
resources/views/components/ui/icon/heroicon-o-*.blade.php
resources/views/components/ui/icon/heroicon-s-*.blade.php
```

New structure:
```
resources/views/components/ui/icons/
├── heroicon/
│   ├── outline/
│   │   └── *.blade.php
│   └── solid/
│       └── *.blade.php
└── phosphor/
    └── *.blade.php
```

## Usage

### Old way:

```blade
<x-ui.icon icon="heroicon-o-check-circle" />
<x-ui.icon icon="heroicon-s-check-circle" />
<x-ui.icon icon="phosphor-house-line" />
```

### New way (with backward compatibility):

```blade
<x-ui.icon icon="heroicon-outline-check-circle" />  <!-- Preferred -->
<x-ui.icon icon="heroicon-solid-check-circle" />    <!-- Preferred -->
<x-ui.icon icon="phosphor-house-line" />

<!-- Legacy formats still work -->
<x-ui.icon icon="heroicon-o-check-circle" />
<x-ui.icon icon="heroicon-s-check-circle" />
```

### Direct component usage:

You can also use the components directly:

```blade
<x-ui.icons.heroicon.outline.check-circle />
<x-ui.icons.heroicon.solid.check-circle />
<x-ui.icons.phosphor.house-line />
```

## Migration Steps

1. All existing icons have been migrated to the new structure
2. The original components will be maintained for backward compatibility for now 
3. For new code, use the new structure and naming conventions
4. Over time, we'll update existing code to use the new structure 
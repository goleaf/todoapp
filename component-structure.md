# Component Structure Changes

## Overview

This document outlines the changes made to organize and standardize the component structure in our application. The goal was to:

1. Move all components into appropriate category subfolders
2. Update all blade templates to use the standardized naming conventions
3. Identify and document potential duplications for future optimization

## Component Categories

Components are now organized into the following categories:

- **Input Components** (`input/`): Form controls and input-related components
- **UI Components** (`ui/`): Basic UI elements like buttons, cards, etc.
- **Layout Components** (`layout/`): Structural components like app layouts, headers, etc.
- **Data Components** (`data/`): Components for displaying and manipulating data
- **Authentication Components** (`auth/`): Authentication-related components
- **Feedback Components** (`feedback/`): Alerts, errors, and other feedback mechanisms
- **Settings Components** (`settings/`): Settings-related components

## Naming Conventions

All component references now follow these patterns:

- `<x-input.*>` for input components
- `<x-ui.*>` for UI components
- `<x-layout.*>` for layout components
- `<x-data.*>` for data components
- `<x-auth.*>` for authentication components
- `<x-feedback.*>` for feedback components

This ensures consistency and makes the component's purpose immediately clear from its name.

## Component Structure

Each component now follows this structure:
- Category folder (`resources/views/components/{category}/`)
- Component subfolder (`resources/views/components/{category}/{component-name}/`)
- Index file for main implementation (`resources/views/components/{category}/{component-name}/index.blade.php`)
- Additional files for subcomponents if needed

## Scripts Used

Three scripts were created to implement these changes:

1. `update-components.sh`: Updated all component references in Blade templates
2. `organize-components.sh`: Organized component files into appropriate subfolders
3. `fix-form-tags.sh`: Fixed form group closing tags that were missed in the initial update
4. `merge-components.sh`: Identified potential duplicate components for review

## Potential Duplications

Some components with similar functionality were identified and documented in `COMPONENT-NOTES.md` for future review:

1. Navigation Items: `layout/navbar/item` and `layout/navlist/item`
2. UI Item Components: `ui/dropdown/item` and `ui/popover/item`
3. Group Components: `input/form/group`, `ui/button/group`, and `layout/navlist/group`

## Current Component Inventory

```
resources/views/components/
├── auth/
│   ├── auth-header/
│   │   └── index.blade.php
│   └── auth-session-status/
│       └── index.blade.php
├── data/
│   └── table/
│       ├── cell.blade.php
│       ├── heading.blade.php
│       ├── index.blade.php
│       └── row.blade.php
├── feedback/
│   ├── action-message/
│   │   └── index.blade.php
│   ├── alert/
│   │   └── index.blade.php
│   └── error/
│       └── index.blade.php
├── input/
│   ├── checkbox/
│   │   └── index.blade.php
│   ├── field/
│   │   └── index.blade.php
│   ├── form/
│   │   ├── group.blade.php
│   │   └── index.blade.php
│   ├── input/
│   │   └── index.blade.php
│   ├── input-error/
│   │   └── index.blade.php
│   ├── label/
│   │   └── index.blade.php
│   ├── radio/
│   │   └── index.blade.php
│   ├── select/
│   │   └── index.blade.php
│   └── textarea/
│       └── index.blade.php
├── layout/
│   ├── app/
│   │   ├── app.blade.php
│   │   ├── header.blade.php
│   │   ├── index.blade.php
│   │   └── sidebar.blade.php
│   ├── app-logo/
│   │   └── index.blade.php
│   ├── app-logo-icon/
│   │   └── index.blade.php
│   ├── auth/
│   │   ├── auth.blade.php
│   │   ├── card.blade.php
│   │   ├── index.blade.php
│   │   ├── simple.blade.php
│   │   └── split.blade.php
│   ├── header/
│   │   └── index.blade.php
│   ├── heading/
│   │   └── index.blade.php
│   ├── navbar/
│   │   ├── index.blade.php
│   │   └── item.blade.php
│   ├── navlist/
│   │   ├── group.blade.php
│   │   ├── index.blade.php
│   │   └── item.blade.php
│   ├── placeholder-pattern/
│   │   └── index.blade.php
│   ├── section-header/
│   │   └── index.blade.php
│   ├── separator/
│   │   └── index.blade.php
│   ├── sidebar/
│   │   ├── index.blade.php
│   │   └── toggle.blade.php
│   ├── spacer/
│   │   └── index.blade.php
│   ├── subheading/
│   │   └── index.blade.php
│   └── text/
│       └── index.blade.php
├── settings/
│   └── layout/
│       └── index.blade.php
└── ui/
    ├── avatar/
    │   └── index.blade.php
    ├── badge/
    │   └── index.blade.php
    ├── button/
    │   ├── group.blade.php
    │   └── index.blade.php
    ├── card/
    │   └── index.blade.php
    ├── container/
    │   └── index.blade.php
    ├── dark-mode-toggle/
    │   └── index.blade.php
    ├── dropdown/
    │   ├── item/
    │   │   └── index.blade.php
    │   └── menu/
    │       └── index.blade.php
    ├── empty-state/
    │   └── index.blade.php
    ├── link/
    │   └── index.blade.php
    ├── modal/
    │   └── index.blade.php
    ├── popover/
    │   ├── index.blade.php
    │   ├── item/
    │   │   └── index.blade.php
    │   └── separator.blade.php
    └── status/
        └── index.blade.php
```

# Component Hierarchy

## components/auth
- components/auth/auth-header.blade.php
- components/auth/auth-session-status.blade.php

## components/data
- components/data/table.blade.php

## components/data/table
- components/data/table/cell.blade.php
- components/data/table/heading.blade.php
- components/data/table/index.blade.php
- components/data/table/row.blade.php

## components/feedback
- components/feedback/action-message.blade.php
- components/feedback/error.blade.php

## components/feedback/action-message
- components/feedback/action-message/index.blade.php

## components/feedback/alert
- components/feedback/alert/index.blade.php

## components/feedback/error
- components/feedback/error/index.blade.php

## components/input
- components/input/field.blade.php
- components/input/input.blade.php
- components/input/input-error.blade.php
- components/input/label.blade.php
- components/input/radio.blade.php
- components/input/textarea.blade.php

## components/input/checkbox
- components/input/checkbox/index.blade.php

## components/input/field
- components/input/field/index.blade.php

## components/input/form
- components/input/form/group.blade.php
- components/input/form/index.blade.php

## components/input/input
- components/input/input/index.blade.php

## components/input/input-error
- components/input/input-error/index.blade.php

## components/input/label
- components/input/label/index.blade.php

## components/input/radio
- components/input/radio/index.blade.php

## components/input/select
- components/input/select/index.blade.php

## components/input/textarea
- components/input/textarea/index.blade.php

## components/layout
- components/layout/app.blade.php
- components/layout/app-logo.blade.php
- components/layout/app-logo-icon.blade.php
- components/layout/auth.blade.php
- components/layout/header.blade.php
- components/layout/heading.blade.php
- components/layout/placeholder-pattern.blade.php
- components/layout/section-header.blade.php
- components/layout/separator.blade.php
- components/layout/spacer.blade.php
- components/layout/subheading.blade.php
- components/layout/text.blade.php

## components/layout/app
- components/layout/app/header.blade.php
- components/layout/app/sidebar.blade.php

## components/layout/app-logo
- components/layout/app-logo/index.blade.php

## components/layout/app-logo-icon
- components/layout/app-logo-icon/index.blade.php

## components/layout/auth
- components/layout/auth/card.blade.php
- components/layout/auth/simple.blade.php
- components/layout/auth/split.blade.php

## components/layout/header
- components/layout/header/index.blade.php

## components/layout/heading
- components/layout/heading/index.blade.php

## components/layout/navbar
- components/layout/navbar/index.blade.php
- components/layout/navbar/item.blade.php

## components/layout/navlist
- components/layout/navlist/group.blade.php
- components/layout/navlist/index.blade.php
- components/layout/navlist/item.blade.php

## components/layout/placeholder-pattern
- components/layout/placeholder-pattern/index.blade.php

## components/layout/section-header
- components/layout/section-header/index.blade.php

## components/layout/separator
- components/layout/separator/index.blade.php

## components/layout/sidebar
- components/layout/sidebar/index.blade.php
- components/layout/sidebar/toggle.blade.php

## components/layout/spacer
- components/layout/spacer/index.blade.php

## components/layout/subheading
- components/layout/subheading/index.blade.php

## components/layout/text
- components/layout/text/index.blade.php

## components/settings
- components/settings/layout.blade.php

## components/ui
- components/ui/container.blade.php
- components/ui/dark-mode-toggle.blade.php
- components/ui/empty-state.blade.php
- components/ui/link.blade.php
- components/ui/modal.blade.php

## components/ui/avatar
- components/ui/avatar/index.blade.php

## components/ui/badge
- components/ui/badge/index.blade.php

## components/ui/button
- components/ui/button/group.blade.php
- components/ui/button/index.blade.php

## components/ui/card
- components/ui/card/index.blade.php

## components/ui/container
- components/ui/container/index.blade.php

## components/ui/dark-mode-toggle
- components/ui/dark-mode-toggle/index.blade.php

## components/ui/dropdown
- components/ui/dropdown/item.blade.php
- components/ui/dropdown/menu.blade.php

## components/ui/empty-state
- components/ui/empty-state/index.blade.php

## components/ui/link
- components/ui/link/index.blade.php

## components/ui/modal
- components/ui/modal/index.blade.php

## components/ui/popover
- components/ui/popover/index.blade.php
- components/ui/popover/item.blade.php
- components/ui/popover/separator.blade.php

## components/ui/status
- components/ui/status/index.blade.php


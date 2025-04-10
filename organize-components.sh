#!/bin/bash

# Create directories if they don't exist
mkdir -p resources/views/components/ui/avatar
mkdir -p resources/views/components/ui/badge
mkdir -p resources/views/components/ui/card
mkdir -p resources/views/components/input/form
mkdir -p resources/views/components/input/checkbox
mkdir -p resources/views/components/input/select
mkdir -p resources/views/components/layout/app
mkdir -p resources/views/components/data/table
mkdir -p resources/views/components/feedback/alert

# Move files to their appropriate locations
if [ -f "resources/views/components/ui/button.blade.php" ]; then
  mv resources/views/components/ui/button.blade.php resources/views/components/ui/button/index.blade.php
fi

if [ -f "resources/views/components/ui/button/group.blade.php" ]; then
  mv resources/views/components/ui/button/group.blade.php resources/views/components/ui/button/group.blade.php
fi

if [ -f "resources/views/components/ui/avatar.blade.php" ]; then
  mv resources/views/components/ui/avatar.blade.php resources/views/components/ui/avatar/index.blade.php
fi

if [ -f "resources/views/components/ui/badge.blade.php" ]; then
  mv resources/views/components/ui/badge.blade.php resources/views/components/ui/badge/index.blade.php
fi

if [ -f "resources/views/components/ui/card.blade.php" ]; then
  mv resources/views/components/ui/card.blade.php resources/views/components/ui/card/index.blade.php
fi

if [ -f "resources/views/components/ui/dropdown-item.blade.php" ]; then
  mv resources/views/components/ui/dropdown-item.blade.php resources/views/components/ui/dropdown/item.blade.php
fi

if [ -f "resources/views/components/ui/dropdown-menu.blade.php" ]; then
  mv resources/views/components/ui/dropdown-menu.blade.php resources/views/components/ui/dropdown/menu.blade.php
fi

if [ -f "resources/views/components/input/form.blade.php" ]; then
  mv resources/views/components/input/form.blade.php resources/views/components/input/form/index.blade.php
fi

if [ -f "resources/views/components/input/checkbox.blade.php" ]; then
  mv resources/views/components/input/checkbox.blade.php resources/views/components/input/checkbox/index.blade.php
fi

if [ -f "resources/views/components/input/select.blade.php" ]; then
  mv resources/views/components/input/select.blade.php resources/views/components/input/select/index.blade.php
fi

if [ -f "resources/views/components/data/table.blade.php" ]; then
  cp resources/views/components/data/table.blade.php resources/views/components/data/table/index.blade.php
fi

# Remove root components after they've been copied to subdirectories
echo "Organization complete. Remember to update references in your templates." 
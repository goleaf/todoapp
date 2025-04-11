#!/bin/bash

# Script to update dynamic components and heroicon references to match namespace pattern

echo "Starting final component upgrade process..."

# Handle dynamic components
echo "Updating dynamic components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dynamic-component/<x-ui.dynamic-component/g' {} \;

# Handle heroicon components in the icon wrapper components
echo "Updating heroicon references in icon wrapper components..."
sed -i 's/<x-heroicon-o-/<x-ui.icon.heroicon-o-/g' resources/views/components/ui/icon/heroicon-o/index.blade.php
sed -i 's/<x-heroicon-s-/<x-ui.icon.heroicon-s-/g' resources/views/components/ui/icon/heroicon-s/index.blade.php

# Just in case there are any direct heroicon references in other files
echo "Checking for any direct heroicon references in other files..."
find resources/views -type f -name "*.blade.php" -not -path "*/components/ui/icon/*" -exec sed -i 's/<x-heroicon-o-/<x-ui.icon.heroicon-o-/g' {} \;
find resources/views -type f -name "*.blade.php" -not -path "*/components/ui/icon/*" -exec sed -i 's/<x-heroicon-s-/<x-ui.icon.heroicon-s-/g' {} \;

echo "Final component upgrade completed!"

# Commit the changes to Git
echo "Committing changes to Git..."
git add resources/views
git commit -m "Updated dynamic components and heroicon references to follow naming convention"
git push

echo "All done! Changes have been pushed to Git." 
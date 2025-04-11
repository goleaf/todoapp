#!/bin/bash

# Script to update remaining component references that weren't caught by the main upgrade

echo "Starting remaining component upgrade process..."

# Handle phosphor icon components
echo "Updating Phosphor icon components..."
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-phosphor-/<x-ui.icon.phosphor-/g' {} \;

# Check for any other non-namespaced components and handle them if needed
echo "Checking for any other non-namespaced components..."
grep -r "<x-[^\.]*" --include="*.blade.php" resources/views | grep -v "<x-slot" | grep -v "<x-ui\." | grep -v "<x-input\." | grep -v "<x-data\." | grep -v "<x-layout\." | grep -v "<x-auth\." | grep -v "<x-feedback\." | grep -v "<x-settings\." | grep -v "<x-phosphor" | grep -v "components/\.sh" | grep -v "\.mdc"

echo "Remaining component upgrade completed!"

# Commit the changes to Git
echo "Committing changes to Git..."
git add resources/views
git commit -m "Updated remaining Blade component references to follow naming convention"
git push

echo "All done! Changes have been pushed to Git." 
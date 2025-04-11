#!/bin/bash

echo "Updating layout references in blade templates..."

# Arrays to hold files that need updating
declare -a APP_LAYOUT_FILES=()
declare -a GUEST_LAYOUT_FILES=()
declare -a SETTINGS_LAYOUT_FILES=()

# Find files using x-app-layout
echo "Finding files using x-app-layout..."
while IFS= read -r file; do
    APP_LAYOUT_FILES+=("$file")
done < <(grep -l "<x-app-layout" $(find resources/views -name "*.blade.php"))

# Find files using x-guest-layout
echo "Finding files using x-guest-layout..."
while IFS= read -r file; do
    GUEST_LAYOUT_FILES+=("$file")
done < <(grep -l "<x-guest-layout" $(find resources/views -name "*.blade.php"))

# Find files using x-settings-layout
echo "Finding files using x-settings-layout..."
while IFS= read -r file; do
    SETTINGS_LAYOUT_FILES+=("$file")
done < <(grep -l "<x-settings-layout" $(find resources/views -name "*.blade.php"))

# Count of files found for each layout
echo "Found ${#APP_LAYOUT_FILES[@]} files using app layout"
echo "Found ${#GUEST_LAYOUT_FILES[@]} files using guest layout"
echo "Found ${#SETTINGS_LAYOUT_FILES[@]} files using settings layout"

# Update app layout references
for file in "${APP_LAYOUT_FILES[@]}"; do
    echo "Updating app layout in $file"
    sed -i 's/<x-app-layout>/<x-layout.app>/g' "$file"
    sed -i 's/<\/x-app-layout>/<\/x-layout.app>/g' "$file"
done

# Update guest layout references
for file in "${GUEST_LAYOUT_FILES[@]}"; do
    echo "Updating guest layout in $file"
    sed -i 's/<x-guest-layout>/<x-layout.auth>/g' "$file"
    sed -i 's/<\/x-guest-layout>/<\/x-layout.auth>/g' "$file"
done

# Update settings layout references
for file in "${SETTINGS_LAYOUT_FILES[@]}"; do
    echo "Updating settings layout in $file"
    sed -i 's/<x-settings-layout>/<x-settings.layout>/g' "$file"
    sed -i 's/<\/x-settings-layout>/<\/x-settings.layout>/g' "$file"
done

echo "Layout reference updates complete!" 
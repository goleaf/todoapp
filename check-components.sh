#!/bin/bash

# This script checks for potential component reference issues

echo "Checking for potential component reference issues..."

# Check for too many nesting levels (more than 2 dots)
echo "Checking for excessive component nesting (>2 levels):"
find resources/views -type f -name "*.blade.php" | grep -v ".bak" | xargs grep -l '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*' || echo "None found"

# Check for references to components that might not exist
echo ""
echo "Getting list of all defined components:"
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > defined-components.txt

echo ""
echo "Suspected invalid component references:"
for component in $(grep -r '<x-' resources/views --include="*.blade.php" | grep -v ".bak" | grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*' | sort -u | sed 's/<x-//g'); do
    if ! grep -q "^$component$" defined-components.txt; then
        echo "$component"
    fi
done

echo ""
echo "Component check completed." 
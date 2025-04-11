#!/bin/bash

echo "Merging duplicate components with similar functionality..."

# Check if navlist/item and navbar/item functionality should be merged

# First, check if the navbar/item component exists
if [ -f "resources/views/components/layout/navbar/item.blade.php" ]; then
    # Create a backup of the original file
    cp resources/views/components/layout/navbar/item.blade.php resources/views/components/layout/navbar/item.blade.php.bak
    
    # If navlist/item also exists, check if they have similar functionality
    if [ -f "resources/views/components/layout/navlist/item.blade.php" ]; then
        # If they have different implementations, keep both but consider merging manually later
        echo "Both navbar/item and navlist/item exist - consider manual review for potential merger"
    fi
fi

# Check for dropdown/item and popover/item components
if [ -f "resources/views/components/ui/dropdown/item/index.blade.php" ] && [ -f "resources/views/components/ui/popover/item.blade.php" ]; then
    echo "Found both dropdown/item and popover/item components - consider consolidating their functionality"
    # Copy the popover item file for backup
    mkdir -p /tmp/todoapp-components/to-merge
    cp resources/views/components/ui/popover/item.blade.php /tmp/todoapp-components/to-merge/
    
    # Rename the popover item to index.blade.php if it's not already named that
    if [ -f "resources/views/components/ui/popover/item.blade.php" ]; then
        mkdir -p resources/views/components/ui/popover/item
        mv resources/views/components/ui/popover/item.blade.php resources/views/components/ui/popover/item/index.blade.php
    fi
fi

# Check for duplicate index.blade.php files with different implementations
# These were identified earlier during the component organization
if [ -d "/tmp/todoapp-components/duplicates" ]; then
    echo "Found duplicate files during previous organization. These have been preserved in /tmp/todoapp-components/duplicates."
    echo "Consider manually reviewing these files to ensure functionality is not lost."
fi

# Create a note about potential duplicate components
cat > COMPONENT-NOTES.md << EOL
# Component Duplications and Merge Notes

This document outlines potential component duplications that should be reviewed to ensure functionality is not lost.

## Potential Duplications

1. **Navigation Items**:
   - \`layout/navbar/item\` and \`layout/navlist/item\` - These have similar functionality for navigation elements.
   - Consider consolidating these into a single reusable component.

2. **UI Item Components**:
   - \`ui/dropdown/item\` and \`ui/popover/item\` - These handle similar interactive menu items.
   - Consider creating a shared base component that both can extend.

3. **Group Components**:
   - \`input/form/group\`, \`ui/button/group\`, and \`layout/navlist/group\` all provide grouping functionality.
   - Each serves a different purpose, but they might benefit from shared traits or utilities.

## Best Practices for Future Development

1. **Component Naming**:
   - Use descriptive, consistent naming within each category.
   - Follow the pattern: \`{category}.{component-name}\` (e.g., \`ui.button\`).

2. **Component Structure**:
   - Keep all components in their respective category folders.
   - Use \`index.blade.php\` for the main component implementation.
   - Use subfolders for component variants or related pieces.

3. **Avoid Duplication**:
   - Before creating a new component, check if similar functionality already exists.
   - Consider extending or adapting existing components for new use cases.
EOL

echo "Created COMPONENT-NOTES.md with recommendations for future component development."
echo "Component merging suggestions complete!" 
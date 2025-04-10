#!/bin/bash

echo "Removing duplicate component files..."

# List of duplicates to remove
DUPLICATES=(
    # Input components
    "resources/views/components/input/input.blade.php"
    "resources/views/components/input/textarea.blade.php"
    "resources/views/components/input/radio.blade.php"
    "resources/views/components/input/input-error.blade.php"
    "resources/views/components/input/label.blade.php"
    "resources/views/components/input/field.blade.php"
    
    # UI components
    "resources/views/components/ui/modal.blade.php"
    "resources/views/components/ui/empty-state.blade.php"
    "resources/views/components/ui/container.blade.php"
    "resources/views/components/ui/link.blade.php"
    "resources/views/components/ui/dark-mode-toggle.blade.php"
    
    # Layout components
    "resources/views/components/layout/heading.blade.php"
    "resources/views/components/layout/subheading.blade.php"
    "resources/views/components/layout/text.blade.php"
    "resources/views/components/layout/separator.blade.php"
    "resources/views/components/layout/spacer.blade.php"
    "resources/views/components/layout/header.blade.php"
    "resources/views/components/layout/section-header.blade.php"
    "resources/views/components/layout/app-logo.blade.php"
    "resources/views/components/layout/app-logo-icon.blade.php"
    "resources/views/components/layout/placeholder-pattern.blade.php"
    "resources/views/components/layout/app.blade.php"
    "resources/views/components/layout/auth.blade.php"
    
    # Data components
    "resources/views/components/data/table.blade.php"
    
    # Feedback components
    "resources/views/components/feedback/error.blade.php"
    "resources/views/components/feedback/action-message.blade.php"
)

# Remove each duplicate file
for file in "${DUPLICATES[@]}"; do
    if [ -f "$file" ]; then
        rm "$file"
        echo "  - Removed duplicate: $file"
    else
        echo "  - File not found: $file"
    fi
done

# Special cases
# layout/app.blade.php and layout/auth.blade.php - ensure they only call the index versions

echo "Duplicate removal complete!" 
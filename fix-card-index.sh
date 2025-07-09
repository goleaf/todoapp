#!/bin/bash

# This script fixes the "components.ui.card.index" not found error and similar issues

echo "Fixing card.index component references and similar issues..."

# Create the index.blade.php file in the card directory if it doesn't exist
if [ ! -f "resources/views/components/ui/card/index.blade.php" ]; then
    echo "Creating card index component..."
    
    # Make sure the directory exists
    mkdir -p resources/views/components/ui/card
    
    # Create a symlink to the parent card component
    cat > resources/views/components/ui/card/index.blade.php << 'EOF'
@props([
    'title' => null,
    'footer' => null,
    'header' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden']) }}>
    @if($title || $header)
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
            @if($title)
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">{{ $title }}</h3>
            @endif
            
            @if($header)
                {{ $header }}
            @endif
        </div>
    @endif
    
    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-4 py-4 sm:px-6 border-t border-gray-200 dark:border-gray-700">
            {{ $footer }}
        </div>
    @endif
</div>
EOF
    
    echo "Card index component created."
fi

# Check for other index references that might cause issues
echo "Checking for other component references that might cause issues..."

# Create a list of available component files
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > available-components.txt

# Check all blade templates for component references
referenced_components=$(grep -r '<x-' resources/views --include="*.blade.php" | grep -v ".bak" | grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\(\.[a-zA-Z0-9\-]*\)*' | sort -u | sed 's/<x-//g')

# Check each referenced component against available components
echo "Looking for missing components..."
for component in $referenced_components; do
    if ! grep -q "^$component$" available-components.txt; then
        echo "Missing component reference found: $component"
        
        # Get the base component (remove the last segment)
        base_component=$(echo $component | rev | cut -d. -f2- | rev)
        
        # Check if the base component exists
        if grep -q "^$base_component$" available-components.txt; then
            echo "  Base component exists: $base_component, will redirect references"
            
            # Replace references to the missing component with references to the base component
            find resources/views -type f -name "*.blade.php" | grep -v ".bak" | xargs sed -i "s/<x-$component/<x-$base_component/g"
        fi
    fi
done

echo "Component reference fixes completed." 
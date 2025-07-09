#!/bin/bash

# Script to clean up duplicate PHP blocks and fix other component issues

echo "========================================================"
echo "CLEANING UP COMPONENT PHP BLOCKS"
echo "========================================================"

# Function to clean up a single component file
cleanup_component() {
    local file="$1"
    local component_name=$(echo "$file" | sed 's|resources/views/components/||g' | sed 's|\.blade\.php||g' | sed 's|/|.|g')
    local changes=0
    
    echo "Cleaning component: $component_name"
    
    # Create a backup
    cp "$file" "${file}.bak"
    
    # 1. Remove duplicate PHP initialization blocks
    init_block_count=$(grep -c "@php.*Initialize basic component variables" "$file")
    if [ $init_block_count -gt 1 ]; then
        echo "  - Removing ${init_block_count} duplicate initialization blocks"
        
        # Create a temporary file without duplicate PHP blocks
        awk '
        BEGIN { skip = 0; found_first = 0; }
        {
            if ($0 ~ /@php.*Initialize basic component variables/) {
                if (found_first == 0) {
                    found_first = 1;
                    print;
                } else {
                    skip = 1;
                }
            } else if ($0 ~ /@endphp/ && skip == 1) {
                skip = 0;
            } else if (skip == 0) {
                print;
            }
        }' "$file" > "${file}.tmp"
        
        # Replace the original file with the cleaned version
        mv "${file}.tmp" "$file"
        changes=$((changes+1))
    fi
    
    # 2. Add @props declaration if missing
    if ! grep -q "@props" "$file"; then
        echo "  - Adding missing @props declaration"
        sed -i '1s/^/@props([])\n\n/' "$file"
        changes=$((changes+1))
    fi
    
    # 3. Remove extra empty lines at the beginning
    sed -i '/./,$!d' "$file"
    
    # 4. Fix incomplete @props declarations in app.head component 
    if [[ "$component_name" == "layout.app.head" ]]; then
        echo "  - Fixing incomplete @props declaration in app.head component"
        sed -i '1s/@props\(\['\''title'\'' => config('\''app.name'\'')/@props(['\''title'\'' => config('\''app.name'\'')])/g' "$file"
        changes=$((changes+1))
    fi
    
    if [ $changes -gt 0 ]; then
        echo "  ✅ Component cleaned up successfully"
        return 0
    else
        echo "  ✓ No issues to fix"
        # Remove backup if no changes
        rm "${file}.bak"
        return 1
    fi
}

# Step 1: Process all component files
echo ""
echo "Step 1: Cleaning up all component files..."

total_components=0
cleaned_components=0

find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | while read file; do
    total_components=$((total_components+1))
    cleanup_component "$file" 
    result=$?
    
    if [ $result -eq 0 ]; then
        cleaned_components=$((cleaned_components+1))
    fi
done

echo ""
echo "Component cleanup results:"
echo "Total components processed: $total_components"
echo "Components cleaned up: $cleaned_components"

# Step 2: Extra focus on specific core components
echo ""
echo "Step 2: Checking core components specifically..."

# List of core components to check specifically
core_components=(
    "layout.app.head"
    "layout.app.header"
    "layout.app.navigation"
)

for component in "${core_components[@]}"; do
    component_path="resources/views/components/$(echo $component | sed 's|\.|/|g').blade.php"
    
    if [ -f "$component_path" ]; then
        echo "Core component $component after cleanup:"
        head -n 5 "$component_path" | cat -n
        echo "..."
    else
        # Check if it exists as index.blade.php
        index_path="resources/views/components/$(echo $component | sed 's|\.|/|g')/index.blade.php"
        if [ -f "$index_path" ]; then
            echo "Core component $component (index file) after cleanup:"
            head -n 5 "$index_path" | cat -n
            echo "..."
        else
            echo "❌ Core component $component is missing!"
        fi
    fi
    
    echo ""
done

# Step 3: Final verification
echo ""
echo "Step 3: Final verification..."

# Quickly check if there are still duplicate initialization blocks
remaining_duplicates=$(find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | xargs grep -l "@php.*Initialize basic component variables" | xargs grep -c "@php.*Initialize basic component variables" | awk '{sum+=$1} END {print sum}')

if [ "$remaining_duplicates" -gt $(find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | wc -l) ]; then
    echo "⚠️ Found $remaining_duplicates initialization blocks across all components."
    echo "   This indicates some components still have duplicate blocks."
else
    echo "✅ No duplicate initialization blocks remain."
fi

echo ""
echo "========================================================"
echo "COMPONENT CLEANUP COMPLETE"
echo "========================================================" 
#!/bin/bash

# This script finds all component Blade files with @php blocks and processes them
# - Removes basic initialization @php blocks
# - Flags files with complex @php blocks for class migration

# Find all Blade files in components directory
echo "Searching for Blade files with @php blocks..."
blade_files=$(find resources/views/components -type f -name "*.blade.php")

# Counter for summary
count=0

# Process each Blade file
for file in $blade_files; do
    if grep -q "@php" "$file"; then
        echo "Refactoring $file..."
        
        # Check if file still has complex @php blocks (more than just variable initialization)
        if grep -q "@php[^@]*@endphp" "$file" | grep -qv "@php[[:space:]]*\$[a-zA-Z_][a-zA-Z0-9_]*[[:space:]]*=[[:space:]]*[^;]*;[[:space:]]*@endphp"; then
            echo "Complex @php blocks found in $file - flagging for class migration"
            # Add comment at the top of the file if not already present
            if ! grep -q "{{-- Needs PHP class migration for complex logic --}}" "$file"; then
                sed -i '1i{{-- Needs PHP class migration for complex logic --}}' "$file"
            fi
        fi

        # Remove basic initialization @php blocks and add comment if not already present
        if grep -q "@php[[:space:]]*\$[a-zA-Z_][a-zA-Z0-9_]*[[:space:]]*=[[:space:]]*[^;]*;[[:space:]]*@endphp" "$file"; then
            if ! grep -q "" "$file"; then
                sed -i '1i' "$file"
            fi
            sed -i 's/@php[[:space:]]*\$[a-zA-Z_][a-zA-Z0-9_]*[[:space:]]*=[[:space:]]*[^;]*;[[:space:]]*@endphp//g' "$file"
        fi
        echo "Completed refactoring $file"
        ((count++))
    fi
done

echo "Refactoring completed!"
echo "Total files processed: $count" 
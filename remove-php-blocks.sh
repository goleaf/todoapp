#!/bin/bash

# This script removes all basic initialization @php blocks from blade files

echo "Removing basic initialization @php blocks from blade files..."

# Function to remove basic initialization @php blocks from a blade file
remove_basic_php_blocks() {
    local file="$1"
    
    # Check if the file exists and is a blade file
    if [[ ! -f "$file" || ! "$file" =~ \.blade\.php$ ]]; then
        return
    fi
    
    echo "Processing: $file"
    
    # Make a backup
    cp "$file" "${file}.bak"
    
    # Remove all @php blocks that initialize basic component variables
    sed -i '/@php.*Initialize basic component variables/,/@endphp/d' "$file"
}

# Find all blade component files
find resources/views/components -type f -name "*.blade.php" | while read file; do
    remove_basic_php_blocks "$file"
done

echo "Basic @php blocks removal completed!" 
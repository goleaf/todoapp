#!/bin/bash

# This script removes index.blade.php files where an equivalent component file already exists in the parent directory

echo "Removing redundant index.blade.php files..."

# Counter for processed files
removed=0

# Find all index.blade.php files
find resources/views/components -type f -name "index.blade.php" | while read file; do
    dir=$(dirname "$file")
    base_dir=$(dirname "$dir")
    base_name=$(basename "$dir")
    target_file="$base_dir/$base_name.blade.php"
    
    # Check if the equivalent file exists in the parent directory
    if [ -f "$target_file" ]; then
        echo "Removing: $file (equivalent file exists: $target_file)"
        rm -f "$file"
        removed=$((removed+1))
    fi
done

echo "Removed $removed redundant index.blade.php files." 
#!/bin/bash

# This script removes remaining single-file folders (containing only index.blade.php)
# It will move the index.blade.php file to the parent directory with appropriate naming

echo "Cleaning up remaining single-file folders..."

# Counter for processed folders
processed=0

# Find all folders with a single index.blade.php file
find resources/views/components -type d -mindepth 1 | while read dir; do
    # Check if folder only contains an index.blade.php file
    if [ $(find "$dir" -maxdepth 1 -type f -name "*.blade.php" | wc -l) -eq 1 ] && [ -f "$dir/index.blade.php" ]; then
        base_dir=$(dirname "$dir")
        base_name=$(basename "$dir")
        target_file="$base_dir/$base_name.blade.php"
        
        # Check for conflicts
        if [ -f "$target_file" ]; then
            echo "Conflict found: $dir/index.blade.php and $target_file both exist"
            
            # Simple merge strategy - keep the file with more content
            index_size=$(wc -l < "$dir/index.blade.php")
            target_size=$(wc -l < "$target_file")
            
            if [ $index_size -gt $target_size ]; then
                echo "  Using index.blade.php content (more lines)"
                # Backup the original file
                cp "$target_file" "$target_file.bak"
                # Replace with index.blade.php content
                cp "$dir/index.blade.php" "$target_file"
                rm -f "$dir/index.blade.php"
                processed=$((processed+1))
            else
                echo "  Keeping existing $target_file (more or equal lines)"
                rm -f "$dir/index.blade.php"
                processed=$((processed+1))
            fi
        else
            echo "Moving $dir/index.blade.php to $target_file"
            # Just move the file if no conflict exists
            cp "$dir/index.blade.php" "$target_file"
            rm -f "$dir/index.blade.php"
            processed=$((processed+1))
        fi
    fi
done

echo "Cleaned up $processed single-file folders." 
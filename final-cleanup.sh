#!/bin/bash

# This script performs final cleanup by:
# 1. Removing remaining index.blade.php files where an equivalent file exists in the parent directory
# 2. Removing empty directories

echo "Performing final cleanup..."

# Remove redundant index.blade.php files
echo "Step 1: Removing redundant index.blade.php files..."
find resources/views/components -type f -name "index.blade.php" | while read file; do
    dir=$(dirname "$file")
    base_dir=$(dirname "$dir")
    base_name=$(basename "$dir")
    target_file="$base_dir/$base_name.blade.php"
    
    # Check if the equivalent file exists in the parent directory
    if [ -f "$target_file" ]; then
        echo "Removing: $file (equivalent file exists: $target_file)"
        rm -f "$file"
    fi
done

# Remove empty directories
echo "Step 2: Removing empty directories..."
find resources/views/components -type d -empty -delete 2>/dev/null
echo "Empty directories removed."

# Check if there are still folders with a single index.blade.php file
echo "Step 3: Checking for remaining single-file folders..."
remaining=$(find resources/views/components -type d -mindepth 1 | while read dir; do
    if [ $(find "$dir" -maxdepth 1 -type f -name "*.blade.php" | wc -l) -eq 1 ] && [ -f "$dir/index.blade.php" ]; then
        echo "$dir"
    fi
done | wc -l)

echo "There are $remaining directories with only index.blade.php remaining."

echo "Final cleanup completed!" 
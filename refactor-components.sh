#!/bin/bash

# This script refactors blade components by:
# 1. Removing basic @php blocks and using @props instead
# 2. Moving single index.blade.php files to parent directory with appropriate naming
# 3. Resolving conflicts when both folder/index.blade.php and folder.blade.php exist

echo "Starting blade component refactoring..."

# Function to refactor a blade file by removing basic @php blocks
refactor_blade_file() {
    local file="$1"
    
    # Check if the file exists and is a blade file
    if [[ ! -f "$file" || ! "$file" =~ \.blade\.php$ ]]; then
        return
    fi
    
    echo "Refactoring: $file"
    
    # Replace basic initialization @php blocks with appropriate @props
    # This is a simplified replacement, more complex PHP code blocks would need manual refactoring
    sed -i 's/@php\s*\/\/\s*Initialize basic component variables\s*$attributes = $attributes ?? collect\(\);\s*$slot = $slot ?? .*@endphp//g' "$file"
    
    # Check if the file has a proper @props definition at the top
    if ! grep -q "@props" "$file"; then
        # Add a basic @props definition if none exists
        sed -i '1s/^/@props([])\n\n/' "$file"
    fi
}

# Process single-file components (folders with only index.blade.php)
process_single_file_components() {
    echo "Processing single-file components..."
    
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
                
                # Merge the conflicting files
                # This is a simple strategy - check both files to see which is more complete
                index_size=$(wc -l < "$dir/index.blade.php")
                target_size=$(wc -l < "$target_file")
                
                if [ $index_size -gt $target_size ]; then
                    echo "  Using index.blade.php content (more lines)"
                    # Backup the original file
                    cp "$target_file" "$target_file.bak"
                    # Replace with index.blade.php content
                    cp "$dir/index.blade.php" "$target_file"
                else
                    echo "  Keeping existing $target_file (more or equal lines)"
                fi
            else
                echo "Moving $dir/index.blade.php to $target_file"
                # Just move the file if no conflict exists
                cp "$dir/index.blade.php" "$target_file"
            fi
            
            # Refactor the file
            refactor_blade_file "$target_file"
        fi
    done
}

# First refactor all blade files to remove @php blocks
echo "Refactoring blade files to remove @php blocks..."
find resources/views/components -type f -name "*.blade.php" | while read file; do
    refactor_blade_file "$file"
done

# Then process single-file components
process_single_file_components

echo "Component refactoring completed!" 
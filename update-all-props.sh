#!/bin/bash

# This script adds @props blocks to all component files that don't have them
# and removes PHP class comments.

echo "Adding @props blocks to component files..."

# Function to update a blade file with proper @props
update_props() {
    local file="$1"
    
    # Check if the file exists and is a blade file
    if [[ ! -f "$file" || ! "$file" =~ \.blade\.php$ ]]; then
        return
    fi
    
    echo "Processing: $file"
    
    # Make a backup
    cp "$file" "${file}.bak"
    
    # Replace "Logic moved to PHP class" comments with proper @props block if needed
    if grep -q "Logic moved to PHP class" "$file" && ! grep -q "@props" "$file"; then
        # Create a temporary file with the @props block
        cat > temp_props.txt << 'EOF'
@props([
    // Define appropriate props for this component
])

EOF
        # Insert @props block at the beginning of the file
        sed -i '1s/^/'"$(cat temp_props.txt)"'/' "$file"
        rm temp_props.txt
    fi
    
    # Remove PHP class comments
    sed -i 's/{{--.*Logic moved to PHP class.*--}}//' "$file"
    sed -i 's/{{--.*Removed @props and @php block.*--}}//' "$file"
    
    # Ensure all files have at least an empty @props block
    if ! grep -q "@props" "$file"; then
        sed -i '1s/^/@props([])\n\n/' "$file"
    fi
    
    # Remove empty lines at the beginning of the file
    sed -i '/./,$!d' "$file"
    # Remove excessive empty lines throughout the file
    sed -i '/^$/N;/^\n$/D' "$file"
}

# Find all blade component files
find resources/views/components -type f -name "*.blade.php" | while read file; do
    update_props "$file"
done

echo "Component props update completed!" 
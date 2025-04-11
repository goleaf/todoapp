#!/bin/bash

echo "Organizing component files into proper subfolder structure..."

# Function to ensure a directory exists
ensure_dir() {
    if [ ! -d "$1" ]; then
        mkdir -p "$1"
        echo "Created directory: $1"
    fi
}

# Main component directories
COMPONENT_DIR="resources/views/components"

# Ensure the main component directories exist
ensure_dir "$COMPONENT_DIR/input"
ensure_dir "$COMPONENT_DIR/ui"
ensure_dir "$COMPONENT_DIR/layout"
ensure_dir "$COMPONENT_DIR/data"
ensure_dir "$COMPONENT_DIR/auth"
ensure_dir "$COMPONENT_DIR/feedback"
ensure_dir "$COMPONENT_DIR/settings"

# Ensure we have a /tmp directory to work with
ensure_dir "/tmp/todoapp-components"

# Function to check for any component files in the root and move them
move_root_components() {
    # Find any components sitting directly in the components root
    ROOT_COMPONENTS=$(find $COMPONENT_DIR -maxdepth 1 -type f -name "*.blade.php")
    
    if [ -n "$ROOT_COMPONENTS" ]; then
        echo "Found the following components in the root directory:"
        echo "$ROOT_COMPONENTS"
        
        for component in $ROOT_COMPONENTS; do
            filename=$(basename "$component")
            component_name=${filename%.*}
            
            # Determine where the component should go based on its name/content
            component_content=$(cat "$component")
            
            if [[ "$component_name" == *"input"* || "$component_name" == *"form"* || "$component_name" == *"label"* || "$component_name" == *"checkbox"* || "$component_name" == *"radio"* || "$component_name" == *"select"* || "$component_name" == *"textarea"* ]]; then
                target_dir="$COMPONENT_DIR/input"
            elif [[ "$component_name" == *"button"* || "$component_name" == *"card"* || "$component_name" == *"avatar"* || "$component_name" == *"badge"* || "$component_name" == *"dropdown"* || "$component_name" == *"modal"* || "$component_name" == *"container"* || "$component_name" == *"link"* || "$component_name" == *"status"* ]]; then
                target_dir="$COMPONENT_DIR/ui"
            elif [[ "$component_name" == *"layout"* || "$component_name" == *"app"* || "$component_name" == *"heading"* || "$component_name" == *"subheading"* || "$component_name" == *"text"* || "$component_name" == *"separator"* || "$component_name" == *"spacer"* || "$component_name" == *"header"* || "$component_name" == *"logo"* ]]; then
                target_dir="$COMPONENT_DIR/layout"
            elif [[ "$component_name" == *"table"* || "$component_name" == *"pagination"* ]]; then
                target_dir="$COMPONENT_DIR/data"
            elif [[ "$component_name" == *"auth"* ]]; then
                target_dir="$COMPONENT_DIR/auth"
            elif [[ "$component_name" == *"error"* || "$component_name" == *"action-message"* || "$component_name" == *"alert"* ]]; then
                target_dir="$COMPONENT_DIR/feedback"
            elif [[ "$component_name" == *"settings"* ]]; then
                target_dir="$COMPONENT_DIR/settings"
            else
                # Default to UI if we can't determine
                target_dir="$COMPONENT_DIR/ui"
            fi
            
            # Create the component's subdirectory if needed
            ensure_dir "$target_dir/$component_name"
            
            # Move the component
            cp "$component" "$target_dir/$component_name/index.blade.php"
            rm "$component"
            
            echo "Moved $component to $target_dir/$component_name/index.blade.php"
        done
    else
        echo "No component files found in the root directory."
    fi
}

# Check for duplicate components (same name but in different folders)
find_duplicate_components() {
    echo "Checking for duplicate components..."
    
    # Get a list of all component base names
    component_files=$(find $COMPONENT_DIR -type f -name "*.blade.php")
    declare -A component_map
    
    for file in $component_files; do
        basename=$(basename "$file")
        if [[ -v component_map["$basename"] ]]; then
            echo "Potential duplicate found: $basename"
            echo " - Original: ${component_map["$basename"]}"
            echo " - Duplicate: $file"
            
            # Compare the files
            if cmp -s "${component_map["$basename"]}" "$file"; then
                echo "   Files are identical. Will remove the duplicate."
                rm "$file"
            else
                echo "   Files have different content. Keeping both but marking for review."
                # You could move duplicates to a special folder for review
                ensure_dir "/tmp/todoapp-components/duplicates/$(dirname "$basename")"
                cp "$file" "/tmp/todoapp-components/duplicates/$basename"
            fi
        else
            component_map["$basename"]=$file
        fi
    done
}

# Function to normalize component names for consistent naming
normalize_component_names() {
    echo "Normalizing component names..."
    
    # Find all component directories
    component_dirs=$(find $COMPONENT_DIR -type d -not -path "$COMPONENT_DIR")
    
    for dir in $component_dirs; do
        dir_name=$(basename "$dir")
        parent_dir=$(dirname "$dir")
        parent_basename=$(basename "$parent_dir")
        
        # Skip directories that are already in the correct format
        if [[ "$parent_basename" == "components" ]]; then
            # This is a top-level category folder, skip
            continue
        fi
        
        # If it's an index.blade.php, leave it alone
        if [ -f "$dir/index.blade.php" ]; then
            continue
        fi
        
        # Look for any blade files in this directory
        blade_files=$(find "$dir" -maxdepth 1 -type f -name "*.blade.php")
        
        for file in $blade_files; do
            filename=$(basename "$file")
            if [ "$filename" != "index.blade.php" ]; then
                # Create component subdirectory if needed
                component_name="${filename%.blade.php}"
                ensure_dir "$dir/$component_name"
                
                # Move the file to index.blade.php in its subdirectory
                mv "$file" "$dir/$component_name/index.blade.php"
                echo "Normalized: $file -> $dir/$component_name/index.blade.php"
            fi
        done
    done
}

# Main execution
move_root_components
find_duplicate_components
normalize_component_names

echo "Component organization complete!" 
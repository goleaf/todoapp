#!/bin/bash

# This script identifies complex @php blocks in blade components and flags them for refactoring
# to component classes following the Laravel View Component pattern

echo "Identifying complex @php blocks in blade components..."

# Directory where components are located
COMPONENTS_DIR="resources/views/components"

# Output file for listing components that need complex refactoring
COMPLEX_COMPONENTS_LIST="complex-components-to-refactor.txt"

# Clear the output file
> "$COMPLEX_COMPONENTS_LIST"

# Function to check if a blade file has complex PHP logic
has_complex_php() {
    local file="$1"
    
    # Check if the file has @php blocks with more than basic variable initialization
    # This pattern tries to detect PHP blocks with calculations, conditionals, etc.
    grep -q "@php[^@]*\(if\|function\|foreach\|for\|while\|switch\|class\|array\|return\)[^@]*@endphp" "$file"
    return $?
}

# Find all blade component files
find "$COMPONENTS_DIR" -type f -name "*.blade.php" | while read file; do
    if has_complex_php "$file"; then
        echo "Complex PHP found in: $file"
        echo "$file" >> "$COMPLEX_COMPONENTS_LIST"
        
        # Extract the component name for creating class files
        rel_path=${file#$COMPONENTS_DIR/}
        component_name=${rel_path%.blade.php}
        
        # Replace slashes with dots for namespace
        namespace_path=${component_name//\//.}
        
        # Convert to PascalCase for class name
        class_name=""
        IFS='.' read -ra PARTS <<< "$namespace_path"
        for part in "${PARTS[@]}"; do
            class_name+=$(echo "$part" | sed -r 's/(^|-)([a-z])/\U\2/g')
        done
        
        echo "  Suggested class name: $class_name"
        echo "  Create: App\\View\\Components\\$class_name"
        echo "" 
    fi
done

echo "Finished identifying components with complex PHP logic."
echo "See $COMPLEX_COMPONENTS_LIST for the list of components to refactor."
echo ""
echo "For each complex component:"
echo "1. Create a new PHP class in App\\View\\Components\\"
echo "2. Move the PHP logic from the blade template to the class"
echo "3. Update the blade template to use the component attributes" 
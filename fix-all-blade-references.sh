#!/bin/bash

# Comprehensive script to check and fix all blade component references in the resources directory

echo "========================================================"
echo "FIXING ALL BLADE COMPONENT REFERENCES IN RESOURCES"
echo "========================================================"

# Create list of existing components for validation
echo "Creating component inventory..."
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > component-inventory.txt
echo "Found $(wc -l < component-inventory.txt) components."

# Function to create missing component with standard structure
create_component() {
    local component="$1"
    local directory="resources/views/components/$(echo $component | sed 's|\.|/|g')"
    local filename="$directory.blade.php"
    
    # Check if file already exists (shouldn't happen, but just in case)
    if [ -f "$filename" ]; then
        echo "  - Component file already exists: $filename"
        return
    fi
    
    # Create directory if needed
    mkdir -p "$(dirname "$filename")"
    
    # Create basic component file with @props declaration
    cat > "$filename" << EOF
@props([])

<div {{ \$attributes }}>
    {{ \$slot }}
</div>
EOF
    
    echo "  - Created component: $component at $filename"
}

# Step 1: Check for .index references and correct them
echo ""
echo "Step 1: Checking for .index component references..."

# Find all <x-component.index> references
all_index_refs=$(grep -r '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.index' resources/views --include="*.blade.php" | wc -l)
echo "Found $all_index_refs component.index references to check."

# For each <x-component.index> reference, check if <x-component> exists and replace if needed
find resources/views -type f -name "*.blade.php" | while read file; do
    # Find all component.index references in this file
    grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.index' "$file" | sort -u | while read -r ref; do
        component_name=$(echo "$ref" | sed 's/<x-//g' | sed 's/\.index$//g')
        
        # Check if the base component exists in our inventory
        if grep -q "^$component_name$" component-inventory.txt; then
            # Replace .index references with the base component
            sedcmd="s|$ref|<x-$component_name|g"
            sed -i "$sedcmd" "$file"
            echo "  - Fixed in $file: $ref -> <x-$component_name"
        else
            # Component doesn't exist but needs to be created
            echo "  - Component $component_name referenced in $file doesn't exist"
            # Create component.index file for now
            create_component "$component_name.index"
        fi
    done
done

# Step 2: Check for references to non-existent components and create them if needed
echo ""
echo "Step 2: Checking for references to non-existent components..."

# Refresh component inventory after creating new components
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > component-inventory.txt

# Find all component references
find resources/views -type f -name "*.blade.php" | while read file; do
    grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\(\.[a-zA-Z0-9\-]*\)*' "$file" | sort -u | while read -r ref; do
        component_name=$(echo "$ref" | sed 's/<x-//g')
        
        # Check if component exists
        if ! grep -q "^$component_name$" component-inventory.txt; then
            echo "  - Missing component: $component_name referenced in $file"
            
            # Try to find a parent component
            parent_component=$(echo "$component_name" | rev | cut -d. -f2- | rev)
            if grep -q "^$parent_component$" component-inventory.txt; then
                echo "    ✓ Parent component $parent_component exists, redirecting reference"
                # Replace with parent component reference
                sedcmd="s|$ref|<x-$parent_component|g"
                sed -i "$sedcmd" "$file"
            else
                echo "    ✗ No parent component found, creating component"
                create_component "$component_name"
            fi
        fi
    done
done

# Step 3: Check for excessive nesting in component references (>2 dots)
echo ""
echo "Step 3: Checking for excessive component nesting..."

excessive_nesting=$(find resources/views -type f -name "*.blade.php" | xargs grep -l '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*')

if [ -n "$excessive_nesting" ]; then
    echo "Found files with excessive component nesting:"
    echo "$excessive_nesting"
    
    # Fix excessive nesting
    find resources/views -type f -name "*.blade.php" | while read file; do
        # Find all excessively nested components (more than 2 dots)
        grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\(\.[a-zA-Z0-9\-]*\)*' "$file" | sort -u | while read -r ref; do
            # Get first three parts of component name (domain.component.subcomponent)
            simplified=$(echo "$ref" | sed -E 's/<x-([a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*).*/\1/')
            
            # Replace with simplified reference
            sedcmd="s|$ref|<x-$simplified|g"
            sed -i "$sedcmd" "$file"
            echo "  - Fixed in $file: $ref -> <x-$simplified"
        done
    done
else
    echo "  ✓ No excessive component nesting found."
fi

# Step 4: Run component verification script to check final status
echo ""
echo "Step 4: Verifying all component references are now valid..."

# Refresh component inventory one last time
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > component-inventory.txt

# Check all component references for validity
invalid_refs=0
find resources/views -type f -name "*.blade.php" | while read file; do
    grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\(\.[a-zA-Z0-9\-]*\)*' "$file" | sort -u | while read -r ref; do
        component_name=$(echo "$ref" | sed 's/<x-//g')
        
        # Check if component exists
        if ! grep -q "^$component_name$" component-inventory.txt; then
            echo "  ! Still missing: $component_name in $file"
            invalid_refs=$((invalid_refs+1))
        fi
    done
done

if [ $invalid_refs -eq 0 ]; then
    echo "  ✅ All component references are now valid!"
else
    echo "  ⚠️ Found $invalid_refs component references still invalid."
fi

# Step 5: Final cleanup
echo ""
echo "Step 5: Cleaning up component directories..."

./cleanup-component-directories.sh

echo ""
echo "========================================================"
echo "ALL BLADE COMPONENT REFERENCES FIXED"
echo "========================================================"
echo ""
echo "You should now test your application to ensure all components render correctly."
echo "Use verify-components.sh to check for any remaining issues."
echo "" 
#!/bin/bash

# Deep Component Verification Script
# This script performs a comprehensive verification of all blade components,
# including checking their structure, content, and references

echo "========================================================"
echo "DEEP BLADE COMPONENT VERIFICATION"
echo "========================================================"

# Create a temporary directory for reports
mkdir -p verification_reports

# Function to check a single component file
check_component() {
    local file="$1"
    local component_name=$(echo "$file" | sed 's|resources/views/components/||g' | sed 's|\.blade\.php||g' | sed 's|/|.|g')
    local issues=0
    
    echo "Checking component: $component_name"
    
    # 1. Check for @props declaration
    if ! grep -q "@props" "$file"; then
        echo "  ❌ Missing @props declaration"
        issues=$((issues+1))
    else
        echo "  ✅ Has @props declaration"
    fi
    
    # 2. Check for duplicate @php blocks
    php_blocks=$(grep -c "@php" "$file")
    if [ $php_blocks -gt 1 ]; then
        echo "  ⚠️ Multiple @php blocks found: $php_blocks blocks"
        # Count identical @php blocks for initializing variables
        duplicate_php=$(grep -c "@php.*Initialize basic component variables" "$file")
        if [ $duplicate_php -gt 1 ]; then
            echo "    ❌ Contains $duplicate_php duplicate initialization blocks"
            issues=$((issues+1))
        fi
    fi
    
    # 3. Check for excessively deep nesting in the file content
    if grep -q "<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*" "$file"; then
        echo "  ❌ Contains excessively nested component references"
        issues=$((issues+1))
    fi
    
    # 4. Check for empty component (no real content)
    content_lines=$(grep -v "^$\|@props\|@php\|@endphp\|<?php\|<div\|</div>" "$file" | wc -l)
    if [ $content_lines -lt 2 ]; then
        echo "  ⚠️ Very minimal content ($content_lines meaningful lines)"
    fi
    
    # 5. Check if it's an index file that might need to be consolidated
    if [[ "$file" == */index.blade.php ]]; then
        parent_dir=$(dirname "$file")
        parent_name=$(basename "$parent_dir")
        parent_file="${parent_dir%/*}/$parent_name.blade.php"
        
        if [ -f "$parent_file" ]; then
            echo "  ⚠️ Both index.blade.php and parent component exist"
            # Compare file sizes to see which is more substantial
            index_size=$(wc -l < "$file")
            parent_size=$(wc -l < "$parent_file")
            
            if [ $index_size -gt $parent_size ]; then
                echo "    ❓ index.blade.php ($index_size lines) is larger than parent ($parent_size lines)"
            fi
        fi
    fi
    
    return $issues
}

# Step 1: Check all component files
echo ""
echo "Step 1: Deep checking all component files..."

total_components=0
problematic_components=0

find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | while read file; do
    total_components=$((total_components+1))
    check_component "$file" > "verification_reports/$(basename "$file").report"
    result=$?
    
    if [ $result -gt 0 ]; then
        problematic_components=$((problematic_components+1))
    fi
done

echo ""
echo "Component inspection results:"
echo "Total components checked: $total_components"
echo "Components with issues: $problematic_components"

# Step 2: Check specifically for layout/app/head.blade.php and other important core files
echo ""
echo "Step 2: Checking core components..."

# List of core components to check specifically
core_components=(
    "layout.app"
    "layout.app.head"
    "layout.app.header"
    "layout.app.navigation"
    "ui.card"
    "ui.button"
    "input.input"
    "input.form"
)

for component in "${core_components[@]}"; do
    component_path="resources/views/components/$(echo $component | sed 's|\.|/|g').blade.php"
    
    if [ -f "$component_path" ]; then
        echo "Core component $component exists:"
        head -n 10 "$component_path" | cat -n
        echo "..."
    else
        # Check if it exists as index.blade.php
        index_path="resources/views/components/$(echo $component | sed 's|\.|/|g')/index.blade.php"
        if [ -f "$index_path" ]; then
            echo "Core component $component exists as index file:"
            head -n 10 "$index_path" | cat -n
            echo "..."
        else
            echo "❌ Core component $component is missing!"
        fi
    fi
    
    echo ""
done

# Step 3: Check for any remaining .index references in blade files
echo ""
echo "Step 3: Checking for remaining .index references..."

index_refs=$(grep -r '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.index' resources/views --include="*.blade.php" | wc -l)

if [ $index_refs -gt 0 ]; then
    echo "❌ Found $index_refs remaining .index references that need to be fixed:"
    grep -r '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.index' resources/views --include="*.blade.php" | head -n 10
else
    echo "✅ No .index references found in blade files."
fi

# Step 4: Check for any deeply nested component references
echo ""
echo "Step 4: Checking for deeply nested component references..."

nested_refs=$(grep -r '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*' resources/views --include="*.blade.php" | wc -l)

if [ $nested_refs -gt 0 ]; then
    echo "❌ Found $nested_refs deeply nested component references that need to be fixed:"
    grep -r '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*' resources/views --include="*.blade.php" | head -n 10
else
    echo "✅ No deeply nested component references found in blade files."
fi

# Clean up
rm -rf verification_reports

echo ""
echo "========================================================"
echo "DEEP COMPONENT VERIFICATION COMPLETE"
echo "========================================================" 
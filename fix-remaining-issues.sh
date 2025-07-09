#!/bin/bash

# This script fixes the remaining component reference issues

echo "Fixing remaining component reference issues..."

# Fix specified component references
find resources/views -type f -name "*.blade.php" | grep -v ".bak" | while read file; do
    # Fix data.table.index references
    sed -i 's/<x-data\.table\.index/<x-data.table/g' "$file"
    
    # Fix input.input.* references (reduce nesting level)
    sed -i 's/<x-input\.input\.checkbox/<x-input.checkbox/g' "$file"
    sed -i 's/<x-input\.input\.form/<x-input.form/g' "$file"
    sed -i 's/<x-input\.input\.label/<x-input.label/g' "$file"
    sed -i 's/<x-input\.input\.radio/<x-input.radio/g' "$file"
    sed -i 's/<x-input\.input\.select/<x-input.select/g' "$file"
    sed -i 's/<x-input\.input\.textarea/<x-input.textarea/g' "$file"
    
    # Fix ui.popover.divider references
    sed -i 's/<x-ui\.popover\.divider/<x-ui.dropdown.divider/g' "$file"
done

echo "Fixed remaining component reference issues." 
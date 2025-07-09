#!/bin/bash

# This script does a more thorough check for problematic component references

echo "Doing final fix of component references..."

# Fix all references to deeper nesting
find resources/views -type f -name "*.blade.php" | grep -v ".bak" | while read file; do
    # Replace any instance of input.input.input-error with input.input-error 
    sed -i 's/<x-input\.input\.input-error/<x-input.input-error/g' "$file"
    
    # Replace any instance of input.input.input with input.input
    sed -i 's/<x-input\.input\.input/<x-input.input/g' "$file"
done

echo "Final fixes applied." 
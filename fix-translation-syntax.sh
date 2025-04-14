#!/bin/bash

# Script to fix syntax errors in translation files
# Replaces closing parentheses with brackets at the end of PHP arrays

# Find all PHP files in the lang/fr directory
find lang/fr -name "*.php" -type f | while read -r file; do
  # Replace closing parenthesis with bracket at the end of the array
  sed -i 's/);$/];/g' "$file"
  echo "Fixed $file"
done

echo "All files fixed" 
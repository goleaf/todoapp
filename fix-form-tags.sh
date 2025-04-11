#!/bin/bash

echo "Fixing form group closing tags..."

# Fix closing tags
find resources/views -type f -name "*.blade.php" -not -path "*/components/*" -exec sed -i 's/<\/x-form\.group>/<\/x-input\.form\.group>/g' {} \;

echo "Form group closing tags fixed!" 
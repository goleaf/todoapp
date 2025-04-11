#!/bin/bash

echo "Fixing remaining component reference issues..."

# Fix input.input.form references (should be input.form)
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input\.input\.form/<x-input\.form/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input\.input\.form>/<\/x-input\.form>/g' {} \;

# Fix input.input.form.group references (should be input.form.group) 
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input\.input\.form\.group/<x-input\.form\.group/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input\.input\.form\.group>/<\/x-input\.form\.group>/g' {} \;

# Fix any remaining layouts.app references (should be layout.app)
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-layouts\.app/<x-layout\.app/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-layouts\.app>/<\/x-layout\.app>/g' {} \;

echo "All remaining component reference issues have been fixed!" 
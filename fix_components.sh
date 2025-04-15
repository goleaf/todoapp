#!/bin/bash

# Fix over-replaced component tags
echo "Fixing over-replaced component tags..."

# Fix Input Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.form/<x-input.form/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.textarea/<x-input.textarea/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.select/<x-input.select/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.checkbox/<x-input.checkbox/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.radio/<x-input.radio/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.input-error/<x-input.input-error/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.label/<x-input.label/g' {} \;

# Fix closure tags too
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.form/<\/x-input.form/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.textarea/<\/x-input.textarea/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.select/<\/x-input.select/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.checkbox/<\/x-input.checkbox/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.radio/<\/x-input.radio/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.input-error/<\/x-input.input-error/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.label/<\/x-input.label/g' {} \;

# Final check for any remaining doubled components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.input/<x-input.input/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<\/x-input.input.input/<\/x-input.input/g' {} \;

echo "Fixed component tags!" 
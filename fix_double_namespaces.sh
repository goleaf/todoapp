#!/bin/bash
echo "Fixing double namespaces in components..."

# Fix double input namespaces
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.input/<x-input.input/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.form/<x-input.form/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.textarea/<x-input.textarea/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.select/<x-input.select/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.checkbox/<x-input.checkbox/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.radio/<x-input.radio/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.input-error/<x-input.input-error/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input.input.label/<x-input.label/g" {} \;

# Fix double input namespaces in closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.input|</x-input.input|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.form|</x-input.form|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.textarea|</x-input.textarea|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.select|</x-input.select|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.checkbox|</x-input.checkbox|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.radio|</x-input.radio|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.input-error|</x-input.input-error|g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s|</x-input.input.label|</x-input.label|g" {} \;

echo "Fixed double namespaces" 
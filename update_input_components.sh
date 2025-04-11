#!/bin/bash
echo "Updating input components..."
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-input/<x-input.input/g" {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i "s/<x-form/<x-input.form/g" {} \;

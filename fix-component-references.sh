#!/bin/bash

# This script fixes incorrectly nested component references

echo "Fixing component references..."

# Fix input component references
find resources/views -type f -name "*.blade.php" | xargs sed -i 's/<x-input\.input\.input\./<x-input.input-/g'
find resources/views -type f -name "*.blade.php" | xargs sed -i 's/<x-input\.input\.input/<x-input.input/g'

# Fix edit_file.blade.php
find resources/views/components/input -type f -name "input.blade.php" | xargs sed -i 's/<x-input\.input\.input\.index/<x-input.field/g'

echo "Component references fixed." 
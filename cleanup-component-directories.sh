#!/bin/bash

# This script removes unnecessary index.blade.php files and empty directories

echo "Cleaning up component directories..."

# Find and remove index.blade.php.bak files
find resources/views/components -type f -name "index.blade.php.bak" -delete

# Find and remove empty directories
find resources/views/components -type d -empty -delete

echo "Component directory cleanup completed."

# Create a final report on component structure
echo ""
echo "Component Structure Report:"
echo "---------------------------"
echo "Total components: $(find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | wc -l)"
echo "Total directories: $(find resources/views/components -type d | wc -l)"
echo "---------------------------" 
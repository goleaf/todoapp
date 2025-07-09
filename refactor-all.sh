#!/bin/bash

# Main script to refactor all blade components

# Make all scripts executable
chmod +x refactor-components.sh
chmod +x refactor-complex-php-blocks.sh
chmod +x update-component-tags.sh

echo "=========================================="
echo "BLADE COMPONENT REFACTORING PROCESS"
echo "=========================================="

# 1. First identify components with complex PHP blocks
echo ""
echo "STEP 1: Identifying components with complex PHP blocks"
echo "----------------------------------------------"
./refactor-complex-php-blocks.sh

# 2. Refactor all components to remove @php blocks and handle single-file components
echo ""
echo "STEP 2: Refactoring components and handling single-file folders"
echo "----------------------------------------------"
./refactor-components.sh

# 3. Update component tags in all blade files
echo ""
echo "STEP 3: Updating component tags in all blade files"
echo "----------------------------------------------"
./update-component-tags.sh

echo ""
echo "=========================================="
echo "REFACTORING PROCESS COMPLETED"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Review components listed in complex-components-to-refactor.txt"
echo "2. For each complex component, create a corresponding PHP class"
echo "3. Manually test the application to ensure all components work correctly" 
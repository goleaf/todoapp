#!/bin/bash

# Component Structure Verification Script
# This script verifies the blade component structure and reports any issues

echo "===== Blade Component Structure Verification ====="

# 1. Check for missing components
echo ""
echo "Checking for missing component references..."

# Create a list of available component files
find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | sed 's|resources/views/components/||g' | sed 's|/|.|g' | sed 's|\.blade\.php||g' > available-components.txt

# Check all blade templates for component references
missing_count=0
missing_files=""

for component in $(grep -r '<x-' resources/views --include="*.blade.php" | grep -v ".bak" | grep -o '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\(\.[a-zA-Z0-9\-]*\)*' | sort -u | sed 's/<x-//g'); do
    if ! grep -q "^$component$" available-components.txt; then
        echo "  - Missing component: $component"
        missing_count=$((missing_count+1))
        missing_files="$missing_files $component"
    fi
done

if [ $missing_count -eq 0 ]; then
    echo "  ✓ No missing component references found"
fi

# 2. Check for excessive nesting (more than 2 dots in component reference)
echo ""
echo "Checking for excessive component nesting..."
excessive_count=0

excessive_files=$(find resources/views -type f -name "*.blade.php" | grep -v ".bak" | xargs grep -l '<x-[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*\.[a-zA-Z0-9\-]*')

if [ -n "$excessive_files" ]; then
    echo "  - Excessive nesting found in: $excessive_files"
    excessive_count=1
else
    echo "  ✓ No excessive component nesting found"
fi

# 3. Check for PHP blocks in blade files
echo ""
echo "Checking for @php blocks in components..."
php_blocks_count=$(find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | xargs grep -l "@php" | wc -l)

if [ $php_blocks_count -gt 0 ]; then
    echo "  - Warning: $php_blocks_count components still have @php blocks"
    echo "  - Files with @php blocks:"
    find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | xargs grep -l "@php" | sed 's/^/    /'
else
    echo "  ✓ No @php blocks found in components"
fi

# 4. Check for empty component directories
echo ""
echo "Checking for empty component directories..."
empty_dirs=$(find resources/views/components -type d -empty | wc -l)

if [ $empty_dirs -gt 0 ]; then
    echo "  - Warning: $empty_dirs empty directories found"
    echo "  - Empty directories:"
    find resources/views/components -type d -empty | sed 's/^/    /'
else
    echo "  ✓ No empty component directories found"
fi

# 5. Generate structure report
echo ""
echo "Component Structure Report:"
echo "---------------------------"
echo "Total components: $(find resources/views/components -type f -name "*.blade.php" | grep -v ".bak" | wc -l)"
echo "Total directories: $(find resources/views/components -type d | wc -l)"
echo "---------------------------"

# 6. Summary
echo ""
echo "Verification Summary:"
if [ $missing_count -eq 0 ] && [ $excessive_count -eq 0 ] && [ $php_blocks_count -eq 0 ] && [ $empty_dirs -eq 0 ]; then
    echo "✅ All component structure checks passed"
else
    echo "⚠️ Some component structure issues detected:"
    [ $missing_count -gt 0 ] && echo "   - $missing_count missing component references"
    [ $excessive_count -gt 0 ] && echo "   - Excessive component nesting found"
    [ $php_blocks_count -gt 0 ] && echo "   - $php_blocks_count components with @php blocks"
    [ $empty_dirs -gt 0 ] && echo "   - $empty_dirs empty directories"
fi

echo ""
echo "===== Verification completed =====" 
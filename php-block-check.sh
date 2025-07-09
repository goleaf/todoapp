#!/bin/bash

echo "Checking for remaining @php blocks in component files..."
COMPONENTS_DIR="resources/views/components"

echo "=== Files with @php blocks ==="
find $COMPONENTS_DIR -type f -name "*.blade.php" -exec grep -l "@php" {} \; | wc -l

echo "=== Files with PHP open tags ==="
find $COMPONENTS_DIR -type f -name "*.blade.php" -exec grep -l "<?php" {} \; | wc -l

echo "=== List of files still containing @php blocks ==="
find $COMPONENTS_DIR -type f -name "*.blade.php" -exec grep -l "@php" {} \;

echo "=== List of files still containing PHP open tags ==="
find $COMPONENTS_DIR -type f -name "*.blade.php" -exec grep -l "<?php" {} \;

echo "Check completed." 
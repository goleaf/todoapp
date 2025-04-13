#!/bin/bash

echo "Starting component cleanup..."

# Create backup directory
mkdir -p component_backups
timestamp=$(date +%Y%m%d%H%M%S)

# 1. Clean up icon components - standardize on nested folder structure
echo "Cleaning up icon components..."

# Move existing icons from ui/icons to ui/icon
if [ -d "resources/views/components/ui/icons" ]; then
    # Move heroicon outline icons
    if [ -d "resources/views/components/ui/icons/heroicon/outline" ]; then
        mkdir -p resources/views/components/ui/icon/heroicon-o
        
        for file in resources/views/components/ui/icons/heroicon/outline/*.blade.php; do
            filename=$(basename "$file" .blade.php)
            # Check if file already exists in target
            if [ -f "resources/views/components/ui/icon/heroicon-o/$filename.blade.php" ]; then
                # Backup the file we're replacing
                cp "resources/views/components/ui/icon/heroicon-o/$filename.blade.php" "component_backups/heroicon-o-$filename-$timestamp.blade.php"
            fi
            cp "$file" "resources/views/components/ui/icon/heroicon-o/$filename.blade.php"
        done
    fi
    
    # Move heroicon solid icons
    if [ -d "resources/views/components/ui/icons/heroicon/solid" ]; then
        mkdir -p resources/views/components/ui/icon/heroicon-s
        
        for file in resources/views/components/ui/icons/heroicon/solid/*.blade.php; do
            filename=$(basename "$file" .blade.php)
            # Check if file already exists in target
            if [ -f "resources/views/components/ui/icon/heroicon-s/$filename.blade.php" ]; then
                # Backup the file we're replacing
                cp "resources/views/components/ui/icon/heroicon-s/$filename.blade.php" "component_backups/heroicon-s-$filename-$timestamp.blade.php"
            fi
            cp "$file" "resources/views/components/ui/icon/heroicon-s/$filename.blade.php"
        done
    fi
    
    # Move phosphor icons
    if [ -d "resources/views/components/ui/icons/phosphor" ]; then
        mkdir -p resources/views/components/ui/icon/phosphor
        
        for file in resources/views/components/ui/icons/phosphor/*.blade.php; do
            filename=$(basename "$file" .blade.php)
            # Check if file already exists in target
            if [ -f "resources/views/components/ui/icon/phosphor/$filename.blade.php" ]; then
                # Backup the file we're replacing
                cp "resources/views/components/ui/icon/phosphor/$filename.blade.php" "component_backups/phosphor-$filename-$timestamp.blade.php"
            fi
            cp "$file" "resources/views/components/ui/icon/phosphor/$filename.blade.php"
        done
    fi
    
    # Backup and remove the old icons directory
    cp -r resources/views/components/ui/icons component_backups/icons-$timestamp
    rm -rf resources/views/components/ui/icons
fi

# 2. Clean up flat icon files (e.g., heroicon-o-check-circle.blade.php)
echo "Cleaning up flat icon files..."

# Find all flat heroicon-o files
for file in resources/views/components/ui/icon/heroicon-o-*.blade.php; do
    if [ -f "$file" ]; then
        filename=$(basename "$file" .blade.php)
        iconname=${filename#heroicon-o-}
        
        # Create target directory if it doesn't exist
        mkdir -p resources/views/components/ui/icon/heroicon-o
        
        # Check if file already exists in target
        if [ -f "resources/views/components/ui/icon/heroicon-o/$iconname.blade.php" ]; then
            # Skip if already moved by previous step
            continue
        fi
        
        # Move file to nested structure
        cp "$file" "resources/views/components/ui/icon/heroicon-o/$iconname.blade.php"
        # Backup file
        cp "$file" "component_backups/$(basename $file)-$timestamp"
        # Remove original file
        rm "$file"
    fi
done

# Find all flat heroicon-s files
for file in resources/views/components/ui/icon/heroicon-s-*.blade.php; do
    if [ -f "$file" ]; then
        filename=$(basename "$file" .blade.php)
        iconname=${filename#heroicon-s-}
        
        # Create target directory if it doesn't exist
        mkdir -p resources/views/components/ui/icon/heroicon-s
        
        # Move file to nested structure
        cp "$file" "resources/views/components/ui/icon/heroicon-s/$iconname.blade.php"
        # Backup file
        cp "$file" "component_backups/$(basename $file)-$timestamp"
        # Remove original file
        rm "$file"
    fi
done

# Find all flat phosphor files
for file in resources/views/components/ui/icon/phosphor-*.blade.php; do
    if [ -f "$file" ]; then
        filename=$(basename "$file" .blade.php)
        iconname=${filename#phosphor-}
        
        # Create target directory if it doesn't exist
        mkdir -p resources/views/components/ui/icon/phosphor
        
        # Move file to nested structure
        cp "$file" "resources/views/components/ui/icon/phosphor/$iconname.blade.php"
        # Backup file
        cp "$file" "component_backups/$(basename $file)-$timestamp"
        # Remove original file
        rm "$file"
    fi
done

# 3. Clean up duplicate layout files
echo "Cleaning up duplicate layout files..."

# Handle app.blade.php vs app/index.blade.php
if [ -f "resources/views/components/layout/app.blade.php" ] && [ -f "resources/views/components/layout/app/index.blade.php" ]; then
    # Backup both files
    cp "resources/views/components/layout/app.blade.php" "component_backups/app-$timestamp.blade.php"
    cp "resources/views/components/layout/app/index.blade.php" "component_backups/app-index-$timestamp.blade.php"
    
    # Use app/index.blade.php as the standard and remove app.blade.php
    rm "resources/views/components/layout/app.blade.php"
fi

# 4. Clean up duplicate UI components
echo "Cleaning up duplicate UI components..."

# Handle card.blade.php vs card/index.blade.php
if [ -f "resources/views/components/ui/card.blade.php" ] && [ -f "resources/views/components/ui/card/index.blade.php" ]; then
    # Backup both files
    cp "resources/views/components/ui/card.blade.php" "component_backups/card-$timestamp.blade.php"
    cp "resources/views/components/ui/card/index.blade.php" "component_backups/card-index-$timestamp.blade.php"
    
    # Use card/index.blade.php as the standard and remove card.blade.php
    rm "resources/views/components/ui/card.blade.php"
fi

# Handle link.blade.php vs link/index.blade.php
if [ -f "resources/views/components/ui/link.blade.php" ] && [ -f "resources/views/components/ui/link/index.blade.php" ]; then
    # Backup both files
    cp "resources/views/components/ui/link.blade.php" "component_backups/link-$timestamp.blade.php"
    cp "resources/views/components/ui/link/index.blade.php" "component_backups/link-index-$timestamp.blade.php"
    
    # Use link/index.blade.php as the standard and remove link.blade.php
    rm "resources/views/components/ui/link.blade.php"
fi

# 5. Handle old layouts directory if all components have been migrated
echo "Checking if layouts directory can be backed up..."

# Only backup if all components have been migrated to the new structure
# For now we're keeping it, but marking it as deprecated for reference
if [ -d "resources/views/layouts" ]; then
    # Create a .deprecated file to indicate this directory should be removed when ready
    echo "This directory contains deprecated layout files that have been migrated to components/layout." > resources/views/layouts/.deprecated
    echo "These files are kept for reference but should be removed when all migration is verified." >> resources/views/layouts/.deprecated
fi

echo "Component cleanup complete!"
echo "Backups were created in the component_backups directory."

# Make this script executable
chmod +x cleanup-components.sh 
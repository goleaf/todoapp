#!/bin/bash

echo "Standardizing icon components..."

# Create backup directory if it doesn't exist
mkdir -p component_backups/standardize
timestamp=$(date +%Y%m%d%H%M%S)

# Function to standardize heroicon outline icons
standardize_heroicon_o() {
    local dir="resources/views/components/ui/icon/heroicon-o"
    
    if [ -d "$dir" ]; then
        for file in "$dir"/*.blade.php; do
            if [ -f "$file" ]; then
                # Backup original file
                cp "$file" "component_backups/standardize/$(basename $file)-$timestamp"
                
                # Create standardized content
                cat > "$file" << EOL
@props(['class' => '', 'width' => 24, 'height' => 24, 'aria-hidden' => 'true'])

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" {{ \$attributes->merge(['class' => \$class, 'width' => \$width, 'height' => \$height, 'aria-hidden' => \$aria-hidden]) }}>
  $(grep -A 20 "<path" "$file" | head -n 1)
</svg>
EOL
                echo "Standardized: $file"
            fi
        done
    fi
}

# Function to standardize heroicon solid icons
standardize_heroicon_s() {
    local dir="resources/views/components/ui/icon/heroicon-s"
    
    if [ -d "$dir" ]; then
        for file in "$dir"/*.blade.php; do
            if [ -f "$file" ]; then
                # Backup original file
                cp "$file" "component_backups/standardize/$(basename $file)-$timestamp"
                
                # Create standardized content
                cat > "$file" << EOL
@props(['class' => '', 'width' => 24, 'height' => 24, 'aria-hidden' => 'true'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" {{ \$attributes->merge(['class' => \$class, 'width' => \$width, 'height' => \$height, 'aria-hidden' => \$aria-hidden]) }}>
  $(grep -A 20 "<path" "$file" | head -n 1)
</svg>
EOL
                echo "Standardized: $file"
            fi
        done
    fi
}

# Function to standardize phosphor icons
standardize_phosphor() {
    local dir="resources/views/components/ui/icon/phosphor"
    
    if [ -d "$dir" ]; then
        for file in "$dir"/*.blade.php; do
            if [ -f "$file" ]; then
                # Backup original file
                cp "$file" "component_backups/standardize/$(basename $file)-$timestamp"
                
                # Create standardized content
                cat > "$file" << EOL
@props(['class' => '', 'width' => 24, 'height' => 24, 'aria-hidden' => 'true'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" fill="currentColor" {{ \$attributes->merge(['class' => \$class, 'width' => \$width, 'height' => \$height, 'aria-hidden' => \$aria-hidden]) }}>
  $(grep -A 20 "<path" "$file" | head -n 1)
</svg>
EOL
                echo "Standardized: $file"
            fi
        done
    fi
}

# Run standardizations
standardize_heroicon_o
standardize_heroicon_s
standardize_phosphor

echo "Icon component standardization complete!"
# Make this script executable
chmod +x icon-standardize.sh 
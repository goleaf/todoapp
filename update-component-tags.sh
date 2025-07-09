#!/bin/bash

# This script updates component tags in blade files as per the migration rules

echo "Updating component tags in blade files..."

# Function to update component tags in a blade file
update_component_tags() {
    local file="$1"
    
    # Check if the file exists and is a blade file
    if [[ ! -f "$file" || ! "$file" =~ \.blade\.php$ ]]; then
        return
    fi
    
    echo "Processing: $file"
    
    # Input Components
    sed -i 's/<x-input\b/<x-input.input/g' "$file"
    sed -i 's/<x-form\b/<x-input.form/g' "$file"
    sed -i 's/<x-textarea\b/<x-input.textarea/g' "$file"
    sed -i 's/<x-select\b/<x-input.select/g' "$file"
    sed -i 's/<x-checkbox\b/<x-input.checkbox/g' "$file"
    sed -i 's/<x-radio\b/<x-input.radio/g' "$file"
    sed -i 's/<x-input-error\b/<x-input.input-error/g' "$file"
    sed -i 's/<x-label\b/<x-input.label/g' "$file"
    
    # UI Components
    sed -i 's/<x-button\b/<x-ui.button/g' "$file"
    sed -i 's/<x-card\b/<x-ui.card/g' "$file"
    sed -i 's/<x-avatar\b/<x-ui.avatar/g' "$file"
    sed -i 's/<x-badge\b/<x-ui.badge/g' "$file"
    sed -i 's/<x-dropdown-item\b/<x-ui.dropdown.item/g' "$file"
    sed -i 's/<x-dropdown-menu\b/<x-ui.dropdown.menu/g' "$file"
    sed -i 's/<x-modal\b/<x-ui.modal/g' "$file"
    sed -i 's/<x-empty-state\b/<x-ui.empty-state/g' "$file"
    sed -i 's/<x-container\b/<x-ui.container/g' "$file"
    sed -i 's/<x-link\b/<x-ui.link/g' "$file"
    sed -i 's/<x-dark-mode-toggle\b/<x-ui.dark-mode-toggle/g' "$file"
    sed -i 's/<x-status\b/<x-ui.status/g' "$file"
    
    # Layout Components
    sed -i 's/<x-layouts\.app\b/<x-layout.app/g' "$file"
    sed -i 's/<x-layouts\.auth\b/<x-layout.auth/g' "$file"
    sed -i 's/<x-heading\b/<x-layout.heading/g' "$file"
    sed -i 's/<x-subheading\b/<x-layout.subheading/g' "$file"
    sed -i 's/<x-text\b/<x-layout.text/g' "$file"
    sed -i 's/<x-separator\b/<x-layout.separator/g' "$file"
    sed -i 's/<x-spacer\b/<x-layout.spacer/g' "$file"
    sed -i 's/<x-header\b/<x-layout.header/g' "$file"
    sed -i 's/<x-section-header\b/<x-layout.section-header/g' "$file"
    sed -i 's/<x-app-logo\b/<x-layout.app-logo/g' "$file"
    sed -i 's/<x-app-logo-icon\b/<x-layout.app-logo-icon/g' "$file"
    sed -i 's/<x-placeholder-pattern\b/<x-layout.placeholder-pattern/g' "$file"
    
    # Data Components
    sed -i 's/<x-table\b/<x-data.table/g' "$file"
    sed -i 's/<x-table\.row\b/<x-data.table.row/g' "$file"
    sed -i 's/<x-table\.cell\b/<x-data.table.cell/g' "$file"
    sed -i 's/<x-table\.heading\b/<x-data.table.heading/g' "$file"
    
    # Authentication Components
    sed -i 's/<x-auth-header\b/<x-auth.auth-header/g' "$file"
    sed -i 's/<x-auth-session-status\b/<x-auth.auth-session-status/g' "$file"
    
    # Feedback Components
    sed -i 's/<x-error\b/<x-feedback.error/g' "$file"
    sed -i 's/<x-action-message\b/<x-feedback.action-message/g' "$file"
    sed -i 's/<x-alert\b/<x-feedback.alert/g' "$file"
}

# Find all blade files in the project
find resources/views -type f -name "*.blade.php" | while read file; do
    update_component_tags "$file"
done

echo "Component tag update completed!" 
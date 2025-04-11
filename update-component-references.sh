#!/bin/bash

# Define search patterns and replacements following the rules in .cursor/rules/main.mdc
declare -A replacements=(
    # Input Components
    ["<x-input"]="<x-input.input"
    ["<x-form"]="<x-input.form"
    ["<x-textarea"]="<x-input.textarea"
    ["<x-select"]="<x-input.select"
    ["<x-checkbox"]="<x-input.checkbox"
    ["<x-radio"]="<x-input.radio"
    ["<x-input-error"]="<x-input.input-error"
    ["<x-label"]="<x-input.label"
    ["<x-field"]="<x-input.field"
    
    # UI Components
    ["<x-button"]="<x-ui.button"
    ["<x-card"]="<x-ui.card"
    ["<x-avatar"]="<x-ui.avatar"
    ["<x-badge"]="<x-ui.badge"
    ["<x-dropdown-item"]="<x-ui.dropdown.item"
    ["<x-dropdown-menu"]="<x-ui.dropdown.menu"
    ["<x-modal"]="<x-ui.modal"
    ["<x-empty-state"]="<x-ui.empty-state"
    ["<x-container"]="<x-ui.container"
    ["<x-link"]="<x-ui.link"
    ["<x-dark-mode-toggle"]="<x-ui.dark-mode-toggle"
    
    # Layout Components
    ["<x-layouts.app"]="<x-layout.app"
    ["<x-layouts.auth"]="<x-layout.auth"
    ["<x-heading"]="<x-layout.heading"
    ["<x-subheading"]="<x-layout.subheading"
    ["<x-text"]="<x-layout.text"
    ["<x-separator"]="<x-layout.separator"
    ["<x-spacer"]="<x-layout.spacer"
    ["<x-header"]="<x-layout.header"
    ["<x-section-header"]="<x-layout.section-header"
    ["<x-app-logo"]="<x-layout.app-logo"
    ["<x-app-logo-icon"]="<x-layout.app-logo-icon"
    ["<x-placeholder-pattern"]="<x-layout.placeholder-pattern"
    
    # Data Components
    ["<x-table"]="<x-data.table"
    ["<x-table.row"]="<x-data.table.row"
    ["<x-table.cell"]="<x-data.table.cell"
    ["<x-table.heading"]="<x-data.table.heading"
    
    # Authentication Components
    ["<x-auth-header"]="<x-auth.auth-header"
    ["<x-auth-session-status"]="<x-auth.auth-session-status"
    
    # Feedback Components
    ["<x-error"]="<x-feedback.error"
    ["<x-action-message"]="<x-feedback.action-message"
)

# Find all blade templates
find resources/views -type f -name "*.blade.php" | while read file; do
    echo "Processing $file..."
    for pattern in "${!replacements[@]}"; do
        replacement="${replacements[$pattern]}"
        # Skip replacement if the file contains the new pattern already
        if grep -q "$replacement" "$file"; then
            continue
        fi
        sed -i "s/$pattern/$replacement/g" "$file"
    done
done

echo "All component references updated!" 
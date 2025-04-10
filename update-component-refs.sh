#!/bin/bash

echo "Updating component references according to main.mdc rules..."

# Define the replacements from main.mdc
declare -A REPLACEMENTS=(
    # Input Components
    ["<x-input"]="<x-input.input"
    ["<x-form"]="<x-input.form"
    ["<x-textarea"]="<x-input.textarea"
    ["<x-select"]="<x-input.select"
    ["<x-checkbox"]="<x-input.checkbox"
    ["<x-radio"]="<x-input.radio"
    ["<x-input-error"]="<x-input.input-error"
    ["<x-label"]="<x-input.label"

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
    ["<x-status"]="<x-ui.status"

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
    ["<x-alert"]="<x-feedback.alert"
)

# Find all blade files with component references
FILES=$(find resources/views -name "*.blade.php" | xargs grep -l '<x-' | sort)

# Counter for modified files
MODIFIED_COUNT=0

# Process each file
for FILE in $FILES; do
    MODIFIED=false
    
    # Apply each replacement
    for PATTERN in "${!REPLACEMENTS[@]}"; do
        REPLACEMENT="${REPLACEMENTS[$PATTERN]}"
        
        # Skip if the pattern is already in the new format
        if grep -q "$REPLACEMENT" "$FILE"; then
            continue
        fi
        
        # Check if the pattern exists in the file
        if grep -q "$PATTERN" "$FILE"; then
            sed -i "s|$PATTERN|$REPLACEMENT|g" "$FILE"
            MODIFIED=true
            echo "  - Updated $PATTERN to $REPLACEMENT in $FILE"
        fi
    done
    
    if [ "$MODIFIED" = true ]; then
        MODIFIED_COUNT=$((MODIFIED_COUNT + 1))
    fi
done

echo "Component update complete! Modified $MODIFIED_COUNT files." 
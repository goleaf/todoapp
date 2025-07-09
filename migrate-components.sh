#!/bin/bash

echo "Starting component migration..."

# Set the base directory for views
VIEWS_DIR="resources/views"

# Function to perform replacements across all Blade files
migrate_components() {
    echo "Migrating $1 to $2"
    find "$VIEWS_DIR" -type f -name "*.blade.php" -exec sed -i -E "s/<x-$1([^.>]|$)/<x-$2\1/g" {} \;
}

echo "=== Migrating Input Components ==="
migrate_components "input([^.]|$)" "input.input"
migrate_components "form([^.]|$)" "input.form"
migrate_components "textarea([^.]|$)" "input.textarea"
migrate_components "select([^.]|$)" "input.select"
migrate_components "checkbox([^.]|$)" "input.checkbox"
migrate_components "radio([^.]|$)" "input.radio"
migrate_components "input-error([^.]|$)" "input.input-error"
migrate_components "label([^.]|$)" "input.label"

echo "=== Migrating UI Components ==="
migrate_components "button([^.]|$)" "ui.button"
migrate_components "card([^.]|$)" "ui.card"
migrate_components "avatar([^.]|$)" "ui.avatar"
migrate_components "badge([^.]|$)" "ui.badge"
migrate_components "dropdown-item([^.]|$)" "ui.dropdown.item"
migrate_components "dropdown-menu([^.]|$)" "ui.dropdown.menu"
migrate_components "modal([^.]|$)" "ui.modal"
migrate_components "empty-state([^.]|$)" "ui.empty-state"
migrate_components "container([^.]|$)" "ui.container"
migrate_components "link([^.]|$)" "ui.link"
migrate_components "dark-mode-toggle([^.]|$)" "ui.dark-mode-toggle"
migrate_components "status([^.]|$)" "ui.status"

echo "=== Migrating Layout Components ==="
migrate_components "layouts.app([^.]|$)" "layout.app"
migrate_components "layouts.auth([^.]|$)" "layout.auth"
migrate_components "heading([^.]|$)" "layout.heading"
migrate_components "subheading([^.]|$)" "layout.subheading"
migrate_components "text([^.]|$)" "layout.text"
migrate_components "separator([^.]|$)" "layout.separator"
migrate_components "spacer([^.]|$)" "layout.spacer"
migrate_components "header([^.]|$)" "layout.header"
migrate_components "section-header([^.]|$)" "layout.section-header"
migrate_components "app-logo([^.]|$)" "layout.app-logo"
migrate_components "app-logo-icon([^.]|$)" "layout.app-logo-icon"
migrate_components "placeholder-pattern([^.]|$)" "layout.placeholder-pattern"

echo "=== Migrating Data Components ==="
migrate_components "table([^.]|$)" "data.table"
migrate_components "table.row([^.]|$)" "data.table.row"
migrate_components "table.cell([^.]|$)" "data.table.cell"
migrate_components "table.heading([^.]|$)" "data.table.heading"

echo "=== Migrating Authentication Components ==="
migrate_components "auth-header([^.]|$)" "auth.auth-header"
migrate_components "auth-session-status([^.]|$)" "auth.auth-session-status"

echo "=== Migrating Feedback Components ==="
migrate_components "error([^.]|$)" "feedback.error"
migrate_components "action-message([^.]|$)" "feedback.action-message"
migrate_components "alert([^.]|$)" "feedback.alert"

echo "Component migration completed!" 
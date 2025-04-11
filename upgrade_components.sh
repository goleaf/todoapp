#!/bin/bash

# Script to update component references in Blade templates
# Based on the migration rules

echo "Upgrading Blade components..."

# Input Components
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-input([^.]|$)/<x-input.input\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-form([^.]|$)/<x-input.form\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-textarea([^.]|$)/<x-input.textarea\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-select([^.]|$)/<x-input.select\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-checkbox([^.]|$)/<x-input.checkbox\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-radio([^.]|$)/<x-input.radio\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-input-error([^.]|$)/<x-input.input-error\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-label([^.]|$)/<x-input.label\1/g' {} \;

# UI Components
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-button([^.]|$)/<x-ui.button\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-card([^.]|$)/<x-ui.card\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-avatar([^.]|$)/<x-ui.avatar\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-badge([^.]|$)/<x-ui.badge\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-dropdown-item([^.]|$)/<x-ui.dropdown.item\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-dropdown-menu([^.]|$)/<x-ui.dropdown.menu\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-modal([^.]|$)/<x-ui.modal\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-empty-state([^.]|$)/<x-ui.empty-state\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-container([^.]|$)/<x-ui.container\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-link([^.]|$)/<x-ui.link\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-dark-mode-toggle([^.]|$)/<x-ui.dark-mode-toggle\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-status([^.]|$)/<x-ui.status\1/g' {} \;

# Layout Components
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-layouts.app([^.]|$)/<x-layout.app\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-layouts.auth([^.]|$)/<x-layout.auth\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-heading([^.]|$)/<x-layout.heading\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-subheading([^.]|$)/<x-layout.subheading\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-text([^.]|$)/<x-layout.text\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-separator([^.]|$)/<x-layout.separator\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-spacer([^.]|$)/<x-layout.spacer\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-header([^.]|$)/<x-layout.header\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-section-header([^.]|$)/<x-layout.section-header\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-app-logo([^.]|$)/<x-layout.app-logo\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-app-logo-icon([^.]|$)/<x-layout.app-logo-icon\1/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-placeholder-pattern([^.]|$)/<x-layout.placeholder-pattern\1/g' {} \;
# Data Components
find resources/views -type f -name "*.blade.php" -exec sed -i -E 's/<x-table([^.]|$)/<x-data.table\1/g' {} \;

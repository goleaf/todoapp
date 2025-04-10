#!/bin/bash

echo "Updating component references in blade templates..."

# Update Input Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-input /<x-input.input /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-form /<x-input.form /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-textarea /<x-input.textarea /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-select /<x-input.select /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-checkbox /<x-input.checkbox /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-radio /<x-input.radio /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-input-error /<x-input.input-error /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-label /<x-input.label /g' {} \;

# Update UI Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-button /<x-ui.button /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-card /<x-ui.card /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-avatar /<x-ui.avatar /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-badge /<x-ui.badge /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-dropdown-item /<x-ui.dropdown.item /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-dropdown-menu /<x-ui.dropdown.menu /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-modal /<x-ui.modal /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-empty-state /<x-ui.empty-state /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-container /<x-ui.container /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-link /<x-ui.link /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-dark-mode-toggle /<x-ui.dark-mode-toggle /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-status /<x-ui.status /g' {} \;

# Update Layout Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-layouts\.app /<x-layout.app /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-layouts\.app>/<\/x-layout.app>/g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-layouts\.auth /<x-layout.auth /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-layouts\.auth>/<\/x-layout.auth>/g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-heading /<x-layout.heading /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-subheading /<x-layout.subheading /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-text /<x-layout.text /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-separator /<x-layout.separator /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-spacer /<x-layout.spacer /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-header /<x-layout.header /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-section-header /<x-layout.section-header /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-app-logo /<x-layout.app-logo /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-app-logo-icon /<x-layout.app-logo-icon /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-placeholder-pattern /<x-layout.placeholder-pattern /g' {} \;

# Update Data Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-table /<x-data.table /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-table\.row /<x-data.table.row /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-table\.cell /<x-data.table.cell /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-table\.heading /<x-data.table.heading /g' {} \;

# Update Authentication Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-auth-header /<x-auth.auth-header /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-auth-session-status /<x-auth.auth-session-status /g' {} \;

# Update Feedback Components
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-error /<x-feedback.error /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-action-message /<x-feedback.action-message /g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-alert /<x-feedback.alert /g' {} \;

# Fix incorrect double namespacing
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-input\.input\./<x-input./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-input\.input\./<\/x-input./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-form\.index\.input\./<x-input./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-form\.index\.input\./<\/x-input./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-form\.input\./<x-input./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-form\.input\./<\/x-input./g' {} \;

# Fix specific components with nested namespaces
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<x-input\.form\.index\./<x-input.form./g' {} \;
find resources/views -name "*.blade.php" -type f -exec sed -i 's/<\/x-input\.form\.index\./<\/x-input.form./g' {} \;

echo "Component references updated successfully!" 
#!/bin/bash

# Update component tags according to migration rules
echo "Updating component tags according to migration rules..."

# Input Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input/<x-input.input/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-form/<x-input.form/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-textarea/<x-input.textarea/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-select/<x-input.select/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-checkbox/<x-input.checkbox/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-radio/<x-input.radio/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input-error/<x-input.input-error/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-label/<x-input.label/g' {} \;

# UI Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-button/<x-ui.button/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-card/<x-ui.card/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-avatar/<x-ui.avatar/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-badge/<x-ui.badge/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dropdown-item/<x-ui.dropdown.item/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dropdown-menu/<x-ui.dropdown.menu/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-modal/<x-ui.modal/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-empty-state/<x-ui.empty-state/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-container/<x-ui.container/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-link/<x-ui.link/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-dark-mode-toggle/<x-ui.dark-mode-toggle/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-status/<x-ui.status/g' {} \;

# Layout Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-layouts.app/<x-layout.app/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-layouts.auth/<x-layout.auth/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-heading/<x-layout.heading/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-subheading/<x-layout.subheading/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-text/<x-layout.text/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-separator/<x-layout.separator/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-spacer/<x-layout.spacer/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-header/<x-layout.header/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-section-header/<x-layout.section-header/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-app-logo/<x-layout.app-logo/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-app-logo-icon/<x-layout.app-logo-icon/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-placeholder-pattern/<x-layout.placeholder-pattern/g' {} \;

# Data Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table/<x-data.table/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.row/<x-data.table.row/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.cell/<x-data.table.cell/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-table.heading/<x-data.table.heading/g' {} \;

# Authentication Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-auth-header/<x-auth.auth-header/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-auth-session-status/<x-auth.auth-session-status/g' {} \;

# Feedback Components
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-error/<x-feedback.error/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-action-message/<x-feedback.action-message/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-alert/<x-feedback.alert/g' {} \;

# This might need to be fixed after the initial run to avoid double replacements
# Fix any components that might be double-replaced
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.input.input/<x-input.input/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-input.form.form/<x-input.form/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-ui.button.button/<x-ui.button/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-ui.card.card/<x-ui.card/g' {} \;
find /www/wwwroot/todoapp.prus.dev/resources/views -type f -name "*.blade.php" -exec sed -i 's/<x-data.table.table/<x-data.table/g' {} \;

echo "Component updates completed!" 
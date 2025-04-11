#!/bin/bash
echo "Upgrading all Blade components..."
# Input components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-input /<x-input.input /g" -e "s/<x-form /<x-input.form /g" -e "s/<x-textarea /<x-input.textarea /g" -e "s/<x-select /<x-input.select /g" -e "s/<x-checkbox /<x-input.checkbox /g" -e "s/<x-radio /<x-input.radio /g" -e "s/<x-input-error /<x-input.input-error /g" -e "s/<x-label /<x-input.label /g" {} \;
# UI components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-button /<x-ui.button /g" -e "s/<x-card /<x-ui.card /g" -e "s/<x-avatar /<x-ui.avatar /g" -e "s/<x-badge /<x-ui.badge /g" -e "s/<x-dropdown-item /<x-ui.dropdown.item /g" -e "s/<x-dropdown-menu /<x-ui.dropdown.menu /g" -e "s/<x-modal /<x-ui.modal /g" -e "s/<x-empty-state /<x-ui.empty-state /g" -e "s/<x-container /<x-ui.container /g" -e "s/<x-link /<x-ui.link /g" -e "s/<x-dark-mode-toggle /<x-ui.dark-mode-toggle /g" -e "s/<x-status /<x-ui.status /g" {} \;
# Layout components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-layouts.app /<x-layout.app /g" -e "s/<x-layouts.auth /<x-layout.auth /g" -e "s/<x-app-layout>/<x-layout.app>/g" -e "s/<\/x-app-layout>/<\/x-layout.app>/g" -e "s/<x-guest-layout>/<x-layout.auth>/g" -e "s/<\/x-guest-layout>/<\/x-layout.auth>/g" {} \;
# More layout components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-heading /<x-layout.heading /g" -e "s/<x-subheading /<x-layout.subheading /g" -e "s/<x-text /<x-layout.text /g" -e "s/<x-separator /<x-layout.separator /g" -e "s/<x-spacer /<x-layout.spacer /g" -e "s/<x-header /<x-layout.header /g" -e "s/<x-section-header /<x-layout.section-header /g" -e "s/<x-app-logo /<x-layout.app.logo /g" -e "s/<x-app-logo-icon /<x-layout.app.logo-icon /g" -e "s/<x-placeholder-pattern /<x-layout.placeholder-pattern /g" {} \;
# Data, auth & feedback components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-table /<x-data.table /g" -e "s/<x-table.row /<x-data.table.row /g" -e "s/<x-table.cell /<x-data.table.cell /g" -e "s/<x-table.heading /<x-data.table.heading /g" -e "s/<x-auth-header /<x-auth.auth-header /g" -e "s/<x-auth-session-status /<x-auth.auth-session-status /g" -e "s/<x-error /<x-feedback.error /g" -e "s/<x-action-message /<x-feedback.action-message /g" -e "s/<x-alert /<x-feedback.alert /g" {} \;
# Icon components
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-heroicon-o-/<x-ui.icon.heroicon-o-/g" -e "s/<x-heroicon-s-/<x-ui.icon.heroicon-s-/g" -e "s/<x-phosphor-/<x-ui.icon.phosphor-/g" -e "s/<x-dynamic-component /<x-ui.dynamic-component /g" {} \;
# Fix closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-input>/<\/x-input.input>/g" -e "s/<\/x-form>/<\/x-input.form>/g" -e "s/<\/x-textarea>/<\/x-input.textarea>/g" -e "s/<\/x-select>/<\/x-input.select>/g" -e "s/<\/x-checkbox>/<\/x-input.checkbox>/g" -e "s/<\/x-radio>/<\/x-input.radio>/g" -e "s/<\/x-input-error>/<\/x-input.input-error>/g" -e "s/<\/x-label>/<\/x-input.label>/g" {} \;
# Fix UI closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-button>/<\/x-ui.button>/g" -e "s/<\/x-card>/<\/x-ui.card>/g" -e "s/<\/x-avatar>/<\/x-ui.avatar>/g" -e "s/<\/x-badge>/<\/x-ui.badge>/g" -e "s/<\/x-dropdown-item>/<\/x-ui.dropdown.item>/g" -e "s/<\/x-dropdown-menu>/<\/x-ui.dropdown.menu>/g" -e "s/<\/x-modal>/<\/x-ui.modal>/g" -e "s/<\/x-empty-state>/<\/x-ui.empty-state>/g" -e "s/<\/x-container>/<\/x-ui.container>/g" -e "s/<\/x-link>/<\/x-ui.link>/g" {} \;
# Fix more UI closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-dark-mode-toggle>/<\/x-ui.dark-mode-toggle>/g" -e "s/<\/x-status>/<\/x-ui.status>/g" -e "s/<\/x-dynamic-component>/<\/x-ui.dynamic-component>/g" {} \;
# Fix layout closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-layouts.app>/<\/x-layout.app>/g" -e "s/<\/x-layouts.auth>/<\/x-layout.auth>/g" -e "s/<\/x-heading>/<\/x-layout.heading>/g" -e "s/<\/x-subheading>/<\/x-layout.subheading>/g" -e "s/<\/x-text>/<\/x-layout.text>/g" -e "s/<\/x-separator>/<\/x-layout.separator>/g" -e "s/<\/x-spacer>/<\/x-layout.spacer>/g" -e "s/<\/x-header>/<\/x-layout.header>/g" -e "s/<\/x-section-header>/<\/x-layout.section-header>/g" {} \;
# Fix more layout closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-app-logo>/<\/x-layout.app.logo>/g" -e "s/<\/x-app-logo-icon>/<\/x-layout.app.logo-icon>/g" -e "s/<\/x-placeholder-pattern>/<\/x-layout.placeholder-pattern>/g" {} \;
# Fix data, auth and feedback closing tags
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<\/x-table>/<\/x-data.table>/g" -e "s/<\/x-table.row>/<\/x-data.table.row>/g" -e "s/<\/x-table.cell>/<\/x-data.table.cell>/g" -e "s/<\/x-table.heading>/<\/x-data.table.heading>/g" -e "s/<\/x-auth-header>/<\/x-auth.auth-header>/g" -e "s/<\/x-auth-session-status>/<\/x-auth.auth-session-status>/g" -e "s/<\/x-error>/<\/x-feedback.error>/g" -e "s/<\/x-action-message>/<\/x-feedback.action-message>/g" -e "s/<\/x-alert>/<\/x-feedback.alert>/g" {} \;
# Fix any potential double conversions
find resources/views -type f -name "*.blade.php" -exec sed -i -e "s/<x-ui\.ui\./<x-ui./g" -e "s/<\/x-ui\.ui\./<\/x-ui./g" -e "s/<x-input\.input\./<x-input./g" -e "s/<\/x-input\.input\./<\/x-input./g" -e "s/<x-layout\.layout\./<x-layout./g" -e "s/<\/x-layout\.layout\./<\/x-layout./g" -e "s/<x-data\.data\./<x-data./g" -e "s/<\/x-data\.data\./<\/x-data./g" -e "s/<x-feedback\.feedback\./<x-feedback./g" -e "s/<\/x-feedback\.feedback\./<\/x-feedback./g" -e "s/<x-auth\.auth\./<x-auth./g" -e "s/<\/x-auth\.auth\./<\/x-auth./g" {} \;
echo "Component upgrade completed!"

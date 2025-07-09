#!/bin/bash

echo "Checking for components that still need migration..."
VIEWS_DIR="resources/views"

# Input Components
echo "=== Input Components ==="
grep -r "<x-input[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-form[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-textarea[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-select[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-checkbox[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-radio[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-input-error[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-label[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

# UI Components
echo "=== UI Components ==="
grep -r "<x-button[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-card[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-avatar[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-badge[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-dropdown-item[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-dropdown-menu[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-modal[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-empty-state[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-container[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-link[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-dark-mode-toggle[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-status[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

# Layout Components
echo "=== Layout Components ==="
grep -r "<x-layouts.app[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-layouts.auth[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-heading[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-subheading[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-text[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-separator[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-spacer[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-header[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-section-header[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-app-logo[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-app-logo-icon[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-placeholder-pattern[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

# Data Components
echo "=== Data Components ==="
grep -r "<x-table[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-table.row[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-table.cell[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-table.heading[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

# Authentication Components
echo "=== Authentication Components ==="
grep -r "<x-auth-header[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-auth-session-status[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

# Feedback Components
echo "=== Feedback Components ==="
grep -r "<x-error[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-action-message[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l
grep -r "<x-alert[^.]" $VIEWS_DIR --include="*.blade.php" | wc -l

echo "Check completed. Numbers indicate components that still need migration." 
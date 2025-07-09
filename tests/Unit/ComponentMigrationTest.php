<?php

namespace Tests\Unit;

use Tests\TestCase;

class ComponentMigrationTest extends TestCase
{
    private $componentMigrationRules = [
        // Input Components
        '/<x-input\b(?![.\-])/' => '<x-input.input',
        '/<x-form\b(?![.\-])/' => '<x-input.form',
        '/<x-textarea\b(?![.\-])/' => '<x-input.textarea',
        '/<x-select\b(?![.\-])/' => '<x-input.select',
        '/<x-checkbox\b(?![.\-])/' => '<x-input.checkbox',
        '/<x-radio\b(?![.\-])/' => '<x-input.radio',
        '/<x-input-error\b(?![.\-])/' => '<x-input.input-error',
        '/<x-label\b(?![.\-])/' => '<x-input.label',

        // UI Components
        '/<x-button\b(?![.\-])/' => '<x-ui.button',
        '/<x-card\b(?![.\-])/' => '<x-ui.card',
        '/<x-avatar\b(?![.\-])/' => '<x-ui.avatar',
        '/<x-badge\b(?![.\-])/' => '<x-ui.badge',
        '/<x-dropdown-item\b(?![.\-])/' => '<x-ui.dropdown.item',
        '/<x-dropdown-menu\b(?![.\-])/' => '<x-ui.dropdown.menu',
        '/<x-modal\b(?![.\-])/' => '<x-ui.modal',
        '/<x-empty-state\b(?![.\-])/' => '<x-ui.empty-state',
        '/<x-container\b(?![.\-])/' => '<x-ui.container',
        '/<x-link\b(?![.\-])/' => '<x-ui.link',
        '/<x-dark-mode-toggle\b(?![.\-])/' => '<x-ui.dark-mode-toggle',
        '/<x-status\b(?![.\-])/' => '<x-ui.status',

        // Layout Components
        '/<x-layouts.app\b(?![.\-])/' => '<x-layout.app',
        '/<x-layouts.auth\b(?![.\-])/' => '<x-layout.auth',
        '/<x-heading\b(?![.\-])/' => '<x-layout.heading',
        '/<x-subheading\b(?![.\-])/' => '<x-layout.subheading',
        '/<x-text\b(?![.\-])/' => '<x-layout.text',
        '/<x-separator\b(?![.\-])/' => '<x-layout.separator',
        '/<x-spacer\b(?![.\-])/' => '<x-layout.spacer',
        '/<x-header\b(?![.\-])/' => '<x-layout.header',
        '/<x-section-header\b(?![.\-])/' => '<x-layout.section-header',
        '/<x-app-logo\b(?![.\-])/' => '<x-layout.app-logo',
        '/<x-app-logo-icon\b(?![.\-])/' => '<x-layout.app-logo-icon',
        '/<x-placeholder-pattern\b(?![.\-])/' => '<x-layout.placeholder-pattern',

        // Data Components
        '/<x-table\b(?![\.\-])/' => '<x-data.table',
        '/<x-table.row\b(?![\.\-])/' => '<x-data.table.row',
        '/<x-table.cell\b(?![\.\-])/' => '<x-data.table.cell',
        '/<x-table.heading\b(?![\.\-])/' => '<x-data.table.heading',
        
        // Auth Components
        '/<x-auth-header\b(?![.\-])/' => '<x-auth.auth-header',
        '/<x-auth-session-status\b(?![.\-])/' => '<x-auth.auth-session-status',

        // Feedback Components
        '/<x-error\b(?![.\-])/' => '<x-feedback.error',
        '/<x-action-message\b(?![.\-])/' => '<x-feedback.action-message',
        '/<x-alert\b(?![.\-])/' => '<x-feedback.alert',
    ];

    public function testNoUnmigratedComponentsInBladeFiles()
    {
        $viewsPath = base_path('resources/views');
        $unmigrated = [];

        $this->findUnmigratedComponents($viewsPath, $unmigrated);

        // If unmigrated components were found, the test will fail and display them
        $this->assertEmpty($unmigrated, "Unmigrated components found in blade files:\n" . implode("\n", $unmigrated));
    }

    private function findUnmigratedComponents($dir, &$unmigrated, $relativePath = '')
    {
        $files = scandir($dir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $path = $dir . '/' . $file;
            $currentRelativePath = $relativePath ? $relativePath . '/' . $file : $file;

            if (is_dir($path)) {
                $this->findUnmigratedComponents($path, $unmigrated, $currentRelativePath);
            } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $content = file_get_contents($path);
                
                foreach ($this->componentMigrationRules as $pattern => $replacement) {
                    if (preg_match($pattern, $content)) {
                        $matches = [];
                        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);
                        
                        foreach ($matches[0] as $match) {
                            $lineNumber = $this->getLineNumber($content, $match[1]);
                            $unmigrated[] = "File: {$currentRelativePath}, Line: {$lineNumber}, Found: {$match[0]} (Should be migrated to {$replacement})";
                        }
                    }
                }
            }
        }
    }

    private function getLineNumber($content, $position)
    {
        return substr_count(substr($content, 0, $position), "\n") + 1;
    }
} 
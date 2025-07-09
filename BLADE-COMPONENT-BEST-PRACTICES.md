# Laravel Blade Component Best Practices

This document outlines best practices for developing and maintaining Laravel Blade components based on the experiences in fixing component issues in this project.

## Component Naming and Organization

1. **Use consistent naming conventions**:
   - Use kebab-case for component file names
   - Use dot notation for component references in templates (e.g., `<x-ui.card>`)
   - Avoid using `.index` in component references - reference the base component directly (e.g., `<x-ui.card>` instead of `<x-ui.card.index>`)

2. **Organize components logically**:
   - Group related components in directories
   - Common organization patterns:
     - `ui` - User interface components (buttons, cards, modals)
     - `layout` - Structural components (headers, footers, sidebars)
     - `input` - Form input components
     - `data` - Data presentation components (tables, pagination)
     - `feedback` - User feedback components (alerts, notices)

3. **Avoid empty directories**:
   - Every directory should contain at least one component file
   - Clean up unused directories to maintain a clean structure

## Component Development

1. **Always use `@props` declarations**:
   - Define all expected properties at the top of each component
   - Use default values where appropriate (e.g., `@props(['type' => 'primary'])`)
   - Document complex props with comments

2. **Minimize use of `@php` blocks**:
   - Prefer Blade syntax over PHP blocks when possible
   - If complex logic is needed, consider moving it to a View Composer or Component class

3. **Keep nesting to a minimum**:
   - Avoid excessive component nesting (more than two dots in the reference)
   - If deep nesting is necessary, create intermediate components

4. **Create index.blade.php files only when needed**:
   - Only create index files if the component has multiple subcomponents
   - For simple components, use the direct component name (e.g., `card.blade.php`)

## Component Maintenance

1. **Regularly check for missing components**:
   - Run the `verify-components.sh` script periodically to catch issues
   - Fix missing components as soon as they're identified

2. **Back up original components before making changes**:
   - Create backups with `.bak` extension when modifying existing components
   - Remove backups after confirming the changes work correctly

3. **Update the component documentation**:
   - Keep this document updated with new best practices
   - Document complex components with inline comments

4. **Test component changes thoroughly**:
   - Test on multiple pages where the component is used
   - Check different component states and variations

## Common Issues and Solutions

1. **"View not found" errors**:
   - Check if the component exists at the referenced path
   - Ensure directory structure matches the dot notation
   - Create missing components as needed

2. **Inconsistent rendering**:
   - Verify props are correctly passed and used
   - Check for conditional rendering logic that might cause issues

3. **Component conflicts**:
   - Avoid duplicate component names in different directories
   - Use namespaced components if needed (using Component classes)

## Tools for Component Management

The following scripts are available to help manage components:

- `verify-components.sh` - Checks for missing components, excessive nesting, and PHP blocks
- `cleanup-component-directories.sh` - Removes backup files and empty directories
- `fix-card-index.sh` - Example of a script to fix specific component issues

These tools should be used regularly to maintain a clean and functional component structure. 
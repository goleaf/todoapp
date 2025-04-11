# Component Duplications and Merge Notes

This document outlines potential component duplications that should be reviewed to ensure functionality is not lost.

## Potential Duplications

1. **Navigation Items**:
   - `layout/navbar/item` and `layout/navlist/item` - These have similar functionality for navigation elements.
   - Consider consolidating these into a single reusable component.

2. **UI Item Components**:
   - `ui/dropdown/item` and `ui/popover/item` - These handle similar interactive menu items.
   - Consider creating a shared base component that both can extend.

3. **Group Components**:
   - `input/form/group`, `ui/button/group`, and `layout/navlist/group` all provide grouping functionality.
   - Each serves a different purpose, but they might benefit from shared traits or utilities.

## Best Practices for Future Development

1. **Component Naming**:
   - Use descriptive, consistent naming within each category.
   - Follow the pattern: `{category}.{component-name}` (e.g., `ui.button`).

2. **Component Structure**:
   - Keep all components in their respective category folders.
   - Use `index.blade.php` for the main component implementation.
   - Use subfolders for component variants or related pieces.

3. **Avoid Duplication**:
   - Before creating a new component, check if similar functionality already exists.
   - Consider extending or adapting existing components for new use cases.

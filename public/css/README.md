# Text Size Feature

This feature allows users to adjust the text size throughout the application for better readability.

## Features

- Three text size options: Small, Medium (default), and Large
- Accessible from the navigation bar or settings page
- Keyboard shortcuts support (1, 2, 3 for sizes, t+s to open menu)
- Persists user preferences between sessions
- Fully accessible with keyboard navigation
- Print-friendly styles
- Visual indicators and notifications

## Files

- `public/css/text-size.css` - Styling for different text sizes
- `resources/js/components/textSize.js` - Alpine.js component for text size functionality
- `resources/views/components/ui/text-size-toggle/index.blade.php` - Text size dropdown component
- `resources/views/settings/appearance.blade.php` - Settings page integration

## Usage

### In Templates

```blade
<x-ui.text-size-toggle />
```

### Keyboard Shortcuts

- `1` - Set to small text size
- `2` - Set to medium text size
- `3` - Set to large text size
- `t` then `s` - Open text size menu

### JavaScript API

```js
// Set text size programmatically
window.dispatchEvent(new CustomEvent('text-size-change'));

// Listen for text size changes
window.addEventListener('text-size-updated', (event) => {
  console.log('Text size changed to:', event.detail.size);
});
``` 
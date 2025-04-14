<?php

return [
    // Accessibility Page
    'title' => 'Accessibility Features',
    'introduction' => 'We are committed to making this app accessible to everyone. Your accessibility preferences are saved in your browser.',
    
    // Text Size
    'text_size' => [
        'title' => 'Text Size Controls',
        'description' => 'Adjust the text size throughout the application to improve readability.',
        'instructions' => 'You can change the text size by clicking the text size icon in the navigation bar or using the controls below.',
        'examples' => 'Examples of different text sizes:',
        'small' => 'Small text size (0.875rem)',
        'medium' => 'Medium text size - Default (1rem)',
        'large' => 'Large text size (1.25rem)',
    ],
    
    // High Contrast Mode
    'high_contrast' => [
        'title' => 'High Contrast Mode',
        'description' => 'Enhances visibility for users with low vision by providing stronger color contrast.',
        'instructions' => 'You can toggle high contrast mode using the toggle in the navigation bar or by pressing Alt+H on your keyboard.',
        'on' => 'High contrast mode is ON',
        'off' => 'High contrast mode is OFF',
    ],
    
    // Keyboard Navigation
    'keyboard' => [
        'title' => 'Keyboard Navigation',
        'description' => 'This app can be fully navigated using only the keyboard.',
        'shortcuts' => 'Common keyboard shortcuts:',
        'tab' => 'Tab: Move to the next interactive element',
        'shift_tab' => 'Shift+Tab: Move to the previous interactive element',
        'enter' => 'Enter: Activate buttons or links',
        'space' => 'Space: Activate buttons or toggle checkboxes',
        'arrows' => 'Arrow keys: Navigate through menus and lists',
        'focus' => 'Focus indicators will show which element is currently active.',
    ],
    
    // Screen Reader Support
    'screen_reader' => [
        'title' => 'Screen Reader Support',
        'description' => 'This app is compatible with screen readers like NVDA, JAWS, and VoiceOver.',
        'features' => [
            'title' => 'Features for screen reader users:',
            'landmarks' => 'Proper landmarks and regions for easy navigation',
            'headings' => 'Hierarchical headings structure',
            'labels' => 'All interactive elements have proper labels and ARIA attributes',
            'alt_text' => 'Images have appropriate alt text',
            'announcements' => 'Important actions are announced to screen readers',
        ],
    ],

    // Enhanced Focus
    'enhanced_focus' => [
        'title' => 'Enhanced Focus Indicators',
        'description' => 'Makes focus outlines more visible when navigating with a keyboard.',
        'enabled' => 'enabled',
        'disabled' => 'disabled',
    ],

    // Reduce Motion
    'reduce_motion' => [
        'title' => 'Reduce Motion',
        'description' => 'Minimize animations and transitions for users sensitive to motion.',
        'enabled' => 'enabled',
        'disabled' => 'disabled',
    ],
    
    // Settings Page
    'settings' => [
        'title' => 'Accessibility Settings',
        'description' => 'Customize the app to meet your accessibility needs',
        'display_preferences' => 'Display Preferences',
        
        'text_size' => [
            'title' => 'Text Size',
            'description' => 'Choose your preferred text size for better readability.',
            'small' => 'Small',
            'small_description' => 'Compact text for more content on screen.',
            'medium' => 'Medium',
            'medium_description' => 'Standard text size (default).',
            'large' => 'Large',
            'large_description' => 'Larger text for improved readability.',
        ],
        
        'high_contrast' => [
            'title' => 'High Contrast Mode',
            'description' => 'Toggle high contrast for better visibility.',
            'toggle' => 'Toggle high contrast mode',
            'status' => 'High contrast mode is',
            'enabled' => 'enabled',
            'disabled' => 'disabled',
            'shortcut' => 'Keyboard shortcut:',
        ],
        
        'enhanced_focus' => [
            'title' => 'Enhanced Focus Indicators',
            'description' => 'Makes focus outlines more visible when navigating with a keyboard.',
            'toggle' => 'Toggle enhanced focus indicators',
            'status' => 'Enhanced focus indicators are',
            'enabled' => 'enabled',
            'disabled' => 'disabled',
        ],
        
        'reduce_motion' => [
            'title' => 'Reduce Motion',
            'description' => 'Minimize animations and transitions for users sensitive to motion.',
            'toggle' => 'Toggle reduced motion',
            'status' => 'Reduced motion is',
            'enabled' => 'enabled',
            'disabled' => 'disabled',
        ],
        
        'reset' => [
            'title' => 'Reset Accessibility Settings',
            'description' => 'Return all accessibility settings to their default values.',
            'button' => 'Reset to Defaults',
            'success' => 'Settings have been reset to their default values',
        ],
        
        'learn_more' => 'Want to learn more about our accessibility features?',
        'view_guide' => 'View Accessibility Guide',
    ],
    
    // Resources Section
    'resources' => [
        'title' => 'Additional Resources',
        'help_center' => 'Visit our <a href=":url">Help Center</a> for more information on using accessibility features.',
        'statement' => 'Read our <a href=":url">accessibility statement</a> to learn about our commitment to WCAG 2.1 Level AA standards.',
    ],
]; 
<?php

if (!function_exists('heroicon')) {
    /**
     * Get a heroicon component name.
     *
     * @param string $style The style of the icon (solid, outline)
     * @param string $name The name of the icon
     * @return string The component name
     */
    function heroicon($style, $name) {
        return "heroicon-" . ($style === 'solid' ? 's' : 'o') . "-" . $name;
    }
} 
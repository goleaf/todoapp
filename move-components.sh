#!/bin/bash

# Input components
cp resources/views/components/textarea.blade.php resources/views/components/input/textarea/index.blade.php
cp resources/views/components/input.blade.php resources/views/components/input/input/index.blade.php
cp resources/views/components/input-error.blade.php resources/views/components/input/input-error/index.blade.php
cp resources/views/components/label.blade.php resources/views/components/input/label/index.blade.php
cp resources/views/components/radio.blade.php resources/views/components/input/radio/index.blade.php
cp resources/views/components/checkbox.blade.php resources/views/components/input/checkbox/index.blade.php
cp resources/views/components/form.blade.php resources/views/components/input/form/index.blade.php
cp resources/views/components/field.blade.php resources/views/components/input/field/index.blade.php
cp resources/views/components/select.blade.php resources/views/components/input/select/index.blade.php

# UI components
cp resources/views/components/button.blade.php resources/views/components/ui/button/index.blade.php
cp resources/views/components/card.blade.php resources/views/components/ui/card/index.blade.php
cp resources/views/components/avatar.blade.php resources/views/components/ui/avatar/index.blade.php
cp resources/views/components/badge.blade.php resources/views/components/ui/badge/index.blade.php
cp resources/views/components/container.blade.php resources/views/components/ui/container/index.blade.php
cp resources/views/components/empty-state.blade.php resources/views/components/ui/empty-state/index.blade.php
cp resources/views/components/link.blade.php resources/views/components/ui/link/index.blade.php
cp resources/views/components/modal.blade.php resources/views/components/ui/modal/index.blade.php
cp resources/views/components/dark-mode-toggle.blade.php resources/views/components/ui/dark-mode-toggle/index.blade.php
cp resources/views/components/dropdown-item.blade.php resources/views/components/ui/dropdown/item.blade.php
cp resources/views/components/dropdown-menu.blade.php resources/views/components/ui/dropdown/menu.blade.php

# Layout components
cp resources/views/components/heading.blade.php resources/views/components/layout/heading/index.blade.php
cp resources/views/components/subheading.blade.php resources/views/components/layout/subheading/index.blade.php
cp resources/views/components/text.blade.php resources/views/components/layout/text/index.blade.php
cp resources/views/components/separator.blade.php resources/views/components/layout/separator/index.blade.php
cp resources/views/components/spacer.blade.php resources/views/components/layout/spacer/index.blade.php
cp resources/views/components/header.blade.php resources/views/components/layout/header/index.blade.php
cp resources/views/components/section-header.blade.php resources/views/components/layout/section-header/index.blade.php
cp resources/views/components/app-logo.blade.php resources/views/components/layout/app-logo/index.blade.php
cp resources/views/components/app-logo-icon.blade.php resources/views/components/layout/app-logo-icon/index.blade.php
cp resources/views/components/placeholder-pattern.blade.php resources/views/components/layout/placeholder-pattern/index.blade.php

# Feedback components
cp resources/views/components/error.blade.php resources/views/components/feedback/error/index.blade.php
cp resources/views/components/action-message.blade.php resources/views/components/feedback/action-message/index.blade.php

# Data components
cp resources/views/components/table.blade.php resources/views/components/data/table/index.blade.php

echo "All components copied to their respective subdirectories." 
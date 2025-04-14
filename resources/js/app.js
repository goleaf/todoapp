import 'instant.page'
import Alpine from 'alpinejs'
import ajax from '@imacrayon/alpine-ajax'
import Popover from './components/popover'
import Toast from './components/toast'
import KeyboardShortcuts from './components/keyboardShortcuts'
import TextSize from './components/textSize'
import Animations from './components/animations'

// Register Alpine plugins and components
Alpine.plugin(ajax)
Alpine.data('popover', Popover)
Alpine.data('toast', Toast)
Alpine.data('keyboardShortcuts', KeyboardShortcuts)
Alpine.data('textSize', TextSize)
Alpine.data('animations', Animations)

// Initialize Alpine
Alpine.start()

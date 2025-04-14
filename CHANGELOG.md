# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Enhanced Category API with improved validation and consistent responses
- Added API Resources for standardized JSON formatting and paginated responses
  - TodoResource, UserResource
  - TodoCollection, CategoryCollection
- Implemented proper Auth controller with registration, login and logout endpoints
- Added dedicated Form Request classes
  - CategoryRequest, LoginRequest, RegisterRequest
  - Enhanced TodoRequest with better validation messages
- Multilingual support for 8 languages (en, es, ru, lt, fr, de, it, ja, zh)
  - Added translations for messages, categories, todos and auth
  - Implemented localized validation error messages
- Accessibility improvements
  - Added text size control styles (`text-size-small`, `text-size-medium`, `text-size-large`)
  - Implemented high contrast mode toggle with keyboard shortcut support (Alt+H)
  - Added screen reader announcements for UI state changes
  - Enhanced component namespacing to improve maintenance and organization

## [2.0.0]

### Major Features
- Completely redesigned UI with Tailwind CSS
- New dashboard with statistics and improved mobile experience
- Tags for todos and advanced filtering/sorting
- Dark mode support

### Architectural Changes
- Removed Vue.js dependency
- Switched to Blade templates for all views
- Improved performance and load times
- Enhanced security features

## [1.2.0]

### Data Management
- Category management
- Bulk actions for todos
- Export functionality (CSV, PDF)
- User preferences

### Interface Updates
- Redesigned dashboard
- Improved accessibility
- Enhanced form validation

### System Fixes
- Fixed date formatting issues
- Fixed category filter not working correctly
- Fixed subtask counting issue

## [1.1.0]

### Task Management
- Subtasks functionality
- Due date reminders
- Improved filtering options
- Search functionality

### UI Improvements
- Enhanced UI with Tailwind CSS
- Improved mobile responsiveness

### Performance
- Optimized database queries

### Bug Fixes
- Fixed issue with task sorting
- Fixed validation errors in the todo form
- Fixed pagination on smaller screens

## [1.0.0]

### Core Functionality
- Initial release of the Todo App
- User authentication (login, registration, logout)
- Todo CRUD functionality 
- Todo categorization
- Todo priorities (low, medium, high)
- Todo statuses (pending, in progress, completed)
- Todo filtering and sorting
- RESTful API for todos and categories
- Responsive design with Tailwind CSS
- Basic directory structure for API, admin panel, user frontend, tests
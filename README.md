# Todo App

A modern todo management application built with Laravel and Tailwind CSS.

## Features

- **User Authentication**: Secure login, registration, and user management
- **Todo Management**: Create, read, update, and delete todos
- **Task Organization**: Categorize tasks and create subtasks
- **Filtering & Sorting**: Filter by category, status, and sort by various criteria
- **Priority Levels**: Set task priority (low, medium, high)
- **Status Tracking**: Track task status (pending, in progress, completed)
- **Due Dates**: Set and track due dates for tasks
- **Responsive Design**: Built with Tailwind CSS for a beautiful, responsive interface
- **RESTful API**: Complete API for frontend integration
- **Multilingual Support**: Available in 8 languages (English, Russian, Lithuanian, French, German, Italian, Japanese, Chinese)
- **Standardized API Responses**: Consistent JSON formatting using API Resources
- **Form Request Validation**: Robust input validation with localized error messages
- **Accessibility Features**:
  - High Contrast Mode: Toggle for increased visibility with keyboard shortcut (Alt+H)
  - Text Size Controls: Small, medium, and large text options for better readability
  - Enhanced Focus Indicators: Improved visibility for keyboard navigation
  - Reduced Motion: Minimizes animations for users sensitive to motion (Alt+M)
  - Screen Reader Announcements: ARIA live regions for key UI changes
  - Keyboard Navigation: Complete keyboard access to all features
  - Dedicated Settings Page: Comprehensive accessibility options at /settings/accessibility

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Sanctum
- **Styling**: Tailwind CSS with custom components
- **Icons**: Heroicons
- **Assets**: Vite for asset bundling

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js and NPM
- MySQL or SQLite

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/your-username/todo-app.git
   cd todo-app
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create a copy of the .env file:
   ```
   cp .env.example .env
   ```

5. Generate an application key:
   ```
   php artisan key:generate
   ```

6. Configure your database in the .env file.

7. Run the database migrations:
   ```
   php artisan migrate
   ```

8. Seed the database (optional):
   ```
   php artisan db:seed
   ```

9. Build the frontend assets:
   ```
   npm run build
   ```

10. Start the development server:
    ```
    php artisan serve
    ```

11. Visit [http://localhost:8000](http://localhost:8000) in your browser.

## API Documentation

The application includes a RESTful API with the following endpoints:

### Authentication Endpoints

- `POST /api/register` - Register a new user
- `POST /api/login` - Login and get auth token
- `POST /api/logout` - Logout and invalidate token
- `GET /api/user` - Get authenticated user information

### Todo Endpoints

- `GET /api/todos` - Get all todos (with filtering options)
- `POST /api/todos` - Create a new todo
- `GET /api/todos/{id}` - Get a specific todo
- `PUT /api/todos/{id}` - Update a todo
- `DELETE /api/todos/{id}` - Delete a todo

### Category Endpoints

- `GET /api/categories` - Get all categories
- `POST /api/categories` - Create a new category
- `GET /api/categories/{id}` - Get a specific category
- `PUT /api/categories/{id}` - Update a category
- `DELETE /api/categories/{id}` - Delete a category

For detailed API documentation, see the [API Documentation](API.md).

## Language Support

The application supports the following languages:

- English (en) - Default
- Russian (ru)
- Lithuanian (lt)
- French (fr)
- German (de)
- Italian (it)
- Japanese (ja)
- Chinese (zh)

To change the application language, you can set it in your user profile or use the language switcher in the UI.

## Accessibility

This application prioritizes accessibility with a comprehensive approach:

### Features for Users
- **High Contrast Mode**: Enhanced color contrasts for users with visual impairments, toggleable via UI or keyboard shortcut (Alt+H)
- **Text Size Controls**: Three size options (small, medium, large) affecting all text elements proportionally
- **Reduced Motion**: Limits animations and transitions for users with vestibular disorders (Alt+M)
- **Enhanced Focus Indicators**: Prominent visual indicators when navigating via keyboard (Alt+F)
- **Keyboard Navigation**: Complete keyboard access to all features with intuitive shortcuts
- **Screen Reader Support**: Comprehensive ARIA attributes and live announcements

### Technical Implementation
- **Dedicated Settings Page**: Available at `/settings/accessibility` with all options in one place
- **LocalStorage Persistence**: User preferences saved and applied across sessions
- **Media Query Support**: Respects OS-level preferences like `prefers-reduced-motion`
- **Cross-tab Synchronization**: Settings synchronized across browser tabs
- **Progressive Enhancement**: Core functionality works without JavaScript
- **Responsive Design**: Accessibility features fully functional on all devices and screen sizes

### Standards Compliance
- Follows WCAG 2.1 AA guidelines
- Semantic HTML structure
- Appropriate color contrast ratios
- Properly labeled form controls
- Meaningful alt text for images

## Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

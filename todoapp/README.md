# Todo React Application

This is a simple React-based Todo application that interfaces with the Laravel backend API.

## Features

- Create, read, update, and delete todos
- Filter todos by status, priority, and category
- Create and manage categories for better organization
- Mark todos as complete or incomplete
- Create subtasks for complex todos

## Project Structure

```
todoapp/
├── src/
│   ├── api/          # API client code for communicating with the backend
│   ├── components/   # Reusable UI components
│   ├── contexts/     # React context providers
│   ├── hooks/        # Custom React hooks
│   ├── pages/        # Page components
│   ├── utils/        # Utility functions
│   └── App.tsx       # Main application component
├── public/           # Public assets
└── package.json      # Project dependencies
```

## Technology Stack

- React (TypeScript)
- Axios for API calls
- React Router for navigation

## Getting Started

1. Make sure the Laravel backend is running
2. Install dependencies:
   ```
   npm install
   ```
3. Start the development server:
   ```
   npm start
   ```

## API Integration

This application communicates with the Laravel backend API endpoints:

- `/api/todos` - CRUD operations for todos
- `/api/categories` - CRUD operations for categories
- `/api/todos/statistics` - Get statistics about todos

## Implementation Notes

- No external UI libraries are used to keep the application lightweight
- The app is optimized for performance with minimal re-renders
- Focus on clean code architecture with separation of concerns 
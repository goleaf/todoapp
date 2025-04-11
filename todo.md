# Project TODOs and Improvements

This document tracks tasks to improve the project.

## Test Status (Current)

*   **Passing:** All Unit (1) and Feature (31) tests are passing.
*   **Warnings:** Feature tests (Admin, Example, some API) show warnings related to Vite HMR file (`public/hot`), likely ignorable in CI/test environments.

## Completed Steps (Major)

*   ✅ Initial Laravel 11 setup and dependency installation.
*   ✅ Database setup (`database.sqlite`, `RefreshDatabase` trait).
*   ✅ Core API implementation (CRUD, filtering, sorting, pagination) with Enums, Form Requests, API Resources, Collections.
*   ✅ Basic i18n setup and translations for multiple languages.
*   ✅ Authentication controllers (Register, Login, Logout) and requests.
*   ✅ **Frontend Overhaul:**
    *   ✅ Integrated Tailwind CSS.
    *   ✅ Created `app` and `guest` layouts with components (navigation, dropdowns, form inputs, alerts, etc.).
    *   ✅ Refactored all Blade views (`welcome`, `home`, `auth/*`, `todos/*`, `admin/*`) to use Tailwind CSS, layouts, and components for a modern, responsive design.
    *   ✅ Added icons and improved styling across the application.
    *   ✅ Compiled frontend assets.

## Next Steps

*   **Address Test Warnings:** Optionally, investigate and silence the `file_get_contents(/public/hot)` warnings in feature tests.
*   ⏳ **Refine UI/UX:** Further polish the Tailwind design, add more components for consistency. (✅ Integrated `blade-ui-kit/blade-heroicons` package and replaced inline SVGs in main CRUD views.)
*   **Frontend Interaction:** Enhance frontend JavaScript for dynamic behavior (e.g., Alpine.js for modals, interactive elements).
*   **API Documentation:** Create detailed API documentation (e.g., using OpenAPI/Swagger).
*   **Unit Tests:** Add unit tests for new/refactored components, resources, and requests.
*   **Admin CRUD Views:** Although index views are styled, the specific create/edit/show views within `resources/views/admin/todos` and `resources/views/admin/users` might need further refinement or creation if they don't fully exist yet.
*   **Further Enhance i18n:** Add more language translations for all application messages and UI elements.
*   **Continue Feature Development.**

## Potential Future Improvements (Enhanced)

This list includes ideas inspired by modern todo/task management applications.

**Task Management:**
*   **Recurring Tasks:** Set tasks to repeat on daily, weekly, monthly, or custom schedules.
*   **Reminders:** Add specific date/time reminders for tasks (potentially location-based).
*   **Natural Language Processing:** Allow creating tasks like "Buy milk tomorrow at 5 pm #groceries p1".
*   **Task Duration/Estimates:** Add fields for estimated time and track actual time spent.
*   **Progress Tracking:** Implement percentage completion for larger tasks.
*   **Dependencies:** Define dependencies between tasks (e.g., Task B cannot start until Task A is complete).
*   **Bulk Actions:** Allow editing/deleting multiple tasks at once.

**Organization & Views:**
*   **Custom Filters & Saved Views:** Allow users to create and save complex filter combinations.
*   **Tags/Labels Enhancements:** Improve tag management, allow tag colors, filter by multiple tags.
*   **Project Templates:** Create reusable templates for common project types.
*   **Sections within Projects:** Allow grouping tasks into sections within a single todo list/project (already partially done with subtasks, could be more generic).
*   **Color-Coding:** Assign colors to projects, tags, or priorities for better visual organization.
*   **Kanban Board View:** Add an alternative view for tasks displayed as cards in columns (e.g., To Do, In Progress, Done).
*   **Calendar View:** Integrate a calendar view showing tasks with due dates.

**Collaboration:**
*   **Task Assignment:** Assign tasks to other users (requires multi-user features beyond basic auth).
*   **Comments & Activity Log:** Allow users to comment on tasks and view a history of changes.
*   **Shared Projects/Lists:** Implement functionality for users to share lists/projects with others.

**UI/UX & Frontend:**
*   **Keyboard Shortcuts:** Implement shortcuts for common actions (add task, complete task, etc.).
*   **Customizable Themes:** Allow users to choose different color themes (beyond light/dark).
*   **Drag & Drop Reordering:** Allow reordering tasks and potentially moving them between sections/lists via drag and drop.
*   **Gamification:** Introduce points/karma for completing tasks.
*   **Enhanced Mobile Experience / PWA:** Improve responsiveness and consider Progressive Web App features for offline access/installability.
*   **Rich Text Editing:** Use a WYSIWYG editor for task descriptions.

**Integrations & Advanced Features:**
*   **Calendar Sync (2-way):** Sync tasks with external calendars like Google Calendar or Outlook.
*   **Email Integration:** Create tasks by sending/forwarding emails to a specific address.
*   **Browser Extensions:** Create browser extensions for quickly adding tasks.
*   **API Enhancements:** Add more API endpoints, webhooks, potentially GraphQL.
*   **AI Features:** Explore AI for task suggestions, scheduling optimization, or summarizing.
*   **Offline Access:** Improve support for using the app when offline.
*   **Reporting & Analytics:** Provide insights into task completion rates, productivity trends, etc.
*   **Advanced User Roles & Permissions:** Finer-grained control over what users can see and do.
*   **Full-text Search for Todos:** More robust search capabilities.
*   **User Profiles and Settings:** Allow users to customize profile details and application settings.
*   **Notifications:** Implement in-app and potentially email/push notifications for reminders, assignments, comments.
*   **Deployment Setup:** Document or script the deployment process.

## 1. Fix Failing Feature Tests (Database Setup)

*   **Problem:** Feature tests (`Tests\Feature\Admin\AdminTest`, `Tests\Feature\Api\TodoTest`) fail with `QueryException` because the test database (`database/database.sqlite`) schema is not created or reset properly.
*   **Solution:** Use the `Illuminate\Foundation\Testing\RefreshDatabase` trait in the feature test classes. This trait automatically handles migrating the database for tests.
*   **Implementation:**
    *   Add `use Illuminate\Foundation\Testing\RefreshDatabase;` to the top of the test files.
    *   Add `use RefreshDatabase;` inside the test classes.
*   **Target Files:**
    *   `tests/Feature/Admin/AdminTest.php`
    *   `tests/Feature/Api/TodoTest.php`

## 2. Analyze Remaining Test Failures

*   **Problem:** After fixing the database setup, other failures might persist due to incorrect test logic, missing test data (factories/seeders), authentication issues, or mismatched API/route expectations.
*   **Solution:** Run the tests again after applying `RefreshDatabase`. Analyze each failure in detail.
    *   Check test assertions.
    *   Ensure necessary data is created using model factories (`database/factories`).
    *   Verify authenticated users are correctly simulated (`$this->actingAs(...)`).
    *   Compare test requests with route definitions in `routes/api.php` and `routes/web.php`.
*   **Implementation:** Requires detailed analysis of the test output after step 1.

## 3. Review API Implementation (Based on Tests)

*   **Problem:** The API tests (`Tests\Feature\Api\TodoTest`) cover basic CRUD, filtering, sorting, and pagination. Failures here might indicate issues in the corresponding controllers or models.
*   **Solution:** Once tests are less noisy, examine the code paths triggered by the failing API tests.
*   **Implementation:** Debug specific controller actions and model interactions related to failing API tests.

## 4. Review Admin Feature Implementation (Based on Tests)

*   **Problem:** The Admin tests (`Tests\Feature\Admin\AdminTest`) cover user and todo management within an admin context. Failures might point to issues in admin controllers, request validation, or authorization logic.
*   **Solution:** Examine the code paths triggered by failing Admin tests.
*   **Implementation:** Debug specific admin controller actions, form request validation, and policies/middleware related to failing admin tests. 
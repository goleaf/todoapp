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
*   **Refine UI/UX:** Further polish the Tailwind design, add more components for consistency, and potentially integrate a dedicated icon library via NPM (e.g., Heroicons).
*   **Frontend Interaction:** Enhance frontend JavaScript for dynamic behavior (e.g., Alpine.js for modals, interactive elements).
*   **API Documentation:** Create detailed API documentation (e.g., using OpenAPI/Swagger).
*   **Unit Tests:** Add unit tests for new/refactored components, resources, and requests.
*   **Admin CRUD Views:** Although index views are styled, the specific create/edit/show views within `resources/views/admin/todos` and `resources/views/admin/users` might need further refinement or creation if they don't fully exist yet.
*   **Further Enhance i18n:** Add more language translations for all application messages and UI elements.
*   **Continue Feature Development.**

## Potential Future Improvements

*   Real-time updates (e.g., WebSockets)
*   Advanced user roles and permissions
*   Full-text search for todos
*   User profiles and settings
*   Notifications
*   Deployment setup

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
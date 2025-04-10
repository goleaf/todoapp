# Project TODOs and Improvements

This document tracks tasks to improve the project.

## Test Status (Current)

*   **Passing:** All Unit (1) and Feature (31) tests are passing.
*   **Warnings:** Feature tests (Admin, Example, some API) show warnings related to Vite HMR file (`public/hot`), likely ignorable in CI/test environments.

## Completed Steps

*   ✅ Fixed `tests/TestCase.php` for Laravel 11.
*   ✅ Installed Composer and NPM dependencies.
*   ✅ Created `database/database.sqlite` file & switched test env to `:memory:`.
*   ✅ Set `APP_KEY` in `phpunit.xml`.
*   ✅ Built frontend assets (`npm run build`), resolving Vite manifest errors.
*   ✅ Explicitly loaded API routes in `bootstrap/app.php`, resolving 404 errors.
*   ✅ Added `todos()` relationship to `User` model.
*   ✅ Adjusted API validation rules (`TodoRequest`).
*   ✅ Refactored `TodoFactory`, `TodoRequest`, `TodoTest` to use Enums consistently.
*   ✅ Added basic i18n setup (`lang/es/messages.php`).
*   ✅ Corrected various test assertions (auth status, Enum usage, pagination structure, sorting order).
*   ✅ Resolved database isolation issue (cause unclear, possibly fixed during Enum refactoring).
*   ✅ Enhanced Category API with dedicated Form Request class for improved validation.
*   ✅ Added API Resources for standardized JSON formatting.
*   ✅ Implemented multilingual support for 8 languages (en, es, ru, lt, fr, de, it, ja, zh).
*   ✅ Added translations for category-related messages and UI elements.
*   ✅ Created TodoResource and UserResource for standardized API responses.
*   ✅ Added TodoCollection and CategoryCollection for paginated responses.
*   ✅ Implemented Auth-related translation files and request classes.
*   ✅ Enhanced TodoRequest with better validation messages.
*   ✅ Implemented proper Auth controller with registration, login and logout endpoints.

## Next Steps

*   **Address Warnings:** Optionally, investigate and silence the `file_get_contents(/public/hot)` warnings.
*   **Continue Feature Development.**
*   **Further Enhance i18n:** Add more language translations for all application messages.
*   **Add API Documentation:** Create detailed API documentation with examples.
*   **Implement Unit Tests:** Add unit tests for the new resources and requests.
*   **Update the Frontend:** Update the frontend to use the new API responses.

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
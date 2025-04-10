# Project TODOs and Improvements

This document tracks tasks to improve the project, starting with fixing the automated tests.

## Test Status (Current)

*   **Passing:** Unit tests (1), some Feature/API tests related to basic auth/validation.
*   **Warnings:** Feature tests (Admin, Example) show warnings related to Vite HMR file (`public/hot`), likely ignorable in CI/test environments.
*   **Failing (6):** `tests/Feature/Api/TodoTest.php` tests related to listing/filtering/sorting/pagination (`test_todos_can_be_listed_by_authenticated_user`, `test_todos_can_be_filtered_by_status`, `test_todos_can_be_filtered_by_priority`, `test_todos_can_be_filtered_by_due_date`, `test_index_returns_paginated_results`, `test_index_can_sort_todos_by_priority`).
    *   **Root Cause:** These tests consistently receive 13 items from the API instead of the expected count (e.g., 3, 2, 1). This happens despite using `RefreshDatabase`, switching to `:memory:` SQLite, ensuring query scoping (`where('user_id', ...)`), and disabling automatic seeding. The `RefreshDatabase` trait's isolation mechanism appears ineffective in this environment, causing data leakage between tests.

## Completed Steps

*   ✅ Fixed `tests/TestCase.php` for Laravel 11.
*   ✅ Installed Composer and NPM dependencies.
*   ✅ Created `database/database.sqlite` file (though now using `:memory:`).
*   ✅ Set `APP_KEY` in `phpunit.xml`.
*   ✅ Built frontend assets (`npm run build`), resolving Vite manifest errors.
*   ✅ Explicitly loaded API routes in `bootstrap/app.php`, resolving 404 errors.
*   ✅ Added `todos()` relationship to `User` model, resolving `BadMethodCallException`.
*   ✅ Adjusted API validation rules (`TodoRequest`) and test assertions for auth/validation cases.
*   ✅ Disabled automatic seeding via `seed()` override in `TodoTest.php` (did not resolve count issue).
*   ✅ Switched to `:memory:` SQLite database in `phpunit.xml` (did not resolve count issue).
*   ✅ Attempted various query scoping methods in `TodoController@index` (did not resolve count issue).

## Next Steps (Debugging Database Isolation)

*   **Investigate `RefreshDatabase` Failure:** The core problem is the lack of test isolation. Potential next steps:
    *   **Simplify:** Remove `RefreshDatabase` and manage migrations/cleanup manually in `setUp`/`tearDown` to pinpoint the failure point.
    *   **Dump SQL/Data:** Add debugging (`dd(...)`) in `TodoController@index` during a test run to inspect the executed query, bindings, auth state, and data *before* pagination.
    *   **Check Observers/Listeners:** Look for any model observers or event listeners that might interfere with test data.
    *   **Review Environment:** Double-check server environment, PHPUnit configuration, and potential interactions specific to this setup.
*   **Fix Sorting:** Once the count issue is resolved, re-verify and fix the priority sorting logic in `TodoController@index` (`test_index_can_sort_todos_by_priority`).
*   **Address Warnings:** Optionally, investigate and silence the `file_get_contents(/public/hot)` warnings in Admin/Example tests if desired (e.g., by mocking Vite facade in tests).

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
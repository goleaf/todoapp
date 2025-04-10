<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use \Illuminate\Foundation\Testing\Concerns\CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();
        Artisan::call('migrate');
    }
}

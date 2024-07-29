<?php

namespace Tests\Feature\Services;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

#php artisan test --filter=UserControllerTest
class UserControllerTest extends TestCase
{
    use RefreshDatabase;
}

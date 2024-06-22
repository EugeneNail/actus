<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\HasValidationAssertions;



class AuthorizedTestCase extends TestCase
{
    use RefreshDatabase, HasValidationAssertions;

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->count(1)->create();
        $this->actingAs(User::first());
    }
}

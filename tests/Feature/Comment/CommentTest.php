<?php

namespace Tests\Feature\Comment;

use Dipnet\Business;
use Dipnet\Company;
use Dipnet\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_comment_a_business()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create([
            'name' => "John Doe's company"
        ]);

        $business = factory(Business::class)->create([
            'name' => "John Doe's business",
            'company_id' => $company->id
        ]);

        $user = factory(User::class)->create([
            'username' => 'John Doe',
            'email' => 'johndoe@example.com',
            'company_id' => $company->id
        ]);
        $this->signIn($user);

        $this->assertCount(0, $business->comments);

        $this->postJson(route('comments.store', $business->id), [
            'body' => 'Some people have an ability to write placeholder text... It\'s an art you\'re basically born with. You either have it or you don\'t.'
        ])->assertStatus(200);

        $this->assertCount(1, $business->fresh()->comments);
    }

    /** @test */
    function guests_cannot_comment_on_businesses()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create([
            'name' => "John Doe's company"
        ]);

        $business = factory(Business::class)->create([
            'name' => "John Doe's business",
            'company_id' => $company->id
        ]);

        $this->assertCount(0, $business->comments);

        $this->postJson(route('comments.store', $business->id), [
            'body' => 'Some people have an ability to write placeholder text... It\'s an art you\'re basically born with. You either have it or you don\'t.'
        ])->assertStatus(401);

        $this->assertCount(0, $business->fresh()->comments);
    }

    /** @test */
    function users_cannot_comment_on_businesses_their_company_is_not_associated_with()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create([
            'name' => "John Doe's company"
        ]);

        $business = factory(Business::class)->create([
            'name' => "John Doe's business",
            'company_id' => $company->id
        ]);

        $this->assertCount(0, $business->comments);

        $user = factory(User::class)->create([
            'username' => 'James',
            'email' => 'james@example.com'
        ]);
        $this->signIn($user);

        $this->postJson(route('comments.store', $business->id), [
            'body' => 'Some people have an ability to write placeholder text... It\'s an art you\'re basically born with. You either have it or you don\'t.'
        ])->assertStatus(403);

        $this->assertCount(0, $business->fresh()->comments);
    }
}

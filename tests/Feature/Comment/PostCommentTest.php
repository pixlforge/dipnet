<?php

namespace Tests\Feature\Comment;

use App\User;
use App\Comment;
use App\Company;
use App\Business;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_see_comments_made_on_their_businesses()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $comment = factory(Comment::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'business_id' => $business->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('businesses.show', $business));
        $response->assertOk();
        $response->assertViewIs('businesses.show');
        $response->assertViewHas('comments', function ($comments) {
            return $comments->first()->body === 'Lorem ipsum dolor sit amet.';
        });
    }

    /** @test */
    public function guests_cannot_see_business_comments()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $comment = factory(Comment::class)->create([
            'body' => 'Lorem ipsum dolor sit amet.',
            'business_id' => $business->id,
        ]);
            
        $this->assertGuest();

        $response = $this->get(route('businesses.show', $business));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function users_can_comment_on_their_own_businesses()
    {
        $this->withoutExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Comment::all());

        $response = $this->postJson(route('comments.store', $business), [
            'body' => 'Lorem ipsum dolor sit amet.',
        ]);
        $response->assertOk();
        $this->assertCount(1, Comment::all());

        $comment = Comment::first();
        $this->assertEquals('Lorem ipsum dolor sit amet.', $comment->body);
        $this->assertEquals($business->id, $comment->business_id);
        $this->assertEquals($user->id, $comment->user_id);
    }

    /** @test */
    public function users_cannot_comment_on_other_users_businesses()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, Comment::all());

        $response = $this->postJson(route('comments.store', $business), [
            'body' => 'Lorem ipsum dolor sit amet.',
        ]);
        $response->assertForbidden();
        $this->assertCount(0, Comment::all());
    }

    /** @test */
    public function guests_cannot_comment_on_businesses()
    {
        $this->withExceptionHandling();

        $company = factory(Company::class)->create();
        $business = factory(Business::class)->create(['company_id' => $company->id]);
        $this->assertGuest();

        $this->assertCount(0, Comment::all());

        $response = $this->postJson(route('comments.store', $business), [
            'body' => 'Lorem ipsum dolor sit amet.',
        ]);
        $response->assertStatus(401);
        $this->assertCount(0, Comment::all());
    }
}

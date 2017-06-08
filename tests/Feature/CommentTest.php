<?php

namespace Tests\Feature;

use App\BusinessComment;
use App\DeliveryComment;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A business comment can be inserted into the database
     *
     * @test
     */
    function a_business_comment_can_be_inserted_into_the_database()
    {
        $businessComment = factory('App\BusinessComment')->create();
        $this->assertDatabaseHas('business_comments', ['content' => $businessComment->content]);
    }

    /**
     * A delivery comment can be inserted into the database
     *
     * @test
     */
    function a_delivery_comment_can_be_inserted_into_the_database()
    {
        $deliveryComment = factory('App\DeliveryComment')->create();
        $this->assertDatabaseHas('delivery_comments', ['content' => $deliveryComment->content]);
    }
}

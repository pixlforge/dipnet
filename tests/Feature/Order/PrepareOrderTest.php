<?php

namespace Tests\Feature\Order;

use App\User;
use App\Order;
use App\Company;
use App\Contact;
use App\Business;
use App\Delivery;
use App\Document;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminOrderCompleteNotification;
use App\Mail\CustomerOrderCompleteConfirmation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrepareOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_associated_with_a_company_can_prepare_and_complete_orders()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        // Create a company associated with a default business
        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create();

        // User is logged in
        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // User creates a new order
        $this->assertCount(0, Order::all());
        $response = $this->get(route('orders.create.start'));
        $response->assertRedirect(route('orders.create.end', 'ODJEGDNM'));
        $this->assertCount(1, Order::all());

        $order = Order::find(1);
        $this->assertEquals($business->id, $order->business_id);
        $this->assertEquals($company->id, $order->company_id);
        
        // User adds a delivery to the order
        $this->assertCount(0, $order->deliveries);
        $deliveries = [
            $deliveryA = factory(Delivery::class)->create([
                'order_id' => $order->id,
                'contact_id' => $contact->id,
                'to_deliver_at' => now()->addWeeks(2),
            ]),
        ];
        $order = $order->fresh();
        $this->assertCount(1, $order->deliveries);

        // User adds documents to the delivery
        $documents = [
            factory(Document::class)->create(['delivery_id' => $deliveryA->id]),
            factory(Document::class)->create(['delivery_id' => $deliveryA->id]),
            factory(Document::class)->create(['delivery_id' => $deliveryA->id]),
        ];
        $deliveryA->documents = $documents;

        // User completes the order
        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$deliveries],
        ]);

        // dd($response->content());
        $response->assertOk();
        $this->assertEquals('envoyée', $order->fresh()->status);
        Mail::assertQueued(CustomerOrderCompleteConfirmation::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
        Mail::assertQueued(AdminOrderCompleteNotification::class, function ($mail) {
            return $mail->hasTo('admin@dipnet.ch');
        });
    }

    /** @test */
    public function guests_cannot_complete_orders()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $this->assertGuest();

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => null,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertStatus(401);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_status_is_missing()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => '',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('status');
        $this->assertContains('Le statut de la commande est requis.', $response->content());
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_status_is_not_incomplete()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'envoyée',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('status');
        $this->assertContains('Le statut de la commande est invalide.', $response->content());
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_is_not_associated_with_a_business()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => null,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('business_id');
        $errors = json_decode($response->content());
        $errors = $errors->errors->business_id;
        $this->assertContains('La commande doit être associée à une affaire.', $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_business_does_not_exist()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => 999,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('business_id');
        $errors = json_decode($response->content());
        $errors = $errors->errors->business_id;
        $this->assertContains("Aucune affaire portant cette référence n'existe.", $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_is_not_associated_with_a_company_when_also_not_associated_with_a_user()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => null,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('company_id');
        $errors = json_decode($response->content());
        $errorsCompany = $errors->errors->company_id;
        $errorsUser = $errors->errors->user_id;
        $this->assertContains('La commande doit être associée à une société ou à un utilisateur.', $errorsCompany);
        $this->assertContains('La commande doit être associée à un utilisateur ou à une société.', $errorsUser);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_company_does_not_exist()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => 999,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('company_id');
        $errors = json_decode($response->content());
        $errors = $errors->errors->company_id;
        $this->assertContains("Aucune société portant cette référence n'existe.", $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_is_not_associated_with_a_user_when_also_not_associated_with_a_company()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['user_id' => 1]);
        $contact = factory(Contact::class)->create(['user_id' => 1]);
        $order = factory(Order::class)->create(['user_id' => 1]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => null,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('user_id');
        $errors = json_decode($response->content());
        $errorsCompany = $errors->errors->company_id;
        $errorsUser = $errors->errors->user_id;
        $this->assertContains('La commande doit être associée à une société ou à un utilisateur.', $errorsCompany);
        $this->assertContains('La commande doit être associée à un utilisateur ou à une société.', $errorsUser);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_user_does_not_exist()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['user_id' => 1]);
        $contact = factory(Contact::class)->create(['user_id' => 1]);
        $order = factory(Order::class)->create(['user_id' => 1]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user', 'solo')->create();
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => 999,
            'company_id' => null,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('user_id');
        $errors = json_decode($response->content());
        $errors = $errors->errors->user_id;
        $this->assertContains("L'utilisateur spécifié n'existe pas.", $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_is_not_associated_with_a_contact()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $delivery = factory(Delivery::class)->create(['order_id' => $order->id]);
        $document = factory(Document::class)->create(['delivery_id' => $delivery->id]);
        $delivery->documents = $document;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => null,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$delivery],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('contact_id');
        $errors = json_decode($response->content());
        $errors = $errors->errors->contact_id;
        $this->assertContains('La commande doit être associée à un contact de facturation.', $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_order_does_not_have_at_least_one_delivery()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, $order->deliveries);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => null,
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries');
        $errors = json_decode($response->content());
        $errors = $errors->errors->deliveries;
        $this->assertContains('Les livraisons relatives à la commande sont requises.', $errors);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_do_not_exist()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(0, $order->deliveries);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [
                factory(Delivery::class)->make(['id' => 997]),
                factory(Delivery::class)->make(['id' => 998]),
                factory(Delivery::class)->make(['id' => 999]),
            ],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.id');
        $response->assertJsonValidationErrors('deliveries.1.id');
        $response->assertJsonValidationErrors('deliveries.2.id');
        $errors = json_decode($response->content());
        $errors = collect($errors->errors);
        $this->assertContains("Aucune livraison portant cette référence n'existe.", $errors['deliveries.0.id']);
        $this->assertContains("Aucune livraison portant cette référence n'existe.", $errors['deliveries.1.id']);
        $this->assertContains("Aucune livraison portant cette référence n'existe.", $errors['deliveries.2.id']);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_are_not_associated_with_any_delivery_contact()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $deliveries = [
            $deliveryA = factory(Delivery::class)->create([
                'order_id' => $order->id,
                'contact_id' => null,
                'to_deliver_at' => now()->addWeeks(2),
            ]),
            $deliveryB = factory(Delivery::class)->create([
                'order_id' => $order->id,
                'contact_id' => null,
                'to_deliver_at' => now()->addWeeks(2),
            ]),
            $deliveryC = factory(Delivery::class)->create([
                'order_id' => $order->id,
                'contact_id' => null,
                'to_deliver_at' => now()->addWeeks(2),
            ]),
        ];
        $documentA = factory(Document::class)->create(['delivery_id' => $deliveryA->id]);
        $documentB = factory(Document::class)->create(['delivery_id' => $deliveryB->id]);
        $documentC = factory(Document::class)->create(['delivery_id' => $deliveryC->id]);
        $deliveryA->documents = $documentA;
        $deliveryB->documents = $documentB;
        $deliveryC->documents = $documentC;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(3, $order->deliveries);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$deliveries],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.0.contact_id');
        $errors = json_decode($response->content());
        $errors = collect($errors->errors);
        $this->assertContains("Aucun contact de livraison n'est spécifié pour la livraison.", $errors['deliveries.0.0.contact_id']);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_do_not_contain_a_delivery_date()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);
        $deliveries = [
            $deliveryA = factory(Delivery::class)->create([
                'order_id' => $order->id,
                'contact_id' => $contact->id,
                'to_deliver_at' => null,
            ]),
        ];
        $documentA = factory(Document::class)->create(['delivery_id' => $deliveryA->id]);
        $deliveryA->documents = $documentA;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $this->assertCount(1, $order->deliveries);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => [$deliveries],
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.0.to_deliver_at');
        $errors = json_decode($response->content());
        $errors = collect($errors->errors);
        $this->assertContains('Une date de livraison est requise.', $errors['deliveries.0.0.to_deliver_at']);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_do_not_have_associated_documents()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);

        $deliveries = [
           [
               $deliveryA = factory(Delivery::class)->create([
                   'contact_id' => $contact->id,
                   'to_deliver_at' => now()->addWeeks(2),
               ]),
           ],
        ];
        $this->assertCount(0, $deliveryA->documents);

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => $deliveries,
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.0.documents');
        $errors = json_decode($response->content());
        $errors = collect($errors->errors);
        $this->assertContains('Les documents relatifs à la livraison sont requis.', $errors['deliveries.0.0.documents']);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_documents_do_not_exist()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);

        $deliveries = [
            [
                $deliveryA = factory(Delivery::class)->create([
                    'order_id' => $order->id,
                    'contact_id' => $contact->id,
                    'to_deliver_at' => now()->addWeeks(2),
                ]),
            ],
        ];
        $documents = [
            factory(Document::class)->make(['id' => 997, 'delivery_id' => $deliveryA->id]),
            factory(Document::class)->make(['id' => 998, 'delivery_id' => $deliveryA->id]),
            factory(Document::class)->make(['id' => 999, 'delivery_id' => $deliveryA->id]),
        ];
        $deliveryA->documents = $documents;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => $deliveries,
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.0.documents.0.id');
        $response->assertJsonValidationErrors('deliveries.0.0.documents.1.id');
        $response->assertJsonValidationErrors('deliveries.0.0.documents.2.id');
        $this->assertEquals('incomplète', $order->fresh()->status);
    }

    /** @test */
    public function complete_order_validation_fails_if_deliveries_documents_are_not_associated_with_a_print_article()
    {
        $this->withExceptionHandling();

        $business = factory(Business::class)->create(['company_id' => 1]);
        $company = factory(Company::class)->create(['business_id' => $business->id]);
        $contact = factory(Contact::class)->create(['company_id' => $company->id]);
        $order = factory(Order::class)->create(['company_id' => $company->id]);

        $deliveries = [
            [
                $deliveryA = factory(Delivery::class)->create([
                    'order_id' => $order->id,
                    'contact_id' => $contact->id,
                    'to_deliver_at' => now()->addWeeks(2),
                ]),
            ],
        ];
        $documents = [
            factory(Document::class)->create([
                'delivery_id' => $deliveryA->id,
                'article_id' => null,
            ]),
            factory(Document::class)->create([
                'delivery_id' => $deliveryA->id,
                'article_id' => null,
            ]),
            factory(Document::class)->create([
                'delivery_id' => $deliveryA->id,
                'article_id' => null,
            ]),
        ];
        $deliveryA->documents = $documents;

        $user = factory(User::class)->states('user')->create(['company_id' => $company->id]);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        $response = $this->patchJson(route('orders.complete.update', $order), [
            'reference' => 'MBXBXWWX',
            'status' => 'incomplète',
            'business_id' => $business->id,
            'contact_id' => $contact->id,
            'user_id' => null,
            'company_id' => $company->id,
            'deliveries' => $deliveries,
        ]);

        // dd($response->content());
        $response->assertJsonValidationErrors('deliveries.0.0.documents.0.article_id');
        $response->assertJsonValidationErrors('deliveries.0.0.documents.1.article_id');
        $response->assertJsonValidationErrors('deliveries.0.0.documents.2.article_id');
        $errors = json_decode($response->content());
        $errors = collect($errors->errors);
        $this->assertContains("Une option d'impression est requise.", $errors['deliveries.0.0.documents.0.article_id']);
        $this->assertContains("Une option d'impression est requise.", $errors['deliveries.0.0.documents.1.article_id']);
        $this->assertContains("Une option d'impression est requise.", $errors['deliveries.0.0.documents.2.article_id']);
        $this->assertEquals('incomplète', $order->fresh()->status);
    }
}

<?php

namespace App\Http\Controllers\Invitations;

use App\Invitation;
use App\Mail\InvitationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\InvitationRequest;
use Illuminate\Validation\Rules\In;

class InvitationsController extends Controller
{
    /**
     * InviteMemberController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('confirm');
    }

    /**
     * @param InvitationRequest $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function store(InvitationRequest $request)
    {
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => Invitation::generateConfirmationToken($request->email),
            'company_id' => auth()->user()->company_id,
            'created_by' => auth()->user()->username
        ]);

        Mail::to($invitation)
            ->queue(new InvitationEmail($invitation));

        if (request()->wantsJson()) {
            return $invitation;
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function confirm(Request $request)
    {
        $invitation = Invitation::where('token', $request->value)->first();

        if (! $invitation) {
            return response("Code invalide", 422);
        }

        return response($invitation, 200);
    }
}
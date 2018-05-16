<?php

namespace App\Http\Controllers\Invitations;

use App\Invitation;
use Illuminate\Http\Request;
use App\Mail\InvitationEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Invitation\InvitationRequest;

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
     * Store a new Invitation.
     *
     * @param InvitationRequest $request
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function store(InvitationRequest $request)
    {
        $invitation = new Invitation;
        $invitation->email = $request->email;
        $invitation->token = Invitation::generateConfirmationToken($request->email);
        $invitation->company_id = auth()->user()->company_id;
        $invitation->created_by = auth()->user()->username;
        $invitation->save();

        Mail::to($invitation)->queue(new InvitationEmail($invitation));

        return response($invitation, 200);
    }

    /**
     * Update an Invitation model and send it again.
     *
     * @param Request $request
     */
    public function update(Request $request)
    {
        $invitation = Invitation::whereEmail($request->email)->first();

        $invitation->update([
            'token' => Invitation::generateConfirmationToken($request->email)
        ]);

        Mail::to($invitation)->queue(new InvitationEmail($invitation));
    }

    /**
     * Confirm an invitation.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function confirm(Request $request)
    {
        $invitation = Invitation::where('token', $request->token)->first();

        if (! $invitation) {
            return response("Code invalide", 422);
        }

        return response($invitation, 200);
    }

    /**
     * Delete an Invitation model.
     *
     * @param Invitation $invitation
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Invitation $invitation)
    {
        $this->authorize('delete', $invitation);

        $invitation->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }
    }
}
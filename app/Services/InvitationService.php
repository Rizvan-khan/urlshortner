<?php

namespace App\Services;

use App\Enums\Role;
use App\Mail\InvitationMail;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class InvitationService
{
    private const EXPIRY_DAYS = 7;

   
    public function inviteClient(User $inviter, string $companyName, string $email): Invitation
    {
        $invitation = DB::transaction(function () use ($inviter, $companyName, $email) {
            $this->ensureNoPendingInvitation($email);

            $company = Company::create(['name' => $companyName, 'email' => $email]);

            return $this->createInvitation($inviter, $company->id, $companyName, $email, Role::Admin);
        });

        Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return $invitation;
    }

    
    public function inviteTeamMember(User $admin, string $name, string $email, Role $role): Invitation
    {
        $invitation = DB::transaction(function () use ($admin, $name, $email, $role) {
            $this->ensureNoPendingInvitation($email);

            return $this->createInvitation($admin, $admin->company_id, $name, $email, $role);
        });

        Mail::to($invitation->email)->send(new InvitationMail($invitation));

        return $invitation;
    }


    public function findPendingOrFail(string $token): Invitation
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        abort_if($invitation->isAccepted() || $invitation->isExpired(), 410, 'This invitation is no longer valid.');

        return $invitation;
    }

   
    public function accept(string $token, string $name, string $password): User
    {
        return DB::transaction(function () use ($token, $name, $password) {
            $invitation = $this->findPendingOrFail($token);

            $user = User::create([
                'name'       => $name,
                'email'      => $invitation->email,
                'password'   => $password, 
                'role'       => $invitation->role,
                'company_id' => $invitation->company_id,
            ]);

            $invitation->update(['accepted_at' => now()]);

            return $user;
        });
    }

    private function createInvitation(User $inviter, int $companyId, string $name, string $email, Role $role): Invitation
    {
        return Invitation::create([
            'company_id' => $companyId,
            'invited_by' => $inviter->id,
            'name'       => $name,
            'email'      => $email,
            'role'       => $role,
            'token'      => Str::random(64),
            'expires_at' => now()->addDays(self::EXPIRY_DAYS),
        ]);
    }

    private function ensureNoPendingInvitation(string $email): void
    {
        $pending = Invitation::where('email', $email)
            ->whereNull('accepted_at')
            ->where('expires_at', '>', now())
            ->exists();

        if ($pending) {
            throw ValidationException::withMessages([
                'email' => 'An invitation is already pending for this email.',
            ]);
        }
    }
}
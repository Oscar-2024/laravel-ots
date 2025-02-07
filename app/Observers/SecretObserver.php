<?php

namespace App\Observers;

use App\Models\Secret;
use App\Services\SecretService;

class SecretObserver
{
    public function creating(Secret $secret): void
    {
        $secret->user_id = SecretService::getUserId();
        $secret->password = SecretService::getPasswordHashFromRequest();
        $secret->expires_at = SecretService::getExpirationFromRequest();
    }

    public function created(Secret $secret): void
    {
        $secret->shareSecret();
    }
}

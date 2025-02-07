<?php

namespace App\Services;

use App\Enums\SecretExpirationOptions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class SecretService
{
    public static function getUserId(): ?int
    {
        return auth()->id();
    }

    public static function getRecipientFromRequest(): ?string
    {
        return auth()->check() ? request('recipient') : null;
    }

    public static function getPasswordHashFromRequest(): ?string
    {
        $password = request('password');

        return $password ? Hash::make($password) : null;
    }

    public static function getExpirationFromRequest(): string
    {
        $expiration = request('expires_at');

        return SecretExpirationOptions::from($expiration)->getExpiration();
    }

    public static function randomContent(): string
    {
        return Str::random(12);
    }
}

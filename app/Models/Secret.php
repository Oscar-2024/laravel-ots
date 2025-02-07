<?php

namespace App\Models;

use App\Enums\SecretExpirationOptions;
use App\Notifications\ShareSecret;
use App\Observers\SecretObserver;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\SecretService;

class Secret extends Model
{
    use HasUuids, MassPrunable;

    const DECRYPTED_SESSION_PREFIX = 'decrypted_secret_';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'content',
        'password',
        'expires_at',
        'recipient',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::observe(SecretObserver::class);
    }

    protected function casts(): array
    {
        return [
            'content' => 'encrypted',
            'recipient' => 'encrypted',
            'expires_at' => 'datetime',
        ];
    }

    public function prunable()
    {
        return static::where('expires_at', '<', now());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function expirationOptions(): array
    {
        return SecretExpirationOptions::getOptions();
    }

    public function sharedLink(): string
    {
        return route('secrets.show', $this->uuid);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isProtectedWithPassword(): bool
    {
        return ! is_null($this->password);
    }

    public function createFlashSession(): void
    {
        session()->flash(self::DECRYPTED_SESSION_PREFIX . $this->uuid);
    }

    public function contentIsVisible(): bool
    {
        if (! $this->isProtectedWithPassword()) {
            return true;
        }

        return session()->exists(self::DECRYPTED_SESSION_PREFIX . $this->uuid);
    }

    public function maskedRecipient(): ?string
    {
        if (is_null($this->recipient)) {
            return null;
        }

        $recipientLength = strlen($this->recipient);
        $mask = Str::mask($this->recipient, '*', 0, 2);

        return Str::mask($mask, '*', $recipientLength - 4, 4);
    }

    /**
     * @throws Exception
     */
    public function validatePassword(string $password): void
    {
        if ($this->isExpired()) {
            throw new Exception('Secret has expired');
        }

        if (! $this->isProtectedWithPassword()) {
            throw new Exception('Secret is not password protected');
        }

        if (! Hash::check($password, $this->password)) {
            throw new Exception('Invalid password');
        }
    }

    public function deleteIfVisible(): void
    {
        if ($this->contentIsVisible()) {
            $this->delete();
        }
    }

    public function shareSecret(): void
    {
        if (! is_null($this->recipient)) {
            (User::make([
                'email' => $this->recipient,
                'name' => 'Laravel One Time Secret',
            ]))->notify(new ShareSecret($this));
        }
    }

    public static function createRandom(): self
    {
        $secret = new self([
            'user_id' => SecretService::getUserId(),
            'content' => SecretService::randomContent(),
            'expires_at' => SecretService::getExpirationFromRequest(),
            'recipient' => SecretService::getRecipientFromRequest(),
            'password' => SecretService::getPasswordHashFromRequest(),
        ]);

        $secret->saveQuietly();

        $secret->shareSecret();

        return $secret;
    }
}

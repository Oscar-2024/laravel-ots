<?php

namespace App\Http\Controllers;

use App\Exceptions\SecretNotValidException;
use App\Http\Requests\SecretRequest;
use App\Models\Secret;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SecretController extends Controller
{
    private string $layout;

    public function __construct()
    {
        $this->layout = auth()->check() ? 'secrets.layouts.app' : 'secrets.layouts.guest';
    }

    public function index(): View
    {
        $secrets = auth()->user()->secrets;

        return view('secrets.index', compact('secrets'));
    }

    public function create(): View
    {
        return view('secrets.create', [
            'layout' => $this->layout,
        ]);
    }

    public function store(SecretRequest $request): RedirectResponse
    {
        $method = match (request('secret'))
        {
            'share' => 'create',
            'random' => 'createRandom',
            default => fn () => abort(404)
        };

        $secret = Secret::$method($request->validated());

        return redirect()->route('secrets.link', [
            'secret' => $secret,
        ]);
    }

    public function showLink(string $uuid): View
    {
        try {
            $secret = $this->checkSecretValidity($uuid);
        } catch (SecretNotValidException $e) {
            return $this->expired($e->getMessage());
        }

        return view('secrets.show_link', [
            'layout' => $this->layout,
            'secret' => $secret,
        ]);
    }

    public function show(string $uuid): View
    {
        try {
            $secret = $this->checkSecretValidity($uuid);
        } catch (SecretNotValidException $e) {
            return $this->expired($e->getMessage());
        }

        $clone = clone $secret;
        $secret->deleteIfVisible();

        return view('secrets.show', [
            'layout' => $this->layout,
            'secret' => $clone,
        ]);
    }

    public function decrypt(Secret $secret): RedirectResponse
    {
        try {
            $secret->validatePassword(request('password'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'password' => $e->getMessage(),
            ]);
        }

        $secret->createFlashSession();

        return back();
    }

    public function destroy(Secret $secret): RedirectResponse
    {
        $secret->delete();

        return back();
    }

    /**
     * @throws SecretNotValidException
     */
    private function checkSecretValidity(string $uuid): Secret
    {
        $secret = Secret::find($uuid);

        if (! $secret || $secret->isExpired())
        {
            $secret?->delete();
            throw new SecretNotValidException('El secreto ha expirado o no existe.');
        }

        return $secret;
    }

    private function expired(string $message): View
    {
        return view('secrets.expired', [
            'layout' => $this->layout,
            'message' => $message,
        ]);
    }
}

<?php

namespace App\Http\Requests\Auth;

use App\Models\IpAccount;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // 1️⃣ Try users table (admin/staff)
        if (Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // 2️⃣ Try ip_accounts table (applicants - lahat dito ay approved na)
        $applicant = IpAccount::where('email', $this->input('email'))->first();

        if ($applicant && Hash::check($this->input('password'), $applicant->password)) {
            Auth::guard('applicant')->login($applicant, $this->boolean('remember'));
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // 3️⃣ If both fail
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}

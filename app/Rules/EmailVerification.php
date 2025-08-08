<?php

namespace App\Rules;

use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\Rule;

class EmailVerification implements Rule
{
    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        $response = Http::withoutVerifying()->get(env('EMAIL_VERIFIER_URL'), [
            'email' => $value,
            'key' => env('EMAIL_VERIFIER_KEY')
        ]);

        if ($response->json()['status'] === 'invalid') {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'El correo electrónico proporcionado es inválido.';
    }
}

<?php

namespace App\Helpers;

class TransformerSanitizer
{
    public static function sanitize(string $code): string
    {
        // Debe empezar con return function($response) { ... };
        $pattern = '/^\s*return\s+function\s*\(\s*\$response\s*\)\s*{[\s\S]*}\s*;?\s*$/';

        if (!preg_match($pattern, $code)) {
            throw new \Exception("El transformer debe ser un return function(\$response) { ... }; válido.");
        }

        // Bloqueamos funciones peligrosas
        $blacklist = [
            'system',
            'exec',
            'shell_exec',
            'passthru',
            'proc_open',
            'eval',
            'base64_decode',
            'file_put_contents',
            'unlink',
        ];

        foreach ($blacklist as $bad) {
            if (stripos($code, $bad) !== false) {
                throw new \Exception("El transformer contiene funciones prohibidas: {$bad}");
            }
        }

        return $code;
    }
}

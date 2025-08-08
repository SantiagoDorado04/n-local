<?php
if (!function_exists('checkEmail')) {
    function checkEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
            return 'Formato de correo electrónico no válido';

        $email_domain = preg_replace('/^[^@]++@/', '', $email);

        if (in_array($email_domain, get_banned_domains()))
            return 'Banned domain ' . $email_domain;

        if (!checkdnsrr($email_domain, 'MX'))
            return 'DNS MX no encontrado para el dominio ' . $email_domain;

        return TRUE;
    }
}

if (!function_exists('get_banned_domains')) {
    function get_banned_domains()
    {
        $file = 'banned_domains.json';

        if (!file_exists($file) || filemtime($file) < strtotime('-1 week')) {
            $banned_domains = file_get_contents("https://rawgit.com/ivolo/disposable-email-domains/master/index.json");
            if ($banned_domains !== FALSE)
                file_put_contents($file, $banned_domains, LOCK_EX);
        } else {
            $banned_domains = file_get_contents($file);
        }

        return json_decode($banned_domains);
    }
}

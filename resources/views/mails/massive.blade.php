<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <img src="{!! url('update-read-massive?contact=' . $contact) !!} " style="display:none">

    {{ $contact }}

    @php
        $stringHtml = $content;
        $contactId = $contact;

        $stringHtmlModificado = preg_replace_callback(
            '/<a href="([^"]+)">([^<]+)<\/a>/',
            function ($matches)use($contactId) {
                $urlOriginal = $matches[1];
                $textoEnlace = $matches[2];
                $urlRedireccion = route('update-click', ['url' => urlencode($urlOriginal), 'contact'=>$contactId]);
                return "<a href=\"$urlRedireccion\">$textoEnlace</a>";
            },
            $stringHtml
        );
    @endphp

    {!! $stringHtmlModificado !!}
</body>
</html>

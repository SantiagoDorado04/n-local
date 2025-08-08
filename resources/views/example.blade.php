<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php
        $stringHtml = $content;

        $stringHtmlModificado = preg_replace_callback(
            '/<a href="([^"]+)">([^<]+)<\/a>/',
            function ($matches) {
                $urlOriginal = $matches[1];
                $textoEnlace = $matches[2];
                $urlRedireccion = route('update-click', ['url' => urlencode($urlOriginal)]);
                return "<a href=\"$urlRedireccion\">$textoEnlace</a>";
            },
            $stringHtml
        );
    @endphp

    {!! $stringHtmlModificado !!}
</body>
</html>

<p><a href="https://primer.parquesoft.co/update-click?url=https%253=
    A%252F%252Fprimer.parquesoft.co%252F&contact=58">Click aqui</a>
    <a href="https://primer.parquesoft.co/admin/mailing-massive" target="_self">Mailing Masivo</a>
    <a href="https://primer.parquesoft.co/admin/mailing-individual" target="_self">Mailing Individual</a></p>
<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>{{ $subject }}</title>
    <meta name="description" content="{{ $subject }}">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body style="margin: 0px; background-color: #f2f3f8;">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="text-align:center;">
                            <a href="https://elnido.parquesoft.co/" title="logo" target="_blank">
                                <img src="{{ asset('assets/img/logo-nido.png') }}" width="15%"
                                    style="margin-bottom: 5px; border-radius:10px;">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="background:#fff; border-radius:3px; text-align:center;box-shadow:0 6px 18px rgba(0,0,0,.06);">
                                <tr>
                                    <td style="padding:0 35px;">
                                        <h1
                                            style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">
                                            {{ $subject }}
                                        </h1>
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:29px 0;">
                                            {{ $content }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353);">
                                <strong><a href="http://elnido.parquesoft.co">elnido.parquesoft.co</a></strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

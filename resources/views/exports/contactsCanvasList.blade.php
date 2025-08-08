<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <table class="table table-bordered text-center" style="border: 1px solid black;">
        <thead>
            <tr>
                <th colspan="7" style="border: 1px solid black; background-color: #28a745; color: white; font-weight: bold; text-align: center;">
                    Listado de Contactos que entrgaron el lienzo {{ $form->name }}:
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Nit/Cédula</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Nombre</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Correo Electrónico</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Teléfono</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Whatsapp</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Persona de Contacto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->nit }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->name }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->email }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->phone }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->whatsapp }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $contact->contact_person_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

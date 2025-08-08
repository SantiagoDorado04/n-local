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
                <th colspan="11" rowspan="2" style="border: 1px solid black; background-color: #28a745; color: white; font-weight: bold; text-align: center;">
                    Listado de Postulados Etapa {{ $stage->name }}
                </th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="8" style="border: 1px solid black; background-color: #f7ad2c; color: white; font-weight: bold; text-align: center;">
                    Información de Postulados
                </th>
                <th colspan="{{ count($formStage->questions) }}" style="border: 1px solid black; background-color: #4257e1; color: white; font-weight: bold; text-align: center;">
                    Respuestas de Formulario
                </th>
            </tr>
            <tr>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Estado</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Nit/Cédula</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Nombre de la Empresa</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Correo Electrónico</th>
                <th style="border: 1px solid black; background-color:#dca84e; color: black; font-weight: bold; text-align: center;">Teléfono</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Whatsapp</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Website</th>
                <th style="border: 1px solid black; background-color: #dca84e; color: black; font-weight: bold; text-align: center;">Persona de contacto</th>
                @foreach ($formStage->questions as $question)
                    <th style="border: 1px solid black; background-color: #7d89db; color: black; font-weight: bold; text-align: center;">{{ $question->text }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($postulates as $postulate)
                <tr>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->approved ? 'Aprobado' : 'No Aprobado' }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->nit }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->name }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->email }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->phone }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->whatsapp }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->website }}</td>
                    <td style="border: 1px solid black; text-align: center;">{{ $postulate->contact->contact_person_name }}</td>


                    @foreach ($formStage->questions as $question)
                    @php
                        $found = false;
                    @endphp
                    @foreach ($answers as $answer)
                        @if ($answer->contact_id == $postulate->contact_id && $answer->question_id == $question->id)
                            <td style="border: 1px solid black; text-align: center;">{{ $answer->answer }}</td>
                            @php
                                $found = true;
                                break;
                            @endphp
                        @endif
                    @endforeach
                    @if (!$found)
                        <td style="border: 1px solid black; text-align: center;"></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
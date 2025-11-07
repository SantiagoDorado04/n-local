<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resultado Test - {{ $processTest->name }}</title>
    <style>
        /* --- Configuración General --- */
        @page {
            margin: 120px 40px 60px 40px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        header {
            position: fixed;
            top: -90px;
            left: 0px;
            right: 0px;
            height: 80px;
            width: 100%;
            border-bottom: 2px solid #005A9C;
            padding-bottom: 10px;
        }

        header .logo {
            float: left;
            width: 100px;
            height: auto;
            max-height: 70px;
        }

        header .branding {
            float: right;
            text-align: right;
            font-size: 11px;
            color: #555;
            margin-top: 10px;
        }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 10px;
            text-align: center;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        .main-title {
            color: #005A9C;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .summary-box {
            background-color: #f0f8ff;
            border: 1px solid #bce8f1;
            border-left: 5px solid #005A9C;
            border-radius: 8px;
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 80%;
        }

        .summary-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        .chart-container {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        .chart-container img {
            max-width: 100%;
            height: auto;
        }

        .category-block {
            margin-bottom: 40px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #ffffff;
        }

        .category-header h2 {
            color: #005A9C;
            margin-top: 0;
            margin-bottom: 5px;
            border-bottom: 2px solid #005A9C;
            padding-bottom: 10px;
        }

        .category-header .appreciation {
            background-color: #e7f3fe;
            padding: 10px;
            border-radius: 5px;
            font-size: 15px;
            margin-top: 10px;
        }

        .category-content {
            margin-top: 20px;
        }

        .layout-table {
            width: 100%;
            border-collapse: collapse;
        }

        .layout-table td {
            vertical-align: top;
            padding: 0;
        }

        .left-col {
            width: 45%;
            padding-right: 20px;
        }

        .right-col {
            width: 55%;
        }

        .subcategory-list .item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .subcategory-list .item:last-child {
            border-bottom: none;
        }

        .subcategory-list .percentage {
            font-weight: bold;
            font-size: 16px;
            color: #005A9C;
        }

        .subcategory-appreciation {
            margin-top: 8px;
            padding: 6px;
            background-color: #f5f5f5;
            border-left: 3px solid #ccc;
            font-size: 10px;
            color: #444;
        }

        .answers-section {
            margin-top: 40px;
        }

        .answers-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .answers-table th,
        .answers-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .answers-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $logoBase64 ?? setting('admin.loader') }}" alt="Logo" class="logo">
        <div class="branding">
            <strong>Nido de Saberes</strong><br>
            ParqueSoft Nariño<br>
            Reporte de Resultados
        </div>
    </header>

    <footer>
        Generado el {{ date('d/m/Y H:i:s') }} para el test: {{ $processTest->name }}
    </footer>

    <main>
        <h1 class="main-title">{{ $processTest->name }}</h1>
        <h2 style="text-align:center; color:#333;">
            Empresa: {{ $contact->name ?? 'No disponible' }}
        </h2>
        <h3>{!! nl2br(e($processTest->description)) !!}</h3>

        <div class="summary-box text-center">
            <p>
                <strong>Puntaje Total:</strong> {{ $totalPoints }} / {{ $totalMaxPoints }}
                (<strong>{{ $totalMaxPoints > 0 ? number_format(($totalPoints / $totalMaxPoints) * 100, 2) : 0 }}%</strong>)
            </p>
            <h3>
                Apreciación General:
                <strong>{{ $generalAppreciation->title ?? 'Sin resultado' }}</strong>
            </h3>

            @if ($generalAppreciation && $generalAppreciation->appreciation)
                <p style="font-size: 15px; color: #555; margin-top: 5px;">
                    {!! nl2br(e($generalAppreciation->appreciation)) !!}
                </p>
            @endif
        </div>

        @if (isset($generalChartBase64) && $generalChartBase64)
            <div class="chart-container avoid-break">
                <h2 style="color: #333;">Distribución de Puntuación General</h2>
                <img src="{{ $generalChartBase64 }}" alt="Gráfico General">
            </div>
        @endif

        <div class="page-break"></div>

        @foreach ($categories as $category)
            <div class="category-block avoid-break">
                <div class="category-header">
                    <h2>{{ $category->name }}</h2>
                    <p>
                        Puntuación: <strong>{{ $category->score }} / {{ $category->max_score }}</strong>
                        ({{ $category->max_score > 0 ? number_format(($category->score / $category->max_score) * 100, 2) : 0 }}%)
                    </p>

                    @if ($category->appreciation_result)
                        <div class="appreciation">
                            <strong>Apreciación de la Categoría:</strong> {{ $category->appreciation_result->title }}
                            @if ($category->appreciation_result->appreciation)
                                <br>{{ $category->appreciation_result->appreciation }}
                            @endif
                        </div>
                    @endif
                </div>

                <div class="category-content">
                    <table class="layout-table">
                        <tr>
                            <td class="left-col">
                                <div class="subcategory-list">
                                    @forelse ($category->subcategories as $sub)
                                        <div class="item">
                                            <span><strong>{{ $sub->name }}</strong></span>
                                            <div class="percentage">
                                                {{ $sub->max_score > 0 ? number_format(($sub->score / $sub->max_score) * 100, 2) : 0 }}%
                                            </div>
                                            <small style="color: #777;">{{ $sub->score }} / {{ $sub->max_score }}
                                                puntos</small>
                                            @if ($sub->appreciation_result && $sub->appreciation_result->title)
                                                <div class="subcategory-appreciation">
                                                    <strong>Apreciación:</strong>
                                                    {{ $sub->appreciation_result->title }}
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <p>No hay subcategorías para mostrar.</p>
                                    @endforelse
                                </div>
                            </td>
                            <td class="right-col">
                                @if (isset($category->chartBase64) && $category->chartBase64)
                                    <div class="text-center">
                                        <img src="{{ $category->chartBase64 }}"
                                            alt="Gráfico de {{ $category->name }}">
                                    </div>
                                @else
                                    <div
                                        style="text-align:center; padding: 40px; background-color:#f5f5f5; border-radius: 8px;">
                                        <p>Gráfico no disponible.</p>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="answers-section page-break">
            <h2 style="color: #005A9C; border-bottom: 2px solid #005A9C; padding-bottom: 10px;">Detalle de Respuestas
            </h2>
            <table class="answers-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Pregunta</th>
                        <th style="width: 35%;">Respuesta Seleccionada</th>
                        <th style="width: 15%;" class="text-center">Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($answers as $answer)
                        <tr>
                            <td>{{ $answer->question->text }}</td>
                            <td>{{ $answer->option ? $answer->option->text : 'Sin respuesta' }}</td>
                            <td class="text-center" style="font-weight: bold; color: #005A9C;">{{ $answer->points }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>

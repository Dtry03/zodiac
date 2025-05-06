<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas de Inscritos - {{ $effectiveDate->isoFormat('D MMMM YYYY') }}</title>
    {{-- Estilos básicos para el PDF --}}
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        h2 {
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        td {
            font-size: 10px;
        }
        .class-details {
            font-size: 11px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ccc;
        }
        .class-details strong {
            display: inline-block;
            min-width: 70px;
        }
        .no-signups {
            font-style: italic;
            color: #777;
        }
        /* Evitar saltos de página dentro de una sección de clase si es posible */
        .class-section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>

    <h1>Listas de Inscritos - {{ $effectiveDayName }}, {{ $effectiveDate->isoFormat('D [de] MMMM [de] YYYY') }}</h1>

    {{-- Iterar sobre las clases del día efectivo --}}
    @forelse ($todaysClasses as $class)
        <div class="class-section">
            <h2>{{ $class->name }} ({{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }})</h2>
            <div class="class-details">
                <strong>Instructor:</strong> {{ $class->instructor->name ?? 'N/A' }} <br>
                <strong>Capacidad:</strong> {{ $class->signups->count() }} / {{ $class->capacity }}
            </div>

            {{-- Tabla de inscritos para esta clase --}}
            @if($class->signups->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            {{-- <th>Teléfono</th> --}} {{-- Añadir si tienes teléfono --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($class->signups as $index => $signup)
                            @if($signup->user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $signup->user->name }}</td>
                                    <td>{{ $signup->user->last_name ?? '' }}</td>
                                    <td>{{ $signup->user->email }}</td>
                                    {{-- <td>{{ $signup->user->phone ?? '' }}</td> --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="no-signups">No hay inscritos en esta clase.</p>
            @endif
        </div>
    @empty
        <p>No hay clases programadas para este día.</p>
    @endforelse

</body>
</html>

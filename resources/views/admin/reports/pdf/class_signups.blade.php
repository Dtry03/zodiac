<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Inscritos - {{ $gymClass->name }}</title>
    {{-- Estilos básicos para el PDF (puedes copiarlos/adaptarlos del otro PDF) --}}
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
            margin-bottom: 5px;
        }
        h2 {
            text-align: center;
            font-size: 12px;
            margin-bottom: 15px;
            color: #555;
            font-weight: normal;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
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
            padding: 10px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
        }
        .class-details strong {
            display: inline-block;
            min-width: 70px;
        }
        .no-signups {
            font-style: italic;
            color: #777;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1>{{ $gymClass->name }}</h1>
    @php
        $dayNames = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
    @endphp
    <h2>{{ $dayNames[$gymClass->day_of_week] ?? 'Día N/D' }} - {{ \Carbon\Carbon::parse($gymClass->start_time)->format('H:i') }}</h2>

    <div class="class-details">
        <strong>Instructor:</strong> {{ $gymClass->instructor->name ?? 'N/A' }} <br>
        <strong>Categoría:</strong> {{ $gymClass->category->name ?? 'N/A' }} <br>
        <strong>Capacidad:</strong> {{ $gymClass->signups->count() }} / {{ $gymClass->capacity }}
    </div>


    {{-- Tabla de inscritos para esta clase --}}
    @if($gymClass->signups->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    {{-- <th>Teléfono</th> --}}
                </tr>
            </thead>
            <tbody>
                {{-- Iterar sobre las inscripciones cargadas con la clase --}}
                @foreach ($gymClass->signups as $index => $signup)
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

</body>
</html>

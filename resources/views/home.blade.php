<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Colaboradores</title>
    <link rel="icon" href="https://static-00.iconduck.com/assets.00/devicon-plain-icon-2048x1941-ps18p8i9.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">Dev</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Registro de colaboradores</a>
                        </li>
                    </ul>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="btn btn-danger">Cerrar sesión</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
        </nav>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-add-worker">
                    Agregar colaborador
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Foto</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>DNI</th>
                                <th>Sueldo Base</th>
                                <th>Sueldo Neto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workers as $worker)
                            <tr>
                                <td class="text-center">
                                    @if($worker->foto)
                                    <img src="{{ asset('storage/' . $worker->foto) }}" alt="Foto" width="50" height="50"
                                        class="rounded-circle shadow-sm" style="object-fit: cover;">
                                    @else
                                    <span class="badge bg-secondary">Sin foto</span>
                                    @endif
                                </td>

                                <td>{{ $worker->nombres }}</td>
                                <td>{{ $worker->apellido_paterno }} {{ $worker->apellido_materno }}</td>
                                <td>{{ $worker->dni }}</td>
                                <td>S/ {{ number_format($worker->sueldo_base, 2) }}</td>
                                <td class="fw-bold text-primary">S/ {{ number_format($worker->sueldo_neto, 2) }}</td>

                                <td>
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modal-view-{{ $worker->id }}">
                                        Ver
                                    </button>

                                    <div class="modal fade" id="modal-view-{{ $worker->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog text-start">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title">Detalles de la Planilla</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-dark">

                                                    <div class="text-center mb-4">
                                                        @if($worker->foto)
                                                        <img src="{{ asset('storage/' . $worker->foto) }}"
                                                            alt="Foto de {{ $worker->nombres }}"
                                                            class="img-thumbnail shadow"
                                                            style="width: 150px; height: 150px; object-fit: cover;">
                                                        @else
                                                        <div class="alert alert-secondary d-inline-block">Este
                                                            colaborador no tiene foto</div>
                                                        @endif
                                                    </div>

                                                    <h5 class="text-primary border-bottom pb-2 text-center">
                                                        {{ $worker->nombres }} {{ $worker->apellido_paterno }}</h5>

                                                    <div class="row mt-3">
                                                        <div class="col-6">
                                                            <p><strong>DNI:</strong> {{ $worker->dni }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><strong>Área:</strong> {{ $worker->area }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><strong>Cargo:</strong> {{ $worker->cargo }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p><strong>Hijos:</strong> {{ $worker->cantidad_hijos }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="bg-light p-3 mt-2 rounded border">
                                                        <p class="mb-1"><strong>Sueldo Base:</strong> S/
                                                            {{ number_format($worker->sueldo_base, 2) }}</p>
                                                        <p class="mb-1"><strong>Asignación Familiar:</strong> S/
                                                            {{ number_format($worker->asignacion_familiar, 2) }}</p>
                                                        
                                                        <p class="mb-1"><strong>AFP:</strong> S/
                                                            {{ number_format($worker->descuento_afp_obligatoria + $worker->descuento_afp_comision, 2) }}</p>

                                                        <P Class="mb-1"><strong>Renta:</strong> S/
                                                            {{ number_format($worker->descuento_renta_5ta, 2) }}</P>

                                                        <p class="mb-1"><strong>EPS:</strong> S/
                                                            {{ number_format($worker->descuento_eps, 2) }}</p>    
                                                        
                                                        <p class="mb-1 text-danger"><strong>Descuentos (AFP, Renta,
                                                                EPS):</strong> - S/
                                                            {{ number_format($worker->sueldo_bruto - $worker->sueldo_neto, 2) }}
                                                        </p>
                                                        <hr>
                                                        <h4 class="text-success mt-2 mb-0 text-center"><strong>Neto a
                                                                Pagar: S/
                                                                {{ number_format($worker->sueldo_neto, 2) }}</strong>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-worker" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar colaborador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('trabajadors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nombres</label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" name="apellido_paterno" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" name="apellido_materno" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">DNI</label>
                                <input type="text" class="form-control" name="dni" maxlength="8" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexo</label>
                                <select class="form-select" name="sexo" required>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Hijos</label>
                                <input type="number" class="form-control" name="cantidad_hijos" value="0" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Sueldo Base (S/)</label>
                                <input type="number" step="0.01" class="form-control" name="sueldo_base" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Área</label>
                                <input type="text" class="form-control" name="area" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Cargo</label>
                                <input type="text" class="form-control" name="cargo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha Ingreso</label>
                                <input type="date" class="form-control" name="fecha_ingreso" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar y Calcular Sueldo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
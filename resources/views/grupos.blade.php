<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Grupos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('components.header')
    @include('components.alerts')
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Grupos</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Semestre</th>
                    <th>Grupo</th>
                    <th>Turno</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->semestre }}</td>
                        <td>{{ $grupo->grupo }}</td>
                        <td>{{ $grupo->turno }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-edit" data-id="{{ $grupo->id }}" data-semestre="{{ $grupo->semestre }}" data-grupo="{{ $grupo->grupo }}" data-turno="{{ $grupo->turno }}" data-toggle="modal" data-target="#editModal">Editar</a>
                            <form action="{{ route('grupos.delete', $grupo->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                    </td>

                    </tr>
                @endforeach
                @if ($grupos->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No hay datos</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">
          Crear Nuevo Registro
        </button>
    </div>
<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear Nuevo Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="createForm" method="POST" action="{{route('grupos.create')}}" novalidate>
            @csrf
            @method('POST')
            <div class="mb-3">
                <label for="semestre" class="form-label">Semestre</label>
                <input type="number" class="form-control" id="semestre" name="semestre" required min="1" max="12">
                <div class="invalid-feedback">
                    El semestre debe ser un número entre 1 y 12.
                </div>
            </div>
            
            <div class="mb-3">
                <label for="grupo" class="form-label">Grupo</label>
                <input type="text" class="form-control" id="grupo" name="grupo" required pattern="^[a-zA-Z0-9]+$" maxlength="10">
                <div class="invalid-feedback">
                    El grupo debe ser alfanumérico y no contener caracteres especiales.
                </div>
            </div>
            
            <div class="mb-3">
                <label for="turno" class="form-label">Turno</label>
                <select class="form-control" id="turno" name="turno" required>
                    <option value="">Seleccione un turno</option>
                    <option value="Matutino">Matutino</option>
                    <option value="Vespertino">Vespertino</option>
                </select>
                <div class="invalid-feedback">
                    Por favor seleccione un turno.
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Grupo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editId" name="id"> 
                    <div class="mb-3">
                        <label for="editSemestre" class="form-label">Semestre</label>
                        <input type="number" class="form-control" id="editSemestre" name="semestre" required min="1" max="12">
                        <div class="invalid-feedback">
                            El semestre debe ser un número entre 1 y 12.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editGrupo" class="form-label">Grupo</label>
                        <input type="text" class="form-control" id="editGrupo" name="grupo" required pattern="^[a-zA-Z0-9]+$" maxlength="10">
                        <div class="invalid-feedback">
                            El grupo debe ser alfanumérico y no contener caracteres especiales.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editTurno" class="form-label">Turno</label>
                        <select class="form-control" id="editTurno" name="turno" required>
                            <option value="">Seleccione un turno</option>
                            <option value="Matutino">Matutino</option>
                            <option value="Vespertino">Vespertino</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un turno.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

    

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        (function() {
            'use strict';
            var form = document.getElementById('createForm');
            // Verificar si el formulario es válido antes de enviarlo
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        })();

        document.querySelectorAll('form[method="POST"]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (form.querySelector('input[name="_method"]').value === 'DELETE') {
                    if (!confirm('¿Estás seguro de que deseas eliminar este grupo?')) {
                        event.preventDefault();
                    }
                }
            });
        });

        document.querySelectorAll('.btn-edit').forEach(function(button) {
        button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const semestre = this.getAttribute('data-semestre');
        const grupo = this.getAttribute('data-grupo');
        const turno = this.getAttribute('data-turno');

        // Asignar valores al formulario de edición
        document.getElementById('editId').value = id;
        document.getElementById('editSemestre').value = semestre;
        document.getElementById('editGrupo').value = grupo;
        document.getElementById('editTurno').value = turno;

        // Cambiar el atributo `action` del formulario para incluir el ID
        const form = document.getElementById('editForm');
        form.action = `/grupos/${id}`; // Asegúrate de usar la ruta correcta
    });
});
    </script>
    @include('components.footer')
</body>
</html>

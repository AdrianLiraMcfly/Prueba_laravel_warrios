<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('components.header')
    @include('components.alerts')
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Estudiantes</h1>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Edad</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Grupo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td>{{ $estudiante->nombre }}</td>
                        <td>{{ $estudiante->apellido }}</td>
                        <td>{{ $estudiante->edad }}</td>
                        <td>{{ $estudiante->email }}</td>
                        <td>{{ $estudiante->telefono }}</td>
                        <td>{{ $estudiante->grupo->grupo ?? 'Sin grupo' }}</td>
                        <td>
                            <a href="#" class="btn btn-warning btn-edit" data-id="{{ $estudiante->id }}" 
                               data-nombre="{{ $estudiante->nombre }}" 
                               data-apellido="{{ $estudiante->apellido }}" 
                               data-edad="{{ $estudiante->edad }}" 
                               data-email="{{ $estudiante->email }}" 
                               data-telefono="{{ $estudiante->telefono }}" 
                               data-toggle="modal" data-target="#editModal">Editar</a>
                            <form action="{{ route('estudiantes.delete', $estudiante->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($estudiantes->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">No hay datos</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">
            Crear Nuevo Registro
        </button>
    </div>

    <!-- Modal de Creación -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Crear Nuevo Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createForm" method="POST" action="{{ route('estudiantes.create') }}" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required max="50" pattern="[A-Za-z ]+" min="3">
                            <div class="invalid-feedback">Por favor ingrese un nombre válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required max="50" pattern="[A-Za-z ]+" min="3">
                            <div class="invalid-feedback">Por favor ingrese los apellido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" required min="1" max="100">
                            <div class="invalid-feedback">Por favor ingrese una edad válida.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Por favor ingrese un email válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required pattern="[0-9]+" max="10">
                            <div class="invalid-feedback">Por favor ingrese un teléfono válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="grupo_id" class="form-label">Grupo</label>
                            <select class="form-control" id="grupo_id" name="grupo_id" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->grupo }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione un grupo.</div>
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
                    <h5 class="modal-title" id="editModalLabel">Editar Estudiante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            <div class="invalid-feedback">Por favor ingrese un nombre válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editApellido" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="editApellido" name="apellido" required>
                            <div class="invalid-feedback">Por favor ingrese los apellido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editEdad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="editEdad" name="edad" required>
                            <div class="invalid-feedback">Por favor ingrese una edad válida.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                            <div class="invalid-feedback">Por favor ingrese un email válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editTelefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                            <div class="invalid-feedback">Por favor ingrese un teléfono válido.</div>
                        </div>
                        <div class="mb-3">
                            <label for="editGrupo_id" class="form-label mb-0">Grupo</label>
                            <select class="form-control" id="editGrupo_id" name="grupo_id" required>
                                <option value="">Seleccione un grupo</option>
                                @foreach ($grupos as $grupo)
                                    <option value="{{ $grupo->id }}">{{ $grupo->grupo }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Por favor seleccione un grupo.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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
                    if (!confirm('¿Estás seguro de que deseas eliminar este estudiante?')) {
                        event.preventDefault();
                    }
                }
            });
        });

        document.querySelectorAll('.btn-edit').forEach(function(button) {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const apellido = this.getAttribute('data-apellido');
                const edad = this.getAttribute('data-edad');
                const email = this.getAttribute('data-email');
                const telefono = this.getAttribute('data-telefono');

                document.getElementById('editId').value = id;
                document.getElementById('editNombre').value = nombre;
                document.getElementById('editApellido').value = apellido;
                document.getElementById('editEdad').value = edad;
                document.getElementById('editEmail').value = email;
                document.getElementById('editTelefono').value = telefono;

                const form = document.querySelector('#editForm');
                form.action = `/estudiantes/${id}`;
            });
        });
    </script>
    @include('components.footer')
</body>
</html>

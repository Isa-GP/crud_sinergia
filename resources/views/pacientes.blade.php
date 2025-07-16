<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-light p-5">
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Pacientes</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPaciente">Agregar Paciente</button>
    </div>

    <table id="tablaPacientes" class="table table-striped table-bordered">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody id="pacientesBody">
        <!-- JS llenará esto -->
        </tbody>
    </table>
</div>

<!-- Modal para agregar/editar paciente -->
<div class="modal fade" id="modalPaciente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPaciente">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPacienteTitle">Nuevo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="paciente_id">
                    <input type="text" id="nombre1" class="form-control mb-2" placeholder="Primer nombre" required>
                    <input type="text" id="apellido1" class="form-control mb-2" placeholder="Primer apellido" required>
                    <input type="email" id="correo" class="form-control mb-2" placeholder="Correo electrónico">
                    <input type="text" id="numero_documento" class="form-control mb-2" placeholder="Número de documento" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
const apiUrl = 'http://localhost:8000/api';
const token = "Bearer {{ session('jwt_token') }}";
const tabla = $('#tablaPacientes').DataTable();

$(document).ready(() => {
    if (!token) {
        alert('No hay token. Redirigiendo al login...');
        window.location.href = '/login';
        return;
    }

    cargarPacientes();

    $('#formPaciente').on('submit', async function (e) {
        e.preventDefault();
        const id = $('#paciente_id').val();
        const metodo = id ? 'PUT' : 'POST';
        const url = id ? `${apiUrl}/pacientes/${id}` : `${apiUrl}/pacientes`;

        const datos = {
            tipo_documento_id: 1,
            numero_documento: $('#numero_documento').val(),
            nombre1: $('#nombre1').val(),
            apellido1: $('#apellido1').val(),
            correo: $('#correo').val(),
            genero_id: 1,
            departamento_id: 1,
            municipio_id: 1
        };

        const res = await fetch(url, {
            method: metodo,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(datos)
        });

        if (res.ok) {
            $('#modalPaciente').modal('hide');
            $('#formPaciente')[0].reset();
            $('#paciente_id').val('');
            tabla.clear().draw();
            cargarPacientes();
        } else {
            const errorText = await res.text();
            console.error('Error al guardar paciente:', errorText);
            alert('Error al guardar paciente');
        }
    });
});

function cargarPacientes() {
    fetch(apiUrl + '/pacientes', {
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        }
    })
    .then(res => res.ok ? res.json() : res.text())
    .then(data => {
        if (Array.isArray(data)) {
            data.forEach(p => {
                tabla.row.add([
                    p.id,
                    `${p.nombre1} ${p.apellido1}`,
                    p.correo || '',
                    `<button class='btn btn-sm btn-warning me-1' onclick='cargarParaEditar(${p.id})'>Editar</button>
                     <button class='btn btn-sm btn-danger' onclick='eliminarPaciente(${p.id})'>Eliminar</button>`
                ]).draw(false);
            });
        } else {
            console.error('Respuesta no esperada:', data);
        }
    })
    .catch(err => console.error('Error cargando pacientes:', err));
}

function cargarParaEditar(id) {
    fetch(`${apiUrl}/pacientes/${id}`, {
        headers: { 'Authorization': 'Bearer ' + token }
    })
    .then(res => res.json())
    .then(p => {
        $('#modalPacienteTitle').text('Editar Paciente');
        $('#paciente_id').val(p.id);
        $('#nombre1').val(p.nombre1);
        $('#apellido1').val(p.apellido1);
        $('#correo').val(p.correo);
        $('#numero_documento').val(p.numero_documento);
        const modal = new bootstrap.Modal(document.getElementById('modalPaciente'));
        modal.show();
    });
}

function eliminarPaciente(id) {
    if (!confirm('¿Estás seguro de eliminar este paciente?')) return;

    fetch(`${apiUrl}/pacientes/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
    }).then(() => {
        tabla.clear().draw();
        cargarPacientes();
    });
}
</script>
</body>
</html>

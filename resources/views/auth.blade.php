<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            max-width: 400px;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="card">
    <h3 class="text-center mb-4">Iniciar sesión</h3>
    <form id="loginForm">
        <div class="mb-3">
            <label for="login_email" class="form-label">Correo electrónico</label>
            <input type="email" id="login_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="login_password" class="form-label">Contraseña</label>
            <input type="password" id="login_password" class="form-control" required>
        </div>
        <button class="btn btn-primary" type="submit">Ingresar</button>
        <div class="mt-3 text-center">
            <a href="/register">¿No tienes cuenta? Regístrate</a>
        </div>
    </form>
    <div class="mt-3 text-danger" id="msg"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    console.log("Login script cargado");
    const apiUrl = "http://localhost:8000/api";

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.getElementById("loginForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        console.log("Formulario login enviado");

        const res = await fetch(`${apiUrl}/login`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: document.getElementById("login_email").value,
                password: document.getElementById("login_password").value
            })
        });

        const data = await res.json();
        console.log("Respuesta:", data);

        if (data.token) {
            await fetch('/set-token', {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ token: data.token })
            });
            window.location.href = "/pacientes";
        } else {
            document.getElementById("msg").textContent = data.message || "Credenciales inválidas.";
        }
    });
});
</script>
</body>
</html>

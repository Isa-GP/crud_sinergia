# 🏥 CRUD de Pacientes - Laravel API + JWT + Frontend Bootstrap

Este proyecto es una aplicación completa que combina un backend en **Laravel** con autenticación **JWT** y un frontend interactivo utilizando **Bootstrap**, **JavaScript** y **DataTables**. Permite realizar operaciones CRUD sobre pacientes: crear, listar, editar y eliminar.

---

## 🔐 Autenticación

El sistema implementa autenticación mediante **JSON Web Token (JWT)**.

### Endpoints:

| Método | Endpoint      | Descripción              |
|--------|---------------|--------------------------|
| POST   | `/api/register` | Registro de usuario     |
| POST   | `/api/login`    | Inicio de sesión (token)|

Después del login, se debe incluir el token en las solicitudes:

Authorization: Bearer TU_TOKEN

yaml
Copiar
Editar

---

## 🚀 Instalación del proyecto

1. Clonar el repositorio:

```bash
git clone https://github.com/Isa-GP/prueba-sinergia.git
cd prueba-sinergia
Instalar dependencias:

bash
Copiar
Editar
composer install
Crear y configurar .env:

bash
Copiar
Editar
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
Configurar conexión a base de datos en .env.

Ejecutar migraciones y seeders:

bash
Copiar
Editar
php artisan migrate --seed
Ejecutar el servidor:

bash
Copiar
Editar
php artisan serve
🧪 Endpoints de la API de Pacientes
Requieren autenticación JWT.

Método	Endpoint	Descripción
GET	/api/pacientes	Lista de pacientes
GET	/api/pacientes/{id}	Ver un paciente
POST	/api/pacientes	Crear paciente
PUT	/api/pacientes/{id}	Actualizar paciente
DELETE	/api/pacientes/{id}	Eliminar paciente

Ejemplo de headers:
json
Copiar
Editar
{
  "Authorization": "Bearer TU_TOKEN",
  "Accept": "application/json",
  "Content-Type": "application/json"
}
🎨 Interfaz Frontend
Ubicada en resources/views/pacientes.blade.php.

Características:
Login y registro con validación

Visualización de pacientes con DataTables

Formulario en modal para crear/editar pacientes

Función de eliminar

Búsqueda en tiempo real

Validación de campos

Tecnologías:
Laravel Blade

Bootstrap 5

DataTables

JavaScript (Fetch API)

jQuery

📁 Estructura Relevante
pgsql
Copiar
Editar
crud_sinergia/
├── app/
│   └── Http/
│       ├── Controllers/
│           ├── AuthController.php
│           └── PacienteController.php
├── routes/
│   └── api.php
├── resources/
│   └── views/
│       ├── login.blade.php
│       └── pacientes.blade.php
├── database/
│   ├── migrations/
│   └── seeders/
✅ Requisitos
PHP >= 8.1

Composer

Laravel 10

MySQL o SQLite

Node.js (opcional, para compilar assets)

👩‍💻 Autora
Maria Isabel González Polanco
Tecnóloga en Análisis y Desarrollo de Software - SENA
GitHub: Isa-GP


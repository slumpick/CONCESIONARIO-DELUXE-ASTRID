#  Concesionario Deluxe - Concesionario Online

**Concesionario Deluxe** es una aplicación web de concesionario de coches desarrollada en **PHP** y **MySQL**, con una interfaz moderna utilizando **Bootstrap**. Permite gestionar vehículos, alquileres y usuarios con diferentes roles.

##  Características principales
- 🔹 **Usuarios con diferentes roles** (Administrador, Vendedor, Comprador)
- 🔹 **Gestión de coches** (Añadir, modificar, eliminar y ver coches)
- 🔹 **Sistema de alquileres** (Registro y administración de alquileres de coches)
- 🔹 **Panel de administración** (Gestión de usuarios y concesionario)
- 🔹 **Autenticación segura** (Inicio de sesión y permisos por rol)

---

##  Instalación y configuración

###  1. Requisitos
- PHP 8+
- MySQL o MariaDB
- Servidor local como **XAMPP** o **WAMP**

###  2. Clonar el repositorio
```sh
git clone https://github.com/
cd 

 3. Importar la base de datos

    Abre phpMyAdmin o tu herramienta SQL favorita.
    Crea una base de datos llamada concesionario.
    Importa el archivo database/concesionario.sql en phpMyAdmin.
 4. Configurar la conexión a la base de datos

Edita el archivo src/php/db.php y asegúrate de que los datos de conexión coinciden con tu entorno:

$host = "localhost";
$user = "root"; // Cambiar si es necesario
$password = ""; // Cambiar si tienes contraseña
$database = "concesionario";
$conn = mysqli_connect($host, $user, $password, $database);

 Usuarios de prueba

Para probar la plataforma, puedes usar los siguientes usuarios con su DNI como contraseña:

    Administrador
        DNI: 1111
        Contraseña: 1111
        Tipo de usuario: admin

    Comprador
        DNI: 123
        Contraseña: 123
        Tipo de usuario: comprador

    Vendedor 1
        DNI: 1234
        Contraseña: 1234
        Tipo de usuario: vendedor

    Vendedor 2
        DNI: 12345
        Contraseña: 12345
        Tipo de usuario: vendedor

 Funcionalidades
 Usuarios

    Comprador: Accede a la vista de los coches disponibles.
    Vendedor: Gestiona los coches que ha publicado y ve los alquileres de sus coches.
    Administrador: Control total sobre la plataforma: usuarios, coches y alquileres.

 Coches

    Listado de coches: Muestra todos los coches disponibles.
    Gestión de coches: Los vendedores y administradores pueden añadir, modificar y eliminar coches.
    Búsqueda y filtrado: Los usuarios pueden buscar coches según diferentes criterios.

 Alquileres

    Alquiler de coches: Los vendedores gestionan los alquileres de sus coches.
    Finalización de alquileres: Los administradores y vendedores pueden finalizar un alquiler y hacer que el coche esté disponible nuevamente.

 Uso del sistema

    Inicia sesión con uno de los usuarios de prueba.
    Explora el sistema y accede a las funciones según tu rol (comprador, vendedor o administrador).
    Gestiona coches: Añade, modifica o elimina coches si tienes permisos.
    Gestiona alquileres: Realiza alquileres y consulta los detalles si eres un vendedor o administrador.

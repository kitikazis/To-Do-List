📌 Sistema Web en PHP con Manejo de JSON
Este proyecto es una aplicación web desarrollada en PHP que gestiona autenticación, actividades, calendario y progreso de usuario, utilizando archivos JSON como base de datos. El sistema sigue una arquitectura con separación de estáticos (CSS, JS, IMG) y un enrutador central (index.php).

📜 Descripción General
El sistema funciona de la siguiente forma:

Cliente Web solicita páginas HTML, CSS, JS e imágenes.

Servidor PHP procesa las solicitudes dinámicas.

Archivos JSON se utilizan para leer y escribir datos persistentes.

Enrutador (index.php) redirige a las páginas correspondientes:

login.php → Manejo de inicio de sesión.

actividades.php → Gestión de actividades.

calendario.php → Visualización del calendario.

progreso.php → Seguimiento del progreso.

Archivos estáticos se sirven directamente desde:

/CSS/

/JS/

/IMG/

🗂 Estructura del Proyecto
bash
Copiar
Editar
📂 Proyecto
 ├── 📂 CSS/                # Hojas de estilo
 ├── 📂 JS/                 # Scripts JavaScript
 ├── 📂 IMG/                # Imágenes del sistema
 ├── 📜 index.php           # Enrutador principal
 ├── 📜 login.php           # Página de inicio de sesión
 ├── 📜 actividades.php     # Gestión de actividades
 ├── 📜 calendario.php      # Vista de calendario
 ├── 📜 progreso.php        # Seguimiento de progreso
 ├── 📜 login.json          # Datos de usuarios
 ├── 📜 actividades.json    # Datos de actividades
⚙️ Flujo de Funcionamiento
Frontend: El navegador solicita HTML, CSS, JS e imágenes.

Backend: PHP procesa las peticiones y retorna HTML dinámico.

Persistencia: Archivos .json para almacenar usuarios y actividades.

🚀 Instalación y Ejecución
Clonar el repositorio:

bash
Copiar
Editar
git clone https://github.com/usuario/repositorio.git
Colocar los archivos en un servidor local (XAMPP, WAMP, Laragon, etc.).

Asegurarse de que PHP tenga permisos de lectura/escritura en los .json.

Abrir en el navegador:

arduino
Copiar
Editar
http://localhost/proyecto/index.php
🖼 Diagrama del Sistema

📌 Tecnologías Utilizadas
PHP 7+

HTML5

CSS3

JavaScript

JSON

✨ Autores
Luis Yamir Huallcca Cuenca
Mattias Muguruza
Isabel
Carlos
Fabian

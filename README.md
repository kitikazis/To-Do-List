# 📌 Sistema Web en PHP con Manejo de JSON

Este proyecto es una aplicación web desarrollada en **PHP** que gestiona autenticación, actividades, calendario y progreso de usuario, utilizando **archivos JSON** como base de datos. El sistema sigue una arquitectura con separación de estáticos (CSS, JS, IMG) y un enrutador central (`index.php`).

## 📜 Descripción General

El sistema funciona de la siguiente forma:

1. **Cliente Web** solicita páginas HTML, CSS, JS e imágenes.
2. **Servidor PHP** procesa las solicitudes dinámicas.
3. **Archivos JSON** se utilizan para leer y escribir datos persistentes.
4. **Enrutador (`index.php`)** redirige a las páginas correspondientes:
   - `login.php` → Manejo de inicio de sesión.
   - `actividades.php` → Gestión de actividades.
   - `calendario.php` → Visualización del calendario.
   - `progreso.php` → Seguimiento del progreso.
5. Archivos estáticos se sirven directamente desde:
   - `/CSS/`
   - `/JS/`
   - `/IMG/`

## 🗂 Estructura del Proyecto
📂 Proyecto
├── 📂 CSS/ # Hojas de estilo
├── 📂 JS/ # Scripts JavaScript
├── 📂 IMG/ # Imágenes del sistema
├── 📜 index.php # Enrutador principal
├── 📜 login.php # Página de inicio de sesión
├── 📜 actividades.php # Gestión de actividades
├── 📜 calendario.php # Vista de calendario
├── 📜 progreso.php # Seguimiento de progreso
├── 📜 login.json # Datos de usuarios
├── 📜 actividades.json # Datos de actividades


## ⚙️ Flujo de Funcionamiento

- **Frontend:** El navegador solicita HTML, CSS, JS e imágenes.
- **Backend:** PHP procesa las peticiones y retorna HTML dinámico.
- **Persistencia:** Archivos `.json` para almacenar usuarios y actividades.

## 🚀 Instalación y Ejecución

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/usuario/repositorio.git

http://localhost/proyecto/index.php

✨ Autores
- Luis Yamir Huallcca Cuenca
- Mattias Muguruza
- Isabel
- Carlos
Fabian

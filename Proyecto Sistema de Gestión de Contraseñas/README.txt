# Sistema de Gestión de Contraseñas

Este proyecto es un sistema web diseñado para la gestión de contraseñas. Permite a los usuarios guardar, visualizar y editar contraseñas de manera segura. Es un desarrollo realizado en PHP, utilizando XAMPP como servidor local.

---

## Requisitos

Antes de comenzar, asegúrate de cumplir con los siguientes requisitos:

- XAMPP instalado en tu computadora (o cualquier servidor local que soporte PHP y MySQL).
- Acceso a un navegador web moderno.
- Git instalado (opcional para clonar el repositorio desde GitHub).

---

## Instalación del proyecto

1. Copiar el proyecto en el servidor local.
2. Ubica la carpeta del proyecto (gestion_contrasenas).
3. Copia esta carpeta dentro de htdocs en tu instalación de XAMPP: 
	C:\xampp\htdocs\gestion_contrasenas

## Importación de la base de datos

1. Abre XAMPP y activa los servicios Apache y MySQL.
2. Abre phpMyAdmin.
3. Crea una nueva base de datos con el nombre gestion_contrasenas.
4. Importa el archivo SQL ubicado en:
	htdocs/gestion_contrasenas/database/gestion_contrasenas.sql

## Configurar la conexión a la base de datos

1. Abre el archivo conexion.php dentro del proyecto.
2. Asegúrate de que las credenciales coincidan con las de tu entorno local:
	$servername = "localhost";
	$username = "root"; // Usuario predeterminado de XAMPP
	$password = ""; // Sin contraseña por defecto
	$dbname = "gestion_contrasenas"; // Nombre de tu base de datos

## Uso

1. Abre tu navegador web y accede al proyecto:
	http://localhost/gestion_contrasenas
2. Inicia sesión con un usuario existente o regístrate.
3. Utiliza las funciones del sistema para gestionar tus contraseñas.


Créditos

Desarrollador: Byron José García.
Universidad: Universidad Nacional Abierta y a Distancia (UNAD).
Proyecto: Sistema de Gestión de Contraseñas (Trabajo de grado).

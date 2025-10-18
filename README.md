# Sistema de Gestión Hotelera — SGH

Una pequeña aplicación PHP para gestionar habitaciones, huéspedes, reservas y tareas de mantenimiento.

Este repositorio contiene una interfaz ligera basada en PHP + PDO y plantillas sencillas en `src/views`. El objetivo del trabajo fue unificar la apariencia entre módulos, arreglar rutas y servicios, y garantizar que las operaciones de crear/editar/borrar funcionen correctamente contra la base de datos MySQL.

## Estado actual (resumen de trabajo realizado)
- Rutas y `require_once` corregidas para usar `src/config/database.php` de forma consistente.
- Modelos alineados con los nombres reales de las tablas en la base de datos (`habitaciones`, `huespedes`, `reservas`, `tareas_mantenimiento`).
- Servicios creados/estandarizados en `src/services/` para procesar formularios: `addReservation.php`, `updateReservation.php`, `deleteReservation.php`, además de `ReservationServices.php`.
- Vistas de reservas (`src/views/reservations`) adaptadas para usar el mismo estilo y estructura que habitaciones (`rooms`).
- Manejo de errores con estilos (`.error`) y mensajes informativos.
- Prevenciones para evitar borrados que rompan integridad referencial (por ejemplo, impedir borrar una habitación con reservas asociadas).

## Estructura del proyecto

Raíz: archivos principales
- `index.php` — panel inicial con enlaces al resto de vistas
- `README.md` — este documento

Carpeta `src/` (código fuente)
- `config/` — `config.php` y `database.php` (conexión PDO)
- `models/` — modelos: `Room.php`, `Guest.php`, `Reservation.php`, `MaintenanceTask.php`
- `services/` — scripts que procesan formularios (alta/edición/baja)
- `views/` — vistas por módulo:
	- `rooms/` — `list.php`, `addRoom.php`, `editRoom.php`, `deleteRoom.php`, `updateRoom.php`
	- `guests/` — `guestsList.php`, `addGuest.php`, `editGuest.php`, `deleteGuest.php`, `updateGuest.php`
	- `reservations/` — `reservationsList.php`, `addReservation.php`, `editReservation.php`, `deleteReservation.php`, `updateReservation.php`
	- `maintenance/` — `tasks.php`, `addTask.php`, `editTask.php`, `deleteTask.php`, `updateTask.php`
- `style.css` — estilos compartidos

## Requisitos
- PHP 7.4+ con PDO (extensión PDO_MySQL)
- MySQL / MariaDB
- XAMPP (recomendado para desarrollo local)

## Configuración rápida (desarrollo)

1. Coloca el proyecto en la carpeta pública de tu servidor (por ejemplo, `C:\xampp\htdocs\SGH` o similar).
2. Asegúrate de que el archivo de configuración `src/config/config.php` contiene los datos correctos de acceso a la BD.
3. Crea la base de datos e importa `hotel_db.sql` (si tienes el volcado). Verifica que las tablas existen y se llaman:
	 - `habitaciones` (con columnas como `id`, `numero`, `tipo`, `precio_base`, `estado_limpieza`)
	 - `huespedes` (con `id`, `nombre`, `apellido`, `email`, ...)
	 - `reservas` (con `id`, `huesped_id`, `habitacion_id`, `fecha_llegada`, `fecha_salida`, `precio_total`, `estado`)
	 - `tareas_mantenimiento` (con `habitacion_id`, `fecha_inicio`, `fecha_fin`, `estado`, ...)

4. Abre en el navegador la ruta al proyecto, por ejemplo:

```powershell
# En Windows con XAMPP, abre
http://localhost/SGH/index.php
```

## Cómo usar — flujos principales

- Habitaciones: `src/views/rooms/list.php` — ver, crear, editar, borrar (siempre se comprueba FK antes de borrar).
- Huéspedes: `src/views/guests/guestsList.php` — ver, crear, editar, borrar.
- Reservas: `src/views/reservations/reservationsList.php` — ver lista; crear/editar/borrar reservas usa los servicios en `src/services/`.
- Mantenimiento: `src/views/maintenance/tasks.php` — gestionar tareas de mantenimiento.

Los formularios POST ahora envían a los scripts dentro de `src/services/` para centralizar la lógica (por ejemplo `src/services/addReservation.php`).

## Pruebas rápidas (crear/editar/eliminar reservas)
1. Crear un huésped en `Huéspedes`.
2. Crear una habitación en `Habitaciones` (con `precio_base`).
3. Ir a `Reservas` → `Crear Nueva Reserva` y seleccionar huésped y habitación; elegir fechas y guardar.
4. Ver en la lista que la reserva aparece con `fecha_llegada`, `fecha_salida` y `precio_total` calculado.
5. Editar la reserva y comprobar que se actualiza.
6. Eliminar la reserva y comprobar que desaparece.

Si algo no aparece, revisa la consola de Apache / logs de PHP para ver errores (paths, permisos o errores SQL).

## Errores comunes y soluciones
- "Failed opening required": normalmente rutas `require_once` incorrectas. Las vistas bajo `src/views/...` deben incluir `__DIR__ . '/../../config/database.php'` y los modelos `__DIR__ . '/../config/database.php'`.
- "Unknown column" o "Table not found": revisa los nombres exactos de tus tablas y columnas. El proyecto usa nombres en español (`reservas`, `habitaciones`, `huespedes`).
- Violaciones FK al borrar: si intentas borrar una habitación con reservas, la aplicación ahora previene el borrado y muestra un mensaje. Si prefieres borrado en cascada, cambia la restricción en la base de datos (ON DELETE CASCADE) con cuidado.

## Notas técnicas y siguientes pasos
- Mejora recomendada: migraciones y un script de seed para crear datos de prueba.
- Añadir autenticación (usuarios, roles) antes de exponer operaciones sensibles.
- Añadir tests automatizados (script PHP o PHPUnit) para validar flujos CRUD.

Si quieres, puedo:
- Generar un script SQL de ejemplo para poblar tablas con datos de prueba.
- Añadir confirmaciones modales JS antes de eliminar y mostrar las reservas vinculadas cuando el usuario intenta borrar una habitación.
- Añadir endpoints AJAX para operaciones sin recargar la página.

---

Si quieres que adapte este README (más corto, con capturas de pantalla o pasos detallados para XAMPP), dime qué formato prefieres y lo actualizo.


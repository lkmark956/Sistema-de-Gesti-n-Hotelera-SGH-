-- Base de datos simple con datos de ejemplo
DROP DATABASE IF EXISTS hotel_db;
CREATE DATABASE IF NOT EXISTS hotel_db;
USE hotel_db;

-- Tabla habitaciones (actualizada)
CREATE TABLE habitaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero VARCHAR(20) NOT NULL UNIQUE,
  tipo VARCHAR(50) NOT NULL,
  precio_base DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  estado_limpieza ENUM('Limpia','Sucia','En Limpieza') NOT NULL DEFAULT 'Limpia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla huéspedes (actualizada)
CREATE TABLE huespedes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla reservas (actualizada)
CREATE TABLE reservas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  huesped_id INT NOT NULL,
  habitacion_id INT NOT NULL,
  fecha_llegada DATE NOT NULL,
  fecha_salida DATE NOT NULL,
  precio_total DECIMAL(10,2) NOT NULL,
  estado ENUM('Pendiente','Confirmada','Cancelada') NOT NULL DEFAULT 'Pendiente',
  fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (huesped_id) REFERENCES huespedes(id) ON DELETE CASCADE,
  FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla mantenimiento (actualizada)
CREATE TABLE tareas_mantenimiento (
  id INT AUTO_INCREMENT PRIMARY KEY,
  habitacion_id INT NOT NULL,
  descripcion VARCHAR(255),
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado ENUM('Programada','En Curso','Finalizada') NOT NULL DEFAULT 'Programada',
  FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos de ejemplo
INSERT INTO habitaciones (numero,tipo,precio_base,estado_limpieza) VALUES
  ('101','Sencilla', 30.00,'Limpia'),
  ('102','Doble', 50.00,'Sucia'),
  ('201','Suite', 100.00,'Limpia');

INSERT INTO huespedes (nombre,email) VALUES
  ('María Pérez','maria@ejemplo.com'),
  ('Juan Gómez','juan@ejemplo.com');

-- Reserva confirmada (bloquea la habitación 101 entre 2025-10-20 y 2025-10-22)
INSERT INTO reservas (huesped_id,habitacion_id,fecha_llegada,fecha_salida,precio_total,estado)
VALUES (1, 1, '2025-10-20', '2025-10-22', 30.00 * 2, 'Confirmada');

-- Tarea de mantenimiento (habitacion 102)
INSERT INTO tareas_mantenimiento (habitacion_id,descripcion,fecha_inicio,fecha_fin,estado)
VALUES (2, 'Reparar grifo', '2025-10-21', '2025-10-21', 'En Curso');

SELECT * FROM huespedes;

ALTER TABLE huespedes
ADD COLUMN apellido VARCHAR(150) NOT NULL;

CREATE TABLE cuentas (
	id_cuenta INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR (200) NOT NULL,
    contraseña VARCHAR (220)
);

INSERT INTO cuentas (nombre, contraseña) VALUES
('admin', '1234'),
('marco', '123'); 

-- Insertar datos con apellidos
UPDATE huespedes SET apellido = 'Pérez' WHERE nombre = 'María';
UPDATE huespedes SET apellido = 'Gómez' WHERE nombre = 'Juan';
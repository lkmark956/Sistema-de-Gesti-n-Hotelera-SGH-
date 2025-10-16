-- Base de datos simple con datos de ejemplo
DROP DATABASE IF EXISTS hotel_bd;
CREATE DATABASE IF NOT EXISTS hotel_db
  DEFAULT CHARACTER SET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;
USE hotel_db;

-- Tabla habitaciones (muy simple)
DROP TABLE IF EXISTS rooms;
CREATE TABLE rooms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  numero VARCHAR(20) NOT NULL UNIQUE,
  tipo VARCHAR(50) NOT NULL,
  precio_base DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  cleaning_state ENUM('Limpia','Sucia','En Limpieza') NOT NULL DEFAULT 'Limpia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla huéspedes simple
DROP TABLE IF EXISTS guests;
CREATE TABLE guests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla reservas mínima
DROP TABLE IF EXISTS reservations;
CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  guest_id INT NOT NULL,
  room_id INT NOT NULL,
  fecha_llegada DATE NOT NULL,
  fecha_salida DATE NOT NULL,
  precio_total DECIMAL(10,2) NOT NULL,
  estado ENUM('Pendiente','Confirmada','Cancelada') NOT NULL DEFAULT 'Pendiente',
  fecha_reserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla mantenimiento mínima
DROP TABLE IF EXISTS maintenance_tasks;
CREATE TABLE maintenance_tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room_id INT NOT NULL,
  descripcion VARCHAR(255),
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado ENUM('Programada','En Curso','Finalizada') NOT NULL DEFAULT 'Programada',
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos de ejemplo
INSERT INTO rooms (numero,tipo,precio_base,cleaning_state) VALUES
  ('101','Sencilla', 30.00,'Limpia'),
  ('102','Doble', 50.00,'Sucia'),
  ('201','Suite', 100.00,'Limpia');

INSERT INTO guests (nombre,email) VALUES
  ('María Pérez','maria@ejemplo.com'),
  ('Juan Gómez','juan@ejemplo.com');

-- Reserva confirmada (bloquea la habitación 101 entre 2025-10-20 y 2025-10-22)
INSERT INTO reservations (guest_id,room_id,fecha_llegada,fecha_salida,precio_total,estado)
VALUES (1, 1, '2025-10-20', '2025-10-22', 30.00 * 2, 'Confirmada');

-- Tarea de mantenimiento (habitacion 102)
INSERT INTO maintenance_tasks (room_id,descripcion,fecha_inicio,fecha_fin,estado)
VALUES (2, 'Reparar grifo', '2025-10-21', '2025-10-21', 'En Curso');
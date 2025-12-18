-- =========================================================
-- FOODEDU RAILWAY DATABASE SCHEMA (FULL & CONSOLIDATED)
-- Compatibility: MySQL 5.7+ / 8.0 / MariaDB (DBeaver & Railway)
-- =========================================================

-- 1. Setup Database (Optional - Railway usually provides one)
-- CREATE DATABASE IF NOT EXISTS railway;
-- USE railway;
-- (Jika menggunakan Railway, biasanya Anda langsung connect ke DB yang tersedia)

-- 2. Drop Tables (Clean Slate - Use with Caution)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS gizi_items;
DROP TABLE IF EXISTS kelayakan_items;
DROP TABLE IF EXISTS pengaduan;
DROP TABLE IF EXISTS saran;
SET FOREIGN_KEY_CHECKS = 1;

-- =========================================================
-- 3. USERS TABLE
-- =========================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('siswa', 'ortu', 'sekolah', 'mbg') NOT NULL,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    sekolah VARCHAR(255),
    anak VARCHAR(255),
    nip VARCHAR(50),
    idk VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Constraints
    UNIQUE KEY uq_email (email),
    UNIQUE KEY uq_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 4. GIZI ITEMS TABLE
-- =========================================================
CREATE TABLE gizi_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL,
    color ENUM('green','orange') NOT NULL DEFAULT 'green',
    image_url VARCHAR(255) NOT NULL,
    category VARCHAR(100) DEFAULT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    description TEXT,
    portion_size VARCHAR(50),
    energy VARCHAR(50),
    fat VARCHAR(50),
    protein VARCHAR(50),
    carbs VARCHAR(50),
    sodium VARCHAR(50),
    calcium VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    UNIQUE KEY uq_slug (slug),
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 5. KELAYAKAN ITEMS TABLE
-- =========================================================
CREATE TABLE kelayakan_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_name VARCHAR(100) NOT NULL,
    good_title VARCHAR(150) NOT NULL,
    good_image_url VARCHAR(255) NOT NULL,
    good_points TEXT NOT NULL,
    bad_title VARCHAR(150) NOT NULL,
    bad_image_url VARCHAR(255) NOT NULL,
    bad_points TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 6. PENGADUAN TABLE
-- =========================================================
CREATE TABLE pengaduan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_lengkap VARCHAR(255) NOT NULL,
    nama_sekolah VARCHAR(255) NOT NULL,
    tanggal_kejadian DATE NOT NULL,
    jenis_pengaduan ENUM('Kualitas Makanan', 'Kebersihan Makanan', 'Kuantitas Makanan', 'Lainnya') NOT NULL,
    deskripsi TEXT NOT NULL,
    bukti_path VARCHAR(500) NULL,
    status ENUM('pending', 'diproses', 'selesai', 'ditolak') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
    -- Optional: Foreign Key to users (if you want strict integrity)
    -- CONSTRAINT fk_pengaduan_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 7. SARAN TABLE
-- =========================================================
CREATE TABLE saran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(255) NOT NULL,
    nama_sekolah VARCHAR(255) NOT NULL,
    saran_dan_masukan TEXT NOT NULL,
    alasan TEXT,
    status ENUM('baru','ditinjau','diterima','ditolak') DEFAULT 'baru',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
-- 8. INITIAL DATA (SAMPLE)
-- =========================================================

-- Admin MBG: mbg / 123456
INSERT INTO users (name, email, phone, role, username, password_hash, idk) 
VALUES ('Admin MBG', 'mbg@foodedu.id', '081234567890', 'mbg', 'mbg', '$2y$10$PhW.u.t.h/t.u.t.h.u.t.h.u.t.h.u.t.h.u.t.h.u.t.h.', 'PEG-001');

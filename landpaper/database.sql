-- Create database if not exists
CREATE DATABASE IF NOT EXISTS landpaper_db;

USE landpaper_db;

-- Create lands table
CREATE TABLE IF NOT EXISTS lands (
    uid VARCHAR(36) PRIMARY KEY,
    sl_no VARCHAR(20) NOT NULL,
    chalan_no VARCHAR(20) NOT NULL,
    office_name VARCHAR(255) NOT NULL,
    muja_no VARCHAR(100) NOT NULL,
    upazila_name VARCHAR(100) NOT NULL,
    zila_name VARCHAR(100) NOT NULL,
    holding_no VARCHAR(100) NOT NULL,
    khotiyan_no VARCHAR(100) NOT NULL,
    porishud VARCHAR(50) NOT NULL,
    publish_date VARCHAR(20) NOT NULL,
    din VARCHAR(20) NOT NULL,
    mas VARCHAR(50) NOT NULL,
    bochor VARCHAR(20) NOT NULL,
    tin_bokaya VARCHAR(50) NOT NULL,
    goto_bokaya VARCHAR(50) NOT NULL,
    bokayar_khoti VARCHAR(50) NOT NULL,
    hall_dabi VARCHAR(50) NOT NULL,
    mot_dabi VARCHAR(50) NOT NULL,
    mot_aday VARCHAR(50) NOT NULL,
    mot_bokaya VARCHAR(50) NOT NULL,
    montobo TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Create land_owners table
CREATE TABLE IF NOT EXISTS land_owners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    land_uid VARCHAR(36) NOT NULL,
    owner_name VARCHAR(255) NOT NULL,
    owner_share VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (land_uid) REFERENCES lands(uid) ON DELETE CASCADE
);

-- Create land_plots table
CREATE TABLE IF NOT EXISTS land_plots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    land_uid VARCHAR(36) NOT NULL,
    dag_no VARCHAR(100) NOT NULL,
    jomi_type VARCHAR(255) NOT NULL,
    jomi_poriman VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (land_uid) REFERENCES lands(uid) ON DELETE CASCADE
);

-- Create settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    value TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);

-- Insert default land_fee setting
INSERT INTO settings (name, value) VALUES ('land_fee', '100.00');
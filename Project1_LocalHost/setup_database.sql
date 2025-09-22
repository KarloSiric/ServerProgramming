-- EventHorizon Database Setup for Milestone 3
-- This script creates the database and users table with sample data

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS eventhorizon_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE eventhorizon_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- Insert sample users with hashed passwords
-- Note: These passwords are hashed versions of: admin123, user123, karlo123
INSERT INTO users (username, email, password_hash, name, role) VALUES
('admin', 'admin@eventhorizon.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('user', 'user@eventhorizon.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Event Attendee', 'user'),
('karlo', 'ks123@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Karlo', 'admin')
ON DUPLICATE KEY UPDATE 
    name = VALUES(name),
    role = VALUES(role),
    updated_at = CURRENT_TIMESTAMP;

-- Show the created data
SELECT 'Users table created successfully!' as status;
SELECT id, username, email, name, role, created_at FROM users;

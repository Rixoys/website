CREATE DATABASE forum;
USE forum;
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tarih DATE,
    saat TIME,
    isim VARCHAR(50),
    cinsiyet VARCHAR(10),
    sinif VARCHAR(20),
    mesaj TEXT
);

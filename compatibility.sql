-- Commands to make MySQL 8.0 compatible with MySQL 5.7
-- Run this script after creating the database and before creating the tables
CREATE USER 'adminmab'@'%' IDENTIFIED WITH mysql_native_password BY 'mab2024';
GRANT ALL PRIVILEGES ON *.* TO 'adminmab'@'%' WITH GRANT OPTION;
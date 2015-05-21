CREATE USER 'erruser'@'localhost' IDENTIFIED BY '';
GRANT INSERT ON db_nesselium.tblErrorlog TO 'erruser'@'localhost';
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS gyenyame;
USE gyenyame;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(50)
);

CREATE TABLE accounts (
  id INT PRIMARY KEY,
  name VARCHAR(50),
  balance INT
);

CREATE TABLE transactions (
  txn_id INT PRIMARY KEY,
  user_id INT,
  amount INT,
  note TEXT
);



INSERT INTO users (username, password) VALUES
('admin', 'admin123'),
('kwame', 'akwaaba123'),
('ama', 'goldcoast'),
('yaw', 'password1'),
('akua', 'sika123'),
('kofi', 'kofi321'),
('abena', 'ghana4life'),
('kojo', '123456'),
('adwoa', 'adwoa456'),
('yaw_mensah', 'mensahpass'),
('afia', 'kokroko'),
('efo_kwadzo', 'volta123'),
('nana_akosua', 'queen456'),
('kweku', 'ashanti1'),
('ama_serwaa', 'serwaa2025'),
('abena_yaa', 'yaaYaa!'),
('kojo_bonsu', 'bonsu007'),
('akua_mansa', 'mansa@GH'),
('yaw_kontoh', 'kontohPass'),
('afia_kuma', 'passAfia'),
('kwabena', 'kwabenaGH');
INSERT INTO accounts VALUES (1, 'Kwame Nkrumah', 5000), (2, 'Yaa Asantewaa', 7000);
INSERT INTO transactions (txn_id, user_id, amount, note) VALUES
(1001, 1, 200, 'Groceries'),
(1002, 1, 150, 'Fuel'),
(1003, 1, 500, 'Airtime Top-up'),
(1004, 1, 1200, 'Rent Payment'),
(1005, 1, 75, 'Transport - Trotro'),
(1006, 2, 300, 'Electricity Bill'),
(1007, 2, 50, 'Mobile Data'),
(1008, 2, 240, 'Food Delivery'),
(1009, 3, 100, 'Water Bill'),
(1010, 3, 1000, 'School Fees'),
(1011, 3, 60, 'Lotto'),
(1012, 3, 850, 'Hospital Visit'),
(1013, 4, 95, 'Lunch at KFC'),
(1014, 4, 40, 'Waakye Seller'),
(1015, 5, 150, 'Internet Subscription'),
(1016, 5, 600, 'Fuel (Total)'),
(1017, 5, 130, 'Momo Transfer'),
(1018, 5, 200, 'Pharmacy'),
(1019, 5, 450, 'Clothing at Makola'),
(1020, 5, 1500, 'Car Repair');

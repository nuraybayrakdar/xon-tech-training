CREATE DATABASE IF NOT EXISTS company;

USE company;

CREATE TABLE employee (
    employee_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255)NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    salary DECIMAL(10, 2)
);

INSERT INTO employee (first_name, last_name, email, salary) 
VALUES 
( 'Nuray', 'Bayrakdar', 'nuray@example.com', 50000.00),
('Ayşe', 'Keser', 'ayse@example.com', 60000.00),
( 'Murat', 'Guler', 'murat@example.com', 55000.00),
( 'Canan', 'Akkaya', 'canan@example.com', 52000.00),
( 'Kerem', 'Kose', 'kerem@example.com', 58000.00);

SELECT first_name, last_name FROM employee;

INSERT INTO employee ( first_name, last_name, email, salary) 
VALUES ('Gulten', 'Koca', 'sample@email.com', 65000.00);

UPDATE employee SET salary = 70000.00 WHERE email = 'sample@email.com';

DELETE FROM employee WHERE email = 'sample@email.com';

CREATE INDEX idx_email ON employee (email);

CREATE TABLE IF NOT EXISTS department (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(255)
);

ALTER TABLE employee 
ADD COLUMN department_id INT,
ADD CONSTRAINT fk_department_id 
    FOREIGN KEY (department_id) 
    REFERENCES department(department_id);


START TRANSACTION;
UPDATE employee SET salary = 75000.00 WHERE employee_id = 1;
COMMIT;
ROLLBACK;

-- Concurrency ve Isolation

-- Birden fazla kullanıcının aynı veriye erişmeye veya değiştirmeye çalışması söz konusu olduğunda
-- çakışmalar olabilir. Örneğin otobüs bileti satın alan iki kişi aynı koltuğu satın almak isteyebilir.
-- Concurrency bu çakışmaları yönetmek için kullanılır. Burada isolation devreye girer. Her processin kendi 
-- işini yapmasını sağlar. Process sadece kendi işini yapar ve diğer processlerin işine karışmaz. 
-- Isolation seviyeleri farklı processlerin birbirleriyle etkileşimini kontrol eder. Örneğin veri tutarlılığı 
-- için serializable, performance için read uncommitted kullanılabilir. Bilet rezerve ederken koltuğun satın 
-- alınmamış olması gerekir yani burada serializable kullanılabilir. Yada  e-ticaret sitesinde ürün stoklarının
-- güncel kalması için read uncommitted kullanılabilir. Hangi isolation seviyesi kullanılacağına karar verirken
-- ihtiyaçlar göz önünde bulundurulmalıdır. 
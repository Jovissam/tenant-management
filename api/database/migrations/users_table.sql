CREATE TABLE users(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    email VARCHAR(100),
    password VARCHAR(255),
    role VARCHAR(20),
    create_time DATETIME COMMENT 'Create Time'
) COMMENT '';
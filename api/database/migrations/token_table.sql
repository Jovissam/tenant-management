CREATE TABLE tokens(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    user_id INT,
    token VARCHAR(255),
    expiry INT,
    create_time DATETIME COMMENT 'Create Time'
) COMMENT '';
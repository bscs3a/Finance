CREATE TABLE tbl_fin_audit (
    id INT AUTO_INCREMENT,
    employee_name VARCHAR(50) NOT NULL,
    action varchar(50) NOT NULL,
    created_at timestamp,

    PRIMARY KEY(id)
);

INSERT INTO tbl_fin_audit (employee_name, action, created_at)
VALUES ('Tagle, Aries', 'Log in', current_timestamp());

INSERT INTO tbl_fin_audit (employee_name, action, created_at)
VALUES ('Tagle, Aries', 'Log out', current_timestamp());


SELECT * FROM tbl_fin_audit;
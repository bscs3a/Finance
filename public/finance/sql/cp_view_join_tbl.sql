-- Path: public/finance/sql/cp_view_join_tbl.sql
-- To View the the 3 table
SELECT lt.*, l.*, acct.*
FROM ledgertransaction as lt
JOIN ledger as l ON lt.ledgerno = l.ledgerno
JOIN accounttype as acct ON l.accounttype = acct.accounttype;

DROP TABLE IF EXISTS tbl_department;

CREATE TABLE tbl_department (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

INSERT INTO tbl_department (department_name)
VALUES ('Human Resource'),
('Delivery/Dispatcher'),
('Sales'),
('Product Order'),
('Inventory'),
('Finance/Accounting')
;

SELECT * FROM tbl_department;


CREATE TABLE tbl_record_per_department (
    record_per_department_id INT AUTO_INCREMENT PRIMARY KEY,
    fk_LedgerXactID INT NOT NULL,
    fk_department_id INT NOT NULL,

    FOREIGN KEY (fk_LedgerXactID) REFERENCES ledgertransaction(LedgerXactID),
    FOREIGN KEY (fk_department_id) REFERENCES tbl_department(department_id)

);


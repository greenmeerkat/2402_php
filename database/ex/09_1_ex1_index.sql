-- Index

-- Index 확인
SHOW INDEX FROM employees;

-- 0.078 초
SELECT * FROM employees WHERE first_name = 'Saniya';

-- Index 생성
ALTER TABLE employees ADD INDEX idx_employees_first_name (first_name);

-- Index 삭제
DROP INDEX idx_employees_first_name ON employees;



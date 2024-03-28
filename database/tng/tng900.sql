CREATE DATABASE test;
USE test;

CREATE TABLE users (
	id 			INT				PRIMARY KEY AUTO_INCREMENT
	,name			VARCHAR(50)		NOT NULL
	,email		VARCHAR(100)	NOT NULL UNIQUE
	,created_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,updated_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,deleted_at	DATE
);

CREATE TABLE boards (
	id 			INT				PRIMARY KEY AUTO_INCREMENT
	,user_id		INT				NOT NULL
	,title		VARCHAR(100)	NOT NULL
	,content		VARCHAR(1000)	NOT NULL
	,created_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,updated_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,deleted_at	DATE
);

CREATE TABLE wishlists (
	id 			INT				PRIMARY KEY AUTO_INCREMENT
	,user_id		INT				NOT NULL
	,board_id	INT				NOT NULL
	,created_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,updated_at	DATE				NOT NULL DEFAULT CURRENT_TIMESTAMP()
	,deleted_at	DATE
);

ALTER TABLE boards ADD CONSTRAINT fk_boards_user_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE wishlists ADD CONSTRAINT fk_wishlists_user_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE wishlists ADD CONSTRAINT fk_wishlists_board_id FOREIGN KEY (board_id) REFERENCES boards(id);

-- boards 테이블에 아래 컬럼을 추가
ALTER TABLE boards ADD COLUMN views INT NOT NULL DEFAULT 0;

-- users 테이블에 아래 3명의 정보를 작성
INSERT INTO users(name, email)
VALUES
('홍길동', 'hong@hong.com')
,('갑돌이', 'dol@dol.com')
,('갑순이', 'sun@sun.com');

-- boards 테이블에 아래 데이터 작성
INSERT INTO boards(user_id, title, content)
VALUES
(1, '길동이1', '길동이내용1')
,(1, '길동이2', '길동이내용2')
,(1, '길동이3', '길동이내용3')
,(1, '길동이4', '길동이내용4')
,(2, '갑돌이1', '갑돌이내용1')
,(2, '갑돌이2', '갑돌이내용2')
,(2, '갑돌이3', '갑돌이내용3')
,(3, '갑순이1', '갑순이내용1')
,(3, '갑순이2', '갑순이내용2');

-- wishlists 테이블에 아래 데이터 작성
INSERT INTO wishlists(user_id, board_id)
VALUES
(1, 5)
,(1, 8)
,(2, 4)
,(2, 1)
,(2, 3)
,(2, 9)
,(2, 6)
,(3, 1)
,(3, 2)
,(3, 3)
,(3, 4)
,(3, 5)
,(3, 6)
,(3, 7)
,(3, 8)
,(3, 9);


-- 홍길동 유저의 탈퇴 처리
UPDATE users SET deleted_at = NOW() WHERE id = 1;

-- users 테이블 모든 데이터 삭제
TRUNCATE TABLE users;

-- 모든 테이블 삭제
DROP TABLE users, boards, wishlists;


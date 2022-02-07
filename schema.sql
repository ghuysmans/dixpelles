CREATE TABLE language(
	iso639_1 CHAR(2) PRIMARY KEY,
	french VARCHAR(15) UNIQUE
);

CREATE TABLE user(
	id INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(50) UNIQUE NOT NULL,
	password VARCHAR(50) NOT NULL,
	admin BOOLEAN NOT NULL
);

CREATE TABLE mistranslation(
	id INT PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(50) NOT NULL,
	orig CHAR(2) NOT NULL,
	orig_text TINYTEXT NOT NULL,
	target CHAR(2) NOT NULL,
	target_text TINYTEXT NOT NULL,
	url VARCHAR(255) NOT NULL,
	submitted_by INT NOT NULL,
	ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (orig) REFERENCES language(iso639_1),
	FOREIGN KEY (target) REFERENCES language(iso639_1),
	FOREIGN KEY (submitted_by) REFERENCES user(id)
);

CREATE TABLE review(
	mistranslation INT,
	reviewer INT,
	review TINYTEXT NOT NULL,
	score TINYINT NOT NULL,
	PRIMARY KEY (mistranslation, reviewer),
	FOREIGN KEY (mistranslation) REFERENCES mistranslation(id),
	FOREIGN KEY (reviewer) REFERENCES user(id)
);

CREATE VIEW homepage AS
SELECT
	m.*,
	l1.french orig_french,
	l2.french target_french,
	r.reviewer,
	r.review,
	r.score
FROM mistranslation m
INNER JOIN language l1 ON l1.iso639_1=orig
INNER JOIN language l2 ON l2.iso639_1=target
LEFT JOIN review r ON r.mistranslation=m.id
ORDER BY id DESC;

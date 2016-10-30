DROP DATABASE IF EXISTS name_in_synonym;

CREATE DATABASE name_in_synonym
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_unicode_ci;

USE name_in_synonym;

CREATE TABLE languages(
	language_id INT AUTO_INCREMENT PRIMARY KEY ,
	language_name VARCHAR(255) UNIQUE
) ENGINE = INNODB;

CREATE table words(
	word_id INT AUTO_INCREMENT PRIMARY KEY,
	word VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
	language_id INT NOT NULL,
	UNIQUE (word, language_id),
	FOREIGN KEY (language_id) REFERENCES languages(language_id)
) ENGINE = INNODB;

CREATE TABLE pair (
	pair_id int AUTO_INCREMENT PRIMARY KEY,
	word_1 INT,
	word_2 INT,
	UNIQUE (word_1, word_2),
	FOREIGN KEY (word_1) REFERENCES words(word_id),
	FOREIGN KEY (word_2) REFERENCES words(word_id)	
) ENGINE = INNODB;

CREATE VIEW pairs AS
	SELECT p.pair_id,
		w1.word AS key_name,
		w1.word_id AS key_id,
		w2.word AS value_name,
		w2.word_id AS value_id,
		w1.language_id,
		0 AS flip
	FROM pair p
		INNER JOIN words w1 ON p.word_1 = w1.word_id
		INNER JOIN words w2 ON p.word_2 = w2.word_id
	UNION
	SELECT p.pair_id,
		w2.word,
		w2.word_id,
		w1.word,
		w1.word_id,
		w1.language_id,
		1 AS flip
	FROM pair p
		INNER JOIN words w1 ON p.word_1 = w1.word_id
		INNER JOIN words w2 ON p.word_2 = w2.word_id;

CREATE TABLE images(
	image_id INT AUTO_INCREMENT PRIMARY KEY,
	image_type INT NOT NULL,
	image_uri TEXT NOT NULL
) ENGINE=INNODB;

CREATE TABLE puzzle (
	puzzle_id INT AUTO_INCREMENT PRIMARY KEY,
	puzzle_solution VARCHAR(255) NOT NULL,
	puzzle_appearance INT NOT NULL,
	image_id INT,
	FOREIGN KEY (image_id) REFERENCES images(image_id)
) ENGINE=INNODB;

CREATE TABLE puzzle_line (
	puzzle_id INT NOT NULL,
	puzzle_line_order INT UNSIGNED NOT NULL,
	pair_id INT NOT NULL,
	puzzle_line_column INT UNSIGNED NOT NULL,
	PRIMARY KEY (puzzle_id, puzzle_line_order),
	FOREIGN KEY (puzzle_id) REFERENCES puzzle(puzzle_id)
) ENGINE=INNODB;

CREATE TABLE caption (
	caption_id int AUTO_INCREMENT PRIMARY KEY,
	image_id int,
	word VARCHAR(255),
	FOREIGN KEY (image_id) REFERENCES images(image_id),
	FOREIGN KEY (word) REFERENCES words(word)
) ENGINE=INNODB;

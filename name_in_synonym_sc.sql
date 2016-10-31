DROP DATABASE IF EXISTS name_in_synonym;

CREATE DATABASE name_in_synonym
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_unicode_ci;

USE name_in_synonym;

CREATE TABLE languages(
	language_id INT AUTO_INCREMENT PRIMARY KEY,
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
#FIXME need to varify image is unique to avoid multiple entries but TEXT cannot be in primary key spec.
	image_id INT AUTO_INCREMENT PRIMARY KEY,
	image_type INT NOT NULL,
	image_url VARCHAR(255) NOT NULL,
	UNIQUE (image_type, image_url)
) ENGINE=INNODB;

CREATE TABLE puzzle (
	puzzle_id INT AUTO_INCREMENT PRIMARY KEY,
	puzzle_solution VARCHAR(255) NOT NULL,
	puzzle_appearance INT NOT NULL,
	image_id INT,
	UNIQUE (puzzle_id, puzzle_solution),
	FOREIGN KEY (image_id) REFERENCES images(image_id)
) ENGINE=INNODB;

CREATE TABLE puzzle_line (
	puzzle_id INT NOT NULL,
	puzzle_line_order INT UNSIGNED NOT NULL,
	pair_id INT NOT NULL,
	puzzle_line_column INT UNSIGNED NOT NULL,
	puzzle_line_flip INT NOT NULL,
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

CREATE VIEW puzzles AS
  SELECT
		pz.puzzle_id,
		pz.puzzle_solution,
		pz.puzzle_appearance,
		w1.word AS word_1_name,
		l1.language_name AS word_1_language,
		w2.word AS word_2_name,
		l2.language_name AS word_2_language,
		i.image_url
	FROM
		puzzle_line
    INNER JOIN pairs AS pr ON puzzle_line.pair_id = pr.pair_id
    INNER JOIN words AS w1 ON pr.key_id = w1.word_id AND pr.flip = puzzle_line.puzzle_line_flip
    INNER JOIN words AS w2 ON pr.value_id = w2.word_id AND pr.flip = puzzle_line.puzzle_line_flip
		INNER JOIN puzzle AS pz ON puzzle_line.puzzle_id = pz.puzzle_id
		INNER JOIN images AS i ON pz.image_id = i.image_id
		INNER JOIN languages AS l1 ON w1.language_id = l1.language_id
		INNER JOIN languages AS l2 ON w2.language_id = l2.language_id;

DELIMITER //
CREATE PROCEDURE lookup (IN in_position INT, IN in_character CHAR(1), IN in_language_name VARCHAR(255))
	BEGIN
		SELECT pair_id,key_name,key_id,value_name,value_id,flip
		FROM (SELECT *
					FROM pairs
					WHERE key_name LIKE CONCAT(REPEAT( '_', in_position ), in_character, '%')
				 ) AS p
			INNER JOIN
			languages l ON l.language_name = in_language_name;
	END //
DELIMITER ;

/*
	add pair
*/
DELIMITER //
CREATE PROCEDURE add_pair (IN in_word_1 VARCHAR(255), IN in_word_2 VARCHAR(255), IN in_language_id INT)
/*
	FIXME add into word list, checking for duplicate words, check for duplicate pairs in both directions
*/
	BEGIN
		INSERT IGNORE INTO words (word, language_id)
			VALUE (in_word_1, in_language_id);

		INSERT IGNORE INTO words (word, language_id)
			VALUE (in_word_2, in_language_id);

		INSERT IGNORE INTO pair (word_1, word_2)
			VALUE ((SELECT words.word_id FROM words WHERE words.word = in_word_1),
						 (SELECT words.word_id FROM words WHERE words.word = in_word_1));
	END //
DELIMITER ;


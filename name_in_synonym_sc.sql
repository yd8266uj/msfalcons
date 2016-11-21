-- noinspection SqlNoDataSourceInspectionForFile
-- noinspection SqlDialectInspectionForFile
/*
DROP DATABASE IF EXISTS ics499fa160124;
CREATE DATABASE ics499fa160124;
*/

USE ics499fa160124;

CREATE TABLE languages(
  language_id INT AUTO_INCREMENT PRIMARY KEY,
  language_name VARCHAR(255) UNIQUE
) ENGINE = INNODB;

CREATE table word(
  word_id INT AUTO_INCREMENT PRIMARY KEY,
  language_id INT NOT NULL,
  FOREIGN KEY (language_id) REFERENCES languages(language_id)
) ENGINE = INNODB;

CREATE TABLE word_char(
  word_id INT,
  char_index INT,
  char_name VARCHAR(5),
  PRIMARY KEY (word_id,char_index),
  FOREIGN KEY (word_id) REFERENCES word(word_id)
) ENGINE = INNODB;

CREATE TABLE pair (
  pair_id int AUTO_INCREMENT PRIMARY KEY,
  word_1 INT,
  word_2 INT,
  UNIQUE (word_1, word_2),
  FOREIGN KEY (word_1) REFERENCES word(word_id),
  FOREIGN KEY (word_2) REFERENCES word(word_id)	
) ENGINE = INNODB;

CREATE VIEW words AS
  SELECT w.word_id,GROUP_CONCAT(wc.char_name ORDER BY wc.char_index ASC SEPARATOR '') AS word_name,w.language_id,count(*) AS length FROM word w
  JOIN word_char wc on wc.word_id = w.word_id
  JOIN languages l on w.language_id = l.language_id
  GROUP BY w.word_id,l.language_id;

CREATE VIEW pairs AS
  SELECT p.pair_id,w1.word_name AS key_name,w1.word_id AS key_id,w2.word_name AS value_name,w2.word_id AS value_id,w1.language_id AS language_id
  FROM pair p
  INNER JOIN words w1 ON p.word_1 = w1.word_id
  INNER JOIN words w2 ON p.word_2 = w2.word_id
    UNION
  SELECT p.pair_id,w2.word_name,w2.word_id,w1.word_name,w1.word_id,w1.language_id
  FROM pair p
  INNER JOIN words w1 ON p.word_1 = w1.word_id
  INNER JOIN words w2 ON p.word_2 = w2.word_id;
/*
CREATE TABLE images(
  #FIXME need to varify image is unique to avoid multiple entries but TEXT cannot be in primary key spec.
  image_id INT AUTO_INCREMENT PRIMARY KEY,
  image_type INT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  UNIQUE (image_type, image_url)
) ENGINE=INNODB;
*/
CREATE TABLE puzzle (
  puzzle_id VARCHAR(32) PRIMARY KEY,
  puzzle_solution VARCHAR(255) NOT NULL,
  puzzle_title VARCHAR(255) NOT NULL
) ENGINE=INNODB;

CREATE TABLE puzzle_line (
  puzzle_id VARCHAR(32) INT NOT NULL,
  puzzle_line_order INT UNSIGNED NOT NULL,
  pair_id INT NOT NULL,
  puzzle_line_column INT UNSIGNED NOT NULL,
  puzzle_line_flip INT NOT NULL,
  PRIMARY KEY (puzzle_id, puzzle_line_order),
  FOREIGN KEY (puzzle_id) REFERENCES puzzle(puzzle_id)
) ENGINE=INNODB;

CREATE VIEW puzzles AS SELECT
  pz.puzzle_id,
  pz.puzzle_solution,
  pz.puzzle_appearance,
  w1.word AS word_1_name,
  l1.language_name AS word_1_language,
  w2.word AS word_2_name,
  l2.language_name AS word_2_language,
  i.image_url
  FROM puzzle_line
  INNER JOIN pairs AS pr ON puzzle_line.pair_id = pr.pair_id
  INNER JOIN words AS w1 ON pr.key_id = w1.word_id AND pr.flip = puzzle_line.puzzle_line_flip
  INNER JOIN words AS w2 ON pr.value_id = w2.word_id AND pr.flip = puzzle_line.puzzle_line_flip
  INNER JOIN puzzle AS pz ON puzzle_line.puzzle_id = pz.puzzle_id
  INNER JOIN images AS i ON pz.image_id = i.image_id
  INNER JOIN languages AS l1 ON w1.language_id = l1.language_id
  INNER JOIN languages AS l2 ON w2.language_id = l2.language_id;


DELIMITER //

DROP FUNCTION IF EXISTS SPLIT_STRING//
CREATE FUNCTION SPLIT_STRING ( s VARCHAR(1024) charset utf8, i INT)
RETURNS VARCHAR(1024) charset utf8
DETERMINISTIC
BEGIN
  DECLARE n INT ;
  SET n = LENGTH(s) - LENGTH(REPLACE(s, ';', '')) + 1;
  IF i > n THEN
    RETURN NULL ;
  ELSE
    RETURN SUBSTRING_INDEX(SUBSTRING_INDEX(s, ';', i) , ';' , -1 ) ;        
  END IF;
END //

DROP PROCEDURE IF EXISTS add_word//
CREATE PROCEDURE add_word(IN in_chars VARCHAR(255) charset utf8, IN in_language VARCHAR(255), OUT out_word_id INT)
label:BEGIN
  DECLARE l_exists INT DEFAULT 0;
  DECLARE l_count INT DEFAULT 0;
  DECLARE l_count_max INT DEFAULT 0;  
  DECLARE l_index INT DEFAULT 0;  
  SELECT count(*),word_id INTO l_exists,out_word_id FROM words WHERE word_name = (SELECT REPLACE(in_chars,';','')) AND language_id = (SELECT language_id FROM languages WHERE language_name=in_language);
  IF l_exists > 0 THEN 
    LEAVE label;  
  END IF;  
  SELECT LENGTH(in_chars) - LENGTH(REPLACE(in_chars, ';', '')) + 1 INTO l_count_max;
  START TRANSACTION;
    INSERT INTO word (language_id) VALUES ((SELECT language_id FROM languages WHERE language_name=in_language));
    SET out_word_id = LAST_INSERT_ID();
    WHILE l_count < l_count_max DO
      INSERT INTO word_char VALUES (out_word_id,l_count,SPLIT_STRING(in_chars,l_count+1));
      SET l_count = l_count + 1;
    END WHILE;    
  COMMIT;
END label//

DROP PROCEDURE IF EXISTS add_pair//
CREATE PROCEDURE add_pair(IN in_word_1 VARCHAR(1024) charset utf8,IN in_word_2 VARCHAR(1024) charset utf8, IN in_language VARCHAR(255))
BEGIN
  DECLARE l_word_1_id INT DEFAULT 0;
  DECLARE l_word_2_id INT DEFAULT 0;
  DECLARE auto_increment_increment_old INT DEFAULT 1;
  CALL add_word(in_word_1,in_language,l_word_1_id);
  CALL add_word(in_word_2,in_language,l_word_2_id);
  SET auto_increment_increment_old=@@auto_increment_increment;
  SET @@auto_increment_increment=2;
  INSERT INTO pair (word_1,word_2) VALUES (l_word_1_id,l_word_2_id);  
  SET @@auto_increment_increment=auto_increment_increment_old;
END //

DROP PROCEDURE IF EXISTS find_word//
CREATE PROCEDURE find_word(IN in_char_name VARCHAR(5) charset utf8,IN in_char_index INT, IN in_language VARCHAR(255), IN in_min INT, IN in_max INT)
BEGIN
  SELECT w.word_id,word_name FROM (SELECT wc.word_id
  FROM word_char wc
  WHERE wc.char_name = in_char_name AND wc.char_index = in_char_index) AS wid
  JOIN words w on w.word_id = wid.word_id AND w.language_id = (SELECT language_id FROM languages WHERE language_name = in_language)
  WHERE w.length <= in_max AND w.length >= in_min;
END //

DELIMITER ;
		


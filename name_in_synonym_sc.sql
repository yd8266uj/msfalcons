DROP DATABASE IF EXISTS name_in_synonym;

CREATE DATABASE name_in_synonym;

USE name_in_synonym;

CREATE table words
(
	word_id INT auto_increment PRIMARY KEY,
	word VARCHAR(255) CHARACTER SET utf8 NOT NULL,
	word_language ENUM('english', 'hindi', 'telugu') NOT NULL,
	occurance INT UNSIGNED DEFAULT 0,
	UNIQUE (word, word_language)
) ENGINE = INNODB;

CREATE TABLE pairs (
  word_1 INT,
  word_2 INT,
  UNIQUE (word_1,word_2),
  PRIMARY KEY (word_1, word_2),
  FOREIGN KEY (word_1) REFERENCES words(word_id),
  FOREIGN KEY (word_2) REFERENCES words(word_id)	
) ENGINE = INNODB;
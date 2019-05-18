-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2018-10-13 22:41:51.181

-- tables
-- Table: responses
CREATE TABLE responses (
    id smallint unsigned NOT NULL AUTO_INCREMENT,
    answerDate date NOT NULL,
    name varchar(255) NOT NULL,
    summary text NOT NULL,
    content mediumtext NOT NULL,
    CONSTRAINT articles_pk PRIMARY KEY (id)
) COMMENT 'Table that logs all responses submitted.';

-- End of file.


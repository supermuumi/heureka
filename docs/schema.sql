######################################################################
# Heureka database schema
#
# The idea is to e.g. import this using phpMyAdmin. It creates the db
# and all necessary tables
#
# Author: Mikko Uromo (muumi@remedygames.com)
# Copyright (c) 2014 Remedy Entertainment
######################################################################

DROP DATABASE   heureka;
CREATE DATABASE heureka;
USE             heureka;

######################################################################
## tables
######################################################################

-- the main thing, an idea
CREATE TABLE idea
(
        id           INT NOT NULL AUTO_INCREMENT,

        summary      TEXT NOT NULL,
        details      TEXT NOT NULL,

        owner        INT NOT NULL,
        status       ENUM('open','archived') NOT NULL, -- todo more ideas

        created      DATETIME NOT NULL,
        last_updated DATETIME NOT NULL,

        PRIMARY KEY (id)
);

-- attachments for ideas, used for e.g. attaching concept art etc.
CREATE TABLE attachment
(
        id       INT NOT NULL AUTO_INCREMENT,
        idea_id  INT NOT NULL,
        filename VARCHAR(255) NOT NULL, 

        PRIMARY KEY (id)
);

-- comments on ideas, e.g. "this is great!"
CREATE TABLE comment
(
        comment_id INT NOT NULL AUTO_INCREMENT, -- unique id
        idea_id    INT NOT NULL,                -- which idea
        user_id    INT NOT NULL,                -- which user
        comment    TEXT NOT NULL,               -- comment
        timestamp  DATETIME NOT NULL,           -- when was the comment made

        PRIMARY KEY (comment_id)
);

-- vote on idea
CREATE TABLE vote
(
        idea_id INT NOT NULL,    -- which idea
        user_id INT NOT NULL,    -- who
        vote    TINYINT NOT NULL -- -1/+1
);

## user
## TODO hook to ldap or something
CREATE TABLE user
(
        id INT NOT NULL AUTO_INCREMENT,

        PRIMARY KEY (id)
);

######################################################################
## indices
######################################################################
CREATE UNIQUE INDEX vote_idea_user ON vote (idea_id, user_id);

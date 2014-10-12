BlogPHP
=======

Blog written in PHP using Slim Framework

-------

**Creating mysql database:**

CREATE TABLE IF NOT EXISTS post(
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    createdTime TIMESTAMP NOT NULL DEFAULT 0,
    updateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    content MEDIUMTEXT
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS comment(
    id   INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    createdTime TIMESTAMP NOT NULL DEFAULT 0,
    updateTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    post_id INT UNSIGNED NOT NULL,
    content TEXT,
    FOREIGN KEY (post_id) REFERENCES post(id) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    role VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-------

**Inserting into database:**

INSERT INTO post(title,createdTime,content) values("post title",CURRENT_TIMESTAMP(),"...text...");

INSERT INTO comment(name,createdTime,post_id,content) values("name",CURRENT_TIMESTAMP(),1,"...comment...");

--------

**Updating database records:**

UPDATE post SET  content="...text2..." WHERE id=1;
UPDATE comment SET  content="...comment..." WHERE id=1;

--------

Passwords for users must be stored as bcrypt hash in the database

--------
Deploying this app in Ubuntu 14.04:

*wget https://raw.githubusercontent.com/cristi92b/BlogPHP/master/ubuntu_14.04_deploy_lamp.sh*
*chmod +x ubuntu_14.04_deploy_lamp.sh*
*./ubuntu_14.04_deploy_lamp.sh*





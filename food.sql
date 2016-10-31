DROP TABLE IF EXISTS 'meals';

CREATE TABLE 'meals' (
'id' int(11) NOT NULL,
'name' varchar(45) NOT NULL,
'price' float NOT NULL DEFAULT '0',
'photo' varchar(45) NOT NULL,
'description' varchar(100) DEFAULT NULL,
'dateModified' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY('id')
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES 'meals' WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS 'users';

CREATE TABLE 'users'(
'user_email' varchar(80) NOT NULL,
'user_password' varchar(45) NOT NULL,
'email_token' varchar(16) DEFAULT NULL,
'isEmailConfirmed' int(1) NOT NULL DEFAULT '0',
'dateCreated' timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
)ENGINE = InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES 'users' WRITE;
UNLOCK TABLES;


DROP TABLE IF EXISTS USERS;

CREATE TABLE USERS (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  FIRSTNAME VARCHAR(255) NOT NULL,
  LASTNAME VARCHAR(255) NOT NULL,
  EMAIL VARCHAR(255) NOT NULL,
  USERNAME VARCHAR(255) NOT NULL,
  CREATE_AT DATETIME NOT NULL
);

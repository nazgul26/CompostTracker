CREATE TABLE users (
	`id` INT NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(32) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL DEFAULT '',
	`first_name` VARCHAR(64) NOT NULL DEFAULT '',
	`last_name` VARCHAR(64) NOT NULL DEFAULT '',
	`phone` VARCHAR(64) NULL,
	`access_level` INTEGER NOT NULL DEFAULT '0',
	`locked` TINYINT(1) NOT NULL DEFAULT 0,
	`reset_token` VARCHAR(255) NULL,
	`reset_time` DATETIME NULL,
	`language` VARCHAR(8) DEFAULT 'en' NOT NULL,
	`country` VARCHAR(8) DEFAULT 'us' NOT NULL,
	`last_login` DATE,
	`email` VARCHAR(64) NOT NULL UNIQUE,
	`created` DATETIME,
	`modified` DATETIME,
	`stripe_id` VARCHAR(255) NULL,
	`client_id` INT NULL REFERENCES clients(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`address_id` INT NULL REFERENCES address(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)
);

CREATE TABLE containers (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL,
	`gallons` INT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE clients ( 
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL DEFAULT '',
	`contact_name` VARCHAR(32) NOT NULL DEFAULT '',
	`contact_phone` VARCHAR(32) NOT NULL DEFAULT '',
	`contact_email` VARCHAR(120) NOT NULL DEFAULT '',
	PRIMARY KEY (id)
);

CREATE TABLE sites (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL DEFAULT '',
	`client_id` INT NOT NULL REFERENCES clients(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)	
);

CREATE TABLE locations (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL,
	`site_id` INT NOT NULL REFERENCES sites(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)
);

CREATE TABLE pickups (
	`id` INT NOT NULL AUTO_INCREMENT,
	`user_id` INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    `location_id` INT NULL REFERENCES locations(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    `pounds` FLOAT NOT NULL,
    `pickup_date` DATETIME,
	`note` VARCHAR(255) NULL,
	PRIMARY KEY (id)
);

CREATE TABLE locations_containers (
	`id` INT NOT NULL AUTO_INCREMENT,
	`location_id` INT NULL REFERENCES locations(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`container_id` INT NULL REFERENCES containers(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	PRIMARY KEY (id)
);

CREATE TABLE pickups_containers (
	`id` INT NOT NULL AUTO_INCREMENT,
	`pickup_id` INT NULL REFERENCES pickups(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`container_id` INT NULL REFERENCES containers(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`quantity` INT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE addresses (
	`id` INT NOT NULL AUTO_INCREMENT,
	`street1` VARCHAR(255) NOT NULL,
	`street2` VARCHAR(255) NULL,
	`city` VARCHAR(255) NOT NULL,
	`state` VARCHAR(2) NOT NULL,
	`zip` VARCHAR(5) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE collections (
	`id` INT NOT NULL AUTO_INCREMENT,
	`customer_user_id` INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
	`worker_user_id` INT NULL REFERENCES users(id) ON DELETE SET DEFAULT ON UPDATE CASCADE,
    `pounds` FLOAT NOT NULL,
    `pickup_date` DATETIME,
	`note` VARCHAR(255) NULL,
	PRIMARY KEY (id)
);


INSERT INTO containers (name, gallons) VALUES ('Toter', 5);
INSERT INTO containers (name, gallons) VALUES ('17 Gal', 17);
INSERT INTO containers (name, gallons) VALUES ('Small Trash', 32);
INSERT INTO containers (name, gallons) VALUES ('Large Trash', 64);

INSERT INTO clients (name, contact_name, contact_email) VALUES ('Phoenix Coffee', 'Jim', 'bob@phemail.com');
INSERT INTO sites (name, client_id) VALUES ('Lee Road', 1);
INSERT INTO locations (name, site_id) VALUES ('Default', 1);
INSERT INTO locations_containers (location_id, container_id) VALUES (1, 2);
INSERT INTO locations_containers (location_id, container_id) VALUES (1, 4);

INSERT INTO sites (name, client_id) VALUES ('Coventry', 2);
INSERT INTO locations (name, site_id) VALUES ('Default', 2);
INSERT INTO locations_containers (location_id, container_id) VALUES (2, 2);


INSERT INTO clients (name, contact_name, contact_email) VALUES ('Zagaras', 'John Zagara', 'john@zagaras.com');
INSERT INTO sites (name, client_id) VALUES ('Lee Road', 2);
INSERT INTO locations (name, site_id) VALUES ('Default', 3);


INSERT INTO locations_containers (location_id, container_id) VALUES (2, 2);
INSERT INTO locations_containers (location_id, container_id) VALUES (3, 2);


/* V2 Migration */
-- create addresses table --
ALTER TABLE users add `address_id` INT NULL REFERENCES addresses(id) ON DELETE SET DEFAULT ON UPDATE CASCADE;
ALTER TABLE users CHANGE COLUMN  `name` `first_name` VARCHAR(64) NOT NULL DEFAULT '';
ALTER TABLE users ADD `last_name` VARCHAR(64) NOT NULL DEFAULT '';
ALTER TABLE users ADD `phone` VARCHAR(64) NULL;
ALTER TABLE users ADD `stripe_id` VARCHAR(255) NULL;
-- create table collections
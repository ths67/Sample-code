-- TODO: Put ALL SQL in between `BEGIN TRANSACTION` and `COMMIT`
BEGIN TRANSACTION;

-- TODO: create tables

 CREATE TABLE 'images' (
   'id'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
 	 'img_name'TEXT NOT NULL UNIQUE,
   'extension'TEXT NOT NULL,
   'img_description'TEXT,
   'user_id'INTEGER NOT NULL
 );

-- TODO: FOR HASHED PASSWORDS, LEAVE A COMMENT WITH THE PLAIN TEXT PASSWORD!

--Source: All images taken by Tom Schreffler

INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (1, 'IMG_0345.jpg', 'jpg', 'We have arrived! It is late, but after a very relaxing private flight, we have arrived. Cannot wait to give a master class on social media with Mark. - Jack', 1);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (2, 'IMG_0638.jpg', 'jpg', 'Here is Ezra. He was an important figure in the founding of Cornell. I am looking forward to the master class I am giving with Jack. - Mark', 2);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (3, 'IMG_0470.png', 'png', 'Giving a master class to the Big Red football team. They need it. - Bill', 3);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (4, 'IMG_0531.jpg', 'jpg', 'The first part of my master class will be at Risley and the second part will be at the Music department - Kanye', 4);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (5, 'IMG_1095.jpg', 'jpg', 'Stopped by Bill and Melinda Gates Hall, where I will meet many bright students tomorrow. - Jack', 1);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (6, 'IMG_2957.jpg', 'jpg', 'Wandering around the Information Science department buildings at night is a pleasant experience, as will be meeting students from this department tomorrow.  - Mark', 2);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (7, 'IMG_7374.jpg', 'jpg', 'The players will be running up and down these steps repeatedly. Should be fun. - Bill', 3);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (8, 'IMG_1605.jpg', 'jpg', 'Came downtown to give an impromptu performance. Going to see the kids now - Kanye', 4);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (9, 'IMG_3942.jpg', 'jpg', 'The four of us have given our master classes and are now dining with some of the students. The weather here is unpredictable. - Bill', 3);
INSERT INTO images (id, img_name, extension, img_description, user_id) VALUES (10, 'IMG_7410.jpg', 'jpg', 'Until next time Cornell - Kanye', 4);

CREATE TABLE 'tags' (
   'id'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   'tag_name'TEXT NOT NULL UNIQUE
);

INSERT INTO tags (id, tag_name) VALUES (1, 'Cornell');
INSERT INTO tags (id, tag_name) VALUES (2, 'Central Campus');
INSERT INTO tags (id, tag_name) VALUES (3, 'North Campus');
INSERT INTO tags (id, tag_name) VALUES (4, 'West Campus');
INSERT INTO tags (id, tag_name) VALUES (5, 'East of campus');
INSERT INTO tags (id, tag_name) VALUES (6, 'social media master class');
INSERT INTO tags (id, tag_name) VALUES (7, 'football master class');
INSERT INTO tags (id, tag_name) VALUES (8, 'music master class');


CREATE TABLE 'visitors' (
   'id'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
   'first_name'TEXT NOT NULL,
   'last_name'TEXT NOT NULL,
   'user_name'TEXT NOT NULL UNIQUE,
   'password'TEXT NOT NULL
);

INSERT INTO visitors (id, first_name, last_name, user_name, password) VALUES (1, 'Jack', 'Dorsey', 'jack', '$2y$10$NPIIUvs3PgTShUwGrR0pKe6HrURtgUSJQWf/cbrxWD2YNwjj54vru'); --password: twitter
INSERT INTO visitors (id, first_name, last_name, user_name, password) VALUES (2, 'Mark', 'Zuckerberg', 'zuck', '$2y$10$RpcqQ6.w3cDJagTYL5Li2u2OuOSDWXkSLSjU0.tOkGO/O7Uzd2vn6'); --password: facebook
INSERT INTO visitors (id, first_name, last_name, user_name, password) VALUES (3, 'Bill', 'Belichick', 'gopats2019', '$2y$10$nMsPQKs5kmtGAITzRdoJLu9vIiQ0teRmvsuT2kPrwMyMEbcE7g9Oy'); --password: 6rings
INSERT INTO visitors (id, first_name, last_name, user_name, password) VALUES (4, 'Kanye', 'West', 'ye', '$2y$10$KuqUvXv9pIqb4uWtm.GhxuS5z4zWP0FF/5QigqJb8r/zMdYWDwbLW'); --password: music789

CREATE TABLE 'sessions' (
  'id'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'user_id'INTEGER NOT NULL,
  'session'TEXT NOT NULL UNIQUE
);

CREATE TABLE 'image_tags' (
  'id'INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'img_id'INTEGER NOT NULL,
  'tag_id'INTEGER NOT NULL,
  'user_id'INTEGER NOT NULL
);

INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (1, 1, 1, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (2, 1, 2, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (3, 1, 6, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (4, 2, 1, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (5, 2, 2, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (6, 2, 6, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (7, 3, 1, 3);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (8, 3, 5, 3);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (9, 3, 7, 3);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (10, 4, 1, 4);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (11, 4, 3, 4);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (12, 4, 8, 4);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (13, 5, 1, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (14, 5, 2, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (15, 5, 5, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (16, 5, 6, 1);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (17, 6, 1, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (18, 6, 2, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (19, 6, 6, 2);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (20, 7, 7, 3);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (21, 8, 8, 4);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (22, 9, 1, 3);
INSERT INTO image_tags (id, img_id, tag_id, user_id) VALUES (23, 9, 4, 3);

COMMIT;

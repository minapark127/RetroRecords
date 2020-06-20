Database: recordforum
creating 3 tables: categories, topics, posts

CREATE TABLE categories(
    categoryId INT NOT NULL AUTO_INCREMENT,
    categoryTitle VARCHAR(255) NOT NULL,
    categoryDesc VARCHAR(255),
    PRIMARY KEY (categoryId)
);
INSERT INTO categories (categoryTitle, categoryDesc) 
VALUES ('Artists', 'musicians and bands');
INSERT INTO categories (categoryTitle, categoryDesc) 
VALUES ('Records','anything about vinyl records');
INSERT INTO categories (categoryTitle, categoryDesc) 
VALUES ('Hardware','turntables, tonearms and amplifiers');

CREATE TABLE topics (
    topicId INT NOT NULL AUTO_INCREMENT,
    topicTitle VARCHAR(255) NOT NULL,
    topicTime DATETIME,
    topicOwner VARCHAR (255),
    categoryId INT NOT NULL,
    PRIMARY KEY (topicId),
    FOREIGN KEY (categoryId) REFERENCES categories(categoryId)
);

CREATE TABLE posts (
    postId INT NOT NULL AUTO_INCREMENT,
    postText VARCHAR(255) NOT NULL,
    postTime DATETIME,
    postOwner VARCHAR (255),
    topicId INT NOT NULL,
    PRIMARY KEY (postId),
    FOREIGN KEY (topicId) REFERENCES topics(topicId)
);


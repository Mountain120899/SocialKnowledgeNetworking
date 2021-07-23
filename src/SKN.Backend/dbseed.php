<?php
require 'bootstrap.php';

$statement = <<<EOS
create table IF NOT EXISTS `setting`(
    `setting_name` NVARCHAR(100) NOT NULL,
    `setting_value` NVARCHAR(100) NOT NULL
  );
  CREATE TABLE IF NOT EXISTS `User` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(255),
    `password` varchar(255),
    `full_name` nvarchar(255),
    `email` varchar(255),
    `yearofbirth` int,
    `created_at` timestamp
  );
  CREATE TABLE IF NOT EXISTS `Badge` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `point` int,
    `date` date,
    `user_id` int
  );
  CREATE TABLE IF NOT EXISTS `Question` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `title` nvarchar(255),
    `content` nvarchar(1000),
    `status` int,
    `user_id` int,
    `created_at` timestamp
  );
  CREATE TABLE IF NOT EXISTS `ReactQuestion` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `username` varchar(255),
    `question_id` int,
    `star` int COMMENT 'between 0 and 5',
    `is_like` boolean
  );
  CREATE TABLE IF NOT EXISTS `Tag` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `tag_name` nvarchar(255),
    `question_id` int
  );
  CREATE TABLE IF NOT EXISTS `Answer` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `full_content` nvarchar(1000),
    `status` int,
    `image_link` varchar(255),
    `question_id` int,
    `user_id` int,
    `created_at` timestamp
  );
  CREATE TABLE IF NOT EXISTS `Category` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `category_name` nvarchar(255)
  );
  CREATE TABLE IF NOT EXISTS `CategoryQuestion` (
    `id` int PRIMARY KEY AUTO_INCREMENT,
    `category_id` int,
    `question_id` int
  );
  ALTER TABLE
    `Badge`
  ADD
    FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
  ALTER TABLE
    `Question`
  ADD
    FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
    ALTER TABLE
    `Answer`
  ADD
    FOREIGN KEY (`user_id`) REFERENCES `User` (`id`);
  ALTER TABLE
    `ReactQuestion`
  ADD
    FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`);
  ALTER TABLE
    `Tag`
  ADD
    FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`);
  ALTER TABLE
    `Answer`
  ADD
    FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`);
  ALTER TABLE
    `CategoryQuestion`
  ADD
    FOREIGN KEY (`category_id`) REFERENCES `Category` (`id`);
  ALTER TABLE
    `CategoryQuestion`
  ADD
    FOREIGN KEY (`question_id`) REFERENCES `Question` (`id`);
    
    CREATE TABLE IF NOT EXISTS `Question` (
      `id` int PRIMARY KEY AUTO_INCREMENT,
      `title` nvarchar(255),
      `content` nvarchar(1000),
      `status` int,
      `user_id` int,
      `created_at` timestamp
  );
  
  ALTER TABLE Question AUTO_INCREMENT = 4;
  
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 1', 'Nội dung câu trả lời 1', null, null, 4, 2, '2021-05-13');
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 2', 'Nội dung câu trả lời 2', null, null, 4, 2, '2021-05-14');
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 3', 'Nội dung câu trả lời 3', null, null, 5, 2, '2021-05-15');
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 4', 'Nội dung câu trả lời 4', null, null, 5, 2, '2021-05-20');
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 5', 'Nội dung câu trả lời 5', null, null, 5, 2, '2021-05-21');
  insert into answer(shorten_content, full_content, status, image_link, question_id, user_id, created_at) values ('Câu trả lời 6', 'Nội dung câu trả lời 6', null, null, 6, 2, '2021-05-22');
  
  insert into user(username, password, full_name, email, yearofbirth, created_at) values ('David', '123456', 'David', 'David@gmail.com', 2000, '2021-05-01');
  
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 4', 'Đây là nội dung câu hỏi số 4', null, 1, '2021-05-12');
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 5', 'Đây là nội dung câu hỏi số 5', null, 1, '2021-05-12');
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 6', 'Đây là nội dung câu hỏi số 6', null, 2, '2021-05-12');
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 7', 'Đây là nội dung câu hỏi số 7', null, 2, '2021-05-12');
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 8', 'Đây là nội dung câu hỏi số 8', null, 2, '2021-05-12');
  insert into question(title, content, status, user_id, created_at) values ('Đây là tiêu đề câu hỏi số 9', 'Đây là nội dung câu hỏi số 9', null, 1, '2021-04-12');
  
  insert into reactquestion(username, question_id, star, is_like) values
  ('Mountain', 6, 0, 1),('Mountain', 7, 0, 1), ('Mountain', 8, 0, 1), ('Mountain', 9, 0, 1), ('Mountain', 10, 0, 1), ('David', 5, 0, 1);
  
  insert into category(category_name) values ('Tất cả'), ('Thể thao'), ('Thời tiết'), ('Xã hội'), ('Thời trang'), ('Chính trị');
  
  insert into categoryquestion(category_id, question_id) values (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11), (1, 12), (2, 4), (3, 5), (4, 6), (5, 7), (6, 8), (2, 9), (3, 10), (4, 11), (5, 12);
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}
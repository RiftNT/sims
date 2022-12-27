-- student1@mail.com : user123
-- prof@mail.com : prof123
-- admin@mail.com : admin123

DROP DATABASE IF EXISTS hogwarts_academic_module;
CREATE DATABASE hogwarts_academic_module;

CREATE TABLE `users`(
    `userID` INT NOT NULL AUTO_INCREMENT,
    `fname` VARCHAR(50) NOT NULL,
    `mname` VARCHAR(50) NOT NULL,
    `lname` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `user_type` ENUM('student', 'professor', 'admin') NOT NULL DEFAULT 'student',
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`userID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `student`(
    `studentID` INT NOT NULL AUTO_INCREMENT,
    `userID` INT NOT NULL,
    `year_level` ENUM('1','2','3','4','5') NOT NULL DEFAULT '1',
    `house` ENUM('Gryffindor', 'Hufflepuff', 'Ravenclaw', 'Slytherin') NOT NULL,
    -- `deleted` ENUM('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY(`studentID`),
    FOREIGN KEY(`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `subject`(
    `subjectID` INT NOT NULL AUTO_INCREMENT,
    `subject_name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(150) NOT NULL,
    -- `deleted` ENUM('0','1') NOT NULL DEFAULT '0',
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(`subjectID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `professor`(
    `professorID` INT NOT NULL AUTO_INCREMENT,
    `userID` INT NOT NULL,
    `subjectID` INT NOT NULL,
    PRIMARY KEY(`professorID`),
    FOREIGN KEY(`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
    FOREIGN KEY(`subjectID`) REFERENCES `subject` (`subjectID`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `enrolled`(
    `enrolledID` INT NOT NULL AUTO_INCREMENT,
    `studentID` INT NOT NULL,
    `professorID` INT NOT NULL,
    `dropped` ENUM('0','1') NOT NULL DEFAULT '0',
    `date_enrolled` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(`enrolledID`),
    FOREIGN KEY(`studentID`) REFERENCES `student` (`studentID`) ON DELETE CASCADE,
    FOREIGN KEY(`professorID`) REFERENCES `professor` (`professorID`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `grades`(
    `gradeID` INT NOT NULL AUTO_INCREMENT,
    `enrolledID` INT NOT NULL,
    `midtermGrade` INT,
    `finalGrade` INT,
    `date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(`gradeID`),
    FOREIGN KEY(`enrolledID`) REFERENCES `enrolled` (`enrolledID`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users(fname, mname, lname, email, password, user_type) VALUES
('Student', 'Studa', 'Doe', 'student1@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studb', 'Doe', 'student2@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studc', 'Doe', 'student3@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studd', 'Doe', 'student4@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Stude', 'Doe', 'student5@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studf', 'Doe', 'student6@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studg', 'Doe', 'student7@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studh', 'Doe', 'student8@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studi', 'Doe', 'student9@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studj', 'Doe', 'student10@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studk', 'Doe', 'student11@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studl', 'Doe', 'student12@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studm', 'Doe', 'student13@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studn', 'Doe', 'student14@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studo', 'Doe', 'student15@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studp', 'Doe', 'student16@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studq', 'Doe', 'student17@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studr', 'Doe', 'student18@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studs', 'Doe', 'student19@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Student', 'Studt', 'Doe', 'student20@mail.com', '$2y$10$VB2bnembPmg6j2cdXfKXAu0dLs8.KT/cNZ7/Naw1KvPkH5v5L69Gi', 1),
('Professor', 'Profa', 'Doe', 'prof1@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profb', 'Doe', 'prof2@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profc', 'Doe', 'prof3@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profd', 'Doe', 'prof4@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profe', 'Doe', 'prof5@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Proff', 'Doe', 'prof6@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profg', 'Doe', 'prof7@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profh', 'Doe', 'prof8@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profi', 'Doe', 'prof9@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Professor', 'Profj', 'Doe', 'prof10@mail.com', '$2y$10$RCSd5LKLdk/BmH8ked7BfeDit9gCEHsLEp70BERbYwLxX.grP89QG', 2),
('Admin', 'Admina', 'Doe', 'admin1@mail.com', '$2y$10$XfpWmegItPpimo/QVyjrnezJxW9iq/GLH7rl2KG7g1ohmZrrnf2Gi', 3),
('Admin', 'Adminb', 'Doe', 'admin2@mail.com', '$2y$10$XfpWmegItPpimo/QVyjrnezJxW9iq/GLH7rl2KG7g1ohmZrrnf2Gi', 3),
('Admin', 'Adminc', 'Doe', 'admin3@mail.com', '$2y$10$XfpWmegItPpimo/QVyjrnezJxW9iq/GLH7rl2KG7g1ohmZrrnf2Gi', 3),
('Admin', 'Admind', 'Doe', 'admin4@mail.com', '$2y$10$XfpWmegItPpimo/QVyjrnezJxW9iq/GLH7rl2KG7g1ohmZrrnf2Gi', 3),
('Admin', 'Admine', 'Doe', 'admin5@mail.com', '$2y$10$XfpWmegItPpimo/QVyjrnezJxW9iq/GLH7rl2KG7g1ohmZrrnf2Gi', 3);

INSERT INTO student (userID, year_level, house) VALUES
(1, 1, 1),(2, 2, 2),(3, 3, 3),(4, 4, 4),(5, 5, 1),(6, 1, 2),(7, 2, 3),(8, 3, 4),(9, 4, 1),(10, 5, 2),
(11, 1, 1),(12, 2, 2),(13, 3, 3),(14, 4, 4),(15, 5, 1),(16, 1, 2),(17, 2, 3),(18, 3, 4),(19, 4, 1),(20, 5, 2);

INSERT INTO subject (subject_name, description) VALUES
("Astronomy", "Astronomy was the branch of magic and science that studied stars and the movement of planets."),
("Charms", "A charm, also known as an Enchantment, a spell that added certain properties to an object or individual."),
("Dark Arts", "The Dark Arts commonly referred to spells and actions that could be used to harm others, ranging from the powerful Unforgivable Curses, to brewing harmful or poisonous potions and breeding dark creatures."),
("Deference Against Dark Arts", "Students studied and learnt how to defend themselves against all aspects of the Dark Arts"),
("Herbology", "Herbology is the study of magical and mundane plants and fungi, making it the wizarding equivalent to botany."),
("History of Magic", "This class is a study of magical history."),
("Potions", "Potions is described as the art of creating mixtures with magical effects. It required the correct mixing and stirring of ingredients at the right times and temperatures."),
("Transfigurations", "Transfiguration is the art of changing the form or appearance of an object."),
("Arithmancy", "A branch of magic concerned with the magical properties of numbers."),
("Care of Magical Creatures", "A class which instructs students on how to care for magical beasts.");

INSERT INTO professor (userID, subjectID) VALUES
(21, 1),(22, 2),(23, 3),(24, 4),(25, 5),(26, 6),(27, 7),(28, 8),(29, 9),(30, 10);

INSERT INTO enrolled (studentID, professorID) VALUES
(1, 1),(2, 1),(3, 1),(4, 1),(5, 1),(1, 2),(2, 2),(3, 2),(4, 2),(5, 2),(6, 3),(7, 3),
(8, 3),(9, 3),(10,3 ),(6, 4),(7, 4),(8, 4),(9, 4),(10,4 ),(11, 5),(12, 5),(13, 5),(14, 5),
(15, 5),(11, 6),(12, 6),(13, 6),(14, 6),(15, 6),(16, 7),(17, 7),(18, 7),(19, 7),(20, 7),
(16, 8),(17, 8),(18, 8),(19, 8),(20, 8),(1, 9),(2, 9),(3, 9),(4, 9),(5, 9),(1, 10),(2, 10),
(3, 10),(4, 10),(5, 10),(6, 1),(7, 1),(8, 1),(9, 1),(10,1 ),(6, 2),(7, 2),(8, 2),(9, 2),
(10,2 ),(11, 3),(12, 3),(13, 3),(14, 3),(15, 3),(11, 4),(12, 4),(13, 4),(14, 4),(15, 4),
(16, 5),(17, 5),(18, 5),(19, 5),(20, 5),(16, 6),(17, 6),(18, 6),(19, 6),(20, 6),(1, 7),(2, 7),
(3, 7),(4, 7),(5, 7),(6, 8),(7, 8),(8, 8),(9, 8),(10,8 ),(11, 9),(12, 9),(13, 9),(14, 9),(15, 9),
(16, 10),(17, 10),(18, 10),(19, 10),(20, 10);

INSERT INTO grades (enrolledID, midtermGrade, finalGrade) VALUES
(1,2,NULL),(2,3,NULL),(3,3,NULL),(4,1,NULL),(5,1,NULL),(6,2,NULL),(7,3,NULL),(8,2,NULL),(9,3,NULL),
(10,3,NULL),(11,4,NULL),(12,4,NULL),(13,5,NULL),(14,2,NULL),(15,1,NULL),(16,2,NULL),(17,3,NULL),
(18,2,NULL),(19,2,NULL),(20,3,NULL),(21,4,NULL),(22,5,NULL),(23,1,NULL),(24,2,NULL),(25,3,NULL),
(26,3,NULL),(27,2,NULL),(28,2,NULL),(29,2,NULL),(30,2,NULL),(31,2,NULL),(32,2,NULL),(33,3,NULL),
(34,4,NULL),(35,5,NULL),(36,1,NULL),(37,1,NULL),(38,1,NULL),(39,2,NULL),(40,3,NULL),(41,4,NULL),
(42,5,NULL),(43,1,NULL),(44,2,NULL),(45,3,NULL),(46,4,NULL),(47,2,NULL),(48,3,NULL),(49,3,NULL),
(50,2,NULL),(51,1,NULL),(52,2,NULL),(53,4,NULL),(54,3,NULL),(55,2,NULL),(56,3,NULL),(57,2,NULL),
(58,2,NULL),(59,2,NULL),(60,1,NULL),(61,1,NULL),(62,2,NULL),(63,3,NULL),(64,4,NULL),(65,5,NULL),
(66,2,NULL),(67,3,NULL),(68,3,NULL),(69,3,NULL),(70,2,NULL),(71,3,NULL),(72,3,NULL),(73,3,NULL),
(74,4,NULL),(75,4,NULL),(76,5,NULL),(77,2,NULL),(78,2,NULL),(79,1,NULL),(80,2,NULL),(81,3,NULL),
(82,2,NULL),(83,3,NULL),(84,2,NULL),(85,1,NULL),(86,2,NULL),(87,3,NULL),(88,4,NULL),(89,2,NULL),
(90,3,NULL),(91,4,NULL),(92,2,NULL),(93,5,NULL),(94,2,NULL),(95,3,NULL),(96,2,NULL),(97,1,NULL),
(98,2,NULL),(99,3,NULL),(100,3,NULL);

-- student1@mail.com : user123
-- prof1@mail.com : prof123
-- admin@mail.com : admin123
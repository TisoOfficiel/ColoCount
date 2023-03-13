/* Création de la table `users` */
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
    `user_id`       integer NOT NULL AUTO_INCREMENT,
    `username` varchar(40),
    `email`    varchar(40),
    `password` varchar(255) NOT NULL,
    `created_at`  datetime DEFAULT NULL,
    `updated_at`  datetime DEFAULT NULL,
    PRIMARY KEY (`user_id`)
    );

/* Insertion d'un utilisateur avec le role admin dans la table `Users`*/
INSERT INTO `users` (`user_id`, `username`, `email`, `password`,`created_at`,`updated_at`) VALUES
    (1, 'Admin', 'Admin@gmail.com', '$2y$10$OgGilVcpTrARPRsrx8YZf.GRCGW3EAugei7htlwYaGDdbROVRY2pu','2023-01-11 14:15:24', '2023-01-11 14:15:24');
INSERT INTO `users` (`user_id`, `username`, `email`, `password`,`created_at`,`updated_at`) VALUES
    (2, 'Romain', 'Romain@gmail.com', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6NCwidXNlcm5hbWUiOiJyb21haW4iLCJleHAiOjE2NzM1MTMyODJ9.ChfOhQ7Q1XSzPlURQX53j_qCBj19Byqr-qrMLSmUNL8','2023-01-12 09:15:24', '2023-01-12 09:15:24');
INSERT INTO `users` (`user_id`, `username`, `email`, `password`,`created_at`,`updated_at`) VALUES
    (3, 'Herby', 'herby@gmail.com', 'herby','2023-01-12 09:15:24', '2023-01-12 09:15:24');
INSERT INTO `users` (`user_id`, `username`, `email`, `password`,`created_at`,`updated_at`) VALUES
    (4, 'Tete', 'tete@gmail.com', 'tete','2023-01-12 09:15:24', '2023-01-12 09:15:24');



/* Création de la table `colocation` */
DROP TABLE IF EXISTS `colocation`;
CREATE TABLE IF NOT EXISTS `colocation` (
    `colocation_id`          integer(11) NOT NULL AUTO_INCREMENT,
    `colocation_name`         varchar(255) NOT NULL,
    `description` varchar(255),
    `created_at`  datetime DEFAULT NULL,
    `updated_at`  datetime DEFAULT NULL,
    PRIMARY KEY (`colocation_id`)
);

/* Insertion d'une colocation dans la table `colocation` */
INSERT INTO `colocation` (`colocation_id`,`colocation_name`,`description`,`created_at`,`updated_at`) VALUES
    (1,'LaColoc','Une coloc pour ! tous pour la coloc','2023-01-11 11:19:14','2023-01-11 11:19:14');
INSERT INTO `colocation` (`colocation_id`,`colocation_name`,`description`,`created_at`,`updated_at`) VALUES
    (2,'LaColoc2','Une coloc Abérrante','2023-01-11 11:19:14','2023-01-11 11:19:14');



/* Création de la table `colocation_user` */
DROP TABLE IF EXISTS `colocation_user`;
CREATE TABLE IF NOT EXISTS `colocation_user` (
    `id` integer(11) NOT NULL AUTO_INCREMENT,
    `colocation_id` integer(11) NOT NULL,
    `user_id` integer(11) NOT NULL,
    `amount` varchar(20) NOT NULL,
    `role` ENUM ('admin', 'user') DEFAULT 'user',
    PRIMARY KEY (`id`),
    FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY(`colocation_id`) REFERENCES `colocation`(`colocation_id`) ON DELETE CASCADE
);


/* Insertion d'un colocation_user du compte Admin dans la table `colocation_user` */
-- ADMIN
INSERT INTO `colocation_user` (`user_id`,`colocation_id`, `amount`, `role`) VALUES
    (1,1,50,'admin');
-- ROMAIN
INSERT INTO `colocation_user` (`user_id`,`colocation_id`, `amount`, `role`) VALUES
    (2,1,-50,'user');
-- HERBY
INSERT INTO `colocation_user` (`user_id`,`colocation_id`, `amount`, `role`) VALUES
    (3,1,0,'user');
-- TETE 
INSERT INTO `colocation_user` (`user_id`,`colocation_id`, `amount`, `role`) VALUES
    (4,1,0,'user');


-- ------

INSERT INTO `colocation_user` (`user_id`,`colocation_id`, `amount`, `role`) VALUES
    (1,2,0,'admin');

/* Création de la table `charges` */
DROP TABLE IF EXISTS `charge`;
CREATE TABLE IF NOT EXISTS `charge` (
    `charge_id`            integer NOT NULL AUTO_INCREMENT,
    `name`          varchar(20) NOT NULL,
    `charge_amount`        float NOT NULL,
    `type`          ENUM ('depense', 'remboursement') DEFAULT 'depense',
    `category`      varchar(20) NOT NULL,
    `created_at`    datetime,
    `updated_at`    datetime,
    PRIMARY KEY(`charge_id`)
);

INSERT INTO `charge` (`charge_id`,`name`,`charge_amount`,`type`,`category`,`created_at`,`updated_at`) VALUES
    (1,"Courses",100,'depense','course','2023-01-13 10:12:24','2023-01-13 10:12:24');

-- INSERT INTO `charge` (`charge_id`,`name`,`charge_amount`,`type`,`category`,`created_at`,`updated_at`) VALUES
--     (2,"Loyer",100,'depense','loyer','2023-01-14 10:12:24','2023-01-14 10:12:24');
-- INSERT INTO `charge` (`charge_id`,`name`,`charge_amount`,`type`,`category`,`created_at`,`updated_at`) VALUES
--     (3,"Autre",30,'depense','loyer','2023-01-14 10:12:24','2023-01-14 10:12:24');
-- INSERT INTO `charge` (`charge_id`,`name`,`charge_amount`,`type`,`category`,`created_at`,`updated_at`) VALUES
--     (4,"Autre2",40,'depense','course','2023-01-14 10:12:24','2023-01-14 10:12:24');
-- INSERT INTO `charge` (`charge_id`,`name`,`charge_amount`,`type`,`category`,`created_at`,`updated_at`) VALUES
--     (5,"Autre3",832,'depense','toto','2023-01-14 10:12:24','2023-01-14 10:12:24');


/* Création de la table `charge_user` */
DROP TABLE IF EXISTS `charge_user`;
CREATE TABLE IF NOT EXISTS `charge_user` (
    `id` integer(11) NOT NULL AUTO_INCREMENT,
    `user_id` integer(11) NOT NULL,
    `charge_username` varchar (30) NOT NULL,
    `charge_id` integer(11) NOT NULL,
    `colocation_id` integer(11) NOT NULL,
    `role_charge` ENUM('paymaster','participant','paymaster_participant') DEFAULT 'paymaster',
    PRIMARY KEY (`id`),
    FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY(`colocation_id`) REFERENCES `colocation`(`colocation_id`) ON DELETE CASCADE,
    FOREIGN KEY(`charge_id`) REFERENCES `charge`(`charge_id`) ON DELETE CASCADE
);

INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
    (1,'Admin',1,1,'paymaster_participant');

INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
    (2,'Romain',1,1,'participant');

-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (1,'Admin',2,1,'participant');

-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (2,'Romain',2,1,'paymaster_participant');


DROP TABLE IF EXISTS `invitation_coloc`;
CREATE TABLE IF NOT EXISTS `invitation_coloc` (
    `id` integer(11) NOT NULL AUTO_INCREMENT,
    `user_id` integer(11) NOT NULL,
    `colocation_id` integer(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY(`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
    FOREIGN KEY(`colocation_id`) REFERENCES `colocation`(`colocation_id`) ON DELETE CASCADE
);

-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (1,'Admin',2,1,'paymaster_participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (2,'Romain',2,1,'participant');

-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (1,'Admin',3,1,'participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (2,'Romain',3,1,'paymaster_participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (3,'Herby',3,1,'participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (2,'Romain',4,1,'paymaster_participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (3,'Herby',4,1,'participant');

-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (2,'Romain',5,1,'participant');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (3,'Herby',5,1,'paymaster');
-- INSERT INTO `charge_user` (`user_id`,`charge_username`,`charge_id`,`colocation_id`,`role_charge`) VALUES
--     (4,'Tete',5,1,'participant');




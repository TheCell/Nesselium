-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblErrorlog`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblErrorlog` (`PK_errorlog`, `time`, `type`, `errormsg`, `file`, `row`) VALUES (1, '2015-07-05 16:00:57 	', 8, 'Undefined index: REMOTE_ADR', 'C:\\xampp\\htdocs\\nesselium\\include\\dbConnect.php', 61);

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblLanguage`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblLanguage` (`PK_language`, `locale`, `languageName`) VALUES (1, 'en_US', 'English - English');
INSERT INTO `db_nesselium`.`tblLanguage` (`PK_language`, `locale`, `languageName`) VALUES (2, 'de_DE', 'German - German');

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblCategory`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblCategory` (`PK_category`, `name`) VALUES (1, 'default');

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblTags`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblTags` (`PK_Tag`, `tagName`) VALUES (1, 'development');

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblUserType`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (1, 'Globaladmin');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (2, 'Administrator');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (3, 'Webmaster');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (4, 'Author');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (5, 'Writer');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (6, 'Translator');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (7, 'User');
INSERT INTO `db_nesselium`.`tblUserType` (`PK_userType`, `name`) VALUES (8, 'Guest');

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblUser`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblUser` (`PK_user`, `username`, `email`, `password`, `salt`, `createTime`, `firstname`, `lastname`, `birthday`, `lastLogin`, `ipAddressV4`, `ipAddressV6`, `FK_usertype`, `FK_language`) VALUES (1, 'testuser1', 'test@test.ch', '4965c7bf3ff0f85bf0e654a4ee05fc1eb0e927cb7e6fc24d4b3f7c315c6b614edacc7196bbac19ae20ea2a8921d8e40957d16bb650bbaf00d52c21cab5708fcc ', '9c39cefefb2b01c860263de248a8208641365d92fdd92f2f1120f68aaa42b3a65d7ee8d9ad13a9d5be14eae99756280266d1583d7650989b95800b719e9e2366', '2015-05-24 15:02:00', 'test', 'user', '2015-05-24', '2015-05-24 15:02:30', NULL, NULL, 1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblLoginAttempt`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblLoginAttempt` (`PK_loginDate`, `isSuccessfull`, `loginTime`, `ipAddressV4`, `ipAddressV6`, `FK_user`) VALUES (1, 1, '2015-07-05 16:01:09', 123, NULL, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblArticle`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblArticle` (`PK_article`, `text`, `FK_category`, `internalComment`, `releaseDate`, `createDate`, `FK_user`, `FK_language`, `FK_userType_viewableBy`) VALUES (1, 'SQL injection <script>alert(\"that was easy\");</script>', 1, 'testing only', '2015-07-05 16:01:09', '2015-07-05 16:01:09', 1, 1, 4);

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblArticle_has_tblTags`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblArticle_has_tblTags` (`tblArticle_PK_article`, `tblTags_PK_Tag`) VALUES (1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `db_nesselium`.`tblEditLog`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_nesselium`;
INSERT INTO `db_nesselium`.`tblEditLog` (`PK_edit`, `time`, `FK_user`, `FK_article`) VALUES (1, '2015-07-05 16:01:09', 1, 1);

COMMIT;
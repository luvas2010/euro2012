SET foreign_key_checks = 0;
#
# TABLE STRUCTURE FOR: matches
#

DROP TABLE IF EXISTS matches;

CREATE TABLE `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_name` varchar(255) NOT NULL,
  `match_number` int(10) unsigned NOT NULL,
  `home_id` int(10) unsigned NOT NULL,
  `away_id` int(10) unsigned NOT NULL,
  `venue_id` int(10) unsigned NOT NULL,
  `match_time` datetime NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `home_goals` int(10) unsigned DEFAULT NULL,
  `away_goals` int(10) unsigned DEFAULT NULL,
  `red_cards` int(10) unsigned DEFAULT NULL,
  `yellow_cards` int(10) unsigned DEFAULT NULL,
  `match_group` varchar(255) NOT NULL,
  `group_home` varchar(255) NOT NULL,
  `group_away` varchar(255) NOT NULL,
  `time_close` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `home_id_idx` (`home_id`),
  KEY `away_id_idx` (`away_id`),
  KEY `match_number_idx` (`match_number`),
  KEY `venue_id_idx` (`venue_id`),
  CONSTRAINT `matches_away_id_teams_team_id_away` FOREIGN KEY (`away_id`) REFERENCES `teams` (`team_id_away`),
  CONSTRAINT `matches_home_id_teams_team_id_home` FOREIGN KEY (`home_id`) REFERENCES `teams` (`team_id_home`),
  CONSTRAINT `matches_venue_id_venues_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (1, 'Group A Match 1', 11, 1, 2, 3, '2012-06-08 18:00:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-08 18:00:00', 'A1-A2');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (2, 'Group A Match 2', 12, 3, 4, 4, '2012-06-08 20:45:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-08 20:45:00', 'A3-A4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (3, 'Group B Match 1', 21, 5, 6, 6, '2012-06-09 18:00:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-09 18:00:00', 'B1-B2');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (4, 'Group B Match 2', 22, 7, 8, 8, '2012-06-09 19:45:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-09 19:45:00', 'B3-B4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (5, 'Group C Match 1', 31, 9, 10, 1, '2012-06-10 18:00:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-10 18:00:00', 'C1-C2');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (6, 'Group C Match 2', 32, 11, 12, 2, '2012-06-10 20:45:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-10 20:45:00', 'C3-C4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (7, 'Group D Match 1', 41, 15, 16, 5, '2012-06-11 18:00:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-11 18:00:00', 'D3-D4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (8, 'Group D Match 2', 42, 13, 14, 7, '2012-06-11 20:45:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-11 20:45:00', 'D1-D2');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (9, 'Group A Match 3', 13, 2, 4, 4, '2012-06-12 18:00:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-12 16:00:00', 'A2-A4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (10, 'Group A Match 4', 14, 1, 3, 3, '2012-06-12 20:45:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-12 20:45:00', 'A1-A3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (11, 'Group B Match 3', 23, 5, 7, 6, '2012-06-13 18:00:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-13 18:00:00', 'B1-B3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (12, 'Group B Match 4', 24, 6, 8, 8, '2012-06-13 18:00:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-13 18:00:00', 'B2-B4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (13, 'Group C Match 3', 33, 10, 12, 7, '2012-06-14 18:00:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-14 18:00:00', 'C2-C4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (14, 'Group C Match 4', 34, 9, 11, 1, '2012-06-14 20:45:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-14 20:45:00', 'C1-C3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (15, 'Group D Match 3', 43, 14, 16, 7, '2012-06-15 18:00:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-15 18:00:00', 'D2-D4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (16, 'Group D Match 4', 44, 13, 15, 5, '2012-06-15 20:45:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-15 20:45:00', 'D1-D3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (17, 'Group A Match 5', 15, 2, 3, 3, '2012-06-16 20:45:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-16 20:45:00', 'A2-A3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (18, 'Group A Match 6', 16, 4, 1, 4, '2012-06-16 20:45:00', 6, NULL, NULL, NULL, NULL, 'A', '', '', '2012-06-16 20:45:00', 'A4-A1');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (19, 'Group B Match 5', 25, 8, 5, 6, '2012-06-17 20:45:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-17 20:45:00', 'B4-B1');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (20, 'Group B Match 6', 26, 6, 7, 7, '2012-06-17 20:45:00', 6, NULL, NULL, NULL, NULL, 'B', '', '', '2012-06-17 20:45:00', 'B2-B3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (21, 'Group C Match 5', 35, 12, 9, 1, '2012-06-18 20:45:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-18 20:45:00', 'C4-C1');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (22, 'Group C Match 6', 36, 10, 11, 2, '2012-06-18 20:45:00', 6, NULL, NULL, NULL, NULL, 'C', '', '', '2012-06-18 20:45:00', 'C2-C3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (23, 'Group D Match 5', 45, 14, 15, 7, '2012-06-19 20:45:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-19 20:45:00', 'D2-D3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (24, 'Group D Match 6', 46, 16, 13, 5, '2012-06-19 20:45:00', 6, NULL, NULL, NULL, NULL, 'D', '', '', '2012-06-19 20:45:00', 'D4-D1');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (25, 'Quarter Final 1', 51, 50, 53, 3, '2012-06-21 20:45:00', 4, NULL, NULL, NULL, NULL, 'QF', 'A', 'B', '2012-06-21 20:45:00', 'Winner Group A - Runner Up Group B');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (26, 'Quarter Final 2', 52, 52, 51, 1, '2012-06-22 20:45:00', 4, NULL, NULL, NULL, NULL, 'QF', 'B', 'A', '2012-06-22 20:45:00', 'Winner Group B - Runner Up Group A');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (27, 'Quarter Final 3', 53, 54, 57, 5, '2012-06-23 20:45:00', 4, NULL, NULL, NULL, NULL, 'QF', 'C', 'D', '2012-06-23 20:45:00', 'Winner Group C - Runner Up Group D');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (28, 'Quarter Final 4', 54, 56, 55, 7, '2012-06-24 19:45:00', 4, NULL, NULL, NULL, NULL, 'QF', 'D', 'C', '2012-06-24 19:45:00', 'Winner Group D - Runner Up Group C');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (29, 'Semi Final 1', 61, 80, 82, 5, '2012-06-27 20:45:00', 2, NULL, NULL, NULL, NULL, 'SF', 'AB', 'CD', '2012-06-27 20:45:00', 'Winner QF1 - Winner QF3');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (30, 'Semi Final 2', 62, 81, 83, 3, '2012-06-28 20:45:00', 2, NULL, NULL, NULL, NULL, 'SF', 'AB', 'CD', '2012-06-28 20:45:00', 'Winner QF2 - Winner QF4');
INSERT INTO matches (`id`, `match_name`, `match_number`, `home_id`, `away_id`, `venue_id`, `match_time`, `type_id`, `home_goals`, `away_goals`, `red_cards`, `yellow_cards`, `match_group`, `group_home`, `group_away`, `time_close`, `description`) VALUES (31, 'Final', 99, 90, 91, 7, '2012-07-01 20:45:00', 1, NULL, NULL, NULL, NULL, 'F', 'ABCD', 'ABCD', '2012-07-01 20:45:00', 'Winner SF1 - Winner SF2');


#
# TABLE STRUCTURE FOR: predictions
#

DROP TABLE IF EXISTS predictions;

CREATE TABLE `predictions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `match_number` int(10) unsigned NOT NULL,
  `home_goals` int(10) unsigned DEFAULT NULL,
  `away_goals` int(10) unsigned DEFAULT NULL,
  `red_cards` int(10) unsigned DEFAULT NULL,
  `home_id` int(10) unsigned DEFAULT '0',
  `away_id` int(10) unsigned DEFAULT '0',
  `yellow_cards` int(10) unsigned DEFAULT NULL,
  `points_home_goals` int(10) unsigned DEFAULT NULL,
  `points_away_goals` int(10) unsigned DEFAULT NULL,
  `points_toto` int(10) unsigned DEFAULT NULL,
  `points_exact` int(10) unsigned DEFAULT NULL,
  `points_red_cards` int(10) unsigned DEFAULT NULL,
  `points_yellow_cards` int(10) unsigned DEFAULT NULL,
  `points_home_id` int(10) unsigned DEFAULT NULL,
  `points_away_id` int(10) unsigned DEFAULT NULL,
  `points_total_this_match` int(10) unsigned DEFAULT NULL,
  `position_prev` int(10) unsigned DEFAULT NULL,
  `position_curr` int(10) unsigned DEFAULT NULL,
  `total_points_curr` int(10) unsigned DEFAULT NULL,
  `total_points_prev` int(10) unsigned DEFAULT NULL,
  `calculated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  KEY `match_number_idx` (`match_number`),
  KEY `home_id_idx` (`home_id`),
  KEY `away_id_idx` (`away_id`),
  CONSTRAINT `predictions_away_id_teams_team_id_away` FOREIGN KEY (`away_id`) REFERENCES `teams` (`team_id_away`),
  CONSTRAINT `predictions_home_id_teams_team_id_home` FOREIGN KEY (`home_id`) REFERENCES `teams` (`team_id_home`),
  CONSTRAINT `predictions_match_number_matches_match_number` FOREIGN KEY (`match_number`) REFERENCES `matches` (`match_number`),
  CONSTRAINT `predictions_user_id_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (1, 1, 11, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (2, 1, 12, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (3, 1, 13, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (4, 1, 14, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (5, 1, 15, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (6, 1, 16, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (7, 1, 21, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (8, 1, 22, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (9, 1, 23, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (10, 1, 24, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (11, 1, 25, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (12, 1, 26, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (13, 1, 31, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (14, 1, 32, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (15, 1, 33, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (16, 1, 34, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (17, 1, 35, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (18, 1, 36, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (19, 1, 41, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (20, 1, 42, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (21, 1, 43, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (22, 1, 44, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (23, 1, 45, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (24, 1, 46, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (25, 1, 51, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (26, 1, 52, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (27, 1, 53, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (28, 1, 54, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (29, 1, 61, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (30, 1, 62, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);
INSERT INTO predictions (`id`, `user_id`, `match_number`, `home_goals`, `away_goals`, `red_cards`, `home_id`, `away_id`, `yellow_cards`, `points_home_goals`, `points_away_goals`, `points_toto`, `points_exact`, `points_red_cards`, `points_yellow_cards`, `points_home_id`, `points_away_id`, `points_total_this_match`, `position_prev`, `position_curr`, `total_points_curr`, `total_points_prev`, `calculated`) VALUES (31, 1, 99, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);


#
# TABLE STRUCTURE FOR: settings
#

DROP TABLE IF EXISTS settings;

CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `setting` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (1, 'poolname', 'Euro 2012', 'poolname_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (2, 'version', '1.0 Alpha', 'version_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (3, 'points_for_goals', '3', 'points_for_goals_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (4, 'points_for_wdl', '3', 'points_for_wdl_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (5, 'points_for_exact_score', '5', 'points_for_exact_score_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (6, 'points_for_team_qf', '7', 'points_for_team_qf_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (7, 'points_for_team_sf', '11', 'points_for_team_sf_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (8, 'points_for_team_f', '13', 'points_for_team_f_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (9, 'points_for_champion', '19', 'points_for_champion_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (10, 'view_other_users', '1', 'view_other_users_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (11, 'use_cards', '0', 'use_cards_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (12, 'server_time_offset_utc', '3600', 'server_time_offset_utc_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (13, 'user_activation', '1', 'user_activation_description');
INSERT INTO settings (`id`, `setting`, `value`, `description`) VALUES (14, 'admin_email', 'admin@example.com', 'admin_email_description');


#
# TABLE STRUCTURE FOR: teams
#

DROP TABLE IF EXISTS teams;

CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `team_id_home` int(10) unsigned NOT NULL,
  `team_id_away` int(10) unsigned NOT NULL,
  `shortname` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `team_group` varchar(255) DEFAULT NULL,
  `played` int(10) unsigned NOT NULL,
  `won` int(10) unsigned NOT NULL,
  `tie` int(10) unsigned NOT NULL,
  `lost` int(10) unsigned NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `goals_for` int(10) unsigned NOT NULL,
  `goals_against` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_id_home_idx` (`team_id_home`),
  UNIQUE KEY `team_id_away_idx` (`team_id_away`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (1, 'Poland', 1, 1, 'Pol', 'poland.png', 'A', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (2, 'Group A, Team 2', 2, 2, 'A2', 'euro.png', 'A', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (3, 'Group A, Team 3', 3, 3, 'A3', 'euro.png', 'A', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (4, 'Group A, Team 4', 4, 4, 'A4', 'euro.png', 'A', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (5, 'Group B, Team 1', 5, 5, 'B1', 'euro.png', 'B', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (6, 'Group B, Team 2', 6, 6, 'B2', 'euro.png', 'B', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (7, 'Group B, Team 3', 7, 7, 'B3', 'euro.png', 'B', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (8, 'Group B, Team 4', 8, 8, 'B4', 'euro.png', 'B', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (9, 'Group C, Team 1', 9, 9, 'C1', 'euro.png', 'C', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (10, 'Group C, Team 2', 10, 10, 'C2', 'euro.png', 'C', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (11, 'Group C, Team 3', 11, 11, 'C3', 'euro.png', 'C', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (12, 'Group C, Team 4', 12, 12, 'C4', 'euro.png', 'C', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (13, 'Ukraine', 13, 13, 'ukr', 'ukraine.png', 'D', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (14, 'Group D, Team 2', 14, 14, 'D2', 'euro.png', 'D', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (15, 'Group D, Team 3', 15, 15, 'D3', 'euro.png', 'D', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (16, 'Group D, Team 4', 16, 16, 'D4', 'euro.png', 'D', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (17, 'Winner Group A', 50, 50, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (18, 'Runner up Group A', 51, 51, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (19, 'Winner Group B', 52, 52, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (20, 'Runner Up Group B', 53, 53, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (21, 'Winner Group C', 54, 54, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (22, 'Runner Up Group C', 55, 55, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (23, 'Winner Group D', 56, 56, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (24, 'Runner Up Group D', 57, 57, NULL, 'unknown.png', 'QF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (25, 'Winner QF1', 80, 80, NULL, 'unknown.png', 'SF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (26, 'Winner QF2', 81, 81, NULL, 'unknown.png', 'SF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (27, 'Winner QF3', 82, 82, NULL, 'unknown.png', 'SF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (28, 'Winner QF4', 83, 83, NULL, 'unknown.png', 'SF', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (29, 'Winner SF1', 90, 90, NULL, 'unknown.png', 'F', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (30, 'Winner SF2', 91, 91, NULL, 'unknown.png', 'F', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (31, 'Winner Final', 99, 99, NULL, 'unknown.png', 'F', 0, 0, 0, 0, 0, 0, 0);
INSERT INTO teams (`id`, `name`, `team_id_home`, `team_id_away`, `shortname`, `flag`, `team_group`, `played`, `won`, `tie`, `lost`, `points`, `goals_for`, `goals_against`) VALUES (32, '', 0, 0, '', 'unknown.png', NULL, 0, 0, 0, 0, 0, 0, 0);


#
# TABLE STRUCTURE FOR: texts
#

DROP TABLE IF EXISTS texts;

CREATE TABLE `texts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text_name` varchar(255) NOT NULL,
  `text_en` longtext NOT NULL,
  `text_nl` longtext NOT NULL,
  `text_default` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `text_name` (`text_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO texts (`id`, `text_name`, `text_en`, `text_nl`, `text_default`) VALUES (1, 'text_welcome_not_logged_in', '<h2>Welcome to [[poolname]], version [[version]].</h2><p>This is a prediction game for Euro 2012. To join the fun, please <a href=\"signup\">create an account</a>, and start predicting the results.</p><h4>With these predictions, you can earn points&#58;</h4><ul><li>Correct goals for the home team or away team&#58; <strong>[[points_for_goals]] points</strong>.</li><li>Correct result (win-draw-loss)&#58; <strong>[[points_for_wdl]] points</strong>.</li><li>Prediction of the<strong> exact</strong> outcome of a match give you <strong>[[points_for_exact_score]] bonus points</strong>.</li></ul><p>You can change your prediction for these reults until the match starts. So if a team does not perform as you thought it would, you have time to correct your predictions during the tournament.</p><p>In the knockout phase of the tournament, you can earn extra points by predicting the teams that will reach the quarter finals, semi finals and the final. <u><em>To keep these predictions honest, you will have to predict the teams before the tournament starts.</em></u></p><ul><li>A team correct in the quarter finals&#58;<strong> [[points_for_team_qf]] points</strong>.</li><li>A team correct in the semi finals&#58;<strong> [[points_for_team_sf]] points</strong>.&nbsp;</li><li>A team correct in the final&#58; <strong>[[points_for_team_f]] points</strong>.</li></ul><p>Whoever has the most points after the tournament is over, wins the game.</p><p>Good luck!</p>', '<h2>Welkom bij [[poolname]], versie [[version]].</h2><p>Dit is een voetbal pool voor het Europees Kampioenschp Voetbal in 2012. Om mee te kunnen doen, moet je eerst&nbsp;<a href=\"signup\">een account aanmaken</a>, daarna kun je voorspelling in gaan vullen.</p><h4>Met deze voorspellingen kun je punten scoren&#58;</h4><ul><li>Correct aantal doelpunten voor uit- of thuisploeg&#58;&nbsp;<strong>[[points_for_goals]] punten</strong>.</li><li>Correct toto resultaat (winst-gelijk-verlies)&#58;&nbsp;<strong>[[points_for_wdl]] punten per wedstrijd</strong>.</li><li>Als je de uitslag van een wedstrijd exact voorspeld hebt, krijg je ook nog eens&nbsp;<strong>[[points_for_exact_score]] bonus punten</strong>.</li></ul><p>Je kunt de voorspelling van de uitslag van een wedstrijd wijzigen tot de wedstrijd begint. Als een land dus niet zo sterk blijkt te presteren als je aanvankelijk dacht, heb je nog de tijd om je voorspellingen te wijzigen.</p><p>Na de groepsfase zijn er ook nog punten te verdienen door de juiste landen in de kwart- en halve finales en de finale te voorspellen. <u><em>Om het allemaal zo eerlijk mogelijk te houden, moet je deze voorspellingen doen v&oacute;&oacute;rdat het toernooi begint.</em></u></p><ul><li>Een land goed voorspeld in de kwart finale&#58;<strong>&nbsp;[[points_for_team_qf]] punten</strong>.</li><li>Een land goed voorspeld in de halve finale&#58;<strong>&nbsp;[[points_for_team_sf]]&nbsp;</strong><strong>punten</strong>.</li> <li>Een land goed voorspeld in de finale&#58;&nbsp;<strong>[[points_for_team_f]]&nbsp;</strong><strong>punten</strong>.</li></ul><p>Wie aan het einde van het toernooi de meeste punten heeft, wint de pool.</p><p>Succes!</p>', '<h2>Welcome to [[poolname]], version[[version]].</h2><p>This is a prediction game for Euro 2012. To join the fun, please <a href=\"signup\">create an account</a>, and start predicting the results.</p><h4>With these predictions, you can earn points&#58</h4><ul><li>Correct goals for the home team or away team: <strong>[[points_for_goals]] points</strong>.</li><li>Correct result (win-draw-loss)&#58; <strong>[[points_for_wdl]] points</strong>.</li><li>Prediction of the<strong> exact</strong> outcome of a match give you <strong>[[points_for_exact_score]] bonus points</strong>.</li></ul><p>In the knockout phase of the tournament, you can earn extra points by predicting the teams that will reach the quarter finals, semi finals and the final&#58;</p><ul><li>A team correct in the quarter finals&#58;<strong> [[points_for_team_qf]] points</strong>.</li><li>A team correct in the semi finals&#58;<strong> [[points_for_team_sf]] points</strong>.&nbsp;</li><li>A team correct in the final&#58; <strong>[[points_for_team_f]] points</strong>.</li></ul><p>Whoever has the most points after the tournament is over, wins the game.</p>');
INSERT INTO texts (`id`, `text_name`, `text_en`, `text_nl`, `text_default`) VALUES (2, 'text_email_activate', '<p>Hi [[nickname]]</p><p>You have created an account for [[poolname]] at <a href=\"http&#58;//[[base_url]]\">http://[[base_url]]</a>. Please click on the following link to activate your account&#58; [[activatelink]].</p><p>If you have trouble activating your account, please contact <a href=\"mailto:[[admin_email]]?subject=Trouble with activation&body=I need help!\">the administrator</a>.</p><p>Thanks,</p><p>[[poolname]]</p>', '<p>Hoi [[nickname]]</p><p>Je hebt een account aangemaakt voor [[poolname]] op [[base_url]]. Klik even op de volgende link om je account te activeren&#58; [[activatelink]].</p><p>Als het activeren niet lukt, of je hebt andere vragen, neem dan contact op met [[admin_email]].</p><p>Bedankt,</p><p>[[poolname]]</p>', '<p>Hi [[nickname]]</p><p>You have created an account for [[poolname]] at [[base_url]]. Please click on the following link to activate your account&#58; [[activatelink]].</p><p>If you have trouble activating your account, please contact [[admin_email]].</p><p>Thanks,</p><p>[[poolname]]</p>');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS users;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `poolgroup` varchar(255) DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'english',
  `admin` tinyint(1) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `activecode` varchar(255) NOT NULL,
  `resetcode` varchar(255) NOT NULL,
  `points` int(10) unsigned NOT NULL,
  `previouspoints` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `lastposition` int(10) unsigned NOT NULL,
  `pred_total_goals` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO users (`id`, `username`, `password`, `email`, `nickname`, `street`, `zipcode`, `city`, `phone`, `poolgroup`, `language`, `admin`, `paid`, `active`, `lastlogin`, `activecode`, `resetcode`, `points`, `previouspoints`, `position`, `lastposition`, `pred_total_goals`, `created_at`, `updated_at`) VALUES (1, 'schop', '35589117afefdd6a71f2ef2b5fd7c93a', 'john.schop@gmail.com', 'Schop Zelf', '6021 BRADFORD WAY', NULL, 'Hudson', '5353535', NULL, 'english', 1, 0, 1, '0000-00-00 00:00:00', 'c23WFC1jXlJDEPzl', '', 0, 0, 0, 0, NULL, '2011-02-07 23:18:28', '2011-02-07 23:18:28');


#
# TABLE STRUCTURE FOR: venues
#

DROP TABLE IF EXISTS venues;

CREATE TABLE `venues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `venue_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `capacity` bigint(20) unsigned NOT NULL,
  `time_offset_utc` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `venue_id_idx` (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (1, 1, 'Municipal Stadium', 'Gdansk', 40000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (2, 2, 'Miejski Stadium', 'Poznan', 40000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (3, 3, 'National Stadium', 'Warsaw', 50000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (4, 4, 'Municipal Stadium', 'Wroclaw', 40000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (5, 5, 'Donbass Arena', 'Donetsk', 50000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (6, 6, 'Metalist Stadium', 'Kharkiv', 35000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (7, 7, 'NSC Olympiyskiy Stadium', 'Kyiv', 60000, 0);
INSERT INTO venues (`id`, `venue_id`, `name`, `city`, `capacity`, `time_offset_utc`) VALUES (8, 8, 'Ukrayina Stadion', 'Lviv', 35000, 0);



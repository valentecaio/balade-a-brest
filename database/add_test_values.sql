INSERT INTO `point` (`id_point`, `nom`, `latitude`, `longitude`, `description`, `status`) VALUES
(1, 'Point1', '48.38434', '-4.49755', NULL, 'en_attente'),
(2, 'Point 2', '48.38536', '-4.50003', NULL, 'en_attente'),
(3, '123', '48.38522', '-4.50089', NULL, 'en_attente'),
(4, 'i3', '48.357892', '-4.570974', NULL, 'accepte'),
(5, 'i5', '48.357297', '-4.570362', NULL, 'accepte'),
(6, 'i8', '48.356595', '-4.570427', NULL, 'accepte'),
(7, 'i9', '48.356880', '-4.569810', NULL, 'accepte'),
(8, 'rak', '48.360106', '-4.571188', NULL, 'accepte');

INSERT INTO `usagers` (`id_usager`, `nom`, `prenom`, `mot_de_passe`, `email`, `permission`) VALUES
(19, 'Cardador', 'Jean', 'fddecb6a9fb5324cab83d2c9d4ec6f3492ee1df4', 'jony@tb', 'admin'),
(20, 'Marin', 'Yan', 'b1b3773a05c0ed0176787a4f1574ff0075f7521e', 'yan@tb', 'user'),
(21, '123', 'Elnatan', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '1@2', 'user');

INSERT INTO `balade` (`id_balade`, `nom`, `theme`, `description`, `status`) VALUES
(31, 'maisel 1', 'maisel', NULL, 'accepte'),
(32, 'maisel 2', 'maisel', NULL, 'accepte'),
(33, 'telecom 1', 'telecom', NULL, 'en_attente'),
(34, 'telecom 2', 'telecom', NULL, 'accepte');

INSERT INTO `contenu_parcours` (`id_p`, `id_b`) VALUES
(4, 31),
(5, 31),
(6, 31),
(7, 31),
(8, 31),
(4, 32),
(5, 32),
(6, 32),
(7, 33),
(8, 33),
(4, 34),
(5, 34);

INSERT INTO `media` (`id_media`, `chemin`, `id_point_ref`, `status`) VALUES
(41, 'mtb.mp4', 3, 'accepte'),
(42, 'danilo.jpg', 6, 'accepte'),
(43, 'dede.jpg', 6, 'accepte'),
(44, 'guinther.png', 6, 'accepte'),
(45, 'danilo.jpg', 5, 'accepte');



INSERT INTO `category` (`id`, `title`) VALUES
(5, 'Discussions'),
(1, 'Geekitude'),
(3, 'Hardware'),
(2, 'Modding et looking PC'),
(4, 'Software');

INSERT INTO `forum` (`id`, `title`, `category_id`, `last_post_id`, `nb_subjects`) VALUES
(1, 'La vie du geek', 1, NULL, 19),
(2, 'Vos autres passions', 1, NULL, 23),
(3, 'Les photos de la rédac', 1, NULL, 28),
(4, 'Galerie des mods', 2, NULL, 26),
(5, 'Workblogs', 2, NULL, 20),
(6, 'Aide, Tutos et bonnes adresses', 2, NULL, 25),
(7, 'Tutos photos et vos meilleurs clichés', 2, NULL, 22),
(8, 'Best of mods (du net)', 2, NULL, 20),
(9, 'Nouvelles configs, upgrades', 3, NULL, 23),
(10, 'Le coeur du PC', 3, NULL, 22),
(11, 'Stockage', 3, NULL, 18),
(12, 'Boitiers, alims, refroidissement', 3, NULL, 18),
(13, 'Mobilité', 3, NULL, 17),
(14, 'Réseau, multimédia et tout le reste', 3, NULL, 22),
(15, 'OS et logiciels', 4, NULL, 20),
(16, 'HTPC et Media-Center', 4, NULL, 27),
(17, 'Création web', 4, NULL, 23),
(18, 'Les débats', 5, NULL, 11),
(19, 'L''actualité de la micro', 5, NULL, 19),
(20, 'Jeux', 5, NULL, 17);

INSERT INTO `user` (`id`, `username`, `password`, `salt`, `email`, `created_at`) VALUES
(1, 'bot', '', '', '', NULL);

INSERT INTO `subject` (`id`, `title`, `forum_id`, `user_id`, `nb_posts`, `created_at`) VALUES
(1, '', 1, 1, 0, NULL),
(2, '', 11, 1, 0, NULL),
(3, '', 4, 1, 0, NULL),
(4, '', 3, 1, 0, NULL),
(5, '', 5, 1, 0, NULL),
(6, '', 13, 1, 0, NULL),
(7, '', 11, 1, 0, NULL),
(8, '', 17, 1, 0, NULL),
(9, '', 10, 1, 0, NULL),
(10, '', 20, 1, 0, NULL),
(11, '', 9, 1, 0, NULL),
(12, '', 6, 1, 0, NULL),
(13, '', 2, 1, 0, NULL),
(14, '', 10, 1, 0, NULL),
(15, '', 3, 1, 0, NULL),
(16, '', 6, 1, 0, NULL),
(17, '', 17, 1, 0, NULL),
(18, '', 11, 1, 0, NULL),
(19, '', 1, 1, 0, NULL),
(20, '', 10, 1, 0, NULL),
(21, '', 8, 1, 0, NULL),
(22, '', 10, 1, 0, NULL),
(23, '', 4, 1, 0, NULL),
(24, '', 7, 1, 0, NULL),
(25, '', 6, 1, 0, NULL),
(26, '', 7, 1, 0, NULL),
(27, '', 16, 1, 0, NULL),
(28, '', 1, 1, 0, NULL),
(29, '', 14, 1, 0, NULL),
(30, '', 9, 1, 0, NULL),
(31, '', 2, 1, 0, NULL),
(32, '', 1, 1, 0, NULL),
(33, '', 17, 1, 0, NULL),
(34, '', 6, 1, 0, NULL),
(35, '', 15, 1, 0, NULL),
(36, '', 20, 1, 0, NULL),
(37, '', 13, 1, 0, NULL),
(38, '', 5, 1, 0, NULL),
(39, '', 4, 1, 0, NULL),
(40, '', 2, 1, 0, NULL),
(41, '', 19, 1, 0, NULL),
(42, '', 9, 1, 0, NULL),
(43, '', 8, 1, 0, NULL),
(44, '', 11, 1, 0, NULL),
(45, '', 11, 1, 0, NULL),
(46, '', 2, 1, 0, NULL),
(47, '', 16, 1, 0, NULL),
(48, '', 13, 1, 0, NULL),
(49, '', 16, 1, 0, NULL),
(50, '', 2, 1, 0, NULL),
(51, '', 1, 1, 0, NULL),
(52, '', 17, 1, 0, NULL),
(53, '', 4, 1, 0, NULL),
(54, '', 6, 1, 0, NULL),
(55, '', 17, 1, 0, NULL),
(56, '', 10, 1, 0, NULL),
(57, '', 15, 1, 0, NULL),
(58, '', 7, 1, 0, NULL),
(59, '', 6, 1, 0, NULL),
(60, '', 9, 1, 0, NULL),
(61, '', 7, 1, 0, NULL),
(62, '', 5, 1, 0, NULL),
(63, '', 6, 1, 0, NULL),
(64, '', 12, 1, 0, NULL),
(65, '', 4, 1, 0, NULL),
(66, '', 1, 1, 0, NULL),
(67, '', 13, 1, 0, NULL),
(68, '', 4, 1, 0, NULL),
(69, '', 17, 1, 0, NULL),
(70, '', 16, 1, 0, NULL),
(71, '', 6, 1, 0, NULL),
(72, '', 3, 1, 0, NULL),
(73, '', 15, 1, 0, NULL),
(74, '', 7, 1, 0, NULL),
(75, '', 9, 1, 0, NULL),
(76, '', 2, 1, 0, NULL),
(77, '', 3, 1, 0, NULL),
(78, '', 9, 1, 0, NULL),
(79, '', 14, 1, 0, NULL),
(80, '', 6, 1, 0, NULL),
(81, '', 4, 1, 0, NULL),
(82, '', 1, 1, 0, NULL),
(83, '', 12, 1, 0, NULL),
(84, '', 16, 1, 0, NULL),
(85, '', 6, 1, 0, NULL),
(86, '', 18, 1, 0, NULL),
(87, '', 14, 1, 0, NULL),
(88, '', 14, 1, 0, NULL),
(89, '', 9, 1, 0, NULL),
(90, '', 20, 1, 0, NULL),
(91, '', 14, 1, 0, NULL),
(92, '', 9, 1, 0, NULL),
(93, '', 3, 1, 0, NULL),
(94, '', 5, 1, 0, NULL),
(95, '', 15, 1, 0, NULL),
(96, '', 4, 1, 0, NULL),
(97, '', 11, 1, 0, NULL),
(98, '', 3, 1, 0, NULL),
(99, '', 1, 1, 0, NULL),
(100, '', 16, 1, 0, NULL),
(101, '', 15, 1, 0, NULL),
(102, '', 10, 1, 0, NULL),
(103, '', 3, 1, 0, NULL),
(104, '', 5, 1, 0, NULL),
(105, '', 14, 1, 0, NULL),
(106, '', 16, 1, 0, NULL),
(107, '', 17, 1, 0, NULL),
(108, '', 20, 1, 0, NULL),
(109, '', 6, 1, 0, NULL),
(110, '', 11, 1, 0, NULL),
(111, '', 14, 1, 0, NULL),
(112, '', 17, 1, 0, NULL),
(113, '', 5, 1, 0, NULL),
(114, '', 11, 1, 0, NULL),
(115, '', 19, 1, 0, NULL),
(116, '', 7, 1, 0, NULL),
(117, '', 12, 1, 0, NULL),
(118, '', 19, 1, 0, NULL),
(119, '', 2, 1, 0, NULL),
(120, '', 7, 1, 0, NULL),
(121, '', 12, 1, 0, NULL),
(122, '', 17, 1, 0, NULL),
(123, '', 12, 1, 0, NULL),
(124, '', 7, 1, 0, NULL),
(125, '', 16, 1, 0, NULL),
(126, '', 3, 1, 0, NULL),
(127, '', 4, 1, 0, NULL),
(128, '', 8, 1, 0, NULL),
(129, '', 11, 1, 0, NULL),
(130, '', 7, 1, 0, NULL),
(131, '', 5, 1, 0, NULL),
(132, '', 19, 1, 0, NULL),
(133, '', 4, 1, 0, NULL),
(134, '', 17, 1, 0, NULL),
(135, '', 17, 1, 0, NULL),
(136, '', 15, 1, 0, NULL),
(137, '', 3, 1, 0, NULL),
(138, '', 9, 1, 0, NULL),
(139, '', 13, 1, 0, NULL),
(140, '', 2, 1, 0, NULL),
(141, '', 5, 1, 0, NULL),
(142, '', 20, 1, 0, NULL),
(143, '', 6, 1, 0, NULL),
(144, '', 9, 1, 0, NULL),
(145, '', 5, 1, 0, NULL),
(146, '', 15, 1, 0, NULL),
(147, '', 4, 1, 0, NULL),
(148, '', 11, 1, 0, NULL),
(149, '', 4, 1, 0, NULL),
(150, '', 7, 1, 0, NULL),
(151, '', 3, 1, 0, NULL),
(152, '', 13, 1, 0, NULL),
(153, '', 17, 1, 0, NULL),
(154, '', 6, 1, 0, NULL),
(155, '', 16, 1, 0, NULL),
(156, '', 3, 1, 0, NULL),
(157, '', 4, 1, 0, NULL),
(158, '', 12, 1, 0, NULL),
(159, '', 8, 1, 0, NULL),
(160, '', 2, 1, 0, NULL),
(161, '', 5, 1, 0, NULL),
(162, '', 19, 1, 0, NULL),
(163, '', 4, 1, 0, NULL),
(164, '', 16, 1, 0, NULL),
(165, '', 13, 1, 0, NULL),
(166, '', 16, 1, 0, NULL),
(167, '', 1, 1, 0, NULL),
(168, '', 14, 1, 0, NULL),
(169, '', 8, 1, 0, NULL),
(170, '', 17, 1, 0, NULL),
(171, '', 2, 1, 0, NULL),
(172, '', 14, 1, 0, NULL),
(173, '', 9, 1, 0, NULL),
(174, '', 19, 1, 0, NULL),
(175, '', 12, 1, 0, NULL),
(176, '', 19, 1, 0, NULL),
(177, '', 3, 1, 0, NULL),
(178, '', 15, 1, 0, NULL),
(179, '', 7, 1, 0, NULL),
(180, '', 9, 1, 0, NULL),
(181, '', 3, 1, 0, NULL),
(182, '', 6, 1, 0, NULL),
(183, '', 19, 1, 0, NULL),
(184, '', 19, 1, 0, NULL),
(185, '', 19, 1, 0, NULL),
(186, '', 18, 1, 0, NULL),
(187, '', 11, 1, 0, NULL),
(188, '', 2, 1, 0, NULL),
(189, '', 12, 1, 0, NULL),
(190, '', 16, 1, 0, NULL),
(191, '', 4, 1, 0, NULL),
(192, '', 11, 1, 0, NULL),
(193, '', 5, 1, 0, NULL),
(194, '', 7, 1, 0, NULL),
(195, '', 19, 1, 0, NULL),
(196, '', 16, 1, 0, NULL),
(197, '', 2, 1, 0, NULL),
(198, '', 18, 1, 0, NULL),
(199, '', 8, 1, 0, NULL),
(200, '', 5, 1, 0, NULL),
(201, '', 16, 1, 0, NULL),
(202, '', 11, 1, 0, NULL),
(203, '', 3, 1, 0, NULL),
(204, '', 18, 1, 0, NULL),
(205, '', 7, 1, 0, NULL),
(206, '', 16, 1, 0, NULL),
(207, '', 2, 1, 0, NULL),
(208, '', 16, 1, 0, NULL),
(209, '', 17, 1, 0, NULL),
(210, '', 15, 1, 0, NULL),
(211, '', 6, 1, 0, NULL),
(212, '', 5, 1, 0, NULL),
(213, '', 3, 1, 0, NULL),
(214, '', 1, 1, 0, NULL),
(215, '', 14, 1, 0, NULL),
(216, '', 7, 1, 0, NULL),
(217, '', 10, 1, 0, NULL),
(218, '', 10, 1, 0, NULL),
(219, '', 20, 1, 0, NULL),
(220, '', 11, 1, 0, NULL),
(221, '', 14, 1, 0, NULL),
(222, '', 16, 1, 0, NULL),
(223, '', 18, 1, 0, NULL),
(224, '', 4, 1, 0, NULL),
(225, '', 2, 1, 0, NULL),
(226, '', 17, 1, 0, NULL),
(227, '', 20, 1, 0, NULL),
(228, '', 9, 1, 0, NULL),
(229, '', 3, 1, 0, NULL),
(230, '', 8, 1, 0, NULL),
(231, '', 10, 1, 0, NULL),
(232, '', 8, 1, 0, NULL),
(233, '', 8, 1, 0, NULL),
(234, '', 14, 1, 0, NULL),
(235, '', 8, 1, 0, NULL),
(236, '', 17, 1, 0, NULL),
(237, '', 4, 1, 0, NULL),
(238, '', 3, 1, 0, NULL),
(239, '', 4, 1, 0, NULL),
(240, '', 9, 1, 0, NULL),
(241, '', 13, 1, 0, NULL),
(242, '', 17, 1, 0, NULL),
(243, '', 7, 1, 0, NULL),
(244, '', 1, 1, 0, NULL),
(245, '', 4, 1, 0, NULL),
(246, '', 16, 1, 0, NULL),
(247, '', 10, 1, 0, NULL),
(248, '', 3, 1, 0, NULL),
(249, '', 20, 1, 0, NULL),
(250, '', 13, 1, 0, NULL),
(251, '', 4, 1, 0, NULL),
(252, '', 19, 1, 0, NULL),
(253, '', 6, 1, 0, NULL),
(254, '', 11, 1, 0, NULL),
(255, '', 14, 1, 0, NULL),
(256, '', 2, 1, 0, NULL),
(257, '', 1, 1, 0, NULL),
(258, '', 20, 1, 0, NULL),
(259, '', 19, 1, 0, NULL),
(260, '', 14, 1, 0, NULL),
(261, '', 12, 1, 0, NULL),
(262, '', 20, 1, 0, NULL),
(263, '', 2, 1, 0, NULL),
(264, '', 9, 1, 0, NULL),
(265, '', 16, 1, 0, NULL),
(266, '', 16, 1, 0, NULL),
(267, '', 13, 1, 0, NULL),
(268, '', 14, 1, 0, NULL),
(269, '', 13, 1, 0, NULL),
(270, '', 19, 1, 0, NULL),
(271, '', 20, 1, 0, NULL),
(272, '', 2, 1, 0, NULL),
(273, '', 9, 1, 0, NULL),
(274, '', 16, 1, 0, NULL),
(275, '', 15, 1, 0, NULL),
(276, '', 8, 1, 0, NULL),
(277, '', 13, 1, 0, NULL),
(278, '', 20, 1, 0, NULL),
(279, '', 2, 1, 0, NULL),
(280, '', 8, 1, 0, NULL),
(281, '', 14, 1, 0, NULL),
(282, '', 7, 1, 0, NULL),
(283, '', 12, 1, 0, NULL),
(284, '', 20, 1, 0, NULL),
(285, '', 3, 1, 0, NULL),
(286, '', 10, 1, 0, NULL),
(287, '', 4, 1, 0, NULL),
(288, '', 9, 1, 0, NULL),
(289, '', 10, 1, 0, NULL),
(290, '', 6, 1, 0, NULL),
(291, '', 17, 1, 0, NULL),
(292, '', 10, 1, 0, NULL),
(293, '', 17, 1, 0, NULL),
(294, '', 16, 1, 0, NULL),
(295, '', 11, 1, 0, NULL),
(296, '', 3, 1, 0, NULL),
(297, '', 1, 1, 0, NULL),
(298, '', 14, 1, 0, NULL),
(299, '', 10, 1, 0, NULL),
(300, '', 7, 1, 0, NULL),
(301, '', 5, 1, 0, NULL),
(302, '', 20, 1, 0, NULL),
(303, '', 8, 1, 0, NULL),
(304, '', 16, 1, 0, NULL),
(305, '', 17, 1, 0, NULL),
(306, '', 16, 1, 0, NULL),
(307, '', 10, 1, 0, NULL),
(308, '', 2, 1, 0, NULL),
(309, '', 15, 1, 0, NULL),
(310, '', 11, 1, 0, NULL),
(311, '', 11, 1, 0, NULL),
(312, '', 1, 1, 0, NULL),
(313, '', 9, 1, 0, NULL),
(314, '', 5, 1, 0, NULL),
(315, '', 15, 1, 0, NULL),
(316, '', 1, 1, 0, NULL),
(317, '', 18, 1, 0, NULL),
(318, '', 7, 1, 0, NULL),
(319, '', 2, 1, 0, NULL),
(320, '', 8, 1, 0, NULL),
(321, '', 12, 1, 0, NULL),
(322, '', 15, 1, 0, NULL),
(323, '', 3, 1, 0, NULL),
(324, '', 5, 1, 0, NULL),
(325, '', 15, 1, 0, NULL),
(326, '', 20, 1, 0, NULL),
(327, '', 15, 1, 0, NULL),
(328, '', 15, 1, 0, NULL),
(329, '', 12, 1, 0, NULL),
(330, '', 13, 1, 0, NULL),
(331, '', 8, 1, 0, NULL),
(332, '', 3, 1, 0, NULL),
(333, '', 5, 1, 0, NULL),
(334, '', 18, 1, 0, NULL),
(335, '', 15, 1, 0, NULL),
(336, '', 1, 1, 0, NULL),
(337, '', 18, 1, 0, NULL),
(338, '', 8, 1, 0, NULL),
(339, '', 6, 1, 0, NULL),
(340, '', 4, 1, 0, NULL),
(341, '', 18, 1, 0, NULL),
(342, '', 3, 1, 0, NULL),
(343, '', 19, 1, 0, NULL),
(344, '', 6, 1, 0, NULL),
(345, '', 12, 1, 0, NULL),
(346, '', 2, 1, 0, NULL),
(347, '', 9, 1, 0, NULL),
(348, '', 3, 1, 0, NULL),
(349, '', 3, 1, 0, NULL),
(350, '', 7, 1, 0, NULL),
(351, '', 4, 1, 0, NULL),
(352, '', 1, 1, 0, NULL),
(353, '', 10, 1, 0, NULL),
(354, '', 10, 1, 0, NULL),
(355, '', 16, 1, 0, NULL),
(356, '', 13, 1, 0, NULL),
(357, '', 17, 1, 0, NULL),
(358, '', 7, 1, 0, NULL),
(359, '', 18, 1, 0, NULL),
(360, '', 14, 1, 0, NULL),
(361, '', 15, 1, 0, NULL),
(362, '', 13, 1, 0, NULL),
(363, '', 20, 1, 0, NULL),
(364, '', 1, 1, 0, NULL),
(365, '', 3, 1, 0, NULL),
(366, '', 10, 1, 0, NULL),
(367, '', 4, 1, 0, NULL),
(368, '', 5, 1, 0, NULL),
(369, '', 14, 1, 0, NULL),
(370, '', 13, 1, 0, NULL),
(371, '', 6, 1, 0, NULL),
(372, '', 8, 1, 0, NULL),
(373, '', 3, 1, 0, NULL),
(374, '', 9, 1, 0, NULL),
(375, '', 16, 1, 0, NULL),
(376, '', 12, 1, 0, NULL),
(377, '', 12, 1, 0, NULL),
(378, '', 5, 1, 0, NULL),
(379, '', 4, 1, 0, NULL),
(380, '', 7, 1, 0, NULL),
(381, '', 2, 1, 0, NULL),
(382, '', 8, 1, 0, NULL),
(383, '', 14, 1, 0, NULL),
(384, '', 8, 1, 0, NULL),
(385, '', 17, 1, 0, NULL),
(386, '', 19, 1, 0, NULL),
(387, '', 7, 1, 0, NULL),
(388, '', 16, 1, 0, NULL),
(389, '', 2, 1, 0, NULL),
(390, '', 14, 1, 0, NULL),
(391, '', 10, 1, 0, NULL),
(392, '', 4, 1, 0, NULL),
(393, '', 9, 1, 0, NULL),
(394, '', 12, 1, 0, NULL),
(395, '', 15, 1, 0, NULL),
(396, '', 17, 1, 0, NULL),
(397, '', 19, 1, 0, NULL),
(398, '', 6, 1, 0, NULL),
(399, '', 9, 1, 0, NULL),
(400, '', 10, 1, 0, NULL),
(401, '', 19, 1, 0, NULL),
(402, '', 9, 1, 0, NULL),
(403, '', 6, 1, 0, NULL),
(404, '', 19, 1, 0, NULL),
(405, '', 1, 1, 0, NULL),
(406, '', 5, 1, 0, NULL),
(407, '', 18, 1, 0, NULL),
(408, '', 20, 1, 0, NULL),
(409, '', 6, 1, 0, NULL),
(410, '', 6, 1, 0, NULL),
(411, '', 13, 1, 0, NULL),
(412, '', 6, 1, 0, NULL),
(413, '', 10, 1, 0, NULL),
(414, '', 12, 1, 0, NULL),
(415, '', 10, 1, 0, NULL),
(416, '', 15, 1, 0, NULL),
(417, '', 3, 1, 0, NULL),
(418, '', 8, 1, 0, NULL),
(419, '', 12, 1, 0, NULL),
(420, '', 14, 1, 0, NULL);
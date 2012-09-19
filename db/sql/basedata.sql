--
-- Dumping data for table `syn_access`
--

INSERT INTO `syn_access` (`id`, `name`, `access_value`) VALUES
(1, 'M.R.', 2),
(2, 'Market Mgr.', 4),
(3, 'Store Keeper', 6),
(5, 'Admin', 9),
(6, 'banned', -1);

--
-- Dumping data for table `syn_customertitle`
--

INSERT INTO `syn_customertitle` (`id`, `title`) VALUES
(1, 'Dr.'),
(2, 'JT,JTA'),
(3, 'Tech.'),
(4, 'Others');

--
-- Dumping data for table `syn_infotitle`
--

INSERT INTO `syn_infotitle` (`id`, `title`, `type`, `regexp`, `importance`, `visibility`) VALUES
(1, 'address', 'varchar', '', '1', '1'),
(2, 'phone', 'varchar', '', '2', '1'),
(3, 'addl1', 'varchar', '', '', ''),
(4, 'addl2', 'varchar', '', '', ''),
(5, 'email', 'varchar', '', '', '');

--
-- Dumping data for table `syn_unit`
--

INSERT INTO `syn_unit` (`id`, `unit_name`) VALUES
(1, 'ml'),
(2, 'lit.'),
(3, 'gm'),
(4, 'kg');

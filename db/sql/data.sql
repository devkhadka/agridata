-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2011 at 05:30 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `agricare_nepal`
--

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
-- Dumping data for table `syn_collection_plan`
--

INSERT INTO `syn_collection_plan` (`id`, `from_date`, `to_date`, `party_id`, `amount`, `created_at`, `created_by`) VALUES
(3, '2011-08-04', '2011-08-18', 5, '1222.00', '2011-08-11', 5),
(4, '2011-08-07', '2011-08-18', 2, '1300.00', '2011-08-28', 5),
(5, '2011-10-03', '2011-10-27', 5, '800.00', '2011-10-20', 4);


--
-- Dumping data for table `syn_customertitle`
--

INSERT INTO `syn_customertitle` (`id`, `title`) VALUES
(1, 'Dr.'),
(2, 'JT,JTA'),
(3, 'Tech.'),
(4, 'Others');

--
-- Dumping data for table `syn_dcr`
--

INSERT INTO `syn_dcr` (`id`, `collected_date`, `name`, `customer_title_id`, `remark`, `user_id`, `created_date`, `approved`, `approved_date`, `approved_by`) VALUES
(2, '2068-04-01', 'Mechi agro birtamod', 4, 'Our distributor visit', 9, '2011-07-27', 0, '0000-00-00 00:00:00', NULL),
(3, '2068-04-11', 'Jansewa Agrmvet, Amul Agrovet, Sindhu Agrovet, Pramila agrovet ', 4, 'Ngt.- Parsa Khairahani Retailer visit', 8, '2011-07-27', 0, '0000-00-00 00:00:00', NULL),
(4, '2011-07-27', 'Jansewa Agrmvet, Amul Agrovet, Sindhu Agrovet, Pramila agrovet ', 4, 'Ngt.- Parsa Khairahani Retailer visit', 8, '2011-07-27', 0, '0000-00-00 00:00:00', NULL),
(7, '2011-07-31', 'Chumaganesh agro center,bhaktapur. Bhaktapur beej bhandar,bhaktapur. ', 4, 'Aaja chumaganesh agro center bata stock linuko sathai ramro order pani liyeko chu. So order maile officema pani bhani sake. Pani parekole club rootko sample use garna pako chaina.', 5, '2011-07-31', 0, '0000-00-00 00:00:00', NULL),
(8, '2011-08-01', 'Harabhara agro vet, pokhara. Janasewa krisi bhandar, pokhara. Nepal krisi bhandar, pokhara. Unnati a', 4, 'Harabhara agro saga business ko kura bhayo agriguard projectle khojdai cha yo barsa business badcha bhanne kura bhako cha.', 5, '2011-08-01', 0, '0000-00-00 00:00:00', NULL),
(9, '2011-08-05', 'asee', 1, 'good', 5, '2011-08-11', 0, '0000-00-00 00:00:00', NULL),
(10, '2011-08-04', 'dinesh', 2, 'very good', 5, '2011-08-11', 0, '0000-00-00 00:00:00', NULL),
(11, '2011-08-15', 'Suresh', 2, 'Very useful person', 5, '2011-08-15', 0, '0000-00-00 00:00:00', NULL),
(12, '2011-08-18', 'Pooja Agrovet. Shiva Agrovet. Palung Beej Bhandar. Samudayik Krishi pasal. Niraj Pradhan. Pudasaini ', 4, 'Palung via Htd. to Ngt visit', 8, '2011-08-18', 0, '0000-00-00 00:00:00', NULL),
(15, '2011-08-19', 'Dawadi Agro Concern, Kisan Agro Traders, Chitwan agro pharma, Jansewa Agrovet, Prashant Agro', 4, 'Dawadi,Ctn. Agro, Kisan Agro discussion about payement.', 8, '2011-08-19', 0, '0000-00-00 00:00:00', NULL),
(16, '2011-08-20', 'Saturday', 4, 'Saturday', 8, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(17, '2011-08-18', 'Chumaganesh agro, bhaktapur. Harc, kalimati. New everest agro,kalimati. National agro, lagankhel.', 4, 'Chumaganesh agro bata 100000 rs aayo.', 5, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(18, '2011-08-19', 'Chumaganesh agro center,bhaktapur. Gramid agro,dolalghat. Sambhu parajuli,kuntabesi. Jugal agro vet,', 4, 'Sabai partylai prise badeko jankari garaye.', 5, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(19, '2011-08-21', 'Dawadi agrovet, Maadi agrovet, ctn.vet,maadi, paudel agrovet, bhurtel agrovet, machhapuchchhre co. L', 4, 'Ngt-Maadi', 8, '2011-08-21', 0, '0000-00-00 00:00:00', NULL),
(20, '2011-08-22', 'Bhurtel agrovet, chapagain agrovet, poudel agrovet, kisan agrovet, hi-himal seed.', 2, 'Maadi, Jagatpur, Ngt.', 8, '2011-08-23', 0, '0000-00-00 00:00:00', NULL),
(21, '2011-08-23', 'Bishal vet, Kisan agro, Dawadi agro, Milijuli agro, Sharma agro, Bhandari agro, Neupane agro, Aachal', 2, 'Ngt., Chanouli, Meghauli ', 8, '2011-08-23', 0, '0000-00-00 00:00:00', NULL),
(22, '2011-08-24', 'Sajha agrovet, Aryal agro supp. Jyamire krishi, Sindhu agrovet, Jansewa agrovet, Kisan agrovet, Laxm', 2, 'Ngt.-Bhandara', 8, '2011-08-24', 0, '0000-00-00 00:00:00', NULL),
(23, '2011-08-30', 'Saanu', 2, 'Excellent', 5, '2011-08-27', 0, '0000-00-00 00:00:00', NULL),
(24, '2011-08-02', 'asee', 3, 'nice\r\n', 5, '2011-08-28', 0, '0000-00-00 00:00:00', NULL),
(25, '2011-08-03', 'asee', 4, 'niceeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 5, '2011-08-29', 0, '0000-00-00 00:00:00', NULL),
(26, '2011-10-19', 'asee', 1, 'nice', 4, '2011-10-18', 0, '0000-00-00 00:00:00', NULL),
(27, '2011-10-15', 'naanu', 1, 'nice very nice', 4, '2011-10-18', 0, '0000-00-00 00:00:00', NULL),
(28, '2011-11-08', 'asee', 2, 'Very good\r\n', 5, '2011-11-03', 0, '0000-00-00 00:00:00', NULL);

--
-- Dumping data for table `syn_headquater`
--


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
-- Dumping data for table `syn_infovalues`
--

INSERT INTO `syn_infovalues` (`id`, `info_id`, `profile_id`, `value`) VALUES
(3, 1, 10, 'chamasing,bhktapur'),
(4, 2, 10, '9841299691'),
(5, 1, 11, 'mahadebbasi,dhading'),
(6, 2, 11, '016216135'),
(7, 1, 12, 'trisuli'),
(8, 2, 12, '9751087159'),
(9, 1, 13, 'pokhara'),
(10, 2, 13, '9846051967'),
(11, 1, 14, 'Palpa'),
(12, 2, 14, '075-521950'),
(13, 1, 15, 'Dhangadi'),
(14, 2, 15, '091-522687'),
(15, 1, 16, 'Dang'),
(16, 2, 16, '082-560529'),
(17, 1, 17, 'Nepalgunj'),
(18, 2, 17, '081-520961'),
(19, 1, 18, 'Tandi'),
(20, 2, 18, '056-560763'),
(21, 1, 19, 'Narayangarh'),
(22, 2, 19, '056-520484'),
(23, 1, 20, 'Hetauda'),
(24, 2, 20, '057-523278'),
(25, 1, 21, 'Narayangarh'),
(26, 2, 21, '056-525544'),
(27, 1, 22, 'khurkhure'),
(28, 2, 22, '9845024328'),
(29, 1, 23, 'Chapur'),
(30, 2, 23, '9855040005'),
(31, 1, 24, 'Jhapa'),
(32, 2, 24, '023-540092'),
(33, 1, 25, 'Biratnagar'),
(34, 2, 25, '021-536922'),
(35, 1, 26, 'Fikkal'),
(36, 2, 26, '027-540335'),
(37, 1, 27, 'Jhapa'),
(38, 2, 27, '023-521485'),
(39, 1, 28, 'Jhapa'),
(40, 2, 28, '023-480146');

--
-- Dumping data for table `syn_material`
--


--
-- Dumping data for table `syn_ndprice`
--

INSERT INTO `syn_ndprice` (`id`, `product_id`, `price`, `effective_date`, `user_id`) VALUES
(2, 2, '62.10', '2011-08-01', 1),
(3, 3, '72.45', '2011-01-12', 1),
(4, 4, '241.00', '2011-01-02', 1),
(5, 5, '75', '2010-01-01', 1),
(6, 6, '138.00', '2011-08-01', 1),
(7, 7, '31.05', '2011-01-09', 1),
(8, 8, '75.90', '2011-01-01', 1),
(9, 10, '48.3', '2011-01-01', 1),
(10, 11, '75', '2010-01-01', 1),
(11, 12, '75', '2010-01-01', 1),
(12, 13, '75', '2010-01-01', 1),
(13, 14, '75', '2010-01-01', 1),
(14, 15, '75', '2010-01-01', 1),
(15, 16, '75', '2010-01-01', 1),
(16, 17, '75', '2010-01-01', 1),
(17, 18, '75', '2010-01-01', 1),
(18, 19, '75', '2010-01-01', 1),
(19, 20, '75', '2010-01-01', 1),
(20, 21, '75', '2010-01-01', 1),
(21, 22, '75', '2010-01-01', 1),
(22, 23, '75', '2010-01-01', 1),
(23, 24, '75', '2010-01-01', 1),
(24, 25, '75', '2010-01-01', 1),
(25, 26, '75', '2010-01-01', 1),
(26, 27, '75', '2010-01-01', 1),
(27, 28, '75', '2010-01-01', 1),
(28, 29, '75', '2010-01-01', 1),
(29, 30, '75', '2010-01-01', 1),
(30, 31, '75', '2010-01-01', 1),
(31, 32, '75', '2010-01-01', 1),
(32, 33, '75', '2010-01-01', 1),
(33, 34, '75', '2010-01-01', 1),
(34, 35, '75', '2010-01-01', 1),
(35, 36, '75', '2010-01-01', 1),
(36, 37, '75', '2010-01-01', 1),
(37, 38, '75', '2010-01-01', 1),
(38, 39, '75', '2010-01-01', 1),
(39, 40, '176.64', '2011-01-01', 1),
(40, 41, '322.92', '2011-01-01', 1),
(41, 42, '573.39', '2011-01-01', 1),
(42, 43, '2637.18', '2011-01-01', 1),
(43, 44, '75', '2010-01-01', 1),
(44, 45, '75', '2010-01-01', 1),
(45, 46, '75', '2010-01-01', 1),
(46, 47, '75', '2010-01-01', 1),
(48, 49, '51.75', '2011-01-16', 1),
(49, 50, '134.55', '2011-01-01', 1),
(50, 51, '217.35', '2011-01-01', 1),
(52, 53, '75', '2010-01-01', 1),
(53, 54, '75', '2010-01-01', 1),
(56, 57, '75', '2010-01-01', 1),
(57, 58, '75', '2010-01-01', 1),
(58, 59, '75', '2010-01-01', 1),
(59, 60, '75', '2010-01-01', 1),
(60, 61, '75', '2010-01-01', 1),
(61, 62, '75', '2010-01-01', 1),
(62, 63, '75', '2010-01-01', 1),
(63, 64, '75', '2010-01-01', 1),
(69, 2, '200', '2011-10-19', 1),
(70, 2, '300', '2011-10-31', 1);

--
-- Dumping data for table `syn_news`
--

INSERT INTO `syn_news` (`id`, `title`, `body`, `date`, `userid`) VALUES
(1, 'metting', 'staff meting', '2011-04-29', 1),
(2, 'Agricultural student ', 'Agricare Nepal is helping the student who have the innovative concept in the agricultural field, Please let us know if u have any creative idea .', '2010-09-17', 1),
(3, 'test news', 'this is test news', '2011-06-01', 1),
(4, 'My news', 'this is my news.com', '2011-07-18', 1);

--
-- Dumping data for table `syn_party`
--

INSERT INTO `syn_party` (`id`, `profile_id`) VALUES
(2, 10),
(3, 11),
(4, 12),
(5, 13),
(6, 14),
(7, 15),
(8, 16),
(9, 17),
(10, 18),
(11, 19),
(12, 20),
(13, 21),
(14, 22),
(15, 23),
(16, 24),
(17, 25),
(18, 26),
(19, 27),
(20, 28);

--
-- Dumping data for table `syn_partystock`
--

INSERT INTO `syn_partystock` (`id`, `collected_date`, `party_id`, `product_id`, `no_of_case`, `indivisual`, `user_id`, `created_date`) VALUES
(4, '2011-07-27', 11, 5, 1, 0, 8, '2011-07-29'),
(5, '2011-07-27', 11, 3, 3, 0, 8, '2011-07-29'),
(6, '2011-07-27', 11, 18, 5, 0, 8, '2011-07-29'),
(7, '2011-07-27', 11, 17, 4, 0, 8, '2011-07-29'),
(8, '2011-07-27', 11, 16, 4, 0, 8, '2011-07-29'),
(9, '2011-07-27', 11, 15, 1, 0, 8, '2011-07-29'),
(10, '2011-07-27', 11, 30, 3, 0, 8, '2011-07-29'),
(11, '2011-07-27', 11, 62, 2, 0, 8, '2011-07-29'),
(12, '2011-07-27', 11, 61, 5, 0, 8, '2011-07-29'),
(13, '2011-07-27', 11, 60, 4, 0, 8, '2011-07-29'),
(14, '2011-07-27', 11, 63, 1, 0, 8, '2011-07-29'),
(15, '2011-07-27', 11, 13, 2, 0, 8, '2011-07-29'),
(16, '2011-07-27', 11, 58, 3, 0, 8, '2011-07-29'),
(17, '2011-07-27', 11, 57, 2, 0, 8, '2011-07-29'),
(18, '2011-07-27', 11, 23, 1, 0, 8, '2011-07-29'),
(19, '2011-07-27', 11, 22, 2, 0, 8, '2011-07-29'),
(20, '2011-07-27', 11, 27, 5, 0, 8, '2011-07-29'),
(21, '2011-07-27', 11, 26, 5, 0, 8, '2011-07-29'),
(22, '2011-07-27', 11, 25, 1, 0, 8, '2011-07-29'),
(23, '2011-07-27', 11, 24, 3, 0, 8, '2011-07-29'),
(24, '2011-07-27', 11, 28, 3, 0, 8, '2011-07-29'),
(25, '2011-07-27', 11, 32, 4, 0, 8, '2011-07-29'),
(26, '2011-07-27', 11, 31, 2, 0, 8, '2011-07-29'),
(27, '2011-07-27', 11, 33, 3, 0, 8, '2011-07-29'),
(28, '2011-07-31', 2, 5, 3, 0, 5, '2011-07-31'),
(29, '2011-07-31', 2, 5, 3, 0, 5, '2011-07-31'),
(30, '2011-07-31', 2, 5, 0, 6, 5, '2011-07-31'),
(31, '2011-07-31', 2, 50, 0, 1, 5, '2011-07-31'),
(32, '2011-07-31', 2, 3, 4, 1, 5, '2011-07-31'),
(33, '2011-07-31', 2, 9, 12, 1, 5, '2011-07-31'),
(34, '2011-07-31', 2, 8, 9, 1, 5, '2011-07-31'),
(35, '2011-07-31', 2, 41, 0, 1, 5, '2011-07-31'),
(36, '2011-07-31', 2, 10, 4, 0, 5, '2011-07-31'),
(37, '2011-07-31', 2, 17, 12, 0, 5, '2011-07-31'),
(38, '2011-07-31', 2, 16, 4, 0, 5, '2011-07-31'),
(39, '2011-07-31', 2, 15, 1, 0, 5, '2011-07-31'),
(40, '2011-07-31', 2, 60, 4, 0, 5, '2011-07-31'),
(41, '2011-07-31', 2, 62, 9, 0, 5, '2011-07-31'),
(42, '2011-07-31', 2, 61, 10, 0, 5, '2011-07-31'),
(43, '2011-07-31', 2, 13, 1, 0, 5, '2011-07-31'),
(44, '2011-07-31', 2, 12, 2, 0, 5, '2011-07-31'),
(45, '2011-07-31', 2, 59, 1, 0, 5, '2011-07-31'),
(46, '2011-07-31', 2, 58, 4, 0, 5, '2011-07-31'),
(47, '2011-07-31', 2, 57, 6, 0, 5, '2011-07-31'),
(48, '2011-07-31', 2, 23, 2, 0, 5, '2011-07-31'),
(49, '2011-07-31', 2, 22, 5, 0, 5, '2011-07-31'),
(50, '2011-07-31', 2, 26, 6, 0, 5, '2011-07-31'),
(51, '2011-07-31', 2, 25, 16, 0, 5, '2011-07-31'),
(52, '2011-07-31', 2, 28, 16, 0, 5, '2011-07-31'),
(53, '2011-07-31', 2, 35, 0, 2, 5, '2011-07-31'),
(54, '2011-07-31', 2, 32, 4, 0, 5, '2011-07-31'),
(55, '2011-08-30', 3, 6, 12, 12, 5, '2011-08-28'),
(57, '2011-08-09', 3, 5, 5, 5, 5, '2011-08-28'),
(58, '2011-08-09', 3, 6, 6, 68, 5, '2011-08-28'),
(59, '2011-08-09', 3, 4, 8, 8, 5, '2011-08-28'),
(60, '2011-08-09', 3, 49, 9, 9, 5, '2011-08-28'),
(61, '2011-08-09', 3, 7, 5, 7, 5, '2011-08-28'),
(62, '2011-08-09', 3, 2, 6, 9, 5, '2011-08-28'),
(63, '2011-08-09', 3, 44, 3, 3, 5, '2011-08-28'),
(64, '2011-08-09', 3, 47, 3, 5, 5, '2011-08-28'),
(65, '2011-08-09', 3, 46, 6, 8, 5, '2011-08-28'),
(66, '2011-08-26', 3, 5, 89, 89, 5, '2011-08-30'),
(67, '2011-08-26', 3, 4, 89, 9, 5, '2011-08-30'),
(68, '2011-08-30', 3, 5, 121, 121, 5, '2011-08-31'),
(69, '2011-10-19', 2, 5, 12, 12, 5, '2011-10-18'),
(70, '2011-10-18', 2, 5, 5, 5, 5, '2011-10-24'),
(71, '2011-10-18', 2, 6, 5, 5, 5, '2011-10-24'),
(72, '2011-10-18', 2, 4, 55, 5, 5, '2011-10-24'),
(73, '2011-10-18', 2, 49, 55, 55, 5, '2011-10-24'),
(74, '2011-10-18', 2, 7, 5, 7, 5, '2011-10-24'),
(75, '2011-10-12', 2, 5, 7, 7, 5, '2011-10-24'),
(76, '2011-10-12', 2, 6, 87, 87, 5, '2011-10-24'),
(77, '2011-10-12', 2, 4, 6, 6, 5, '2011-10-24'),
(78, '2011-11-09', 2, 5, 12, 12, 5, '2011-11-03'),
(79, '2011-11-08', 7, 5, 23, 2, 4, '2011-11-09');

--
-- Dumping data for table `syn_party_due`
--

INSERT INTO `syn_party_due` (`id`, `collected_date`, `amount`, `party_id`, `created_by`, `created_at`) VALUES
(5, now(), '12.00', 10, 1, NULL),
(3, '2011-07-28', '15000.00', 3, 1, NULL),
(4, '2011-07-15', '10000.00', 10, 1, NULL),
(2, '2011-07-06', '10000.00', 10, 1, '2011-07-31'),
(6, '2011-11-10', '100.00', 10, 1, '2011-11-08'),
(7, '2011-11-08', '1000.00', 9, 1, '2011-11-09');

--
-- Dumping data for table `syn_party_headquater`
--


--
-- Dumping data for table `syn_party_user`
--

INSERT INTO `syn_party_user` (`id`, `party_id`, `user_id`) VALUES
(2, 2, 5),
(3, 3, 5),
(4, 4, 5),
(5, 5, 4),
(6, 6, 7),
(7, 7, 4),
(8, 8, 7),
(9, 9, 7),
(10, 10, 8),
(11, 11, 8),
(12, 12, 8),
(13, 13, 8),
(14, 14, 8),
(15, 15, 8),
(16, 16, 9),
(17, 17, 9),
(18, 18, 9),
(19, 19, 9),
(20, 20, 9);

--
-- Dumping data for table `syn_product`
--

INSERT INTO `syn_product` (`id`, `name`, `quantity`, `unit_id`, `no_in_case`, `active`) VALUES
(2, 'Agrinol Plus', '100', 1, '72', 1),
(3, 'Agrizinc Plus', '1', 4, '50', 1),
(4, 'Agriguard', '100', 1, '72', 1),
(5, 'Agricin', '50', 3, '96', 1),
(6, 'Agriguard', '50', 1, '96', 1),
(7, 'Agrinol', '50', 1, '144', 1),
(8, 'Agrizyme', '100', 1, '100', 1),
(9, 'Agrizyme', '250', 1, '40', 1),
(10, 'Agroliv Cole Spl', '250', 3, '64', 1),
(11, 'Agroliv Cole Spl', '500', 3, '32', 1),
(12, 'Agroliv potato Spl', '250', 3, '64', 1),
(13, 'Agroliv potato Spl', '500', 3, '32', 1),
(14, 'Agroliv potato Spl', '1', 4, '16', 1),
(15, 'Agroliv fs', '50', 1, '144', 1),
(16, 'Agroliv fs', '100', 1, '100', 1),
(17, 'Agroliv fs', '250', 1, '40', 1),
(18, 'Agroliv fs', '500', 1, '20', 1),
(19, 'Agroliv fs', '5', 2, '3', 1),
(20, 'Biojeb', '50', 1, '96', 1),
(21, 'Biojeb', '100', 1, '72', 1),
(22, 'Chelazin', '50', 3, '96', 1),
(23, 'Chelazin', '100', 3, '72', 1),
(24, 'Poshan', '50', 1, '144', 1),
(25, 'Poshan', '100', 1, '100', 1),
(26, 'Poshan', '250', 1, '40', 1),
(27, 'Poshan', '500', 1, '20', 1),
(28, 'Poshan plus', '1', 4, '25', 1),
(29, 'Sticker', '50', 1, '144', 1),
(30, 'Agroliv fs', '1', 2, '12', 1),
(31, 'Sticker', '100', 1, '100', 1),
(32, 'Sticker', '250', 1, '40', 1),
(33, 'Sticker', '500', 1, '20', 1),
(34, 'Sticker', '1', 2, '12', 1),
(35, 'Sticker', '5', 2, '3', 1),
(36, 'Agroliv Tea Special', '250', 1, '40', 1),
(37, 'Agroliv Tea Special', '500', 1, '20', 1),
(38, 'Agroliv Tea Special', '1', 2, '12', 1),
(39, 'Agroliv Tea Special', '5', 2, '3', 1),
(40, 'Agrizyme Tea Special', '250', 1, '40', 1),
(41, 'Agrizyme Tea Special', '500', 1, '20', 1),
(42, 'Agrizyme Tea Special', '1', 2, '12', 1),
(43, 'Agrizyme Tea Special', '5', 2, '3', 1),
(44, 'Poshan Tea Special', '250', 1, '40', 1),
(45, 'Poshan Tea Special', '500', 1, '20', 1),
(46, 'Poshan Tea Special', '1', 2, '12', 1),
(47, 'Poshan Tea Special', '5', 2, '3', 1),
(49, 'Agrinol', '100', 1, '96', 1),
(50, 'Agrinol Plus ', '250', 1, '40', 1),
(51, 'Agrinol Plus ', '500', 1, '20', 1),
(53, 'Chelazin Tea Special', '250', 3, '64', 1),
(54, 'Chelazin Tea Special', '500', 3, '32', 1),
(57, 'BORO M', '100', 1, '72', 1),
(58, 'BORO M', '250', 1, '40', 1),
(59, 'BORO M', '500', 1, '20', 1),
(60, 'AGROLIV NPK', '100', 1, '100', 1),
(61, 'AGROLIV NPK', '250', 1, '40', 1),
(62, 'AGROLIV NPK', '500', 1, '20', 1),
(63, 'AGROLIV NPK', '1', 2, '12', 1),
(64, 'bio side trivi', '1', 4, '5', 1);

--
-- Dumping data for table `syn_productdetails`
--


--
-- Dumping data for table `syn_profile`
--

INSERT INTO `syn_profile` (`id`, `name`) VALUES
(4, 'Mahendra raj poudel'),
(5, 'bivek dahal'),
(7, 'basanta raj khanel'),
(8, 'dinesh dhungana'),
(9, 'Tiko pendra Mani Sharma'),
(10, 'chuma ganesh bizze bhandar'),
(11, 'bidari agrovet'),
(12, 'niranjana agro supplyers'),
(13, 'haravara agri center'),
(14, 'Bhandari Agrovet'),
(15, 'Krishak Sahayog Kendra'),
(16, 'Siddartha Agri Center'),
(17, 'Sagarmatha Agrovet'),
(18, 'Chitwan Agro Pharma'),
(19, 'Dawadi Agro Pharma'),
(20, 'Kheti Sewa Pasal'),
(21, 'Sahayogi Agrovet'),
(22, 'ParsantaAgrovet'),
(23, 'Mangaleshor Agrovet'),
(24, 'Mechi Agrovet'),
(25, 'Sairam Agro Traders'),
(26, 'Shah Agrovet'),
(27, 'Biochem Agro Trade Center'),
(28, 'Nava Joti Krishi Bhandar'),
(29, 'asee'),
(30, 'asee'),
(34, 'Asee Shrestha');

--
-- Dumping data for table `syn_sales_plan`
--

INSERT INTO `syn_sales_plan` (`id`, `from_date`, `to_date`, `party_id`, `created_at`, `created_by`) VALUES
(4, '2011-07-20', '2011-07-31', 3, '2011-07-30', 5),
(6, '2011-08-04', '2011-08-18', 2, '2011-08-28', 5),
(7, '2011-10-16', '2011-10-20', 2, '2011-10-18', 5),
(9, '2011-10-25', '2011-10-26', 2, '2011-10-24', 5),
(10, '2011-10-18', '2011-10-26', 2, '2011-10-24', 5);

--
-- Dumping data for table `syn_sales_plan_detail`
--

INSERT INTO `syn_sales_plan_detail` (`id`, `sales_plan_id`, `product_id`, `plan_case`, `plan_individual`, `discount_case`, `discount_individual`) VALUES
(10, 6, 5, 9, 9, 1, 4),
(11, 7, 5, 12, 11, 11, 1),
(13, 9, 5, 4, 4, 2, 2),
(14, 10, 5, 4, 4, 4, 4),
(15, 10, 6, 4, 4, 5, 3),
(16, 10, 4, 6, 3, 5, 6),
(17, 10, 49, 5, 5, 5, 5),
(18, 10, 7, 5, 5, 5, 5),
(19, 10, 2, 5, 0, 0, 5),
(20, 10, 51, 5, 0, 0, 0);

--
-- Dumping data for table `syn_stock`
--


--
-- Dumping data for table `syn_tada`
--

INSERT INTO `syn_tada` (`id`, `visited_date`, `visit_place`, `distance`, `da`, `other`, `remark`, `user_id`, `created_date`, `approved`, `approved_date`, `approved_by`) VALUES
(2, '2011-07-27', 'bhaktapur', '75', '250', '60', ' 60 rupee ko ompssion di ya ko yeuta keta lai \r\n', 5, '2011-07-27', 0, '0000-00-00 00:00:00', NULL),
(3, '2068-07-27', 'Ngt.Parsa,khairahani ', '80 ', '200', '', 'Retailer visit', 8, '2011-07-27', 0, '0000-00-00 00:00:00', NULL),
(4, '2011-07-31', 'Kalimati to Bhaktapur', '60 ', '200', '1', 'Nothing', 5, '2011-07-31', 0, '0000-00-00 00:00:00', NULL),
(5, '2011-08-01', 'Kathmandu to pokhara', '200', '500', '100', 'Nothing', 5, '2011-08-01', 0, '0000-00-00 00:00:00', NULL),
(6, '2068-05-01', 'Palung, Hetaunda', '160 ', '250', '', 'Palung, Htd. Ngt.', 8, '2011-08-18', 0, '0000-00-00 00:00:00', NULL),
(7, '2011-08-18', 'Palung, Hetaunda', '160 ', '250', '', 'Palung, Htd, Ngt', 8, '2011-08-19', 0, '0000-00-00 00:00:00', NULL),
(8, '2011-08-18', 'Kathmandu, bhaktapur, lagankhel', '70', '250', '1', 'Nothing', 5, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(9, '2011-08-19', 'Bhaktapur,dolalghat,kuntabesi,dhulikhel,panauti,nala.', '180', '250', '1', 'Nothing', 5, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(10, '2011-08-19', 'Ngt., Tandi, Khurkhure', '70', '250', '00', 'Ngt', 8, '2011-08-20', 0, '0000-00-00 00:00:00', NULL),
(11, '2011-08-21', 'Ngt,jagatpur,Maadi', '85', '700', '', 'Ngt,jagatpur,Maadi', 8, '2011-08-21', 0, '0000-00-00 00:00:00', NULL),
(12, '2011-08-22', 'Maadi, Jagatpur, Ngt', '85', '250', '', 'Maadi-Ngt.', 8, '2011-08-23', 0, '0000-00-00 00:00:00', NULL),
(13, '2011-08-23', 'Ngt., Chanouli, Meghauli', '70', '250', '', 'Ngt., Meghauli', 8, '2011-08-23', 0, '0000-00-00 00:00:00', NULL),
(14, '2011-08-24', 'Ngt., Parsa, Bhandara', '80', '250', '00', 'Ngt.-Bhandara', 8, '2011-08-24', 0, '0000-00-00 00:00:00', NULL),
(15, '2011-08-15', 'Nepalgunjuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu', '15', '3000', '400', 'Very Good.', 5, '2011-08-28', 0, '0000-00-00 00:00:00', NULL),
(16, '2011-10-16', 'Tamakoshi', '8', '10', '19', 'Very good', 5, '2011-10-18', 0, '0000-00-00 00:00:00', NULL),
(19, '2011-10-26', 'nepal', '5', '7', '7', 'good', 5, '2011-10-23', 0, '0000-00-00 00:00:00', NULL),
(20, '2011-10-25', 'myanmar', '6', '45', '7', 'nice', 5, '2011-10-23', 0, '0000-00-00 00:00:00', NULL),
(21, '2011-10-20', 'nepal', '6', '6', '7', 'nice', 5, '2011-10-23', 0, '0000-00-00 00:00:00', NULL),
(22, '2011-11-02', 'palpa', '5', '45', '3', 'good', 5, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(23, '2011-11-02', 'nepal', '5', '6', '3', 'good', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(24, '2011-10-05', 'nepal', '5', '6', '6', 'goood', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(25, '2011-11-03', 'nepal', '7', '7', '7', 'nice', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(26, '2011-11-04', 'nepal', '7', '7', '7', 'nice', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(27, '2011-11-01', 'Birgunj', '4', '3', '8', 'good', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL),
(28, '2011-11-07', 'Birgunj', '7', '6', '56', 'good', 4, '2011-11-03', 0, '0000-00-00 00:00:00', NULL);

--
-- Dumping data for table `syn_tasetting`
--

INSERT INTO `syn_tasetting` (`id`, `amount`, `effective_date`, `user_id`) VALUES
(2, 3, '2011-07-17', 4),
(3, 3, '2011-07-17', 5),
(4, 8, '2011-07-17', 7),
(5, 3, '2011-07-17', 8),
(6, 3, '2011-07-17', 9),
(7, 3, '2011-08-01', 5),
(8, 3, '2011-08-01', 7),
(9, 3, '2011-08-01', 8),
(10, 3, '2011-08-01', 9),
(11, 3, '2011-08-01', 8),
(12, 39, '2011-11-05', 5),
(13, 40, '2011-11-03', 5),
(14, 100, '2011-11-07', 10);

--
-- Dumping data for table `syn_unit`
--

INSERT INTO `syn_unit` (`id`, `unit_name`) VALUES
(1, 'ml'),
(2, 'lit.'),
(3, 'gm'),
(4, 'kg');

--
-- Dumping data for table `syn_user`
--

INSERT INTO `syn_user` (`id`, `username`, `password`, `access_value`, `profile_id`, `manager_id`, `created_date`, `last_login`) VALUES
(1, 'admin', '2aefc34200a294a3cc7db81b43a81873', 9, 34, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'raaj', 'fd66a4f14f46a2af3ea6bc3a691895ac', 4, 4, NULL, '2011-07-26 01:30:54', '0000-00-00 00:00:00'),
(5, 'bivek', '539971fbf9c079394cf17532412825a3', 2, 5, 4, '2011-07-26 02:03:08', '0000-00-00 00:00:00'),
(7, 'basanta', '5fffc649f786af4404538dda21a1708d', 2, 7, 4, '2011-07-26 02:30:14', '0000-00-00 00:00:00'),
(8, 'dinesh', 'fd66a4f14f46a2af3ea6bc3a691895ac', 4, 8, NULL, '2011-07-26 02:38:43', '0000-00-00 00:00:00'),
(9, 'bharat', 'dfb57b2e5f36c1f893dbc12dd66897d4', 2, 9, 4, '2011-07-26 02:45:41', '0000-00-00 00:00:00'),
(10, 'asee', '845ea8e40c18cb139d843f5125a3a86f', 2, 29, 4, '2011-07-28 02:59:33', '0000-00-00 00:00:00'),
(11, 'Naamu', '845ea8e40c18cb139d843f5125a3a86f', 2, 30, 8, '2011-11-09 17:44:04', '0000-00-00 00:00:00');

--
-- Dumping data for table `syn_user_headquater`
--


--
-- Dumping data for table `syn_visit_plan`
--

INSERT INTO `syn_visit_plan` (`id`, `user_id`, `collected_date`, `place`, `description`, `remark`, `created_at`, `updated_at`, `approved`, `approved_date`, `approved_by`) VALUES
(2, 5, '2011-07-15', 'heutanda', '', 'helllo sir for the collection ', '2011-07-28 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(3, 5, '2011-08-20', 'Kathmanduuuuuuuuuuuuuuuuuuuu', '', 'Very Goodaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2011-08-28 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(4, 5, '2011-10-17', 'Hetauda', '', 'Good', '2011-10-18 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(5, 4, '2011-10-17', 'nepal', '', 'nice', '2011-10-18 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(6, 8, '2011-10-19', 'nepal', '', 'good', '2011-10-18 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(7, 5, '2011-10-20', 'NEPAL', '', 'GOOD', '2011-10-21 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(8, 5, '2011-10-13', 'narayanghat', '', 'nice', '2011-10-21 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(9, 5, '2011-10-21', 'palpa', '', 'nice', '2011-10-21 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(14, 5, '2011-10-11', 'catmadnu', '', 'good\r\n', '2011-10-22 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(20, 5, '2011-10-07', 'catmadnu', '', 'sample test', '2011-10-22 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(21, 5, '2011-10-08', 'nepal', '', 'document', '2011-10-22 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(33, 5, '2011-10-19', 'nepal', '', 'good', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(34, 5, '2011-10-12', 'nepalgunj', '', 'goood', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(35, 5, '2011-10-28', 'nepalgunj', '', 'nice', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(36, 5, '2011-10-27', 'nepalgunj', '', 'nice', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(37, 5, '2011-10-26', 'nepal', '', 'good', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(38, 5, '2011-10-31', 'nepalgunj', '', 'nice', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(39, 5, '2011-10-25', 'nepalgunj', '', 'ncie', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(40, 5, '2011-10-24', 'nepalgunj', '', 'dfd', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(41, 5, '2011-10-15', 'nepalgunj', '', 'nice', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL),
(42, 5, '2011-10-10', 'nepalgunj', '', 'hello', '2011-10-23 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', NULL);

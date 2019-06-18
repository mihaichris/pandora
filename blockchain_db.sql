-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2019 at 07:48 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blockchain_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('Investitor', '3', 1541959748),
('Miner', '2', 1540495937),
('Miner', '4', 1543136431),
('Miner', '5', 1552122131);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('Admin', 1, 'Adminul are acces la toate configuratiile si comenzile aplicatiei', NULL, NULL, 1540672732, 1540672732),
('Investitor', 1, 'Investitorul este persoana care este focusata pe investirea  in retea si efectuarea de tranzactii.', NULL, NULL, 1538212637, 1538212637),
('Miner', 1, 'Minerul este persoana care valideaza tranzactiile din retea, cripteaza blocurile si mentine reteaua stabila.', NULL, NULL, 1537293320, 1537293320);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

DROP TABLE IF EXISTS `block`;
CREATE TABLE `block` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `previous_hash` varchar(200) DEFAULT NULL,
  `miner_id` int(11) DEFAULT NULL,
  `fees` double DEFAULT NULL,
  `proof_of_work` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`id`, `timestamp`, `previous_hash`, `miner_id`, `fees`, `proof_of_work`) VALUES
(1, '2019-05-25 10:51:19', '00000a4004a3cc3c2f692ededd836f4557b0818c34fc8c6cdf9bc58ab5f6c69b86fea5bc6c63845279bf31ad022c7a9d7ab270be7f328f40482fea10e520aaa9', 4, 0, 152295),
(2, '2019-05-25 10:52:06', '0000ceb05d540081a28a94819f24cb1d0de928b8cd74b53f51f031f61b24271cf7668e9420b30fb14e5d18f5f5b5029ccda2547ed8f3b560f8d8eb1437e4df72', 2, 0.1, 1523),
(3, '2019-05-25 10:58:11', '0000ab764bbb944abed59d6359242ab1ccd10d54fe071616b81f72e4883d77c03bc100ba8053789cb23beb59a27bf81d8bf72061602adfbb7917324853fd6fa6', 4, 0.2, 37704),
(4, '2019-05-25 11:13:03', '000056c3531b068ae1c766ca26246e466ff19139f3e0ad749a6640b71541df5af3aaf0d7e0b9ff5a1391ab8a19f2f149068062ccf014d769efdca8a259422714', 2, 2.5, 78094),
(5, '2019-05-25 11:22:06', '00007082f2e4fe2279b913bf67a98efa5615855f0a5b04f2f4254fb7fbd673b072069dffde2620f7df9dea65cb19f59f9e699d154d3aacdbbcc052055e5b69e3', 4, 1.6, 39164),
(6, '2019-05-25 11:34:44', '000034462793deec85b7431627dbf6217e66c85989bd1bfba5eb342962fee7ed56b1d6194e1038bcba7e6ada517b0449b8d4414e3c75ee23181a2a77eed78346', 2, 0.3, 24647),
(7, '2019-05-25 11:41:57', '00009ad5fee5b3162f4157d9b09ae83cc83eed750ff72f142f16acb57f68ebc06b19300b3ae8635cff3f9879e81ccd23d88d2070ea925a036dbb8a4b9edac8fc', 4, 2.3, 142998),
(8, '2019-05-25 16:40:20', '000058eb6c0f1caa21b41c3a04f4ac44a83d420a9c755f22b5ab779be4d7df45aa3e591b1b894a4713647a2b295387ad420920e46cb8daaffa9c8d08dcac572e', 4, 0, 4501),
(9, '2019-05-25 16:46:50', '000071c5073cebf04a05a24f1e21eede553e3ca21113eb9c1d6deaaf8affe1040f4e63761835654b1b2dfa45818e789501efae0c0b3b1e6e382b102169655e38', 2, 0, 29777),
(10, '2019-06-01 12:30:15', '00004182ef33cdf0212d25c88f1b83281d158971cba34b0735ab0bdf5124ecd49870c768ee8b79bf26196363208ed1eb455db55b6e3fc0169231f2f88dc6c8a4', 2, 0, 136398),
(11, '2019-06-12 21:05:16', '00002323dcdc72d9fdc50a21c1d1508fce4716006c717a2c19a7190db2febb1e78d0861a99bed56515549018f2a257d2aaf8ae0e4a7b0238b886f2b173f55644', 2, 0, 44240);

-- --------------------------------------------------------

--
-- Table structure for table `hash`
--

DROP TABLE IF EXISTS `hash`;
CREATE TABLE `hash` (
  `id` int(11) NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `hash` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hash`
--

INSERT INTO `hash` (`id`, `block_id`, `hash`) VALUES
(1, 1, '0000ceb05d540081a28a94819f24cb1d0de928b8cd74b53f51f031f61b24271cf7668e9420b30fb14e5d18f5f5b5029ccda2547ed8f3b560f8d8eb1437e4df72'),
(2, 2, '0000ab764bbb944abed59d6359242ab1ccd10d54fe071616b81f72e4883d77c03bc100ba8053789cb23beb59a27bf81d8bf72061602adfbb7917324853fd6fa6'),
(3, 3, '000056c3531b068ae1c766ca26246e466ff19139f3e0ad749a6640b71541df5af3aaf0d7e0b9ff5a1391ab8a19f2f149068062ccf014d769efdca8a259422714'),
(4, 4, '00007082f2e4fe2279b913bf67a98efa5615855f0a5b04f2f4254fb7fbd673b072069dffde2620f7df9dea65cb19f59f9e699d154d3aacdbbcc052055e5b69e3'),
(5, 5, '000034462793deec85b7431627dbf6217e66c85989bd1bfba5eb342962fee7ed56b1d6194e1038bcba7e6ada517b0449b8d4414e3c75ee23181a2a77eed78346'),
(6, 6, '00009ad5fee5b3162f4157d9b09ae83cc83eed750ff72f142f16acb57f68ebc06b19300b3ae8635cff3f9879e81ccd23d88d2070ea925a036dbb8a4b9edac8fc'),
(7, 7, '000058eb6c0f1caa21b41c3a04f4ac44a83d420a9c755f22b5ab779be4d7df45aa3e591b1b894a4713647a2b295387ad420920e46cb8daaffa9c8d08dcac572e'),
(8, 8, '000071c5073cebf04a05a24f1e21eede553e3ca21113eb9c1d6deaaf8affe1040f4e63761835654b1b2dfa45818e789501efae0c0b3b1e6e382b102169655e38'),
(9, 9, '00004182ef33cdf0212d25c88f1b83281d158971cba34b0735ab0bdf5124ecd49870c768ee8b79bf26196363208ed1eb455db55b6e3fc0169231f2f88dc6c8a4'),
(10, 10, '00002323dcdc72d9fdc50a21c1d1508fce4716006c717a2c19a7190db2febb1e78d0861a99bed56515549018f2a257d2aaf8ae0e4a7b0238b886f2b173f55644'),
(11, 11, '0000c6373146dea09fe5f75490e93864b6ac1d83cb3e239102159b69d91992a109dbbe0f775f84a904a0877a40a1eb18b649d0ec6fd27bde5d7f3728633fc740');

-- --------------------------------------------------------

--
-- Table structure for table `investor`
--

DROP TABLE IF EXISTS `investor`;
CREATE TABLE `investor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `investor`
--

INSERT INTO `investor` (`id`, `user_id`, `created_at`) VALUES
(1, 3, '2018-11-11 19:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `key_storage_item`
--

DROP TABLE IF EXISTS `key_storage_item`;
CREATE TABLE `key_storage_item` (
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mempool`
--

DROP TABLE IF EXISTS `mempool`;
CREATE TABLE `mempool` (
  `id` int(11) NOT NULL,
  `sender_address` varchar(500) DEFAULT NULL,
  `receiver_address` varchar(500) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `miner`
--

DROP TABLE IF EXISTS `miner`;
CREATE TABLE `miner` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `miner`
--

INSERT INTO `miner` (`id`, `user_id`, `created_at`) VALUES
(1, 2, '2018-10-25 21:32:16'),
(2, 4, '2018-11-25 10:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `node`
--

DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `node_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `node`
--

INSERT INTO `node` (`id`, `user_id`, `node_address`) VALUES
(1, 2, '127.0.0.1:5002'),
(2, 3, '127.0.0.1:5003'),
(3, 4, '127.0.0.1:5004');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `name`, `public_email`, `gravatar_email`, `gravatar_id`, `location`, `website`, `bio`, `timezone`) VALUES
(1, 'Admin', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Europe/Bucharest'),
(2, 'Mihai Fagadau', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Paulesti', '', '', 'Europe/Bucharest'),
(3, 'Isabell Baicoianu', '', '', 'd41d8cd98f00b204e9800998ecf8427e', 'Ploiesti', '', '', 'Europe/Bucharest'),
(4, 'Andrei Fagadau', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', '', '', 'Pacific/Apia');

-- --------------------------------------------------------

--
-- Table structure for table `system_log`
--

DROP TABLE IF EXISTS `system_log`;
CREATE TABLE `system_log` (
  `id` bigint(20) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `system_log`
--

INSERT INTO `system_log` (`id`, `level`, `category`, `log_time`, `prefix`, `message`) VALUES
(1, 1, 'yii\\httpclient\\Exception', 1557687724.986, '[app-frontend][/pandora/chain/check-chain-validation]', 'yii\\base\\ErrorException: fopen(http://127.0.0.1:5002/chain/is_valid): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:61\nStack trace:\n#0 [internal function]: yii\\base\\ErrorHandler->handleError(2, \'fopen(http://12...\', \'C:\\\\xampp\\\\htdocs...\', 61, Array)\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php(61): fopen(\'http://127.0.0....\', \'rb\', false, Resource id #219)\n#2 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#3 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#4 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\ChainController.php(76): yii\\httpclient\\Request->send()\n#5 [internal function]: frontend\\controllers\\ChainController->actionCheckChainValidation()\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'check-chain-val...\', Array)\n#9 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'chain/check-cha...\', Array)\n#10 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#11 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#12 {main}\n\nNext yii\\httpclient\\Exception: fopen(http://127.0.0.1:5002/chain/is_valid): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:68\nStack trace:\n#0 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#2 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\ChainController.php(76): yii\\httpclient\\Request->send()\n#3 [internal function]: frontend\\controllers\\ChainController->actionCheckChainValidation()\n#4 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#5 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'check-chain-val...\', Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'chain/check-cha...\', Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#9 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#10 {main}'),
(2, 1, 'yii\\base\\ErrorException:1', 1557938527.3354, '[app-frontend][/pandora/block/mine-block]', 'yii\\base\\ErrorException: Maximum execution time of 30 seconds exceeded in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:61\nStack trace:\n#0 [internal function]: yii\\base\\ErrorHandler->handleFatalError()\n#1 {main}'),
(3, 1, 'yii\\httpclient\\Exception', 1559972367.3227, '[app-frontend][/pandora/hash/hash-message]', 'yii\\base\\ErrorException: fopen(http://127.0.0.1:5002/block/hash): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:61\nStack trace:\n#0 [internal function]: yii\\base\\ErrorHandler->handleError(2, \'fopen(http://12...\', \'C:\\\\xampp\\\\htdocs...\', 61, Array)\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php(61): fopen(\'http://127.0.0....\', \'rb\', false, Resource id #225)\n#2 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#3 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#4 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\HashController.php(43): yii\\httpclient\\Request->send()\n#5 [internal function]: frontend\\controllers\\HashController->actionHashMessage()\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'hash-message\', Array)\n#9 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'hash/hash-messa...\', Array)\n#10 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#11 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#12 {main}\n\nNext yii\\httpclient\\Exception: fopen(http://127.0.0.1:5002/block/hash): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:68\nStack trace:\n#0 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#2 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\HashController.php(43): yii\\httpclient\\Request->send()\n#3 [internal function]: frontend\\controllers\\HashController->actionHashMessage()\n#4 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#5 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'hash-message\', Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'hash/hash-messa...\', Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#9 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#10 {main}'),
(4, 1, 'yii\\httpclient\\Exception', 1559972370.7286, '[app-frontend][/pandora/hash/hash-message]', 'yii\\base\\ErrorException: fopen(http://127.0.0.1:5002/block/hash): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:61\nStack trace:\n#0 [internal function]: yii\\base\\ErrorHandler->handleError(2, \'fopen(http://12...\', \'C:\\\\xampp\\\\htdocs...\', 61, Array)\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php(61): fopen(\'http://127.0.0....\', \'rb\', false, Resource id #225)\n#2 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#3 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#4 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\HashController.php(43): yii\\httpclient\\Request->send()\n#5 [internal function]: frontend\\controllers\\HashController->actionHashMessage()\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'hash-message\', Array)\n#9 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'hash/hash-messa...\', Array)\n#10 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#11 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#12 {main}\n\nNext yii\\httpclient\\Exception: fopen(http://127.0.0.1:5002/block/hash): failed to open stream: No connection could be made because the target machine actively refused it.\r\n in C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\StreamTransport.php:68\nStack trace:\n#0 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Client.php(233): yii\\httpclient\\StreamTransport->send(Object(yii\\httpclient\\Request))\n#1 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2-httpclient\\src\\Request.php(436): yii\\httpclient\\Client->send(Object(yii\\httpclient\\Request))\n#2 C:\\xampp\\htdocs\\pandora\\frontend\\controllers\\HashController.php(43): yii\\httpclient\\Request->send()\n#3 [internal function]: frontend\\controllers\\HashController->actionHashMessage()\n#4 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\InlineAction.php(57): call_user_func_array(Array, Array)\n#5 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Controller.php(157): yii\\base\\InlineAction->runWithParams(Array)\n#6 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Module.php(528): yii\\base\\Controller->runAction(\'hash-message\', Array)\n#7 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\web\\Application.php(103): yii\\base\\Module->runAction(\'hash/hash-messa...\', Array)\n#8 C:\\xampp\\htdocs\\pandora\\vendor\\yiisoft\\yii2\\base\\Application.php(386): yii\\web\\Application->handleRequest(Object(yii\\web\\Request))\n#9 C:\\xampp\\htdocs\\pandora\\frontend\\web\\index.php(17): yii\\base\\Application->run()\n#10 {main}');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `amount` double DEFAULT NULL,
  `valid_at` datetime DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `sender_address` varchar(500) DEFAULT NULL,
  `receiver_address` varchar(500) DEFAULT NULL,
  `status` enum('0','1') DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `sender_id`, `receiver_id`, `amount`, `valid_at`, `block_id`, `created_at`, `sender_address`, `receiver_address`, `status`) VALUES
(1, 4, 2, 0, '2019-05-25 10:51:19', 1, '2019-05-25 10:51:16', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '1'),
(2, 4, 3, 1, '2019-05-25 10:52:06', 2, '2019-05-25 10:51:38', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(3, 2, 3, 0, '2019-05-25 10:52:06', 2, '2019-05-25 10:52:04', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(4, 3, 4, 1, '2019-05-25 10:58:11', 3, '2019-05-25 10:57:34', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(5, 4, 3, 1, '2019-05-25 10:58:11', 3, '2019-05-25 10:57:57', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(6, 4, 3, 12, '2019-05-25 11:13:03', 4, '2019-05-25 11:12:01', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(7, 2, 3, 12, '2019-05-25 11:13:03', 4, '2019-05-25 11:12:47', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(8, 2, 4, 1, '2019-05-25 11:13:03', 4, '2019-05-25 11:13:00', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(9, 2, 4, 1, '2019-05-25 11:22:06', 5, '2019-05-25 11:21:00', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(10, 3, 2, 10, '2019-05-25 11:22:06', 5, '2019-05-25 11:21:25', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '1'),
(11, 4, 3, 5, '2019-05-25 11:22:06', 5, '2019-05-25 11:21:49', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(12, 4, 3, 1, '2019-05-25 11:34:43', 6, '2019-05-25 11:31:34', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(13, 3, 4, 1, '2019-05-25 11:34:43', 6, '2019-05-25 11:32:27', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(14, 2, 4, 1, '2019-05-25 11:34:43', 6, '2019-05-25 11:33:21', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(15, 2, 4, 12, '2019-05-25 11:41:55', 7, '2019-05-25 11:39:25', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(16, 3, 2, 0, '2019-05-25 11:41:55', 7, '2019-05-25 11:40:51', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '1'),
(17, 4, 3, 11, '2019-05-25 11:41:55', 7, '2019-05-25 11:41:14', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(18, 4, 2, 0, '2019-05-25 16:40:20', 8, '2019-05-25 16:40:16', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '1'),
(19, 4, 3, 0, '2019-05-25 16:46:50', 9, '2019-05-25 16:46:26', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(20, 2, 4, 0, '2019-05-25 16:46:50', 9, '2019-05-25 16:46:47', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1'),
(21, 2, 3, 0, '2019-06-01 12:30:14', 10, '2019-06-01 12:29:35', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', '1'),
(22, 2, 4, 0, '2019-06-12 21:05:15', 11, '2019-06-12 21:05:12', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`, `last_login_at`) VALUES
(1, 'admin', 'admin@exemplu.com', '$2y$10$W9lDc2KSS80vRrXegXtEMuCKYwVF2A98bUv.wgJZLZO2nFpyvkovu', 'zAixyzJRp2AXIP1VmeJCMQHjReBa1p7Q', 1537287156, NULL, NULL, '::1', 1537287156, 1537287156, 0, 1552122314),
(2, 'Mihai', 'mihai@exemplu.com', '$2y$10$uH9BX0PdlCntUjwKEaLmtOfd1xPG3DQsf9p0LVVfMql3I3SkCO.yu', 'Z-MBMZWrgSdffusrWD9jVKBjHUDHXfB1', 1540495931, NULL, NULL, '::1', 1540495931, 1540495931, 0, 1560875884),
(3, 'Iza', 'iza@exemplu.ro', '$2y$10$hx3p1bM1VGd/IYgLjFANyeimY6LopffWlAq2/un6h1M2DFyctdqUO', 'bzHCadhtj7FoFhYULahfCiH31V4bmf_0', 1541959539, NULL, NULL, '::1', 1541959539, 1541959539, 0, 1558773576),
(4, 'Andrei', 'andrei@exemplu.com', '$2y$10$RrmnQAS3LsqLnm2ZJN90pe9I5mNXJbCwfMmIyoCZB6c2mZFifUO4a', '4CCzzWKok3QYX2K-BIFXdfZUZmHxsaDD', 1543136427, NULL, NULL, '::1', 1543136427, 1543136427, 0, 1558773664);

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

DROP TABLE IF EXISTS `wallet`;
CREATE TABLE `wallet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `private_address` varchar(3000) NOT NULL,
  `public_address` varchar(500) NOT NULL,
  `balance` float DEFAULT '0',
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id`, `user_id`, `private_address`, `public_address`, `balance`, `created_at`) VALUES
(1, 2, '3082025e0201000281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d3020301000102818008081d069b198aeba7e3964dcf7aaba4c17cbf0f1d5bb7a735a43df7af4c9416710fe89e96cdf1109dd838b326cfd45190f4ba4aa47dd29cf3965150210638b0e0db7747b98679470fdc0cc35fc78faaa4257ecd89a30a4e17946bdae58ff0a2c3c3b7b8aaabbee7aa803b99dbda88c64b761eeab74e70762342e0c762faa9a9024100b852df5d7b18984e24c9991ecfd84fad96d8ceb35525ad216efdeaaea51bebca4fdd7977c617c0379513d574b4efc67bb0ca0b87212096236d51cace51877805024100cb20db93efa7191ea435f82262eb4dffcea877e9fab8841481abffbe19b63822aaa969508ff4d258dd0190e5caf2b1277247f97b993a4c62fbe4ee724b92c4f7024100809800915d41c9702b26229766760910983ee5e6232f47dc1d6d347f675d55612ddadbd57df42ffc171b613e2cc5637a03dad1b4129e83606ff232454287fa69024100c2c0ef2648a94a71517a193d46e05a79803790393ad4fc75f8d9e32aedd602be622869bbff39f90f905e3701cb72a31db1f9861ed60bca3f4149fec080eae883024100ae6fd15017fb2d5429a7ebe34cc89cd86e7789ddb678955bb68ebab4d12cf4390b168370e34328a138467e3bce499f6c44ffdc6d619d2c8e513fdf88e941bbfc', '30819f300d06092a864886f70d010101050003818d003081890281810092415f947584cd82de044815775218005d6e3877d066c8f083b203444dfa687e202d130700404b02fb26ce17b914c78cdbd0b7303617b1ab39eb6fa2d7b197f2d4115db43b08bafe9cf9ebd59dab52269717c8ffee3f117ee9841ae3353dfd236c16092641bc2a1a2f1234c82501e177c392396c28e747db4019eb224b72a0d30203010001', 242.36, '2018-11-11 18:52:29'),
(2, 3, '3082025b02010002818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f02030100010281807fedf7660970d085fe93d8bc89776c7a8b18cb68c057ff09f422eaa00d5e7a01b1f057785b1d87ddacbd92f3b9132de56d48662031fe61eab110d74294ab0a549ebdabf8f771c36b35b47e99c95f45a22431f1d630800ca8208a60ae1d994295a1cadf33a31e9e57ea6ca5b481b0a5b859070b65691f6a9c681992ad22360cc1024100d301bb50d7e790dc771568cfa311e7fd0b4da450e6c5cfa0f79067a3bc5a091b4dc9dc01ec70bc60e42a2f73a461ca630e1b8b4a11006d891fde966eed7d1521024100eddaeb3350943de7b8643ea6dfcc98e00fd962e9c5d7d3a5ce6f3892a00f8c37d0d9cb6f865b0b0fbdadaa8c33f56c6bf410ea3d759bdc3fe7a81a7b1376d54f02404a543bd5d8985bf12d89bf28157b834b22263191c6193c70a98496dd98c5e69b55a59bf8997f84fc64a36f9fbef22bc704fb32efde59563c8d9b6d469a260bc102404080193ff51dfe1b94593ad42de461a0812bc632f6bfac594e3dc2eda01217481b8eb4282e1b0a48de7af5c0c7664a5c8bf6fa4e685237cbec9a1d743ab702e902401285160bbec817fc0fb01d313cbed8b71bb8fc65804a5da68ae6b4b007b4dc9ff3356d6848e1466ca1936ab58e3bdac0e0481aa3f69a6cc362d4ceec87414e4b', '30819f300d06092a864886f70d010101050003818d0030818902818100c40d0bc03d6f7e2a017bcefcbd1dac5c4e021c344b4355c9b961463deee814d5408fb9a780e365d6a9b452110f93550fc4cb9f87a7718d403b5b3cd8a6fa15ed219e6157ef3f77471f57330b806d58a07d1e0050e10e6cbfcaad41c9f6e818c97cb5a16fa16b08664340a71e1a0a49b067cf4de8d113ed490f82f8e88c63fa2f0203010001', 359.6, '2018-11-11 19:09:49'),
(3, 4, '3082025d02010002818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f02030100010281803c0caa1f9b3071684193a0c6c23e254234987c9c9917080a380cdc92d19b3cf80a56cc967a13b657a4a4234e54e41e45bc3f63e926d3482d5e2277541f23b70b9feabceadbbacf3cbb58558827be30cb9b0e1291b94cf250f6b18b815c67b5840d5cc7a4c9a5c499aaf10c8b91742a633900d557e1aedce45f67fb462081bd99024100d8fee1f41f7adfc10dda848206e7ff0d9ca161d0651b23ecfbc582f3d359c4abc4ea6dc4bc67cdd48015ca9e3bbe307e1d402028cbb618fd07d9b6519bff8d8b024100e8a488c662c37990ed61a7dfbc0699d1c4240b382f7f5cf72fbe1c28e15efc95d23fd6ddfa7a1d83de97202309651a09073efa4dfa288a7d2e62efd23b11f96d02410099ae92bac1dcd541b61d1001c30065ebef0580f005db5deb46391150bc5bf4652ed6551da3cde4c1de61109a567791829016cd6ff72ea5adf6f4632293583f97024100be64a17752aecd97b95e79a81656849e72da58c043c7054b5b2c481980d05f01324f82c6aa4e34478eecb9a552f40609ab7f74144b0dd0c1402c423f188ece4502401501f0d3c51bd5fd2774c6e956dbd4da71b3c3cc4ca78c63e0bbb2486e9a18b280a7b5cd8037a90c2028ba81a5b3f38e11a13e238632d3ec7417682c27032136', '30819f300d06092a864886f70d010101050003818d0030818902818100c53273fd8dcf3cb8ce85c54130a41580e70898de0aa46318a49779dee83b319ee2e7ad8f894bc723d07bdcc80fbb7d70639b96762d569610bb2d8b39aa7d4039e0674e03e7555c75055ea3b5d64139fbfe926b2bc0855bd4cd7b4fd2db3e6ad227def1d3f9dcc754b88dfef760750a0c73a7fd43c553e090ba6424186bb6772f0203010001', 116.84, '2018-11-25 10:01:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `auth_assignment_user_id_idx` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `block`
--
ALTER TABLE `block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `block_miner_fk` (`miner_id`);

--
-- Indexes for table `hash`
--
ALTER TABLE `hash`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash_un` (`block_id`);

--
-- Indexes for table `investor`
--
ALTER TABLE `investor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investor_user_fk` (`user_id`);

--
-- Indexes for table `key_storage_item`
--
ALTER TABLE `key_storage_item`
  ADD PRIMARY KEY (`key`),
  ADD UNIQUE KEY `idx_key_storage_item_key` (`key`);

--
-- Indexes for table `mempool`
--
ALTER TABLE `mempool`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mempool_user_fk` (`user_id`);

--
-- Indexes for table `miner`
--
ALTER TABLE `miner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miner_user_fk` (`user_id`);

--
-- Indexes for table `node`
--
ALTER TABLE `node`
  ADD PRIMARY KEY (`id`),
  ADD KEY `node_user_fk` (`user_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `system_log`
--
ALTER TABLE `system_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_log_level` (`level`),
  ADD KEY `idx_log_category` (`category`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD UNIQUE KEY `token_unique` (`user_id`,`code`,`type`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_block_fk` (`block_id`),
  ADD KEY `transaction_user_fk` (`sender_id`),
  ADD KEY `transaction_user_fk_1` (`receiver_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_unique_username` (`username`),
  ADD UNIQUE KEY `user_unique_email` (`email`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wallet_un` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block`
--
ALTER TABLE `block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `hash`
--
ALTER TABLE `hash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `investor`
--
ALTER TABLE `investor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mempool`
--
ALTER TABLE `mempool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `miner`
--
ALTER TABLE `miner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `node`
--
ALTER TABLE `node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `system_log`
--
ALTER TABLE `system_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `block`
--
ALTER TABLE `block`
  ADD CONSTRAINT `block_miner_fk` FOREIGN KEY (`miner_id`) REFERENCES `miner` (`user_id`);

--
-- Constraints for table `hash`
--
ALTER TABLE `hash`
  ADD CONSTRAINT `hash_block_fk` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`);

--
-- Constraints for table `investor`
--
ALTER TABLE `investor`
  ADD CONSTRAINT `investor_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mempool`
--
ALTER TABLE `mempool`
  ADD CONSTRAINT `mempool_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `miner`
--
ALTER TABLE `miner`
  ADD CONSTRAINT `miner_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `node`
--
ALTER TABLE `node`
  ADD CONSTRAINT `node_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_block_fk` FOREIGN KEY (`block_id`) REFERENCES `block` (`id`),
  ADD CONSTRAINT `transaction_user_fk` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `transaction_user_fk_1` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

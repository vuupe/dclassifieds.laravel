-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 04, 2016 at 09:42 PM
-- Server version: 5.1.42
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dclassifieds`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `condition_id` int(10) unsigned NOT NULL,
  `ad_email` varchar(255) DEFAULT NULL,
  `ad_publish_date` datetime DEFAULT NULL,
  `ad_valid_until` date DEFAULT NULL,
  `ad_active` tinyint(4) DEFAULT '0',
  `ad_ip` varchar(20) DEFAULT NULL,
  `ad_price` double(10,2) DEFAULT '0.00',
  `ad_free` tinyint(4) DEFAULT '0',
  `ad_phone` varchar(255) DEFAULT NULL,
  `ad_title` varchar(255) DEFAULT NULL,
  `ad_description` text,
  `ad_description_hash` varchar(40) DEFAULT NULL,
  `ad_puslisher_name` varchar(255) DEFAULT NULL,
  `code` char(30) DEFAULT NULL,
  `ad_promo` tinyint(4) DEFAULT '0',
  `ad_promo_until` date DEFAULT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `ad_video` varchar(255) DEFAULT NULL,
  `ad_lat_lng` varchar(255) DEFAULT NULL,
  `ad_skype` varchar(255) DEFAULT NULL,
  `ad_address` varchar(255) DEFAULT NULL,
  `ad_pic` varchar(255) DEFAULT NULL,
  `ad_view` int(11) DEFAULT '0',
  `estate_type_id` int(11) DEFAULT '0',
  `estate_sq_m` int(11) DEFAULT '0',
  `estate_year` int(11) DEFAULT '0',
  `estate_construction_type_id` int(11) DEFAULT '0',
  `estate_floor` int(11) DEFAULT '0',
  `estate_num_floors_in_building` int(11) DEFAULT '0',
  `estate_heating_type_id` int(11) DEFAULT '0',
  `estate_furnishing_type_id` int(11) DEFAULT '0',
  `car_brand_id` int(11) DEFAULT '0',
  `car_model_id` int(11) DEFAULT '0',
  `car_engine_id` int(11) DEFAULT '0',
  `car_transmission_id` int(11) DEFAULT '0',
  `car_modification_id` int(11) DEFAULT '0',
  `car_condition_id` int(11) DEFAULT '0',
  `car_year` int(11) DEFAULT '0',
  `car_kilometeres` int(11) DEFAULT '0',
  `clothes_size_id` int(11) DEFAULT '0',
  `shoes_size_id` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ad_id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `ad_description_hash` (`ad_description_hash`),
  FULLTEXT KEY `ad_title` (`ad_title`,`ad_description`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `ad`
--

INSERT INTO `ad` (`ad_id`, `user_id`, `category_id`, `location_id`, `type_id`, `condition_id`, `ad_email`, `ad_publish_date`, `ad_valid_until`, `ad_active`, `ad_ip`, `ad_price`, `ad_free`, `ad_phone`, `ad_title`, `ad_description`, `ad_description_hash`, `ad_puslisher_name`, `code`, `ad_promo`, `ad_promo_until`, `ad_link`, `ad_video`, `ad_lat_lng`, `ad_skype`, `ad_address`, `ad_pic`, `ad_view`, `estate_type_id`, `estate_sq_m`, `estate_year`, `estate_construction_type_id`, `estate_floor`, `estate_num_floors_in_building`, `estate_heating_type_id`, `estate_furnishing_type_id`, `car_brand_id`, `car_model_id`, `car_engine_id`, `car_transmission_id`, `car_modification_id`, `car_condition_id`, `car_year`, `car_kilometeres`, `clothes_size_id`, `shoes_size_id`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 7, 1, 0, 'dinko359@gmail.com', '2016-06-05 18:32:30', '2016-07-05', 1, '127.0.0.1', 6000.00, 0, '', 'audi a6 kombi', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vulputate vulputate efficitur. Curabitur lacinia id orci id hendrerit. Nam volutpat interdum sapien ut porttitor. Curabitur a blandit magna, eu viverra dolor. Donec eu orci dolor. Proin imperdiet turpis vitae sollicitudin euismod. Curabitur consectetur sapien nec nibh vehicula, mattis tempor nisi blandit. Quisque rutrum dui nisl, ac dapibus lorem dignissim nec. Proin eget lectus consequat, consequat ligula quis, gravida nisi. Nam placerat, felis vitae tempus cursus, lorem tellus facilisis purus, a facilisis tellus dolor et massa. In ultrices convallis risus, et imperdiet metus pellentesque vel. Duis pharetra lacus eu purus pellentesque mattis. Maecenas sit amet dui a turpis tincidunt faucibus. Aenean placerat est diam, sed euismod justo condimentum id. Duis sit amet quam at urna sagittis accumsan.\r\n\r\nAliquam erat volutpat. Mauris tempor metus nec felis aliquam, vitae semper nisi lobortis. Maecenas sem diam, pharetra fringilla aliquam a, semper sit amet velit. Nullam enim ex, auctor ullamcorper tellus id, vestibulum vestibulum nunc. Donec ante ex, dignissim ac dapibus vitae, fringilla quis ligula. Morbi eget dapibus diam, vitae volutpat lacus. Nullam elementum libero faucibus suscipit facilisis. Mauris posuere lorem lectus, at tempor orci viverra id. Sed pretium convallis elit id pharetra. Nullam malesuada erat nec imperdiet posuere. Quisque suscipit metus sit amet nunc rhoncus, mattis pretium sapien aliquet. Fusce condimentum diam in odio ultrices aliquet. Sed commodo ornare diam nec aliquam. Pellentesque ac viverra ligula, ac auctor tortor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.\r\n\r\nMauris convallis malesuada metus nec scelerisque. Aliquam congue ac elit et condimentum. Nullam velit erat, malesuada a lacus quis, ultrices venenatis tortor. Praesent sodales quis augue sit amet scelerisque. Quisque iaculis, elit in porttitor rutrum, sem velit efficitur neque, id viverra nibh urna et erat. Aenean id metus finibus, sagittis ante sit amet, pretium libero. Etiam elementum ipsum ac dolor tempus, a efficitur ligula sodales. Nunc condimentum massa vitae nulla finibus, vehicula cursus arcu interdum. Curabitur pulvinar tincidunt urna, vel faucibus odio tincidunt at. ', '263b60d9715e8a90541b1ced03b5702d', 'Ivan Ivanov', 'KUwDgm3fUgjAwjacOLLZeOCjBsGOIC', 1, '2016-10-17', NULL, NULL, NULL, '', NULL, '1_111aa13e56468dfeef73451725fea2ce.jpg', 120, 0, 0, 0, 0, 0, 0, 0, 0, 6, 56, 2, 2, 0, 1, 2003, 201000, 0, 0, '2016-10-31 21:31:33', '2016-10-31 19:31:33'),
(2, 1, 23, 7, 1, 1, 'dinko359@gmail.com', '2016-04-09 17:52:14', '2016-05-09', 1, '127.0.0.1', 0.00, 1, 'phone', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec accumsan congue cursus. Ut facilisis imperdiet nibh id hendrerit. Donec luctus tincidunt faucibus. Quisque gravida mi sit amet eros malesuada, id gravida libero suscipit. Sed nec lacus ex. Nulla facilisi. Proin efficitur diam ut congue sagittis. Suspendisse hendrerit eros id nisl consectetur tempor. Integer interdum quam ut ligula condimentum, at iaculis ligula tincidunt. In finibus maximus tortor eu elementum. Vivamus mollis leo elit, ut tristique mauris ultrices at.\r\n\r\nQuisque dapibus augue ac erat porttitor imperdiet. Aenean eu ipsum eros. Ut aliquet tincidunt urna. Morbi convallis, libero at laoreet egestas, est tortor ultricies felis, et tristique leo nulla vel nisi. Proin eu sapien vel justo pretium iaculis eu ac dui. Phasellus molestie dignissim lectus, at iaculis orci iaculis non. Aliquam tempus odio quis mauris bibendum eleifend. Vivamus auctor fermentum tempor. Suspendisse justo orci, euismod sit amet molestie vulputate, dignissim ut erat. Cras metus purus, varius at nisi vitae, congue mattis nisl. Cras elementum euismod odio id luctus. Maecenas non sem vitae sapien bibendum porttitor eu nec turpis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec a lobortis ligula. Ut urna neque, euismod quis auctor nec, pellentesque eget nisi.\r\n\r\nMauris tincidunt lectus ut diam porta pellentesque. Praesent pretium auctor sapien nec efficitur. Nulla facilisi. Pellentesque ut libero id ipsum euismod cursus. Praesent scelerisque porttitor erat tincidunt efficitur. Proin a nulla ligula. Praesent congue at ante sit amet volutpat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Quisque in bibendum nisl. Donec id tempor massa. Sed efficitur augue interdum tellus semper, a tempor eros sodales. Duis ac rhoncus justo. Nullam quis mattis purus. Etiam euismod enim in tristique aliquam. ', '64e6d55b6f47ca9d07aa9c0800b66c5f', 'Ivan Ivanov', '9uwSzi6Np3wFVisdqo3dLrcwRYePAf', 0, NULL, 'http://www.google.com', 'https://www.youtube.com/watch?v=10pmPiK8pi8&list=FLGllc6M9nVNtIgPZMFNdQWA&index=1', '(42.6745345, 23.31851329999995)', 'skype', 'ul. "Nikolay Liliev" 34, 1421 Sofia, Bulgaria', '2_c80a8414e4bbdc4477a8546a837dba81.jpg', 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-19 14:19:31', '2016-10-19 11:19:31'),
(3, 1, 23, 5, 1, 1, 'dinko359@gmail.com', '2016-04-09 19:45:47', '2016-05-09', 1, '127.0.0.1', 5000000.00, 0, '', 'asdasdasd', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc mollis ullamcorper lacus eget lacinia. Morbi feugiat neque ut ultricies laoreet. Donec pulvinar arcu vel augue maximus, feugiat cursus lorem feugiat. Morbi ac pellentesque sapien. In eu lacinia felis. Donec non enim a felis laoreet malesuada eget in tellus. Vestibulum congue est ac enim dapibus mollis. Nullam sed nulla id nisl varius faucibus id ac nisi. Vestibulum malesuada rhoncus dignissim. In efficitur nec augue nec porta. ', '914736644a755db69a7ef813c98a2d1e', 'asdasd', 'EwTxqMUjSeEYyytOIcnvjNIFxGEmlt', 0, NULL, '', '', '', '', '', '3_15627bac625951749154c3eec2147e92.jpg', 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-28 17:07:48', '2016-10-28 14:07:48'),
(17, 1, 23, 5, 1, 2, 'dinko359@gmail.com', '2016-10-29 12:48:44', '2016-11-28', 0, '127.0.0.1', 200.00, 0, 'phone1', 'Феноменална маса с шест стола от масивно дърво! Тамплиерски стил!', 'Скъпи клиенти, на Вашето внимание представяме феноменална маса с шест стола от масивно дърво! Тамплиерски стил! Мебелите са закупени от Англия посредством търгово наддаване. Състоянието им е изключително добро без видими следи от експлоатация.<br /><br />Допуснете аристократичният стил и във Вашият дом.<br /><br />Размери:<br />Маса: Дължина- 180 см; ширина: 91 см; височина- 76 см<br /><br />Столове:<br />Седло- ширина- 45,5 см; дълбочина- 44 см<br />Облегалка ширина- 42 см; Височина- 62 см', '12a3638c7e7c6520ba71d7a25af3f043', 'dinko1 georgiev1', '2UJFNxoJPlC8fLpB8rXXPrO8nq4EDr', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '17_0dd70d39f3df8b2c068960d452493cf4.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 15:48:46', '2016-10-29 12:48:46'),
(6, 1, 13, 5, 1, 0, 'asdasd@asdasd.com', '2016-04-10 09:45:44', '2016-05-10', 1, '127.0.0.1', 47323.00, 0, '', 'Двустаен апартамент', 'Луксозен клас апартамент в центъра на квартал Кръстова Вада в жилищна сграда в непосредствена близост до Парадайз МОЛ с невероятна гледка към Витоша.Сградата е със собствено ограждение и видео контрол.Архитектурата е решена в съвременен стил и създава усещането за модерна визия. В проекта са вложени висококачествени материали, като тухли „Винербергер Поротерм“ по австрийски патент, луксозни асансьори на един от световните лидери в бранша и висок клас алуминиева дограма с прекъснат термомост.Апартамента е с краен срок на завършване 1.05.2016 год.В сградата се предлагат двустайни и тристайни апартаменти от 47323-до 88700 лв със ДДС , като някои от тях могат да се обединят за по големи пространства.Има възможност за закупуване на гаражи и паркоместа. ', 'e5caed09210c8a86669c8b1d66f90c10', 'asdasd', 'gIjPZSght8b6EdMtCXyH9Bp6wiEs0F', 0, NULL, '', '', '', '', '', '6_2d2062827a2ef704895a9020e4839b8f.jpg', 21, 4, 58, 0, 1, 2, 5, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-23 10:04:30', '2016-10-23 07:04:30'),
(7, 1, 13, 6, 1, 0, 'dinko359@gmail.com', '2016-06-09 15:47:23', '2016-07-09', 1, '127.0.0.1', 4450012.00, 0, '0899999999', 'Двустаен апартамент2', 'НОВА оферта на ул.''Преки път''. Луксозна сграда с Акт 16 от 2014 г. Продажба апартамент състоящ се от слънчева и функционална дневна с кухн. бокс, просторна спалня и санитарен възел. <br /><br />Жилището е с монтирани интериорни врати, РVС дограма, газов котел, алуминиеви радиатори. <br /><br />Стени - щпакловка и латекс, под - циментова замазка. Изложение - югозапад. Към апартамента са прилежащи мазе, както и идеални части от двора с регламентирано парко място. Сградата е газифицирана и оборудвана с хидравличен асансьор. Продава се и тристаен апартамент с площ от 103 кв.м. за Е 82 500. При желание може да се довърши до ключ. За прегледност на скицата ап.2. ', 'ebd86214936e6388cfa8c9e29f2a92f5', 'dinko georgiev', 'qco5EsBzNlXfaHlx2Xktx3jLnE766r', 0, NULL, '', '', '(51.4541617, -2.5879761999999573)', 'skype', 'East Tucker Street, Bristol, City of Bristol BS1 6FS, UK', '7_389cc50ae20a54dc0687f99626798078.jpg', 209, 4, 57, 2005, 1, 1, 5, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-28 18:33:09', '2016-10-28 15:33:09'),
(9, 1, 19, 5, 1, 1, 'dinko359@gmail.com', '2016-06-22 19:39:26', '2016-07-22', 1, '127.0.0.1', 123.00, 0, '', 'test ad', 'Докато обществото гледа назад, икономиката и държавата ни не могат да тръгнат напред. 25 години спорим по едни и същи теми, които не могат да доведат до реално отражение в бъдещето ни. Правителствата водят политика на нулева приемственост, а без определяне на национална кауза няма как да продължим развитието си. Усеща се тежка липса на важен дебат, която се замаскира и замества от дребни махленски караници.<br /><br />Прочети още на: http://www.dnes.bg/politika/2016/06/21/sporim-za-gei-parada-a-nacionalna-kauza.306361<br /><br />', '8fdfe08686666e3e0b8a11376b310d21', 'Ivan Ivanov', 'iQLMaNkPjQenXd2RhPkCZ8JOJRtpCZ', 0, NULL, '', '', '', '', '', '9_f8809969d6f416a7f671b7f62286eac7.jpg', 38, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-31 12:36:31', '2016-10-31 10:36:31'),
(16, 1, 23, 5, 1, 2, 'dinko359@gmail.com', '2016-10-29 12:48:18', '2016-11-28', 0, '127.0.0.1', 200.00, 0, 'phone1', 'Феноменална маса с шест стола от масивно дърво! Тамплиерски стил!', 'Скъпи клиенти, на Вашето внимание представяме феноменална маса с шест стола от масивно дърво! Тамплиерски стил! Мебелите са закупени от Англия посредством търгово наддаване. Състоянието им е изключително добро без видими следи от експлоатация.<br /><br />Допуснете аристократичният стил и във Вашият дом.<br /><br />Размери:<br />Маса: Дължина- 180 см; ширина: 91 см; височина- 76 см<br /><br />Столове:<br />Седло- ширина- 45,5 см; дълбочина- 44 см<br />Облегалка ширина- 42 см; Височина- 62 см', '12a3638c7e7c6520ba71d7a25af3f043', 'dinko1 georgiev1', 'OgGpzEsWpqgp5qULDy6WSHDTdXeuKc', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '16_35fd40e34504b70b2a8ba3d276a1d485.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 15:48:19', '2016-10-29 12:48:19'),
(15, 1, 23, 5, 1, 2, 'dinko359@gmail.com', '2016-10-29 12:44:11', '2016-11-28', 0, '127.0.0.1', 200.00, 0, 'phone1', 'Феноменална маса с шест стола от масивно дърво! Тамплиерски стил!', 'Скъпи клиенти, на Вашето внимание представяме феноменална маса с шест стола от масивно дърво! Тамплиерски стил! Мебелите са закупени от Англия посредством търгово наддаване. Състоянието им е изключително добро без видими следи от експлоатация.<br /><br />Допуснете аристократичният стил и във Вашият дом.<br /><br />Размери:<br />Маса: Дължина- 180 см; ширина: 91 см; височина- 76 см<br /><br />Столове:<br />Седло- ширина- 45,5 см; дълбочина- 44 см<br />Облегалка ширина- 42 см; Височина- 62 см', '12a3638c7e7c6520ba71d7a25af3f043', 'dinko1 georgiev1', 'P8oaRUevy9TztxbFkovJepDxuAN3d2', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '15_04b84a3cb1fae6fae0a35a89adecd361.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 15:44:12', '2016-10-29 12:44:12'),
(12, 1, 13, 5, 1, 1, 'dinko359@gmail.com', '2016-07-14 18:05:33', '2016-08-14', 0, '166.166.166.166', 100.00, 0, 'phone1', 'asd', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'e0559d0ae32c0f58035b6c1e735cbab7', 'dinko1 georgiev1', 'E3Xy3HqSXwdKsmeylLx5gksCvKlAop', 1, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '12_1d065a0fa7dcbf468bd756a348b7022c.jpg', 0, 1, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-14 10:30:35', '2016-07-14 18:05:34'),
(18, 1, 23, 5, 1, 2, 'dinko359@gmail.com', '2016-10-29 13:00:20', '2016-11-28', 1, '127.0.0.1', 200.00, 0, 'phone1', 'Феноменална маса с шест стола от масивно дърво! Тамплиерски стил!', 'Скъпи клиенти, на Вашето внимание представяме феноменална маса с шест стола от масивно дърво! Тамплиерски стил! Мебелите са закупени от Англия посредством търгово наддаване. Състоянието им е изключително добро без видими следи от експлоатация.<br /><br />Допуснете аристократичният стил и във Вашият дом.<br /><br />Размери:<br />Маса: Дължина- 180 см; ширина: 91 см; височина- 76 см<br /><br />Столове:<br />Седло- ширина- 45,5 см; дълбочина- 44 см<br />Облегалка ширина- 42 см; Височина- 62 см', '12a3638c7e7c6520ba71d7a25af3f043', 'dinko1 georgiev1', 'RXCZH9n7yn2jvIWf7mJtvxnA5tQM8o', 1, '2016-11-05', 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '18_afe7f9cac5a4dfe7ceb3217258989682.jpg', 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-31 17:31:53', '2016-10-31 15:31:53'),
(19, 1, 23, 5, 2, 1, 'dinko359@gmail.com', '2016-10-29 13:04:16', '2016-11-28', 1, '127.0.0.1', 0.00, 1, 'phone1', 'Транспортни услуги', 'Превоз-пренос на стоки, багаж, покъщнина и други с товарен закрит бус за град Варна и от Варна за цялата страна. Дължина на фургона 3,40м. ширина 1,80 м, височина 2 метра. Цена за Варна 15 -20 лева. Извън града - по договаряне. ДЕНОНОЩНО! ', 'd4025bc91c3df6046dba4b6aba5556ae', 'dinko1 georgiev1', 'l58dm9CV6Ve1UTbkEn4aTlnuKlWNO7', 1, '2016-11-05', 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '19_d79516c35c1f737e08c84a1d34df6c4a.jpg', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 16:05:01', '2016-10-29 13:05:01'),
(20, 1, 23, 5, 2, 1, 'dinko359@gmail.com', '2016-10-29 13:20:08', '2016-11-28', 0, '127.0.0.1', 0.00, 1, 'phone1', 'Продавам фолксваген голф ', 'Колата е в много добро техническо състояние. Сменени масла, филтри, ремъци, акумулатор, нови летни гуми и др..Платени са гражданска отговорност, данък, винетка, технически преглед. ', '12bfe9fc7bf8f4c1f3fb7f41e1fa24d8', 'dinko1 georgiev1', 'BasooyVIwinFQq2N6SfboResbuFnSL', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '20_6875394da0fef8dab159c5a836f3fdec.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 16:20:08', '2016-10-29 13:20:08'),
(21, 1, 23, 5, 2, 1, 'dinko359@gmail.com', '2016-10-29 13:24:25', '2016-11-28', 0, '127.0.0.1', 0.00, 1, 'phone1', 'ГИПСОКАРТОН монтаж 20лв с матерялите,тенекджйски заготовки,', 'монтаж на гипсокартон, боя,шпакловка,мазилка зидане с итонг,ВиК,само разливни замазки<br />цени по договорка. Топлоизолации с скеле и вишка тенекеджийски заготовки ,улуци,водостоци отоплителни системи по улуци и водосточни тръби,по улами и др. ', '8bb875cd31c8b5b8006b95d6aec3b3d3', 'dinko1 georgiev1', 'mzcEP9AzQoxS2c9Hz1OWQv61sFFqv4', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '21_8466db5587e220cf58661b045fbd4d80.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 16:24:25', '2016-10-29 13:24:25'),
(22, 1, 23, 5, 2, 1, 'dinko359@gmail.com', '2016-10-29 13:38:47', '2016-11-28', 1, '127.0.0.1', 0.00, 1, 'phone1', 'Тъч / touch монитор 12" Fujitsu USB в много добро състояние 6 м. гарая', 'Продавам Тъч / touch монитор 12" Fujitsu 3000LCD12 USB в мног добро състояние 6 м. гаранция.<br /><br />Монитора е тестван и работи без забележки. Продава се пълен комплект със захранващ адаптер, стойка VGA, USB кабел и диск с драйвери.<br />Тъч монитора е втора употреба и е подходящ за ПОС / POS системи, за ресторанти, заведения за бързо хранене, супермаркети, аптеки и др.<br />Тъч мониторите може да се използват в ПОС / POS системи на Мистрал, Микроинвест, Янак софт, Детелина, Тремол и други.<br /><br />Цена е с 209 лв. ДДС и може да се издаде фактура.<br />Гаранция 6 м.<br /><br />Спецификация:<br /><br />Модел - 3000LCD12" DSP D22<br />Размер на Дисплея - 12,1" (30,73см.)<br />Тип матрица - LCD monitor (Matt)<br />Резолюция на дисплея - 800 x 600 (SVGA)<br />Тъч панел - Resistive with USB interface<br />Яркост - 200 cd/m2<br />Контраст - 250:1<br />Интерфейс - VGA, DVI, Jack/3,5"(Audio in), 1 x USB, 1 x Power USB, 4-pin power jack<br />Аудио - stereo speakers ', 'a0476285d4a72187496002eb21d858b7', 'dinko1 georgiev1', 'nQhBeRsZraXGSFfHFFfajXJ6CORYRf', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '22_e179a3eb0a63e5f39107d75c107877e4.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-29 16:45:39', '2016-10-29 13:45:39'),
(23, 1, 23, 5, 2, 1, 'dinko359@gmail.com', '2016-10-30 11:50:04', '2016-11-29', 0, '127.0.0.1', 0.00, 1, 'phone1', 'Обработено лозе с къща и кладенец с вода ', 'Продавам лозе в близост до спирка Чешмичката в местността Садовете, гр. Лом. Намира се на 400 метра от спирката, във високата част на местността и има изглед към р. Дунав.<br /><br />+ ПОДДЪРЖАНО, ОБРАБОТЕНО лозе, винен сорт и десертно грозде 1 дка.; с циментови колци и тел<br />+ 800 кв. м. обработваемо място с насаждения (плодове и зеленчуци)<br />+ овощни дървета - ябълки, круши, вишни, мушмули, сливи<br />+ ягоди и малини<br />+ кладенец с вода<br />+ малка къща и допълнителна постройка<br />+ има електрическа инсталация, но в момента няма ток до къщата<br />+ Нотариален акт<br />+ всички прилежащи документи.  <br />За повече информация и оглед: тел. 884 - Покажи -   ', '12a9fdee27e173808e2d3a7b1c0ed116', 'dinko1 georgiev1', 'gnKqMSwyv8eU0Or5IJaT7A9woh07xs', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '23_f4a4e27fddbbea9b3794c016adf9167d.jpg', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-30 13:50:04', '2016-10-30 11:50:04'),
(24, 1, 20, 5, 2, 0, 'dinko359@gmail.com', '2016-10-31 08:04:34', '2016-11-30', 1, '127.0.0.1', 100.00, 0, 'phone1', 'test services', 'Известен факт е, че читателя обръща внимание на съдържанието, което чете, а не на оформлението му. Свойството на Lorem Ipsum е, че до голяма степен има нормално разпределение на буквите и се чете по-лесно, за разлика от нормален текст на английски език като "Това е съдържание, това е съдържание". Много системи за публикуване и редактори на Уеб страници използват Lorem Ipsum като примерен текстов модел "по подразбиране", поради което при търсене на фразата "lorem ipsum" в Интернет ще бъдат открити много сайтове в процес на разработка. Някой от тези сайтове биват променяни с времето, а други по случайност или нарочно(за забавление и пр.) биват оставяни в този си незавършен вид.', '19d82655b16f72ce70862ecbbb403a4a', 'dinko1 georgiev1', 'iWplBHRD2DTF5FUAApzsrPRJxa5FiM', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '24_5e34cd0d8a27c7c31a53d7d97293776f.jpg', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-10-31 10:22:04', '2016-10-31 08:22:04'),
(25, 1, 21, 5, 2, 0, 'dinko359@gmail.com', '2016-10-31 08:06:25', '2016-11-30', 1, '127.0.0.1', 15.00, 0, 'phone1', 'test clothes', 'Известен факт е, че читателя обръща внимание на съдържанието, което чете, а не на оформлението му. Свойството на Lorem Ipsum е, че до голяма степен има нормално разпределение на буквите и се чете по-лесно, за разлика от нормален текст на английски език като "Това е съдържание, това е съдържание". Много системи за публикуване и редактори на Уеб страници използват Lorem Ipsum като примерен текстов модел "по подразбиране", поради което при търсене на фразата "lorem ipsum" в Интернет ще бъдат открити много сайтове в процес на разработка. Някой от тези сайтове биват променяни с времето, а други по случайност или нарочно(за забавление и пр.) биват оставяни в този си незавършен вид.', '19d82655b16f72ce70862ecbbb403a4a', 'dinko1 georgiev1', 'gBeanrd3Nyk7EBiBOjvWQLA8JOYVk1', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '25_1eaae0790b1c8520011ada59962cfad1.jpg', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2016-10-31 12:53:52', '2016-06-23 08:29:24'),
(26, 1, 22, 5, 2, 0, 'dinko359@gmail.com', '2016-10-31 08:07:36', '2016-11-30', 1, '127.0.0.1', 0.00, 1, 'phone1', 'test shoes', 'Известен факт е, че читателя обръща внимание на съдържанието, което чете, а не на оформлението му. Свойството на Lorem Ipsum е, че до голяма степен има нормално разпределение на буквите и се чете по-лесно, за разлика от нормален текст на английски език като "Това е съдържание, това е съдържание". Много системи за публикуване и редактори на Уеб страници използват Lorem Ipsum като примерен текстов модел "по подразбиране", поради което при търсене на фразата "lorem ipsum" в Интернет ще бъдат открити много сайтове в процес на разработка. Някой от тези сайтове биват променяни с времето, а други по случайност или нарочно(за забавление и пр.) биват оставяни в този си незавършен вид.', '19d82655b16f72ce70862ecbbb403a4a', 'dinko1 georgiev1', '0P4pLX4NeEhIQsyiaHiQMYF1ny1JIM', 0, NULL, 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '26_973d092d1fa30e7b84a39307807bab44.jpg', 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2016-10-31 10:21:29', '2016-10-31 08:21:29'),
(27, 1, 23, 5, 1, 0, 'dinko359@gmail.com', '2016-10-31 08:09:08', '2016-11-30', 1, '127.0.0.1', 2100.00, 0, 'phone1', 'test land', 'Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове. Този начин не само е оцелял повече от 5 века, но е навлязъл и в публикуването на електронни издания като е запазен почти без промяна. Популяризиран е през 60те години на 20ти век със издаването на Letraset листи, съдържащи Lorem Ipsum пасажи, популярен е и в наши дни във софтуер за печатни издания като Aldus PageMaker, който включва различни версии на Lorem Ipsum.', '68dd3c3fcfb29195c820359508909732', 'dinko1 georgiev1', 'q4niJx8n16FZazO2CBllPO6iHoyMmf', 1, '2016-11-08', 'web site1', '', '(33.5206313, -86.80255310000001)', 'phone1', '451-499 24th St N, Birmingham, AL 35203, USA', '27_7b0c6bc7b160cd673bf2e12465f1b2cb.jpg', 3, 0, 2100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-11-04 16:32:07', '2016-11-04 14:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) DEFAULT NULL,
  `menu_type_id` tinyint(4) DEFAULT '1',
  `menu_title_key` varchar(255) NOT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) NOT NULL,
  `menu_controller` varchar(255) NOT NULL,
  `menu_ord` int(11) NOT NULL,
  `menu_active` tinyint(1) NOT NULL,
  `menu_external_link` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`menu_id`, `menu_parent_id`, `menu_type_id`, `menu_title_key`, `menu_icon`, `menu_link`, `menu_controller`, `menu_ord`, `menu_active`, `menu_external_link`) VALUES
(1, NULL, 1, 'dashboard', 'fa fa-link', 'admin', 'admincontroller', 10, 1, 0),
(2, NULL, 1, 'locations', 'fa fa-globe', 'admin/location', 'locationcontroller', 20, 1, 0),
(3, NULL, 1, 'categories', 'fa fa-sitemap', 'admin/category', 'categorycontroller', 30, 1, 0),
(4, NULL, 1, 'ads', 'fa fa-edit', 'admin/ad', 'adcontroller', 40, 1, 0),
(5, NULL, 1, 'users', 'fa fa-users', 'admin/user', 'usercontroller', 50, 1, 0),
(6, NULL, 2, 'common_types', 'fa fa-gears', '', '', 60, 1, 0),
(7, 6, 1, 'adtype', 'fa fa-circle-o', 'admin/adtype', 'adtypecontroller', 10, 1, 0),
(8, 6, 1, 'adcondition', 'fa fa-circle-o', 'admin/adcondition', 'adconditioncontroller', 20, 1, 0),
(9, NULL, 2, 'real_estate_types', 'fa fa-gears', '', '', 70, 1, 0),
(10, 9, 1, 'estate_construction_type', 'fa fa-circle-o', 'admin/estateconstruction', 'estateconstructioncontroller', 10, 1, 0),
(11, 9, 1, 'estate_furnishing_type', 'fa fa-circle-o', 'admin/estatefurnishing', 'estatefurnishingcontroller', 20, 1, 0),
(12, 9, 1, 'estate_heating_type', 'fa fa-circle-o', 'admin/estateheating', 'estateheatingcontroller', 30, 1, 0),
(13, 9, 1, 'estate_type', 'fa fa-circle-o', 'admin/estatetype', 'estatetypecontroller', 40, 1, 0),
(14, NULL, 2, 'car_types', 'fa fa-gears', '', '', 80, 1, 0),
(15, 14, 1, 'car_brand', 'fa fa-circle-o', 'admin/carbrand', 'carbrandcontroller', 10, 1, 0),
(16, 14, 1, 'car_model', 'fa fa-circle-o', 'admin/carmodel', 'carmodelcontroller', 20, 1, 0),
(17, 14, 1, 'car_condition', 'fa fa-circle-o', 'admin/carcondition', 'carconditioncontroller', 30, 1, 0),
(18, 14, 1, 'car_engine', 'fa fa-circle-o', 'admin/carengine', 'carenginecontroller', 40, 1, 0),
(19, 14, 1, 'car_modification', 'fa fa-circle-o', 'admin/carmodification', 'carmodificationcontroller', 50, 1, 0),
(20, 14, 1, 'car_transmission', 'fa fa-circle-o', 'admin/cartransmission', 'cartransmissioncontroller', 60, 1, 0),
(21, NULL, 1, 'banner', 'fa fa-dollar', 'admin/banner', 'bannercontroller', 90, 1, 0),
(22, NULL, 1, 'settings', 'fa fa-gear', 'admin/settings', 'settingscontroller', 100, 1, 0),
(23, NULL, 1, 'pages', 'fa fa-file-text-o', 'admin/page', 'pagecontroller', 120, 1, 0),
(24, NULL, 1, 'reports', 'fa fa-warning', 'admin/report', 'reportcontroller', 130, 1, 0),
(25, NULL, 1, 'wallet', 'fa fa-money', 'admin/wallet', 'walletcontroller', 140, 1, 0),
(26, NULL, 1, 'payment_options', 'fa fa-credit-card', 'admin/pay', 'paycontroller', 150, 1, 0),
(27, NULL, 1, 'mail', 'fa fa-envelope-o', 'admin/mail', 'mailcontroller', 160, 1, 0),
(28, NULL, 1, 'ipban', 'fa fa-ban', 'admin/ipban', 'ipbancontroller', 170, 1, 0),
(29, NULL, 1, 'mailban', 'fa fa-ban', 'admin/mailban', 'mailbancontroller', 180, 1, 0),
(30, NULL, 1, 'clear_cache', 'fa fa-eraser', 'admin/clearcache', 'clearcachecontroller', 190, 1, 0),
(31, NULL, 2, 'clothes_types', 'fa fa-gears', '', '', 85, 1, 0),
(32, 31, 1, 'clothes_sizes', 'fa fa-circle-o', 'admin/clothes', 'clothescontroller', 10, 1, 0),
(33, 31, 1, 'shoes_sizes', 'fa fa-circle-o', 'admin/shoes', 'shoescontroller', 20, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_ban_email`
--

CREATE TABLE IF NOT EXISTS `ad_ban_email` (
  `ban_email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_email` varchar(255) NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`ban_email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_ban_email`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_ban_ip`
--

CREATE TABLE IF NOT EXISTS `ad_ban_ip` (
  `ban_ip_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_ip` varchar(50) NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`ban_ip_id`),
  UNIQUE KEY `ban_ip` (`ban_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_ban_ip`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_condition`
--

CREATE TABLE IF NOT EXISTS `ad_condition` (
  `ad_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_condition_name` varchar(255) NOT NULL,
  PRIMARY KEY (`ad_condition_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ad_condition`
--

INSERT INTO `ad_condition` (`ad_condition_id`, `ad_condition_name`) VALUES
(1, 'New'),
(2, 'Used');

-- --------------------------------------------------------

--
-- Table structure for table `ad_fav`
--

CREATE TABLE IF NOT EXISTS `ad_fav` (
  `ad_fav_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ad_fav_id`),
  KEY `ad_id` (`ad_id`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `ad_fav`
--

INSERT INTO `ad_fav` (`ad_fav_id`, `ad_id`, `user_id`) VALUES
(14, 6, 1),
(13, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ad_pic`
--

CREATE TABLE IF NOT EXISTS `ad_pic` (
  `ad_pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `ad_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ad_pic_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `ad_pic`
--

INSERT INTO `ad_pic` (`ad_pic_id`, `ad_id`, `ad_pic`) VALUES
(1, 1, '1_839f199a67ab8eaed5d6890ff0c64134.jpg'),
(2, 1, '1_81804133ca6962e88039ccb7c8cabdcc.jpg'),
(3, 1, '1_db519b238cbcf5321241bd245ceddae8.jpg'),
(4, 1, '1_80eef0160835ee6977c1b7e58c55964a.jpg'),
(5, 2, '2_c6d26ad7b1ee8885c82ad67081559a2c.jpg'),
(6, 2, '2_170a66abd9e5a376eeefd2233833b779.jpg'),
(7, 2, '2_a1a335413ce6904b20028c4101e4124e.jpg'),
(8, 2, '2_14990b3f6f5ef72f744e2123d19d3307.jpg'),
(9, 3, '3_acd37158ccecfe31c51321cb8e0e38e0.jpg'),
(11, 6, '6_f7c7c04a0fe17515610c6a3d8622e8db.jpg'),
(12, 6, '6_d231a9dcfdf8376ebd7ff46acff0678c.jpg'),
(13, 6, '6_6c106ae60aebf768ceb50f7cdb902540.jpg'),
(14, 6, '6_20a36f7ee352784f83e9f97fbb087819.jpg'),
(23, 7, '7_75dc160eb4444f9cb1615cf8d3440aa2.jpg'),
(22, 7, '7_42fed772c613fdf4ce69128e2d1ab62d.jpg'),
(21, 7, '7_686f6c8fae123d0a6393bcf44fb801ab.jpg'),
(20, 7, '7_e77c30d0a0e5f5d7bbd2fb608912ac56.jpg'),
(27, 15, '15_b057343450c0d3f9cbeec7f3c1f2d182.jpg'),
(28, 15, '15_2c724769f0099a38b30fd6485bd8b3b3.jpg'),
(29, 15, '15_1f7080f51933a3257e91b27ab5c42401.jpg'),
(30, 15, '15_531902bc69079b2ab058d77ea20ddd65.jpg'),
(31, 16, '16_07df55423f31f88f3bf05c93e08b223f.jpg'),
(32, 16, '16_323a72a9ba07a21b373346709c40e08a.jpg'),
(33, 16, '16_ab0a2d7b55f9374ae762eb12d0126125.jpg'),
(34, 16, '16_3e9aa17e9f9cc5290d956a0daecc1ee0.jpg'),
(35, 17, '17_e90f74b419fbc91aec714e355ddd3b5c.jpg'),
(36, 17, '17_3dda0a01d1bbc5f7b5c2c645276b0eb1.jpg'),
(37, 17, '17_5a53edb8c95fb0e9933d3ca7864bc53a.jpg'),
(38, 17, '17_49b832326c314b1aa8bf7bc4a4b05f55.jpg'),
(39, 18, '18_a25c78571b4293070035c2a4055d3837.jpg'),
(40, 18, '18_ee228acb7965f420b58ba20dab02277a.jpg'),
(41, 18, '18_3f866883dac99628bea459736c7f5ecd.jpg'),
(42, 18, '18_6ab9221693aa90b9291063c36755ab17.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ad_report`
--

CREATE TABLE IF NOT EXISTS `ad_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_ad_id` int(11) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  `report_info` text,
  `report_date` datetime NOT NULL,
  `report_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `ad_id` (`report_ad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ad_report`
--

INSERT INTO `ad_report` (`report_id`, `report_ad_id`, `report_type_id`, `report_info`, `report_date`, `report_user_id`) VALUES
(2, 7, 2, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. ', '2016-05-02 10:15:31', NULL),
(3, 7, 3, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. ', '2016-05-02 10:16:48', 1),
(5, 9, 6, '', '2016-10-19 12:41:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ad_type`
--

CREATE TABLE IF NOT EXISTS `ad_type` (
  `ad_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`ad_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ad_type`
--

INSERT INTO `ad_type` (`ad_type_id`, `ad_type_name`) VALUES
(1, 'Private'),
(2, 'Business');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_position` int(11) NOT NULL,
  `banner_type` int(11) NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `banner_code` text,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_active_from` date DEFAULT NULL,
  `banner_active_to` date DEFAULT NULL,
  `banner_num_views` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `banner_position`, `banner_type`, `banner_name`, `banner_link`, `banner_code`, `banner_image`, `banner_active_from`, `banner_active_to`, `banner_num_views`) VALUES
(2, 1, 1, 'cntral banner', 'http://www.google.com', '', '1475935276_banner.png', '2016-10-08', '2018-10-10', 1237),
(4, 2, 1, 'ad detail banner', 'http://www.google.com', '', '1476006282_banner.gif', '2016-10-06', '2017-04-13', 175);

-- --------------------------------------------------------

--
-- Table structure for table `car_brand`
--

CREATE TABLE IF NOT EXISTS `car_brand` (
  `car_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand_name` varchar(255) NOT NULL,
  `car_brand_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`car_brand_id`),
  UNIQUE KEY `car_brand_name` (`car_brand_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

--
-- Dumping data for table `car_brand`
--

INSERT INTO `car_brand` (`car_brand_id`, `car_brand_name`, `car_brand_active`) VALUES
(1, 'AC', 1),
(2, 'Acura', 1),
(3, 'Aixam', 1),
(4, 'Alfa romeo', 1),
(5, 'Aston martin', 1),
(6, 'Audi', 1),
(7, 'Austin', 1),
(8, 'Bentley', 1),
(9, 'Berliner', 1),
(10, 'Bmw', 1),
(11, 'Borgward', 1),
(12, 'Bugatti', 1),
(13, 'Buick', 1),
(14, 'Cadillac', 1),
(15, 'Chevrolet', 1),
(16, 'Chrysler', 1),
(17, 'Citroen', 1),
(18, 'Corvette', 1),
(19, 'Dacia', 1),
(20, 'Daewoo', 1),
(21, 'Daihatsu', 1),
(22, 'Daimler', 1),
(23, 'Datsun', 1),
(24, 'Dkw', 1),
(25, 'Dodge', 1),
(26, 'Dr', 1),
(27, 'Eagle', 1),
(28, 'FSO', 1),
(29, 'Ferrari', 1),
(30, 'Fiat', 1),
(31, 'Ford', 1),
(32, 'Geo', 1),
(33, 'Great Wall', 1),
(34, 'Heinkel', 1),
(35, 'Honda', 1),
(36, 'Hyundai', 1),
(37, 'Ifa', 1),
(38, 'Infiniti', 1),
(39, 'Innocenti', 1),
(40, 'Isuzu', 1),
(41, 'Jaguar', 1),
(42, 'Kia', 1),
(43, 'Lada', 1),
(44, 'Lamborghini', 1),
(45, 'Lancia', 1),
(46, 'Lexus', 1),
(47, 'Lifan', 1),
(48, 'Lincoln', 1),
(49, 'Lotus', 1),
(50, 'Maserati', 1),
(51, 'Matra', 1),
(52, 'Maybach', 1),
(53, 'Mazda', 1),
(54, 'McLaren', 1),
(55, 'Mercedes', 1),
(56, 'Mercury', 1),
(57, 'Mg', 1),
(58, 'Mini', 1),
(59, 'Mitsubishi', 1),
(60, 'Morgan', 1),
(61, 'Moskvich', 1),
(62, 'Nissan', 1),
(63, 'Oldsmobile', 1),
(64, 'Opel', 1),
(65, 'Perodua', 1),
(66, 'Peugeot', 1),
(67, 'Pgo', 1),
(68, 'Plymouth', 1),
(69, 'Polonez', 1),
(70, 'Pontiac', 1),
(71, 'Porsche', 1),
(72, 'Proton', 1),
(73, 'Renault', 1),
(74, 'Rolls-Royce', 1),
(75, 'Rover', 1),
(76, 'SECMA', 1),
(77, 'Saab', 1),
(78, 'Samand', 1),
(79, 'Saturn', 1),
(80, 'Scion', 1),
(81, 'Seat', 1),
(82, 'Shatenet', 1),
(83, 'Shuanghuan', 1),
(84, 'Simca', 1),
(85, 'Skoda', 1),
(86, 'Smart', 1),
(87, 'Ssang yong', 1),
(88, 'Subaru', 1),
(89, 'Suzuki', 1),
(90, 'Talbot', 1),
(91, 'Tata', 1),
(92, 'Tavria', 1),
(93, 'Tazzari', 1),
(94, 'Terberg', 1),
(95, 'Tesla', 1),
(96, 'Tofas', 1),
(97, 'Toyota', 1),
(98, 'Trabant', 1),
(99, 'Triumph', 1),
(100, 'VROMOS', 1),
(101, 'Volga', 1),
(102, 'Volvo', 1),
(103, 'Vw', 1),
(104, 'Warszawa', 1),
(105, 'Wartburg', 1),
(106, 'Wiesmann', 1),
(107, 'Xinshun', 1),
(108, 'Zastava', 1),
(109, 'Zaz', 1),
(110, 'Други', 1),
(111, 'Победа', 1),
(112, 'София', 1),
(113, 'Чайка', 1),
(114, 'Aro', 1),
(115, 'Asia', 1),
(116, 'Bertone', 1),
(117, 'Gaz', 1),
(118, 'Gmc', 1),
(119, 'Hummer', 1),
(120, 'Iveco', 1),
(121, 'Jeep', 1),
(122, 'Jpx', 1),
(123, 'Laforza', 1),
(124, 'Land rover', 1),
(125, 'Landwind', 1),
(126, 'Mahindra', 1),
(127, 'SH auto', 1),
(128, 'SsangYong', 1),
(129, 'Tempo', 1),
(130, 'Uaz', 1),
(131, 'Xinkai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `car_condition`
--

CREATE TABLE IF NOT EXISTS `car_condition` (
  `car_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_condition_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_condition_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `car_condition`
--

INSERT INTO `car_condition` (`car_condition_id`, `car_condition_name`) VALUES
(1, 'In Motion'),
(2, 'For Parts');

-- --------------------------------------------------------

--
-- Table structure for table `car_engine`
--

CREATE TABLE IF NOT EXISTS `car_engine` (
  `car_engine_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_engine_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_engine_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `car_engine`
--

INSERT INTO `car_engine` (`car_engine_id`, `car_engine_name`) VALUES
(1, 'Benzin'),
(2, 'Diesel');

-- --------------------------------------------------------

--
-- Table structure for table `car_model`
--

CREATE TABLE IF NOT EXISTS `car_model` (
  `car_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand_id` int(11) NOT NULL,
  `car_model_name` varchar(255) NOT NULL,
  `car_model_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`car_model_id`),
  KEY `car_brand_id` (`car_brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1763 ;

--
-- Dumping data for table `car_model`
--

INSERT INTO `car_model` (`car_model_id`, `car_brand_id`, `car_model_name`, `car_model_active`) VALUES
(2, 2, 'Integra', 1),
(3, 2, 'Mdx', 1),
(4, 2, 'Rl', 1),
(5, 2, 'Rsx', 1),
(6, 2, 'Slx', 1),
(7, 2, 'Tl', 1),
(8, 2, 'Tsx', 1),
(9, 3, '400', 1),
(10, 3, '505', 1),
(11, 3, '600', 1),
(12, 4, '145', 1),
(13, 4, '146', 1),
(14, 4, '147', 1),
(15, 4, '155', 1),
(16, 4, '156', 1),
(17, 4, '156 sportwagon', 1),
(18, 4, '159', 1),
(19, 4, '159 sportwagon', 1),
(20, 4, '164', 1),
(21, 4, '166', 1),
(22, 4, '33', 1),
(23, 4, '75', 1),
(24, 4, '76', 1),
(25, 4, '8C Competizione', 1),
(26, 4, '90', 1),
(27, 4, 'Alfetta', 1),
(28, 4, 'Brera', 1),
(29, 4, 'Crosswagon q4', 1),
(30, 4, 'Giulietta', 1),
(31, 4, 'Gt', 1),
(32, 4, 'Gtv', 1),
(33, 4, 'MiTo', 1),
(34, 4, 'Spider', 1),
(35, 4, 'Sprint', 1),
(36, 4, 'Sud', 1),
(37, 5, '.', 1),
(38, 5, 'DBS', 1),
(39, 5, 'Db7', 1),
(40, 5, 'Db9', 1),
(41, 5, 'Rapide', 1),
(42, 5, 'V12 Vantage', 1),
(43, 5, 'V8 Vantage', 1),
(44, 5, 'Vanquish', 1),
(45, 6, '100', 1),
(46, 6, '200', 1),
(47, 6, '50', 1),
(48, 6, '60', 1),
(49, 6, '80', 1),
(50, 6, '90', 1),
(51, 6, 'A1', 1),
(52, 6, 'A2', 1),
(53, 6, 'A3', 1),
(54, 6, 'A4', 1),
(55, 6, 'A5', 1),
(56, 6, 'A6', 1),
(57, 6, 'A7', 1),
(58, 6, 'A8', 1),
(59, 6, 'Allroad', 1),
(60, 6, 'R8', 1),
(61, 6, 'Rs4', 1),
(62, 6, 'Rs5', 1),
(63, 6, 'Rs6', 1),
(64, 6, 'Rs7', 1),
(65, 6, 'S2', 1),
(66, 6, 'S3', 1),
(67, 6, 'S4', 1),
(68, 6, 'S5', 1),
(69, 6, 'S6', 1),
(70, 6, 'S7', 1),
(71, 6, 'S8', 1),
(72, 6, 'Tt', 1),
(73, 7, 'Allegro', 1),
(74, 7, 'Ambassador', 1),
(75, 7, 'Maestro', 1),
(76, 7, 'Maxi', 1),
(77, 7, 'Metro', 1),
(78, 7, 'Mg', 1),
(79, 7, 'Mini', 1),
(80, 7, 'Montego', 1),
(81, 7, 'Princess', 1),
(82, 8, 'Arnage', 1),
(83, 8, 'Azure', 1),
(84, 8, 'Continental', 1),
(85, 8, 'Continental gt', 1),
(86, 8, 'Mulsanne', 1),
(87, 8, 'T-series', 1),
(88, 9, 'Coupe', 1),
(89, 10, '1', 1),
(90, 10, '114', 1),
(91, 10, '116', 1),
(92, 10, '118', 1),
(93, 10, '120', 1),
(94, 10, '123', 1),
(95, 10, '125', 1),
(96, 10, '130', 1),
(97, 10, '135', 1),
(98, 10, '1500', 1),
(99, 10, '1600', 1),
(100, 10, '1602', 1),
(101, 10, '1800', 1),
(102, 10, '2', 1),
(103, 10, '2 Active Tourer', 1),
(104, 10, '2000', 1),
(105, 10, '2002', 1),
(106, 10, '220 d', 1),
(107, 10, '3', 1),
(108, 10, '315', 1),
(109, 10, '316', 1),
(110, 10, '318', 1),
(111, 10, '320', 1),
(112, 10, '323', 1),
(113, 10, '324', 1),
(114, 10, '325', 1),
(115, 10, '328', 1),
(116, 10, '330', 1),
(117, 10, '335', 1),
(118, 10, '3gt', 1),
(119, 10, '4', 1),
(120, 10, '420', 1),
(121, 10, '428', 1),
(122, 10, '430', 1),
(123, 10, '435', 1),
(124, 10, '5', 1),
(125, 10, '5 Gran Turismo', 1),
(126, 10, '501', 1),
(127, 10, '518', 1),
(128, 10, '520', 1),
(129, 10, '523', 1),
(130, 10, '524', 1),
(131, 10, '525', 1),
(132, 10, '528', 1),
(133, 10, '530', 1),
(134, 10, '535', 1),
(135, 10, '540', 1),
(136, 10, '545', 1),
(137, 10, '550', 1),
(138, 10, '5GT', 1),
(139, 10, '6', 1),
(140, 10, '628', 1),
(141, 10, '630', 1),
(142, 10, '633', 1),
(143, 10, '635', 1),
(144, 10, '640', 1),
(145, 10, '645', 1),
(146, 10, '650', 1),
(147, 10, '7', 1),
(148, 10, '700', 1),
(149, 10, '721', 1),
(150, 10, '723', 1),
(151, 10, '725', 1),
(152, 10, '728', 1),
(153, 10, '730', 1),
(154, 10, '732', 1),
(155, 10, '733', 1),
(156, 10, '735', 1),
(157, 10, '740', 1),
(158, 10, '745', 1),
(159, 10, '750', 1),
(160, 10, '760', 1),
(161, 10, '840', 1),
(162, 10, '850', 1),
(163, 10, 'Izetta', 1),
(164, 10, 'M', 1),
(165, 10, 'M Coupе', 1),
(166, 10, 'M135', 1),
(167, 10, 'M3', 1),
(168, 10, 'M4', 1),
(169, 10, 'M5', 1),
(170, 10, 'M6', 1),
(171, 10, 'Z1', 1),
(172, 10, 'Z3', 1),
(173, 10, 'Z4', 1),
(174, 10, 'Z8', 1),
(175, 10, 'i3', 1),
(176, 10, 'i8', 1),
(177, 11, 'Hansa', 1),
(178, 12, 'Veyron', 1),
(179, 13, 'Electra', 1),
(180, 13, 'Invicta', 1),
(181, 13, 'Park avenue', 1),
(182, 13, 'Regal', 1),
(183, 13, 'Skylark', 1),
(184, 13, 'Skyline', 1),
(185, 14, 'Allante', 1),
(186, 14, 'BLS', 1),
(187, 14, 'Brougham', 1),
(188, 14, 'Cts', 1),
(189, 14, 'Deville', 1),
(190, 14, 'Eldorado', 1),
(191, 14, 'Fleetwood', 1),
(192, 14, 'STS', 1),
(193, 14, 'Seville', 1),
(194, 14, 'Srx', 1),
(195, 14, 'Xlr', 1),
(196, 15, 'Alero', 1),
(197, 15, 'Astro', 1),
(198, 15, 'Aveo', 1),
(199, 15, 'Beretta', 1),
(200, 15, 'Camaro', 1),
(201, 15, 'Caprice', 1),
(202, 15, 'Cavalier', 1),
(203, 15, 'Cobalt', 1),
(204, 15, 'Corvette', 1),
(205, 15, 'Cruze', 1),
(206, 15, 'Epica', 1),
(207, 15, 'Evanda', 1),
(208, 15, 'Hhr', 1),
(209, 15, 'Impala', 1),
(210, 15, 'Kalos', 1),
(211, 15, 'Lacetti', 1),
(212, 15, 'Lumina', 1),
(213, 15, 'Malibu', 1),
(214, 15, 'Matiz', 1),
(215, 15, 'Nova', 1),
(216, 15, 'Nubira', 1),
(217, 15, 'Orlando', 1),
(218, 15, 'Silverado', 1),
(219, 15, 'Spark', 1),
(220, 15, 'Ssr', 1),
(221, 15, 'Tacuma', 1),
(222, 15, 'Transsport', 1),
(223, 15, 'Volt', 1),
(224, 16, '300c', 1),
(225, 16, '300m', 1),
(226, 16, 'Crossfire', 1),
(227, 16, 'Daytona', 1),
(228, 16, 'Es', 1),
(229, 16, 'Gr.voyager', 1),
(230, 16, 'Gts', 1),
(231, 16, 'Interpid', 1),
(232, 16, 'Lebaron', 1),
(233, 16, 'Neon', 1),
(234, 16, 'New yorker', 1),
(235, 16, 'Pacifica', 1),
(236, 16, 'Pt cruiser', 1),
(237, 16, 'Saratoga', 1),
(238, 16, 'Sebring', 1),
(239, 16, 'Stratus', 1),
(240, 16, 'Vision', 1),
(241, 16, 'Voyager', 1),
(242, 17, '2cv', 1),
(243, 17, 'Ax', 1),
(244, 17, 'Axel', 1),
(245, 17, 'Berlingo', 1),
(246, 17, 'Bx', 1),
(247, 17, 'C - Zero', 1),
(248, 17, 'C-Elysee', 1),
(249, 17, 'C1', 1),
(250, 17, 'C15', 1),
(251, 17, 'C2', 1),
(252, 17, 'C3', 1),
(253, 17, 'C3 Picasso', 1),
(254, 17, 'C3 pluriel', 1),
(255, 17, 'C4', 1),
(256, 17, 'C4 Cactus', 1),
(257, 17, 'C4 Picasso', 1),
(258, 17, 'C5', 1),
(259, 17, 'C6', 1),
(260, 17, 'C8', 1),
(261, 17, 'Cx', 1),
(262, 17, 'DS3', 1),
(263, 17, 'DS4', 1),
(264, 17, 'DS5', 1),
(265, 17, 'Ds', 1),
(266, 17, 'Evasion', 1),
(267, 17, 'Grand C4 Picasso', 1),
(268, 17, 'Gsa', 1),
(269, 17, 'Gx', 1),
(270, 17, 'Ln', 1),
(271, 17, 'Nemo', 1),
(272, 17, 'Oltcit', 1),
(273, 17, 'Saxo', 1),
(274, 17, 'Visa', 1),
(275, 17, 'Xantia', 1),
(276, 17, 'Xm', 1),
(277, 17, 'Xsara', 1),
(278, 17, 'Xsara picasso', 1),
(279, 17, 'Zx', 1),
(280, 18, 'C06 Convertible', 1),
(281, 18, 'C06 Coupe', 1),
(282, 18, 'Powa', 1),
(283, 18, 'Z06', 1),
(284, 19, '1100', 1),
(285, 19, '1300', 1),
(286, 19, '1304', 1),
(287, 19, '1307', 1),
(288, 19, '1310', 1),
(289, 19, '1350', 1),
(290, 19, 'Dokker', 1),
(291, 19, 'Liberta', 1),
(292, 19, 'Lodgy', 1),
(293, 19, 'Logan', 1),
(294, 19, 'Nova', 1),
(295, 19, 'Pickup', 1),
(296, 19, 'Sandero', 1),
(297, 19, 'Solenza', 1),
(298, 20, 'Ace', 1),
(299, 20, 'Chairman', 1),
(300, 20, 'Cielo', 1),
(301, 20, 'Espero', 1),
(302, 20, 'Evanda', 1),
(303, 20, 'Fso', 1),
(304, 20, 'Kalos', 1),
(305, 20, 'Lacetti', 1),
(306, 20, 'Lanos', 1),
(307, 20, 'Leganza', 1),
(308, 20, 'Magnus', 1),
(309, 20, 'Matiz', 1),
(310, 20, 'Nexia', 1),
(311, 20, 'Nubira', 1),
(312, 20, 'Prince', 1),
(313, 20, 'Racer', 1),
(314, 20, 'Rezzo', 1),
(315, 20, 'Super', 1),
(316, 20, 'Tacuma', 1),
(317, 20, 'Tico', 1),
(318, 21, 'Applause', 1),
(319, 21, 'Charade', 1),
(320, 21, 'Charmant', 1),
(321, 21, 'Copen', 1),
(322, 21, 'Cuore', 1),
(323, 21, 'Gran move', 1),
(324, 21, 'Hijet', 1),
(325, 21, 'Materia', 1),
(326, 21, 'Move', 1),
(327, 21, 'Sharade', 1),
(328, 21, 'Sirion', 1),
(329, 21, 'Trevis', 1),
(330, 21, 'Yrv', 1),
(331, 22, 'Double six', 1),
(332, 22, 'Six', 1),
(333, 22, 'Sovereign', 1),
(334, 23, 'Bluebird', 1),
(335, 23, 'Cherry', 1),
(336, 23, 'Stanza', 1),
(337, 24, 'F102', 1),
(338, 25, 'Avenger', 1),
(339, 25, 'Caliber', 1),
(340, 25, 'Caravan', 1),
(341, 25, 'Challenger', 1),
(342, 25, 'Charger', 1),
(343, 25, 'Coronet', 1),
(344, 25, 'Daytona', 1),
(345, 25, 'Interpid', 1),
(346, 25, 'Journey', 1),
(347, 25, 'Magnum', 1),
(348, 25, 'Neon', 1),
(349, 25, 'Ram', 1),
(350, 25, 'Shadow', 1),
(351, 25, 'Stealth', 1),
(352, 25, 'Stratus', 1),
(353, 25, 'Viper', 1),
(354, 26, '1', 1),
(355, 26, '2', 1),
(356, 26, '3', 1),
(357, 27, 'Premire', 1),
(358, 27, 'Talon', 1),
(359, 27, 'Vision', 1),
(360, 28, 'Polonez', 1),
(361, 29, '348', 1),
(362, 29, '360 modena', 1),
(363, 29, '360 spider', 1),
(364, 29, '458 Italia', 1),
(365, 29, '599', 1),
(366, 29, 'California', 1),
(367, 29, 'Enzo', 1),
(368, 29, 'F12berlinetta', 1),
(369, 29, 'F430', 1),
(370, 29, 'F456m', 1),
(371, 29, 'F575m maranello', 1),
(372, 29, 'F612 scaglietti', 1),
(373, 29, 'FF', 1),
(374, 29, 'LaFerrari', 1),
(375, 29, 'Mondial 8', 1),
(376, 29, 'Testarossa', 1),
(377, 30, '1100', 1),
(378, 30, '124', 1),
(379, 30, '125', 1),
(380, 30, '126', 1),
(381, 30, '127', 1),
(382, 30, '128', 1),
(383, 30, '131', 1),
(384, 30, '132', 1),
(385, 30, '1400', 1),
(386, 30, '1500', 1),
(387, 30, '1800', 1),
(388, 30, '500', 1),
(389, 30, '500L', 1),
(390, 30, '600', 1),
(391, 30, '650', 1),
(392, 30, '750', 1),
(393, 30, 'Albea', 1),
(394, 30, 'Argenta', 1),
(395, 30, 'Barchetta', 1),
(396, 30, 'Bertone', 1),
(397, 30, 'Brava', 1),
(398, 30, 'Bravo', 1),
(399, 30, 'Cinquecento', 1),
(400, 30, 'Coupe', 1),
(401, 30, 'Croma', 1),
(402, 30, 'Doblo', 1),
(403, 30, 'Duna', 1),
(404, 30, 'Fiorino', 1),
(405, 30, 'Idea', 1),
(406, 30, 'Linea', 1),
(407, 30, 'Marea', 1),
(408, 30, 'Multipla', 1),
(409, 30, 'Palio', 1),
(410, 30, 'Panda', 1),
(411, 30, 'Punto', 1),
(412, 30, 'Qubo', 1),
(413, 30, 'Regata', 1),
(414, 30, 'Ritmo', 1),
(415, 30, 'Scudo', 1),
(416, 30, 'Sedici', 1),
(417, 30, 'Seicento', 1),
(418, 30, 'Siena', 1),
(419, 30, 'Stilo', 1),
(420, 30, 'Strada', 1),
(421, 30, 'Tempra', 1),
(422, 30, 'Tipo', 1),
(423, 30, 'Topolino', 1),
(424, 30, 'Ulysse', 1),
(425, 30, 'Uno', 1),
(426, 31, '12m', 1),
(427, 31, '15m', 1),
(428, 31, '17m', 1),
(429, 31, '20m', 1),
(430, 31, 'Aerostar', 1),
(431, 31, 'B-Max', 1),
(432, 31, 'C-max', 1),
(433, 31, 'Capri', 1),
(434, 31, 'Connect', 1),
(435, 31, 'Consul', 1),
(436, 31, 'Cortina', 1),
(437, 31, 'Cosworth', 1),
(438, 31, 'Cougar', 1),
(439, 31, 'Countur', 1),
(440, 31, 'Courier', 1),
(441, 31, 'Crown victoria', 1),
(442, 31, 'Ecoline', 1),
(443, 31, 'Escort', 1),
(444, 31, 'F150', 1),
(445, 31, 'Fiesta', 1),
(446, 31, 'Focus', 1),
(447, 31, 'Fusion', 1),
(448, 31, 'Galaxy', 1),
(449, 31, 'Granada', 1),
(450, 31, 'Ka', 1),
(451, 31, 'Mondeo', 1),
(452, 31, 'Mustang', 1),
(453, 31, 'Orion', 1),
(454, 31, 'Probe', 1),
(455, 31, 'Puma', 1),
(456, 31, 'Rs', 1),
(457, 31, 'S-Max', 1),
(458, 31, 'Scorpio', 1),
(459, 31, 'Sierra', 1),
(460, 31, 'Sportka', 1),
(461, 31, 'Streetka', 1),
(462, 31, 'Taunus', 1),
(463, 31, 'Taurus', 1),
(464, 31, 'Thunderbird', 1),
(465, 31, 'Windstar', 1),
(466, 31, 'Zephyr', 1),
(467, 32, 'Metro', 1),
(468, 32, 'Prizm', 1),
(469, 32, 'Storm', 1),
(470, 33, 'Voleex C10', 1),
(471, 33, 'Voleex C30', 1),
(472, 34, 'Тrojan', 1),
(473, 35, 'Accord', 1),
(474, 35, 'Cbr', 1),
(475, 35, 'Cbx', 1),
(476, 35, 'City', 1),
(477, 35, 'Civic', 1),
(478, 35, 'Civic ballade', 1),
(479, 35, 'Concerto', 1),
(480, 35, 'Cr-v', 1),
(481, 35, 'Crx', 1),
(482, 35, 'Crz', 1),
(483, 35, 'Fit', 1),
(484, 35, 'Fr-v', 1),
(485, 35, 'Hr-v', 1),
(486, 35, 'Insight', 1),
(487, 35, 'Integra', 1),
(488, 35, 'Jazz', 1),
(489, 35, 'Legend', 1),
(490, 35, 'Logo', 1),
(491, 35, 'Nsx', 1),
(492, 35, 'Odyssey', 1),
(493, 35, 'Prelude', 1),
(494, 35, 'Quintet', 1),
(495, 35, 'S2000', 1),
(496, 35, 'Shuttle', 1),
(497, 35, 'Stream', 1),
(498, 36, 'Accent', 1),
(499, 36, 'Atos', 1),
(500, 36, 'Coupe', 1),
(501, 36, 'Elantra', 1),
(502, 36, 'Excel', 1),
(503, 36, 'Genesis', 1),
(504, 36, 'Getz', 1),
(505, 36, 'Grace', 1),
(506, 36, 'Grandeur', 1),
(507, 36, 'I10', 1),
(508, 36, 'I20', 1),
(509, 36, 'I30', 1),
(510, 36, 'I40', 1),
(511, 36, 'Ix20', 1),
(512, 36, 'Lantra', 1),
(513, 36, 'Matrix', 1),
(514, 36, 'Pony', 1),
(515, 36, 'Porter', 1),
(516, 36, 'S', 1),
(517, 36, 'Santamo', 1),
(518, 36, 'Sonata', 1),
(519, 36, 'Sonica', 1),
(520, 36, 'Stelar', 1),
(521, 36, 'Tb', 1),
(522, 36, 'Trajet', 1),
(523, 36, 'Veloster ', 1),
(524, 36, 'Xg', 1),
(525, 37, 'F9', 1),
(526, 38, 'Fx45', 1),
(527, 38, 'G', 1),
(528, 38, 'G coupe', 1),
(529, 38, 'G sedan', 1),
(530, 38, 'I', 1),
(531, 38, 'J', 1),
(532, 38, 'M', 1),
(533, 38, 'Q', 1),
(534, 39, 'Mini', 1),
(535, 40, 'Gemini', 1),
(536, 40, 'Piazza', 1),
(537, 40, 'Pickup', 1),
(538, 41, 'Daimler', 1),
(539, 41, 'Daimler double six', 1),
(540, 41, 'Daimler six', 1),
(541, 41, 'F-Type', 1),
(542, 41, 'S-type', 1),
(543, 41, 'Sovereign', 1),
(544, 41, 'Super v8', 1),
(545, 41, 'X-type', 1),
(546, 41, 'Xf', 1),
(547, 41, 'Xj', 1),
(548, 41, 'Xjr', 1),
(549, 41, 'Xjs', 1),
(550, 41, 'Xjsc', 1),
(551, 41, 'Xk8', 1),
(552, 41, 'Xkr', 1),
(553, 42, 'Avella delta', 1),
(554, 42, 'Cadenza', 1),
(555, 42, 'Carens', 1),
(556, 42, 'Carnival', 1),
(557, 42, 'Ceed', 1),
(558, 42, 'Cerato', 1),
(559, 42, 'Clarus', 1),
(560, 42, 'Joecs', 1),
(561, 42, 'Joyce', 1),
(562, 42, 'Magentis', 1),
(563, 42, 'Opirus', 1),
(564, 42, 'Optima', 1),
(565, 42, 'Picanto', 1),
(566, 42, 'Pride', 1),
(567, 42, 'Pro ceed', 1),
(568, 42, 'Quoris', 1),
(569, 42, 'Rio', 1),
(570, 42, 'Sephia', 1),
(571, 42, 'Shuma', 1),
(572, 42, 'Soul', 1),
(573, 42, 'Spectra', 1),
(574, 42, 'Venga', 1),
(575, 43, '1200', 1),
(576, 43, '1300', 1),
(577, 43, '1500', 1),
(578, 43, '1600', 1),
(579, 43, '2101', 1),
(580, 43, '21011', 1),
(581, 43, '21012', 1),
(582, 43, '21013', 1),
(583, 43, '21015', 1),
(584, 43, '2102', 1),
(585, 43, '2103', 1),
(586, 43, '2104', 1),
(587, 43, '21043', 1),
(588, 43, '2105', 1),
(589, 43, '21051', 1),
(590, 43, '21053', 1),
(591, 43, '2106', 1),
(592, 43, '21061', 1),
(593, 43, '21063', 1),
(594, 43, '2107', 1),
(595, 43, '21074', 1),
(596, 43, '2108', 1),
(597, 43, '21083', 1),
(598, 43, '2109', 1),
(599, 43, '21093', 1),
(600, 43, '21099', 1),
(601, 43, '2110', 1),
(602, 43, '21213', 1),
(603, 43, 'Granta', 1),
(604, 43, 'Kalina', 1),
(605, 43, 'Nova', 1),
(606, 43, 'Oka', 1),
(607, 43, 'Priora', 1),
(608, 43, 'Samara', 1),
(609, 44, 'Aventador', 1),
(610, 44, 'Countach', 1),
(611, 44, 'Diablo', 1),
(612, 44, 'Gallardo', 1),
(613, 44, 'Huracan', 1),
(614, 44, 'Murcielago', 1),
(615, 44, 'Reventon', 1),
(616, 44, 'Veneno', 1),
(617, 45, 'A112', 1),
(618, 45, 'Aurelia', 1),
(619, 45, 'Beta', 1),
(620, 45, 'Dedra', 1),
(621, 45, 'Delta', 1),
(622, 45, 'Kappa', 1),
(623, 45, 'Lybra', 1),
(624, 45, 'Musa', 1),
(625, 45, 'Phedra', 1),
(626, 45, 'Prisma', 1),
(627, 45, 'Thema', 1),
(628, 45, 'Thesis', 1),
(629, 45, 'Unior', 1),
(630, 45, 'Y', 1),
(631, 45, 'Y10', 1),
(632, 45, 'Ypsilon', 1),
(633, 45, 'Zeta', 1),
(634, 46, 'CT200h', 1),
(635, 46, 'Es', 1),
(636, 46, 'Gs', 1),
(637, 46, 'Is', 1),
(638, 46, 'LFA', 1),
(639, 46, 'Ls', 1),
(640, 46, 'Sc', 1),
(641, 47, 'LF1010', 1),
(642, 47, 'LF320', 1),
(643, 47, 'LF520', 1),
(644, 47, 'LF620', 1),
(645, 47, 'LF6361', 1),
(646, 47, 'LF7130', 1),
(647, 47, 'LF7160', 1),
(648, 48, 'Continental', 1),
(649, 48, 'Ls', 1),
(650, 48, 'Mark', 1),
(651, 48, 'Mkz', 1),
(652, 48, 'Town car', 1),
(653, 48, 'Zephyr', 1),
(654, 49, 'Elise', 1),
(655, 49, 'Europe', 1),
(656, 49, 'Evora', 1),
(657, 49, 'Exige', 1),
(658, 50, '3200 gt', 1),
(659, 50, 'Biturbo', 1),
(660, 50, 'Coupe gt', 1),
(661, 50, 'Ghibli', 1),
(662, 50, 'GranCabrio', 1),
(663, 50, 'GranTurismo', 1),
(664, 50, 'Gransport', 1),
(665, 50, 'Quattroporte', 1),
(666, 50, 'Spyder', 1),
(667, 50, 'Zagato', 1),
(668, 51, 'Murena', 1),
(669, 51, 'Rancho', 1),
(670, 52, '57', 1),
(671, 52, '62', 1),
(672, 53, '121', 1),
(673, 53, '2', 1),
(674, 53, '3', 1),
(675, 53, '323', 1),
(676, 53, '5', 1),
(677, 53, '6', 1),
(678, 53, '626', 1),
(679, 53, '929', 1),
(680, 53, 'Demio', 1),
(681, 53, 'Mpv', 1),
(682, 53, 'Mx-3', 1),
(683, 53, 'Mx-5', 1),
(684, 53, 'Mx-6', 1),
(685, 53, 'Premacy', 1),
(686, 53, 'Rx-7', 1),
(687, 53, 'Rx-8', 1),
(688, 53, 'Tribute', 1),
(689, 53, 'Xedos', 1),
(690, 54, 'F1', 1),
(691, 54, 'MP4-12C', 1),
(692, 54, 'P1', 1),
(693, 55, '110', 1),
(694, 55, '111', 1),
(695, 55, '113', 1),
(696, 55, '114', 1),
(697, 55, '115', 1),
(698, 55, '116', 1),
(699, 55, '123', 1),
(700, 55, '124', 1),
(701, 55, '126', 1),
(702, 55, '126-260', 1),
(703, 55, '150', 1),
(704, 55, '170', 1),
(705, 55, '180', 1),
(706, 55, '190', 1),
(707, 55, '200', 1),
(708, 55, '220', 1),
(709, 55, '230', 1),
(710, 55, '240', 1),
(711, 55, '250', 1),
(712, 55, '260', 1),
(713, 55, '280', 1),
(714, 55, '290', 1),
(715, 55, '300', 1),
(716, 55, '320', 1),
(717, 55, '350', 1),
(718, 55, '380', 1),
(719, 55, '380se', 1),
(720, 55, '420', 1),
(721, 55, '450', 1),
(722, 55, '500', 1),
(723, 55, '560', 1),
(724, 55, '600', 1),
(725, 55, 'A', 1),
(726, 55, 'A140', 1),
(727, 55, 'A150', 1),
(728, 55, 'A160', 1),
(729, 55, 'A170', 1),
(730, 55, 'A180', 1),
(731, 55, 'A190', 1),
(732, 55, 'A200', 1),
(733, 55, 'A210', 1),
(734, 55, 'AMG GT', 1),
(735, 55, 'AMG GT S', 1),
(736, 55, 'Adenauer', 1),
(737, 55, 'B', 1),
(738, 55, 'B150', 1),
(739, 55, 'B170', 1),
(740, 55, 'B180', 1),
(741, 55, 'B200', 1),
(742, 55, 'C', 1),
(743, 55, 'C180', 1),
(744, 55, 'C200', 1),
(745, 55, 'C220', 1),
(746, 55, 'C230', 1),
(747, 55, 'C240', 1),
(748, 55, 'C250', 1),
(749, 55, 'C270', 1),
(750, 55, 'C280', 1),
(751, 55, 'C30 AMG', 1),
(752, 55, 'C300', 1),
(753, 55, 'C32 AMG', 1),
(754, 55, 'C320', 1),
(755, 55, 'C350', 1),
(756, 55, 'C36 AMG', 1),
(757, 55, 'C43 AMG', 1),
(758, 55, 'C55 AMG', 1),
(759, 55, 'C63 AMG', 1),
(760, 55, 'CLA180', 1),
(761, 55, 'CLA200', 1),
(762, 55, 'CLA220', 1),
(763, 55, 'CLA250', 1),
(764, 55, 'CLA45 AMG', 1),
(765, 55, 'CLC', 1),
(766, 55, 'Citan', 1),
(767, 55, 'Cl', 1),
(768, 55, 'Cl55 AMG', 1),
(769, 55, 'Cl63 AMG', 1),
(770, 55, 'Cl65 AMG', 1),
(771, 55, 'Clk', 1),
(772, 55, 'Clk55 AMG', 1),
(773, 55, 'Clk63 AMG', 1),
(774, 55, 'Cls250', 1),
(775, 55, 'Cls300', 1),
(776, 55, 'Cls320', 1),
(777, 55, 'Cls350', 1),
(778, 55, 'Cls500', 1),
(779, 55, 'Cls55', 1),
(780, 55, 'Cls55 AMG', 1),
(781, 55, 'Cls63', 1),
(782, 55, 'Cls63 AMG', 1),
(783, 55, 'E', 1),
(784, 55, 'E200', 1),
(785, 55, 'E220', 1),
(786, 55, 'E230', 1),
(787, 55, 'E240', 1),
(788, 55, 'E250', 1),
(789, 55, 'E260', 1),
(790, 55, 'E270', 1),
(791, 55, 'E280', 1),
(792, 55, 'E290', 1),
(793, 55, 'E300', 1),
(794, 55, 'E320', 1),
(795, 55, 'E350', 1),
(796, 55, 'E36 AMG', 1),
(797, 55, 'E400', 1),
(798, 55, 'E420', 1),
(799, 55, 'E430', 1),
(800, 55, 'E50 AMG', 1),
(801, 55, 'E500', 1),
(802, 55, 'E55', 1),
(803, 55, 'E55 AMG', 1),
(804, 55, 'E60', 1),
(805, 55, 'E60 AMG', 1),
(806, 55, 'E63 AMG', 1),
(807, 55, 'GLA', 1),
(808, 55, 'R', 1),
(809, 55, 'R280', 1),
(810, 55, 'R300', 1),
(811, 55, 'R320', 1),
(812, 55, 'R350', 1),
(813, 55, 'R500', 1),
(814, 55, 'R63 AMG', 1),
(815, 55, 'S', 1),
(816, 55, 'S250', 1),
(817, 55, 'S280', 1),
(818, 55, 'S300', 1),
(819, 55, 'S320', 1),
(820, 55, 'S350', 1),
(821, 55, 'S400', 1),
(822, 55, 'S420', 1),
(823, 55, 'S430', 1),
(824, 55, 'S450', 1),
(825, 55, 'S500', 1),
(826, 55, 'S55 AMG', 1),
(827, 55, 'S550', 1),
(828, 55, 'S600', 1),
(829, 55, 'S63', 1),
(830, 55, 'S63 AMG', 1),
(831, 55, 'S65', 1),
(832, 55, 'S65 AMG', 1),
(833, 55, 'SLR', 1),
(834, 55, 'SLS', 1),
(835, 55, 'Sl', 1),
(836, 55, 'Sl55 AMG', 1),
(837, 55, 'Sl60 AMG', 1),
(838, 55, 'Sl63 AMG', 1),
(839, 55, 'Sl65 AMG', 1),
(840, 55, 'Slk', 1),
(841, 55, 'Slk32 AMG', 1),
(842, 55, 'Slk55 AMG', 1),
(843, 55, 'Sls AMG', 1),
(844, 55, 'V230', 1),
(845, 55, 'Vaneo', 1),
(846, 55, 'E63', 1),
(847, 56, 'Marauder', 1),
(848, 56, 'Milan', 1),
(849, 56, 'Monarch', 1),
(850, 56, 'Villager', 1),
(851, 57, 'Mga', 1),
(852, 57, 'Mgb', 1),
(853, 57, 'Mgf', 1),
(854, 57, 'Tf', 1),
(855, 57, 'Zr', 1),
(856, 57, 'Zs', 1),
(857, 57, 'Zt', 1),
(858, 57, 'Zt-t', 1),
(859, 58, 'Clubman', 1),
(860, 58, 'Cooper', 1),
(861, 58, 'Cooper cabrio', 1),
(862, 58, 'Cooper s', 1),
(863, 58, 'Cooper s cabrio', 1),
(864, 58, 'Coupe', 1),
(865, 58, 'D one', 1),
(866, 58, 'One', 1),
(867, 58, 'One cabrio', 1),
(868, 58, 'Paceman', 1),
(869, 59, '3000 gt', 1),
(870, 59, 'Carisma', 1),
(871, 59, 'Colt', 1),
(872, 59, 'Cordia', 1),
(873, 59, 'Eclipse', 1),
(874, 59, 'Galant', 1),
(875, 59, 'Grandis', 1),
(876, 59, 'Lancer', 1),
(877, 59, 'Sapporo', 1),
(878, 59, 'Sigma', 1),
(879, 59, 'Space gear', 1),
(880, 59, 'Space runner', 1),
(881, 59, 'Space star', 1),
(882, 59, 'Space wagon', 1),
(883, 59, 'Starion', 1),
(884, 59, 'Tredia', 1),
(885, 60, 'Aero8', 1),
(886, 61, '1360', 1),
(887, 61, '1361', 1),
(888, 61, '1500', 1),
(889, 61, '2136', 1),
(890, 61, '2138', 1),
(891, 61, '2140', 1),
(892, 61, '2141', 1),
(893, 61, '21412', 1),
(894, 61, '21417', 1),
(895, 61, '2142', 1),
(896, 61, '2715', 1),
(897, 61, '401', 1),
(898, 61, '403', 1),
(899, 61, '407', 1),
(900, 61, '408', 1),
(901, 61, '412', 1),
(902, 61, '426', 1),
(903, 61, '427', 1),
(904, 61, '503', 1),
(905, 61, 'Aleko', 1),
(906, 61, 'Иж', 1),
(907, 62, '100 nx', 1),
(908, 62, '200 sx', 1),
(909, 62, '240 z', 1),
(910, 62, '280 z', 1),
(911, 62, '300 zx', 1),
(912, 62, '350z', 1),
(913, 62, '370Z', 1),
(914, 62, 'Almera', 1),
(915, 62, 'Almera tino', 1),
(916, 62, 'Altima', 1),
(917, 62, 'Bluebird', 1),
(918, 62, 'Cedric', 1),
(919, 62, 'Cherry', 1),
(920, 62, 'Cube', 1),
(921, 62, 'Figaro', 1),
(922, 62, 'Gt-r', 1),
(923, 62, 'Kubistar', 1),
(924, 62, 'Laurel', 1),
(925, 62, 'Leaf ', 1),
(926, 62, 'Maxima', 1),
(927, 62, 'Micra', 1),
(928, 62, 'Note', 1),
(929, 62, 'Pickup', 1),
(930, 62, 'Pixo', 1),
(931, 62, 'Prairie', 1),
(932, 62, 'Primera', 1),
(933, 62, 'Pulsar', 1),
(934, 62, 'Serena', 1),
(935, 62, 'Silvia', 1),
(936, 62, 'Skyline', 1),
(937, 62, 'Stantza', 1),
(938, 62, 'Sunny', 1),
(939, 62, 'Tiida', 1),
(940, 62, 'Versa', 1),
(941, 63, 'Achieva', 1),
(942, 63, 'Alero', 1),
(943, 63, 'Aurora', 1),
(944, 63, 'Bravada', 1),
(945, 63, 'Cutlass', 1),
(946, 63, 'Firenza', 1),
(947, 63, 'Intrigue', 1),
(948, 63, 'Regency', 1),
(949, 63, 'Silhouette', 1),
(950, 63, 'Toronado', 1),
(951, 64, 'Adam', 1),
(952, 64, 'Admiral', 1),
(953, 64, 'Agila', 1),
(954, 64, 'Ampera', 1),
(955, 64, 'Ascona', 1),
(956, 64, 'Astra', 1),
(957, 64, 'Calibra', 1),
(958, 64, 'Cascada', 1),
(959, 64, 'Combo', 1),
(960, 64, 'Commodore', 1),
(961, 64, 'Corsa', 1),
(962, 64, 'Diplomat', 1),
(963, 64, 'Gt', 1),
(964, 64, 'Insignia', 1),
(965, 64, 'Kadett', 1),
(966, 64, 'Kapitaen', 1),
(967, 64, 'Manta', 1),
(968, 64, 'Meriva', 1),
(969, 64, 'Monza', 1),
(970, 64, 'Omega', 1),
(971, 64, 'Rekord', 1),
(972, 64, 'Senator', 1),
(973, 64, 'Signum', 1),
(974, 64, 'Sintra', 1),
(975, 64, 'Speedster', 1),
(976, 64, 'Tigra', 1),
(977, 64, 'Vectra', 1),
(978, 64, 'Zafira', 1),
(979, 65, 'Kancil', 1),
(980, 65, 'Kelisa', 1),
(981, 65, 'Kembara', 1),
(982, 65, 'Kenari', 1),
(983, 65, 'Nippa', 1),
(984, 65, 'Rusa', 1),
(985, 66, '1007', 1),
(986, 66, '104', 1),
(987, 66, '106', 1),
(988, 66, '107', 1),
(989, 66, '202', 1),
(990, 66, '204', 1),
(991, 66, '205', 1),
(992, 66, '206', 1),
(993, 66, '207', 1),
(994, 66, '208', 1),
(995, 66, '3008', 1),
(996, 66, '301', 1),
(997, 66, '304', 1),
(998, 66, '305', 1),
(999, 66, '306', 1),
(1000, 66, '307', 1),
(1001, 66, '308', 1),
(1002, 66, '309', 1),
(1003, 66, '402', 1),
(1004, 66, '403', 1),
(1005, 66, '404', 1),
(1006, 66, '405', 1),
(1007, 66, '406', 1),
(1008, 66, '407', 1),
(1009, 66, '5008', 1),
(1010, 66, '504', 1),
(1011, 66, '505', 1),
(1012, 66, '508', 1),
(1013, 66, '604', 1),
(1014, 66, '605', 1),
(1015, 66, '607', 1),
(1016, 66, '806', 1),
(1017, 66, '807', 1),
(1018, 66, 'Bipper', 1),
(1019, 66, 'Partner', 1),
(1020, 66, 'RCZ', 1),
(1021, 66, 'Range', 1),
(1022, 67, 'Cevennes', 1),
(1023, 67, 'Speedster', 1),
(1024, 68, 'Acclaim', 1),
(1025, 68, 'Barracuda', 1),
(1026, 68, 'Breeze', 1),
(1027, 68, 'Colt', 1),
(1028, 68, 'Grand voyager', 1),
(1029, 68, 'Horizon', 1),
(1030, 68, 'Laser', 1),
(1031, 68, 'Neon', 1),
(1032, 68, 'Prowler', 1),
(1033, 68, 'Reliant', 1),
(1034, 68, 'Road runner', 1),
(1035, 68, 'Sundance', 1),
(1036, 68, 'Volare', 1),
(1037, 68, 'Voyager', 1),
(1038, 69, 'Pickup', 1),
(1039, 70, 'Aztec', 1),
(1040, 70, 'Bonneville', 1),
(1041, 70, 'Fiero', 1),
(1042, 70, 'Firebird', 1),
(1043, 70, 'Grand am', 1),
(1044, 70, 'Grand prix', 1),
(1045, 70, 'Gto', 1),
(1046, 70, 'Lemans', 1),
(1047, 70, 'Solstice', 1),
(1048, 70, 'Sunbird', 1),
(1049, 70, 'Sunfire', 1),
(1050, 70, 'Tempest', 1),
(1051, 70, 'Trans am', 1),
(1052, 70, 'Trans sport', 1),
(1053, 70, 'Vibe', 1),
(1054, 71, '911', 1),
(1055, 71, '918 Spyder', 1),
(1056, 71, '924', 1),
(1057, 71, '928', 1),
(1058, 71, '935', 1),
(1059, 71, '944', 1),
(1060, 71, '956', 1),
(1061, 71, '968', 1),
(1062, 71, '993', 1),
(1063, 71, '996', 1),
(1064, 71, 'Boxster', 1),
(1065, 71, 'Carrera', 1),
(1066, 71, 'Cayman', 1),
(1067, 71, 'Panamera', 1),
(1068, 72, '400', 1),
(1069, 72, 'Persone', 1),
(1070, 72, 'Satria', 1),
(1071, 73, '10', 1),
(1072, 73, '11', 1),
(1073, 73, '12', 1),
(1074, 73, '14', 1),
(1075, 73, '16', 1),
(1076, 73, '18', 1),
(1077, 73, '19', 1),
(1078, 73, '20', 1),
(1079, 73, '21', 1),
(1080, 73, '25', 1),
(1081, 73, '29', 1),
(1082, 73, '30', 1),
(1083, 73, '4', 1),
(1084, 73, '5', 1),
(1085, 73, '8', 1),
(1086, 73, '9', 1),
(1087, 73, 'Alpine', 1),
(1088, 73, 'Avantime', 1),
(1089, 73, 'Bakara', 1),
(1090, 73, 'Bulgar', 1),
(1091, 73, 'Captur', 1),
(1092, 73, 'Chamade', 1),
(1093, 73, 'Clio', 1),
(1094, 73, 'Espace', 1),
(1095, 73, 'Express', 1),
(1096, 73, 'Fluence', 1),
(1097, 73, 'Fuego', 1),
(1098, 73, 'Grand espace', 1),
(1099, 73, 'Grand scenic', 1),
(1100, 73, 'Kangoo', 1),
(1101, 73, 'Koleos', 1),
(1102, 73, 'Laguna', 1),
(1103, 73, 'Laguna Coupe', 1),
(1104, 73, 'Latitude', 1),
(1105, 73, 'Megane', 1),
(1106, 73, 'Modus', 1),
(1107, 73, 'Nevada', 1),
(1108, 73, 'Rapid', 1),
(1109, 73, 'Safrane', 1),
(1110, 73, 'Scenic', 1),
(1111, 73, 'Symbol', 1),
(1112, 73, 'Twingo', 1),
(1113, 73, 'Twizy', 1),
(1114, 73, 'Vel satis', 1),
(1115, 73, 'Zoe', 1),
(1116, 74, 'Ghost', 1),
(1117, 74, 'Phantom', 1),
(1118, 74, 'Silver Seraph', 1),
(1119, 74, 'Wraith', 1),
(1120, 75, '111', 1),
(1121, 75, '114', 1),
(1122, 75, '200', 1),
(1123, 75, '213', 1),
(1124, 75, '214', 1),
(1125, 75, '216', 1),
(1126, 75, '220', 1),
(1127, 75, '25', 1),
(1128, 75, '400', 1),
(1129, 75, '414', 1),
(1130, 75, '416', 1),
(1131, 75, '418', 1),
(1132, 75, '420', 1),
(1133, 75, '45', 1),
(1134, 75, '600', 1),
(1135, 75, '618', 1),
(1136, 75, '620', 1),
(1137, 75, '623', 1),
(1138, 75, '75', 1),
(1139, 75, '800', 1),
(1140, 75, '820', 1),
(1141, 75, '825', 1),
(1142, 75, '827', 1),
(1143, 75, 'City', 1),
(1144, 75, 'Estate', 1),
(1145, 75, 'Maestro', 1),
(1146, 75, 'Metro', 1),
(1147, 75, 'Mini', 1),
(1148, 75, 'Montego', 1),
(1149, 75, 'Streetwise', 1),
(1150, 76, 'F16', 1),
(1151, 76, 'F440DCI', 1),
(1152, 76, 'Fun Buggy', 1),
(1153, 76, 'Fun Extreem', 1),
(1154, 76, 'Fun Lander', 1),
(1155, 76, 'Fun Quad', 1),
(1156, 77, '9-3', 1),
(1157, 77, '9-5', 1),
(1158, 77, '900', 1),
(1159, 77, '9000', 1),
(1160, 78, 'LX', 1),
(1161, 79, 'Astra', 1),
(1162, 79, 'Aura', 1),
(1163, 79, 'Sky', 1),
(1164, 80, 'Tc', 1),
(1165, 80, 'Xa', 1),
(1166, 80, 'Xb', 1),
(1167, 81, 'Alhambra', 1),
(1168, 81, 'Altea', 1),
(1169, 81, 'Arosa', 1),
(1170, 81, 'Cordoba', 1),
(1171, 81, 'Exeo', 1),
(1172, 81, 'Fura', 1),
(1173, 81, 'Ibiza', 1),
(1174, 81, 'Inka', 1),
(1175, 81, 'Leon', 1),
(1176, 81, 'Malaga', 1),
(1177, 81, 'Marbella', 1),
(1178, 81, 'Mii', 1),
(1179, 81, 'Ronda', 1),
(1180, 81, 'Terra', 1),
(1181, 81, 'Toledo', 1),
(1182, 81, 'Vario', 1),
(1183, 82, 'Stella', 1),
(1184, 83, 'Noble', 1),
(1185, 84, '1307', 1),
(1186, 84, '1308', 1),
(1187, 84, '1309', 1),
(1188, 84, '1510', 1),
(1189, 84, 'Aront', 1),
(1190, 84, 'Chrysler', 1),
(1191, 84, 'Horizon', 1),
(1192, 84, 'Shambord', 1),
(1193, 84, 'Solara', 1),
(1194, 84, 'Special', 1),
(1195, 84, 'Versail', 1),
(1196, 85, '100', 1),
(1197, 85, '1000', 1),
(1198, 85, '105', 1),
(1199, 85, '120', 1),
(1200, 85, '125', 1),
(1201, 85, '130', 1),
(1202, 85, '135', 1),
(1203, 85, '136', 1),
(1204, 85, 'Citigo', 1),
(1205, 85, 'Fabia', 1),
(1206, 85, 'Favorit', 1),
(1207, 85, 'Felicia', 1),
(1208, 85, 'Forman', 1),
(1209, 85, 'Octavia', 1),
(1210, 85, 'Rapid', 1),
(1211, 85, 'Roomster', 1),
(1212, 85, 'Superb', 1),
(1213, 85, 'Yeti', 1),
(1214, 86, 'Forfour', 1),
(1215, 86, 'Fortwo', 1),
(1216, 86, 'Mc', 1),
(1217, 86, 'Roadster', 1),
(1218, 87, 'Chairman', 1),
(1219, 87, 'Rodius', 1),
(1220, 88, '1800', 1),
(1221, 88, 'BRZ', 1),
(1222, 88, 'Baja', 1),
(1223, 88, 'E12', 1),
(1224, 88, 'Forester', 1),
(1225, 88, 'G3x justy', 1),
(1226, 88, 'Impreza', 1),
(1227, 88, 'Justy', 1),
(1228, 88, 'Legacy', 1),
(1229, 88, 'Libero', 1),
(1230, 88, 'Outback', 1),
(1231, 88, 'Svx', 1),
(1232, 88, 'Trezia', 1),
(1233, 88, 'Vivio', 1),
(1234, 88, 'XT', 1),
(1235, 88, 'XV', 1),
(1236, 89, 'Alto', 1),
(1237, 89, 'Baleno', 1),
(1238, 89, 'Forenza', 1),
(1239, 89, 'Ignis', 1),
(1240, 89, 'Kizashi', 1),
(1241, 89, 'Liana', 1),
(1242, 89, 'Maruti', 1),
(1243, 89, 'Reno', 1),
(1244, 89, 'SX4', 1),
(1245, 89, 'Sg', 1),
(1246, 89, 'Splash', 1),
(1247, 89, 'Swift', 1),
(1248, 89, 'Wagon r', 1),
(1249, 90, '1100', 1),
(1250, 90, '1310', 1),
(1251, 90, 'Horizon', 1),
(1252, 90, 'Matra', 1),
(1253, 90, 'Murena', 1),
(1254, 90, 'Samba', 1),
(1255, 90, 'Simka', 1),
(1256, 90, 'Solara', 1),
(1257, 91, 'Aria', 1),
(1258, 91, 'Estate', 1),
(1259, 91, 'Indica', 1),
(1260, 91, 'Mint', 1),
(1261, 91, 'Nano', 1),
(1262, 92, '.', 1),
(1263, 92, 'Dana', 1),
(1264, 92, 'Kombi', 1),
(1265, 92, 'Slavuta', 1),
(1266, 93, 'Zero', 1),
(1267, 94, 'Fl2850', 1),
(1268, 94, 'Sl3000', 1),
(1269, 95, 'Model S', 1),
(1270, 95, 'Roadster', 1),
(1271, 95, 'Roadster Sport', 1),
(1272, 96, 'Dogan', 1),
(1273, 96, 'Kartal', 1),
(1274, 96, 'Sahin', 1),
(1275, 97, 'Auris', 1),
(1276, 97, 'Avalon', 1),
(1277, 97, 'Avensis', 1),
(1278, 97, 'Avensis verso', 1),
(1279, 97, 'Aygo', 1),
(1280, 97, 'Camry', 1),
(1281, 97, 'Carina', 1),
(1282, 97, 'Celica', 1),
(1283, 97, 'Corolla', 1),
(1284, 97, 'Corolla verso', 1),
(1285, 97, 'Cressida', 1),
(1286, 97, 'Crown', 1),
(1287, 97, 'GT86', 1),
(1288, 97, 'IQ', 1),
(1289, 97, 'Matrix', 1),
(1290, 97, 'Mr2', 1),
(1291, 97, 'Paseo', 1),
(1292, 97, 'Picnic', 1),
(1293, 97, 'Previa', 1),
(1294, 97, 'Prius', 1),
(1295, 97, 'Scion', 1),
(1296, 97, 'Sienna', 1),
(1297, 97, 'Starlet', 1),
(1298, 97, 'Supra', 1),
(1299, 97, 'Tercel', 1),
(1300, 97, 'Verso', 1),
(1301, 97, 'Verso S', 1),
(1302, 97, 'Yaris', 1),
(1303, 97, 'Yaris verso', 1),
(1304, 98, '600', 1),
(1305, 98, '601', 1),
(1306, 98, 'Combi', 1),
(1307, 98, 'T 1.1', 1),
(1308, 99, 'Acclaim', 1),
(1309, 99, 'Dolomite', 1),
(1310, 99, 'Herald', 1),
(1311, 99, 'Spitfire', 1),
(1312, 99, 'Stag', 1),
(1313, 99, 'Tr6', 1),
(1314, 99, 'Tr7', 1),
(1315, 100, 'Kiwi', 1),
(1316, 100, 'Rhea', 1),
(1317, 101, '22', 1),
(1318, 101, '24', 1),
(1319, 101, '3110', 1),
(1320, 101, '3111', 1),
(1321, 101, 'M 20', 1),
(1322, 101, 'M 21', 1),
(1323, 101, 'Siber', 1),
(1324, 102, '142', 1),
(1325, 102, '144', 1),
(1326, 102, '145', 1),
(1327, 102, '164', 1),
(1328, 102, '1800 es', 1),
(1329, 102, '240', 1),
(1330, 102, '244', 1),
(1331, 102, '245', 1),
(1332, 102, '262 c', 1),
(1333, 102, '264', 1),
(1334, 102, '340', 1),
(1335, 102, '343', 1),
(1336, 102, '344', 1),
(1337, 102, '345', 1),
(1338, 102, '360', 1),
(1339, 102, '440', 1),
(1340, 102, '460', 1),
(1341, 102, '480', 1),
(1342, 102, '66', 1),
(1343, 102, '740', 1),
(1344, 102, '744', 1),
(1345, 102, '745', 1),
(1346, 102, '760', 1),
(1347, 102, '765', 1),
(1348, 102, '770', 1),
(1349, 102, '780', 1),
(1350, 102, '850', 1),
(1351, 102, '940', 1),
(1352, 102, '960', 1),
(1353, 102, 'C30', 1),
(1354, 102, 'C70', 1),
(1355, 102, 'P 1800', 1),
(1356, 102, 'S40', 1),
(1357, 102, 'S60', 1),
(1358, 102, 'S70', 1),
(1359, 102, 'S80', 1),
(1360, 102, 'V40', 1),
(1361, 102, 'V50', 1),
(1362, 102, 'V60', 1),
(1363, 102, 'V70', 1),
(1364, 102, 'Xc70', 1),
(1365, 103, '1200', 1),
(1366, 103, '1300', 1),
(1367, 103, '1302', 1),
(1368, 103, '1303', 1),
(1369, 103, '1500', 1),
(1370, 103, '1600', 1),
(1371, 103, 'Bora', 1),
(1372, 103, 'CC', 1),
(1373, 103, 'Caddy', 1),
(1374, 103, 'Corrado', 1),
(1375, 103, 'Derby', 1),
(1376, 103, 'Eos', 1),
(1377, 103, 'Fox', 1),
(1378, 103, 'Golf', 1),
(1379, 103, 'Golf Plus', 1),
(1380, 103, 'Golf Variant', 1),
(1381, 103, 'Jetta', 1),
(1382, 103, 'K 70', 1),
(1383, 103, 'Karmann-ghia', 1),
(1384, 103, 'Lupo', 1),
(1385, 103, 'Multivan', 1),
(1386, 103, 'New beetle', 1),
(1387, 103, 'Passat', 1),
(1388, 103, 'Passat CC', 1),
(1389, 103, 'Phaeton', 1),
(1390, 103, 'Polo', 1),
(1391, 103, 'Rabbit', 1),
(1392, 103, 'Santana', 1),
(1393, 103, 'Scirocco', 1),
(1394, 103, 'Sharan', 1),
(1395, 103, 'Touran', 1),
(1396, 103, 'Up', 1),
(1397, 103, 'Vento', 1),
(1398, 104, '223', 1),
(1399, 104, '232', 1),
(1400, 105, '1.3', 1),
(1401, 105, '311', 1),
(1402, 105, '312', 1),
(1403, 105, '353', 1),
(1404, 106, 'Gt', 1),
(1405, 106, 'Mf3', 1),
(1406, 106, 'Mf4', 1),
(1407, 106, 'Mf5', 1),
(1408, 107, 'XS-D055', 1),
(1409, 108, '600', 1),
(1410, 108, '750', 1),
(1411, 108, 'Florida', 1),
(1412, 108, 'Gt 55', 1),
(1413, 108, 'Koral', 1),
(1414, 108, 'Miami', 1),
(1415, 108, 'Yugo 45', 1),
(1416, 109, '1102', 1),
(1417, 109, '1103', 1),
(1418, 109, '1105', 1),
(1419, 109, '965', 1),
(1420, 109, '966', 1),
(1421, 109, '968', 1),
(1422, 109, 'Tavria', 1),
(1423, 110, ' ', 1),
(1424, 111, 'М', 1),
(1425, 112, 'С', 1),
(1426, 113, 'М', 1),
(1427, 2, 'Mdx', 1),
(1428, 2, 'Rdx', 1),
(1429, 114, '10', 1),
(1430, 114, '24', 1),
(1431, 114, '242', 1),
(1432, 114, '243', 1),
(1433, 114, '244', 1),
(1434, 114, '246', 1),
(1435, 114, '32', 1),
(1436, 114, '320', 1),
(1437, 114, '324', 1),
(1438, 114, '328', 1),
(1439, 114, '33', 1),
(1440, 115, 'Rocsta', 1),
(1441, 6, 'Q3', 1),
(1442, 6, 'Q5', 1),
(1443, 6, 'Q7', 1),
(1444, 8, 'Bentayga', 1),
(1445, 116, 'Freeclimber', 1),
(1446, 10, 'X1', 1),
(1447, 10, 'X3', 1),
(1448, 10, 'X4', 1),
(1449, 10, 'X5', 1),
(1450, 10, 'X6', 1),
(1451, 13, 'Rendezvous', 1),
(1452, 14, 'Escalade', 1),
(1453, 14, 'Srx', 1),
(1454, 15, 'Avalanche', 1),
(1455, 15, 'Blazer', 1),
(1456, 15, 'Captiva', 1),
(1457, 15, 'Colorado', 1),
(1458, 15, 'Equinox', 1),
(1459, 15, 'Gmc', 1),
(1460, 15, 'Niva', 1),
(1461, 15, 'Suburban', 1),
(1462, 15, 'Tahoe', 1),
(1463, 15, 'Tracker', 1),
(1464, 15, 'Trailblazer', 1),
(1465, 15, 'Trax', 1),
(1466, 16, 'Cherokee', 1),
(1467, 16, 'Grand cherokee', 1),
(1468, 16, 'Wrangler', 1),
(1469, 17, 'C-Crosser', 1),
(1470, 19, 'Duster', 1),
(1471, 20, 'Korando', 1),
(1472, 20, 'Musso', 1),
(1473, 21, 'Feroza', 1),
(1474, 21, 'Rocky', 1),
(1475, 21, 'Taft', 1),
(1476, 21, 'Terios', 1),
(1477, 21, 'Wildcat', 1),
(1478, 25, 'Dakota', 1),
(1479, 25, 'Durango', 1),
(1480, 25, 'Journey', 1),
(1481, 25, 'Nitro', 1),
(1482, 25, 'Ram', 1),
(1483, 26, '5', 1),
(1484, 30, '500Х', 1),
(1485, 30, 'Campagnola', 1),
(1486, 30, 'Freemont', 1),
(1487, 31, 'Bronco', 1),
(1488, 31, 'Edge', 1),
(1489, 31, 'Escape', 1),
(1490, 31, 'Everest', 1),
(1491, 31, 'Excursion', 1),
(1492, 31, 'Expedition', 1),
(1493, 31, 'Explorer', 1),
(1494, 31, 'F150', 1),
(1495, 31, 'F250', 1),
(1496, 31, 'F350', 1),
(1497, 31, 'F450', 1),
(1498, 31, 'F550', 1),
(1499, 31, 'F650', 1),
(1500, 31, 'F750', 1),
(1501, 31, 'Kuga', 1),
(1502, 31, 'Maverick', 1),
(1503, 31, 'Ranger', 1),
(1504, 117, '469', 1),
(1505, 117, '69', 1),
(1506, 32, 'Tracker', 1),
(1507, 118, 'Envoy', 1),
(1508, 118, 'Jimmy', 1),
(1509, 118, 'Saturn', 1),
(1510, 118, 'Savana', 1),
(1511, 118, 'Sierra', 1),
(1512, 118, 'Sonoma', 1),
(1513, 118, 'Tracker', 1),
(1514, 118, 'Typhoon', 1),
(1515, 118, 'Yukon', 1),
(1516, 33, 'Hover Cuv', 1),
(1517, 33, 'Hover H5', 1),
(1518, 33, 'Hover H6', 1),
(1519, 33, 'Safe', 1),
(1520, 33, 'Steed 5', 1),
(1521, 35, 'Cr-v', 1),
(1522, 35, 'Crosstour', 1),
(1523, 35, 'Element', 1),
(1524, 35, 'Hr-v', 1),
(1525, 35, 'Passport', 1),
(1526, 35, 'Pilot', 1),
(1527, 35, 'Ridgeline', 1),
(1528, 119, 'H1', 1),
(1529, 119, 'H2', 1),
(1530, 119, 'H3', 1),
(1531, 36, 'Galloper', 1),
(1532, 36, 'IX35', 1),
(1533, 36, 'IX55', 1),
(1534, 36, 'Santa fe', 1),
(1535, 36, 'Terracan', 1),
(1536, 36, 'Tucson', 1),
(1537, 38, 'Ex30', 1),
(1538, 38, 'Ex35', 1),
(1539, 38, 'Ex37', 1),
(1540, 38, 'Fx 30', 1),
(1541, 38, 'Fx 35', 1),
(1542, 38, 'Fx 37', 1),
(1543, 38, 'Fx 45', 1),
(1544, 38, 'Fx 50', 1),
(1545, 38, 'Q45', 1),
(1546, 38, 'Qx', 1),
(1547, 38, 'Qx4', 1),
(1548, 40, 'Amigo', 1),
(1549, 40, 'D-max', 1),
(1550, 40, 'Rodeo', 1),
(1551, 40, 'Tfs', 1),
(1552, 40, 'Trooper', 1),
(1553, 40, 'Vehi cross', 1),
(1554, 120, 'Massive', 1),
(1555, 121, 'Cherokee', 1),
(1556, 121, 'Commander', 1),
(1557, 121, 'Compass', 1),
(1558, 121, 'Grand cherokee', 1),
(1559, 121, 'Patriot', 1),
(1560, 121, 'Renegade', 1),
(1561, 121, 'Wrangler', 1),
(1562, 122, 'Montez', 1),
(1563, 42, 'Mohave', 1),
(1564, 42, 'Retona', 1),
(1565, 42, 'Sorento', 1),
(1566, 42, 'Sportage', 1),
(1567, 43, 'Niva', 1),
(1568, 123, 'Magnum', 1),
(1569, 124, 'Defender', 1),
(1570, 124, 'Discovery', 1),
(1571, 124, 'Freelander', 1),
(1572, 124, 'Range Rover Evoque', 1),
(1573, 124, 'Range Rover Sport', 1),
(1574, 124, 'Range rover', 1),
(1575, 125, 'Jx6476da', 1),
(1576, 46, 'Gx470', 1),
(1577, 46, 'Lx', 1),
(1578, 46, 'NX', 1),
(1579, 46, 'RX330', 1),
(1580, 46, 'Rx', 1),
(1581, 46, 'Rx300', 1),
(1582, 46, 'Rx350', 1),
(1583, 46, 'Rx400h', 1),
(1584, 46, 'Rx450', 1),
(1585, 47, 'X60', 1),
(1586, 48, 'Mark Lt', 1),
(1587, 48, 'Mark lt', 1),
(1588, 48, 'Mkx', 1),
(1589, 48, 'Navigator', 1),
(1590, 126, 'Armada', 1),
(1591, 126, 'Bolero', 1),
(1592, 126, 'Cl', 1),
(1593, 126, 'Commander', 1),
(1594, 126, 'Goa', 1),
(1595, 126, 'Marshall', 1),
(1596, 126, 'Scorpio', 1),
(1597, 53, 'B2200', 1),
(1598, 53, 'B2500', 1),
(1599, 53, 'B2600', 1),
(1600, 53, 'BT-50', 1),
(1601, 53, 'Cx-5', 1),
(1602, 53, 'Cx-7', 1),
(1603, 53, 'Cx-9', 1),
(1604, 53, 'Tribute', 1),
(1605, 55, 'G', 1),
(1606, 55, 'G230', 1),
(1607, 55, 'G240', 1),
(1608, 55, 'G250', 1),
(1609, 55, 'G270', 1),
(1610, 55, 'G280', 1),
(1611, 55, 'G290', 1),
(1612, 55, 'G300', 1),
(1613, 55, 'G320', 1),
(1614, 55, 'G350', 1),
(1615, 55, 'G36 AMG', 1),
(1616, 55, 'G400', 1),
(1617, 55, 'G500', 1),
(1618, 55, 'G55 AMG', 1),
(1619, 55, 'G63 AMG', 1),
(1620, 55, 'G65 AMG', 1),
(1621, 55, 'GLA', 1),
(1622, 55, 'GLA 45AMG', 1),
(1623, 55, 'GLA200', 1),
(1624, 55, 'GLA220', 1),
(1625, 55, 'GLA250', 1),
(1626, 55, 'GLC 220', 1),
(1627, 55, 'GLC 250', 1),
(1628, 55, 'GLE', 1),
(1629, 55, 'GLE 350d', 1),
(1630, 55, 'GLE 400', 1),
(1631, 55, 'GLE 450 AMG', 1),
(1632, 55, 'GLE 63 AMG', 1),
(1633, 55, 'GLE 63 S AMG', 1),
(1634, 55, 'Gl', 1),
(1635, 55, 'Gl320', 1),
(1636, 55, 'Gl350', 1),
(1637, 55, 'Gl420', 1),
(1638, 55, 'Gl450', 1),
(1639, 55, 'Gl500', 1),
(1640, 55, 'Gl55 AMG', 1),
(1641, 55, 'Gl63 AMG', 1),
(1642, 55, 'Glk', 1),
(1643, 55, 'Ml', 1),
(1644, 55, 'Ml230', 1),
(1645, 55, 'Ml250', 1),
(1646, 55, 'Ml270', 1),
(1647, 55, 'Ml280', 1),
(1648, 55, 'Ml300', 1),
(1649, 55, 'Ml320', 1),
(1650, 55, 'Ml350', 1),
(1651, 55, 'Ml400', 1),
(1652, 55, 'Ml420', 1),
(1653, 55, 'Ml430', 1),
(1654, 55, 'Ml450', 1),
(1655, 55, 'Ml500', 1),
(1656, 55, 'Ml55 AMG', 1),
(1657, 55, 'Ml63 AMG', 1),
(1658, 56, 'Mountaineer', 1),
(1659, 58, 'Countryman', 1),
(1660, 59, 'ASX', 1),
(1661, 59, 'L200', 1),
(1662, 59, 'Montero', 1),
(1663, 59, 'Outlander', 1),
(1664, 59, 'Pajero', 1),
(1665, 59, 'Pajero pinin', 1),
(1666, 59, 'Pajero sport', 1),
(1667, 62, 'Armada', 1),
(1668, 62, 'Frontier', 1),
(1669, 62, 'Juke', 1),
(1670, 62, 'Murano', 1),
(1671, 62, 'NP300', 1),
(1672, 62, 'Navara', 1),
(1673, 62, 'Pathfinder', 1),
(1674, 62, 'Patrol', 1),
(1675, 62, 'Qashqai', 1),
(1676, 62, 'Rogue', 1),
(1677, 62, 'Terrano', 1),
(1678, 62, 'Titan crew cab', 1),
(1679, 62, 'Titan king', 1),
(1680, 62, 'X-trail', 1),
(1681, 62, 'Xterra', 1),
(1682, 63, 'Bravada', 1),
(1683, 64, 'Antara', 1),
(1684, 64, 'Campo', 1),
(1685, 64, 'Frontera', 1),
(1686, 64, 'Mokka', 1),
(1687, 64, 'Monterey', 1),
(1688, 64, 'Моkka', 1),
(1689, 66, '2008', 1),
(1690, 66, '4007', 1),
(1691, 71, 'Cayenne', 1),
(1692, 71, 'Macan', 1),
(1693, 73, 'Kadjar', 1),
(1694, 73, 'Koleos', 1),
(1695, 73, 'Scenic rx4', 1),
(1696, 127, 'Ceo', 1),
(1697, 77, '9-4X', 1),
(1698, 77, '9-7x', 1),
(1699, 79, 'Outlook', 1),
(1700, 79, 'Vue', 1),
(1701, 83, 'Ceo', 1),
(1702, 85, 'Yeti', 1),
(1703, 128, 'Actyon', 1),
(1704, 128, 'Actyon Sports', 1),
(1705, 128, 'Korando', 1),
(1706, 128, 'Kyron', 1),
(1707, 128, 'Musso', 1),
(1708, 128, 'Rexton', 1),
(1709, 88, 'B9 tribeca', 1),
(1710, 89, 'Grand vitara', 1),
(1711, 89, 'Ignis', 1),
(1712, 89, 'Jimny', 1),
(1713, 89, 'SX4 S-Cross', 1),
(1714, 89, 'Samurai', 1),
(1715, 89, 'Santana', 1),
(1716, 89, 'Sidekick', 1),
(1717, 89, 'Sj', 1),
(1718, 89, 'Vitara', 1),
(1719, 89, 'X-90', 1),
(1720, 89, 'XL-7', 1),
(1721, 91, 'Safari', 1),
(1722, 91, 'Sierra', 1),
(1723, 91, 'Sumo', 1),
(1724, 91, 'Telcoline', 1),
(1725, 91, 'Xenon', 1),
(1726, 129, 'Gurkha', 1),
(1727, 129, 'Judo', 1),
(1728, 97, '4runner', 1),
(1729, 97, 'Fj cruiser', 1),
(1730, 97, 'Harrier', 1),
(1731, 97, 'Highlander', 1),
(1732, 97, 'Hilux', 1),
(1733, 97, 'Land cruiser', 1),
(1734, 97, 'Rav4', 1),
(1735, 97, 'Sequoia', 1),
(1736, 97, 'Tacoma', 1),
(1737, 97, 'Tundra', 1),
(1738, 97, 'Urban Cruiser', 1),
(1739, 97, 'Venza', 1),
(1740, 130, '452', 1),
(1741, 130, '460', 1),
(1742, 130, '469', 1),
(1743, 130, '669', 1),
(1744, 130, '69', 1),
(1745, 130, 'Hunter', 1),
(1746, 130, 'Patriot', 1),
(1747, 102, 'XC60', 1),
(1748, 102, 'Xc90', 1),
(1749, 103, 'Amarok', 1),
(1750, 103, 'Taro', 1),
(1751, 103, 'Tiguan', 1),
(1752, 103, 'Touareg', 1),
(1753, 131, '1021d', 1),
(1754, 131, '1021ls', 1),
(1755, 131, '1021s', 1),
(1756, 131, '2021d', 1),
(1757, 131, '2021s', 1),
(1758, 110, ' ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `car_modification`
--

CREATE TABLE IF NOT EXISTS `car_modification` (
  `car_modification_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_modification_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_modification_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `car_modification`
--

INSERT INTO `car_modification` (`car_modification_id`, `car_modification_name`) VALUES
(1, 'Saloon'),
(2, 'Estate Car'),
(3, 'Cabrio');

-- --------------------------------------------------------

--
-- Table structure for table `car_transmission`
--

CREATE TABLE IF NOT EXISTS `car_transmission` (
  `car_transmission_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_transmission_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_transmission_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `car_transmission`
--

INSERT INTO `car_transmission` (`car_transmission_id`, `car_transmission_name`) VALUES
(1, 'Manual'),
(2, 'Automatic');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_parent_id` int(10) unsigned DEFAULT NULL,
  `category_type` tinyint(4) DEFAULT '1',
  `category_title` varchar(255) DEFAULT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `category_keywords` varchar(255) DEFAULT NULL,
  `category_img` varchar(255) DEFAULT NULL,
  `category_active` tinyint(4) DEFAULT '1',
  `category_ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_slug` (`category_slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_parent_id`, `category_type`, `category_title`, `category_slug`, `category_description`, `category_keywords`, `category_img`, `category_active`, `category_ord`) VALUES
(1, NULL, 2, 'Real Estates', 'real-estates', 'Real Estates', 'Real Estates', 'house158.png', 1, 10),
(2, NULL, 1, 'Cars and Parts', 'cars-and-parts', 'Cars and Parts', 'Cars and Parts', 'car189.png', 1, 20),
(3, NULL, 1, 'Electronics', 'electronics', 'Electronics', 'Electronics', 'personal5.png', 1, 30),
(4, NULL, 1, 'Sport, Books, Hobby', 'sports-books-hobby', 'Sport, Books, Hobby', 'Sport, Books, Hobby', 'man459.png', 1, 40),
(5, NULL, 1, 'Pets', 'pets', 'Pets', 'Pets', 'print48.png', 1, 50),
(6, NULL, 1, 'Home and Garden', 'home-and-garden', 'Home and Garden', 'Home and Garden', 'sofa9.png', 1, 60),
(7, NULL, 1, 'Fashion', 'fashion', 'Fashion', 'Fashion', 'tshirt18.png', 1, 70),
(8, NULL, 1, 'Baby and Kids', 'baby-and-kids', 'Baby and Kids', 'Baby and Kids', 'babies35.png', 1, 80),
(9, NULL, 1, 'Тourism', 'tourism', 'Тourism', 'Тourism', 'flying.png', 1, 90),
(10, NULL, 1, 'Business, Services', 'business-services', 'Business, Services', 'Business, Services', 'two205.png', 1, 100),
(11, NULL, 1, 'Jobs', 'jobs', 'Jobs', 'Jobs', 'man337.png', 1, 110),
(12, NULL, 1, 'Give away', 'give-away', 'Give away', 'Give away', 'christmas.png', 1, 120),
(13, 1, 2, 'For Sale', 'for-sale', 'For Sale', 'For Sale', NULL, 1, 10),
(14, 1, 2, 'For Rent', 'for-rent', 'For Rent', 'For Rent', NULL, 1, 20),
(15, 2, 3, 'Cars', 'cars', 'Cars', 'Cars', NULL, 1, 10),
(16, 2, 1, 'Parts', 'parts', 'Parts', 'Parts', NULL, 1, 20),
(17, 3, 1, 'Computers', 'computers', 'Computers', 'Computers', NULL, 1, 10),
(18, 3, 1, 'Phones', 'phones', 'phones', 'phones', NULL, 1, 20),
(19, 13, 1, 'level1 common', 'level1', 'level1', 'level1', NULL, 1, 10),
(20, 19, 4, 'level2 services', 'level2', 'level2', 'level2', NULL, 1, 10),
(21, 20, 5, 'level3 clothes', 'level3', 'level3', 'level3', NULL, 1, 10),
(22, 21, 6, 'level4 shoes', 'level4', 'level4', 'level4', NULL, 1, 10),
(23, 22, 7, 'level5 land', 'level5', 'level5', 'level5', NULL, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `clothes_size`
--

CREATE TABLE IF NOT EXISTS `clothes_size` (
  `clothes_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `clothes_size_name` varchar(255) NOT NULL,
  `clothes_size_ord` int(11) NOT NULL,
  PRIMARY KEY (`clothes_size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `clothes_size`
--

INSERT INTO `clothes_size` (`clothes_size_id`, `clothes_size_name`, `clothes_size_ord`) VALUES
(1, 'S', 15);

-- --------------------------------------------------------

--
-- Table structure for table `estate_construction_type`
--

CREATE TABLE IF NOT EXISTS `estate_construction_type` (
  `estate_construction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `estate_construction_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_construction_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estate_construction_type`
--

INSERT INTO `estate_construction_type` (`estate_construction_type_id`, `estate_construction_type_name`) VALUES
(1, 'Brick'),
(2, 'Panel');

-- --------------------------------------------------------

--
-- Table structure for table `estate_furnishing_type`
--

CREATE TABLE IF NOT EXISTS `estate_furnishing_type` (
  `estate_furnishing_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_furnishing_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_furnishing_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estate_furnishing_type`
--

INSERT INTO `estate_furnishing_type` (`estate_furnishing_type_id`, `estate_furnishing_type_name`) VALUES
(1, 'Furnished'),
(2, 'Unfurnished');

-- --------------------------------------------------------

--
-- Table structure for table `estate_heating_type`
--

CREATE TABLE IF NOT EXISTS `estate_heating_type` (
  `estate_heating_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_heating_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_heating_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `estate_heating_type`
--

INSERT INTO `estate_heating_type` (`estate_heating_type_id`, `estate_heating_type_name`) VALUES
(1, 'Central Heating'),
(2, 'Local Heating');

-- --------------------------------------------------------

--
-- Table structure for table `estate_type`
--

CREATE TABLE IF NOT EXISTS `estate_type` (
  `estate_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `estate_type`
--

INSERT INTO `estate_type` (`estate_type_id`, `estate_type_name`) VALUES
(1, 'Studio'),
(2, 'Loft'),
(3, 'One-room apartment'),
(4, 'Two-room apartment');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_parent_id` int(11) DEFAULT NULL,
  `location_active` tinyint(4) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_slug` varchar(255) NOT NULL,
  `location_post_code` varchar(255) DEFAULT NULL,
  `location_ord` int(11) DEFAULT '0',
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_slug` (`location_slug`),
  KEY `post_code` (`location_post_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location_parent_id`, `location_active`, `location_name`, `location_slug`, `location_post_code`, `location_ord`) VALUES
(1, NULL, 1, 'England', 'england', '1234', 0),
(2, NULL, 1, 'Northern Ireland', 'northern-ireland', NULL, 0),
(3, NULL, 1, 'Scotland', 'scotland', NULL, 0),
(4, NULL, 1, 'Wales', 'wales', NULL, 0),
(5, 1, 1, 'Birmingham', 'birmingham', NULL, 0),
(6, 1, 1, 'Bristol', 'bristol', NULL, 0),
(7, 1, 1, 'Liverpool', 'liverpool', NULL, 0),
(8, 1, 1, 'London', 'london', NULL, 0),
(9, 2, 1, 'Belfast', 'belfast', NULL, 0),
(10, 2, 1, 'Castlereagh', 'castlereagh', NULL, 0),
(11, 2, 1, 'Lisburn', 'lisburn', NULL, 0),
(12, 2, 1, 'Newtownabbey', 'newtownabbey', NULL, 0),
(13, 3, 1, 'Dundee', 'dundee', NULL, 0),
(14, 3, 1, 'Edinburgh', 'edinburgh', NULL, 0),
(15, 3, 1, 'Glasgow', 'glasgow', NULL, 0),
(16, 3, 1, 'Livingston', 'livingston', NULL, 0),
(17, 4, 1, 'Cardiff', 'cardiff', NULL, 0),
(18, 4, 1, 'Cwmbran', 'cwmbran', NULL, 0),
(19, 4, 1, 'Newport', 'newport', NULL, 0),
(20, 4, 1, 'Rhondda', 'rhondda', NULL, 0),
(21, 5, 1, 'level3', 'level3', NULL, 0),
(22, 21, 1, 'level4', 'level4', NULL, 0),
(23, 22, 1, 'level5', 'level5', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_position` tinyint(4) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` varchar(255) DEFAULT NULL,
  `page_keywords` varchar(255) DEFAULT NULL,
  `page_content` text NOT NULL,
  `page_active` tinyint(4) DEFAULT '1',
  `page_ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `page`
--


-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reset_user_email_index` (`email`),
  KEY `password_reset_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--


-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(255) NOT NULL,
  `pay_active` tinyint(4) NOT NULL,
  `pay_ord` int(11) NOT NULL,
  `pay_info_url` varchar(255) NOT NULL,
  `pay_sum` double(8,2) NOT NULL,
  `pay_promo_period` int(11) NOT NULL,
  `pay_sms_prefix` varchar(255) DEFAULT NULL,
  `pay_description` text,
  `pay_ping_url` varchar(255) DEFAULT NULL,
  `pay_allowed_ip` varchar(255) DEFAULT NULL,
  `pay_number` varchar(255) DEFAULT NULL,
  `pay_secret` varchar(255) DEFAULT NULL,
  `pay_testmode` tinyint(4) DEFAULT '0',
  `pay_paypal_mail` varchar(255) DEFAULT NULL,
  `pay_sum_to_charge` double(8,2) DEFAULT '0.00',
  `pay_currency` varchar(10) DEFAULT NULL,
  `pay_locale` varchar(10) DEFAULT NULL,
  `pay_log` tinyint(4) DEFAULT '0',
  `pay_page_name` varchar(255) DEFAULT NULL,
  `pay_secret_key` varchar(255) DEFAULT NULL,
  `pay_publish_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`pay_id`, `pay_name`, `pay_active`, `pay_ord`, `pay_info_url`, `pay_sum`, `pay_promo_period`, `pay_sms_prefix`, `pay_description`, `pay_ping_url`, `pay_allowed_ip`, `pay_number`, `pay_secret`, `pay_testmode`, `pay_paypal_mail`, `pay_sum_to_charge`, `pay_currency`, `pay_locale`, `pay_log`, `pay_page_name`, `pay_secret_key`, `pay_publish_key`) VALUES
(1, 'Mobio SMS Pay', 1, 10, 'http://mobio.bg/site/en/', 4.60, 7, 'DC', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English.', 'http://your domain/mobiopay', '87.120.176.216,194.12.244.114', '1666', NULL, 0, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL),
(2, 'Fortumo SMS Pay', 1, 20, 'https://fortumo.com/', 4.60, 7, 'TXT DCAA', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. ', 'http://your domain/fortumopay', '127.0.0.1,79.125.125.1,79.125.5.205,79.125.5.95,54.72.6.23', '1855', '2e1a1e7515ce57e7475462720a85dd2f', 0, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL),
(3, 'Paypal Standard Pay', 1, 30, 'https://www.paypal.com', 4.60, 7, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', NULL, NULL, NULL, NULL, 0, 'paypal@dedo.bg', 1.00, 'EUR', 'US', 0, 'paypalpay', NULL, NULL),
(4, 'Stripe', 1, 40, 'https://stripe.com/', 4.60, 7, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', NULL, '', '', '', 0, '', 1.00, 'EUR', '', 0, 'stripepay', 'sk_test_BQokikJOvBiI2HlWgH4olfQ2', 'pk_test_6pRNASCoBOKtIshFeQd4XMUh');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_description` varchar(255) NOT NULL,
  `setting_show_in_admin` tinyint(4) DEFAULT '1',
  `setting_field_type` varchar(10) DEFAULT 'text',
  `setting_more_info` varchar(255) DEFAULT NULL,
  `setting_ord` int(11) DEFAULT '0',
  `setting_required` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`, `setting_description`, `setting_show_in_admin`, `setting_field_type`, `setting_more_info`, `setting_ord`, `setting_required`) VALUES
(1, 'site_domain', 'dclassifieds.eu', 'Site domain name', 1, 'text', NULL, 0, 1),
(2, 'site_logo_name', 'DClassifieds V3', 'Site Logo Name', 1, 'text', NULL, 0, 1),
(3, 'site_home_page_title', 'DClassifieds V3', 'Site home page title', 1, 'text', NULL, 0, 1),
(4, 'site_copyright_name', 'DClassifieds', 'Site Copyright Name', 1, 'text', NULL, 0, 1),
(5, 'site_url', 'http://www.dclassifieds.eu', 'Site Url', 1, 'text', NULL, 0, 1),
(6, 'site_price_sign', '&euro;', 'Site Price Sign', 1, 'text', NULL, 0, 1),
(7, 'facebook_site_url', 'https://www.facebook.com/DClassifieds.eu/', 'Facebook Page Url', 1, 'text', NULL, 0, 1),
(8, 'home_page_seo_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Enter Seo Text For Homepage', 1, 'textarea', NULL, 0, 1),
(9, 'admin_list_num_items', '50', 'Num Items on Admin List Page', 1, 'text', NULL, 0, 1),
(10, 'admin_logo_name', '<b>DC</b>lassifieds', 'Admin Logo Name', 1, 'text', NULL, 0, 1),
(11, 'admin_short_logo_name', '<b>DC</b>', 'Admin Short Logo Name', 1, 'text', NULL, 0, 1),
(12, 'admin_skin', 'red', 'Admin Skin', 1, 'text', 'admin_skin', 0, 1),
(13, 'site_logo_img', '592_logo.png', 'Site Logo Image', 1, 'file', 'site_logo_image_info', 0, 0),
(14, 'site_logo_alt', NULL, 'Site Logo Alernate Text', 1, 'text', NULL, 0, 0),
(15, 'footer_html', '<div>Icons made by <a href="http://www.flaticon.com/authors/situ-herrera" title="Situ Herrera">Situ Herrera</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>', 'Footer HTML', 1, 'textarea', NULL, 0, 0),
(16, 'head_scripts', NULL, 'Head Scripts', 1, 'textarea', 'head_scripts', 0, 0),
(17, 'end_body_scripts', NULL, 'Body/Footer Scripts', 1, 'textarea', 'end_body_scripts', 0, 0),
(18, 'start_body_scripts', '<div id="fb-root"></div>\r\n        <script>(function(d, s, id) {\r\n            var js, fjs = d.getElementsByTagName(s)[0];\r\n            if (d.getElementById(id)) return;\r\n            js = d.createElement(s); js.id = id;\r\n            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";\r\n            fjs.parentNode.insertBefore(js, fjs);\r\n        }(document, ''script'', ''facebook-jssdk''));</script>', 'Body Start Scripts', 1, 'textarea', 'start_body_scripts', 0, 0),
(19, 'num_promo_ads_home_page', '10', 'Num Promo Ads on Home page', 1, 'text', NULL, 0, 1),
(20, 'enable_new_ads_on_homepage', '1', 'Enable New/Latest Ads on Home page', 1, 'text', NULL, 0, 1),
(21, 'num_latest_ads_home_page', '12', 'Num New/Latest Ads on Home Page', 1, 'text', NULL, 0, 1),
(22, 'show_small_item_ads_list', '1', 'Show small ad item on home page and search', 1, 'text', NULL, 0, 1),
(23, 'num_promo_ads_list', '6', 'Num Promo ads on Ad List/Search', 1, 'text', NULL, 0, 1),
(24, 'num_ads_list', '24', 'Num Ads on Ad List/Search', 1, 'text', NULL, 0, 1),
(25, 'num_addition_ads_from_user', '4', 'Num Additions Ads From User', 1, 'text', 'Num Additions Ads From User', 0, 1),
(26, 'num_last_viewed_ads', '4', 'Num Ads In Last Viewed', 1, 'text', NULL, 0, 1),
(27, 'site_currency_code', 'EUR', 'Site Currency Code', 1, 'text', NULL, 0, 1),
(28, 'require_ad_image', '1', 'Require at least one image on ad publish', 1, 'text', NULL, 0, 1),
(29, 'ad_num_images', '5', 'Num Ad Images', 1, 'text', NULL, 0, 1),
(48, 'control_mail_edit_subject', '[CONTROL][EDIT] dclassifieds', 'Control Edit Mail Subject', 1, 'text', NULL, 0, 1),
(31, 'num_rows_ad_description_textarea', '10', 'Num Rows Ad Description Field', 1, 'text', NULL, 0, 1),
(32, 'ad_description_min_lenght', '50', 'Ad Description min Lenght in Words', 1, 'text', NULL, 0, 1),
(33, 'ad_image_max_size', '300', 'Ad image Max size in kb', 1, 'text', NULL, 0, 1),
(34, 'enable_link_in_ad', '1', 'Enable link in Ad', 1, 'text', NULL, 0, 1),
(35, 'enable_video_in_ad', '1', 'Enable video in Ad', 1, 'text', NULL, 0, 1),
(36, 'enable_dofollow_link', '0', 'Enable do follow link in ad', 1, 'text', NULL, 0, 1),
(37, 'enable_dofollow_link_promo', '1', 'Enable do follow link only in promo Ad', 1, 'text', NULL, 0, 1),
(38, 'privacy_policy_link', NULL, 'Privacy Policy Link', 1, 'text', NULL, 0, 1),
(39, 'enable_control_mails', '1', 'Send Control Mail On Publish/Edit Ad', 1, 'text', NULL, 0, 1),
(40, 'control_mail', 'webmaster@dclassifieds.eu', 'Control Mail', 1, 'text', NULL, 0, 1),
(41, 'control_mail_subject', '[CONTROL] dclassifieds', 'Control Mail Subject', 1, 'text', NULL, 0, 1),
(42, 'ad_valid_period_in_days', '30', 'Ad Valid Period In Days', 1, 'text', NULL, 0, 1),
(43, 'site_contact_mail', 'test@mylove.bg', 'Site Contact Mail', 1, 'text', NULL, 0, 1),
(44, 'enable_promo_ads', '1', 'Enable Promo Ads', 1, 'text', NULL, 0, 1),
(45, 'site_metric_system', 'sq. m.', 'Site Metric System', 1, 'text', NULL, 0, 1),
(46, 'wallet_promo_ad_price', '4.60', 'Promo Ad Price when payed from wallet', 1, 'text', NULL, 0, 1),
(47, 'wallet_promo_ad_period', '7', 'Promo Ad Period in Days When payed from Wallet', 1, 'text', NULL, 0, 1),
(49, 'num_ads_on_myads', '30', 'Num Ads on My Ads List', 1, 'text', NULL, 0, 1),
(50, 'num_ads_user_list', '30', 'Num Ads on User Ads List', 1, 'text', NULL, 0, 1),
(51, 'mywallet_num_items', '30', 'My Wallet Num Items', 1, 'text', NULL, 0, 1),
(52, 'ad_contact_min_words', '20', 'Minimum Words in Ad Contact Field', 1, 'text', NULL, 0, 1),
(53, 'site_contact_min_words', '10', 'Minimum Words in Site Contact Field', 1, 'text', NULL, 0, 1),
(54, 'enable_recaptcha_site_contact', '1', 'Enable reCaptcha for Site Contact Page', 1, 'text', 'recaptcha_info', 0, 1),
(55, 'recaptcha_site_key', '6Lfv8AoUAAAAACUvo2f97ZsblN1BFp63AIVDUIj2', 'reCaptcha Site Key', 1, 'text', 'recaptcha_info', 0, 0),
(56, 'recaptcha_secret_key', '6Lfv8AoUAAAAANirJ8tJV9zKv1gvMLZNVrYzEQMI', 'reCaptcha Secret Key', 1, 'text', 'recaptcha_info', 0, 0),
(57, 'enable_recaptcha_register', '1', 'Enable reCaptcha for Site Register Page', 1, 'text', 'recaptcha_info', 0, 1),
(58, 'enable_recaptcha_publish', '1', 'Enable reCaptcha for Site Publish Page', 1, 'text', NULL, 0, 1),
(59, 'recaptcha_lang', 'en', 'reCaptcha Language', 1, 'text', NULL, 0, 1),
(60, 'enable_recaptcha_ad_contact', '1', 'Enable reCaptcha for Ad Contact Page', 1, 'text', NULL, 0, 1),
(61, 'enable_facebook_login', '1', 'Enable Facebook Login', 1, 'text', NULL, 0, 1),
(62, 'facebook_app_client_id', '1616767541958956', 'Facebook App Client Id', 1, 'text', NULL, 0, 0),
(63, 'facebook_app_secret', 'a24cc88a6867ad2c69ff13493987b558', 'Facebook App Client Secret', 1, 'text', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shoes_size`
--

CREATE TABLE IF NOT EXISTS `shoes_size` (
  `shoes_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `shoes_size_name` varchar(255) NOT NULL,
  `shoes_size_ord` int(11) NOT NULL,
  PRIMARY KEY (`shoes_size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shoes_size`
--

INSERT INTO `shoes_size` (`shoes_size_id`, `shoes_size_name`, `shoes_size_ord`) VALUES
(1, '33', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_activated` tinyint(4) DEFAULT '0',
  `user_activation_token` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_location_id` int(11) DEFAULT '0',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_lat_lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_user_email_unique` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `avatar`, `email`, `password`, `remember_token`, `user_activated`, `user_activation_token`, `user_location_id`, `user_phone`, `user_skype`, `user_address`, `user_lat_lng`, `user_site`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'dinko1 georgiev1', '1_f2ac6ef22c16c7e2f97abe9ab134c283.jpg', 'dinko359@gmail.com', '$2y$10$OVuW0xkgw2.1hcJTC8nDx.7sMq1mOuLG/MA3Nh0s1uoPPhQdU.bEW', 'l2KKjbAtKl34Y1u3o0Bti7ceylfOVXdZqjgi6zUD1bzjTGSU5S6sK5cHy0RW', 1, NULL, 5, 'phone1', 'skype1', '451-499 24th St N, Birmingham, AL 35203, USA', '(33.5206313, -86.80255310000001)', 'web site1', 1, '2016-05-01 14:18:20', '2016-11-04 19:36:59'),
(2, 'Ivan Ivanov', NULL, 'webmaster@silabg.com', '$2y$10$OVuW0xkgw2.1hcJTC8nDx.7sMq1mOuLG/MA3Nh0s1uoPPhQdU.bEW', 'ZsGZV0Dzu67KfivfPfP2hI1xdZF5nmwnTaZDeppsrrW1lzeBrJ1R4VBI6ru9', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, '2016-05-01 14:23:22', '2016-06-21 14:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_mail`
--

CREATE TABLE IF NOT EXISTS `user_mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `user_id_from` int(11) NOT NULL,
  `user_id_to` int(11) NOT NULL,
  `mail_text` text NOT NULL,
  `mail_date` datetime NOT NULL,
  `mail_hash` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `mail_hash` (`mail_hash`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_mail`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_mail_status`
--

CREATE TABLE IF NOT EXISTS `user_mail_status` (
  `mail_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_status` tinyint(4) NOT NULL,
  `mail_deleted` tinyint(4) DEFAULT '0',
  `mail_hash` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`mail_status_id`),
  KEY `mail_hash` (`mail_hash`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_mail_status`
--

INSERT INTO `user_mail_status` (`mail_status_id`, `mail_id`, `user_id`, `mail_status`, `mail_deleted`, `mail_hash`) VALUES
(1, 1, 1, 2, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d'),
(2, 1, 2, 2, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d'),
(3, 2, 2, 2, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d'),
(4, 2, 1, 2, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d'),
(5, 3, 2, 0, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d'),
(6, 3, 1, 1, 0, '4f57d0ecf9622a0bd8a6e3f79c71a09d');

-- --------------------------------------------------------

--
-- Table structure for table `user_social_account`
--

CREATE TABLE IF NOT EXISTS `user_social_account` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_social_account`
--

INSERT INTO `user_social_account` (`user_id`, `provider_user_id`, `provider`, `created_at`, `updated_at`) VALUES
(1, '10209511660562132', 'facebook', '2016-11-04 19:26:43', '2016-11-04 19:26:43');

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE IF NOT EXISTS `wallet` (
  `wallet_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `sum` double(8,2) NOT NULL,
  `wallet_date` datetime NOT NULL,
  `wallet_description` varchar(255) NOT NULL,
  PRIMARY KEY (`wallet_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`wallet_id`, `user_id`, `ad_id`, `sum`, `wallet_date`, `wallet_description`) VALUES
(1, 1, NULL, 4.60, '2016-11-01 17:25:36', 'test'),
(2, 1, 27, -4.60, '2016-11-01 15:26:07', 'Your ad #27 is Promo Until 2016-11-08.');

-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-02-2019 a las 03:23:57
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_tour`
--

CREATE TABLE `category_tour` (
  `id_catgry` bigint(20) NOT NULL,
  `descrip` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de registro de las categorias de los tours';

--
-- Volcado de datos para la tabla `category_tour`
--

INSERT INTO `category_tour` (`id_catgry`, `descrip`) VALUES
(1, 'Guided tours'),
(2, 'Museums and monuments'),
(3, 'Unique experiences'),
(4, 'Full day trips'),
(5, 'Multi day tours'),
(6, 'Theme parks'),
(7, 'Gifts and memories');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `city`
--

CREATE TABLE `city` (
  `id_city` bigint(20) NOT NULL,
  `city` varchar(256) COLLATE utf8_bin NOT NULL,
  `zip_postal` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de registro de las ciudades';

--
-- Volcado de datos para la tabla `city`
--

INSERT INTO `city` (`id_city`, `city`, `zip_postal`) VALUES
(2, 'Liverpool', 'L1 0AA'),
(3, 'London', 'L1 11AA'),
(4, 'Manchester', 'L1 12AA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prices`
--

CREATE TABLE `prices` (
  `id_type` bigint(20) NOT NULL,
  `id_tours_price` bigint(20) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de registro de los precios por tipo';

--
-- Volcado de datos para la tabla `prices`
--

INSERT INTO `prices` (`id_type`, `id_tours_price`, `price`) VALUES
(1, 1, 108.2),
(1, 2, 88.9),
(1, 3, 34.3),
(1, 4, 72.6),
(1, 5, 108.4),
(1, 6, 150.6),
(1, 7, 67.3),
(1, 8, 35),
(1, 11, 55),
(2, 3, 27.7),
(2, 5, 55.9),
(2, 7, 63.3),
(2, 8, 16.6),
(3, 1, 88.9),
(3, 3, 0),
(3, 8, 0),
(4, 2, 14.8),
(4, 4, 68.9),
(4, 6, 120.6),
(5, 1, 210.5),
(5, 6, 225.8),
(5, 11, 115.8),
(6, 1, 99.55),
(6, 5, 0),
(6, 6, 68.9),
(6, 7, 65.9),
(6, 8, 27.3),
(7, 2, 72.5),
(7, 5, 65.72),
(7, 7, 0),
(7, 11, 66);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserve_tours`
--

CREATE TABLE `reserve_tours` (
  `id_reserve` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_tours` bigint(20) NOT NULL,
  `name_tours` varchar(1024) COLLATE utf8_bin NOT NULL,
  `duration` varchar(256) COLLATE utf8_bin NOT NULL,
  `descrip_large` varchar(4096) COLLATE utf8_bin NOT NULL,
  `date_reserve` date NOT NULL,
  `date_tour` date NOT NULL,
  `shedule_assign` time NOT NULL,
  `tikets` varchar(4096) COLLATE utf8_bin NOT NULL,
  `price_total` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de registro de las reservas de los usuarios';

--
-- Volcado de datos para la tabla `reserve_tours`
--

INSERT INTO `reserve_tours` (`id_reserve`, `id_user`, `id_tours`, `name_tours`, `duration`, `descrip_large`, `date_reserve`, `date_tour`, `shedule_assign`, `tikets`, `price_total`) VALUES
(8, 3, 6, 'Edinburgh Day Trip', '1 or 2 days', 'Discover Edinburgh\'s most important sights at your own pace, with this train excursion to the Scottish capital. It includes a tourist bus, and entry to the unmissable Edinburgh Castle.', '2019-02-04', '2019-02-22', '06:30:00', '1--Adults--150.6--1//5--Family Pass--225.8--1', 484.8),
(9, 3, 5, 'Entrada a KidZania', '4 hours', 'KidZania es una ciudad interactiva para niños donde los más pequeños de la casa aprenden a ser mayores. ¡Una divertida experiencia didáctica imprescindible en Londres!', '2019-02-01', '2019-02-08', '14:00:00', '1--Adults--108.4--1//6--Seniors over 60 years old--0--2', 484.8),
(10, 3, 1, 'Total London Full Day Guided Tour', '9 hours', 'Discover the spirit of London on this full-day guided tour. Visit the city’s most famous landmarks like St Paul’s Cathedral and see the Changing of the Guard at Buckingham Palace and finally relax and admire 360º panoramic views of London from the River Thames', '2019-02-11', '2019-02-27', '10:00:00', '1--Adults--108.2--1//6--Seniors over 60 years old--99.55--3', 406.85);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tours`
--

CREATE TABLE `tours` (
  `id_tours` bigint(20) NOT NULL,
  `id_ctgry` bigint(20) NOT NULL,
  `name` varchar(1024) COLLATE utf8_bin NOT NULL,
  `place` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `img_site_small` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `img_site_large` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `date` date NOT NULL,
  `schedule_range` varchar(256) COLLATE utf8_bin NOT NULL,
  `duration` varchar(256) COLLATE utf8_bin NOT NULL,
  `itinerary` varchar(4096) COLLATE utf8_bin NOT NULL,
  `language` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `descrip_large` varchar(4096) COLLATE utf8_bin DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de registro de los tours';

--
-- Volcado de datos para la tabla `tours`
--

INSERT INTO `tours` (`id_tours`, `id_ctgry`, `name`, `place`, `img_site_small`, `img_site_large`, `date`, `schedule_range`, `duration`, `itinerary`, `language`, `descrip_large`, `featured`, `visible`) VALUES
(1, 3, 'Total London Full Day Guided Tour', 'London', '110247towerBridge.jpg', 'tour-londres-completo.jpg', '2019-02-27', '8:00/10:00', '9 hours', 'Get on board an air-conditioned coach at 8:15am at Central London, sit back and admire the city’s most famous and impressive attractions, including Westminster Abbey, Big Ben and London Bridge, while an English-speaking guide explains the landmarks and “The Big Smoke’s” history.', 'English', 'Discover the spirit of London on this full-day guided tour. Visit the city’s most famous landmarks like St Paul’s Cathedral and see the Changing of the Guard at Buckingham Palace and finally relax and admire 360º panoramic views of London from the River Thames', 0, 1),
(2, 2, 'British Museum Tour', 'London', '110250museo-britanico-monumento-nereidas.jpg', 'visita-guiada-museo-britanico.jpg', '2019-02-26', '10:00/ 14:30/12:00', '2 hours', 'With one of the most important collections in the world, this is the third most-visited museum, after the Louvre in Paris and the Metropolitan Museum in New York City. Its vast collection includes world art and artifacts from Ancient Greece, Ancient Egypt, Mexico’s ancient civilizations and Easter Island.  During the British Museum tour, you’ll admire its highlights including the Greek and Egyptian areas, double-headed Aztec serpent, the Assyrian lion hunt reliefs, Lewis Chessmen, the Parthenon sculptures, the colossal statue of Ramesses II, the Holy Thorn Reliquary, the Mechanical model of the solar system, the Easter Island moai and the Sutton Hoo Helmet.', 'English', 'The British Museum is the UK’s most-visited museum. Accompanied by history and art-enthusiast guide, you’ll admire the Museum’s masterpieces and learn how humans have shaped our world.', 1, 1),
(3, 3, 'London Eye Tickets', 'London', '110243london-eye-atardecer.jpg', 'entradas-london-eye.jpg', '2019-03-08', '11:00/12:00/16:00', '1/2 hours', 'Enjoy a 30-minute ride on board one of the world’s most famous Ferris wheels and one of London’s iconic symbols since it was inaugurated in 2000. From its highest point, you’ll admire the whole of London. You’ll see how the River Thames winds its way across the city and spot other attractions such as the impressive Buckingham Palace, Palace of Westminster, Big Ben, Tower Bridge and St Paul’s Cathedral. Enjoy some of the best panoramic views of London, breathtaking both during the day and at night-time.', 'English', 'Take a trip on the London Eye, Europe’s largest Ferris wheel, by boarding one of its glass capsules and enjoy incomparable panoramic views over the city. Check out London’s landmarks like the Big Ben, Buckingham Palace, St Paul’s Cathedral or the River Thames standing 443-feet high.', 0, 1),
(4, 3, 'Shrek&#39;s Adventure Ticket', 'London', '110158shrek-adventure.jpg', 'entrada-shrek-adventure.jpg', '2019-02-28', '11:00/14:00', 'As long as you wish', 'The Kingdom of Far Far Away, where Shrek, Donkey, and his friends live, is now at your fingertips. Enjoy a memorable day with the characters from one of Dreamworks’ biggest films in recent years. Begin the tour by boarding a magical 4D flying bus and bump into Shrek&#39;s loyal friends, including Puss in Boots, Pinocchio, Donkey, Fiona, and the Muffin Man. Then, enjoy various themed live shows with the iconic characters of Shrek.', 'English', 'Lose yourself in the Kingdom of Far Far Away with this magical experience for all the family. Book your ticket online and spend an unforgettable day at Shrek&#39;s Adventure!.', 0, 1),
(5, 6, 'Entrada a KidZania', 'London', '110240tienda-kidzania.jpg', 'entrada-kidzania.jpg', '2019-02-25', '10:00/14:00/08:00', '4 hours', 'Located in the Westfield London Shopping Center, KidZania is a tiny city ​​of scale dedicated to children. In its more than 7,000 square meters, children learn in a fun and didactic way how the world of adults works. While playing, children and pre-teens can experience first-person roles and careers. In this way, they can know, for example, what a scientific laboratory consists of, a fire station or a television studio in which the daily news is presented. KidZania is especially recommended for children between 1 and 14 years old. Children under the age of 8 can access the center alone. It is not necessary to reserve an adult ticket for this case. For these cases, it is only required that a person over 18 years of age be responsible for the minor who will enter to play in KidZania by presenting themselves at the accreditation desk at the beginning and at the end of the 4 hours that the activity lasts.', 'English', 'KidZania is an interactive city for children where the little ones of the house learn to be older. A fun educational experience essential in London!.', 0, 1),
(6, 5, 'Edinburgh Day Trip', 'Scotland', '110236castillo-edimburgo-entrada.jpg', 'excursion-edimburgo.jpg', '2019-03-01', '6:30', '1 or 2 days', 'The tour meets at 6:30 am at the Kings Cross ticket office, where we will give you your tickets, a map of Edinburgh and information of interest so you can make the most of your trip to Scotland. At 7:00 am the train begins its 4 and a half hour journey, passing through England and enjoying the beautiful views of the East Coast and the authentic landscapes of the Scottish lowlands.', 'English', 'Discover Edinburgh&#39;s most important sights at your own pace, with this train excursion to the Scottish capital. It includes a tourist bus, and entry to the unmissable Edinburgh Castle.', 1, 1),
(7, 4, 'Stonehenge Day Trip', 'London', '110233stonehenge.jpg', 'excursion-stonehenge.jpg', '2019-03-01', '8:15/13:15/16:30', '6 hours', 'Get on board an air-conditioned coach at central London and head east to Wiltshire, home to the legendary Stonehenge. The journey will take around 1-hour-and-30-minutes. Upon arrival, you’ll have two hours to visit the prehistoric monument at your own leisure, as the tour includes a full entry to the enclosure. On your return, the coach will drop you off at Gloucester Road, in Kensington.', 'English', 'Built approximately 5,000 years ago, Stonehenge is one of the most famous megalithic structures in the world. Travel to Wiltshire and discover this remarkable man-made monument in person. ', 1, 1),
(8, 6, 'Tower of London Tickets', 'London', 'torreLondres.jpg', 'entradas-torre-londres.jpg', '2019-02-20', '09:00/13:30/16:00', 'As long as you wish', 'Discover the city’s history while exploring this historic Castle: visit the monarch’s chambers, the Royal Menagerie, where the wild animals were kept, find out where Thomas Moore and Anne Boleyn were executed and explore the prison where William Wallace was kept before his execution in 1305. The Tower’s most famous room houses the Crown Jewels, a collection of ceremonial objects including the oldest Crown Jewel, St Edward’s Crown, which is used to crown English and British monarchs. Another impressive piece is the Imperial State Crown, which is worn by the monarch at the annual State Opening of Parliament and the Cullinan Diamond, the largest rough diamond found in South Africa. It also contains the Koh-i-Noor, the oldest diamond known.', 'English', 'Visit the Tower of London and discover the dark past of the Castle, which was once a royal residence, then transformed into a prison, an execution site, a Royal Menagerie and nowadays, houses the Crown Jewels.', 1, 1),
(11, 6, 'Harry Potter Studio Tour', 'London', '101606harry-potter-studio-tour.jpg', '101606tour-harry-potter-warner-bros.jpg', '2019-03-09', '08:00/11:00/16:00', '7 Hours', 'The Warner Bros. London Studio Tour leaves from the city centre every hour. It takes approximately one hour to get to the Studios. During the tour, you’ll discover the Great Hall, explore Dumbledore’s office, see the original props like Harry&#39;s Nimbus 2000 and Hagrid’s flying motorcycle, as well as visit the Gryffindor Common Room, the dormitories, Hagrid’s hut, Ollivander&#39;s wand shop and the Quidditch store. You’ll also walk through Gringotts Wizarding Bank, sit at the Potions classroom and get a glimpse of Professor Umbridge’s office in the Ministry of Magic. This behind-the-scenes walking tour also includes the chance to find out how they filmed all the special effects and brought to life the story&#39;s various creatures. The Studio also features several interactive exhibitions, where you’ll feel one of the characters.', 'English', 'This Harry Potter studio tour is where you can discover the original film sets, special effects, authentic props and costumes from the eight-film series. The ideal place to visit for muggles and witches alike!', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_price`
--

CREATE TABLE `type_price` (
  `id_type` bigint(20) NOT NULL,
  `descrip` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla de los tipos de precios que pueden tener los tours';

--
-- Volcado de datos para la tabla `type_price`
--

INSERT INTO `type_price` (`id_type`, `descrip`) VALUES
(1, 'Adults'),
(2, 'Children 3-15 years old'),
(3, 'Children under 3 years old'),
(4, 'Children under 18 years old'),
(5, 'Family Pass'),
(6, 'Seniors over 60 years old'),
(7, 'Students'),
(8, 'Adults + 2 Children 3-5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) NOT NULL,
  `id_city` bigint(20) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin NOT NULL,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `road` varchar(45) COLLATE utf8_bin NOT NULL,
  `clas_user` smallint(6) NOT NULL DEFAULT '0',
  `password` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tabla para llevar registro de los usuarios';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `id_city`, `name`, `email`, `phone`, `road`, `clas_user`, `password`) VALUES
(3, 3, 'Administrador', 'admin@gmail.com', '414-718-4799', 'Unidad 7 calle 23', 1, '8488f5089ededf4943913e36a0bf9992f7a60556'),
(4, 4, 'Maria', 'maria@gmail.com', '344-111-4532', 'calle Evue 32', 0, '8488f5089ededf4943913e36a0bf9992f7a60556');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category_tour`
--
ALTER TABLE `category_tour`
  ADD PRIMARY KEY (`id_catgry`);

--
-- Indices de la tabla `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`);

--
-- Indices de la tabla `prices`
--
ALTER TABLE `prices`
  ADD UNIQUE KEY `id_type` (`id_type`,`id_tours_price`),
  ADD KEY `id_tours_price` (`id_tours_price`);

--
-- Indices de la tabla `reserve_tours`
--
ALTER TABLE `reserve_tours`
  ADD PRIMARY KEY (`id_reserve`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_tours` (`id_tours`);

--
-- Indices de la tabla `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id_tours`),
  ADD KEY `id_ctgry` (`id_ctgry`);

--
-- Indices de la tabla `type_price`
--
ALTER TABLE `type_price`
  ADD PRIMARY KEY (`id_type`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_address` (`id_city`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category_tour`
--
ALTER TABLE `category_tour`
  MODIFY `id_catgry` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `city`
--
ALTER TABLE `city`
  MODIFY `id_city` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reserve_tours`
--
ALTER TABLE `reserve_tours`
  MODIFY `id_reserve` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tours`
--
ALTER TABLE `tours`
  MODIFY `id_tours` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `type_price`
--
ALTER TABLE `type_price`
  MODIFY `id_type` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `type_price` (`id_type`),
  ADD CONSTRAINT `prices_ibfk_2` FOREIGN KEY (`id_tours_price`) REFERENCES `tours` (`id_tours`);

--
-- Filtros para la tabla `reserve_tours`
--
ALTER TABLE `reserve_tours`
  ADD CONSTRAINT `reserve_tours_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reserve_tours_ibfk_3` FOREIGN KEY (`id_tours`) REFERENCES `tours` (`id_tours`);

--
-- Filtros para la tabla `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `tours_ibfk_1` FOREIGN KEY (`id_ctgry`) REFERENCES `category_tour` (`id_catgry`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

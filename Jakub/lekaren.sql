-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Št 11.Jún 2020, 23:18
-- Verzia serveru: 10.4.11-MariaDB
-- Verzia PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `lekaren`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `lekaren_objednavky`
--

CREATE TABLE `lekaren_objednavky` (
  `id` int(11) NOT NULL,
  `meno` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  `adresa` text COLLATE utf8_slovak_ci NOT NULL,
  `tovar` text COLLATE utf8_slovak_ci NOT NULL,
  `doprava` varchar(10) COLLATE utf8_slovak_ci NOT NULL,
  `datum_odberu` varchar(20) COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `lekaren_objednavky`
--

INSERT INTO `lekaren_objednavky` (`id`, `meno`, `adresa`, `tovar`, `doprava`, `datum_odberu`) VALUES
(44, 'Mentha Piperina', 'Mätová 24', ';12', 'kurier', '6-11');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `lekaren_pouzivatelia`
--

CREATE TABLE `lekaren_pouzivatelia` (
  `id_pouz` smallint(6) NOT NULL,
  `prihlasmeno` varchar(20) COLLATE utf8_slovak_ci NOT NULL,
  `heslo` varchar(50) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `meno` varchar(20) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `priezvisko` varchar(30) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `lekaren_pouzivatelia`
--

INSERT INTO `lekaren_pouzivatelia` (`id_pouz`, `prihlasmeno`, `heslo`, `meno`, `priezvisko`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrátor', 'systému', 1),
(2, 'uwa', '78f0f32c08873cfdba57f17c855943c0', 'predmet', 'UWA', 0);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `lekaren_tovar`
--

CREATE TABLE `lekaren_tovar` (
  `kod` smallint(6) NOT NULL,
  `nazov` varchar(100) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `popis` text CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `na_sklade` smallint(6) NOT NULL,
  `skupina` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sťahujem dáta pre tabuľku `lekaren_tovar`
--

INSERT INTO `lekaren_tovar` (`kod`, `nazov`, `popis`, `cena`, `na_sklade`, `skupina`) VALUES
(1, 'Panadol', 'Liek s analgetickým a antipyretickým účinkom. Obsahuje kofeín a kodeín. Pomáha tlmi? silnú bolesť a znižuje teplotu. Vhodný pri chrípkovych stavoch. Šumivé tablety.', '3.20', 12, 'bolesť'),
(2, 'Acylpyrín', 'Liek s protizápalovým a analgetickým účinkom. Pomáha tlmi zápal a bolesť rôzneho pôvodu. Znižuje teplotu. Obsahuje kyselinu acetylsalicylovú.', '1.49', 16, 'bolesť'),
(3, 'Ibuprofen', 'Liek na zmiernenie bolesti a zníženie horúčky. Obsahuje ibuprofén. Je určený pre dospelých a deti od 12 rokov', '2.69', 33, 'bolesť'),
(4, 'Nalgesin', 'Liek s protizápalovým, antipyretickým a analgetickým účinkom. Pomáha tlmiť bolesť rôzneho pôvodu-poúrazové a pooperačné, znižuje teplotu a zápal.', '8.45', 6, 'bolesť'),
(5, 'Robicold', 'Liek obsahuje dve liečivá: ibuprofen a pseudoefedrín.\r\n\r\nIbuprofen patrí do skupiny liekov, ktoré sa nazývajú „nesteroidné protizápalové lieky“ (NSAID). Pomáha zmierniť bolesť a zníži? vysokú teplotu (horúčku).\r\nPseudoefedrín patrí do skupiny liekov, dekongestant, ktorý pomáha prečistiť nosové dutiny a zmierniť zdurenie nosovej sliznice.', '8.00', 6, 'bolesť'),
(6, 'Rúško', 'Viacnásobne použiteľné rúško na tvár. Vyrobené na Slovensku.', '4.30', 38, 'chrípka'),
(7, 'Orinox 1 mg/ml', 'Orinox 1 mg/ml je určený na liečbu upchatého nosa, vhodný pre dospelých a deti staršie ako 12 rokov.', '3.65', 6, 'chrípka'),
(8, 'Ambroxol Dr.Max 15 mg/5 ml sirup', '100 ml\r\nUvoľnuje hlien. Uľahčuje vykašliavanie. Tlmí kašeľ.', '4.99', 9, 'chrípka'),
(9, 'Bylinné pastilky Islandský lišajník', '36 ks\r\nBylinné pastilky s extraktom z islandského lišajníka s vitamínom C.', '7.33', 18, 'chrípka'),
(10, 'Simethicon Baby', 'kvapky, 30 ml\r\nKvapky s obsahom simetikónu na liečbu porúch trávenia, nadúvania a črevnej koliky vhodné pre deti už od narodenia.', '3.51', 30, 'trávenie'),
(11, 'Psyllium', '200 g\r\nPsyllium - prírodná vláknina používaná v Indii viac ako 2 000 rokov.', '4.56', 13, 'trávenie'),
(12, ' Laktobacily', 'Komplex 12 kmeňov laktobacilov a bifidobaktérií.', '16.35', 8, 'trávenie'),
(13, 'Gastrofruit', 'Výživový doplnok so štyrmi ovocnými príchuťami obsahujúci vápnik, ktorý prispieva k správnemu fungovaniu tráviacich enzýmov.', '5.00', 5, 'trávenie'),
(14, 'Carboplus 250 mg', 'Carboplus je výživový doplnok s obsahom 250 mg aktívneho uhlia v každej tablete.', '3.99', 35, 'trávenie'),
(15, 'Očné kvapky - Podráždené oči', 'Očná roztoková instilácia na podráždené oči.', '3.49', 16, 'zrakasluch'),
(16, 'AudioMax Classic', 'Penový chránič sluchu na jednorazové použitie (redukcia hluku o 27 dB).', '0.49', 12, 'zrakasluch'),
(17, 'Ušné kvapky Burow', 'kvapky, 20 g\r\nUšné kvapky určené na liečbu zápalov vonkajšieho zvukovodu.', '6.20', 22, 'zrakasluch'),
(18, 'PureVision® 2 HD™ kontaktné šošovky', '6 ks mesačných kontaktných šošoviek, zakrivenie: 8.6, výber dioptrií skladom: -01.00 až -04.50, dodanie ostatných dioptrií -12.00 až +06.00 s časovým oneskorením 1-2 dni naviac.', '24.50', 16, 'zrakasluch'),
(19, 'AVILUT Očné kvapky', 'Očné kvapky AVILUT® sú s lubrikačným, zvlhčujúcim účinkom na báze destilovanej vody s výťažkom zo slezu a s kyselinou hyalurónovou v praktickom sterilnom balení po jednotlivých dávkach.\r\n\r\nZložky prípravku pomáhajú zvlhčiť suché, unavené a červené oči a prinášajú im úľavu a príjemný osviežujúci pocit. Predovšetkým kyselina hyalurónová, už prirodzene prítomná v oku, okrem svojho zvlhčujúceho účinku podporeného výťažkom zo slezu, pôsobí tiež ako lubrikačné činidlo.', '7.59', 12, 'zrakasluch'),
(20, 'PRO32 Zubná kefka soft 3000', 'Zubná kefka PRO32 soft 3000 vhodná pre citlivé zuby a ďasná.', '5.99', 16, 'zuby'),
(21, 'Zubná niť', 'Voskovaná zubná niť. Je impregnovaná fluoridom a má jemnú mätovú príchuť. Pomáha odstraňovať povlak z medzizubných priestorov a poskytuje optimálnu ochranu proti zubnému kazu.', '2.49', 18, 'zuby'),
(22, 'Dental Floss Picks', 'Špáradlo s vloženou zubnou niťou na čistenie medzizubných priestorov.', '1.99', 11, 'zuby'),
(23, 'Toothpaste Intensive', 'Inovatívna zubná pasta, ktorá pomáha brániť podráždeniu ďasien a znižovať riziko vzniku zubných kazov a parodontitídy. Posilňuje, regeneruje a upokojuje ďasná.', '5.45', 12, 'zuby'),
(24, 'Fixačný krém na zubné protézy', 'Môže byť použitý na mokrý i suchý povrch.\r\nVhodný pre úplné alebo čiastočné zubné náhrady.\r\nPevná fixácia zubnej náhrady až 12 hodín.', '3.98', 17, 'zuby'),
(25, 'Morská voda ', 'Izotonický nosový sprej určený na uvoľnenie a vyčistenie nosových slizníc a dutín u detí. Určené pre deti od 0 do 6 rokov.', '4.00', 7, 'alergia'),
(26, 'CLARITINE 10 mg', '10 tabliet\r\nLiek proti alergii. Je určený pre dospelých a deti od 2 rokov s hmotnosťou nad 30 kg na zmiernenie príznakov alergie.', '5.99', 3, 'alergia'),
(27, 'Livostin 0,5 mg/ ml', 'aer nau (fľ.PE) 1x10 ml\r\nNosový sprej poskytujúci úľavu od príznakov alergie . Odstraňuje výtok z nosa, svrbenie, opuch sliznice, kýchanie.', '6.59', 19, 'alergia');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `lekaren_objednavky`
--
ALTER TABLE `lekaren_objednavky`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `lekaren_pouzivatelia`
--
ALTER TABLE `lekaren_pouzivatelia`
  ADD PRIMARY KEY (`id_pouz`),
  ADD UNIQUE KEY `username` (`prihlasmeno`);

--
-- Indexy pre tabuľku `lekaren_tovar`
--
ALTER TABLE `lekaren_tovar`
  ADD PRIMARY KEY (`kod`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `lekaren_objednavky`
--
ALTER TABLE `lekaren_objednavky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pre tabuľku `lekaren_pouzivatelia`
--
ALTER TABLE `lekaren_pouzivatelia`
  MODIFY `id_pouz` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pre tabuľku `lekaren_tovar`
--
ALTER TABLE `lekaren_tovar`
  MODIFY `kod` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

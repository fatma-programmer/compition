-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 12:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tournament_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `correct_answer` varchar(100) NOT NULL,
  `options` text DEFAULT NULL,
  `option_a` varchar(100) DEFAULT NULL,
  `option_b` varchar(100) DEFAULT NULL,
  `option_c` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `event_id`, `question_text`, `correct_answer`, `options`, `option_a`, `option_b`, `option_c`) VALUES
(65, 1, 'ما هو الغاز الذي يشكل معظم الغلاف الجوي للأرض؟', 'النيتروجين', NULL, 'الأكسجين', 'النيتروجين', 'ثاني أكسيد الكربون'),
(66, 1, 'ما هو العنصر الكيميائي الذي يرمز له بـ H؟', 'الهيدروجين', NULL, 'الهليوم', 'الهيدروجين', 'الأكسجين'),
(67, 1, 'ما هو اسم الكوكب الذي يُعرف بالكوكب الأحمر؟', 'المريخ', NULL, 'الأرض', 'المريخ', 'زحل'),
(68, 1, 'ما هي الوحدة الأساسية للوراثة؟', 'الجين', NULL, 'الكروموسوم', 'الجين', 'DNA'),
(69, 1, 'كم عدد الحواس التي يمتلكها الإنسان؟', '5', NULL, '6', '5', '4'),
(70, 2, 'ما هو ناتج 9 + 10؟', '19', NULL, '18', '19', '20'),
(71, 2, 'ما هو ناتج 5 × 6؟', '30', NULL, '25', '30', '35'),
(72, 2, 'كم عدد الأضلاع في مربع؟', '4', NULL, '3', '4', '5'),
(73, 2, 'ما هو 100 ÷ 10؟', '10', NULL, '5', '10', '15'),
(74, 2, 'ما هو ناتج 15 - 7؟', '8', NULL, '7', '8', '6'),
(75, 3, 'من هو أول رئيس للولايات المتحدة الأمريكية؟', 'جورج واشنطن', NULL, 'أبراهام لينكولن', 'جورج واشنطن', 'توماس جيفرسون'),
(76, 3, 'ما هو تاريخ سقوط جدار برلين؟', '1989', NULL, '1990', '1989', '1988'),
(77, 3, 'من اكتشف أمريكا؟', 'كريستوفر كولومبوس', NULL, 'ماركو بولو', 'كريستوفر كولومبوس', 'فاسكو دا غاما'),
(78, 3, 'متى بدأت الحرب العالمية الثانية؟', '1939', NULL, '1940', '1939', '1941'),
(79, 3, 'من كان الملك خلال الثورة الفرنسية؟', 'لويس السادس عشر', NULL, 'لويس الخامس عشر', 'لويس السادس عشر', 'لويس السابع عشر'),
(80, 4, 'ما هي عاصمة اليابان؟', 'طوكيو', NULL, 'سيول', 'طوكيو', 'بكين'),
(81, 4, 'ما هو أكبر محيط في العالم؟', 'المحيط الهادئ', NULL, 'المحيط الأطلسي', 'المحيط الهادئ', 'المحيط الهندي'),
(82, 4, 'ما هو أكبر بلد في العالم؟', 'روسيا', NULL, 'كندا', 'روسيا', 'الصين'),
(83, 4, 'كم عدد الدول في الاتحاد الأوروبي؟', '27', NULL, '28', '27', '26'),
(84, 4, 'ما هي عاصمة مصر؟', 'القاهرة', NULL, 'الجيزة', 'القاهرة', 'الإسكندرية'),
(85, 5, 'من هو مؤلف رواية \"1984\"؟', 'جورج أورويل', NULL, 'ألدوس هكسلي', 'جورج أورويل', 'راي برادبري'),
(86, 5, 'ما هو العنصر الأكثر وفرة في الغلاف الجوي للأرض؟', 'النيتروجين', NULL, 'الأكسجين', 'النيتروجين', 'الأرجون'),
(87, 5, 'كم عدد الألوان في قوس قزح؟', '7', NULL, '6', '7', '8'),
(88, 5, 'من هو الفنان الذي رسم لوحة \"العشاء الأخير\"؟', 'ليوناردو دا فينشي', NULL, 'مايكل أنجلو', 'ليوناردو دا فينشي', 'رافاييل'),
(89, 5, 'ما هي اللغة الأكثر تحدثًا في العالم؟', 'الصينية', NULL, 'الإنجليزية', 'الصينية', 'الإسبانية');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

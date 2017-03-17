-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 10 Φεβ 2017 στις 10:38:55
-- Έκδοση διακομιστή: 5.5.54
-- Έκδοση PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `BarteringDB`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `ads`
--
CREATE DATABASE IF NOT EXISTS BarteringDB;
USE BarteringDB;


CREATE TABLE `ads` (
  `ad_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL,
  `ad_type` int(1) NOT NULL,
  `publication_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `ads`
--

INSERT INTO `ads` (`ad_id`, `user_id`, `product_id`, `ad_type`, `publication_date`, `active`) VALUES
(215, 1, 12467, 1, '2017-02-09 23:53:26', 1),
(216, 1, 12469, 0, '2017-02-10 00:08:49', 1),
(217, 2, 12472, 1, '2017-02-10 00:23:50', 1),
(218, 2, 12474, 1, '2017-02-10 00:39:30', 1),
(219, 1, 12476, 0, '2017-02-10 00:41:16', 1),
(220, 2, 12480, 1, '2017-02-10 00:44:28', 1),
(221, 1, 12481, 1, '2017-02-10 00:56:34', 0),
(222, 2, 12483, 0, '2017-02-10 00:52:12', 1),
(223, 3, 12488, 1, '2017-02-10 01:01:02', 1),
(224, 2, 12489, 1, '2017-02-10 01:01:17', 1),
(225, 1, 12491, 0, '2017-02-10 01:04:43', 1),
(226, 3, 12492, 0, '2017-02-10 01:14:27', 1),
(227, 7, 12498, 1, '2017-02-10 01:16:52', 1),
(228, 2, 12500, 0, '2017-02-10 01:20:52', 1),
(229, 3, 12502, 1, '2017-02-10 01:28:46', 1),
(230, 7, 12504, 0, '2017-02-10 01:29:45', 1),
(231, 1, 12507, 1, '2017-02-10 01:39:35', 1),
(232, 3, 12509, 1, '2017-02-10 01:39:55', 1),
(233, 7, 12512, 1, '2017-02-10 01:46:49', 1),
(234, 7, 12514, 0, '2017-02-10 01:54:04', 1),
(235, 8, 12515, 1, '2017-02-10 02:03:14', 1),
(236, 8, 12516, 1, '2017-02-10 02:06:00', 1),
(237, 3, 12518, 0, '2017-02-10 02:08:12', 1),
(238, 3, 12520, 1, '2017-02-10 02:14:06', 1),
(239, 3, 12521, 1, '2017-02-10 02:18:58', 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `categories`
--

CREATE TABLE `categories` (
  `category_id` int(3) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(3) NOT NULL,
  `leaf` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`, `leaf`) VALUES
(1, 'Υπολογιστές', 0, 0),
(2, 'Περιφερειακά', 1, 0),
(3, 'Hardware', 1, 0),
(4, 'Οθόνες', 2, 0),
(5, 'Εκτυπωτές', 2, 1),
(6, 'Κάρτες Μνήμης', 2, 1),
(7, 'Μητρικές Κάρτες', 3, 1),
(8, 'Μνήμες RAM', 3, 1),
(9, 'Επεξεργαστές', 3, 1),
(10, 'Είδη Γραφείου', 0, 0),
(11, 'Αναλώσιμα', 10, 0),
(12, 'Φωτιστικά', 10, 0),
(13, 'Βιβλία', 0, 0),
(14, 'Επιστήμες', 13, 0),
(15, 'Εκπαίδευση', 13, 0),
(16, 'Λογοτεχνία', 13, 1),
(17, 'Ποίηση', 13, 1),
(18, 'Πληροφορική', 14, 1),
(19, 'Μαθηματικά', 14, 1),
(21, 'Laptops', 1, 1),
(23, 'Λάμπες Γραφείου', 12, 1),
(24, 'Είδη Σπιτιού', 0, 0),
(25, 'Υπνοδωμάτιο', 24, 0),
(26, 'Σαλόνι', 24, 0),
(27, 'Κρεβάτια', 25, 1),
(28, 'Καναπέδες', 26, 1),
(29, 'Πολυθρόνες', 26, 1),
(30, 'Μουσικά Όργανα', 0, 0),
(35, 'Desktops', 1, 1),
(40, 'Plasma', 4, 1),
(41, 'Αφής', 4, 1),
(42, 'Δημοτικό', 15, 1),
(43, 'Γυμνάσιο', 15, 1),
(44, 'Χαρτικά', 10, 0),
(45, 'Φύλλα Α4', 44, 1),
(47, 'Πιάνο', 30, 0),
(51, 'Κάρτες Γραφικών', 3, 1),
(52, 'Ηχεία', 2, 1),
(53, 'Τρόφιμα', 0, 0),
(58, 'Ρούχα', 0, 0),
(59, 'Παλτά', 58, 1),
(60, 'Μελάνια', 11, 1),
(62, 'Παιδικά', 13, 1),
(63, 'Λύκειο', 15, 1),
(64, 'Τετράδια', 44, 1),
(65, 'Κουζίνα', 24, 0),
(66, 'Σκεύη Μαγειρικής', 65, 1),
(67, 'Έγχορδα', 30, 0),
(68, 'Πνευστά', 30, 0),
(69, 'Κιθάρες', 67, 1),
(70, 'Μπάσα', 67, 1),
(71, 'Σαξόφωνα', 68, 1),
(72, 'Τρομπέτες', 68, 1),
(73, 'Πιάνο με ουρά', 47, 1),
(74, 'Ηλεκτρικό πιάνο', 47, 1),
(75, 'Λαχανικά', 53, 1),
(76, 'Ζυμαρικά', 53, 1),
(77, 'Κρέας', 53, 1),
(78, 'Παντελόνια', 58, 1),
(79, 'Μπλούζες', 58, 1);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `interests`
--

CREATE TABLE `interests` (
  `interest_id` int(5) NOT NULL,
  `ad_id` int(11) NOT NULL,
  `user_id` int(3) NOT NULL,
  `ad2_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `interests`
--

INSERT INTO `interests` (`interest_id`, `ad_id`, `user_id`, `ad2_id`) VALUES
(164, 217, 1, NULL),
(165, 221, 2, NULL),
(166, 217, 3, NULL),
(167, 216, 7, NULL),
(168, 223, 2, NULL),
(169, 215, 7, NULL),
(170, 226, 2, 224),
(171, 225, 3, NULL),
(172, 224, 3, 226),
(173, 233, 3, NULL);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `interest_trades`
--

CREATE TABLE `interest_trades` (
  `interest_id` int(3) NOT NULL,
  `product_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `interest_trades`
--

INSERT INTO `interest_trades` (`interest_id`, `product_id`) VALUES
(164, 12479),
(165, 12486),
(166, 12487),
(167, 12494),
(167, 12495),
(168, 12496),
(169, 12497),
(171, 12506),
(173, 12519);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `match_logs`
--

CREATE TABLE `match_logs` (
  `log_id` int(5) NOT NULL,
  `ad_id` int(5) NOT NULL,
  `ad_id2` int(5) DEFAULT NULL,
  `interest_id` int(5) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `match_logs`
--

INSERT INTO `match_logs` (`log_id`, `ad_id`, `ad_id2`, `interest_id`, `date`) VALUES
(1, 221, NULL, 165, '2017-02-10 10:36:12');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `moderators`
--

CREATE TABLE `moderators` (
  `m_id` int(2) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `fname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sname` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `moderators`
--

INSERT INTO `moderators` (`m_id`, `username`, `password`, `fname`, `sname`, `email`) VALUES
(1, 'john', 'john', 'Ιωάννης', 'Κυρίτσης', ''),
(2, 'ioulios', 'ioulios', 'Ιούλιος', 'Τσίκο', ''),
(3, 'theo', 'theo', 'Θεόφιλος', 'Αξιώτης', '');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

CREATE TABLE `products` (
  `product_id` int(3) NOT NULL,
  `category_id` int(3) NOT NULL,
  `product_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_descr` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `product_descr`, `picture`) VALUES
(12467, 40, 'Οθόνη Plasma', 'Δίνεται οθόνη Plasma, 30 ιντσών σε άριστη κατάσταση. Η αγορά της έγινε πριν απο δύο χρόνια και έχει χρησιμοποιηθεί ελάχιστα.', 'p12467.jpg'),
(12468, 27, 'Ημίδιπλο κρεβάτι', 'Ημίδιπλο κρεβάτι σε καλή κατάσταση. Iδανικά το χρώμα του ξύλου να είναι σκούρο καφέ, αλλά όλες οι προτάσεις είναι ευπρόσδεκτες.', 'p12468.jpg'),
(12469, 69, 'Κιθάρα Telecaster', 'Ζητώ κιθάρα fender telecaster χρώματος sunburst , mexican made. Επιθυμώ να είναι σε καλή κατάσταση χωρίς φθορές. ', 'p12469.jpg'),
(12470, 18, 'Βιβλίο προγραμματισμ', '250 σελίδες, ελάχιστα χρησιμοποιημένο. Εξαιρετικό για αρχάριους.', 'p12470.jpg'),
(12471, 21, 'Laptop Dell', 'Διαθέτει διπύρηνο επεξεργαστή Intel Core i7 που πλαισιώνεται από 4 GB μνήμης DDR3, σκληρό δίσκο 128 GB, ενώ διαθέτει και αυτόνομη κάρτα γραφικών της AMD.', 'p12471.jpg'),
(12472, 35, 'INNOVATOR 5 CLASSIC ', 'ΑΝΑΛΥΤΙΚΗ ΣΥΝΘΕΣΗ\r\nΕΠΕΞΕΡΓΑΣΤΗΣ - CPU		CPU INTEL CORE I5-6400 2.70GHZ LGA1151 - BOX\r\nΣΚΛΗΡΟΣ ΔΙΣΚΟΣ		HDD SEAGATE ST1000DM003 1TB BARRACUDA 7200.14 SATA3\r\nΜΝΗΜΗ RAM		RAM KINGSTON KVR24N17S8/4 4GB DDR4 2400MHZ\r\nΚΑΡΤΑ ΓΡΑΦΙΚΩΝ		Integrated Intel HD Graphics\r\n', 'p12472.jpg'),
(12473, 21, 'LAPTOP ACER ASPIRE E', 'Το Acer Aspire, σειρά E, προσφέρει μια εξαιρετική εμπειρία πολλαπλών δυνατοτήτων, σε πολύ οικονομική τιμή. Η σταθερή του απόδοση, τα εργαλεία πολυμέσων και η εύκολη συνδεσιμότητα, κάνουν ευχάριστη την χρήση του υπολογιστή αυτού. Η πρακτική, αλλά και κομψή', 'no_img.jpg'),
(12474, 27, 'Diamond ii', 'Υπερδιπλο κρεβάτι σε αριστη κατασταση\r\n', 'p12474.jpg'),
(12475, 40, 'Τηλεόραση απο 40 ιντ', '', 'no_img.jpg'),
(12476, 35, 'Gaming Desktop PC', 'Ζητώ ισχυρό desktop pc που προορίζεται για gaming. Δεκτές όλες οι προσφορές αλλά θα προτιμηθεί το πιο ισχυρό. Είναι επιτακτική ανάγκη να παίξω το Fallout 4 σε full HD.', 'p12476.jpg'),
(12477, 28, 'Καφέ Καναπές', 'Προσφέρεται , είναι σε πολύ καλή κατάσταση. Εφόσον ολοκληρωθεί η ανταλλαγή δεν θα τον έχω πια ανάγκη.', 'p12477.jpg'),
(12478, 27, 'Μονό Κρεβάτι', 'Προσφέρεται , είναι σε πολύ καλή κατάσταση. Το μόνο ελάττωμα είναι πως τρίζει λίγο.', 'p12478.jpg'),
(12479, 21, 'LAPTOP ACER ASPIRE E', 'Το Acer Aspire, σειρά E, προσφέρει μια εξαιρετική εμπειρία πολλαπλών δυνατοτήτων, σε πολύ οικονομική τιμή. Η σταθερή του απόδοση, τα εργαλεία πολυμέσων και η εύκολη συνδεσιμότητα, κάνουν ευχάριστη την χρήση του υπολογιστή αυτού. Η πρακτική, αλλά και κομψή', 'no_img.jpg'),
(12480, 40, 'TV LG 32', 'TV LG 32LH510B 32\' LED HD READY', 'p12480.jpg'),
(12481, 5, 'εκτυπωτης', 'Μέγεθος Α3\nΤύπου inkjet', 'p12481.jpg'),
(12482, 18, 'Βιβλίο Προγραμματισμ', 'Ζητώ βιβλίο προγραμματισμού για μελέτη. Ιδανικά με ενδιαφέρουν γλώσσες όπως Java, PHP, Python όμως όλες οι προσφορές είναι επιθυμητές.', 'no_img.jpg'),
(12483, 9, ' Επεξεργαστη της   i', 'αρχιτεκτονικης i5\r\nsocket 1151', 'no_img.jpg'),
(12484, 8, 'ram huperx', '4gb ddr3', 'p12484.jpg'),
(12485, 52, 'ακουστικά THRUSTMAST', 'Μέγεθος Οδηγού (ηχείων) : 50 mm.\nΕύρος συχνότητας : 10 Hz-25 kHz .\nΠαθητική μόνωση θορύβου: -31 dB.\nσε αριστη κατασταση', 'p12485.jpg'),
(12486, 18, 'Βιβλίο Προγραμματισμ', 'Ζητώ βιβλίο προγραμματισμού για μελέτη. Ιδανικά με ενδιαφέρουν γλώσσες όπως Java, PHP, Python όμως όλες οι προσφορές είναι επιθυμητές.', 'no_img.jpg'),
(12487, 21, 'Laptop Dell Inspiron', 'Σε πολύ καλή κατάσταση με λειτουργικό Windows 10.', 'no_img.jpg'),
(12488, 16, 'Το όνομα του ρόδου', 'Σε πολύ καλή κατάσταση για τους επιλεκτικούς αναγνώστες.', 'p12488.jpg'),
(12489, 21, 'APPLE MACBOOK', 'πολυ ακριβο', 'p12489.jpg'),
(12490, 69, 'κιθαρα', 'μια κιθαρα οτι να ναι\nνα ξεφορτοθω το mac θελω', 'no_img.jpg'),
(12491, 72, 'Τρομπέτα', 'Κάνω τα πρώτα μου βήματα στην Jazz , και θέλω να γίνω τρομπετίστας. Δεν με ενδιαφέρει ιδιαίτερα να έχει ιδιαίτερα στοιχεία, απλά θέλω το όργανο. Δεν διαθέτω συγκεκριμένα προιόντα, παρακαλώ κάντε προσφορές με ό,τι θέλετε', 'p12491.jpg'),
(12492, 21, 'Apple MacBook Pro', 'Θα ήθελα ένα MacBook γιατί είμαι παράξενο παιδί', 'no_img.jpg'),
(12493, 69, 'Κιθάρα Alhambra 3F', 'Πολύ καλή κιθάρα για κάθε επίδοξο κιθαρίστα.', 'p12493.jpg'),
(12494, 18, 'Βιβλίο προγραμματισμ', '250 σελίδες, ελάχιστα χρησιμοποιημένο. Εξαιρετικό για αρχάριους.', 'no_img.jpg'),
(12495, 21, 'Laptop Dell', 'Διαθέτει διπύρηνο επεξεργαστή Intel Core i7 που πλαισιώνεται από 4 GB μνήμης DDR3, σκληρό δίσκο 128 GB, ενώ διαθέτει και αυτόνομη κάρτα γραφικών της AMD.', 'no_img.jpg'),
(12496, 62, 'Ο μικρος πριγκιπας', 'Κλασικο βιβλίο που χανεσε στις παιδικες σοθ αναμνησης', 'no_img.jpg'),
(12497, 27, 'Hμίδιπλο κρεβάτι', 'Όχι όμως καφέ χρώματος αλλα μαύρου.', 'no_img.jpg'),
(12498, 52, 'Behringer MS16', 'Διαθέτω τα ηχεία MS16 της Behringer, έχουν αγοραστεί πριν λίγους μήνες και είναι κατάλληλα για ημιεπαγγελματική μίξη ήχων. Τα δίνω επειδή τελικά ακούω μουσική απο το youtube με ακουστικά.', 'p12498.jpg'),
(12499, 23, 'Λάμπα Γραφείου', 'Για να μπορώ να διαβάζω με φώς.', 'p12499.jpg'),
(12500, 66, 'Χυτρα ταχύτητας TEFA', ' μου αρέσουν πολυ οι λαχανοντολμάδες', 'no_img.jpg'),
(12501, 66, '2 τηγανια αντικολιτί', '', 'p12501.jpg'),
(12502, 29, 'Αναπαυτική πολυθρόνα', 'Σχετικά καινούρια πολυθρόνα, με αναπαυτικό κάθισμα και μοντέρνο σχεδιασμό. ', 'p12502.jpg'),
(12503, 72, 'Απλή τρομπέτα', 'Είμαι επίδοξος τρομπετίστας και θα ήθελα να εξασκηθώ στην τρομποτική.', 'no_img.jpg'),
(12504, 8, 'Μνήμη RAM', 'Ζητείται μνήμη RAM 4GB Corsair, για να ολοκληρωθεί επιτέλους το μηχάνημα που στήνω τόσο καιρό. Θέλω να είναι σφραγισμένη από το κουτί.', 'p12504.jpg'),
(12505, 29, 'Πολυθρόνα σαλονιού', 'Σε πολύ καλη κατάσταση , μαύρου χρώματος.', 'p12505.jpg'),
(12506, 72, 'Τρομπέτα για αρχάριο', 'Με αυτή την τρομπέτα, θα γίνεις μεγάλος και τρανός φίλε μου.', 'no_img.jpg'),
(12507, 79, 'Code T-Shirt', 'Προσφέρω μπλουζάκι με λογοπαίγνιο για προγραμματιστές, που αγόρασα όταν ήθελα κι εγώ να μάθω java. Στην πορεία κατάλαβα πως ...δεν θέλω πια να ξαναδώ κώδικα στη ζωή μου - και ούτε το μπλουζάκι αυτό.', 'p12507.jpg'),
(12508, 17, 'Ποιητική Συλλογή', 'Πλέον με ενδιαφέρει εντόνως η ποίηση, και ψάχνω ποιητικές συλλογές για να απαγγείλω στις ποιητικές βραδιές που παίρνω μέρος κάθε Παρασκευή.', 'no_img.jpg'),
(12509, 71, 'Σαξόφωνο', 'Ήμουν στα νιάτα μου μεγάλος σαξοφωνιάς, αλλά κουράστηκα πλέον.', 'p12509.jpg'),
(12510, 64, 'Τετράδιο μπλέ', 'Θα ήθελα ένα τετράδιο για να γράψω τις καλλιτεχνικές μου ανησυχίες.', 'no_img.jpg'),
(12511, 23, 'Λάμπα γραφείου', 'Μια λάμπα για να μπορώ να γράφω στο τετράδιο μου.', 'no_img.jpg'),
(12512, 75, '1/2 κιλό λάχανο', 'Φρεσκότατα λαχανάκια ιδανικά για σαλάτες! Είναι δικής μου παραγωγής από το μποστάνι του σπιτιού μου.', 'p12512.jpg'),
(12513, 45, 'Φύλλα Α4', 'Για εκτυπώσεις.', 'no_img.jpg'),
(12514, 62, 'O παπουτσωμένος γάτο', 'Μια φορά κι έναν καιρό, ζούσε ένας μυλωνάς που είχε τρεις γιους. Ένας πανέξυπνος παπουτσωμένος γάτος, ένας μύλος, τρία φλουριά, σε ένα μαγευτικό παραμύθι που μεγάλωσε γενιές και γενιές.', 'p12514.jpg'),
(12515, 23, 'Λάμπα Γραφείου', 'Ιδανική για διάβασμα , χρώματος ασημί ταιριάζει με κάθε γραφείο.', 'p12515.jpg'),
(12516, 51, 'GeForce GT710', 'Ταχύτητα Επεξεργαστή: 954 MHz, Ταχύτητα Μνήμης: 1600 MHz, Memory Bus: 64 bit. Μέγιστη Ανάλυση: 4096x2160 pixels, Interface: PCI Express x16 2.0 , Κατασκευαστής: MSI. Ιδανική για....τίποτα.', 'p12516.jpg'),
(12517, 62, 'Παιδικό βιβλίο', 'Για να διαβάζω στα παιδιά μου και να κοιμούνται ήσυχα το βράδυ.', 'no_img.jpg'),
(12518, 6, 'Κάρτα Μνήμης 32 GB', 'Χωρητικότητα: 32 GB, Τύπος Κάρτας: microSDHC, Speed Class: 10, Ταχύτητα Ανάγνωσης: 80 MB/s', 'p12518.jpg'),
(12519, 45, 'Φύλλα Α4', 'Φύλλα Α4 για τα λάχανα σας.', 'no_img.jpg'),
(12520, 45, 'Α4 Overlap', 'Πακέτο 50 φύλλων από την Overlap.', 'p12520.jpg'),
(12521, 62, 'Lucky Luke', 'Είναι φτωχός και μόνο cowboy.', 'p12521.jpg');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `trades`
--

CREATE TABLE `trades` (
  `ad_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Άδειασμα δεδομένων του πίνακα `trades`
--

INSERT INTO `trades` (`ad_id`, `product_id`) VALUES
(215, 12468),
(216, 12470),
(216, 12471),
(217, 12473),
(218, 12475),
(219, 12477),
(219, 12478),
(220, 12481),
(221, 12482),
(222, 12484),
(222, 12485),
(224, 12490),
(226, 12493),
(227, 12499),
(228, 12501),
(229, 12503),
(230, 12505),
(231, 12508),
(232, 12510),
(232, 12511),
(233, 12513),
(236, 12517);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `u_id` int(4) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `sname` varchar(20) NOT NULL,
  `address` varchar(30) NOT NULL,
  `zipcode` int(5) NOT NULL,
  `city` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`u_id`, `username`, `password`, `email`, `fname`, `sname`, `address`, `zipcode`, `city`, `status`) VALUES
(1, 'teo', '123', 'teo@teiath.gr', 'Theofilos', 'Axiotis', 'Peristeri', 11221, 'Athens', 1),
(2, 'ioulios', '1234', 'ioulios321@hotmail.com', 'ioulios', 'ioulios', 'ioulios', 0, 'ioulios', 1),
(3, 'ioan', 'ioan', 'ioannis@teiath.gr', 'Ioannis', 'Kyritsis', 'Stamou', 23124, 'Anthoupoli', 1),
(7, 'dim', 'dim', 'dim@teiath.gr', 'Dimitris', 'Rakopoulos', 'Sepolia', 12345, 'Athina', 1),
(8, 'alex', 'alex', 'alex@gmail.com', 'Alex', 'Bogdanovic', 'Anoi3i', 54326, 'Athina', 1);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Ευρετήρια για πίνακα `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Ευρετήρια για πίνακα `interests`
--
ALTER TABLE `interests`
  ADD PRIMARY KEY (`interest_id`),
  ADD UNIQUE KEY `interest_id` (`interest_id`),
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ad2_id` (`ad2_id`);

--
-- Ευρετήρια για πίνακα `interest_trades`
--
ALTER TABLE `interest_trades`
  ADD PRIMARY KEY (`interest_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Ευρετήρια για πίνακα `match_logs`
--
ALTER TABLE `match_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `ad_id` (`ad_id`),
  ADD KEY `ad_id2` (`ad_id2`),
  ADD KEY `interest_id` (`interest_id`);

--
-- Ευρετήρια για πίνακα `moderators`
--
ALTER TABLE `moderators`
  ADD PRIMARY KEY (`m_id`);

--
-- Ευρετήρια για πίνακα `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Ευρετήρια για πίνακα `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`ad_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT για πίνακα `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT για πίνακα `interests`
--
ALTER TABLE `interests`
  MODIFY `interest_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT για πίνακα `interest_trades`
--
ALTER TABLE `interest_trades`
  MODIFY `interest_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT για πίνακα `match_logs`
--
ALTER TABLE `match_logs`
  MODIFY `log_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT για πίνακα `moderators`
--
ALTER TABLE `moderators`
  MODIFY `m_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT για πίνακα `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12522;
--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Περιορισμοί για άχρηστους πίνακες
--

--
-- Περιορισμοί για πίνακα `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`),
  ADD CONSTRAINT `ads_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Περιορισμοί για πίνακα `interests`
--
ALTER TABLE `interests`
  ADD CONSTRAINT `interests_ibfk_3` FOREIGN KEY (`ad2_id`) REFERENCES `ads` (`ad_id`),
  ADD CONSTRAINT `interests_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`),
  ADD CONSTRAINT `interests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`u_id`);

--
-- Περιορισμοί για πίνακα `interest_trades`
--
ALTER TABLE `interest_trades`
  ADD CONSTRAINT `interest_trades_ibfk_3` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`interest_id`),
  ADD CONSTRAINT `interest_trades_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Περιορισμοί για πίνακα `match_logs`
--
ALTER TABLE `match_logs`
  ADD CONSTRAINT `match_logs_ibfk_3` FOREIGN KEY (`interest_id`) REFERENCES `interest_trades` (`interest_id`),
  ADD CONSTRAINT `match_logs_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`),
  ADD CONSTRAINT `match_logs_ibfk_2` FOREIGN KEY (`ad_id2`) REFERENCES `ads` (`ad_id`);

--
-- Περιορισμοί για πίνακα `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Περιορισμοί για πίνακα `trades`
--
ALTER TABLE `trades`
  ADD CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`ad_id`) REFERENCES `ads` (`ad_id`),
  ADD CONSTRAINT `trades_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

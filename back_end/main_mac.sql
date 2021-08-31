-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2021 at 09:38 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `main_mac`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `benfits`
--

CREATE TABLE `benfits` (
  `benfit_id` int(11) NOT NULL,
  `description` varchar(225) NOT NULL,
  `benfit_image` varchar(225) NOT NULL,
  `benfit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `benfits`
--

INSERT INTO `benfits` (`benfit_id`, `description`, `benfit_image`, `benfit_date`) VALUES
(6, 'كن ذا أثر طيب', '49105_1.jpg', '2021-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` text NOT NULL,
  `ordering` int(11) DEFAULT 0,
  `parent` int(11) NOT NULL,
  `Visibility` tinyint(4) NOT NULL,
  `Allow_Comment` tinyint(4) NOT NULL,
  `Allow_Ads` tinyint(4) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`, `ordering`, `parent`, `Visibility`, `Allow_Comment`, `Allow_Ads`, `image`) VALUES
(1, 'المجموعة الاولى-الصف الاول الثانوى', 'المجموعة الاولى-الصف الاول الثانوى-السبت والثلاثاء', 1, 0, 1, 0, 0, '8194_'),
(2, 'المجموعة الثانية-الصف الاول الثانوى', 'المجموعة الثانية-الصف الاول الثانوى-السبت والثلاثاء', 2, 0, 1, 0, 0, '24368_'),
(3, 'المجموعة الثالثة-الصف الاول الثانوى', 'المجموعة الثالثة-الصف الاول الثانوى-الاحد والاربعاء', 3, 0, 1, 0, 0, '39910_'),
(4, 'المجموعة الرابعة-الصف الاول الثانوى', 'المجموعة الرابعة-الصف الاول الثانوى-الاحد والاربعاء', 4, 0, 1, 0, 0, '65659_'),
(5, 'المجموعة الخامسة-الصف الاول الثانوى', 'المجموعة الخامسة-الصف الاول الثانوى-الاتنين و الخميس', 5, 0, 1, 0, 0, '63791_'),
(6, 'المجموعة السادسة-الصف الاول الثانوى', 'المجموعة السادسة-الصف الاول الثانوى-الاتنين و الخميس', 6, 0, 1, 0, 0, '54790_'),
(7, 'المجموعة الاولى-الصف الثانى الثانوى', 'المجموعة الاولى-الصف الثانى الثانوى-السبت والثلاثاء', 1, 0, 1, 0, 0, '8194_'),
(8, 'المجموعة الثانية-الصف الثانى الثانوى', 'المجموعة الثانية-الصف الثانى الثانوى-السبت والثلاثاء', 2, 0, 1, 0, 0, '24368_'),
(9, 'المجموعة الثالثة-الصف الثانى الثانوى', 'المجموعة الثالثة-الصف الثانى الثانوى-الاحد والاربعاء', 3, 0, 1, 0, 0, '39910_'),
(10, 'المجموعة الرابعة-الصف الثانى الثانوى', 'المجموعة الرابعة-الصف الثانى الثانوى-الاحد والاربعاء', 4, 0, 1, 0, 0, '65659_'),
(11, 'المجموعة الخامسة-الصف الثانى الثانوى', 'المجموعة الخامسة-الصف الثانى الثانوى-الاتنين و الخميس', 5, 0, 1, 0, 0, '63791_'),
(12, 'المجموعة السادسة-الصف الثانى الثانوى', 'المجموعة السادسة-الصف الثانى الثانوى-الاتنين و الخميس', 6, 0, 1, 0, 0, '54790_'),
(13, 'المجموعة الاولى-الصف الثالث الثانوى', 'المجموعة الاولى-الصف الثالث الثانوى-السبت والثلاثاء', 1, 0, 1, 0, 0, '8194_'),
(14, 'المجموعة الثانية-الصف الثالث الثانوى', 'المجموعة الثانية-الصف الثالث الثانوى-السبت والثلاثاء', 2, 0, 1, 0, 0, '24368_'),
(15, 'المجموعة الثالثة-الصف الثالث الثانوى', 'المجموعة الثالثة-الصف الثالث الثانوى-الاحد والاربعاء', 3, 0, 1, 0, 0, '39910_'),
(16, 'المجموعة الرابعة-الصف الثالث الثانوى', 'المجموعة الرابعة-الصف الثالث الثانوى-الاحد والاربعاء', 4, 0, 1, 0, 0, '65659_'),
(17, 'المجموعة الخامسة-الصف الثالث الثانوى', 'المجموعة الخامسة-الصف الثالث الثانوى-الاتنين و الخميس', 5, 0, 1, 0, 0, '63791_'),
(18, 'المجموعة السادسة-الصف الثالث الثانوى', 'المجموعة السادسة-الصف الثالث الثانوى-الاتنين و الخميس', 6, 0, 1, 0, 0, '54790_'),
(37, 'الكلمات الشائعة ', 'الكلمات الفرنسية الشائعة فى اللغة \r\nككلمات الترحيب والتحيه', 1, 1, 1, 0, 0, '29089_The-number-of-words-in-the-French-language-1080x580.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_data` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `member_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `comment_data`, `status`, `member_id`, `post_id`, `lesson_id`, `message_id`) VALUES
(20, 'جميل جدا', '2021-04-10', 1, 241, 71, NULL, NULL),
(21, 'عظيم', '2021-04-10', 1, 241, 71, NULL, NULL),
(22, 'عظيم عظيم', '2021-04-10', 1, 241, 72, NULL, NULL),
(23, 'عظيم جدا', '2021-04-10', 1, 241, 69, NULL, NULL),
(24, 'ان شاء الله ', '2021-04-10', 1, 241, 70, NULL, NULL),
(25, 'ممتاز جدا', '2021-05-03', 0, 242, 71, NULL, NULL),
(26, 'رائع', '2021-05-03', 0, 242, 69, NULL, NULL),
(27, 'عظيم ', '2021-05-03', 0, 242, 71, NULL, NULL),
(28, 'رائع', '2021-05-03', 0, 242, 69, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `events_id` int(11) NOT NULL,
  `events_name` varchar(250) NOT NULL,
  `events_description` varchar(500) NOT NULL,
  `events_time` time NOT NULL,
  `events_date` date NOT NULL,
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`events_id`, `events_name`, `events_description`, `events_time`, `events_date`, `cat_id`) VALUES
(8, 'تسميع الكلمات للوحدة الأولى ', 'سيتم تسميع الكلمات الخاصة بالوحده الأولى كاملة ', '17:00:00', '2021-04-11', 1),
(9, 'امتحان شامل', 'امتحان شامل على الوحدة الأولى ', '17:00:00', '2021-04-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_name` varchar(255) NOT NULL,
  `exam_date` date NOT NULL,
  `categ_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `exam_desc` text DEFAULT NULL,
  `number` int(11) DEFAULT 10,
  `type` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_name`, `exam_date`, `categ_id`, `member_id`, `lesson_id`, `exam_desc`, `number`, `type`, `time`) VALUES
(35, 'Hyper Text Markup Language', '2021-04-14', 35, 1, 96, NULL, 5, 1, 50),
(36, 'Cascading style sheet', '2021-04-14', NULL, 1, NULL, NULL, 10, 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `lesson_name` varchar(255) NOT NULL,
  `lesson_description` text NOT NULL,
  `video` varchar(255) NOT NULL,
  `lesson_data` date NOT NULL,
  `member_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `video_name` varchar(225) DEFAULT NULL,
  `allow_comments` tinyint(4) NOT NULL DEFAULT 0,
  `Approve` tinyint(1) NOT NULL DEFAULT 0,
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `lesson_name`, `lesson_description`, `video`, `lesson_data`, `member_id`, `cat_id`, `video_name`, `allow_comments`, `Approve`, `pdf`) VALUES
(96, 'Hyper text markup language', 'لغة ترميز تستخدم في إنشاء وتصميم صفحات ومواقع الويب، وتعتبر هذه اللّغة من أقدم اللّغات وأوسعها استخداما في تصميم صفحات الويب.', 'https://www.youtube.com/watch?v=6QAELgirvjs&t=38s', '2021-04-14', 1, 35, NULL, 0, 1, 'https://drive.google.com/file/d/1-HrrNSFc-J1yI6wKUG93zGKZEnaXazMJ/view?usp=sharing'),
(97, 'Cascading style sheet', 'لغة تنسيق لصفحات الويب تهتم بشكل وتصميم المواقع، صممت خصيصا لعزل التنسيق عن محتوى المستند المكتوب وينطبق ذلك على الألوان والخطوط والصور والخلفيات التي تستخدم في الصفحات، بمرونة وسهولة تامة. هذه التقنية تعنى بالمظهر الكلي لصفحات مواقع الويب من ألوان وصور وغيره.', 'https://www.youtube.com/watch?v=X1ulCwyhCVM&t=11s', '2021-04-14', 1, 35, NULL, 0, 1, 'https://drive.google.com/file/d/1VfUlNLVPQJYbM_tegHu6ZKazov2pxZB6/view?usp=sharing'),
(98, 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'https://www.youtube.com/watch?v=X1ulCwyhCVM&t=11s', '2021-04-14', 1, 36, NULL, 0, 1, 'https://drive.google.com/file/d/1VfUlNLVPQJYbM_tegHu6ZKazov2pxZB6/view?usp=sharing'),
(99, 'Why do we use it?', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'https://www.youtube.com/watch?v=89VLfs-wpEY', '2021-04-14', 1, 36, NULL, 0, 1, 'https://drive.google.com/file/d/1-HrrNSFc-J1yI6wKUG93zGKZEnaXazMJ/view?usp=sharing'),
(100, 'كلمات التحية ', 'كلمات التحية  صباحا ومساء ', 'https://www.youtube.com/watch?v=BliDUlParaQ', '2021-05-03', 1, 37, NULL, 0, 1, 'https://drive.google.com/file/d/1VfUlNLVPQJYbM_tegHu6ZKazov2pxZB6/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_member`
--

CREATE TABLE `lesson_member` (
  `lesson_member_id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT 1,
  `last_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson_member`
--

INSERT INTO `lesson_member` (`lesson_member_id`, `lesson_id`, `member_id`, `date`, `cat_id`, `type`, `last_date`) VALUES
(17, 96, 241, '2021-04-14 02:52:13', 35, 2, '2021-04-14 02:52:25'),
(18, 96, 242, '2021-05-03 15:53:08', 35, 2, '2021-05-03 15:53:14'),
(19, 100, 241, '2021-05-03 17:49:06', 37, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `live`
--

CREATE TABLE `live` (
  `live_id` int(11) NOT NULL,
  `link` text DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `regstatus` int(11) NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `avatar` varchar(225) NOT NULL DEFAULT 'img.png',
  `lil` text DEFAULT NULL,
  `exam answer` int(11) DEFAULT NULL,
  `lil_data` date DEFAULT NULL,
  `phone` int(20) DEFAULT NULL,
  `only` int(11) NOT NULL DEFAULT 0,
  `mac` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`userid`, `username`, `password`, `email`, `fullname`, `groupid`, `regstatus`, `date`, `avatar`, `lil`, `exam answer`, `lil_data`, `phone`, `only`, `mac`) VALUES
(1, 'احمد الطارون', '601f1889667efaebb33b8c12572835da3f027f78', 'mastercode179@gmail.com', NULL, 6, 1, '2021-01-26', 'img.png', NULL, NULL, NULL, 1066343874, 1, 'b666ad8a2959ee6497bb1afeb5af69d946c407ab'),
(241, 'هبه عصام', '7c4a8d09ca3762af61e59520943dc26494f8941b', NULL, NULL, 1, 1, '2021-04-10', 'img.png', NULL, NULL, NULL, 123456789, 0, 'bc65f477bec8c9024dcf671154f473833ff4a868'),
(242, 'xxxxxx', '88a01c9334d7e1c806ecbbeacd5a9818999c6668', NULL, NULL, 1, 1, '2021-05-03', 'img.png', NULL, NULL, NULL, 123654789, 0, 'bc65f477bec8c9024dcf671154f473833ff4a868'),
(243, 'xyzxyz', '3ba9e19d487eb43539bd511afcd37b04b7f37754', NULL, NULL, 1, 0, '2021-05-03', 'img.png', NULL, NULL, NULL, 123654789, 0, 'bc65f477bec8c9024dcf671154f473833ff4a868'),
(244, 'xyzxyz2', '88a01c9334d7e1c806ecbbeacd5a9818999c6668', NULL, NULL, 1, 0, '2021-05-03', 'img.png', NULL, NULL, NULL, 1478523690, 0, 'bc65f477bec8c9024dcf671154f473833ff4a868');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message`, `user_id`, `date`, `username`, `email`) VALUES
(76, 'متى يكون الأمتحان القادم؟', 241, '2021-04-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `part`
--

CREATE TABLE `part` (
  `part_id` int(11) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_name` varchar(255) NOT NULL,
  `post_description` text NOT NULL,
  `post_image` varchar(255) NOT NULL,
  `post_data` date NOT NULL,
  `allow_comment` tinyint(4) NOT NULL DEFAULT 0,
  `users` int(11) NOT NULL,
  `tags` varchar(225) NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `post_name`, `post_description`, `post_image`, `post_data`, `allow_comment`, `users`, `tags`, `type`, `cat_id`) VALUES
(69, 'بداية العمل بالمنصة للترم الأول', 'تم بحمد الله وتوفيقه افتتاح المنصة للفصل الدراسى الأول', '64691_1.jpg', '2021-04-10', 0, 1, '', 0, 1),
(70, 'بدء العمل بالمنصة للفصل الدراسى التانى', 'تم بحمد الله وتوفيقة سيتم البدء بالعمل للفصل الدراسى التانى بعد غد ', '63137_1.jpg', '2021-04-10', 0, 1, '', 0, 1),
(71, 'Hyper Text Markup Language', 'لغة HTML هي لغة توصيفية لإنشاء صفحات الويب وتطبيقات الويب، وترمز إلى Hypertext Markup Language (أي لغة النص الفائق). تُستخدَم مع لغة CSS و JavaScript لإنشاء صفحات ويب تفاعلية.\r\n\r\nتستقبل متصفحات الويب مستندات HTML من خادم الويب أو من نظام الملفات وتعرضها، ووظيفة لغة HTML هي وصف بنية صفحات الويب هيكليًا.\r\n\r\nالعناصر في HTML هي اللبنة الأساسية لبناء مستندات HTML، إذ نستطيع عبرها إضافة الصور والكائنات التفاعلية مثل النماذج أو ملفات الفيديو والصوت؛ وتستطيع أيضًا إنشاء مستندات منظمة عبر استخدام وسوم للتصريح عن الفقرات والعناوين والروابط والاقتباسات والجداول وغيرها.', '79174_2.jpg', '2021-04-10', 0, 1, '', 1, NULL),
(72, 'CSS &#34;cascading style sheet&#34;', 'هي لغة تنسيق لصفحات الويب تهتم بشكل وتصميم المواقع، صممت خصيصا لعزل التنسيق عن محتوى المستند المكتوب وينطبق ذلك على الألوان والخطوط والصور والخلفيات التي تستخدم في الصفحات، بمرونة وسهولة تامة. هذه التقنية تعنى بالمظهر الكلي لصفحات مواقع الويب من ألوان وصور وغيره', '82469_1.jpg', '2021-04-10', 0, 1, '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `ques` text NOT NULL,
  `added_date` date NOT NULL,
  `answer_1` text NOT NULL,
  `answer_2` text NOT NULL,
  `answer_3` text NOT NULL,
  `answer_4` text NOT NULL,
  `right_answer` varchar(255) NOT NULL,
  `photo` varchar(225) NOT NULL,
  `answer` text DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `username` varchar(225) CHARACTER SET utf8 NOT NULL,
  `token` varchar(225) CHARACTER SET utf8 NOT NULL,
  `timemodified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `username`, `token`, `timemodified`) VALUES
(1, 'رضا مختار', 'AZqBon3ez4', '2021-01-07 07:37:11'),
(2, 'heba essam', '9EGgWNQayK', '2021-01-23 09:59:25'),
(3, 'احمد الطارونygjgjy', 'aBHwp2IrS5', '2021-01-31 14:29:42'),
(4, 'احمد الطارونiunjighj', 'Q7n9JGnDLs', '2021-01-31 17:46:18'),
(5, 'احمد الطارونhdfgrsvdfaed', '8XvXEGEHe6', '2021-02-04 07:44:34'),
(6, 'احمد الطارونugjyhfgdf', 'BsKJwJC4jI', '2021-02-05 07:40:26'),
(7, 'احمد الطارونhvbjhk', 'WtaRFdnbTf', '2021-02-05 15:43:16'),
(8, 'احمد الطاروsfvdacsن', '9meTLpfzJG', '2021-02-05 16:22:00'),
(9, 'احمد الطارونhftg', 'dBNVE5Aaei', '2021-02-07 07:37:40'),
(10, 'هبه عصام', '4OKO5lcTUg', '2021-04-10 15:57:31'),
(11, 'xxxxxx', 'tVXLBoDTXq', '2021-05-03 12:50:48'),
(12, 'xyzxyz', 'fCt5zOfFy4', '2021-05-03 13:22:25'),
(13, 'xyzxyz2', 'nxd5tZv46T', '2021-05-03 13:27:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `exam` (`exam_id`);

--
-- Indexes for table `benfits`
--
ALTER TABLE `benfits`
  ADD PRIMARY KEY (`benfit_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comments` (`member_id`),
  ADD KEY `com` (`lesson_id`),
  ADD KEY `memb` (`post_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`events_id`),
  ADD KEY `cata` (`cat_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `lesson_member`
--
ALTER TABLE `lesson_member`
  ADD PRIMARY KEY (`lesson_member_id`),
  ADD KEY `lesson_id` (`lesson_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `live`
--
ALTER TABLE `live`
  ADD PRIMARY KEY (`live_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_message` (`user_id`);

--
-- Indexes for table `part`
--
ALTER TABLE `part`
  ADD PRIMARY KEY (`part_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_name` (`users`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ques` (`exam_id`),
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `benfits`
--
ALTER TABLE `benfits`
  MODIFY `benfit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `lesson_member`
--
ALTER TABLE `lesson_member`
  MODIFY `lesson_member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `live`
--
ALTER TABLE `live`
  MODIFY `live_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `part`
--
ALTER TABLE `part`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `exam` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `members` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `com` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments` FOREIGN KEY (`member_id`) REFERENCES `members` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memb` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `cata` FOREIGN KEY (`cat_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `lesson_member`
--
ALTER TABLE `lesson_member`
  ADD CONSTRAINT `lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_id` FOREIGN KEY (`member_id`) REFERENCES `members` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `user_message` FOREIGN KEY (`user_id`) REFERENCES `members` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `part`
--
ALTER TABLE `part`
  ADD CONSTRAINT `exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_name` FOREIGN KEY (`users`) REFERENCES `members` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `part_id` FOREIGN KEY (`part_id`) REFERENCES `part` (`part_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ques` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

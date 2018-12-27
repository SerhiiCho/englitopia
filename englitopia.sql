-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Дек 27 2018 г., 14:29
-- Версия сервера: 5.7.24
-- Версия PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `englitopia`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blockedusers`
--

CREATE TABLE `blockedusers` (
  `id` int(11) NOT NULL,
  `blocker` varchar(50) NOT NULL,
  `blockee` varchar(50) NOT NULL,
  `block_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `id_1` int(11) NOT NULL,
  `id_2` int(11) NOT NULL,
  `date_chat` datetime NOT NULL,
  `delete_chat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `chat`
--

INSERT INTO `chat` (`id`, `id_1`, `id_2`, `date_chat`, `delete_chat`) VALUES
(1, 2, 1, '2018-12-27 14:28:20', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `favoritepod`
--

CREATE TABLE `favoritepod` (
  `id` int(11) NOT NULL,
  `id_pod` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `favoritestory`
--

CREATE TABLE `favoritestory` (
  `id` int(11) NOT NULL,
  `id_story` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user1` varchar(50) NOT NULL,
  `user2` varchar(50) NOT NULL,
  `accepted` int(2) NOT NULL,
  `friendship_date` datetime NOT NULL,
  `who_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `friends`
--

INSERT INTO `friends` (`id`, `user1`, `user2`, `accepted`, `friendship_date`, `who_sent`) VALUES
(1, 'admin', 'foo', 1, '2018-12-27 13:55:06', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `info`
--

INSERT INTO `info` (`id`, `subject`, `content`, `tags`, `views`, `date`) VALUES
(1, 'About us', '<h3>English as a driver of change</h3>\r\n\r\n<p>Welcome to Englitopia! A community for people who study English and want to improve their ability more understand English language without any payments and wasting time watching boring advertising. We believe that our podcasts Will help you to improve your listening skills and also start speaking. Nothing improves reading better than reading Englitopia\'s stories, especially when you very attentive and have a desire to study it.</p>\r\n\r\n\r\n<h3>We believe</h3>\r\n\r\n<p>We believe we can be the best English community on the internet, it is possible only with you. Nowadays English \r\nshould be free on the internet, and advertising should not distract you while you are learning a language.</p>\r\n\r\n<p>This is the very onset of our community, we need so much to do. If you have a suggestion \r\nclick <a href=\"contact.php\">contact us</a>, make our world a little bit nicer with your ideas :) Our main purpose is \r\nto provide you with content that can improve your English level by different ways. All we want is your persistence and dedication to the whole process called \"learning\".</p>\r\n\r\n<h3>Thank you guys</h3>\r\n\r\n<p>Big thanks <a href=\"http://fontawesome.io/\">Font Awesome</a> for their awesome icons that we use on some our pages. Thank you <a href=\"https://pixabay.com/\">Pixabay</a> for your incredible people who give us so beautiful photos for free use. We really appreciate every free service on the internet that helps thousands of people from different parts of the world without asking for money and huge advertising banners which covers half of the website.</p>', 'Englitopia, thanks, improve, welcome', 108, '2017-11-25 19:50:35'),
(2, 'Privacy Policy', '<ol>\n\n    <li>\n        <h3 style=\"text-align:left;\">General</h3>\n        \n        <p>This privacy policy has been compiled to better serve those who are concerned with how their \"Personally Identifiable Information\" (PII) is being used online. PII, as described in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">What personal information do we collect from the people that visit our website</h3>\n        \n        <p>When ordering or registering on our site, as appropriate, you may be asked to enter your email address or other details to help you with your experience.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">When do we collect information?</h3>\n        \n        <p>We collect information from you when you register on our site, fill out a form or enter information on our site.</p>\n        \n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">How do we use your information?</h3>\n        \n        <p>We may use the information we collect from you when you register, make a purchase, sign up for our newsletter, respond to a survey or marketing communication, surf the website, or use certain other site features in the following ways:</p>\n        <ul>\n            <li>To improve our website in order to better serve you.</li>\n            \n        </ul>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">How do we protect your information?</h3>\n        \n        <p>We do not use vulnerability scanning or scanning to PCI standards.\n            <br>\n            We only provide articles and information. We never ask for credit card numbers.<br>\n            We do not use Malware Scanning.</p>\n            \n        <p>Your personal information is contained behind secured networks and is only accessible by a limited number of persons who have special access rights to such systems, and are required to keep the information confidential. In addition, all sensitive information you supply is encrypted via Secure Socket Layer (SSL) technology.</p>\n        \n        <p>We implement a variety of security measures when a user enters, submits, or accesses their information to maintain the safety of your personal information.</p>\n        \n        <p>All transactions are processed through a gateway provider and are not stored or processed on our servers.</p>\n    </li>\n    \n    \n    <li>\n        <h3 style=\"text-align:left;\">Do we use \"cookies\"?</h3>\n        \n        <p>We do not use cookies for tracking purposes. But we may use it in future.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">Third-party disclosure</h3>\n        \n        <p>We do not sell, trade, or otherwise transfer to outside parties your Personally Identifiable Information.</p>\n    </li>\n    \n\n    <li>\n        <h3 style=\"text-align:left;\">Third-party links</h3>\n        \n        <p>Occasionally, at our discretion, we may include or offer third-party products or services on our website. These third-party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>\n    </li>\n\n    <li>\n        <h3 style=\"text-align:left;\">Google</h3>\n        \n        <p>We have not enabled Google AdSense on our website, and we are not going to do it in future.</p>\n    </li>\n\n    <li>\n        <h3 style=\"text-align:left;\">California Online Privacy Protection Act</h3>\n        \n        <p>CalOPPA is the first state law in the nation to require commercial websites and online services to post a privacy policy. The law\'s reach stretches well beyond California to require any person or company in the United States (and conceivably the world) that operates websites collecting Personally Identifiable Information from California consumers to post a conspicuous privacy policy on its website stating exactly the information being collected and those individuals or companies with whom it is being shared. - See more at: http://consumercal.org/california-online-privacy-protection-act-caloppa/#sthash.0FdRbT51.dpuf</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">According to CalOPPA, we agree to the following:</h3>\n        \n        <p>Users can visit our site anonymously.<br>\n            Once this privacy policy is created, we will add a link to it on our Home Page on the bottom of our website.</p>\n          <p>Our Privacy Policy link includes the word \"Privacy\" and can easily be found on the page specified above.</p>\n            \n        <p>You will be notified of any Privacy Policy changes on our Privacy Policy Page.</p>\n        \n        <p>You cannot change your personal username or email adress after the registration, but you will be able to do it in future.</p>\n    </li>\n\n    <li>\n        <h3 style=\"text-align:left;\">How does our site handle Do Not Track signals?</h3>\n        \n        <p>We honor Do Not Track signals and Do Not Track, plant cookies, or use advertising when a Do Not Track (DNT) browser mechanism is in place.</p>\n    </li>\n\n    <li>\n        <h3 style=\"text-align:left;\">Does our site allow third-party behavioral tracking?</h3>\n        \n        <p>It\'s also important to note that we do not allow third-party behavioral tracking.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">COPPA (Children Online Privacy Protection Act)</h3>\n\n        <p>When it comes to the collection of personal information from children under the age of 13 years old, the Children\'s Online Privacy Protection Act (COPPA) puts parents in control. The Federal Trade Commission, United States\' consumer protection agency, enforces the COPPA Rule, which spells out what operators of websites and online services must do to protect children\'s privacy and safety online.</p>\n        \n        <p>We do not specifically market to children under the age of 13 years old.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">Fair Information Practices</h3>\n\n        <p>The Fair Information Practices Principles form the backbone of privacy law in the United States and the concepts they include have played a significant role in the development of data protection laws around the globe. Understanding the Fair Information Practice Principles and how they should be implemented is critical to comply with the various privacy laws that protect personal information.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">In order to be in line with Fair Information Practices we will take the following responsive action, should a data breach occur:</h3>\n\n        <p>We will notify you via email within 7 business days.</p>\n    </li>\n    \n    <li>\n        <h3 style=\"text-align:left;\">CAN SPAM Act</h3>\n\n        <p>The CAN-SPAM Act is a law that sets the rules for commercial email, establishes requirements for commercial messages, gives recipients the right to have emails stopped from being sent to them, and spells out tough penalties for violations.</p>\n\n        <h4>We collect your email address in order to:</h4>\n        \n        <ul>\n            <li>Send information, respond to inquiries, and other imporrant requests.</li>\n        </ul>\n        \n        <h4>To be in accordance with CANSPAM, we agree to the following:</h4>\n           \n        <ul>\n            <li>Not use false or misleading subjects or email addresses.</li>\n            <li>Identify the message as an advertisement in some reasonable way.</li>\n            <li>Include the physical address of our business or site headquarters.</li>\n            <li>Allow users to unsubscribe by using the link at the bottom of each email.</li>\n        </ul>\n        \n        <h4>If at any time you would like to unsubscribe from receiving future emails, you can unsubscribe by using the link at the bottom of each email.</h4>\n        \n        <ul>\n            <li>Follow the instructions at the bottom of each email, and we will promptly remove you from ALL correspondence.</li>\n        </ul>\n    </li>\n    \n   <!-- <li>\n        <h3 style=\"text-align:left;\">Contacting Us</h3>\n\n     <p>If there are any questions regarding this privacy policy, you may contact us using the information below.</p>\n        \n        <p>\n            d95664yj.beget.tech\n            <br>\n            Kharkiv\n            <br>\n            Ukraine\n            <br>\n            \n        </p>-->\n    </li>\n</ol>', '', 36, '2017-09-30 19:40:35'),
(3, 'Terms and Conditions', '<h3>General</h3>\r\n	<p>The Englitopia community (“Website”) is operated by Englitopia, (\"Englitopia\", \"we\", \"us\" or \"our\"). Please read Terms and Conditions carefully before using our website. Access and use of the Service is subject to the following Terms and Conditions of Service (“Terms and Conditions”).</p>\r\n	<p>By accessing this website you accept these terms and conditions in full and become an Englitopia\'s member. Do not continue using Englitopia\'s website if you do not accept all of the terms and conditions stated on this page. If you do not agree to abide by these Terms and Conditions, you are not authorized to use, access or participate in the Service.</p>\r\n	<p>Agreements: \"Member”, “You” and “Your” refers to you, the person accessing this website and accepting the Englitopia’s terms and conditions. “Englitopia”, \"Our team\", “We”, \"Ourselves\", “Our” and “Us”, refers to Englitopia. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the member in the most appropriate manner, whether by formal meetings of a fixed duration, or any other means, for the express purpose of meeting the member’s needs in respect of provision of the Englitopia’s stated services, in accordance with and subject to, prevailing law. Any use of the above terminology or other words in the singular, plural, capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>\r\n   \r\n    <h3>Hyperlinking to our Content</h3>\r\n	<ol>\r\n		<li>The following organizations may link to our Web site without prior written approval:\r\n			<ol>\r\n                <li>Government agencies;</li>\r\n                <li>Search engines;</li>\r\n                <li>News organizations;</li>\r\n                <li>Online directory distributors when they list us in the directory may link to our Web site in the same manner as they hyperlink to the Web sites of other listed businesses;</li>\r\n                <li>Systemwide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>\r\n			</ol>\r\n		</li>\r\n	</ol>\r\n	\r\n	<ol start=\"2\">\r\n		<li>These organizations may link to our home page, to publications or to other Web site information so long as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship, endorsement or approval of the linking member and its products or services; and (c) fits within the context of the linking member\'s site.</li>\r\n		<li>We may consider and approve in our sole discretion other link requests from the following types of organizations:\r\n			<ol>\r\n				<li>commonly-known consumer and/or business information sources such as Chambers of Commerce, American Automobile Association, AARP and Consumers Union;</li>\r\n				<li>dot.com community sites;</li>\r\n				<li>associations or other groups representing charities, including charity giving sites,</li>\r\n				<li>online directory distributors;</li>\r\n				<li>internet portals;</li>\r\n				<li>accounting, law and consulting firms whose primary members are businesses; and</li>\r\n				<li>educational institutions and trade associations.</li>\r\n			</ol>\r\n		</li>\r\n	</ol>\r\n	\r\n	<p>We will approve link requests from these organizations if we determine that: (a) the link would not reflect unfavorably on us or our accredited businesses (for example, trade associations or other organizations representing inherently suspect types of business, such as work-at-home opportunities, shall not be allowed to link); (b)the organization does not have an unsatisfactory record with us; (c) the benefit to us from the visibility associated with the hyperlink outweighs the absence of Englitopia; and (d) where the link is in the context of general resource information or is otherwise consistent with editorial content in a newsletter or similar product furthering the mission of the organization.</p>\r\n	<p>These organizations may link to our home page, to publications or to other Web site information so long as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship, endorsement or approval of the linking member and it products or services; and (c) fits within the context of the linking member\'s site.</p>\r\n	<p>If you are among the organizations listed in paragraph 2 above and are interested in linking to our website, you must notify us by sending an e-mail to <a href=\"mailto:1990serzhil@gmail.com\" title=\"send an email to 1990serzhil@gmail.com\">1990serzhil@gmail.com</a>. Please include your name, your organization name, contact information (such as e-mail address) as well as the URL of your site, a list of any URLs from which you intend to link to our Web site, and a list of the URL(s) on our site to which you would like to link. Allow 2-3 weeks for a response.</p>\r\n	<p>Approved organizations may hyperlink to our Web site as follows:</p>\r\n\r\n	<ol>\r\n		<li>By use of our corporate name; or</li>\r\n		<li>By use of the uniform resource locator (Web address) being linked to; or</li>\r\n		<li>By use of any other description of our Web site or material being linked to that makes sense within the context and format of content on the linking member\'s site.</li>\r\n	</ol>\r\n	\r\n	<p>No use of Englitopia’s logo or other artwork will be allowed for linking absent a trademark license agreement.</p>\r\n	\r\n    <h3>Iframes</h3>\r\n	<p>Without prior approval and express written permission, you may not create frames around our Web pages or use other techniques that alter in any way the visual presentation or appearance of our Web site.</p>\r\n   \r\n    <h3>Reservation of Rights</h3>\r\n	<p>We reserve the right at any time and in its sole discretion to request that you remove all links or any particular link to our Web site. You agree to immediately remove all links to our Web site upon such request. We also reserve the right to amend these terms and conditions and its linking policy at any time. By continuing to link to our Web site, you agree to be bound to and abide by these linking terms and conditions.</p>\r\n	\r\n    <h3>Removal of links from our website</h3>\r\n	<p>If you find any link on our Web site or any linked web site objectionable for any reason, you may contact us about this. We will consider requests to remove links but will have no obligation to do so or to respond directly to you.</p>\r\n	<p>Whilst we endeavour to ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we commit to ensuring that the website remains available or that the material on the website is kept up to date.</p>\r\n	\r\n    <h3>Content Liability</h3>\r\n	<p>We shall have no responsibility or liability for any content appearing on your Web site. You agree to indemnify and defend us against all claims arising out of or based upon your Website. No link(s) may appear on any page on your Web site or within any context containing content or materials that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third member rights.</p>\r\n	\r\n    <h3>Disclaimer</h3>\r\n	<p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website (including, without limitation, any warranties implied by law in respect of satisfactory quality, fitness for purpose and/or the use of reasonable care and skill). Nothing in this disclaimer will:</p>\r\n	\r\n	<ol>\r\n        <li>limit or exclude our or your liability for death or personal injury resulting from negligence;</li>\r\n        <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>\r\n        <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>\r\n        <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>\r\n	</ol>\r\n\r\n	<p>The limitations and exclusions of liability set out in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer or in relation to the subject matter of this disclaimer, including liabilities arising in contract, in tort (including negligence) and for breach of statutory duty.</p>\r\n	<p>To the extent that the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>\r\n\r\n	<h3>Cookies</h3>\r\n	<p>We use cookies to help you stay online, and make the website more functional.</p>', '', 62, '2017-12-23 14:20:14');

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE `members` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `cookie_password` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reports` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `email`, `username`, `country`, `first`, `last`, `gender`, `active`, `status`, `about`, `date`, `cookie_password`, `password`, `reports`) VALUES
(1, 'admin@admin.com', 'admin', '', '', '', '', 1, 'member, writer, host,admin', '', '2018-12-27 13:17:48', '32630823440000', '$2y$10$m1/hrN7Gp9osrx2ajmcWouas8bQJbSwFpQLqjtCKZoSOVx./UWENC', 0),
(2, 'foo@bar.com', 'foo', '', '', '', '', 1, 'Member', '', '2018-12-27 13:53:14', '12622649460000', '$2y$10$dBXN/iPnD5q//yAaGIVACe5lidde6iTy0KBg0E6B9aecmMSq6Aip6', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `membersdata`
--

CREATE TABLE `membersdata` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `photo_status` int(11) UNSIGNED DEFAULT NULL,
  `photo_version` int(11) DEFAULT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `searching` text COLLATE utf8mb4_unicode_ci,
  `note_check` datetime DEFAULT NULL,
  `note_close` datetime DEFAULT NULL,
  `favorite_story` text COLLATE utf8mb4_unicode_ci,
  `favorite_pod` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `membersdata`
--

INSERT INTO `membersdata` (`id`, `user_id`, `photo_status`, `photo_version`, `ip`, `last_login`, `searching`, `note_check`, `note_close`, `favorite_story`, `favorite_pod`) VALUES
(1, 1, 0, 0, '127.0.0.1', '2018-12-27 14:29:46', '', '2018-12-27 13:53:44', '2018-12-27 13:17:48', NULL, NULL),
(2, 2, 1, 6, '127.0.0.1', '2018-12-27 14:29:10', '', '2018-12-27 13:55:17', '2018-12-27 13:53:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `id_from` int(11) NOT NULL,
  `id_to` int(11) NOT NULL,
  `message` text NOT NULL,
  `date_time` datetime NOT NULL,
  `have_read` varchar(3) NOT NULL DEFAULT '0',
  `id_chat` int(11) NOT NULL,
  `delete_messages` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `id_from`, `id_to`, `message`, `date_time`, `have_read`, `id_chat`, `delete_messages`) VALUES
(1, 2, 1, 'Hello world', '2018-12-27 14:26:15', '0', 1, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `notification` text NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '1',
  `link` varchar(255) NOT NULL DEFAULT '#',
  `active` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `pod`
--

CREATE TABLE `pod` (
  `id` int(11) NOT NULL,
  `subject` varchar(40) NOT NULL,
  `intro` varchar(207) NOT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `author` varchar(128) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `duration` varchar(10) NOT NULL,
  `approved` float NOT NULL DEFAULT '0',
  `approved_by` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pod`
--

INSERT INTO `pod` (`id`, `subject`, `intro`, `content`, `tags`, `views`, `author`, `date`, `duration`, `approved`, `approved_by`) VALUES
(1, 'Hello', 'When 8-year-old Cark Reimer and his 6-year-old sister Carla knock on the front door of their new neighbor’s house, hoping that they have children they can play with, they get something way better – wh', 'When 8-year-old Cark Reimer and his 6-year-old sister Carla knock on the front door of their new neighbor’s house, hoping that they have children they can play with, they get something way better – when the door is opened by a man wearing the scariest, coolest monster mask! It turns out their neighbor, Mr. Neewollah (spell it backwards…), creates monsters for a movie studio, and when he invites Cark, Carla, and their parents to join him for a movie shoot on the tropical island of Tahka Paka.', 'introduction, conversation, test, cat, lala', 20, 'Serhii Cho', '2017-09-29 18:59:00', '0:45:20', 2, 'admin, '),
(2, 'Test', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam optio nulla, quod vitae labore maiores accusamus! In quidem vitae.', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam optio nulla, quod vitae labore maiores accusamus! In quidem vitae, voluptatibus voluptate blanditiis nisi harum voluptatem alias tenetur possimus perferendis voluptatum. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Veniam optio nulla, quod vitae labore maiores accusamus! In quidem vitae, voluptatibus voluptate blanditiis nisi harum voluptatem alias tenetur possimus perferendis voluptatum.', 'test, dog, cat, bird', 61, 'Me and You', '2018-01-19 17:58:23', '00:05:50', 2, 'serhii, ');

-- --------------------------------------------------------

--
-- Структура таблицы `postoffice`
--

CREATE TABLE `postoffice` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `important` float NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `from_user` varchar(50) NOT NULL,
  `to_user` varchar(50) NOT NULL,
  `report_date` date NOT NULL,
  `report_time` time NOT NULL,
  `type` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `searchstat`
--

CREATE TABLE `searchstat` (
  `id` int(11) UNSIGNED NOT NULL,
  `words` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `times` int(11) UNSIGNED DEFAULT NULL,
  `last_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `subject` varchar(40) NOT NULL,
  `intro` varchar(207) NOT NULL,
  `content` text NOT NULL,
  `tags` text NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author` varchar(128) NOT NULL,
  `writer` varchar(60) NOT NULL,
  `approved` int(11) NOT NULL,
  `approved_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stories`
--

INSERT INTO `stories` (`id`, `subject`, `intro`, `content`, `tags`, `views`, `date`, `author`, `writer`, `approved`, `approved_by`) VALUES
(1, 'Test Subject', 'Theresa May has indicated that she is prepared to demote Boris Johnson in a reshuffle in a bid to reassert her authority over her warring Cabinet.', '<p>Theresa May has indicated that she is prepared to demote Boris Johnson in a reshuffle in a bid to reassert her authority over her warring Cabinet.\n\nThe Prime Minister has opened the door to a potential reshuffle later this month as part of a bid to ensure that she has \"the best people in my Cabinet\".</p>\n\n<p>As well as promoting a new generation of Tory MPs, Mrs May has signaled that she is willing to replace ministers who have shown disloyalty.\n\nMarked what she might do with the Foreign Secretary in a reshuffle, she told The Sunday Times: \"It has never been my style to hide from a challenge and I\'m not going to start now.\n\n\"I\'m the PM, and part of my job is to make sure I always have the best people in my cabinet, to make the most of the wealth of talent available to me in the party.\"</p>\n\n<p>Her comments will be viewed as a slapdown to Mr Johnson, whose activities overshadowed much of the Tory conference until Mrs May\'s ill-fated speech. Although to muddy the waters further, the Foreign Secretary issued a plea for warring party members to unite behind the Prime Minister in this morning\'s Sunday Telegraph.</p>\n\n<p>Elsewhere Sir John Major lashed out at \"disloyal\" Tory MPs and ministers as he urged them to back Theresa May - but suggested she must take radical action to win over voters by increasing public spending and reviewing controversial welfare changes.</p>\n\n<p>The ex-Tory leader, whose own premiership was marred by infighting and plotting, said he had viewed the turmoil in the Conservative Party with \"increasing dismay\".</p>\n\n<p>But alongside his appeal for unity, Sir John called for radical action on Mrs May\'s social justice agenda to \"win back hearts and minds\" or risk the prospect of \"neo-Marxist\" Jeremy Corbyn taking the keys to Number 10.</p>\n\n<p>Ruth Davidson said there had been some \"unfortunate shenanigans\" in the party \"but the pushback has been pretty strong\" against those trying to force a leadership contest. The Scottish Tory leader hit out at colleagues engaged in \"tittle-tattle\", adding that being a politician is \"about delivering for the country, it\'s not and should never be about private ambition\" - comments likely to be viewed as a swipe at Mr Johnson. Ms Davidson told BBC One\'s Andrew Marr Show the Foreign Secretary had backed Mrs May\'s Florence speech on Brexit and she should \"hold him to that\".</p>\n\n<p>\"He is a big intellect, a big figure in the party and if the Prime Minister believes he is the right person to be Foreign Secretary then she has my full support,\" she said.</p>', 'introduction, conversation, test, cat', 60, '2017-10-01 08:23:00', 'Author', '', 2, ''),
(2, 'Perfectionism', 'Perfectionism, in psychology, is a personality trait characterized by a person\'s striving for flawlessness and setting high performance standards, accompanied by critical self-evaluations and', '<p>Perfectionism, in psychology, is a personality trait characterized by a person\'s striving for flawlessness and setting high performance standards, accompanied by critical self-evaluations and concerns regarding others\' evaluations.It is best conceptualized as a multidimensional characteristic, as psychologists agree that there are many positive and negative aspects. In its maladaptive form, perfectionism drives people to attempt to achieve an unattainable ideal while their adaptive perfectionism can sometimes motivate them to reach their goals. In the end, they derive pleasure from doing so. When perfectionists do not reach their goals, they often fall into depression.</p>\n\n<p>Perfectionists strain compulsively and unceasingly toward unobtainable goals, and measure their self-worth by productivity and accomplishment.[4] Pressuring oneself to achieve unrealistic goals inevitably sets the person up for disappointment. Perfectionists tend to be harsh critics of themselves when they fail to meet their standards.</p>\n\n<h3>Normal vs. neurotic</h3>\n\n<p>D. E. Hamachek in 1978 argued for two contrasting types of perfectionism, classifying people as tending towards normal perfectionism or neurotic perfectionism. Normal perfectionists are more inclined to pursue perfection without compromising their self-esteem, and derive pleasure from their efforts. Neurotic perfectionists are prone to strive for unrealistic goals and feel dissatisfied when they cannot reach them. Hamachek offers several strategies that have proven useful in helping people change from maladaptive towards healthier behavior.Contemporary research supports the idea that these two basic aspects of perfectionistic behavior, as well as other dimensions such as \"nonperfectionism\", can be differentiated. They have been labeled differently, and are sometimes referred to as positive striving and maladaptive evaluation concerns, active and passive perfectionism, positive and negative perfectionism, and adaptive and maladaptive perfectionism. Although there is a general perfectionism that affects all realms of life, some researchers contend that levels of perfectionism are significantly different across different domains (i.e. work, academic, sport, interpersonal relationships, home life).\n\nOthers such as T. S. Greenspon disagree with the terminology of \"normal\" vs. \"neurotic\" perfectionism, and hold that perfectionists desire perfection and fear imperfection and feel that other people will like them only if they are perfect. For Greenspon, perfectionism itself is thus never seen as healthy or adaptive, and the terms \"normal\" or \"healthy\" perfectionism are misnomers, since absolute perfection is impossible. He argues that perfectionism should be distinguished from \"striving for excellence\", in particular with regard to the meaning given to mistakes. Those who strive for excellence can take mistakes (imperfections) as incentive to work harder. Unhealthy perfectionists consider their mistakes a sign of personal defects. For these people, anxiety about potential failure is the reason perfectionism is felt as a burden.</p>\n\n<h3>Multidimensional perfectionism scale</h3>\n\n<p><img src=\"img/content/Perfectionism.jpg\">Randy O. Frost et al. (1990) developed a multidimensional perfectionism scale (now known as the \"Frost Multidimensional Perfectionism Scale\", FMPS) with six dimensions: concern over making mistakes, high personal standards (striving for excellence), the perception of high parental expectations, the perception of high parental criticism, the doubting of the quality of one\'s actions, and a preference for order and organization.</p>\n\n<p>Hewitt & Flett (1991) devised another \"multidimensional perfectionism scale\", a 45-item measure that rates three aspects of perfectionistic self-presentation: self-oriented perfectionism, other-oriented perfectionism, and socially prescribed perfectionism. Self-oriented perfectionism is having unrealistic expectations and standards for oneself that lead to perfectionistic motivation. An example is the constant desire to achieve an ideal physical appearance out of vanity. Other-oriented perfectionism is having unrealistic expectations and standards for others that in turn pressure them to have perfectionistic motivations of their own. Socially prescribed perfectionism is developing perfectionistic motivations due to the fact that significant others expect them to be perfect. Parents that push their children to be successful in certain endeavors (such as athletics or academics) provide an example of this type of perfectionism, as the children feel that they must meet their parents\' lofty expectations.</p>\n\n<p<A similarity has been pointed out among Frost\'s distinction between setting high standards for oneself and the level of concern over making mistakes in performance (the two most important dimensions of the FMPS and Hewitt & Flett\'s distinction between self-oriented versus socially prescribed perfectionism.</p>\n\n<h3>Almost perfect scale-revised</h3>\n\n<p>Slaney and his colleagues (1996) developed the Almost Perfect Scale-Revised (APS-R) to identify perfectionists (adaptive or maladaptive) and non-perfectionists. People are classified based on their scores for High Standards, Order, and Discrepancy measures. Both adaptive and maladaptive perfectionists rate highly in High Standards and Order, but maladaptive perfectionists also rate highly in Discrepancy. Discrepancy refers to the belief that personal high standards are not being met, which is the defining negative aspect of perfectionism. Maladaptive perfectionists typically yield the highest social stress and anxiety scores, reflecting their feelings of inadequacy and low self-esteem. In general, the APS-R is a relatively easy instrument to administer, and can be used to identify perfectionist adolescents as well as adults, though it has yet to be proven useful for children.[6] Interestingly, in one study evaluating APS-R in an adolescent population, maladaptive perfectionists obtained higher satisfaction scores than non-perfectionists. This finding suggests that adolescents\' high standards may protect them from challenges to personal satisfaction when their standards are not met.Two other forms of the APS-R measure perfectionism directed towards intimate partners (Dyadic Almost Perfect Scale) and perceived perfectionism from one\'s family (Family Almost Perfect Scale).</p>', 'introduction, conversation, test, cat', 21, '2017-10-10 08:21:52', 'Some Dude', '', 2, '');

-- --------------------------------------------------------

--
-- Структура таблицы `visits`
--

CREATE TABLE `visits` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `week` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(11) UNSIGNED DEFAULT NULL,
  `value` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `visits`
--

INSERT INTO `visits` (`id`, `date`, `month`, `week`, `year`, `value`) VALUES
(1, '27.12.18', 'Dec', 'Thu', 2018, 2);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `blockedusers`
--
ALTER TABLE `blockedusers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favoritepod`
--
ALTER TABLE `favoritepod`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favoritestory`
--
ALTER TABLE `favoritestory`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `membersdata`
--
ALTER TABLE `membersdata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_membersdata_user` (`user_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pod`
--
ALTER TABLE `pod`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `postoffice`
--
ALTER TABLE `postoffice`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `searchstat`
--
ALTER TABLE `searchstat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `blockedusers`
--
ALTER TABLE `blockedusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `favoritepod`
--
ALTER TABLE `favoritepod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `favoritestory`
--
ALTER TABLE `favoritestory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `membersdata`
--
ALTER TABLE `membersdata`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `pod`
--
ALTER TABLE `pod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `postoffice`
--
ALTER TABLE `postoffice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `searchstat`
--
ALTER TABLE `searchstat`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

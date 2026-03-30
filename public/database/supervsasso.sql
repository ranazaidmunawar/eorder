-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2024 at 10:13 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supervsasso`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` int DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '0 - deactive, 1 - active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `username`, `email`, `first_name`, `last_name`, `image`, `password`, `status`, `created_at`, `updated_at`, `token`) VALUES
(1, NULL, 'admin', 'imranyeasin75@gmail.com', 'Justin', 'Langer', '5f6c395833e14.jpg', '$2y$10$1FJBRGpBFqs6bPtfcx.WKeNvX1n8fbPW/QLz8IiemvWqjzVQWmW7u', 1, NULL, '2023-12-18 14:42:51', 'noqvhqCitQmzv56XiwNYbwdx5mURP5admin'),
(10, 7, 'delivery', 'delivery@gmail.com', 'Delivery', 'Manager', '5f6c395833e14.jpg', '$2y$10$658kJ38abUEn.d46DmYhQ.wNIy9fRE2TPDrNzeMODbxDWHWOwrqRS', 1, '2020-09-24 00:14:48', '2020-09-28 11:24:32', NULL),
(11, 8, 'kitchen', 'kitchen@gmail.com', 'Kitchen', 'Manager', '60a934a18ff49.jpg', '$2y$10$PTTKwbg5AEHm4BBVUaes1uhlx1eZKeTJzD7M5pIQjPrDmGYaVzul2', 1, '2020-09-28 11:23:39', '2021-05-23 01:43:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backups`
--

CREATE TABLE `backups` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backups`
--

INSERT INTO `backups` (`id`, `filename`, `created_at`, `updated_at`) VALUES
(3, '2022-04-24-121935-dump-superv.sql', '2022-04-24 06:19:35', '2022-04-24 06:19:35');

-- --------------------------------------------------------

--
-- Table structure for table `basic_extendeds`
--

CREATE TABLE `basic_extendeds` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `cookie_alert_status` tinyint NOT NULL DEFAULT '1',
  `cookie_alert_text` blob,
  `cookie_alert_button_text` varchar(255) DEFAULT NULL,
  `to_mail` varchar(255) DEFAULT NULL,
  `default_language_direction` varchar(20) NOT NULL DEFAULT 'ltr' COMMENT 'ltr / rtl',
  `from_mail` varchar(255) DEFAULT NULL,
  `testimonial_img` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `is_smtp` tinyint NOT NULL DEFAULT '0',
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` varchar(30) DEFAULT NULL,
  `encryption` varchar(30) DEFAULT NULL,
  `smtp_username` varchar(255) DEFAULT NULL,
  `smtp_password` varchar(255) DEFAULT NULL,
  `base_currency_symbol` blob,
  `base_currency_symbol_position` varchar(10) NOT NULL DEFAULT 'left',
  `base_currency_text` varchar(100) DEFAULT NULL,
  `base_currency_text_position` varchar(10) NOT NULL DEFAULT 'right',
  `base_currency_rate` decimal(8,2) NOT NULL DEFAULT '0.00',
  `hero_section_title` varchar(255) DEFAULT NULL,
  `hero_section_text` varchar(255) DEFAULT NULL,
  `hero_section_button_text` varchar(30) DEFAULT NULL,
  `hero_section_button_url` text,
  `hero_section_video_url` text,
  `hero_img` varchar(50) DEFAULT NULL,
  `timezone` text,
  `contact_addresses` text,
  `contact_numbers` text,
  `contact_mails` text,
  `is_whatsapp` tinyint NOT NULL DEFAULT '1',
  `whatsapp_number` varchar(50) DEFAULT NULL,
  `whatsapp_header_title` varchar(255) DEFAULT NULL,
  `whatsapp_popup_message` text,
  `whatsapp_popup` tinyint NOT NULL DEFAULT '1',
  `domain_request_success_message` varchar(255) DEFAULT NULL,
  `cname_record_section_title` varchar(255) DEFAULT NULL,
  `cname_record_section_text` text,
  `package_features` text,
  `expiration_reminder` int NOT NULL DEFAULT '3',
  `max_video_size` decimal(11,2) NOT NULL DEFAULT '20.00',
  `max_file_size` decimal(11,2) NOT NULL DEFAULT '10.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `basic_extendeds`
--

INSERT INTO `basic_extendeds` (`id`, `language_id`, `cookie_alert_status`, `cookie_alert_text`, `cookie_alert_button_text`, `to_mail`, `default_language_direction`, `from_mail`, `testimonial_img`, `from_name`, `is_smtp`, `smtp_host`, `smtp_port`, `encryption`, `smtp_username`, `smtp_password`, `base_currency_symbol`, `base_currency_symbol_position`, `base_currency_text`, `base_currency_text_position`, `base_currency_rate`, `hero_section_title`, `hero_section_text`, `hero_section_button_text`, `hero_section_button_url`, `hero_section_video_url`, `hero_img`, `timezone`, `contact_addresses`, `contact_numbers`, `contact_mails`, `is_whatsapp`, `whatsapp_number`, `whatsapp_header_title`, `whatsapp_popup_message`, `whatsapp_popup`, `domain_request_success_message`, `cname_record_section_title`, `cname_record_section_text`, `package_features`, `expiration_reminder`, `max_video_size`, `max_file_size`) VALUES
(147, 176, 1, 0x596f757220657870657269656e6365206f6e207468697320736974652077696c6c20626520696d70726f76656420627920616c6c6f77696e6720636f6f6b6965732e, 'Allow Cookies', 'pratik.anwar@gmail.com', 'ltr', 'geniustest11@gmail.com', '80529e986bb50427e6e899a33099ca88c531dbd1.png', 'Supervsasso', 1, 'smtp.gmail.com', '587', 'TLS', 'geniustest11@gmail.com', 'jvpdiafcjhrznkbm', 0x24, 'left', 'USD', 'right', 1.00, 'Our Platform, Your Success', 'Build Your Own Restaurant Website', 'Explore Plans', 'https://coursmat.xyz/pricing', 'https://www.youtube.com/watch?v=6stlCkUDG_s', 'ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg', 'America/Shiprock', 'California, USA\r\nLondon, United Kingdom\r\nMelbourne, Australia', '+8434197502,+2350575099,+23576039607', 'contact@example.com,support@example.com,query@example.com', 1, NULL, NULL, NULL, 1, 'We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.', 'Read Before Sending Custom Domain Request', '<ul><li><font color=\"#575962\"><span style=\"font-weight:600;\"> Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).</span></font></li><li><font color=\"#575962\"><span style=\"font-weight:600;\"> CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain</span></font></li><li><font color=\"#575962\"><span style=\"font-weight:600;\"> Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain</span></font></li></ul>', '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\"]', 4, 40.00, 5.00),
(148, 177, 1, 0xd8b3d98ad8aad98520d8aad8add8b3d98ad98620d8aad8acd8b1d8a8d8aad98320d8b9d984d98920d987d8b0d8a720d8a7d984d985d988d982d8b920d985d98620d8aed984d8a7d98420d8a7d984d8b3d985d8a7d8ad20d8a8d985d984d981d8a7d8aa20d8aad8b9d8b1d98ad98120d8a7d984d8a7d8b1d8aad8a8d8a7d8b7, 'السماح للكوكيز', 'pratik.anwar@gmail.com', 'ltr', 'geniustest11@gmail.com', '80529e986bb50427e6e899a33099ca88c531dbd1.png', 'Supervsasso', 1, 'smtp.gmail.com', '587', 'TLS', 'geniustest11@gmail.com', 'jvpdiafcjhrznkbm', 0x24, 'left', 'USD', 'right', 1.00, 'منصتنا ، نجاحك', 'إنشاء موقع الدورة التدريبية الخاصة بك', 'اكتشف الخطط', 'https://coursmat.xyz/pricing', 'https://www.youtube.com/watch?v=6stlCkUDG_s', '62bd7ba737ba0.png', 'America/Shiprock', 'منزل - 44 ، طريق - 03 ، قطاع - 11 ، أوتارا ، دكا\r\nدهانوندي ، دكا\r\nمحمدبور ، دكا', '237237237,72372332,+8967936437', 'contact@example.com,support@example.com,query@example.com', 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\"]', 3, 40.00, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `basic_settings`
--

CREATE TABLE `basic_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `favicon` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `preloader_status` tinyint NOT NULL DEFAULT '1',
  `preloader` varchar(50) DEFAULT NULL,
  `website_title` varchar(255) DEFAULT NULL,
  `base_color` varchar(30) DEFAULT NULL,
  `base_color2` varchar(30) DEFAULT NULL,
  `breadcrumb` varchar(50) DEFAULT NULL,
  `footer_logo` varchar(50) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  `newsletter_text` varchar(255) DEFAULT NULL,
  `copyright_text` blob,
  `intro_subtitle` varchar(50) DEFAULT NULL,
  `intro_title` varchar(50) DEFAULT NULL,
  `intro_text` text,
  `intro_main_image` varchar(191) DEFAULT NULL,
  `contact_form_title` varchar(255) DEFAULT NULL,
  `contact_text` varchar(255) DEFAULT NULL,
  `contact_info_title` varchar(191) DEFAULT NULL,
  `tawk_to_script` text,
  `is_recaptcha` tinyint NOT NULL DEFAULT '0',
  `google_recaptcha_site_key` varchar(255) DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `is_tawkto` tinyint NOT NULL DEFAULT '1',
  `tawkto_property_id` varchar(255) DEFAULT NULL,
  `tawkto_chat_link` varchar(255) DEFAULT NULL,
  `is_disqus` tinyint NOT NULL DEFAULT '1',
  `is_user_disqus` tinyint NOT NULL DEFAULT '1',
  `disqus_shortname` varchar(255) DEFAULT NULL,
  `disqus_script` text,
  `maintainance_mode` tinyint NOT NULL DEFAULT '0' COMMENT '1 - active, 0 - deactive',
  `maintainance_text` text,
  `maintenance_img` varchar(50) DEFAULT NULL,
  `maintenance_status` tinyint NOT NULL DEFAULT '0',
  `secret_path` varchar(255) DEFAULT NULL,
  `home_section` tinyint NOT NULL DEFAULT '1',
  `process_section` tinyint NOT NULL DEFAULT '1',
  `featured_users_section` tinyint NOT NULL DEFAULT '1',
  `pricing_section` tinyint NOT NULL DEFAULT '1',
  `partners_section` tinyint NOT NULL DEFAULT '1',
  `partner_title` varchar(255) DEFAULT NULL,
  `partner_subtitle` varchar(255) DEFAULT NULL,
  `intro_section` tinyint NOT NULL DEFAULT '1',
  `intro_section_button_text` varchar(255) DEFAULT NULL,
  `intro_section_button_url` varchar(255) DEFAULT NULL,
  `intro_section_video_url` varchar(255) DEFAULT NULL,
  `testimonial_section` tinyint NOT NULL DEFAULT '1',
  `feature_title` varchar(255) DEFAULT NULL,
  `work_process_title` varchar(255) DEFAULT NULL,
  `preview_templates_title` varchar(255) DEFAULT NULL,
  `preview_templates_subtitle` varchar(255) DEFAULT NULL,
  `featured_users_title` varchar(255) DEFAULT NULL,
  `featured_users_subtitle` varchar(255) DEFAULT NULL,
  `pricing_title` varchar(255) DEFAULT NULL,
  `pricing_subtitle` varchar(255) DEFAULT NULL,
  `testimonial_title` varchar(255) DEFAULT NULL,
  `testimonial_subtitle` varchar(255) DEFAULT NULL,
  `news_section` tinyint NOT NULL DEFAULT '1',
  `template_section` tinyint NOT NULL DEFAULT '1',
  `top_footer_section` tinyint NOT NULL DEFAULT '1',
  `copyright_section` tinyint NOT NULL DEFAULT '1',
  `blog_title` varchar(255) DEFAULT NULL,
  `blog_subtitle` varchar(255) DEFAULT NULL,
  `useful_links_title` varchar(50) DEFAULT NULL,
  `newsletter_title` varchar(50) DEFAULT NULL,
  `newsletter_subtitle` varchar(255) DEFAULT NULL,
  `is_whatsapp` tinyint NOT NULL DEFAULT '1',
  `whatsapp_number` varchar(50) DEFAULT NULL,
  `whatsapp_header_title` varchar(255) DEFAULT NULL,
  `whatsapp_popup_message` text,
  `whatsapp_popup` tinyint NOT NULL DEFAULT '1',
  `aws_access_key_id` varchar(255) DEFAULT NULL,
  `aws_secret_access_key` varchar(255) DEFAULT NULL,
  `aws_default_region` varchar(255) DEFAULT NULL,
  `aws_bucket` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `basic_settings`
--

INSERT INTO `basic_settings` (`id`, `language_id`, `favicon`, `logo`, `preloader_status`, `preloader`, `website_title`, `base_color`, `base_color2`, `breadcrumb`, `footer_logo`, `footer_text`, `newsletter_text`, `copyright_text`, `intro_subtitle`, `intro_title`, `intro_text`, `intro_main_image`, `contact_form_title`, `contact_text`, `contact_info_title`, `tawk_to_script`, `is_recaptcha`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `is_tawkto`, `tawkto_property_id`, `tawkto_chat_link`, `is_disqus`, `is_user_disqus`, `disqus_shortname`, `disqus_script`, `maintainance_mode`, `maintainance_text`, `maintenance_img`, `maintenance_status`, `secret_path`, `home_section`, `process_section`, `featured_users_section`, `pricing_section`, `partners_section`, `partner_title`, `partner_subtitle`, `intro_section`, `intro_section_button_text`, `intro_section_button_url`, `intro_section_video_url`, `testimonial_section`, `feature_title`, `work_process_title`, `preview_templates_title`, `preview_templates_subtitle`, `featured_users_title`, `featured_users_subtitle`, `pricing_title`, `pricing_subtitle`, `testimonial_title`, `testimonial_subtitle`, `news_section`, `template_section`, `top_footer_section`, `copyright_section`, `blog_title`, `blog_subtitle`, `useful_links_title`, `newsletter_title`, `newsletter_subtitle`, `is_whatsapp`, `whatsapp_number`, `whatsapp_header_title`, `whatsapp_popup_message`, `whatsapp_popup`, `aws_access_key_id`, `aws_secret_access_key`, `aws_default_region`, `aws_bucket`) VALUES
(153, 176, '04183517e770a890d4a56cf9deae1d19dd69ffee.png', 'ee50d26a0952e3e925dd71d418f37c99631e394f.png', 1, '9fc4b325993e8d2f83f57637274e96da369f5a39.gif', 'Supervsasso', '#FF5F26', '#FF4B2B', 'da024ec1d7b2a9628424dd1ef42c59578d23d3ed.png', '0ac7f783db891f76ee6866d5312b0048a69364c9.png', 'We are a awward winning multinaitonal Company. We Believe quality and standard worlwidex Consider.', 'Subscribe to gate Latest News, Offer and connect With Us.', 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920654f726465722e3c2f703e, 'Bring More Profit With More Features', 'Why You Choose Our Template', 'It is a long established fact that a reader will be choose by the readable content of a page when looking at its layout.\n\nWe completed 500+ client’s projects\nWe have 10+ multiple developer\n100+ active client’s working with us\nYour trusted business partner', '62b2b131e6f12.png', 'Leave Reply', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum.', 'Contact Info', '<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/5f5e445f4704467e89ee918d/default\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->', 0, '6Lf9jOQUAAAAABJKj_nQBNvji7wh4DdOZIPAdRKk', '6Lf9jOQUAAAAALO4C5pC7O_HHw0Z1BuYCU_FA606', 0, '60b886bbde99a4282a1b22a3', 'https://tawk.to/chat/62d688ec7b967b11799a42ee/1g8b0do1h', 1, 1, 'plusagency-2-5', '<script>\r\n\r\n/**\r\n*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.\r\n*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/\r\n/*\r\nvar disqus_config = function () {\r\nthis.page.url = PAGE_URL;  // Replace PAGE_URL with your page\'s canonical URL variable\r\nthis.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page\'s unique identifier variable\r\n};\r\n*/\r\n(function() { // DON\'T EDIT BELOW THIS LINE\r\nvar d = document, s = d.createElement(\'script\');\r\ns.src = \'https://plusagency.disqus.com/embed.js\';\r\ns.setAttribute(\'data-timestamp\', +new Date());\r\n(d.head || d.body).appendChild(s);\r\n})();\r\n</script>', 0, 'We are upgrading our site. We will come back soon. \r\nPlease stay with us.\r\nThank you....', '62c010a8266f6.png', 0, NULL, 1, 1, 1, 1, 1, 'Our Great Achievement Proved Us!', 'We Completed 500+ Projects With Clint\'s Satisfaction', 1, 'Know More', 'http://www.coursmat.xyz/p/about-us', 'https://www.youtube.com/watch?v=K4TOrB7at0Y', 1, 'Features', 'Make Restaurant Website', 'Creative & User Friendly Design', 'See Our Restaurant Template', 'Our Features Users', 'Take a Look at The Featured Users', 'Build Your Relationship With Price', 'Choose Your Package', 'Our Happy Client’s', 'What Our Cliets Say', 1, 1, 1, 1, 'Blogs', 'Our Latest Blogs', 'Useful Links', 'Newsletter', 'Get latest updates first', 0, '2367327069', 'Hi, There!', 'How can I help you?\r\ngreat', 0, 'AKIA42IHPRGEG42AS4G5', 'kLgOufX8W1tV3egeMINCqJyU7Qps57a/gRaNFQ/n', 'us-east-1', 'suppervsasso'),
(154, 177, '04183517e770a890d4a56cf9deae1d19dd69ffee.png', 'ee50d26a0952e3e925dd71d418f37c99631e394f.png', 1, '9fc4b325993e8d2f83f57637274e96da369f5a39.gif', 'Supervsasso', '#FF5F26', '#FF4B2B', 'da024ec1d7b2a9628424dd1ef42c59578d23d3ed.png', '0040c48e2130c3c6609f5573fb5debeafb7d9855.png', 'نحن شركة متعددة الأطراف فائزة بشكل كبير. نحن نؤمن بالجودة والمعايير التي نأخذها بعين الاعتبار.', 'Subscribe to gate Latest News, Offer and connect With Us.', 0xd8acd985d98ad8b920d8a7d984d8add982d988d98220d985d8add981d988d8b8d8a920c2a920323032322e, 'قصتنا', 'لدينا 20 عاما من الخبرة العملية في مقهى.', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام', '6195e994095b0.png', 'اترك الرد', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل', 'معلومات الاتصال', '<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/5f5e445f4704467e89ee918d/default\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->', 0, '6Lf9jOQUAAAAABJKj_nQBNvji7wh4DdOZIPAdRKk', '6Lf9jOQUAAAAALO4C5pC7O_HHw0Z1BuYCU_FA606', 0, '60b886bbde99a4282a1b22a3', 'https://tawk.to/chat/62d688ec7b967b11799a42ee/1g8b0do1h', 1, 1, 'plusagency-2-5', '<script>\r\n\r\n/**\r\n*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.\r\n*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/\r\n/*\r\nvar disqus_config = function () {\r\nthis.page.url = PAGE_URL;  // Replace PAGE_URL with your page\'s canonical URL variable\r\nthis.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page\'s unique identifier variable\r\n};\r\n*/\r\n(function() { // DON\'T EDIT BELOW THIS LINE\r\nvar d = document, s = d.createElement(\'script\');\r\ns.src = \'https://plusagency.disqus.com/embed.js\';\r\ns.setAttribute(\'data-timestamp\', +new Date());\r\n(d.head || d.body).appendChild(s);\r\n})();\r\n</script>', 0, 'We are upgrading our site. We will come back soon. \r\nPlease stay with us.\r\nThank you....', NULL, 0, NULL, 1, 1, 1, 1, 1, 'لقد أثبت لنا إنجازنا العظيم!', 'لقد أكملنا أكثر من +500 مشروع برضا كلينت', 1, NULL, NULL, NULL, 1, 'متميز', 'آلية العمل', 'تصميم إبداعي وسهل الاستخدام', 'انظر نموذج التعليم الخاص بنا', 'مستخدم مميز', 'مستخدم مميز', 'التسعير', 'التسعير', 'شهادة', 'شهادة', 1, 1, 1, 1, 'المدونات', 'أحدث مدوناتنا', 'روابط مفيدة', 'النشرة الإخبارية', 'احصل على آخر التحديثات أولاً', 0, '2367327069', 'Hi, There!', 'How can I help you?\r\ngreat', 0, 'AKIA42IHPRGEG42AS4G5', 'kLgOufX8W1tV3egeMINCqJyU7Qps57a/gRaNFQ/n', 'us-east-1', 'suppervsasso');

-- --------------------------------------------------------

--
-- Table structure for table `bcategories`
--

CREATE TABLE `bcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial_number` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bcategories`
--

INSERT INTO `bcategories` (`id`, `language_id`, `name`, `status`, `serial_number`) VALUES
(1, 176, 'Cooking', 1, 1),
(3, 176, 'Foods', 1, 2),
(4, 176, 'Burgers', 1, 3),
(5, 176, 'Fun & Jamming', 1, 4),
(6, 176, 'Recipes', 1, 5),
(7, 177, 'طبخ', 1, 1),
(8, 177, 'أغذية', 1, 2),
(9, 177, 'برجر', 1, 3),
(10, 177, 'المرح والتشويش', 1, 4),
(11, 177, 'وصفات', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `bcategory_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` blob,
  `tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `serial_number` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `language_id`, `bcategory_id`, `title`, `slug`, `main_image`, `content`, `tags`, `meta_keywords`, `meta_description`, `serial_number`, `created_at`, `updated_at`) VALUES
(66, 176, 1, 'Fusce convallis enim non magna Duis lacus dignissim.', 'Fusce-convallis-enim-non-magna-Duis-lacus-dignissim.', '1598694784.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 1, '2020-08-29 03:47:49', '2020-08-29 03:53:04'),
(67, 176, 3, 'Non magna pharetra facilisis. lacus nulla dignissim.', 'Non-magna-pharetra-facilisis.-lacus-nulla-dignissim.', '1598694802.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 2, '2020-08-29 03:50:37', '2020-08-29 03:53:22'),
(68, 176, 6, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor', 'Lorem-ipsum-dolor-sit-amet,-consectetur-adipiscing-elit,-sed-do-eiusmod-tempor', '1598694694.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 3, '2020-08-29 03:51:34', '2020-08-29 03:51:34'),
(69, 176, 3, 'Fusce convallis enim non magna Duis lacus dignissim.', 'Fusce-convallis-enim-non-magna-Duis-lacus-dignissim.', '1598694769.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 4, '2020-08-29 03:52:49', '2020-08-29 03:52:49'),
(70, 176, 1, 'Top 10 Most Popular E-commerce Website Template for Shopping', 'Top-10-Most-Popular-E-commerce-Website-Template-for-Shopping', '2121f447abc4ee04ae0ea0b20c7e9ba1a3ebf6f3.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 5, '2020-08-29 03:53:57', '2022-12-15 07:13:49'),
(71, 176, 5, 'Fusce convallis enim non magna Duis lacus dignissim.', 'Fusce-convallis-enim-non-magna-Duis-lacus-dignissim.', '1598694875.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 6, '2020-08-29 03:54:35', '2020-08-29 03:54:35'),
(72, 176, 3, 'Non magna pharetra facilisis. lacus nulla dignissim.', 'Non-magna-pharetra-facilisis.-lacus-nulla-dignissim.', '1598694928.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 7, '2020-08-29 03:55:28', '2020-08-29 03:55:28'),
(73, 176, 3, 'Non magna pharetra facilisis. lacus nulla dignissim.', 'Non-magna-pharetra-facilisis.-lacus-nulla-dignissim.', '1598694962.jpg', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, NULL, NULL, NULL, 8, '2020-08-29 03:56:02', '2020-08-29 03:56:02'),
(74, 176, 1, 'Fusce convallis enim non magna Duis lacus dignissim.', 'Fusce-convallis-enim-non-magna-Duis-lacus-dignissim.', '1598695007.jpg', 0x3c703e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e3c2f703e, NULL, NULL, NULL, 9, '2020-08-29 03:56:47', '2023-08-24 08:40:45'),
(75, 177, 7, 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز', 'هناك-حقيقة-مثبتة-منذ-زمن-طويل-وهي-أن-المحتوى-المقروء-لصفحة-ما-سيلهي-القارئ-عن-التركيز', '1598773516.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 1, '2020-08-30 01:45:16', '2020-08-30 01:45:16'),
(76, 177, 8, 'المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص', 'المحتوى)-ويُستخدم-في-صناعات-المطابع-ودور-النشر.-كان-لوريم-إيبسوم-ولايزال-المعيار-للنص', '1598773566.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 2, '2020-08-30 01:46:06', '2020-08-30 01:46:06'),
(77, 177, 11, 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز', 'هناك-حقيقة-مثبتة-منذ-زمن-طويل-وهي-أن-المحتوى-المقروء-لصفحة-ما-سيلهي-القارئ-عن-التركيز', '1598773612.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 3, '2020-08-30 01:46:52', '2020-08-30 01:46:52'),
(78, 177, 8, 'لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس', 'لوريم-إيبسوم(Lorem-Ipsum)-هو-ببساطة-نص-شكلي-(بمعنى-أن-الغاية-هي-الشكل-وليس', '1598773671.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 4, '2020-08-30 01:47:51', '2020-08-30 01:47:51');
INSERT INTO `blogs` (`id`, `language_id`, `bcategory_id`, `title`, `slug`, `main_image`, `content`, `tags`, `meta_keywords`, `meta_description`, `serial_number`, `created_at`, `updated_at`) VALUES
(79, 177, 7, 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز', 'هناك-حقيقة-مثبتة-منذ-زمن-طويل-وهي-أن-المحتوى-المقروء-لصفحة-ما-سيلهي-القارئ-عن-التركيز', '1598773736.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 5, '2020-08-30 01:48:56', '2020-08-30 01:48:56'),
(80, 177, 10, 'المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص', 'المحتوى)-ويُستخدم-في-صناعات-المطابع-ودور-النشر.-كان-لوريم-إيبسوم-ولايزال-المعيار-للنص', '1598773784.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 6, '2020-08-30 01:49:44', '2020-08-30 01:49:44'),
(81, 177, 8, 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز', 'هناك-حقيقة-مثبتة-منذ-زمن-طويل-وهي-أن-المحتوى-المقروء-لصفحة-ما-سيلهي-القارئ-عن-التركيز', '1598773832.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 7, '2020-08-30 01:50:32', '2020-08-30 01:50:32'),
(82, 177, 8, 'المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص', 'المحتوى)-ويُستخدم-في-صناعات-المطابع-ودور-النشر.-كان-لوريم-إيبسوم-ولايزال-المعيار-للنص', '1598773871.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 8, '2020-08-30 01:51:11', '2020-08-30 01:51:11'),
(83, 177, 7, 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز', 'هناك-حقيقة-مثبتة-منذ-زمن-طويل-وهي-أن-المحتوى-المقروء-لصفحة-ما-سيلهي-القارئ-عن-التركيز', '1598773908.jpg', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, NULL, NULL, NULL, 9, '2020-08-30 01:51:48', '2020-08-30 01:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `bottomlinks`
--

CREATE TABLE `bottomlinks` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bottomlinks`
--

INSERT INTO `bottomlinks` (`id`, `language_id`, `user_id`, `name`, `url`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Privacy Policy', 'https://codecanyon.megasoft.biz/superv/Privacy-Policy/4/page', NULL, NULL),
(2, 3, 1, 'Terms & Conditions', 'https://codecanyon.megasoft.biz/superv/About-Us/1/page', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `verification_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_verified` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `pass_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `fname`, `lname`, `photo`, `username`, `email`, `password`, `number`, `city`, `state`, `address`, `country`, `remember_token`, `billing_fname`, `billing_lname`, `billing_photo`, `billing_username`, `billing_email`, `billing_number`, `billing_city`, `billing_state`, `billing_address`, `billing_country`, `shipping_fname`, `shipping_lname`, `shipping_username`, `shipping_email`, `shipping_number`, `shipping_city`, `shipping_state`, `shipping_address`, `shipping_country`, `status`, `verification_link`, `email_verified`, `pass_token`, `created_at`, `updated_at`, `provider`, `provider_id`, `billing_country_code`, `shipping_country_code`) VALUES
(5, 14, NULL, NULL, NULL, 'genius', 'imranyeasin75@gmail.com', '$2y$10$ZMZsPL6ZthVpDUqCKBLMquj1hEXZ1Lo4Dcwli65WJB1a/IJouCuM6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'a92199839f50d86a6446bdc173600f9a', 'Yes', 'zk5eTXeMd8KX4HA6ezpooabA7GoYpy', '2023-11-27 14:44:05', '2023-12-19 03:44:23', NULL, NULL, NULL, NULL),
(6, 14, NULL, NULL, NULL, 'nitanevici', 'kyfycinali@mailinator.com', '$2y$10$dJUxOuLgJOmSIAbNnlJipuyty9R9b/l8G2oF3oijq2VQoavGx3qE6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '5d4211d569829f15829556198a7dd7d2', 'Yes', NULL, '2023-12-07 03:58:16', '2023-12-06 21:58:34', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'percentage, fixed',
  `value` decimal(11,2) DEFAULT NULL,
  `packages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_spend` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `code`, `type`, `value`, `packages`, `start_date`, `end_date`, `minimum_spend`, `created_at`, `updated_at`) VALUES
(2, 'KHABO60', 'KHABO60', 'fixed', 60.00, NULL, '12/24/2020', '12/30/2020', 180.00, '2020-12-23 02:23:36', '2020-12-23 02:23:36'),
(3, 'Victory Day', 'BIJOY16', 'percentage', 16.00, NULL, '12/16/2020', '01/07/2021', 10.00, '2020-12-23 02:32:55', '2020-12-24 04:54:59'),
(4, 'Special', 'Special14', 'percentage', 14.00, NULL, '12/29/2020', '01/09/2021', 400.00, '2020-12-23 03:54:07', '2020-12-24 08:54:42'),
(5, 'Cricket', '123', 'percentage', 5.00, '[\"39\",\"40\"]', '12/03/2023', '12/28/2023', 100.00, '2023-12-04 10:36:24', '2023-12-04 10:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 14, 'genius', 'geniustest11@gmail.com', '1689583182', 'Rome, Italy', '2023-09-12 10:08:47', '2023-09-12 10:08:47'),
(2, 14, 'genius test', 'geniustest11@gmail.com', '01689583182', NULL, '2023-09-13 16:14:20', '2023-09-13 16:14:20'),
(3, 14, 'genius test', 'pratik.anwar@gmail.com', '3243263413', NULL, '2023-09-27 16:25:26', '2023-09-27 16:25:26'),
(4, 14, 'Samiul Alim', 'geniustest11@gmail.com', '16895831821', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', '2023-11-28 13:00:34', '2023-12-26 05:08:06'),
(5, 14, NULL, NULL, NULL, NULL, '2023-11-28 13:03:37', '2023-12-30 10:21:10'),
(6, 14, 'Imran', 'imranyeasin75@gmail.com', '1919921118', NULL, '2023-12-07 04:06:10', '2023-12-09 03:29:40');

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `email_type` varchar(100) DEFAULT NULL,
  `email_subject` text,
  `email_body` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `email_type`, `email_subject`, `email_body`) VALUES
(2, 'email_verification', 'Verify Your Email', '<p style=\"line-height: 1.6;\">Hello<b> {customer_name}</b>,</p><p style=\"line-height: 1.6;\"><br>Please click the link below to verify your email.</p><p>{verification_link}</p><p><br></p><p>Best Regards,</p><p>{website_title}</p>'),
(12, 'custom_domain_connected', 'Custom Domain is Connected with Our Server', 'Hi {username},<br><br>\n\nThanks for your custom domain request.<br>\nYour requested domain {requested_domain} has been connected to your server.<br>\nPlease <strong>clear your browser cache</strong> & visit {requested_domain} to see your portfolio website.<br>\n\nYour current domain: {requested_domain}.<br>\nYour previous domain: {previous_domain}.<br><br>\n\nBest Regards,<br>\n{website_title}.<br>'),
(13, 'custom_domain_rejected', 'Custom Domain Request is Rejected', 'Hi {username},<br><br>\r\n\r\nThanks for your custom domain request.<br>\r\nUnfortunately, we have rejected your custom domain request<br>\r\n\r\nYour requested domain: {requested_domain}.<br>\r\nYour current domain: {current_domain}.<br><br>\r\n\r\nBest Regards,<br>\r\n{website_title}.<br>'),
(16, 'registration_with_premium_package', 'You have registered successfully', '<p>Hi {username},<br /><br />\n\nThis is a confirmation mail from us</p><p><b><span style=\"font-size:18px;\">Membership Information:</span></b><br /><strong>Package Title:</strong> {package_title}<br /><strong>Package Price:</strong> {package_price}</p><p><b>Discount:</b> {discount}</p><p><span style=\"font-weight:600;\">Total:</span> {total}<br /><strong>Activation Date:</strong> {activation_date}<br /><strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\nThank you for your purchase.</p><p><br />\n\nBest Regards,<br />\n{website_title}.<br /></p>'),
(17, 'registration_with_trial_package', 'You have registered successfully', 'Hi {username},<br /><br />\r\n\r\nThis is a confirmation mail from us.<br />\r\nYou have purchased a trial package<br /><br />\r\n\r\n<h4>Membership Information:</h4>\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}<br /><br />\r\n\r\nWe have attached an invoice in this mail<br />\r\nThank you for your purchase.<br /><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br />'),
(18, 'registration_with_free_package', 'You have registered successfully', 'Hi {username},<br /><br />\r\n\r\nThis is a confirmation mail from us.<br />\r\nYou have purchased a free package<br /><br />\r\n\r\n<h4>Membership Information:</h4>\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}<br /><br />\r\n\r\nWe have attached an invoice in this mail<br />\r\nThank you for your purchase.<br /><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br />'),
(19, 'membership_expiry_reminder', 'Your membership will be expired soon', 'Hi {username},<br /><br />\r\n\r\nYour membership will be expired soon.<br />\r\nYour membership is valid till <strong>{last_day_of_membership}</strong><br />\r\nPlease click here - {login_link} to log into the dashboard to purchase a new package / extend the current package to extend your membership.<br /><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.'),
(20, 'membership_expired', 'Your membership is expired', 'Hi {username},<br><br>\r\n\r\nYour membership is expired.<br>\r\nPlease click here - {login_link} to log into the dashboard to purchase a new package / extend the current package to continue the membership.<br><br>\r\n\r\nBest Regards,<br>\r\n{website_title}.'),
(21, 'membership_extend', 'Your membership is extended', '<p>Hi {username},<br /><br />\n\nThis is a confirmation mail from us.<br />\nYou have extended your membership.<br />\n\n<strong>Package Title:</strong> {package_title}<br />\n<strong>Package Price:</strong> {package_price}<br />\n<strong>Activation Date:</strong> {activation_date}<br />\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\nThank you for your purchase.</p><p><br />\n\nBest Regards,<br />\n{website_title}.<br /></p>'),
(22, 'payment_accepted_for_membership_extension_offline_gateway', 'Your payment for membership extension is accepted', '<p>Hi {username},<br /><br />\r\n\r\nThis is a confirmation mail from us.<br />\r\nYour payment has been accepted & your membership is extended.<br />\r\n\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(23, 'payment_accepted_for_registration_offline_gateway', 'Your payment for registration is approved', '<p>Hi {username},<br /><br />\r\n\r\nThis is a confirmation mail from us.<br />\r\nYour payment has been accepted & now you can login to your user dashboard to build your portfolio website.<br />\r\n\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(24, 'payment_rejected_for_membership_extension_offline_gateway', 'Your payment for membership extension is rejected', '<p>Hi {username},<br /><br />\r\n\r\nWe are sorry to inform you that your payment has been rejected<br />\r\n\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(25, 'payment_rejected_for_registration_offline_gateway', 'Your payment for registration is rejected', '<p>Hi {username},<br /><br />\r\n\r\nWe are sorry to inform you that your payment has been rejected<br>\r\n\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(26, 'admin_changed_current_package', 'Admin has changed your current package', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has changed your current package <b>({replaced_package})</b></p>\r\n<p><b>New Package Information:</b></p>\r\n<p>\r\n<strong>Package:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(27, 'admin_added_current_package', 'Admin has added current package for you', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has added current package for you</p><p><b><span style=\"font-size:18px;\">Current Membership Information:</span></b><br />\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(28, 'admin_changed_next_package', 'Admin has changed your next package', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has changed your next package <b>({replaced_package})</b></p><p><b><span style=\"font-size:18px;\">Next Membership Information:</span></b><br />\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(29, 'admin_added_next_package', 'Admin has added next package for you', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has added next package for you</p><p><b><span style=\"font-size:18px;\">Next Membership Information:</span></b><br />\r\n<strong>Package Title:</strong> {package_title}<br />\r\n<strong>Package Price:</strong> {package_price}<br />\r\n<strong>Activation Date:</strong> {activation_date}<br />\r\n<strong>Expire Date:</strong> {expire_date}</p><p><br /></p><p>We have attached an invoice with this mail.<br />\r\nThank you for your purchase.</p><p><br />\r\n\r\nBest Regards,<br />\r\n{website_title}.<br /></p>'),
(30, 'admin_removed_current_package', 'Admin has removed current package for you', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has removed current package - <strong>{removed_package_title}</strong><br>\r\n\r\nBest Regards,<br />\r\n{website_title}.<br />'),
(31, 'admin_removed_next_package', 'Admin has removed next package for you', '<p>Hi {username},<br /><br />\r\n\r\nAdmin has removed next package - <strong>{removed_package_title}</strong><br>\r\n\r\nBest Regards,<br />\r\n{website_title}.<br />');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `serial_number` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `language_id`, `question`, `answer`, `serial_number`) VALUES
(20, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 1),
(21, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 2),
(22, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 3),
(23, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 4),
(24, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 5),
(25, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 6),
(26, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 7),
(27, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 8),
(28, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 9),
(29, 176, 'Why this app is so awesome', 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.', 10),
(50, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 1),
(51, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 2),
(52, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 3),
(53, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 4),
(54, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 5),
(55, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 6),
(56, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 7),
(57, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 8),
(58, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 9),
(59, 177, 'لماذا هذا التطبيق رائع جدا', 'الرسوم المتحركة pariatur كليشيه reprehenderit ، enim eiusmod حياة عالية accusamus تيري ريتشاردسون الإعلانية الحبار. 3 الذئب القمر officia aute ، غير cupidatat غداء دولر لوح التزلج. شاحنة الغذاء الكينوا nesciunt labum eiusmod.', 10);

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `language_id`, `image`, `title`, `serial_number`, `created_at`, `updated_at`) VALUES
(37, 176, '1598681069.png', 'Healthy Foods', 1, NULL, NULL),
(38, 176, '1599804681.png', 'Fresh Items', 2, NULL, NULL),
(42, 176, '1598681208.png', 'Tasty Foods', 3, NULL, NULL),
(43, 176, '1598681487.png', 'Sweet Cheeses', 4, NULL, NULL),
(50, 176, '1598681561.jpg', 'Best Pizzas', 5, NULL, NULL),
(51, 176, '1598681630.jpg', 'Hot Snacks', 6, NULL, NULL),
(52, 177, '1598709367.png', 'أغذية صحية', 1, NULL, NULL),
(53, 177, '1598709399.png', 'الأصناف الطازجة', 2, NULL, NULL),
(54, 177, '1598709420.png', 'Tasty Foods', 3, NULL, NULL),
(55, 177, '1598709446.png', 'جبن حلو', 4, NULL, NULL),
(56, 177, '1598709473.jpg', 'أفضل بيتزا', 5, NULL, NULL),
(57, 177, '1598709494.jpg', 'وجبات خفيفة ساخنة', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `language_id`, `user_id`, `title`, `image`, `serial_number`, `created_at`, `updated_at`) VALUES
(5, 10, 7, 'sadfasdf', '61046c691296b5273e99964d888d172ad5f7d1c1.jpeg', 2, '2023-09-10 07:15:22', '2023-09-10 07:15:22'),
(6, 21, 14, 'عشر عندما قامت مطبعة م', 'ceb69d9f3b556df1e54078380dad624ddb78bfe2.png', 1, '2023-09-28 12:12:13', '2023-09-28 12:12:13'),
(7, 19, 14, 'jvkhkj', '01b6c2b79830e54138189c0a0fe1969a660334c1.png', 1, '2023-10-12 04:32:36', '2023-12-26 22:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `endpoint` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `user_id`, `endpoint`, `created_at`, `updated_at`) VALUES
(1, 14, 'https://fcm.googleapis.com/fcm/send/fUtUUAwK6r4:APA91bFeSP7KJ6Vrjs5Sku8m5tQB_TOdMGsu3kbyf6rBNe_UcZIzP4AVzsKrrCqiMWRCV9idAI9I6k82ld-8GpGtNDKZ5pD5quB9TXUYEl5fV80QBXPHdvBE1_7VAcH1zaHsq4J5Wy7e', '2023-12-20 07:15:44', '2023-12-20 07:15:44'),
(2, 14, 'https://fcm.googleapis.com/fcm/send/doJFJNI9pK0:APA91bHUrCnvPsJrwRV3c78ET15Xhtpe8lEiNfS3vmeoFpmQf_EbC7O_USqVnZZqfyBrAhGZ2yYQo3GldQr1asnuSavjI34J-zq2l3E_Pkr4beJdhy2oVo5hjlohctyBdd3AMrNqLT2j', '2023-12-23 06:42:23', '2023-12-23 06:42:23'),
(3, 14, 'https://fcm.googleapis.com/fcm/send/fc2b9a-GNnE:APA91bEF22XzYVf4-r9xCkDAxTxQpjP6LFAe77ycWIE1LhVuKpWZc8NVKHWoSwzUXZQKr2zhQt2Rg7ExYxQ0TNqPL1Mtl0QVN5UqbNCyqouAna3HQWtMF1D0ResH35-Onsy8NyULwQJh', '2023-12-25 00:08:48', '2023-12-25 00:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `jcategories`
--

CREATE TABLE `jcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial_number` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jcategories`
--

INSERT INTO `jcategories` (`id`, `language_id`, `user_id`, `name`, `status`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 21, 14, 'تقضي على', 1, 1, '2023-09-28 11:37:45', '2023-09-28 11:37:45'),
(2, 19, 14, 'developer', 1, 1, '2023-12-04 21:51:56', '2023-12-04 21:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `jcategory_id` int DEFAULT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacancy` int DEFAULT NULL,
  `deadline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experience` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_responsibilities` blob,
  `employment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `educational_requirements` blob,
  `experience_requirements` blob,
  `additional_requirements` blob,
  `job_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` blob,
  `benefits` blob,
  `read_before_apply` blob,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int NOT NULL DEFAULT '0',
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `jcategory_id`, `language_id`, `user_id`, `title`, `slug`, `vacancy`, `deadline`, `experience`, `job_responsibilities`, `employment_status`, `educational_requirements`, `experience_requirements`, `additional_requirements`, `job_location`, `salary`, `benefits`, `read_before_apply`, `email`, `serial_number`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 21, 14, 'بل انه حتى صار مستخدماً', 'بل-انه-حتى-صار-مستخدماً', 3, '09/20/2023', '3', 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 'الخامس', 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, '. كان لوريم', 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 0x3c70206469723d2272746c223ed984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985284c6f72656d20497073756d2920d987d98820d8a8d8a8d8b3d8a7d8b7d8a920d986d8b520d8b4d983d984d98a2028d8a8d985d8b9d986d98920d8a3d98620d8a7d984d8bad8a7d98ad8a920d987d98a20d8a7d984d8b4d983d98420d988d984d98ad8b320d8a7d984d985d8add8aad988d9892920d988d98ad98fd8b3d8aad8aed8afd98520d981d98a20d8b5d986d8a7d8b9d8a7d8aa20d8a7d984d985d8b7d8a7d8a8d8b920d988d8afd988d8b120d8a7d984d986d8b4d8b12e20d983d8a7d98620d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d988d984d8a7d98ad8b2d8a7d98420d8a7d984d985d8b9d98ad8a7d8b120d984d984d986d8b520d8a7d984d8b4d983d984d98a20d985d986d8b020d8a7d984d982d8b1d98620d8a7d984d8aed8a7d985d8b320d8b9d8b4d8b120d8b9d986d8afd985d8a720d982d8a7d985d8aa20d985d8b7d8a8d8b9d8a920d985d8acd987d988d984d8a920d8a8d8b1d8b520d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8a3d8add8b1d98120d8a8d8b4d983d98420d8b9d8b4d988d8a7d8a6d98a20d8a3d8aed8b0d8aad987d8a720d985d98620d986d8b5d88c20d984d8aad983d988d991d98620d983d8aad98ad991d8a820d8a8d985d8abd8a7d8a8d8a920d8afd984d98ad98420d8a3d98820d985d8b1d8acd8b920d8b4d983d984d98a20d984d987d8b0d98720d8a7d984d8a3d8add8b1d9812e20d8aed985d8b3d8a920d982d8b1d988d98620d985d98620d8a7d984d8b2d985d98620d984d98520d8aad982d8b6d98a20d8b9d984d98920d987d8b0d8a720d8a7d984d986d8b5d88c20d8a8d98420d8a7d986d98720d8add8aad98920d8b5d8a7d8b120d985d8b3d8aad8aed8afd985d8a7d98b20d988d8a8d8b4d983d984d98720d8a7d984d8a3d8b5d984d98a20d981d98a20d8a7d984d8b7d8a8d8a7d8b9d8a920d988d8a7d984d8aad986d8b6d98ad8af20d8a7d984d8a5d984d983d8aad8b1d988d986d98a2e20d8a7d986d8aad8b4d8b120d8a8d8b4d983d98420d983d8a8d98ad8b120d981d98a20d8b3d8aad98ad986d98ad991d8a7d8aa20d987d8b0d8a720d8a7d984d982d8b1d98620d985d8b920d8a5d8b5d8afd8a7d8b120d8b1d982d8a7d8a6d9822022d984d98ad8aad8b1d8a7d8b3d98ad8aa2220284c657472617365742920d8a7d984d8a8d984d8a7d8b3d8aad98ad983d98ad8a920d8aad8add988d98a20d985d982d8a7d8b7d8b920d985d98620d987d8b0d8a720d8a7d984d986d8b5d88c20d988d8b9d8a7d8af20d984d98ad986d8aad8b4d8b120d985d8b1d8a920d8a3d8aed8b1d98920d985d8a4d8aed8b1d8a7d98e20d985d8b920d8b8d987d988d8b120d8a8d8b1d8a7d985d8ac20d8a7d984d986d8b4d8b120d8a7d984d8a5d984d983d8aad8b1d988d986d98a20d985d8abd9842022d8a3d984d8afd988d8b320d8a8d8a7d98ad8ac20d985d8a7d98ad983d8b1222028416c64757320506167654d616b65722920d988d8a7d984d8aad98a20d8add988d8aa20d8a3d98ad8b6d8a7d98b20d8b9d984d98920d986d8b3d8ae20d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d9852e3c2f703e, 'pratik.anwar@gmail.com', 1, NULL, NULL, '2023-09-28 11:39:12', '2023-09-28 11:39:12'),
(2, 2, 19, 14, 'an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electr', 'an-unknown-printer-took-a-galley-of-type-and-scrambled-it-to-make-a-type-specimen-book.-It-has-survived-not-only-five-centuries,-but-also-the-leap-into-electr', 1, '12/18/2023', '1', 0x3c703e616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e20497420686173207375727669766564206e6f74206f6e6c7920666976652063656e7475726965732c2062757420616c736f20746865206c65617020696e746f20656c656374726f6e6963207479706573657474696e672c2072656d61696e696e6720657373656e7469616c6c7920756e6368616e6765642e2049742077617320706f70756c61726973656420696e207468652031393630732077697468207468652072656c65617365206f66204c6574726173653c2f703e, 'full time,remote', 0x3c703e616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e20497420686173207375727669766564206e6f74206f6e6c7920666976652063656e7475726965732c2062757420616c736f20746865206c65617020696e746f20656c656374726f6e6963207479706573657474696e672c2072656d61696e696e6720657373656e7469616c6c7920756e6368616e6765642e2049742077617320706f70756c61726973656420696e207468652031393630732077697468207468652072656c65617365206f66204c6574726173653c2f703e, 0x3c703e616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e20497420686173207375727669766564206e6f74206f6e6c7920666976652063656e7475726965732c2062757420616c736f20746865206c65617020696e746f20656c656374726f6e6963207479706573657474696e672c2072656d61696e696e6720657373656e7469616c6c7920756e6368616e6765642e2049742077617320706f70756c61726973656420696e207468652031393630732077697468207468652072656c65617365206f66204c6574726173653c2f703e, NULL, 'Uttara', 0x3c703e616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e20497420686173207375727669766564206e6f74206f6e6c7920666976652063656e7475726965732c2062757420616c736f20746865206c65617020696e746f20656c656374726f6e6963207479706573657474696e672c2072656d61696e696e6720657373656e7469616c6c7920756e6368616e6765642e2049742077617320706f70756c61726973656420696e207468652031393630732077697468207468652072656c65617365206f66204c6574726173653c2f703e, NULL, NULL, 'imranyeasin75@gmail.com', 1, NULL, NULL, '2023-12-04 21:55:55', '2023-12-04 21:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint NOT NULL DEFAULT '1',
  `rtl` tinyint NOT NULL DEFAULT '0' COMMENT '0 - LTR, 1- RTL',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `rtl`, `created_at`, `updated_at`) VALUES
(176, 'English', 'en', 1, 0, '2020-08-07 04:43:05', '2020-12-31 09:22:02'),
(177, 'عربى', 'ar', 0, 1, '2020-08-07 04:51:17', '2020-12-31 09:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `language_id`, `user_id`, `name`, `rank`, `image`, `twitter`, `facebook`, `instagram`, `linkedin`, `feature`, `created_at`, `updated_at`) VALUES
(1, 21, 14, 'الخامس', 'الخامس', 'd97061c078dcb206ab3906dbaf2ffbcd5c2b3701.jpg', 'https://www.facebook.com/', 'https://www.facebook.com/', 'https://www.facebook.com/', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` bigint UNSIGNED NOT NULL,
  `package_price` double NOT NULL DEFAULT '0',
  `discount` double NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) DEFAULT NULL,
  `price` double NOT NULL DEFAULT '0',
  `currency` varchar(255) NOT NULL,
  `currency_symbol` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `is_trial` tinyint(1) NOT NULL DEFAULT '0',
  `trial_days` int NOT NULL DEFAULT '0',
  `receipt` longtext,
  `transaction_details` longtext,
  `settings` longtext,
  `package_id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `modified` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `package_price`, `discount`, `coupon_code`, `price`, `currency`, `currency_symbol`, `payment_method`, `transaction_id`, `status`, `is_trial`, `trial_days`, `receipt`, `transaction_details`, `settings`, `package_id`, `user_id`, `start_date`, `expire_date`, `created_at`, `updated_at`, `modified`) VALUES
(36, 0, 0, NULL, 49, 'USD', '$', 'Flutterwave', '2af05ab6', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"Asia\\/Dhaka\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Amazon AWS s3\\\",\\\"Storage Limit\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 7, '2023-09-10', '2023-10-10', '2023-09-10 02:40:30', '2023-09-10 02:40:30', 0),
(41, 0, 0, NULL, 99, 'USD', '$', 'Flutterwave', 'd113af2d', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"Asia\\/Dhaka\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Amazon AWS s3\\\",\\\"Storage Limit\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 41, 13, '2023-09-10', '2024-09-10', '2023-09-10 11:53:03', '2023-09-10 11:53:03', 0),
(42, 0, 0, NULL, 99, 'USD', '$', 'Stripe', '99b0fc7b', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"Asia\\/Dhaka\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Amazon AWS s3\\\",\\\"Storage Limit\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 41, 14, '2023-09-10', '2023-12-25', '2023-09-10 15:39:02', '2023-12-26 02:43:26', 1),
(60, 0, 0, NULL, 49, 'USD', '$', 'Offline Gateway 2', '79a55e15', 0, 0, 0, NULL, '\"offline\"', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"Asia\\/Dhaka\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 14, '9999-12-31', '2024-11-27', '2023-11-27 11:04:46', '2023-12-25 02:12:17', 1),
(62, 99, 0, NULL, 99, 'USD', '$', 'Stripe', '6dda3502', 1, 0, 0, NULL, '{\"id\":\"ch_3OHoPkJlIV5dN9n70dJnzMbI\",\"object\":\"charge\",\"amount\":9900,\"amount_captured\":9900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3OHoPkJlIV5dN9n70zoukVFR\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1701266816,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are purchasing a membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":{\"customer_name\":\"pratik\"},\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":48,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1OHoPjJlIV5dN9n7bhsbaASY\",\"payment_method_details\":{\"card\":{\"amount_authorized\":9900,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":9900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"pratik.anwar@gmail.com\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KIGLnasGMgYnMJXSJhM6LBYfLjFee7yCdfQjOnIadPMQ-wvg-QpNXHhMfu58Zjda-_YQXmqSIk8AaXzt\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3OHoPkJlIV5dN9n70dJnzMbI\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1OHoPjJlIV5dN9n7bhsbaASY\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"Europe\\/Sarajevo\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 41, 28, '2023-11-29', '9999-12-31', '2023-11-29 09:06:57', '2023-11-29 09:06:57', 0),
(78, 0, 0, NULL, 10, 'USD', '$', 'Flutterwave', '92e3b2c7', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 39, 40, '2023-12-17', '2024-01-17', '2023-12-16 20:35:54', '2023-12-16 20:35:54', 0),
(79, 0, 0, NULL, 10, 'USD', '$', 'Instamojo', 'de9d0aaf', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 39, 42, '2023-12-18', '2024-01-18', '2023-12-18 17:22:26', '2023-12-18 17:22:26', 0),
(80, 49, 0, NULL, 49, 'USD', '$', 'Paypal', 'd84d67f8', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-MWATQNI40T124514D857873X\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"0FE149636U6760205\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"megasoft.envato@gmail.com\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"49.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"49.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"megasoft.envato-facilitator@gmail.com\"\n            },\n            \"description\": \"You are purchasing a membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are purchasing a membership\",\n                        \"price\": \"49.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"4GV93514E7189345L\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"49.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"49.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"2.20\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-MWATQNI40T124514D857873X\",\n                        \"create_time\": \"2023-12-19T06:29:44Z\",\n                        \"update_time\": \"2023-12-19T06:29:44Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/4GV93514E7189345L\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/4GV93514E7189345L/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATQNI40T124514D857873X\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://supervsasso.test/membership/paypal/success?paymentId=PAYID-MWATQNI40T124514D857873X\",\n        \"cancel_url\": \"https://supervsasso.test/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2023-12-19T06:29:09Z\",\n    \"update_time\": \"2023-12-19T06:29:44Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATQNI40T124514D857873X\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 43, '2023-12-18', '2024-12-18', '2023-12-18 17:29:46', '2023-12-18 17:29:46', 0),
(81, 0, 0, NULL, 10, 'USD', '$', 'Paypal', 'c63d0540', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-MWATVSY8DV52813C92968254\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"7BR098217K474334U\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"megasoft.envato@gmail.com\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"id\": \"7157040345310252769\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\",\n                \"type\": \"HOME_OR_WORK\",\n                \"default_address\": false,\n                \"preferred_address\": true,\n                \"primary_address\": true,\n                \"disable_for_transaction\": false\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"10.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"10.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"megasoft.envato-facilitator@gmail.com\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"10.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"id\": \"7157040345310252769\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\",\n                    \"type\": \"HOME_OR_WORK\",\n                    \"default_address\": false,\n                    \"preferred_address\": true,\n                    \"primary_address\": true,\n                    \"disable_for_transaction\": false\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"1G8655083F5906222\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"10.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"10.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"0.84\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-MWATVSY8DV52813C92968254\",\n                        \"create_time\": \"2023-12-19T06:40:21Z\",\n                        \"update_time\": \"2023-12-19T06:40:21Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/1G8655083F5906222\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/1G8655083F5906222/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATVSY8DV52813C92968254\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://supervsasso.test/membership/paypal/success?paymentId=PAYID-MWATVSY8DV52813C92968254\",\n        \"cancel_url\": \"https://supervsasso.test/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2023-12-19T06:40:11Z\",\n    \"update_time\": \"2023-12-19T06:40:21Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATVSY8DV52813C92968254\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 39, 42, '9999-12-31', '2025-01-18', '2023-12-18 17:40:22', '2023-12-18 17:41:03', 1);
INSERT INTO `memberships` (`id`, `package_price`, `discount`, `coupon_code`, `price`, `currency`, `currency_symbol`, `payment_method`, `transaction_id`, `status`, `is_trial`, `trial_days`, `receipt`, `transaction_details`, `settings`, `package_id`, `user_id`, `start_date`, `expire_date`, `created_at`, `updated_at`, `modified`) VALUES
(82, 0, 0, NULL, 49, 'USD', '$', 'Paypal', '46e6ab5b', 1, 0, 0, NULL, '{\n    \"id\": \"PAYID-MWATWDY12F437546J822274S\",\n    \"intent\": \"sale\",\n    \"state\": \"approved\",\n    \"cart\": \"4AH386734J479844W\",\n    \"payer\": {\n        \"payment_method\": \"paypal\",\n        \"status\": \"VERIFIED\",\n        \"payer_info\": {\n            \"email\": \"megasoft.envato@gmail.com\",\n            \"first_name\": \"Samiul Alim\",\n            \"last_name\": \"Pratik\",\n            \"payer_id\": \"8C5NYJ7EZ7QSS\",\n            \"shipping_address\": {\n                \"recipient_name\": \"Samiul Alim Pratik\",\n                \"line1\": \"1 Main St\",\n                \"city\": \"San Jose\",\n                \"state\": \"CA\",\n                \"postal_code\": \"95131\",\n                \"country_code\": \"US\"\n            },\n            \"country_code\": \"US\"\n        }\n    },\n    \"transactions\": [\n        {\n            \"amount\": {\n                \"total\": \"49.00\",\n                \"currency\": \"USD\",\n                \"details\": {\n                    \"subtotal\": \"49.00\",\n                    \"shipping\": \"0.00\",\n                    \"insurance\": \"0.00\",\n                    \"handling_fee\": \"0.00\",\n                    \"shipping_discount\": \"0.00\",\n                    \"discount\": \"0.00\"\n                }\n            },\n            \"payee\": {\n                \"merchant_id\": \"BKNWZYE3MAUNU\",\n                \"email\": \"megasoft.envato-facilitator@gmail.com\"\n            },\n            \"description\": \"You are extending your membership Via Paypal\",\n            \"item_list\": {\n                \"items\": [\n                    {\n                        \"name\": \"You are extending your membership\",\n                        \"price\": \"49.00\",\n                        \"currency\": \"USD\",\n                        \"tax\": \"0.00\",\n                        \"quantity\": 1,\n                        \"image_url\": \"\"\n                    }\n                ],\n                \"shipping_address\": {\n                    \"recipient_name\": \"Samiul Alim Pratik\",\n                    \"line1\": \"1 Main St\",\n                    \"city\": \"San Jose\",\n                    \"state\": \"CA\",\n                    \"postal_code\": \"95131\",\n                    \"country_code\": \"US\"\n                }\n            },\n            \"related_resources\": [\n                {\n                    \"sale\": {\n                        \"id\": \"06688020R0285544X\",\n                        \"state\": \"completed\",\n                        \"amount\": {\n                            \"total\": \"49.00\",\n                            \"currency\": \"USD\",\n                            \"details\": {\n                                \"subtotal\": \"49.00\",\n                                \"shipping\": \"0.00\",\n                                \"insurance\": \"0.00\",\n                                \"handling_fee\": \"0.00\",\n                                \"shipping_discount\": \"0.00\",\n                                \"discount\": \"0.00\"\n                            }\n                        },\n                        \"payment_mode\": \"INSTANT_TRANSFER\",\n                        \"protection_eligibility\": \"ELIGIBLE\",\n                        \"protection_eligibility_type\": \"ITEM_NOT_RECEIVED_ELIGIBLE,UNAUTHORIZED_PAYMENT_ELIGIBLE\",\n                        \"transaction_fee\": {\n                            \"value\": \"2.20\",\n                            \"currency\": \"USD\"\n                        },\n                        \"parent_payment\": \"PAYID-MWATWDY12F437546J822274S\",\n                        \"create_time\": \"2023-12-19T06:41:28Z\",\n                        \"update_time\": \"2023-12-19T06:41:28Z\",\n                        \"links\": [\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/06688020R0285544X\",\n                                \"rel\": \"self\",\n                                \"method\": \"GET\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/sale/06688020R0285544X/refund\",\n                                \"rel\": \"refund\",\n                                \"method\": \"POST\"\n                            },\n                            {\n                                \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATWDY12F437546J822274S\",\n                                \"rel\": \"parent_payment\",\n                                \"method\": \"GET\"\n                            }\n                        ]\n                    }\n                }\n            ]\n        }\n    ],\n    \"redirect_urls\": {\n        \"return_url\": \"https://supervsasso.test/membership/paypal/success?paymentId=PAYID-MWATWDY12F437546J822274S\",\n        \"cancel_url\": \"https://supervsasso.test/membership/paypal/cancel\"\n    },\n    \"create_time\": \"2023-12-19T06:41:19Z\",\n    \"update_time\": \"2023-12-19T06:41:28Z\",\n    \"links\": [\n        {\n            \"href\": \"https://api.sandbox.paypal.com/v1/payments/payment/PAYID-MWATWDY12F437546J822274S\",\n            \"rel\": \"self\",\n            \"method\": \"GET\"\n        }\n    ],\n    \"failed_transactions\": []\n}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 42, '9999-12-31', '2025-01-18', '2023-12-18 17:41:30', '2023-12-18 17:41:48', 1),
(83, 0, 0, NULL, 49, 'USD', '$', 'Offline Gateway 2', '6f183b9d', 0, 0, 0, NULL, '\"offline\"', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 42, '9999-12-31', '2025-01-18', '2023-12-18 17:43:24', '2023-12-18 17:43:52', 1),
(84, 0, 0, NULL, 10, 'USD', '$', 'Cash On Delivery', 'a8f8a1bd', 0, 0, 0, NULL, '\"offline\"', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 39, 42, '2024-01-19', '2025-01-18', '2023-12-18 17:44:07', '2023-12-18 17:44:07', 0),
(85, 0, 0, NULL, 10, 'USD', '$', 'Flutterwave', '9d2670f6', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 39, 44, '2023-12-23', '2024-01-23', '2023-12-23 01:47:23', '2023-12-23 01:47:23', 0),
(88, 0, 0, NULL, 49, 'USD', '$', NULL, '658af49e5d1e9', 1, 0, 0, NULL, NULL, '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 14, '2023-12-26', '2023-12-25', '2023-12-26 02:43:26', '2023-12-26 02:59:46', 1),
(89, 0, 0, NULL, 49, 'USD', '$', 'Stripe', '8370ce92', 1, 0, 0, NULL, '{\"id\":\"ch_3ORcw8JlIV5dN9n71yEA4L7Z\",\"object\":\"charge\",\"amount\":4900,\"amount_captured\":4900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3ORcw8JlIV5dN9n71IFPDUG3\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1703605976,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are extending your membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":45,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1ORcw7JlIV5dN9n7mACBDtUH\",\"payment_method_details\":{\"card\":{\"amount_authorized\":4900,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":4900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"geniustest11@gmail.com1\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KNntq6wGMgYsl39NvyQ6LBZeRl7uXk0_C5HJ3uBSCODGOkMA_3TW0pcbZgHwwOJ9ExoMkfI8SQxmvNFj\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3ORcw8JlIV5dN9n71yEA4L7Z\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1ORcw7JlIV5dN9n7mACBDtUH\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 14, '2023-12-26', '2023-12-25', '2023-12-26 02:52:57', '2023-12-26 03:05:00', 1),
(90, 0, 0, NULL, 99, 'USD', '$', 'Stripe', '5ec32a35', 1, 0, 0, NULL, '{\"id\":\"ch_3ORd79JlIV5dN9n71b7PUzpU\",\"object\":\"charge\",\"amount\":9900,\"amount_captured\":9900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3ORd79JlIV5dN9n71KOa5PNL\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1703606659,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are extending your membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":3,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1ORd78JlIV5dN9n7SUVSG8sm\",\"payment_method_details\":{\"card\":{\"amount_authorized\":9900,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":9900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"geniustest11@gmail.com1\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KIPzq6wGMgZsrg4z_xE6LBbareLr3fy4wJQqo1hd-rxvgEk3-xsWskDlOmlDPuB6CNGTjObpU5yEOVyf\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3ORd79JlIV5dN9n71b7PUzpU\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1ORd78JlIV5dN9n7SUVSG8sm\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 41, 14, '2023-12-26', '2023-12-25', '2023-12-26 03:04:20', '2023-12-26 03:18:11', 0),
(91, 0, 0, NULL, 49, 'USD', '$', 'Stripe', '9aedc815', 1, 0, 0, NULL, '{\"id\":\"ch_3ORdKYJlIV5dN9n71Cz2jBED\",\"object\":\"charge\",\"amount\":4900,\"amount_captured\":4900,\"amount_refunded\":0,\"application\":null,\"application_fee\":null,\"application_fee_amount\":null,\"balance_transaction\":\"txn_3ORdKYJlIV5dN9n717TCIXHh\",\"billing_details\":{\"address\":{\"city\":null,\"country\":null,\"line1\":null,\"line2\":null,\"postal_code\":\"12345\",\"state\":null},\"email\":null,\"name\":null,\"phone\":null},\"calculated_statement_descriptor\":\"Stripe\",\"captured\":true,\"created\":1703607490,\"currency\":\"usd\",\"customer\":null,\"description\":\"You are extending your membership\",\"destination\":null,\"dispute\":null,\"disputed\":false,\"failure_balance_transaction\":null,\"failure_code\":null,\"failure_message\":null,\"fraud_details\":[],\"invoice\":null,\"livemode\":false,\"metadata\":[],\"on_behalf_of\":null,\"order\":null,\"outcome\":{\"network_status\":\"approved_by_network\",\"reason\":null,\"risk_level\":\"normal\",\"risk_score\":63,\"seller_message\":\"Payment complete.\",\"type\":\"authorized\"},\"paid\":true,\"payment_intent\":null,\"payment_method\":\"card_1ORdKXJlIV5dN9n7aT4cPjJp\",\"payment_method_details\":{\"card\":{\"amount_authorized\":4900,\"brand\":\"visa\",\"checks\":{\"address_line1_check\":null,\"address_postal_code_check\":\"pass\",\"cvc_check\":\"pass\"},\"country\":\"US\",\"exp_month\":12,\"exp_year\":2025,\"extended_authorization\":{\"status\":\"disabled\"},\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"incremental_authorization\":{\"status\":\"unavailable\"},\"installments\":null,\"last4\":\"4242\",\"mandate\":null,\"multicapture\":{\"status\":\"unavailable\"},\"network\":\"visa\",\"network_token\":{\"used\":false},\"overcapture\":{\"maximum_amount_capturable\":4900,\"status\":\"unavailable\"},\"three_d_secure\":null,\"wallet\":null},\"type\":\"card\"},\"receipt_email\":\"geniustest11@gmail.com1\",\"receipt_number\":null,\"receipt_url\":\"https:\\/\\/pay.stripe.com\\/receipts\\/payment\\/CAcaFwoVYWNjdF8xQXplbzNKbElWNWROOW43KMP5q6wGMgZQrnoEXLQ6LBbgm5Q3U8R9s9g1pgwLEylUZ7rpCvF43PssgN1HNDMA2HeOBzmuAa0riGgt\",\"refunded\":false,\"refunds\":{\"object\":\"list\",\"data\":[],\"has_more\":false,\"total_count\":0,\"url\":\"\\/v1\\/charges\\/ch_3ORdKYJlIV5dN9n71Cz2jBED\\/refunds\"},\"review\":null,\"shipping\":null,\"source\":{\"id\":\"card_1ORdKXJlIV5dN9n7aT4cPjJp\",\"object\":\"card\",\"address_city\":null,\"address_country\":null,\"address_line1\":null,\"address_line1_check\":null,\"address_line2\":null,\"address_state\":null,\"address_zip\":\"12345\",\"address_zip_check\":\"pass\",\"brand\":\"Visa\",\"country\":\"US\",\"customer\":null,\"cvc_check\":\"pass\",\"dynamic_last4\":null,\"exp_month\":12,\"exp_year\":2025,\"fingerprint\":\"WXDgVUSzrY61Nnm6\",\"funding\":\"credit\",\"last4\":\"4242\",\"metadata\":[],\"name\":null,\"tokenization_method\":null,\"wallet\":null},\"source_transfer\":null,\"statement_descriptor\":null,\"statement_descriptor_suffix\":null,\"status\":\"succeeded\",\"transfer_data\":null,\"transfer_group\":null}', '{\"id\":147,\"language_id\":176,\"cookie_alert_status\":1,\"cookie_alert_text\":\"Your experience on this site will be improved by allowing cookies.\",\"cookie_alert_button_text\":\"Allow Cookies\",\"to_mail\":\"pratik.anwar@gmail.com\",\"default_language_direction\":\"ltr\",\"from_mail\":\"geniustest11@gmail.com\",\"testimonial_img\":\"80529e986bb50427e6e899a33099ca88c531dbd1.png\",\"from_name\":\"Supervsasso\",\"is_smtp\":1,\"smtp_host\":\"smtp.gmail.com\",\"smtp_port\":\"587\",\"encryption\":\"TLS\",\"smtp_username\":\"geniustest11@gmail.com\",\"smtp_password\":\"jvpdiafcjhrznkbm\",\"base_currency_symbol\":\"$\",\"base_currency_symbol_position\":\"left\",\"base_currency_text\":\"USD\",\"base_currency_text_position\":\"right\",\"base_currency_rate\":\"1.00\",\"hero_section_title\":\"Our Platform, Your Success\",\"hero_section_text\":\"Build Your Own Restaurant Website\",\"hero_section_button_text\":\"Explore Plans\",\"hero_section_button_url\":\"https:\\/\\/coursmat.xyz\\/pricing\",\"hero_section_video_url\":\"https:\\/\\/www.youtube.com\\/watch?v=6stlCkUDG_s\",\"hero_img\":\"ce05eaec0a497ff65ff7967dae6bc4b6f100586e.jpg\",\"timezone\":\"America\\/Shiprock\",\"contact_addresses\":\"California, USA\\r\\nLondon, United Kingdom\\r\\nMelbourne, Australia\",\"contact_numbers\":\"+8434197502,+2350575099,+23576039607\",\"contact_mails\":\"contact@example.com,support@example.com,query@example.com\",\"is_whatsapp\":1,\"whatsapp_number\":null,\"whatsapp_header_title\":null,\"whatsapp_popup_message\":null,\"whatsapp_popup\":1,\"domain_request_success_message\":\"We have received your custom domain request. Please allow us 2 business days to connect the domain with our server.\",\"cname_record_section_title\":\"Read Before Sending Custom Domain Request\",\"cname_record_section_text\":\"<ul><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Before sending request for your custom domain, You need to add a CNAME record (given in below table) in your custom domain from your domain registrar account (like - namecheap, godaddy etc...).<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0CNAME record is needed to point your custom domain to our domain ( profilo.xyz ), so that our website can show your portfolio on your domain<\\/span><\\/font><\\/li><li><font color=\\\"#575962\\\"><span style=\\\"font-weight:600;\\\">\\u00a0Different domain registrar (like - godaddy, namecheap etc...) has different interface for adding CNAME record. If you cannot find the place to add CNAME record in your domain registrar account, then please contact your domain registrar support, they will show you the place to add CNAME record for your custom domain<\\/span><\\/font><\\/li><\\/ul>\",\"package_features\":\"[\\\"Custom Domain\\\",\\\"Subdomain\\\",\\\"POS\\\",\\\"Coupon\\\",\\\"Live Orders\\\",\\\"Whatsapp Order & Notification\\\",\\\"QR Menu\\\",\\\"Table Reservation\\\",\\\"Table QR Builder\\\",\\\"Call Waiter\\\",\\\"Staffs\\\",\\\"Blog\\\",\\\"Custom Page\\\",\\\"Online Order\\\",\\\"On Table\\\",\\\"Pick Up\\\",\\\"Home Delivery\\\",\\\"Postal Code Based Delivery Charge\\\",\\\"PWA Installability\\\"]\",\"expiration_reminder\":4,\"max_video_size\":\"40.00\",\"max_file_size\":\"5.00\"}', 40, 14, '2023-12-25', '2024-12-26', '2023-12-26 03:18:11', '2023-12-26 03:18:11', 0);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `menus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `language_id`, `menus`, `created_at`, `updated_at`) VALUES
(107, 177, '[{\"text\":\"منزل\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"القوائم\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"listings\"},{\"text\":\"التسعير\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"pricing\"},{\"text\":\"الصفحات\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"معلومات عنا\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"12\"},{\"text\":\"البنود و الظروف\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"13\"}]},{\"type\":\"blog\",\"text\":\"مدونة او مذكرة\",\"href\":\"\",\"target\":\"_self\"},{\"text\":\"أسئلة وأجوبة\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"},{\"text\":\"اتصال\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2020-12-31 06:36:17', '2020-12-31 06:36:17'),
(129, 176, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Listings\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"listings\"},{\"text\":\"Pricing\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"pricing\"},{\"text\":\"Pages\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"Privacy Policy\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"4\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"},{\"type\":\"faq\",\"text\":\"FAQ\",\"href\":\"\",\"target\":\"_self\"}]', '2024-01-05 15:17:25', '2024-01-05 15:17:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_04_10_155226_add_pos_to_serving_methods', 1),
(5, '2021_04_10_161129_create_pos_payment_methods', 2),
(6, '2021_04_11_075502_create_customers_table', 3),
(7, '2021_04_11_151305_create_tables_table', 4),
(8, '2021_04_16_175547_add_qr_image_to_tables', 5),
(10, '2021_04_16_184950_add_qr_cols_to_table', 6),
(11, '2021_05_06_172702_add_image_to_tables', 7),
(12, '2021_05_06_182658_add_image_size_to_tables', 8),
(13, '2021_05_07_141846_change_defailt_image_size', 9),
(14, '2021_05_07_165729_drop_background_color_from_tables', 10),
(15, '2021_05_07_170622_add_image_position_cols_to_tables', 11),
(17, '2021_05_08_104914_add_type_and_text_cols_to_tables', 12),
(18, '2021_05_08_113457_add_default_value_to_text_color_in_tables', 13),
(19, '2021_05_08_174437_add_default_value_to_text_size_in_tables', 14),
(20, '2021_05_08_194033_add_qr_image_cols_to_basic_extendeds', 15),
(21, '2021_05_10_155349_add_gateway_type_to_product_orders', 16),
(24, '2021_05_11_180827_add_token_no_in_basic_settings', 17),
(25, '2021_05_11_181941_add_token_no_after_order_number_in_product_orders', 17),
(28, '2021_05_13_083313_create_postal_codes_table', 18),
(29, '2021_05_13_101831_add_postal_code_to_basic_settings', 19),
(32, '2021_05_16_105019_add_postal_code_to_product_orders', 20),
(33, '2021_05_18_130916_add_call_waiter_status_to_basic_settings', 21),
(34, '2021_05_18_194729_add_contact_infos_to_basic_settings', 22),
(36, '2021_05_19_081335_create_popups_table', 23),
(37, '2021_05_19_122217_drop_announcement_cols_from_basic_settings', 24),
(38, '2021_05_19_125220_drop_parent_link_col_from_basic_settings', 25),
(40, '2021_05_19_125534_add_whatsapp_chat_cols_to_basic_settings', 26),
(41, '2021_05_20_120604_add_order_close_cols_to_basic_extendeds', 27),
(42, '2022_03_13_165621_create_psub_categories_table', 28),
(43, '2022_03_13_180650_add_subcategory_id_to_products_table', 28),
(44, '2022_03_17_131144_add_free_delivery_amount_to_postal_codes', 29),
(45, '2022_03_17_194525_add_free_delivery_amount_to_shipping_charges', 30),
(46, '2022_04_18_133021_create_basic_extras', 31),
(49, '2022_04_19_155032_add_country_code_to_users_table', 32),
(51, '2022_04_21_120742_add_country_code_in_product_orders', 33),
(52, '2022_04_23_124847_add_whatsapp_order_notification_based_on_serving_methods', 34),
(53, '2022_04_23_144354_add_twilio_credentials_in_basic_extras', 35),
(54, '2022_05_25_195401_add_is_feature_in_psub_categories', 36),
(55, '2023_09_18_160526_add_token_to_admins', 37),
(56, '2023_09_18_160606_add_pass_token_to_users', 37);

-- --------------------------------------------------------

--
-- Table structure for table `offline_gateways`
--

CREATE TABLE `offline_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `instructions` blob,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial_number` int NOT NULL DEFAULT '0',
  `is_receipt` tinyint NOT NULL DEFAULT '1',
  `receipt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offline_gateways`
--

INSERT INTO `offline_gateways` (`id`, `name`, `short_description`, `instructions`, `status`, `serial_number`, `is_receipt`, `receipt`, `created_at`, `updated_at`) VALUES
(1, 'Offline Gateway 1', 'Please send your payment to the following account.\r\nBank Name: Lorem Ipsum.\r\nBeneficiary Name: John Doe.\r\nAccount Number/IBAN: 12345678', 0x3c70207374796c653d226c696e652d6865696768743a20312e383b223e3c666f6e7420666163653d2243697263756c61725374642d426f6f6b2c20417269616c2c2073616e732d7365726966223e43686173652042616e6b2069732074686520636f6e73756d65722062616e6b696e67206469766973696f6e206f66204a504d6f7267616e2043686173652e20556e6c696b652069747320636f6d70657469746f72732c2043686173652069732074616b696e6720737465707320746f20657870616e6420697473206272616e6368206e6574776f726b20696e206b6579206d61726b6574732e205468652062616e6b2063757272656e746c7920686173206e6561726c7920352c303030206272616e6368657320616e642031362c3030302041544d732e204163636f7264696e6720746f207468652062616e6b2c206e6561726c792068616c66206f662074686520636f756e747279e280997320686f757365686f6c64732061726520436861736520637573746f6d6572732e3c2f666f6e743e3c62723e3c2f703e, 1, 1, 1, NULL, '2020-09-17 01:06:39', '2021-01-01 02:12:12'),
(2, 'Offline Gateway 2', 'Please send your payment to the following account.\r\nBank Name: Lorem Ipsum.\r\nBeneficiary Name: John Doe.\r\nAccount Number/IBAN: 12345678', 0x3c70207374796c653d226c696e652d6865696768743a20312e383b223e3c7370616e207374796c653d22666f6e742d66616d696c793a2043697263756c61725374642d426f6f6b2c20417269616c2c2073616e732d73657269663b20666f6e742d73697a653a20313470783b223e42616e6b206f6620416d6572696361207365727665732061626f7574203636206d696c6c696f6e20636f6e73756d65727320616e6420736d616c6c20627573696e65737320636c69656e747320776f726c64776964652e204c696b65206d616e79206f662074686520626967676573742062616e6b732c2042616e6b206f6620416d6572696361206973206b6e6f776e20666f7220697473206469676974616c20696e6e6f766174696f6e2e20497420686173206d6f7265207468616e203337206d696c6c696f6e206469676974616c20636c69656e747320616e6420697320657870657269656e63696e67207375636365737320616674657220696e74726f647563696e6720697473207669727475616c20617373697374616e742c2045726963612c20746861742061737369737473206163636f756e7420686f6c64657273207769746820766172696f7573207461736b733c2f7370616e3e3c62723e3c2f703e, 1, 2, 0, NULL, '2020-09-17 01:07:37', '2021-01-01 02:12:22'),
(3, 'Cash On Delivery', NULL, 0x3c703e3c62723e3c2f703e, 0, 3, 0, NULL, '2020-09-17 02:05:36', '2023-06-07 10:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `product_order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `variations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `addons` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `variations_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `addons_price` decimal(11,2) NOT NULL,
  `product_price` decimal(11,2) NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `product_order_id`, `product_id`, `user_id`, `customer_id`, `title`, `qty`, `image`, `variations`, `addons`, `variations_price`, `addons_price`, `product_price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 21.00, 27.00, '2023-09-12 10:08:47', NULL),
(2, 1, 23, 14, 1, 'Variation + Addon Item', 2, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 12.00, 12.00, 24.00, 48.00, '2023-09-12 10:08:47', NULL),
(3, 1, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-12 10:08:47', NULL),
(4, 1, 25, 14, 1, 'Only Variation', 6, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 42.00, 0.00, 36.00, 78.00, '2023-09-12 10:08:47', NULL),
(5, 1, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-09-12 10:08:47', NULL),
(6, 1, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-09-12 10:08:47', NULL),
(7, 2, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 21.00, 27.00, '2023-09-12 10:16:40', NULL),
(8, 2, 23, 14, 1, 'Variation + Addon Item', 2, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 12.00, 12.00, 24.00, 48.00, '2023-09-12 10:16:40', NULL),
(9, 2, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-12 10:16:40', NULL),
(10, 2, 25, 14, 1, 'Only Variation', 6, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 42.00, 0.00, 36.00, 78.00, '2023-09-12 10:16:40', NULL),
(11, 2, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-09-12 10:16:40', NULL),
(12, 2, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-09-12 10:16:40', NULL),
(13, 3, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 21.00, 27.00, '2023-09-12 10:26:12', NULL),
(14, 3, 23, 14, 1, 'Variation + Addon Item', 2, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 12.00, 12.00, 24.00, 48.00, '2023-09-12 10:26:12', NULL),
(15, 3, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-12 10:26:12', NULL),
(16, 3, 25, 14, 1, 'Only Variation', 6, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 42.00, 0.00, 36.00, 78.00, '2023-09-12 10:26:12', NULL),
(17, 3, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-09-12 10:26:12', NULL),
(18, 3, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-09-12 10:26:12', NULL),
(19, 4, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 21.00, 27.00, '2023-09-12 10:29:16', NULL),
(20, 4, 23, 14, 1, 'Variation + Addon Item', 2, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 12.00, 12.00, 24.00, 48.00, '2023-09-12 10:29:16', NULL),
(21, 4, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-12 10:29:16', NULL),
(22, 4, 25, 14, 1, 'Only Variation', 6, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 42.00, 0.00, 36.00, 78.00, '2023-09-12 10:29:16', NULL),
(23, 4, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-09-12 10:29:16', NULL),
(24, 4, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-09-12 10:29:16', NULL),
(25, 5, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 21.00, 27.00, '2023-09-12 10:30:30', NULL),
(26, 5, 23, 14, 1, 'Variation + Addon Item', 2, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 12.00, 12.00, 24.00, 48.00, '2023-09-12 10:30:30', NULL),
(27, 5, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-12 10:30:30', NULL),
(28, 5, 25, 14, 1, 'Only Variation', 6, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 42.00, 0.00, 36.00, 78.00, '2023-09-12 10:30:30', NULL),
(29, 5, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-09-12 10:30:30', NULL),
(30, 5, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-09-12 10:30:30', NULL),
(31, 6, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:02:11', NULL),
(32, 6, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:02:11', NULL),
(33, 7, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:06:34', NULL),
(34, 7, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:06:34', NULL),
(35, 8, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:07:33', NULL),
(36, 8, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:07:33', NULL),
(37, 9, 25, 14, NULL, 'Only Variation', 1, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 2.00, 0.00, 6.00, 8.00, '2023-09-13 16:14:20', NULL),
(38, 9, 24, 14, NULL, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 16:14:20', NULL),
(39, 10, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:16:33', NULL),
(40, 10, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:16:33', NULL),
(41, 11, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:17:06', NULL),
(42, 11, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:17:06', NULL),
(43, 12, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:18:05', NULL),
(44, 12, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:18:05', NULL),
(45, 13, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:18:47', NULL),
(46, 13, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:18:47', NULL),
(47, 14, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:19:30', NULL),
(48, 14, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:19:30', NULL),
(49, 15, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:20:04', NULL),
(50, 15, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:20:04', NULL),
(51, 16, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:21:27', NULL),
(52, 16, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:21:27', NULL),
(53, 17, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:22:05', NULL),
(54, 17, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:22:05', NULL),
(55, 18, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:22:32', NULL),
(56, 18, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:22:32', NULL),
(57, 19, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:23:10', NULL),
(58, 19, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:23:10', NULL),
(59, 20, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:24:55', NULL),
(60, 20, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:24:55', NULL),
(61, 21, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:29:46', NULL),
(62, 21, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:29:46', NULL),
(63, 22, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:30:45', NULL),
(64, 22, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:30:45', NULL),
(65, 23, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:32:25', NULL),
(66, 23, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:32:25', NULL),
(67, 24, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:35:14', NULL),
(68, 24, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:35:14', NULL),
(69, 25, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:36:07', NULL),
(70, 25, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:36:07', NULL),
(71, 26, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:36:34', NULL),
(72, 26, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:36:34', NULL),
(73, 27, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:37:23', NULL),
(74, 27, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:37:23', NULL),
(75, 28, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 10:38:05', NULL),
(76, 28, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 10:38:05', NULL),
(77, 29, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-13 12:14:32', NULL),
(78, 29, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-09-13 12:14:32', NULL),
(79, 30, 24, 14, NULL, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-09-27 16:25:26', NULL),
(81, 32, 26, 14, 1, 'Only Addon', 1, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"noodles\",\"price\":\"5.00\"},{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 8.00, 7.00, 15.00, '2023-10-10 04:42:53', NULL),
(82, 33, 26, 14, 1, 'Only Addon', 2, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 4.00, 14.00, 18.00, '2023-10-16 09:55:50', NULL),
(83, 33, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-10-16 09:55:50', NULL),
(84, 33, 26, 14, 1, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-10-16 09:55:50', NULL),
(85, 34, 24, 14, 1, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-10-16 09:57:02', NULL),
(86, 34, 26, 14, 1, 'Only Addon', 1, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '\"\"', 0.00, 0.00, 7.00, 7.00, '2023-10-16 09:57:02', NULL),
(87, 35, 26, 14, 1, 'Only Addon', 4, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"noodles\",\"price\":\"5.00\"},{\"name\":\"Patty\",\"price\":\"1.00\"}]', 0.00, 24.00, 28.00, 52.00, '2023-10-20 03:41:36', NULL),
(88, 35, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"8 GB\",\"price\":4},\"Color Family\":{\"name\":\"White\",\"price\":3}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-10-20 03:41:36', NULL),
(89, 35, 24, 14, 1, 'No Variation + No Addon', 3, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 27.00, 27.00, '2023-10-20 03:41:36', NULL),
(90, 35, 25, 14, 1, 'Only Variation', 3, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6},\"Spice Level en\":{\"name\":\"Standard\",\"price\":0}}', '[{\"name\":\"Spicy Patty\",\"price\":\"1.00\"},{\"name\":\"Spicy Egg\",\"price\":\"2.00\"}]', 21.00, 9.00, 18.00, 48.00, '2023-10-20 03:41:36', NULL),
(91, 36, 25, 14, 1, 'Only Variation', 4, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"White\",\"price\":3}}', '\"\"', 16.00, 0.00, 24.00, 40.00, '2023-10-20 05:17:20', NULL),
(92, 36, 27, 14, 1, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-10-20 05:17:20', NULL),
(93, 37, 25, 14, 1, 'Only Variation', 4, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"White\",\"price\":3}}', '\"\"', 16.00, 0.00, 24.00, 40.00, '2023-10-20 05:28:58', NULL),
(94, 37, 27, 14, 1, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-10-20 05:28:58', NULL),
(95, 38, 27, 14, 1, 'galley of type and scrambled it to', 2, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 48.00, 48.00, '2023-10-20 07:50:58', NULL),
(96, 39, 27, 14, 1, 'galley of type and scrambled it to', 2, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 48.00, 48.00, '2023-10-20 07:56:50', NULL),
(97, 40, 27, 14, 1, 'galley of type and scrambled it to', 2, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 48.00, 48.00, '2023-10-20 07:58:21', NULL),
(98, 40, 23, 14, 1, 'Variation + Addon Item', 1, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '\"\"', 6.00, 0.00, 12.00, 18.00, '2023-10-20 07:58:21', NULL),
(99, 41, 27, 14, NULL, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-10-20 14:02:59', NULL),
(100, 42, 23, 14, 1, 'Variation + Addon Item', 3, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Basic\",\"price\":2}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 15.00, 18.00, 36.00, 69.00, '2023-10-20 09:33:08', NULL),
(101, 42, 24, 14, 1, 'No Variation + No Addon', 2, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 18.00, 18.00, '2023-10-20 09:33:08', NULL),
(102, 42, 25, 14, 1, 'Only Variation', 2, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 4.00, 0.00, 12.00, 16.00, '2023-10-20 09:33:08', NULL),
(103, 42, 26, 14, 1, 'Only Addon', 2, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 14.00, 20.00, '2023-10-20 09:33:08', NULL),
(104, 43, 27, 14, 1, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-10-20 09:56:42', NULL),
(105, 43, 23, 14, 1, 'Variation + Addon Item', 1, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '\"\"', 6.00, 0.00, 12.00, 18.00, '2023-10-20 09:56:42', NULL),
(106, 44, 26, 14, 1, 'Only Addon', 2, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 14.00, 20.00, '2023-10-24 08:48:16', NULL),
(107, 44, 27, 14, 1, 'galley of type and scrambled it to', 2, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 48.00, 48.00, '2023-10-24 08:48:16', NULL),
(108, 45, 25, 14, 1, 'Only Variation', 1, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 2.00, 0.00, 6.00, 8.00, '2023-10-24 08:50:35', NULL),
(109, 45, 26, 14, 1, 'Only Addon', 4, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '\"\"', 0.00, 0.00, 28.00, 28.00, '2023-10-24 08:50:35', NULL),
(110, 45, 27, 14, 1, 'galley of type and scrambled it to', 2, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 48.00, 48.00, '2023-10-24 08:50:35', NULL),
(111, 46, 26, 14, 1, 'Only Addon', 2, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 6.00, 14.00, 20.00, '2023-10-24 08:53:48', NULL),
(112, 46, 23, 14, 1, 'Variation + Addon Item', 1, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '\"\"', 6.00, 0.00, 12.00, 18.00, '2023-10-24 08:53:48', NULL),
(113, 46, 25, 14, 1, 'Only Variation', 1, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 2.00, 0.00, 6.00, 8.00, '2023-10-24 08:53:48', NULL),
(114, 47, 27, 14, 1, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-10-24 08:55:46', NULL),
(115, 47, 26, 14, 1, 'Only Addon', 1, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '\"\"', 0.00, 0.00, 7.00, 7.00, '2023-10-24 08:55:46', NULL),
(116, 48, 23, 14, NULL, 'Variation + Addon Item', 3, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Egg\",\"price\":\"7.00\"}]', 18.00, 21.00, 36.00, 75.00, '2023-11-28 13:00:34', NULL),
(117, 48, 24, 14, NULL, 'No Variation + No Addon', 2, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 18.00, 18.00, '2023-11-28 13:00:34', NULL),
(118, 49, 27, 14, NULL, 'galley of type and scrambled it to', 1, '8acf4e31320d4e23b8be84cc122bf0518a8d726b.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-11-28 13:03:37', NULL),
(119, 49, 24, 14, NULL, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-11-28 13:03:37', NULL),
(120, 49, 26, 14, NULL, 'Only Addon', 3, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 9.00, 21.00, 30.00, '2023-11-28 13:03:37', NULL),
(121, 50, 24, 14, 6, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-12-07 04:06:10', NULL),
(122, 51, 24, 14, 6, 'No Variation + No Addon', 1, '1f7d139151349fbb4258df28409edacfb40411e1.jpg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-12-07 04:30:19', NULL),
(123, 51, 27, 14, 6, 'galley of type and scrambled it to', 1, '4837dbbcdb47e9e1439c4950580e5cf44c91a334.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-12-07 04:30:19', NULL),
(124, 52, 27, 14, 5, 'galley of type and scrambled it to', 1, '4837dbbcdb47e9e1439c4950580e5cf44c91a334.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-12-07 04:50:29', NULL),
(125, 53, 23, 14, NULL, 'Variation + Addon Item', 1, 'f2d5a0fa4f20a7052862f31bf3d9203d1ba1fd77.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"}]', 6.00, 4.00, 12.00, 22.00, '2023-12-09 03:29:40', NULL),
(126, 54, 25, 14, NULL, 'Only Variation', 1, '2d5fde7eb29e66ffd8412a90b4d09e68ac913cbb.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 7.00, 0.00, 6.00, 13.00, '2023-12-09 04:58:52', NULL),
(127, 55, 26, 14, NULL, 'Only Addon', 1, 'cda5cc012c3877209b2a4a6393c7b1ecdba3ec1f.jpg', '[]', '[{\"name\":\"noodles\",\"price\":\"5.00\"},{\"name\":\"Patty\",\"price\":\"1.00\"}]', 0.00, 6.00, 7.00, 13.00, '2023-12-09 05:14:12', NULL),
(128, 56, 26, 14, 5, 'Only Addon', 1, '1454e82a43a2e9e7ed1656c7ecfd74aafb468e92.jpg', '[]', '[{\"name\":\"noodles\",\"price\":\"5.00\"},{\"name\":\"Patty\",\"price\":\"1.00\"},{\"name\":\"bun\",\"price\":\"2.00\"}]', 0.00, 8.00, 7.00, 15.00, '2023-12-09 08:23:32', NULL),
(129, 56, 23, 14, 5, 'Variation + Addon Item', 1, 'cc3110ebab07c0637b4ad5379ad9256460b86760.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"}]', 6.00, 4.00, 12.00, 22.00, '2023-12-09 08:23:32', NULL),
(130, 56, 27, 14, 5, 'galley of type and scrambled it to', 1, '4837dbbcdb47e9e1439c4950580e5cf44c91a334.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-12-09 08:23:32', NULL),
(131, 56, 28, 14, 5, 'It is a long established fact that a reader will be', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-09 08:23:32', NULL),
(132, 57, 23, 14, 5, 'Variation + Addon Item ar', 1, 'cc3110ebab07c0637b4ad5379ad9256460b86760.jpg', '{\"Color ar\":{\"name\":\"Black\",\"price\":1},\"Size ar\":{\"name\":\"Regular\",\"price\":2},\"Type ar\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"},{\"name\":\"Patty\",\"price\":\"2.00\"}]', 6.00, 6.00, 12.00, 24.00, '2023-12-11 06:07:02', NULL),
(133, 58, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 01:34:10', NULL),
(134, 59, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 01:45:10', NULL),
(135, 60, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 06:50:24', NULL),
(136, 61, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 03:50:50', NULL),
(137, 62, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-12 19:54:00', NULL),
(138, 63, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 06:54:36', NULL),
(139, 64, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-13 06:56:19', NULL),
(140, 65, 23, 14, NULL, 'Variation + Addon Item', 1, 'cc3110ebab07c0637b4ad5379ad9256460b86760.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Patty\",\"price\":\"2.00\"}]', 6.00, 2.00, 12.00, 20.00, '2023-12-17 05:44:35', NULL),
(142, 67, 34, 14, 6, 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 1, '03bb966b9b5d76c0d380a16fcca41264575c5b2f.png', '\"\"', '\"\"', 0.00, 0.00, 20.00, 20.00, '2023-12-19 07:05:07', NULL),
(143, 68, 34, 14, NULL, 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 1, '03bb966b9b5d76c0d380a16fcca41264575c5b2f.png', '\"\"', '\"\"', 0.00, 0.00, 20.00, 20.00, '2023-12-23 07:37:05', NULL),
(144, 68, 28, 14, NULL, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 2, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 154.00, 154.00, '2023-12-23 07:37:05', NULL),
(145, 68, 27, 14, NULL, 'galley of type and scrambled it to', 1, '4837dbbcdb47e9e1439c4950580e5cf44c91a334.jpg', '\"\"', '\"\"', 0.00, 0.00, 24.00, 24.00, '2023-12-23 07:37:05', NULL),
(146, 68, 25, 14, NULL, 'Only Variation', 3, '5deac9b853f5142917fec3d2be5b191fdc015826.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Red\",\"price\":6}}', '\"\"', 21.00, 0.00, 18.00, 39.00, '2023-12-23 07:37:05', NULL),
(147, 68, 25, 14, NULL, 'Only Variation', 7, '5deac9b853f5142917fec3d2be5b191fdc015826.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"White\",\"price\":3}}', '\"\"', 28.00, 0.00, 42.00, 70.00, '2023-12-23 07:37:05', NULL),
(148, 68, 26, 14, NULL, 'Only Addon', 3, '1454e82a43a2e9e7ed1656c7ecfd74aafb468e92.jpg', '[]', '[{\"name\":\"Patty\",\"price\":\"1.00\"}]', 0.00, 3.00, 21.00, 24.00, '2023-12-23 07:37:05', NULL),
(149, 68, 24, 14, NULL, 'No Variation + No Addon', 1, '3ed16f26df2b8c8e36ca0d0b6db78bf60495caf9.jpeg', '\"\"', '\"\"', 0.00, 0.00, 9.00, 9.00, '2023-12-23 07:37:05', NULL),
(150, 68, 23, 14, NULL, 'Variation + Addon Item', 1, 'cc3110ebab07c0637b4ad5379ad9256460b86760.jpg', '{\"Color\":{\"name\":\"Black\",\"price\":1},\"Size\":{\"name\":\"Regular\",\"price\":2},\"Type\":{\"name\":\"Standard\",\"price\":3}}', '[{\"name\":\"Chesse\",\"price\":\"4.00\"}]', 6.00, 4.00, 12.00, 22.00, '2023-12-23 07:37:05', NULL),
(151, 69, 25, 14, NULL, 'Only Variation', 4, '5deac9b853f5142917fec3d2be5b191fdc015826.jpg', '{\"RAM\":{\"name\":\"1GB\",\"price\":1},\"Color Family\":{\"name\":\"Black\",\"price\":1}}', '\"\"', 8.00, 0.00, 24.00, 32.00, '2023-12-26 05:08:06', NULL),
(156, 80, 28, 14, 5, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 1, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '\"\"', '\"\"', 0.00, 0.00, 77.00, 77.00, '2023-12-30 12:05:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_times`
--

CREATE TABLE `order_times` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `day` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_times`
--

INSERT INTO `order_times` (`id`, `user_id`, `day`, `start_time`, `end_time`) VALUES
(183, 7, 'monday', NULL, NULL),
(184, 7, 'tuesday', NULL, NULL),
(185, 7, 'wednesday', NULL, NULL),
(186, 7, 'thursday', NULL, NULL),
(187, 7, 'friday', NULL, NULL),
(188, 7, 'saturday', NULL, NULL),
(189, 7, 'sunday', NULL, NULL),
(218, 13, 'monday', NULL, NULL),
(219, 13, 'tuesday', NULL, NULL),
(220, 13, 'wednesday', NULL, NULL),
(221, 13, 'thursday', NULL, NULL),
(222, 13, 'friday', NULL, NULL),
(223, 13, 'saturday', NULL, NULL),
(224, 13, 'sunday', NULL, NULL),
(225, 14, 'monday', '9:35 AM', '5:35 PM'),
(226, 14, 'tuesday', '8:36 AM', '10:11 PM'),
(227, 14, 'wednesday', '9:14 AM', '1:00 PM'),
(228, 14, 'thursday', '9:36 AM', '3:36 PM'),
(229, 14, 'friday', '10:36 AM', '3:36 PM'),
(230, 14, 'saturday', '8:37 AM', '8:37 PM'),
(231, 14, 'sunday', '6:37 AM', '6:37 PM'),
(246, 28, 'monday', NULL, NULL),
(247, 28, 'tuesday', NULL, NULL),
(248, 28, 'wednesday', NULL, NULL),
(249, 28, 'thursday', NULL, NULL),
(250, 28, 'friday', NULL, NULL),
(251, 28, 'saturday', NULL, NULL),
(252, 28, 'sunday', NULL, NULL),
(330, 40, 'monday', NULL, NULL),
(331, 40, 'tuesday', NULL, NULL),
(332, 40, 'wednesday', NULL, NULL),
(333, 40, 'thursday', NULL, NULL),
(334, 40, 'friday', NULL, NULL),
(335, 40, 'saturday', NULL, NULL),
(336, 40, 'sunday', NULL, NULL),
(337, 42, 'monday', NULL, NULL),
(338, 42, 'tuesday', NULL, NULL),
(339, 42, 'wednesday', NULL, NULL),
(340, 42, 'thursday', NULL, NULL),
(341, 42, 'friday', NULL, NULL),
(342, 42, 'saturday', NULL, NULL),
(343, 42, 'sunday', NULL, NULL),
(344, 43, 'monday', NULL, NULL),
(345, 43, 'tuesday', NULL, NULL),
(346, 43, 'wednesday', NULL, NULL),
(347, 43, 'thursday', NULL, NULL),
(348, 43, 'friday', NULL, NULL),
(349, 43, 'saturday', NULL, NULL),
(350, 43, 'sunday', NULL, NULL),
(351, 44, 'monday', NULL, NULL),
(352, 44, 'tuesday', NULL, NULL),
(353, 44, 'wednesday', NULL, NULL),
(354, 44, 'thursday', NULL, NULL),
(355, 44, 'friday', NULL, NULL),
(356, 44, 'saturday', NULL, NULL),
(357, 44, 'sunday', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `term` varchar(255) DEFAULT NULL,
  `featured` enum('0','1') NOT NULL DEFAULT '0',
  `is_trial` enum('0','1') NOT NULL DEFAULT '0',
  `trial_days` int DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `recommended` enum('0','1') NOT NULL DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `storage_limit` int DEFAULT '999999',
  `staff_limit` int DEFAULT '999999',
  `order_limit` int NOT NULL DEFAULT '999999',
  `categories_limit` int DEFAULT '999999',
  `subcategories_limit` int DEFAULT '999999',
  `items_limit` int DEFAULT '999999',
  `table_reservation_limit` int DEFAULT '999999',
  `language_limit` float DEFAULT '999999',
  `features` text,
  `meta_keywords` longtext,
  `meta_description` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `slug`, `price`, `term`, `featured`, `is_trial`, `trial_days`, `status`, `recommended`, `icon`, `storage_limit`, `staff_limit`, `order_limit`, `categories_limit`, `subcategories_limit`, `items_limit`, `table_reservation_limit`, `language_limit`, `features`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(39, 'Basic', 'Basic', 10, 'month', '1', '1', 15, '1', '0', 'fas fa-cubes', 999999, 3, 55, 12, 13, 10, 999999, 4, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\"]', 'basic,package', NULL, '2022-08-08 23:15:10', '2023-12-23 01:49:03'),
(40, 'Pro', 'Pro', 49, 'month', '1', '0', NULL, '1', '0', 'far fa-gem', 999999, 999999, 999999, 999, 999999, 999999, 999999, 999999, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\"]', NULL, NULL, '2022-12-06 09:04:43', '2024-01-04 15:00:26'),
(41, 'Beginner Plan', 'Beginner-Plan', 99, 'lifetime', '1', '1', 15, '1', '0', 'fas fa-cubes', 10000, 99, 6, 9999, 99, 9999, 8, 99, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\"]', 'beginner,plan', NULL, '2022-12-14 20:28:22', '2023-12-26 03:06:19'),
(42, 'lorem ipsum', 'lorem-ipsum', 566, 'lifetime', '1', '1', 7, '1', '1', 'fab fa-affiliatetheme', 999999, 999999, 999999, 5, 5, 5, 999999, 4, '[\"Storage Limit\",\"Live Orders\"]', NULL, NULL, '2023-12-26 00:14:32', '2023-12-26 00:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` blob,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial_number` int NOT NULL DEFAULT '0',
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `language_id`, `name`, `title`, `subtitle`, `slug`, `body`, `status`, `serial_number`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 176, 'About Us', 'About Us', 'About Us', 'About-Us', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e, 1, 1, NULL, NULL, '2020-08-21 04:06:16', '2020-08-29 04:27:29'),
(3, 176, 'Terms & Conditions', 'Terms & Conditions', 'Terms & Conditions', 'Terms-&-Conditions', 0x69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b, 1, 2, NULL, NULL, '2020-08-21 04:06:16', '2020-08-30 02:06:33'),
(4, 176, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', 'Privacy-Policy', 0x3c703e4c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e672020696e6475737472792e200a0a4c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e200a0a4c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e0a0a204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e69732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b2e2069732073696d706c792064756d6d792074657874206f6620746865207072696e74696e6720616e64207479706573657474696e6720696e6475737472792e204c6f72656d20497073756d20686173206265656e2074686520696e6475737472792773207374616e646172642064756d6d79207465787420657665722073696e6365207468652031353030732c207768656e20616e20756e6b6e6f776e207072696e74657220746f6f6b20612067616c6c6579206f66207479706520616e6420736372616d626c656420697420746f206d616b65206120747970652073706563696d656e20626f6f6b3c2f703e, 1, 3, NULL, NULL, '2020-08-21 04:06:16', '2020-09-07 18:47:30'),
(5, 177, 'معلومات عنا', 'معلومات عنا', 'معلومات عنا', 'معلومات-عنا', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, 1, 1, NULL, NULL, '2020-08-30 02:07:32', '2020-08-30 02:07:32'),
(6, 177, 'البنود و الظروف', 'البنود و الظروف', 'البنود و الظروف', 'البنود-و-الظروف', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, 1, 2, NULL, NULL, '2020-08-30 02:09:42', '2020-08-30 02:09:42'),
(7, 177, 'سياسة خاصة', 'سياسة خاصة', 'سياسة خاصة', 'سياسة-خاصة', 0xd987d986d8a7d98320d8add982d98ad982d8a920d985d8abd8a8d8aad8a920d985d986d8b020d8b2d985d98620d8b7d988d98ad98420d988d987d98a20d8a3d98620d8a7d984d985d8add8aad988d98920d8a7d984d985d982d8b1d988d8a120d984d8b5d981d8add8a920d985d8a720d8b3d98ad984d987d98a20d8a7d984d982d8a7d8b1d8a620d8b9d98620d8a7d984d8aad8b1d983d98ad8b220d8b9d984d98920d8a7d984d8b4d983d98420d8a7d984d8aed8a7d8b1d8acd98a20d984d984d986d8b520d8a3d98820d8b4d983d98420d8aad988d8b6d8b920d8a7d984d981d982d8b1d8a7d8aa20d981d98a20d8a7d984d8b5d981d8add8a920d8a7d984d8aad98a20d98ad982d8b1d8a3d987d8a72e20d988d984d8b0d984d98320d98ad8aad98520d8a7d8b3d8aad8aed8afd8a7d98520d8b7d8b1d98ad982d8a920d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d984d8a3d986d987d8a720d8aad8b9d8b7d98a20d8aad988d8b2d98ad8b9d8a7d98e20d8b7d8a8d98ad8b9d98ad8a7d98e202dd8a5d984d98920d8add8af20d985d8a72d20d984d984d8a3d8add8b1d98120d8b9d988d8b6d8a7d98b20d8b9d98620d8a7d8b3d8aad8aed8afd8a7d9852022d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98ad88c20d987d986d8a720d98ad988d8acd8af20d985d8add8aad988d98920d986d8b5d98a2220d981d8aad8acd8b9d984d987d8a720d8aad8a8d8afd9882028d8a3d98a20d8a7d984d8a3d8add8b1d9812920d988d983d8a3d986d987d8a720d986d8b520d985d982d8b1d988d8a12e20d8a7d984d8b9d8afd98ad8af20d985d98620d8a8d8b1d8a7d985d8ad20d8a7d984d986d8b4d8b120d8a7d984d985d983d8aad8a8d98a20d988d8a8d8b1d8a7d985d8ad20d8aad8add8b1d98ad8b120d8b5d981d8add8a7d8aa20d8a7d984d988d98ad8a820d8aad8b3d8aad8aed8afd98520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8a8d8b4d983d98420d8a5d981d8aad8b1d8a7d8b6d98a20d983d986d985d988d8b0d8ac20d8b9d98620d8a7d984d986d8b5d88c20d988d8a5d8b0d8a720d982d985d8aa20d8a8d8a5d8afd8aed8a7d98420226c6f72656d20697073756d2220d981d98a20d8a3d98a20d985d8add8b1d98320d8a8d8add8ab20d8b3d8aad8b8d987d8b120d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d985d988d8a7d982d8b920d8a7d984d8add8afd98ad8abd8a920d8a7d984d8b9d987d8af20d981d98a20d986d8aad8a7d8a6d8ac20d8a7d984d8a8d8add8ab2e20d8b9d984d98920d985d8afd98920d8a7d984d8b3d986d98ad98620d8b8d987d8b1d8aa20d986d8b3d8ae20d8acd8afd98ad8afd8a920d988d985d8aed8aad984d981d8a920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b7d8b1d98ad98220d8a7d984d8b5d8afd981d8a9d88c20d988d8a3d8add98ad8a7d986d8a7d98b20d8b9d98620d8b9d985d8af20d983d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d8b9d8a8d8a7d8b1d8a7d8aa20d8a7d984d981d983d8a7d987d98ad8a920d8a5d984d98ad987d8a72e20d987d986d8a7d984d98320d8a7d984d8b9d8afd98ad8af20d985d98620d8a7d984d8a3d986d988d8a7d8b920d8a7d984d985d8aad988d981d8b1d8a920d984d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d985d88c20d988d984d983d98620d8a7d984d8bad8a7d984d8a8d98ad8a920d8aad98520d8aad8b9d8afd98ad984d987d8a720d8a8d8b4d983d98420d985d8a720d8b9d8a8d8b120d8a5d8afd8aed8a7d98420d8a8d8b9d8b620d8a7d984d986d988d8a7d8afd8b120d8a3d98820d8a7d984d983d984d985d8a7d8aa20d8a7d984d8b9d8b4d988d8a7d8a6d98ad8a920d8a5d984d98920d8a7d984d986d8b52e20d8a5d98620d983d986d8aa20d8aad8b1d98ad8af20d8a3d98620d8aad8b3d8aad8aed8afd98520d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d985d8a7d88c20d8b9d984d98ad98320d8a3d98620d8aad8aad8add982d98220d8a3d988d984d8a7d98b20d8a3d98620d984d98ad8b320d987d986d8a7d98320d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d985d8add8b1d8acd8a920d8a3d98820d8bad98ad8b120d984d8a7d8a6d982d8a920d985d8aed8a8d8a3d8a920d981d98a20d987d8b0d8a720d8a7d984d986d8b52e20d8a8d98ad986d985d8a720d8aad8b9d985d98420d8acd985d98ad8b920d985d988d984d991d8afd8a7d8aa20d986d8b5d988d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa20d8b9d984d98920d8a5d8b9d8a7d8afd8a920d8aad983d8b1d8a7d8b120d985d982d8a7d8b7d8b920d985d98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d986d981d8b3d98720d8b9d8afd8a920d985d8b1d8a7d8aa20d8a8d985d8a720d8aad8aad8b7d984d8a8d98720d8a7d984d8add8a7d8acd8a9d88c20d98ad982d988d98520d985d988d984d991d8afd986d8a720d987d8b0d8a720d8a8d8a7d8b3d8aad8aed8afd8a7d98520d983d984d985d8a7d8aa20d985d98620d982d8a7d985d988d8b320d98ad8add988d98a20d8b9d984d98920d8a3d983d8abd8b120d985d9862032303020d983d984d985d8a920d984d8a720d8aad98ad986d98ad8a9d88c20d985d8b6d8a7d98120d8a5d984d98ad987d8a720d985d8acd985d988d8b9d8a920d985d98620d8a7d984d8acd985d98420d8a7d984d986d985d988d8b0d8acd98ad8a9d88c20d984d8aad983d988d98ad98620d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8b0d98820d8b4d983d98420d985d986d8b7d982d98a20d982d8b1d98ad8a820d8a5d984d98920d8a7d984d986d8b520d8a7d984d8add982d98ad982d98a2e20d988d8a8d8a7d984d8aad8a7d984d98a20d98ad983d988d98620d8a7d984d986d8b520d8a7d984d986d8a7d8aad8ad20d8aed8a7d984d98a20d985d98620d8a7d984d8aad983d8b1d8a7d8b1d88c20d8a3d98820d8a3d98a20d983d984d985d8a7d8aa20d8a3d98820d8b9d8a8d8a7d8b1d8a7d8aa20d8bad98ad8b120d984d8a7d8a6d982d8a920d8a3d98820d985d8a720d8b4d8a7d8a8d9872e20d988d987d8b0d8a720d985d8a720d98ad8acd8b9d984d98720d8a3d988d98420d985d988d984d991d8af20d986d8b520d984d988d8b1d98ad98520d8a5d98ad8a8d8b3d988d98520d8add982d98ad982d98a20d8b9d984d98920d8a7d984d8a5d986d8aad8b1d986d8aa2e20, 1, 3, NULL, NULL, '2020-08-30 02:10:07', '2020-08-30 02:10:07'),
(8, 176, 'test', 'asdasdasdasdasdasdasdasd', NULL, 'test', 0x3c7461626c65207374796c653d22626f726465722d636f6c6c617073653a20636f6c6c617073653b2077696474683a2039392e39383232253b2220626f726465723d2231223e3c636f6c67726f75703e3c636f6c207374796c653d2277696474683a203530253b22202f3e3c636f6c207374796c653d2277696474683a203530253b22202f3e3c2f636f6c67726f75703e0d0a3c74626f64793e0d0a3c74723e0d0a3c74643e6173646173646173646173646173646173646173646173646173646164733c2f74643e0d0a3c74643e61736464646464643c2f74643e0d0a3c2f74723e0d0a3c74723e0d0a3c74643e736461616161613c2f74643e0d0a3c74643e736461616161616161616161613c2f74643e0d0a3c2f74723e0d0a3c2f74626f64793e0d0a3c2f7461626c653e0d0a3c703e3c696d67207372633d2268747470733a2f2f6d2e6d656469612d616d617a6f6e2e636f6d2f696d616765732f492f36315a68343637704b6a4c2e5f5f41435f53593434355f53583334325f514c37305f464d776562705f2e6a70672220616c743d22222077696474683d2231323522206865696768743d2231363622202f3e3c2f703e0d0a3c703e3c696672616d65207469746c653d224b6f646f6d207c20426c7565204a65616e73207c204c7972696373207c20e0a695e0a6a6e0a6ae22207372633d2268747470733a2f2f7777772e796f75747562652e636f6d2f656d6265642f526d627a636d5f377951553f6c6973743d5244526d627a636d5f37795155222077696474683d223132353722206865696768743d2237303722206672616d65626f726465723d2230223e3c2f696672616d653e3c2f703e, 1, 0, NULL, NULL, '2023-08-24 08:29:04', '2023-08-24 08:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `serial_number` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `language_id`, `image`, `url`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 176, 'fbb202d3560182f7b98d4becc1aede873b42e93b.png', 'https://www.google.com/', 1, NULL, NULL),
(2, 176, 'dffafdc83578824d0e6cefa74ab9fb8d437e094f.png', 'https://www.google.com/', 2, NULL, NULL),
(3, 176, '7a221033f6011dc26aa0bb04daa0a2dde352e61c.png', 'https://www.google.com/', 3, NULL, NULL),
(4, 176, 'c11de403e1cbe44e47047c76459c41d2975818b1.png', 'https://www.google.com/', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('imranyeasin75@gmail.com', '$2y$10$z/D6rNrJYGxTr82pjS9bk.asOCeNNL13WwO9K/1ADpxSFCkJ.lZDS', '2023-06-08 05:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'manual',
  `information` mediumtext,
  `keyword` varchar(255) DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `subtitle`, `title`, `details`, `name`, `type`, `information`, `keyword`, `status`) VALUES
(6, NULL, NULL, NULL, 'Flutterwave', 'automatic', '{\"public_key\":\"FLWPUBK_TEST-a34940f2f87746abbdd8c117caee81cf-X\",\"secret_key\":\"FLWSECK_TEST-1cb427c96e0b1e6772a04504be3638bd-X\",\"text\":\"Pay via your Flutterwave account.\"}', 'flutterwave', 1),
(9, NULL, NULL, NULL, 'Razorpay', 'automatic', '{\"key\":\"rzp_test_fV9dM9URYbqjm7\",\"secret\":\"nickxZ1du2ojPYVVRTDif2Xr\",\"text\":\"Pay via your Razorpay account.\"}', 'razorpay', 1),
(11, NULL, NULL, NULL, 'Paytm', 'automatic', '{\"environment\":\"local\",\"merchant\":\"tkogux49985047638244\",\"secret\":\"LhNGUUKE9xCQ9xY8\",\"website\":\"WEBSTAGING\",\"industry\":\"Retail\",\"text\":\"Pay via your paytm account.\"}', 'paytm', 1),
(12, NULL, NULL, NULL, 'Paystack', 'automatic', '{\"key\":\"sk_test_4ac9f2c43514e3cc08ab68f922201549ebda1bfd\",\"email\":null,\"text\":\"Pay via your Paystack account.\"}', 'paystack', 1),
(13, NULL, NULL, NULL, 'Instamojo', 'automatic', '{\"key\":\"test_172371aa837ae5cad6047dc3052\",\"token\":\"test_4ac5a785e25fc596b67dbc5c267\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Instamojo account.\"}', 'instamojo', 1),
(14, NULL, NULL, NULL, 'Stripe', 'automatic', '{\"key\":\"pk_test_UnU1Coi1p5qFGwtpjZMRMgJM\",\"secret\":\"sk_test_QQcg3vGsKRPlW6T3dXcNJsor\",\"text\":\"Pay via your Credit account.\"}', 'stripe', 1),
(15, NULL, NULL, NULL, 'Paypal', 'automatic', '{\"client_id\":\"AVYKFEw63FtDt9aeYOe9biyifNI56s2Hc2F1Us11hWoY5GMuegipJRQBfWLiIKNbwQ5tmqKSrQTU3zB3\",\"client_secret\":\"EJY0qOKliVg7wKsR3uPN7lngr9rL1N7q4WV0FulT1h4Fw3_e5Itv1mxSdbtSUwAaQoXQFgq-RLlk_sQu\",\"sandbox_check\":\"1\",\"text\":\"Pay via your PayPal account.\"}', 'paypal', 1),
(17, NULL, NULL, NULL, 'Mollie Payment', 'automatic', '{\"key\":\"test_m6BAuk4mJ7asBP52AtCWn3WjpK4Tv3\",\"text\":\"Pay via your Mollie Payment account.\"}', 'mollie', 1),
(19, NULL, NULL, NULL, 'Mercado Pago', 'automatic', '{\"token\":\"TEST-705032440135962-041006-ad2e021853f22338fe1a4db9f64d1491-421886156\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Mercado Pago account.\"}', 'mercadopago', 1),
(20, NULL, NULL, NULL, 'Authorize.net', 'automatic', '{\"login_id\":\"3Ca5hYQ6h\",\"transaction_key\":\"8bt8Kr5gPZ3ZE23C\",\"public_key\":\"7m38JBnNjStNFq58BA6Wrr852ahtT533cGKavWwu6Fge28RDc5wC7wTL8Vsb35B3\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Authorize.net account.\"}', 'authorize.net', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pcategories`
--

CREATE TABLE `pcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `is_feature` int DEFAULT NULL,
  `tax` decimal(11,2) NOT NULL DEFAULT '0.00',
  `indx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pcategories`
--

INSERT INTO `pcategories` (`id`, `language_id`, `user_id`, `name`, `slug`, `image`, `status`, `is_feature`, `tax`, `indx`, `created_at`, `updated_at`) VALUES
(31, 10, 7, 'First Category', 'First-Category', '827e6705a44e33bbc0b1fd5af48d49c9a2d1fc10.jpg', 1, NULL, 4.00, NULL, '2023-09-10 03:10:35', '2023-09-10 03:10:35'),
(32, 19, 14, 'cat en 1', 'cat-en-1', '09fd0aa8553c25756a7fa5bc5672c7a5c0826380.jpg', 1, 1, 3.00, '6523be25dfff1', '2023-09-10 15:45:18', '2023-12-18 17:51:22'),
(33, 19, 14, 'cat en 2', 'cat-en-2', '5da6b3f98a900d45e392e0352ab745bd1fa5b10d.jpg', 1, 1, 4.00, '6523be4de5b56', '2023-09-10 15:45:32', '2023-12-09 00:23:13'),
(34, 21, 14, 'cat ar 1', 'cat-ar-1', '09fd0aa8553c25756a7fa5bc5672c7a5c0826380.jpg', 1, NULL, 3.00, '6523be25dfff1', '2023-09-26 14:39:02', '2023-12-18 17:51:22'),
(35, 21, 14, 'cat ar 2', 'cat-ar-2', '5da6b3f98a900d45e392e0352ab745bd1fa5b10d.jpg', 1, NULL, 4.00, '6523be4de5b56', '2023-09-26 14:39:24', '2023-12-09 00:23:13'),
(38, 19, 14, 'cat-3', 'cat-3', '1cf46f8c61af90c488d43d3c0977985d2d503b38.jpg', 1, NULL, 1.00, '657ee2c7b2117', '2023-12-16 23:00:07', '2023-12-18 17:52:27'),
(39, 21, 14, 'cat-3 ar', 'cat-3-ar', '1cf46f8c61af90c488d43d3c0977985d2d503b38.jpg', 1, NULL, 1.00, '657ee2c7b2117', '2023-12-16 23:00:07', '2023-12-18 17:52:27'),
(40, 37, 42, 'Service with zoom & calendar', 'Service-with-zoom-&-calendar', NULL, 1, NULL, 10.00, '658136cd432c7', '2023-12-18 17:23:09', '2023-12-18 17:23:09'),
(41, 38, 43, 'First Service', 'First-Service', NULL, 1, NULL, 0.00, '6581388e679d9', '2023-12-18 17:30:38', '2023-12-18 17:30:38');

-- --------------------------------------------------------

--
-- Table structure for table `popups`
--

CREATE TABLE `popups` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_opacity` decimal(8,2) NOT NULL DEFAULT '1.00',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `button_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delay` int NOT NULL DEFAULT '1000' COMMENT 'in milisconds',
  `serial_number` int NOT NULL DEFAULT '0',
  `type` tinyint NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1 - active, 0 - deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popups`
--

INSERT INTO `popups` (`id`, `language_id`, `name`, `image`, `background_image`, `background_color`, `background_opacity`, `title`, `text`, `button_text`, `button_url`, `button_color`, `end_date`, `end_time`, `delay`, `serial_number`, `type`, `status`, `created_at`, `updated_at`) VALUES
(33, 177, 'Black Friday', '606d41536fa81.jpg', NULL, NULL, 1.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1500, 1, 1, 0, '2021-04-06 19:21:23', '2021-04-07 22:06:58'),
(34, 177, 'Monthend Sale', NULL, '606d41d50dd28.jpg', '451D53', 0.80, 'ENJOY 10% OFF', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'Shop Now', 'http://example.com/', '451D53', NULL, NULL, 2000, 2, 2, 0, '2021-04-06 19:23:33', '2021-04-07 22:06:21'),
(35, 177, 'Summer Sale', NULL, '606d42e66ee81.jpg', 'FF2865', 0.70, 'Newsletter', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', 'Subscribe', NULL, 'FF2865', NULL, NULL, 2000, 3, 3, 0, '2021-04-06 19:28:06', '2021-04-07 22:06:18'),
(36, 177, 'Winter Offer', '606d43711d16a.jpg', NULL, NULL, 1.00, 'Get 10% off your first order', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt', 'Shop Now', 'http://example.com/', 'FF2865', NULL, NULL, 1500, 4, 4, 0, '2021-04-06 19:30:25', '2021-04-25 04:18:04'),
(37, 177, 'Winter Sale', '606d43dfad35b.jpg', NULL, NULL, 1.00, 'Get 10% off your first order', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt', 'Subscribe', NULL, 'F8960D', NULL, NULL, 2000, 6, 5, 0, '2021-04-06 19:32:15', '2021-04-07 22:06:09'),
(38, 177, 'New Arrivals Saleu', NULL, '606d55f99176d.jpg', NULL, 1.00, 'Hurry, Sale Ends This Friday', 'This is your last chance to save 30%', 'Yes,I Want to Save 30%', 'http://example.com/', '29A19C', '03/14/2022', '3:00 AM', 1500, 7, 6, 0, '2021-04-06 19:34:08', '2021-05-23 01:00:12'),
(39, 177, 'Flash Sale', '606d5691a51bf.jpg', NULL, '930077', 1.00, 'Hurry, Sale Ends This Friday', 'This is your last chance to save 30%', 'Yes,I Want to Save 30%', 'http://example.com/', 'FA00CA', '04/09/2022', '10:00 AM', 1500, 8, 7, 0, '2021-04-06 19:36:04', '2021-04-07 22:06:03'),
(40, 176, 'Subscribe', NULL, '850b06ad934e4610c43119d62635967ac91dab4f.png', '197A83', 0.80, 'Subscribe For Update', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from', 'Subscribe', NULL, '197A83', NULL, NULL, 2000, 2, 3, 0, '2022-12-13 06:49:47', '2023-12-04 22:57:06'),
(41, 176, 'Second Category', NULL, 'b6199ff5a5cf0ac567945470fea3caf5660c3ce0.png', '451D53', 0.40, 't has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English', 't has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search', NULL, NULL, '451D53', NULL, NULL, 1000, 1, 3, 0, '2023-12-04 22:56:08', '2023-12-04 22:56:56'),
(42, 176, 'Cricket', NULL, '3ccd0ef03842cc5b184e26384219733a22e3eb93.png', '451D53', 0.80, 't has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it', 't has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search', NULL, NULL, '451D53', NULL, NULL, 2000, 1, 3, 0, '2023-12-04 22:59:09', '2023-12-04 23:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `postal_codes`
--

CREATE TABLE `postal_codes` (
  `id` int NOT NULL,
  `language_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `postcode` varchar(50) NOT NULL,
  `charge` decimal(11,2) NOT NULL DEFAULT '0.00',
  `free_delivery_amount` decimal(11,2) DEFAULT NULL,
  `serial_number` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `postal_codes`
--

INSERT INTO `postal_codes` (`id`, `language_id`, `user_id`, `title`, `postcode`, `charge`, `free_delivery_amount`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 'ps 1', '1230', 2.50, 60.00, 1, '2023-09-12 16:02:52', '2023-10-12 04:50:24'),
(2, 19, 14, 'ps 2', '1222', 2.00, 50.00, 2, '2023-09-12 16:03:08', '2023-10-12 04:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `pos_payment_methods`
--

CREATE TABLE `pos_payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL COMMENT '1 - active, 0 - deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `id` int NOT NULL,
  `language_id` int DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `btn_text` varchar(100) DEFAULT NULL,
  `serial_number` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`id`, `language_id`, `icon`, `title`, `text`, `btn_text`, `serial_number`) VALUES
(17, 176, 'fas fa-dollar-sign', 'Purchase Plan', 'Choose a pricing plan which suits best to you', 'Purchase Now', 1),
(18, 176, 'fas fa-graduation-cap', 'Upload Course', 'Upload Your Course, Modules, Lessons & Lesson Contents', 'Upload Now', 2),
(19, 176, 'fas fa-rocket', 'Start Selling', 'Setup Your Currency, Payment Gateways & Start Selling', 'Launch Now', 3),
(23, 176, 'fas fa-desktop', 'Custom Domain', 'Add Custom Domain to Make Your Website Professional', NULL, 4),
(24, 177, 'fas fa-dollar-sign', 'خطة الشراء', 'اختر خطة تسعير تناسبك بشكل أفضل', 'شراء الآن', 1),
(25, 177, 'fas fa-graduation-cap', 'تحميل الدورة', 'قم بتحميل الدورة التدريبية والوحدات النمطية والدروس ومحتويات الدرس', 'تحميل الآن', 2),
(26, 177, 'fas fa-rocket', 'ابدأ بالبيع', 'قم بإعداد عملتك وبوابات الدفع وابدأ البيع', 'تنطلق الان', 3),
(27, 177, 'fas fa-desktop', 'مجال مخصص', 'إضافة مجال مخصص لجعل موقع الويب الخاص بك محترفًا', NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `feature_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variations` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `addon_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `addons` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `indx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `previous_price` decimal(11,2) DEFAULT '0.00',
  `rating` decimal(11,2) NOT NULL DEFAULT '0.00',
  `status` int NOT NULL DEFAULT '1',
  `is_feature` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_special` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `feature_image`, `variations`, `keywords`, `addon_keywords`, `addons`, `indx`, `current_price`, `previous_price`, `rating`, `status`, `is_feature`, `created_at`, `updated_at`, `is_special`) VALUES
(21, 7, 'b37ae4b4c91800c7b6d99b44668f2e3b50a9941d.png', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 20.00, 22.00, 0.00, 1, 0, '2023-09-10 03:14:22', '2023-09-10 03:14:22', 0),
(22, 7, '5f43711e9b70dd501451ab06042887e923303ae9.png', '{\"Spicy Level\":[{\"name\":\"High\",\"price\":\"2\"},{\"name\":\"Medium High\",\"price\":\"1\"},{\"name\":\"Low\",\"price\":\"1\"}],\"Patty\":[{\"name\":\"Single\",\"price\":\"1\"},{\"name\":\"Double Extra\",\"price\":\"2\"}],\"Souce\":[{\"name\":\"Medium\",\"price\":\"1\"},{\"name\":\"High\",\"price\":\"2\"}]}', '{\"option_name\":{\"en_High\":\"High\",\"en_Medium High\":\"Medium High\",\"en_Low\":\"Low\",\"en_Single\":\"Single\",\"en_Double Extra\":\"Double Extra\",\"en_Medium\":\"Medium\"},\"variation_name\":{\"en_Spicy Level\":\"Spicy Level\",\"en_Patty\":\"Patty\",\"en_Souce\":\"Souce\"}}', '{\"addon_name\":{\"en_Addon\":\"Addon\",\"en_Addon Two\":\"Addon Two\"}}', '[{\"name\":\"Addon\",\"price\":1},{\"name\":\"Addon Two\",\"price\":2}]', '[\"0\",\"1\",\"2\"]', 15.00, 16.00, 0.00, 1, 0, '2023-09-10 03:19:47', '2023-09-10 03:19:47', 0),
(23, 14, 'cc3110ebab07c0637b4ad5379ad9256460b86760.jpg', '{\"Color\":[{\"name\":\"Black\",\"price\":\"1\"},{\"name\":\"Red\",\"price\":\"2\"}],\"Size\":[{\"name\":\"Regular\",\"price\":\"2\"},{\"name\":\"Medium\",\"price\":\"4\"},{\"name\":\"Large\",\"price\":\"6\"}],\"Type\":[{\"name\":\"Standard\",\"price\":\"3\"},{\"name\":\"Basic\",\"price\":\"2\"},{\"name\":\"Full\",\"price\":\"0\"}]}', '{\"option_name\":{\"en_Black\":\"Black\",\"en_Red\":\"Red\",\"ar_Black\":\"Black ar\",\"ar_Red\":\"Red ar\",\"en_Regular\":\"Regular\",\"en_Medium\":\"Medium\",\"en_Large\":\"Large\",\"ar_Regular\":\"Regular ar\",\"ar_Medium\":\"Medium ar\",\"ar_Large\":\"Large ar\",\"en_Standard\":\"Standard\",\"en_Basic\":\"Basic\",\"en_Full\":\"Full\",\"ar_Standard\":\"Standard ar\",\"ar_Basic\":\"Basic ar\",\"ar_Full\":\"Full ar\"},\"variation_name\":{\"en_Color\":\"Color\",\"ar_Color\":\"Color ar\",\"en_Size\":\"Size\",\"ar_Size\":\"Size ar\",\"en_Type\":\"Type\",\"ar_Type\":\"Type ar\"}}', '{\"addon_name\":{\"en_Chesse\":\"Chesse\",\"ar_Chesse\":\"Chesse ar\",\"en_Patty\":\"Patty\",\"ar_Patty\":\"Patty ar\",\"en_Egg\":\"Egg\",\"ar_Egg\":\"Egg ar\"}}', '[{\"name\":\"Chesse\",\"price\":4},{\"name\":\"Patty\",\"price\":2},{\"name\":\"Egg\",\"price\":7}]', '[\"0\",\"1\",\"2\"]', 12.00, NULL, 0.00, 1, 1, '2023-09-10 15:53:48', '2023-12-09 00:28:55', 0),
(24, 14, '3ed16f26df2b8c8e36ca0d0b6db78bf60495caf9.jpeg', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 9.00, 12.00, 3.50, 1, 1, '2023-09-10 16:12:49', '2023-12-09 00:28:02', 0),
(25, 14, '5deac9b853f5142917fec3d2be5b191fdc015826.jpg', '{\"RAM\":[{\"name\":\"1GB\",\"price\":\"1\"},{\"name\":\"8 GB\",\"price\":\"4\"}],\"Color Family\":[{\"name\":\"Black\",\"price\":\"1\"},{\"name\":\"White\",\"price\":\"3\"},{\"name\":\"Red\",\"price\":\"6\"}]}', '{\"option_name\":{\"en_1GB\":\"1GB\",\"en_8 GB\":\"8 GB\",\"ar_1GB\":\"1GB ar\",\"ar_8 GB\":\"8GB ar\",\"en_Black\":\"Black\",\"en_White\":\"White\",\"en_Red\":\"Red\",\"ar_Black\":\"Black ar\",\"ar_White\":\"White ar\",\"ar_Red\":\"Red ar\"},\"variation_name\":{\"en_RAM\":\"RAM\",\"ar_RAM\":\"RAM ar\",\"en_Color Family\":\"Color Family\",\"ar_Color Family\":\"Color Family ar\"}}', '{\"addon_name\":[]}', '[]', '[\"0\",\"1\"]', 6.00, 10.00, 0.00, 1, 1, '2023-09-10 16:19:46', '2023-12-10 23:48:59', 0),
(26, 14, '1454e82a43a2e9e7ed1656c7ecfd74aafb468e92.jpg', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":{\"en_noodles\":\"noodles\",\"ar_noodles\":\"\\u0645\\u0648\\u0639\\u062f \\u0627\\u0644\\u062a\\u0633\\u0644\\u064a\\u0645\",\"en_Patty\":\"Patty\",\"ar_Patty\":\"\\u0641\\u0637\\u064a\\u0631\\u0629\",\"en_bun\":\"bun\",\"ar_bun\":\"\\u0643\\u0639\\u0643\\u0629\"}}', '[{\"name\":\"noodles\",\"price\":5},{\"name\":\"Patty\",\"price\":1},{\"name\":\"bun\",\"price\":2}]', NULL, 7.00, 15.00, 0.00, 1, 1, '2023-09-10 16:26:12', '2023-12-09 00:25:47', 0),
(27, 14, '4837dbbcdb47e9e1439c4950580e5cf44c91a334.jpg', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 24.00, 34.00, 3.50, 1, 0, '2023-10-20 11:12:18', '2023-12-07 05:13:53', 0),
(28, 14, '9d5ef8ee57d9e4fd807aac06e826be3a5ad01ec6.jpg', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 77.00, NULL, 0.00, 1, 0, '2023-10-24 15:09:33', '2023-12-05 21:18:11', 0),
(34, 14, '03bb966b9b5d76c0d380a16fcca41264575c5b2f.png', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 20.00, NULL, 4.00, 1, 0, '2023-12-16 23:01:10', '2023-12-19 07:06:41', 0),
(35, 42, '131078376c8120d92679f4fdea655443a4146a93.jpeg', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 200.00, NULL, 0.00, 1, 0, '2023-12-18 17:24:33', '2023-12-18 17:24:33', 0),
(36, 43, '0d6a08a080fc0db447f24aa2e4ba487477c722b7.png', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":[]}', '[]', NULL, 100.00, NULL, 0.00, 1, 0, '2023-12-18 17:31:30', '2023-12-18 17:31:30', 0),
(37, 42, 'ae8f3755516fdc8b20e3143fd453cf5c76a42761.png', '[]', '{\"option_name\":[],\"variation_name\":[]}', '{\"addon_name\":{\"en_addon\":\"addon\",\"en_addon 2\":\"addon 2\"}}', '[{\"name\":\"addon\",\"price\":1},{\"name\":\"addon 2\",\"price\":3}]', NULL, 100.00, NULL, 0.00, 1, 0, '2023-12-18 17:38:01', '2023-12-18 17:38:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `user_id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(2, 7, 21, '1491acb479f53f45c52e18455016f7015d389d4e.png', '2023-09-10 03:13:47', '2023-09-10 03:14:22'),
(3, 7, 22, '07d53c2a7ca6e1d379335c0c3e91e71c0b644427.jpg', '2023-09-10 03:16:44', '2023-09-10 03:19:47'),
(4, 7, 22, '07630d3f32daf078c6e7f1456702283945872773.jpg', '2023-09-10 03:16:44', '2023-09-10 03:19:47'),
(15, 24, NULL, '00eeb9b99c21ecbe86c8caf888e8424b582034a6.jpg', '2023-10-24 15:06:04', '2023-10-24 15:06:04'),
(18, 14, 28, '5c6d101d25b3695adf99c64f434cb0a043fbd47c.jpg', '2023-12-05 21:17:14', '2023-12-05 21:17:14'),
(19, 14, 28, '9e2d7388003c1241ff0c5250290a5d4a157805ce.jpeg', '2023-12-05 21:17:24', '2023-12-05 21:17:24'),
(20, 14, 27, '48d93f1ed475ebc3af13db17422044d214338bc5.jpg', '2023-12-05 21:19:53', '2023-12-05 21:19:53'),
(21, 14, 27, 'c2ac63ab000ae28b131627220310110b10cc8816.png', '2023-12-05 21:20:17', '2023-12-05 21:20:17'),
(26, 14, 26, '92327c133064a0cd1f48618d743a41edd611d08c.jpg', '2023-12-09 00:24:19', '2023-12-09 00:24:19'),
(27, 14, 26, '7d99ccb48323db4559df721a1b3144b0c9d6bc21.jpg', '2023-12-09 00:24:19', '2023-12-09 00:24:19'),
(28, 14, 25, '28ae60e8c68643ffa2677013699d5df8af949e3b.jpg', '2023-12-09 00:26:20', '2023-12-09 00:26:20'),
(29, 14, 25, '191c70c1b5ba5778dab903b932a8c67010cd1024.jpg', '2023-12-09 00:26:20', '2023-12-09 00:26:20'),
(30, 14, 24, '07af92968d319b841c33419e43aafa6459af06a6.jpg', '2023-12-09 00:27:32', '2023-12-09 00:27:32'),
(31, 14, 24, '6e1231685c8b0d744d50c34e7abd8bcf115d953e.jpg', '2023-12-09 00:27:32', '2023-12-09 00:27:32'),
(32, 14, 23, '835789de11a9e02f2047b8f6041bf3638740dcf2.jpg', '2023-12-09 00:28:40', '2023-12-09 00:28:40'),
(33, 14, 23, 'c7647b3f73daacde274d36e3ac36fe01afc1a4e3.jpg', '2023-12-09 00:28:40', '2023-12-09 00:28:40'),
(34, 14, 34, 'dc4c7189af8a03a7002db05c9e5e7803a5988d13.png', '2023-12-16 23:00:33', '2023-12-16 23:01:10'),
(35, 42, 35, 'b5602dce00a8aec630ebbd7a76cacf47f92b959c.jpeg', '2023-12-18 17:24:03', '2023-12-18 17:24:33'),
(36, 43, 36, 'c83b47e10cb486bdd904df175572010a365bf660.png', '2023-12-18 17:30:51', '2023-12-18 17:31:30'),
(37, 42, 37, 'd2b428c0110c5deaf912ec3f4822899fb8a55b2b.png', '2023-12-18 17:37:26', '2023-12-18 17:38:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_informations`
--

CREATE TABLE `product_informations` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `summary` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subcategory_id` int DEFAULT NULL,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_informations`
--

INSERT INTO `product_informations` (`id`, `language_id`, `user_id`, `product_id`, `title`, `slug`, `category_id`, `summary`, `description`, `created_at`, `updated_at`, `subcategory_id`, `meta_keywords`, `meta_description`) VALUES
(33, 10, 7, 21, 'First Product Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquet semper porttitor. Phasellus fringilla urna at sagittis effi', 'First-Product-Lorem-ipsum-dolor-sit-amet,-consectetur-adipiscing-elit.-Vestibulum-aliquet-semper-porttitor.-Phasellus-fringilla-urna-at-sagittis-effi', 31, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum tempor nibh. Maecenas vehicula fermentum scelerisque. Nunc fermentum, est quis lobortis efficitur', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum tempor nibh. Maecenas vehicula fermentum scelerisque. Nunc fermentum, est quis lobortis efficiturLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum tempor nibh. Maecenas vehicula fermentum scelerisque. Nunc fermentum, est quis lobortis efficitur</p>', '2023-09-10 03:14:22', '2023-09-10 03:14:22', 24, NULL, NULL),
(34, 10, 7, 22, 'Variant product Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus et nibh quis sapien semper', 'Variant-product-Lorem-ipsum-dolor-sit-amet,-consectetur-adipiscing-elit.-Phasellus-et-nibh-quis-sapien-semper', 31, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum tempor nibh. Maecenas vehicula fermentum scelerisque. Nunc fermentum, est quis lobortis efficitur', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed dictum tempor nibh. Maecenas vehicula fermentum scelerisque. Nunc fermentum, est quis lobortis efficitur</p>', '2023-09-10 03:19:47', '2023-09-10 03:19:47', 24, NULL, NULL),
(35, 19, 14, 23, 'Variation + Addon Item', 'Variation-+-Addon-Item', 32, 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on t', '<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>', '2023-09-10 15:53:48', '2023-10-20 15:27:27', 27, NULL, NULL),
(36, 19, 14, 24, 'No Variation + No Addon', 'No-Variation-+-No-Addon', 32, 'as a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publish', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '2023-09-10 16:12:49', '2023-10-20 15:28:13', 25, NULL, NULL),
(37, 19, 14, 25, 'Only Variation', 'Only-Variation', 33, '. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p>', '2023-09-10 16:19:46', '2023-09-10 16:23:51', 26, NULL, NULL),
(38, 19, 14, 26, 'Only Addon', 'Only-Addon', 33, 'm Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.', '<div>\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div> </div>', '2023-09-10 16:26:12', '2023-10-10 10:41:52', 26, NULL, NULL),
(39, 21, 14, 23, 'Variation + Addon Item ar', 'Variation-+-Addon-Item-ar', 34, 'ic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '<div>\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div> </div>', '2023-09-26 14:45:56', '2023-12-09 04:21:01', NULL, NULL, NULL),
(40, 21, 14, 26, 'أول مدونة', 'أول-مدونة', 35, 'أول مدونةأول مدونةأول مدونةأول مدونةأول مدونةأول مدونة', '<p>أول مدونةأول مدونةأول مدونةأول مدونةأول مدونةأول مدونةأول مدونةأول مدونة</p>', '2023-10-09 09:53:38', '2023-10-09 09:53:38', 30, NULL, NULL),
(41, 21, 14, 25, 'Only Variation ar', 'Only-Variation-ar', 35, 'لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي', '<p dir=\"rtl\">لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.</p>', '2023-10-20 09:32:42', '2023-10-20 09:34:57', 30, NULL, NULL),
(42, 19, 14, 27, 'galley of type and scrambled it to', 'galley-of-type-and-scrambled-it-to', 33, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown', '<div>\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div> </div>', '2023-10-20 11:12:18', '2023-12-05 21:20:39', 26, NULL, NULL),
(43, 21, 14, 27, 'galley of type and scrambled it to ar', 'galley-of-type-and-scrambled-it-to-ar', 35, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown', '<div>\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n</div>\r\n<div> </div>', '2023-10-20 11:12:18', '2023-12-09 02:22:34', 30, NULL, NULL),
(44, 21, 14, 24, 'تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة', 'تطورت-إصدارات-مختلفة-على-مر-السنين-،-أحيانًا-عن-طريق-الصدفة', 35, 'تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة', '<p>                                      تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة                                                                تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة                                                                تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة                                                                تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة                                                                تطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفةتطورت إصدارات مختلفة على مر السنين ، أحيانًا عن طريق الصدفة                          </p>', '2023-10-20 15:28:13', '2023-10-20 15:28:13', NULL, NULL, NULL),
(45, 19, 14, 28, 'It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established fact that a reader will be It is a long established', 'It-is-a-long-established-fact-that-a-reader-will-be-It-is-a-long-established-fact-that-a-reader-will-be-It-is-a-long-established-fact-that-a-reader-will-be-It-is-a-long-established', 33, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-le', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '2023-10-24 15:09:33', '2023-12-05 02:32:39', 26, NULL, NULL),
(46, 21, 14, 28, 'It is a long established fact that a reader will be', 'It-is-a-long-established-fact-that-a-reader-will-be', 35, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-le', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '2023-10-24 15:09:33', '2023-10-24 15:09:33', 30, NULL, NULL),
(52, 19, 14, 34, 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 33, 'rewwwwwwertwwwwwwwwwwwy', '<p>ewwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww</p>', '2023-12-16 23:01:10', '2023-12-23 02:34:41', NULL, NULL, NULL),
(53, 21, 14, 34, 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 'hsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfg', 39, 'rewwwwwwertwwwwwwwwwwwy', '<p>ewwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww</p>', '2023-12-16 23:01:10', '2023-12-16 23:01:10', NULL, NULL, NULL),
(54, 37, 42, 35, 'About Electricity of Bangladesh', 'About-Electricity-of-Bangladesh', 40, 'asdddddddddddddddd', '<p>dssssssssssssssssssssssssssssssssssssssssssssssssssssssssss</p>', '2023-12-18 17:24:33', '2023-12-18 17:24:33', NULL, NULL, NULL),
(55, 38, 43, 36, 'Cricket ,Asia Cup start 30 auguast and world cup will be later lorem impsum mate', 'Cricket-,Asia-Cup-start-30-auguast-and-world-cup-will-be-later-lorem-impsum-mate', 41, 'sybtrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrbyssssssssssssse', '<p>ysbbbbbbbbbbbbbbbbbbbbbbbbbbbbberbysssssssssss</p>', '2023-12-18 17:31:30', '2023-12-18 17:31:30', NULL, NULL, NULL),
(56, 37, 42, 37, 'Variant Product', 'Variant-Product', 40, 'fsdgggggggggggggggggggggggggggggggggggggggggggg', '<p>gdfsssssssssssssssssssssssssssssssssssssssssssssssssss</p>', '2023-12-18 17:38:01', '2023-12-18 17:38:01', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_orders`
--

CREATE TABLE `product_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `membership_id` int NOT NULL,
  `billing_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_fname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_lname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_code_position` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_symbol` blob,
  `currency_symbol_position` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_no` int DEFAULT NULL,
  `shipping_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_charge` decimal(11,2) DEFAULT NULL,
  `postal_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `postal_code_status` tinyint NOT NULL DEFAULT '0' COMMENT '1 - post code based delivery enabled, 0 - post code based delivery disabled',
  `payment_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `txnid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `receipt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `completed` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serving_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_up_date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pick_up_time` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waiter_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` decimal(11,2) NOT NULL DEFAULT '0.00',
  `coupon` decimal(11,2) NOT NULL DEFAULT '0.00',
  `delivery_date` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_time_start` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_time_end` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_orders`
--

INSERT INTO `product_orders` (`id`, `customer_id`, `user_id`, `membership_id`, `billing_country`, `billing_fname`, `billing_lname`, `billing_address`, `billing_city`, `billing_email`, `billing_country_code`, `billing_number`, `shipping_country`, `shipping_fname`, `shipping_lname`, `shipping_address`, `shipping_city`, `shipping_email`, `shipping_country_code`, `shipping_number`, `total`, `method`, `gateway_type`, `currency_code`, `currency_code_position`, `currency_symbol`, `currency_symbol_position`, `order_number`, `token_no`, `shipping_method`, `shipping_charge`, `postal_code`, `postal_code_status`, `payment_status`, `order_status`, `txnid`, `charge_id`, `invoice_number`, `created_at`, `updated_at`, `receipt`, `order_notes`, `completed`, `type`, `serving_method`, `pick_up_date`, `pick_up_time`, `waiter_name`, `table_number`, `tax`, `coupon`, `delivery_date`, `delivery_time_start`, `delivery_time_end`) VALUES
(1, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 214.24, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'C1hV-1694534927', NULL, NULL, 0.00, 'ps 1 - 1230', 1, 'Completed', 'pending', 'txn_NaWYxFr11694534927', 'ch_41pMwvXTj1694534927', 'gs6n1694534929.pdf', '2023-09-12 10:08:47', '2023-09-12 10:08:50', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 6.24, 0.00, NULL, NULL, NULL),
(2, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 216.24, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'NcEk-1694535400', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_hJnnpGfl1694535400', 'ch_kvFyqN9XO1694535400', 'TUcb1694535402.pdf', '2023-09-12 10:16:40', '2023-09-12 10:16:43', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 6.24, 0.00, NULL, NULL, NULL),
(3, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 217.27, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '6ov7-1694535972', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_wCP8Cpgw1694535971', 'ch_XPkhYhFcR1694535971', 'OMFs1694535973.pdf', '2023-09-12 10:26:12', '2023-09-12 10:26:14', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 7.27, 0.00, NULL, NULL, NULL),
(4, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 215.27, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'OAQv-1694536156', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_Mh4SaIjW1694536156', 'ch_UbRVIhBxy1694536156', 'OVdQ1694536158.pdf', '2023-09-12 10:29:16', '2023-09-12 10:29:19', NULL, NULL, 'no', 'website', 'pick_up', '09/15/2023', '01:00 AM', NULL, NULL, 7.27, 0.00, NULL, NULL, NULL),
(5, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 215.27, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'QtFm-1694536230', 1, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_9ROeZOG51694536230', 'ch_utIGSAIAV1694536230', 'tuR51694536232.pdf', '2023-09-12 10:30:30', '2023-09-12 10:30:33', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, 'rahman', '6', 7.27, 0.00, NULL, NULL, NULL),
(6, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '2O3p-1694620931', 2, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_Uv2xycbf1694620931', 'ch_pFio0wX9r1694620931', 'VBcT1694620933.pdf', '2023-09-13 10:02:11', '2023-09-13 10:02:13', NULL, NULL, 'no', 'qr', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(7, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'G7Ct-1694621194', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_5E4hyipE1694621194', 'ch_14ZIDFgUV1694621194', '3kOV1694621195.pdf', '2023-09-13 10:06:34', '2023-09-13 10:06:36', NULL, NULL, 'no', 'qr', 'pick_up', '09/22/2023', '01:30 AM', NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(8, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 52.42, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'mGCB-1694621253', NULL, NULL, 2.50, 'ps 1 - 1230', 1, 'Completed', 'pending', 'txn_GbzNsHoT1694621253', 'ch_Tdt3B4u4V1694621253', 'xR1g1694621255.pdf', '2023-09-13 10:07:33', '2023-09-13 10:07:35', NULL, 'sample note', 'no', 'qr', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(9, NULL, 14, 42, NULL, 'genius test', NULL, NULL, NULL, 'geniustest11@gmail.com', NULL, '01689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17.68, NULL, NULL, 'USD', 'right', 0x24, 'left', 'tWtn-1694621660', 3, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, 'pRFs1694621662.pdf', '2023-09-13 16:14:20', '2023-09-13 16:14:22', NULL, NULL, 'no', 'pos', 'on_table', NULL, NULL, NULL, '1', 0.68, 0.00, NULL, NULL, NULL),
(10, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'RJi5-1694621793', 4, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_RhF49bFs1694621792', 'ch_cC58xiRfR1694621792', 'KlcN1694621794.pdf', '2023-09-13 10:16:33', '2023-09-13 10:16:34', NULL, NULL, 'no', 'qr', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(11, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'Mc2L-1694621826', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_qL7cmmbS1694621826', 'ch_XdOsRSDCQ1694621826', 'jCCl1694621828.pdf', '2023-09-13 10:17:06', '2023-09-13 10:17:08', NULL, NULL, 'no', 'qr', 'pick_up', '09/27/2023', '02:00 AM', NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(12, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'hGSb-1694621885', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_54aFm91N1694621885', 'ch_gdDjVC2UQ1694621885', 'TjdB1694621886.pdf', '2023-09-13 10:18:05', '2023-09-13 10:18:07', NULL, NULL, 'no', 'qr', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(13, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'zTgH-1694621927', 5, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_7Id0LsYc1694621927', 'ch_bBlEasZcu1694621927', 'vzrL1694621928.pdf', '2023-09-13 10:18:47', '2023-09-13 10:18:49', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(14, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'Y1WW-1694621970', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_AedNxuPu1694621970', 'ch_JjXOaB0l91694621970', '5o3O1694621971.pdf', '2023-09-13 10:19:30', '2023-09-13 10:19:32', NULL, NULL, 'no', 'website', 'pick_up', '09/14/2023', '01:30 AM', NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(15, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'VrYq-1694622004', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_jfc1FcAI1694622004', 'ch_aPOMCxF6Y1694622004', 'OeDD1694622005.pdf', '2023-09-13 10:20:04', '2023-09-13 10:20:06', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(16, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '3QeI-1694622087', 6, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_CxAc4i8I1694622087', 'ch_CKHbwbdjk1694622087', 'fisr1694622088.pdf', '2023-09-13 10:21:27', '2023-09-13 10:21:29', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 1.92, 0.00, NULL, NULL, NULL),
(17, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '48Cl-1694622124', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_8XEqhfg71694622124', 'ch_QhfHFuSZr1694622124', '1uab1694622126.pdf', '2023-09-13 10:22:05', '2023-09-13 10:22:06', NULL, NULL, 'no', 'website', 'pick_up', '09/15/2023', '01:00 AM', NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(18, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'wIv7-1694622152', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_EldxU1OL1694622152', 'ch_YuUkVFHFV1694622152', 'mgar1694622153.pdf', '2023-09-13 10:22:32', '2023-09-13 10:22:34', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(19, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 52.42, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'QctN-1694622190', NULL, NULL, 2.50, 'ps 1 - 1230', 1, 'Completed', 'pending', 'txn_YdqiCXs61694622190', 'ch_gQ51pd9M71694622190', 'bzfe1694622191.pdf', '2023-09-13 10:23:10', '2023-09-13 10:23:12', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(20, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '6o2h-1694622295', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_W5xJmalI1694622295', 'ch_naf5a2lJD1694622295', 'Z1gA1694622296.pdf', '2023-09-13 10:24:55', '2023-09-13 10:24:57', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(21, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'S8pH-1694622586', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_2KJ9CtFi1694622586', 'ch_D6u7ZmiR31694622586', '44yA1694622587.pdf', '2023-09-13 10:29:46', '2023-09-13 10:29:48', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(22, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'jTCU-1694622645', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_NJDCQTGz1694622645', 'ch_D3BdjKdwO1694622645', 'Boba1694622646.pdf', '2023-09-13 10:30:45', '2023-09-13 10:30:47', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(23, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 51.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'LLi7-1694622745', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_T5pUf4RQ1694622745', 'ch_kT1GXz2qv1694622745', '3KMH1694622747.pdf', '2023-09-13 10:32:25', '2023-09-13 10:32:27', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.92, 0.00, NULL, NULL, NULL),
(24, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', '5tmL-1694622914', 7, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_ehTHth741694622914', 'ch_TYgel5SQX1694622914', 'MVXq1694622915.pdf', '2023-09-13 10:35:14', '2023-09-13 10:35:16', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(25, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'P4X8-1694622967', 8, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_6wubx5hB1694622967', 'ch_4hqkejohs1694622967', 'bm8J1694622969.pdf', '2023-09-13 10:36:07', '2023-09-13 10:36:09', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 1.92, 0.00, NULL, NULL, NULL),
(26, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'Gn3J-1694622994', 9, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_5t24FsTm1694622994', 'ch_9McDvOWwy1694622994', 'Zix81694622995.pdf', '2023-09-13 10:36:34', '2023-09-13 10:36:36', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(27, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'deBc-1694623043', 10, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_wnbuOJqY1694623043', 'ch_uQNE0Bssw1694623043', 'kYYK1694623044.pdf', '2023-09-13 10:37:23', '2023-09-13 10:37:25', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(28, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'HOFd-1694623085', 11, NULL, NULL, NULL, 0, 'Completed', 'received', 'txn_dLJHSKqp1694623085', 'ch_ykSUPai5y1694623085', 'EkIW1694623087.pdf', '2023-09-13 10:38:05', '2023-09-13 17:44:35', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', 1.92, 0.00, NULL, NULL, NULL),
(29, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'cash', 'offline', 'USD', 'right', 0x24, 'left', 'ggpZ-1694628872', 12, NULL, NULL, NULL, 0, 'Pending', 'pending', 'txn_Fh9VfP9I1694628872', 'ch_15nMy6i5L1694628872', 'iYIq1694628872.pdf', '2023-09-13 12:14:32', '2023-09-13 12:14:32', 'e3d90d8e94639135ab798a7a1fef5b86bd373fdb.jpeg', NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '7', 1.92, 0.00, NULL, NULL, NULL),
(30, NULL, 14, 42, NULL, 'genius test', NULL, NULL, NULL, 'pratik.anwar@gmail.com', NULL, '3243263413', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9.36, NULL, NULL, 'USD', 'right', 0x24, 'left', 'TMRW-1695831926', 13, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, '2Jcc1695831928.pdf', '2023-09-27 16:25:26', '2023-09-27 16:25:28', NULL, NULL, 'no', 'pos', 'on_table', NULL, NULL, NULL, '1', 0.36, 0.00, NULL, NULL, NULL),
(32, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15.60, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'FqKG-1696934573', 15, NULL, NULL, NULL, 0, 'Completed', 'pending', '97W54627VF510761U', 'PAYID-MUSSVMI7PS03056BF307463M', 'mEMT1696934587.pdf', '2023-10-10 04:42:53', '2023-10-10 04:43:07', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '1', 0.60, 0.00, NULL, NULL, NULL),
(33, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 59.28, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'XDdf-1697471750', 16, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_CvS9pPaB1697471750', 'ch_MytrJSzx61697471750', 'uaFI1697471751.pdf', '2023-10-16 09:55:50', '2023-10-16 09:55:52', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 2.28, 0.00, NULL, NULL, NULL),
(34, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16.64, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'Cwxh-1697471822', 17, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_v2rwYcKu1697471822', 'ch_IaiMcCiec1697471822', 's9eK1697471823.pdf', '2023-10-16 09:57:02', '2023-10-16 09:57:04', NULL, NULL, 'no', 'qr', 'on_table', NULL, NULL, NULL, '5', 0.64, 0.00, NULL, NULL, NULL),
(35, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 172.64, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'kgC0-1697794896', 18, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_IzHNOcZI1697794896', 'ch_shVnauub31697794896', 'gT6N1697794897.pdf', '2023-10-20 03:41:36', '2023-10-20 03:41:38', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '8', 6.64, 0.00, NULL, NULL, NULL),
(36, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 66.56, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'OpTu-1697800640', 19, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-10-20 05:17:20', '2023-10-20 05:17:20', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 2.56, 0.00, NULL, NULL, NULL),
(37, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 66.56, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'BmYB-1697801338', 20, NULL, NULL, NULL, 0, 'Completed', 'pending', '59D68801D1406304G', 'PAYID-MUZGI7I6K350558KL712053M', 'MHAt1697801366.pdf', '2023-10-20 05:28:58', '2023-10-20 05:29:26', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 2.56, 0.00, NULL, NULL, NULL),
(38, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '0xlT-1697809858', 21, NULL, NULL, NULL, 0, 'Completed', 'pending', '1Y469247YJ128852X', 'PAYID-MUZILRI4NB85790UH378645D', 'ZQDo1697809884.pdf', '2023-10-20 07:50:58', '2023-10-20 07:51:25', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 1.92, 0.00, NULL, NULL, NULL),
(39, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49.92, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'qMQ4-1697810210', 22, NULL, NULL, NULL, 0, 'Completed', 'pending', '8WF05096WG528442G', 'PAYID-MUZIOJA1UP51506X2090634F', '93YD1697810228.pdf', '2023-10-20 07:56:50', '2023-10-20 07:57:08', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 1.92, 0.00, NULL, NULL, NULL),
(40, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 68.64, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'HPtn-1697810301', 23, NULL, NULL, NULL, 0, 'Completed', 'pending', '0HR78295997393201', 'PAYID-MUZIO7Y63084296JM3100102', 'Kk691697810320.pdf', '2023-10-20 07:58:21', '2023-10-20 07:58:40', NULL, NULL, 'no', 'qr', 'on_table', NULL, NULL, NULL, '5', 2.64, 0.00, NULL, NULL, NULL),
(41, NULL, 14, 42, NULL, 'genius test', NULL, NULL, NULL, 'pratik.anwar@gmail.com', NULL, '3243263413', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24.96, NULL, NULL, 'USD', 'right', 0x24, 'left', 'rx0R-1697810579', 24, NULL, NULL, NULL, 0, 'Completed', 'pending', NULL, NULL, 'ylfD1697810580.pdf', '2023-10-20 14:02:59', '2023-10-20 14:03:01', NULL, NULL, 'no', 'pos', 'on_table', NULL, NULL, NULL, '1', 0.96, 0.00, NULL, NULL, NULL),
(42, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 127.05, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'B7kA-1697815988', 25, NULL, NULL, NULL, 0, 'Completed', 'pending', '8X539142BM348570J', 'PAYID-MUZJ3NY9V256162VN096841G', 'Lux21697816016.pdf', '2023-10-20 09:33:08', '2023-10-20 09:33:36', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 4.05, 0.00, NULL, NULL, NULL),
(43, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 43.50, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '9Rhv-1697817402', 26, NULL, NULL, NULL, 0, 'Completed', 'pending', '77W85241VK265515F', 'PAYID-MUZKGPA5J479566508330000', '9mLl1697817425.pdf', '2023-10-20 09:56:42', '2023-10-20 09:57:08', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 1.50, 0.00, NULL, NULL, NULL),
(44, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 70.72, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'pYn4-1698158896', NULL, NULL, 0.00, 'ps 1 - 1230', 1, 'Completed', 'pending', '69Y99098YR6545345', 'PAYID-MU35SNA0VC9436894180101T', 'QUaG1698158925.pdf', '2023-10-24 08:48:16', '2023-10-24 08:48:48', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 2.72, 0.00, NULL, NULL, NULL),
(45, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 87.36, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'TQ60-1698159035', NULL, NULL, 0.00, 'ps 2 - 1222', 1, 'Completed', 'pending', '26530758NK344044A', 'PAYID-MU35TPI55M41136PX730425G', '2z8t1698159057.pdf', '2023-10-24 08:50:35', '2023-10-24 08:51:00', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 3.36, 0.00, NULL, NULL, NULL),
(46, 1, 14, 42, 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 'Italy', 'genius', 'test', 'Rome, Italy', 'Rome', 'geniustest11@gmail.com', '+880', '1689583182', 49.66, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'NLOo-1698159228', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', '7BL57808G2286690U', 'PAYID-MU35U7Q7GT71116G0144724N', 'aaYZ1698159249.pdf', '2023-10-24 08:53:48', '2023-10-24 08:54:11', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.66, 0.00, NULL, NULL, NULL),
(47, 1, 14, 42, NULL, 'genius', NULL, NULL, NULL, 'geniustest11@gmail.com', '+880', '1689583182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 32.24, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'b3e2-1698159346', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', '7PN767142W170172C', 'PAYID-MU35V5A55767440JU417971L', 'X5b21698159365.pdf', '2023-10-24 08:55:46', '2023-10-24 08:56:07', NULL, NULL, 'no', 'website', 'pick_up', '10/26/2023', '02:00 AM', NULL, NULL, 1.24, 0.00, NULL, NULL, NULL),
(48, NULL, 14, 42, NULL, 'Samiul Alim Pratik', NULL, NULL, NULL, 'pratik.anwar@gmail.com', '+880', '16895831821', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 95.79, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'ruE8-1701176433', 27, NULL, NULL, NULL, 0, 'Completed', 'pending', 'txn_YT34WaMG1701176433', 'ch_ptDaOFz6z1701176433', 'GOEW1701176435.pdf', '2023-11-28 13:00:33', '2023-11-28 13:00:37', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '5', 2.79, 0.00, NULL, NULL, NULL),
(49, NULL, 14, 42, 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'pratik.anwar@gmail.com', '+880', '1689583182', 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'pratik.anwar@gmail.com', '+880', '1689583182', 75.43, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'm2Md-1701176617', NULL, 'sc 1', 10.00, NULL, 0, 'Completed', 'pending', '97V63417P30479934', 'PAYID-MVS6KLA315902296J697662U', 'n9CV1701176647.pdf', '2023-11-28 13:03:37', '2023-11-28 13:04:10', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 2.43, 0.00, NULL, NULL, NULL),
(50, 6, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+880', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9.00, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'xMSt-1701921970', 28, NULL, NULL, NULL, 0, 'Completed', 'pending', '5KY78875WV535413N', 'PAYID-MVYUJNQ7HY80665B3719032G', 'aKeh1701921992.pdf', '2023-12-07 04:06:10', '2023-12-07 04:06:37', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '3', 0.00, 0.00, NULL, NULL, NULL),
(51, 6, 14, 42, NULL, 'Vaughan Moss', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+355', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 33.00, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'kqHi-1701923419', 29, NULL, NULL, NULL, 0, 'Completed', 'pending', '8JR80876CX651824P', 'PAYID-MVYUUXQ1R3533312S633163G', '8xtf1701923442.pdf', '2023-12-07 04:30:19', '2023-12-07 04:30:44', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '10', 0.00, 0.00, NULL, NULL, NULL),
(52, 5, 14, 42, NULL, '1', NULL, NULL, NULL, 'kikovulyli@mailinator.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24.00, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'oiyM-1701924629', 30, NULL, NULL, NULL, 0, 'Completed', 'pending', '2A142947YR418574L', 'PAYID-MVYU6GA5XF13676F3989083Y', 'L7xX1701924653.pdf', '2023-12-07 04:50:29', '2023-12-07 04:50:55', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '66', 0.00, 0.00, NULL, NULL, NULL),
(53, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22.00, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'xFb3-1702092580', 31, NULL, NULL, NULL, 0, 'Completed', 'pending', '26T99694KC2733741', 'PAYID-MVZ56JY6YL928383F536405S', 'sMjw1702092597.pdf', '2023-12-09 03:29:40', '2023-12-09 03:29:59', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '22', 0.00, 0.00, NULL, NULL, NULL),
(54, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+355', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13.52, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'nCUm-1702097932', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', '6JH12921LG680881P', 'PAYID-MVZ7IDY93S700394H9440944', 'EQvO1702097953.pdf', '2023-12-09 04:58:52', '2023-12-09 04:59:15', NULL, NULL, 'no', 'website', 'pick_up', '12/20/2023', '07:30 PM', NULL, NULL, 0.52, 0.00, NULL, NULL, NULL),
(55, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+880', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13.52, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '7z8r-1702098852', NULL, NULL, NULL, NULL, 0, 'Completed', 'received', '946729745V148034C', 'PAYID-MVZ7PJQ46755898GD2397332', '98fb1702098888.pdf', '2023-12-09 05:14:12', '2023-12-10 22:08:08', NULL, NULL, 'no', 'website', 'pick_up', '12/27/2023', '01:30 AM', NULL, NULL, 0.52, 0.00, NULL, NULL, NULL),
(56, 5, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 143.30, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'OcKx-1702110212', 1, NULL, NULL, NULL, 0, 'Completed', 'pending', '5LF87818LD677104C', 'PAYID-MV2CIBY21P32464DJ1163441', '5NLH1702110241.pdf', '2023-12-09 08:23:32', '2023-12-09 08:24:02', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '3', 5.30, 0.00, NULL, NULL, NULL),
(57, 5, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24.72, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'hwBW-1702274822', 2, NULL, NULL, NULL, 0, 'Completed', 'pending', '75A11725S1235364Y', 'PAYID-MV3KOCI4U189085WF700592U', 'J84T1702274844.pdf', '2023-12-11 06:07:02', '2023-12-16 23:07:51', NULL, NULL, 'yes', 'qr', 'on_table', NULL, NULL, NULL, '33', 0.72, 0.00, NULL, NULL, NULL),
(58, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '3jSB-1702449250', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-13 01:34:10', '2023-12-13 01:34:10', NULL, NULL, 'no', 'website', 'pick_up', '12/18/2023', '01:30 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(59, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'TNOg-1702449910', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-13 01:45:10', '2023-12-13 01:45:10', NULL, NULL, 'no', 'website', 'pick_up', '12/18/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(60, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'qyQh-1702450224', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-13 06:50:24', '2023-12-13 06:50:24', NULL, NULL, 'no', 'website', 'pick_up', '12/14/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(61, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'N1EF-1702450250', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-13 03:50:50', '2023-12-13 03:50:50', NULL, NULL, 'no', 'website', 'pick_up', '12/14/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(62, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'msYl-1702450440', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-12 19:54:00', '2023-12-12 19:54:00', NULL, NULL, 'no', 'website', 'pick_up', '12/14/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(63, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '1dwh-1702450476', NULL, NULL, NULL, NULL, 0, 'Pending', 'pending', NULL, NULL, NULL, '2023-12-13 06:54:36', '2023-12-13 06:54:36', NULL, NULL, 'no', 'website', 'pick_up', '12/14/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(64, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+93', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'AVYl-1702450579', NULL, NULL, NULL, NULL, 0, 'Completed', 'pending', '1VG078920A525044P', 'PAYID-MV4VLFI92Y82442H31302015', 'LQsW1702450613.pdf', '2023-12-13 06:56:19', '2023-12-13 06:56:56', NULL, NULL, 'no', 'website', 'pick_up', '12/14/2023', '12:00 AM', NULL, NULL, 3.08, 0.00, NULL, NULL, NULL),
(65, NULL, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20.60, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'nsyg-1702791875', 3, NULL, NULL, NULL, 0, 'Completed', 'pending', '2HN21968E5562422E', 'PAYID-MV7IVRQ0P5423265F324431L', 'uXuM1702791891.pdf', '2023-12-17 05:44:35', '2023-12-16 23:07:39', NULL, NULL, 'yes', 'qr', 'on_table', NULL, NULL, 'dfgdfgdf', 'dfgdfgdfgdfg', 0.60, 0.00, NULL, NULL, NULL),
(67, 6, 14, 42, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+7840', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20.20, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'LD6T-1702969507', 33, NULL, NULL, NULL, 0, 'Completed', 'pending', '7SS74887DT522823E', 'PAYID-MWAUBJA77B17949R2023810M', 'ornL1702969521.pdf', '2023-12-19 07:05:07', '2023-12-19 07:05:23', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '2', 0.20, 0.00, NULL, NULL, NULL),
(68, NULL, 14, 42, NULL, 'Samiul Alim Pratik', NULL, NULL, NULL, 'pratik.anwar@gmail.com', '+880', '16895831821', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 300.87, 'paypal', 'online', 'USD', 'right', 0x24, 'left', '0uUD-1703345825', 34, NULL, NULL, NULL, 0, 'Completed', 'pending', '9PA067231W197274V', 'PAYID-MWDP5JA6U1727993H114005P', 'WiWR1703345854.pdf', '2023-12-23 07:37:05', '2023-12-23 07:37:36', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', -3.21, 57.92, NULL, NULL, NULL),
(69, NULL, 14, 42, 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'geniustest11@gmail.com', '+880', '16895831821', 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'geniustest11@gmail.com', '+880', '1689583182', 35.28, 'stripe', 'online', 'USD', 'right', 0x24, 'left', 'L0yL-1703596086', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_ZURqKTKt1703596086', 'ch_BGO9DQMo71703596086', 'biN21703596087.pdf', '2023-12-26 05:08:06', '2023-12-26 05:08:07', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.28, 0.00, '31/12/2023', NULL, NULL),
(70, NULL, 14, 90, NULL, 'Samiul Alim Pratik', NULL, NULL, NULL, 'pratik.anwar@gmail.com', '+880', '16895831821', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 300.87, 'paypal', 'online', 'USD', 'right', NULL, 'left', '0uUD-1703345825', 34, NULL, NULL, NULL, 0, 'Completed', 'pending', '9PA067231W197274V', 'PAYID-MWDP5JA6U1727993H114005P', 'WiWR1703345854.pdf', '2023-12-23 07:37:05', '2023-12-23 07:37:36', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '6', -3.21, 57.92, NULL, NULL, NULL),
(71, NULL, 14, 90, 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'geniustest11@gmail.com', '+880', '16895831821', 'Bangladesh', 'Samiul Alim', 'Pratik', 'House - 44, Road, - 3, Sector - 11, Uttara, Dhaka', 'Dhaka', 'geniustest11@gmail.com', '+880', '1689583182', 35.28, 'stripe', 'online', 'USD', 'right', NULL, 'left', 'L0yL-1703596086', NULL, NULL, 2.00, 'ps 2 - 1222', 1, 'Completed', 'pending', 'txn_ZURqKTKt1703596086', 'ch_BGO9DQMo71703596086', 'biN21703596087.pdf', '2023-12-26 05:08:06', '2023-12-26 05:08:07', NULL, NULL, 'no', 'website', 'home_delivery', NULL, NULL, NULL, NULL, 1.28, 0.00, '31/12/2023', NULL, NULL),
(80, 5, 14, 91, NULL, 'Imran', NULL, NULL, NULL, 'imranyeasin75@gmail.com', '+880', '1919921118', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 80.08, 'paypal', 'online', 'USD', 'right', 0x24, 'left', 'Z6fx-1703937938', 38, NULL, NULL, NULL, 0, 'Completed', 'pending', '37413454VY699514N', 'PAYID-MWIAPFA6K7399345W6036844', '4pPU1703938128.pdf', '2023-12-30 12:05:38', '2023-12-30 12:08:49', NULL, NULL, 'no', 'website', 'on_table', NULL, NULL, NULL, '11', 3.08, 0.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `review` int DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `customer_id`, `user_id`, `product_id`, `review`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 24, 3, 'fgdfgdfgdfg', '2023-10-11 20:35:25', '2023-10-11 20:35:25'),
(2, 1, 14, 26, NULL, 'sfdfsdfsdfsdf', '2023-10-11 20:36:29', '2023-10-11 20:37:22'),
(3, 1, 14, 23, NULL, 'fgddfgdfgfdg', '2023-10-11 21:03:52', '2023-10-11 21:03:52'),
(5, 6, 14, 24, 4, 'etewrtert', '2023-12-07 04:17:47', '2023-12-07 04:17:47'),
(6, 6, 14, 27, 5, 'adasdasdasd', '2023-12-07 04:46:31', '2023-12-07 04:47:15'),
(7, 5, 14, 27, 2, NULL, '2023-12-07 04:52:44', '2023-12-07 05:13:53'),
(8, 6, 14, 34, 4, NULL, '2023-12-19 07:06:41', '2023-12-19 07:06:41');

-- --------------------------------------------------------

--
-- Table structure for table `psub_categories`
--

CREATE TABLE `psub_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `language_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int DEFAULT NULL,
  `is_feature` tinyint NOT NULL DEFAULT '0',
  `indx` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `psub_categories`
--

INSERT INTO `psub_categories` (`id`, `user_id`, `language_id`, `category_id`, `name`, `slug`, `status`, `is_feature`, `indx`, `created_at`, `updated_at`) VALUES
(24, 7, 10, 31, 'First Subcategory', 'First-Subcategory', 1, 0, NULL, '2023-09-10 03:10:52', '2023-09-10 03:10:52'),
(25, 14, 19, 32, 'subcat en 11', 'subcat-en-11', 0, 0, '6523cb08ca5cf', '2023-09-10 15:45:51', '2023-12-25 02:55:20'),
(26, 14, 19, 33, 'subcat en 21', 'subcat-en-21', 1, 0, '6523cb54eb656', '2023-09-10 15:46:06', '2023-09-10 15:46:06'),
(27, 14, 19, 32, 'subcat en 12', 'subcat-en-12', 1, 1, '6523cb67d8bc5', '2023-09-10 15:46:21', '2023-11-27 09:35:30'),
(29, 14, 21, 32, 'subcat ar 11', 'subcat-ar-11', 0, 0, '6523cb08ca5cf', '2023-09-26 14:40:43', '2023-12-25 02:55:20'),
(30, 14, 21, 35, 'subcat ar 21', 'subcat-ar-21', 1, 0, '6523cb54eb656', '2023-09-26 14:41:01', '2023-09-26 14:41:01'),
(32, 14, 21, 32, 'subcat ar 12', 'subcat-ar-12', 1, 0, '6523cb67d8bc5', '2023-09-26 14:41:40', '2023-11-27 09:35:30');

-- --------------------------------------------------------

--
-- Table structure for table `push_subscriptions`
--

CREATE TABLE `push_subscriptions` (
  `id` int UNSIGNED NOT NULL,
  `subscribable_id` int DEFAULT NULL,
  `subscribable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endpoint` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_encoding` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `push_subscriptions`
--

INSERT INTO `push_subscriptions` (`id`, `subscribable_id`, `subscribable_type`, `endpoint`, `public_key`, `auth_token`, `content_encoding`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Guest', 'https://fcm.googleapis.com/fcm/send/fUtUUAwK6r4:APA91bFeSP7KJ6Vrjs5Sku8m5tQB_TOdMGsu3kbyf6rBNe_UcZIzP4AVzsKrrCqiMWRCV9idAI9I6k82ld-8GpGtNDKZ5pD5quB9TXUYEl5fV80QBXPHdvBE1_7VAcH1zaHsq4J5Wy7e', 'BMLT3rb-Xu2YnV-z6ZE7cZNalNneBDSkWAIvzXgCUrfD08PBTKsSSN4W-WflrY1LR6fwmhZLDL5LvK79G8C4mcA', 'O1MjAaRieQgezf6d-s3vHg', NULL, '2023-12-20 07:15:44', '2023-12-20 07:15:44'),
(2, 2, 'App\\Models\\Guest', 'https://fcm.googleapis.com/fcm/send/doJFJNI9pK0:APA91bHUrCnvPsJrwRV3c78ET15Xhtpe8lEiNfS3vmeoFpmQf_EbC7O_USqVnZZqfyBrAhGZ2yYQo3GldQr1asnuSavjI34J-zq2l3E_Pkr4beJdhy2oVo5hjlohctyBdd3AMrNqLT2j', 'BH2Fw_cQ-emhNpyutu0gFoTcAR6olZGsX9h688YvsJnc0PvzEXHF67ZP07-6p0MORDpbyI9C8TF_UGMYpr-Xxxw', '2IM6wc-dCcCKQ6VvHkxuPw', NULL, '2023-12-23 06:42:23', '2023-12-23 06:42:23'),
(3, 3, 'App\\Models\\Guest', 'https://fcm.googleapis.com/fcm/send/fc2b9a-GNnE:APA91bEF22XzYVf4-r9xCkDAxTxQpjP6LFAe77ycWIE1LhVuKpWZc8NVKHWoSwzUXZQKr2zhQt2Rg7ExYxQ0TNqPL1Mtl0QVN5UqbNCyqouAna3HQWtMF1D0ResH35-Onsy8NyULwQJh', 'BHQr7063DpAOzH0X4HGJGdMtvfQdgkhDkMqSJnfgkNj5IFopAjfzUmvg49q46e_iiTTRnGP7hOmgygrI3ZzxmbU', 'pSyG-Rsc-tL2Mkp3ZlMaLQ', NULL, '2023-12-25 00:08:48', '2023-12-25 00:08:48');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_inputs`
--

CREATE TABLE `reservation_inputs` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `type` tinyint DEFAULT NULL COMMENT '1-text, 2-select, 3-checkbox, 4-textarea, 5-datepicker, 6-timepicker',
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placeholder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required` tinyint NOT NULL DEFAULT '0' COMMENT '1 - required, 0 - optional',
  `order_number` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation_inputs`
--

INSERT INTO `reservation_inputs` (`id`, `language_id`, `user_id`, `type`, `label`, `name`, `placeholder`, `required`, `order_number`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 1, 'text field', 'text_field', 'text field', 1, 1, '2023-10-11 08:34:34', '2023-10-11 08:34:34'),
(2, 19, 14, 7, 'Number Field', 'Number_Field', 'Number Field', 1, 2, '2023-10-11 08:34:41', '2023-10-11 08:34:41'),
(3, 19, 14, 2, 'select field', 'select_field', 'Select', 1, 3, '2023-10-11 08:35:19', '2023-10-11 08:35:19'),
(4, 19, 14, 3, 'Checkbox', 'Checkbox', NULL, 1, 4, '2023-10-11 08:35:37', '2023-10-11 08:35:37'),
(5, 19, 14, 4, 'Textarea Field', 'Textarea_Field', 'Textarea Field', 1, 5, '2023-10-11 08:35:57', '2023-10-11 08:35:57'),
(6, 19, 14, 5, 'Select Date', 'Select_Date', 'Choose One', 1, 6, '2023-10-11 08:36:07', '2023-10-11 08:36:07'),
(7, 19, 14, 6, 'Timepicker', 'Timepicker', 'Select One', 1, 7, '2023-10-11 08:36:18', '2023-10-11 08:36:18');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_input_options`
--

CREATE TABLE `reservation_input_options` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `reservation_input_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation_input_options`
--

INSERT INTO `reservation_input_options` (`id`, `user_id`, `reservation_input_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 14, 3, '1', '2023-10-11 08:35:19', '2023-10-11 08:35:19'),
(2, 14, 3, '2', '2023-10-11 08:35:19', '2023-10-11 08:35:19'),
(3, 14, 3, '3', '2023-10-11 08:35:19', '2023-10-11 08:35:19'),
(4, 14, 4, 'Checkbox', '2023-10-11 08:35:37', '2023-10-11 08:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(7, 'Delivery Manager', '[\"Dashboard\",\"Order Management\"]', '2020-09-24 00:13:52', '2021-05-21 05:28:11'),
(8, 'Kitchen Manager', '[\"Dashboard\",\"Table Reservation\",\"Product Management\",\"Order Management\"]', '2020-09-28 11:23:56', '2020-12-31 05:45:18');

-- --------------------------------------------------------

--
-- Table structure for table `seos`
--

CREATE TABLE `seos` (
  `id` int NOT NULL,
  `language_id` int DEFAULT NULL,
  `home_meta_keywords` text,
  `home_meta_description` text,
  `profiles_meta_keywords` text,
  `profiles_meta_description` text,
  `pricing_meta_keywords` text,
  `pricing_meta_description` text,
  `blogs_meta_keywords` text,
  `blogs_meta_description` text,
  `faqs_meta_keywords` text,
  `faqs_meta_description` text,
  `contact_meta_keywords` text,
  `contact_meta_description` text,
  `login_meta_keywords` text,
  `login_meta_description` text,
  `forget_password_meta_keywords` text,
  `forget_password_meta_description` text,
  `checkout_meta_keywords` text,
  `checkout_meta_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `seos`
--

INSERT INTO `seos` (`id`, `language_id`, `home_meta_keywords`, `home_meta_description`, `profiles_meta_keywords`, `profiles_meta_description`, `pricing_meta_keywords`, `pricing_meta_description`, `blogs_meta_keywords`, `blogs_meta_description`, `faqs_meta_keywords`, `faqs_meta_description`, `contact_meta_keywords`, `contact_meta_description`, `login_meta_keywords`, `login_meta_description`, `forget_password_meta_keywords`, `forget_password_meta_description`, `checkout_meta_keywords`, `checkout_meta_description`) VALUES
(1, 176, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `serving_methods`
--

CREATE TABLE `serving_methods` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateways` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `serial_number` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `website_menu` tinyint NOT NULL DEFAULT '1' COMMENT '0 - deactive on website menu, 1 - active on website menu',
  `qr_menu` tinyint NOT NULL DEFAULT '1' COMMENT '0 - deactive on qr menu, 1 - active on qr menu',
  `qr_payment` tinyint NOT NULL DEFAULT '0' COMMENT '0 - deactive, 1 - active',
  `pos` tinyint NOT NULL DEFAULT '1' COMMENT '1 - active for POS, 0 - deactive for POS'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `serving_methods`
--

INSERT INTO `serving_methods` (`id`, `user_id`, `name`, `value`, `gateways`, `serial_number`, `note`, `website_menu`, `qr_menu`, `qr_payment`, `pos`) VALUES
(75, 7, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(76, 7, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(77, 7, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(90, 13, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(91, 13, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(92, 13, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(93, 14, 'On Table', 'on_table', '[\"1\"]', 1, NULL, 1, 1, 0, 1),
(94, 14, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(95, 14, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(102, 28, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(103, 28, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(104, 28, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(138, 40, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(139, 40, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(140, 40, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(141, 42, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(142, 42, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(143, 42, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(144, 43, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(145, 43, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(146, 43, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1),
(147, 44, 'On Table', 'on_table', NULL, 1, NULL, 1, 1, 0, 1),
(148, 44, 'Pick Up', 'pick_up', NULL, 2, NULL, 1, 1, 0, 1),
(149, 44, 'Home Delivery', 'home_delivery', NULL, 3, NULL, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_charges`
--

CREATE TABLE `shipping_charges` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `free_delivery_amount` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_charges`
--

INSERT INTO `shipping_charges` (`id`, `title`, `language_id`, `user_id`, `text`, `charge`, `created_at`, `updated_at`, `free_delivery_amount`) VALUES
(1, 'sc 1', 19, 14, 'by accident, sometimes on purpose (injected humour and the like).', 10.00, '2023-09-12 15:39:23', '2023-10-12 04:49:51', 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `sitemaps`
--

CREATE TABLE `sitemaps` (
  `id` bigint UNSIGNED NOT NULL,
  `sitemap_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sitemaps`
--

INSERT INTO `sitemaps` (`id`, `sitemap_url`, `filename`, `created_at`, `updated_at`) VALUES
(5, 'https://codecanyon.net/', 'sitemap658160374f76f.xml', '2023-12-18 20:20:31', '2023-12-18 20:20:31'),
(6, 'https://businesso.xyz/', 'sitemap658acd077980b.xml', '2023-12-25 23:56:41', '2023-12-25 23:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_url1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `title_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_font_size` int NOT NULL DEFAULT '60',
  `text_font_size` int NOT NULL DEFAULT '18',
  `button_text_font_size` int NOT NULL DEFAULT '14',
  `button_text1_font_size` int NOT NULL DEFAULT '14'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `language_id`, `user_id`, `text`, `title`, `button_text`, `button_url`, `button_text1`, `button_url1`, `image`, `bg_image`, `serial_number`, `created_at`, `updated_at`, `title_color`, `text_color`, `button_color`, `title_font_size`, `text_font_size`, `button_text_font_size`, `button_text1_font_size`) VALUES
(1, 19, 14, 'nt of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-l', 'blished fact that a reader will be distrac', 'Shop Now', 'http://example.com/', NULL, NULL, '0fbac5db0edc17476753571cfd97236306494159.png', '577d03f02dddc4c8236bb9cb3abe4482c1931c29.jpg', 1, '2023-09-28 09:48:47', '2023-09-28 09:48:47', '3254FF', '252525', '161EFF', 30, 18, 18, 14),
(2, 19, 14, 'of a page when looking at its l', 'English. Many desktop publishing packages and web pag', 'Shop Now', 'http://example.com/', 'Book a Table', 'https://megasoft.biz/plusagency/about-us/page', '5f25f10651a72dda050816cc996b624f88bc9a75.png', 'afb8665071fa77d103913b8062707d4354ba4651.png', 1, '2023-09-28 09:51:48', '2023-09-28 09:51:48', '7486FF', 'FF93A8', 'FF1837', 48, 18, 18, 14);

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `id` int NOT NULL,
  `icon` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `serial_number` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `socials`
--

INSERT INTO `socials` (`id`, `icon`, `url`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 'fab fa-accusoft iconpicker-component', 'https://www.youtube.com/', 3, '2024-01-05 21:13:11', '2024-01-05 21:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'user1@gmail.com', NULL, NULL),
(2, 'user5@gmail.com', NULL, NULL),
(8, 'ben@gmail.com', NULL, NULL),
(9, 'drop_your_cv@plusagency.com', NULL, NULL),
(10, 'user34@gmail.com', NULL, NULL),
(12, 'client@gmail.com', NULL, NULL),
(14, 'user@gmail.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `table_no` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1' COMMENT '1 - active, 2 - deactive',
  `qr_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `size` int NOT NULL DEFAULT '250',
  `style` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'square',
  `eye_style` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'square',
  `margin` int NOT NULL DEFAULT '0',
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '000000',
  `text_size` int DEFAULT '15',
  `text_x` int NOT NULL DEFAULT '50',
  `text_y` int NOT NULL DEFAULT '50',
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int NOT NULL DEFAULT '20',
  `image_x` int NOT NULL DEFAULT '50',
  `image_y` int NOT NULL DEFAULT '50',
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' COMMENT 'default, image, text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `user_id`, `table_no`, `status`, `qr_image`, `color`, `size`, `style`, `eye_style`, `margin`, `text`, `text_color`, `text_size`, `text_x`, `text_y`, `image`, `image_size`, `image_x`, `image_y`, `type`) VALUES
(1, 14, 1, 1, '6501df54b0da3.png', '000000', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default'),
(2, 14, 2, 1, '6501df5b5a831.png', '000000', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default'),
(3, 14, 3, 1, '6537e39f22155.png', '5542FF', 250, 'square', 'square', 0, 'pro', 'FF1673', 15, 50, 50, 'be31a16d0ad872d0b650c4e7e46ef8c5ef4c01b7.jpg', 20, 91, 89, 'text'),
(4, 14, 4, 1, '658954869057e.png', '000000', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image');

-- --------------------------------------------------------

--
-- Table structure for table `table_books`
--

CREATE TABLE `table_books` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `membership_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fields` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `table_books`
--

INSERT INTO `table_books` (`id`, `user_id`, `membership_id`, `name`, `email`, `fields`, `status`, `created_at`, `updated_at`) VALUES
(1, 14, 42, 'genius test', 'pratik.anwar@gmail.com', '[]', 1, '2023-09-27 10:14:03', '2023-09-27 10:14:03'),
(2, 14, 42, 'Arabic', 'user@gmail.com', '[]', 1, '2023-09-27 10:14:15', '2023-09-27 10:14:15'),
(3, 14, 42, 'Pratik', 'romario@example.com', '[]', 1, '2023-09-27 10:14:29', '2023-09-27 16:15:48'),
(4, 14, 42, 'genius test', 'geniustest11@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"2\",\"select_field\":\"1\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh v\",\"Select_Date\":\"10/10/2023\",\"Timepicker\":\"12:00 AM\"}', 1, '2023-10-24 15:48:03', '2023-10-24 15:48:03'),
(5, 14, 42, 'genius test', 'geniustest11@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"3\",\"select_field\":\"2\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh\",\"Select_Date\":\"10/26/2023\",\"Timepicker\":\"02:00 AM\"}', 1, '2023-10-24 09:50:32', '2023-10-24 09:50:32'),
(6, 14, 42, 'McKenzie Salas', 'pixyvasen@mailinator.com', '{\"text_field\":\"Debitis reprehenderi\",\"Number_Field\":\"856\",\"select_field\":\"2\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"Autem doloremque tem\",\"Select_Date\":\"05-Jan-2020\",\"Timepicker\":\"12:30 AM\"}', 1, '2023-12-04 03:49:29', '2023-12-04 03:49:29'),
(10, 14, 42, 'Imran Hossain', 'imran@gmail.com', '{\"text_field\":\"Cupidatat asperiores\",\"Number_Field\":\"1200\",\"select_field\":\"2\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum isthat it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like\",\"Select_Date\":\"12/19/2023\",\"Timepicker\":\"04:00 AM\"}', 1, '2023-12-19 07:21:48', '2023-12-19 07:21:48'),
(11, 14, 42, 'Fahad', 'fahad@gmail.com', '{\"text_field\":\"Cupidatat asperiores\",\"Number_Field\":\"343443\",\"select_field\":\"3\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"fsdsdsdsdsdsdsdsdsdsdsdfaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa\\r\\naewtwtwtwtwtwtwtwtwtwtwtwtwtwt\",\"Select_Date\":\"12/20/2023\",\"Timepicker\":\"12:30 AM\"}', 1, '2023-12-20 04:27:11', '2023-12-20 04:27:11'),
(12, 14, 42, 'Samiul Alim Pratik', 'pratik.anwar@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"4585454\",\"select_field\":\"2\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh\",\"Select_Date\":\"20/01/2024\",\"Timepicker\":\"12:30 AM\"}', 1, '2023-12-25 02:09:35', '2023-12-25 02:09:35'),
(13, 14, 42, 'genius test', 'pratik.anwar@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"26236\",\"select_field\":\"3\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh v\",\"Select_Date\":\"20/01/2024\",\"Timepicker\":\"07:00 AM\"}', 1, '2023-12-25 02:12:19', '2023-12-25 02:12:19'),
(14, 14, 88, 'Samiul Alim Pratik', 'pratik.anwar@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"4585454\",\"select_field\":\"2\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh sgsdh\",\"Select_Date\":\"20/01/2024\",\"Timepicker\":\"12:30 AM\"}', 1, '2023-12-25 02:09:35', '2023-12-25 02:09:35'),
(15, 14, 88, 'genius test', 'pratik.anwar@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"26236\",\"select_field\":\"3\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh v\",\"Select_Date\":\"20/01/2024\",\"Timepicker\":\"07:00 AM\"}', 1, '2023-12-25 02:12:19', '2023-12-25 02:12:19'),
(16, 14, 88, 'genius test', 'pratik.anwar@gmail.com', '{\"text_field\":\"sgsdh\",\"Number_Field\":\"26236\",\"select_field\":\"3\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sgsdh sgsdh sgsdh sgsdh v\",\"Select_Date\":\"20/01/2024\",\"Timepicker\":\"07:00 AM\"}', 1, '2023-12-25 02:12:19', '2023-12-25 02:12:19'),
(22, 14, 91, 'Cricket', 'imranyeasin75@gmail.com', '{\"text_field\":\"Cupidatat asperiores\",\"Number_Field\":\"33\",\"select_field\":\"1\",\"Checkbox\":[\"Checkbox\"],\"Textarea_Field\":\"sdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdfsdf\",\"Select_Date\":\"30/12/2023\",\"Timepicker\":\"12:30 AM\"}', 1, '2023-12-30 10:54:09', '2023-12-30 10:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `language_id`, `image`, `comment`, `name`, `rank`, `rating`, `serial_number`, `created_at`, `updated_at`) VALUES
(24, 176, '1597736067.png', 'Donec ac quam non elit hendrerit placerat. Pellentesque a est id diam lacinia convallis. Etiam non quam sit amet odio pharetra lacinia. Donec purus enim, ornare ac imperdiet', 'Emma Watson', 'CEO, PlusAgency', 5, 1, NULL, NULL),
(25, 176, '1597749691.png', 'Donec ac quam non elit hendrerit placerat. Pellentesque a est id diam lacinia convallis. Etiam non quam sit amet odio pharetra lacinia. Donec purus enim, ornare ac imperdiet', 'Amelia Hanna', 'Manager, PlusAgency', 5, 4, NULL, NULL),
(28, 176, '1598692556.png', 'Donec ac quam non elit hendrerit placerat. Pellentesque a est id diam lacinia convallis. Etiam non quam sit amet odio pharetra lacinia. Donec purus enim, ornare ac imperdiet', 'Marcos Reus', 'Software Engineer', 5, 2, NULL, NULL),
(29, 176, '1598692612.png', 'Donec ac quam non elit hendrerit placerat. Pellentesque a est id diam lacinia convallis. Etiam non quam sit amet odio pharetra lacinia. Donec purus enim, ornare ac imperdiet', 'Rebeca Isabella', 'CTO, PlusAgency', 5, 3, NULL, NULL),
(30, 177, '1598772950.png', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام', 'إيما واتسون', 'الرئيس التنفيذي لشركة PlusAgency', 5, 1, NULL, NULL),
(31, 177, '1598772999.png', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام', 'اميليا حنا', 'مدير PlusAgency', 5, 2, NULL, NULL),
(32, 177, '1598773050.png', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام', 'ماركوس ريوس', 'مهندس برمجيات', 5, 3, NULL, NULL),
(33, 177, '1598773091.png', 'هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام', 'ريبيكا إيزابيلا', 'CTO ، PlusAgency', 5, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `country_code` char(3) NOT NULL,
  `timezone` varchar(125) NOT NULL DEFAULT '',
  `gmt_offset` float(10,2) DEFAULT NULL,
  `dst_offset` float(10,2) DEFAULT NULL,
  `raw_offset` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`country_code`, `timezone`, `gmt_offset`, `dst_offset`, `raw_offset`) VALUES
('AD', 'Europe/Andorra', 1.00, 2.00, 1.00),
('AE', 'Asia/Dubai', 4.00, 4.00, 4.00),
('AF', 'Asia/Kabul', 4.50, 4.50, 4.50),
('AG', 'America/Antigua', -4.00, -4.00, -4.00),
('AI', 'America/Anguilla', -4.00, -4.00, -4.00),
('AL', 'Europe/Tirane', 1.00, 2.00, 1.00),
('AM', 'Asia/Yerevan', 4.00, 4.00, 4.00),
('AO', 'Africa/Luanda', 1.00, 1.00, 1.00),
('AQ', 'Antarctica/Casey', 8.00, 8.00, 8.00),
('AQ', 'Antarctica/Davis', 7.00, 7.00, 7.00),
('AQ', 'Antarctica/DumontDUrville', 10.00, 10.00, 10.00),
('AQ', 'Antarctica/Mawson', 5.00, 5.00, 5.00),
('AQ', 'Antarctica/McMurdo', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Palmer', -3.00, -4.00, -4.00),
('AQ', 'Antarctica/Rothera', -3.00, -3.00, -3.00),
('AQ', 'Antarctica/South_Pole', 13.00, 12.00, 12.00),
('AQ', 'Antarctica/Syowa', 3.00, 3.00, 3.00),
('AQ', 'Antarctica/Vostok', 6.00, 6.00, 6.00),
('AR', 'America/Argentina/Buenos_Aires', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Catamarca', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Cordoba', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Jujuy', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/La_Rioja', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Mendoza', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Rio_Gallegos', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Salta', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Juan', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/San_Luis', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Tucuman', -3.00, -3.00, -3.00),
('AR', 'America/Argentina/Ushuaia', -3.00, -3.00, -3.00),
('AS', 'Pacific/Pago_Pago', -11.00, -11.00, -11.00),
('AT', 'Europe/Vienna', 1.00, 2.00, 1.00),
('AU', 'Antarctica/Macquarie', 11.00, 11.00, 11.00),
('AU', 'Australia/Adelaide', 10.50, 9.50, 9.50),
('AU', 'Australia/Brisbane', 10.00, 10.00, 10.00),
('AU', 'Australia/Broken_Hill', 10.50, 9.50, 9.50),
('AU', 'Australia/Currie', 11.00, 10.00, 10.00),
('AU', 'Australia/Darwin', 9.50, 9.50, 9.50),
('AU', 'Australia/Eucla', 8.75, 8.75, 8.75),
('AU', 'Australia/Hobart', 11.00, 10.00, 10.00),
('AU', 'Australia/Lindeman', 10.00, 10.00, 10.00),
('AU', 'Australia/Lord_Howe', 11.00, 10.50, 10.50),
('AU', 'Australia/Melbourne', 11.00, 10.00, 10.00),
('AU', 'Australia/Perth', 8.00, 8.00, 8.00),
('AU', 'Australia/Sydney', 11.00, 10.00, 10.00),
('AW', 'America/Aruba', -4.00, -4.00, -4.00),
('AX', 'Europe/Mariehamn', 2.00, 3.00, 2.00),
('AZ', 'Asia/Baku', 4.00, 5.00, 4.00),
('BA', 'Europe/Sarajevo', 1.00, 2.00, 1.00),
('BB', 'America/Barbados', -4.00, -4.00, -4.00),
('BD', 'Asia/Dhaka', 6.00, 6.00, 6.00),
('BE', 'Europe/Brussels', 1.00, 2.00, 1.00),
('BF', 'Africa/Ouagadougou', 0.00, 0.00, 0.00),
('BG', 'Europe/Sofia', 2.00, 3.00, 2.00),
('BH', 'Asia/Bahrain', 3.00, 3.00, 3.00),
('BI', 'Africa/Bujumbura', 2.00, 2.00, 2.00),
('BJ', 'Africa/Porto-Novo', 1.00, 1.00, 1.00),
('BL', 'America/St_Barthelemy', -4.00, -4.00, -4.00),
('BM', 'Atlantic/Bermuda', -4.00, -3.00, -4.00),
('BN', 'Asia/Brunei', 8.00, 8.00, 8.00),
('BO', 'America/La_Paz', -4.00, -4.00, -4.00),
('BQ', 'America/Kralendijk', -4.00, -4.00, -4.00),
('BR', 'America/Araguaina', -3.00, -3.00, -3.00),
('BR', 'America/Bahia', -3.00, -3.00, -3.00),
('BR', 'America/Belem', -3.00, -3.00, -3.00),
('BR', 'America/Boa_Vista', -4.00, -4.00, -4.00),
('BR', 'America/Campo_Grande', -3.00, -4.00, -4.00),
('BR', 'America/Cuiaba', -3.00, -4.00, -4.00),
('BR', 'America/Eirunepe', -5.00, -5.00, -5.00),
('BR', 'America/Fortaleza', -3.00, -3.00, -3.00),
('BR', 'America/Maceio', -3.00, -3.00, -3.00),
('BR', 'America/Manaus', -4.00, -4.00, -4.00),
('BR', 'America/Noronha', -2.00, -2.00, -2.00),
('BR', 'America/Porto_Velho', -4.00, -4.00, -4.00),
('BR', 'America/Recife', -3.00, -3.00, -3.00),
('BR', 'America/Rio_Branco', -5.00, -5.00, -5.00),
('BR', 'America/Santarem', -3.00, -3.00, -3.00),
('BR', 'America/Sao_Paulo', -2.00, -3.00, -3.00),
('BS', 'America/Nassau', -5.00, -4.00, -5.00),
('BT', 'Asia/Thimphu', 6.00, 6.00, 6.00),
('BW', 'Africa/Gaborone', 2.00, 2.00, 2.00),
('BY', 'Europe/Minsk', 3.00, 3.00, 3.00),
('BZ', 'America/Belize', -6.00, -6.00, -6.00),
('CA', 'America/Atikokan', -5.00, -5.00, -5.00),
('CA', 'America/Blanc-Sablon', -4.00, -4.00, -4.00),
('CA', 'America/Cambridge_Bay', -7.00, -6.00, -7.00),
('CA', 'America/Creston', -7.00, -7.00, -7.00),
('CA', 'America/Dawson', -8.00, -7.00, -8.00),
('CA', 'America/Dawson_Creek', -7.00, -7.00, -7.00),
('CA', 'America/Edmonton', -7.00, -6.00, -7.00),
('CA', 'America/Glace_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Goose_Bay', -4.00, -3.00, -4.00),
('CA', 'America/Halifax', -4.00, -3.00, -4.00),
('CA', 'America/Inuvik', -7.00, -6.00, -7.00),
('CA', 'America/Iqaluit', -5.00, -4.00, -5.00),
('CA', 'America/Moncton', -4.00, -3.00, -4.00),
('CA', 'America/Montreal', -5.00, -4.00, -5.00),
('CA', 'America/Nipigon', -5.00, -4.00, -5.00),
('CA', 'America/Pangnirtung', -5.00, -4.00, -5.00),
('CA', 'America/Rainy_River', -6.00, -5.00, -6.00),
('CA', 'America/Rankin_Inlet', -6.00, -5.00, -6.00),
('CA', 'America/Regina', -6.00, -6.00, -6.00),
('CA', 'America/Resolute', -6.00, -5.00, -6.00),
('CA', 'America/St_Johns', -3.50, -2.50, -3.50),
('CA', 'America/Swift_Current', -6.00, -6.00, -6.00),
('CA', 'America/Thunder_Bay', -5.00, -4.00, -5.00),
('CA', 'America/Toronto', -5.00, -4.00, -5.00),
('CA', 'America/Vancouver', -8.00, -7.00, -8.00),
('CA', 'America/Whitehorse', -8.00, -7.00, -8.00),
('CA', 'America/Winnipeg', -6.00, -5.00, -6.00),
('CA', 'America/Yellowknife', -7.00, -6.00, -7.00),
('CC', 'Indian/Cocos', 6.50, 6.50, 6.50),
('CD', 'Africa/Kinshasa', 1.00, 1.00, 1.00),
('CD', 'Africa/Lubumbashi', 2.00, 2.00, 2.00),
('CF', 'Africa/Bangui', 1.00, 1.00, 1.00),
('CG', 'Africa/Brazzaville', 1.00, 1.00, 1.00),
('CH', 'Europe/Zurich', 1.00, 2.00, 1.00),
('CI', 'Africa/Abidjan', 0.00, 0.00, 0.00),
('CK', 'Pacific/Rarotonga', -10.00, -10.00, -10.00),
('CL', 'America/Santiago', -3.00, -4.00, -4.00),
('CL', 'Pacific/Easter', -5.00, -6.00, -6.00),
('CM', 'Africa/Douala', 1.00, 1.00, 1.00),
('CN', 'Asia/Chongqing', 8.00, 8.00, 8.00),
('CN', 'Asia/Harbin', 8.00, 8.00, 8.00),
('CN', 'Asia/Kashgar', 8.00, 8.00, 8.00),
('CN', 'Asia/Shanghai', 8.00, 8.00, 8.00),
('CN', 'Asia/Urumqi', 8.00, 8.00, 8.00),
('CO', 'America/Bogota', -5.00, -5.00, -5.00),
('CR', 'America/Costa_Rica', -6.00, -6.00, -6.00),
('CU', 'America/Havana', -5.00, -4.00, -5.00),
('CV', 'Atlantic/Cape_Verde', -1.00, -1.00, -1.00),
('CW', 'America/Curacao', -4.00, -4.00, -4.00),
('CX', 'Indian/Christmas', 7.00, 7.00, 7.00),
('CY', 'Asia/Nicosia', 2.00, 3.00, 2.00),
('CZ', 'Europe/Prague', 1.00, 2.00, 1.00),
('DE', 'Europe/Berlin', 1.00, 2.00, 1.00),
('DE', 'Europe/Busingen', 1.00, 2.00, 1.00),
('DJ', 'Africa/Djibouti', 3.00, 3.00, 3.00),
('DK', 'Europe/Copenhagen', 1.00, 2.00, 1.00),
('DM', 'America/Dominica', -4.00, -4.00, -4.00),
('DO', 'America/Santo_Domingo', -4.00, -4.00, -4.00),
('DZ', 'Africa/Algiers', 1.00, 1.00, 1.00),
('EC', 'America/Guayaquil', -5.00, -5.00, -5.00),
('EC', 'Pacific/Galapagos', -6.00, -6.00, -6.00),
('EE', 'Europe/Tallinn', 2.00, 3.00, 2.00),
('EG', 'Africa/Cairo', 2.00, 2.00, 2.00),
('EH', 'Africa/El_Aaiun', 0.00, 0.00, 0.00),
('ER', 'Africa/Asmara', 3.00, 3.00, 3.00),
('ES', 'Africa/Ceuta', 1.00, 2.00, 1.00),
('ES', 'Atlantic/Canary', 0.00, 1.00, 0.00),
('ES', 'Europe/Madrid', 1.00, 2.00, 1.00),
('ET', 'Africa/Addis_Ababa', 3.00, 3.00, 3.00),
('FI', 'Europe/Helsinki', 2.00, 3.00, 2.00),
('FJ', 'Pacific/Fiji', 13.00, 12.00, 12.00),
('FK', 'Atlantic/Stanley', -3.00, -3.00, -3.00),
('FM', 'Pacific/Chuuk', 10.00, 10.00, 10.00),
('FM', 'Pacific/Kosrae', 11.00, 11.00, 11.00),
('FM', 'Pacific/Pohnpei', 11.00, 11.00, 11.00),
('FO', 'Atlantic/Faroe', 0.00, 1.00, 0.00),
('FR', 'Europe/Paris', 1.00, 2.00, 1.00),
('GA', 'Africa/Libreville', 1.00, 1.00, 1.00),
('GB', 'Europe/London', 0.00, 1.00, 0.00),
('GD', 'America/Grenada', -4.00, -4.00, -4.00),
('GE', 'Asia/Tbilisi', 4.00, 4.00, 4.00),
('GF', 'America/Cayenne', -3.00, -3.00, -3.00),
('GG', 'Europe/Guernsey', 0.00, 1.00, 0.00),
('GH', 'Africa/Accra', 0.00, 0.00, 0.00),
('GI', 'Europe/Gibraltar', 1.00, 2.00, 1.00),
('GL', 'America/Danmarkshavn', 0.00, 0.00, 0.00),
('GL', 'America/Godthab', -3.00, -2.00, -3.00),
('GL', 'America/Scoresbysund', -1.00, 0.00, -1.00),
('GL', 'America/Thule', -4.00, -3.00, -4.00),
('GM', 'Africa/Banjul', 0.00, 0.00, 0.00),
('GN', 'Africa/Conakry', 0.00, 0.00, 0.00),
('GP', 'America/Guadeloupe', -4.00, -4.00, -4.00),
('GQ', 'Africa/Malabo', 1.00, 1.00, 1.00),
('GR', 'Europe/Athens', 2.00, 3.00, 2.00),
('GS', 'Atlantic/South_Georgia', -2.00, -2.00, -2.00),
('GT', 'America/Guatemala', -6.00, -6.00, -6.00),
('GU', 'Pacific/Guam', 10.00, 10.00, 10.00),
('GW', 'Africa/Bissau', 0.00, 0.00, 0.00),
('GY', 'America/Guyana', -4.00, -4.00, -4.00),
('HK', 'Asia/Hong_Kong', 8.00, 8.00, 8.00),
('HN', 'America/Tegucigalpa', -6.00, -6.00, -6.00),
('HR', 'Europe/Zagreb', 1.00, 2.00, 1.00),
('HT', 'America/Port-au-Prince', -5.00, -4.00, -5.00),
('HU', 'Europe/Budapest', 1.00, 2.00, 1.00),
('ID', 'Asia/Jakarta', 7.00, 7.00, 7.00),
('ID', 'Asia/Jayapura', 9.00, 9.00, 9.00),
('ID', 'Asia/Makassar', 8.00, 8.00, 8.00),
('ID', 'Asia/Pontianak', 7.00, 7.00, 7.00),
('IE', 'Europe/Dublin', 0.00, 1.00, 0.00),
('IL', 'Asia/Jerusalem', 2.00, 3.00, 2.00),
('IM', 'Europe/Isle_of_Man', 0.00, 1.00, 0.00),
('IN', 'Asia/Kolkata', 5.50, 5.50, 5.50),
('IO', 'Indian/Chagos', 6.00, 6.00, 6.00),
('IQ', 'Asia/Baghdad', 3.00, 3.00, 3.00),
('IR', 'Asia/Tehran', 3.50, 4.50, 3.50),
('IS', 'Atlantic/Reykjavik', 0.00, 0.00, 0.00),
('IT', 'Europe/Rome', 1.00, 2.00, 1.00),
('JE', 'Europe/Jersey', 0.00, 1.00, 0.00),
('JM', 'America/Jamaica', -5.00, -5.00, -5.00),
('JO', 'Asia/Amman', 2.00, 3.00, 2.00),
('JP', 'Asia/Tokyo', 9.00, 9.00, 9.00),
('KE', 'Africa/Nairobi', 3.00, 3.00, 3.00),
('KG', 'Asia/Bishkek', 6.00, 6.00, 6.00),
('KH', 'Asia/Phnom_Penh', 7.00, 7.00, 7.00),
('KI', 'Pacific/Enderbury', 13.00, 13.00, 13.00),
('KI', 'Pacific/Kiritimati', 14.00, 14.00, 14.00),
('KI', 'Pacific/Tarawa', 12.00, 12.00, 12.00),
('KM', 'Indian/Comoro', 3.00, 3.00, 3.00),
('KN', 'America/St_Kitts', -4.00, -4.00, -4.00),
('KP', 'Asia/Pyongyang', 9.00, 9.00, 9.00),
('KR', 'Asia/Seoul', 9.00, 9.00, 9.00),
('KW', 'Asia/Kuwait', 3.00, 3.00, 3.00),
('KY', 'America/Cayman', -5.00, -5.00, -5.00),
('KZ', 'Asia/Almaty', 6.00, 6.00, 6.00),
('KZ', 'Asia/Aqtau', 5.00, 5.00, 5.00),
('KZ', 'Asia/Aqtobe', 5.00, 5.00, 5.00),
('KZ', 'Asia/Oral', 5.00, 5.00, 5.00),
('KZ', 'Asia/Qyzylorda', 6.00, 6.00, 6.00),
('LA', 'Asia/Vientiane', 7.00, 7.00, 7.00),
('LB', 'Asia/Beirut', 2.00, 3.00, 2.00),
('LC', 'America/St_Lucia', -4.00, -4.00, -4.00),
('LI', 'Europe/Vaduz', 1.00, 2.00, 1.00),
('LK', 'Asia/Colombo', 5.50, 5.50, 5.50),
('LR', 'Africa/Monrovia', 0.00, 0.00, 0.00),
('LS', 'Africa/Maseru', 2.00, 2.00, 2.00),
('LT', 'Europe/Vilnius', 2.00, 3.00, 2.00),
('LU', 'Europe/Luxembourg', 1.00, 2.00, 1.00),
('LV', 'Europe/Riga', 2.00, 3.00, 2.00),
('LY', 'Africa/Tripoli', 2.00, 2.00, 2.00),
('MA', 'Africa/Casablanca', 0.00, 0.00, 0.00),
('MC', 'Europe/Monaco', 1.00, 2.00, 1.00),
('MD', 'Europe/Chisinau', 2.00, 3.00, 2.00),
('ME', 'Europe/Podgorica', 1.00, 2.00, 1.00),
('MF', 'America/Marigot', -4.00, -4.00, -4.00),
('MG', 'Indian/Antananarivo', 3.00, 3.00, 3.00),
('MH', 'Pacific/Kwajalein', 12.00, 12.00, 12.00),
('MH', 'Pacific/Majuro', 12.00, 12.00, 12.00),
('MK', 'Europe/Skopje', 1.00, 2.00, 1.00),
('ML', 'Africa/Bamako', 0.00, 0.00, 0.00),
('MM', 'Asia/Rangoon', 6.50, 6.50, 6.50),
('MN', 'Asia/Choibalsan', 8.00, 8.00, 8.00),
('MN', 'Asia/Hovd', 7.00, 7.00, 7.00),
('MN', 'Asia/Ulaanbaatar', 8.00, 8.00, 8.00),
('MO', 'Asia/Macau', 8.00, 8.00, 8.00),
('MP', 'Pacific/Saipan', 10.00, 10.00, 10.00),
('MQ', 'America/Martinique', -4.00, -4.00, -4.00),
('MR', 'Africa/Nouakchott', 0.00, 0.00, 0.00),
('MS', 'America/Montserrat', -4.00, -4.00, -4.00),
('MT', 'Europe/Malta', 1.00, 2.00, 1.00),
('MU', 'Indian/Mauritius', 4.00, 4.00, 4.00),
('MV', 'Indian/Maldives', 5.00, 5.00, 5.00),
('MW', 'Africa/Blantyre', 2.00, 2.00, 2.00),
('MX', 'America/Bahia_Banderas', -6.00, -5.00, -6.00),
('MX', 'America/Cancun', -6.00, -5.00, -6.00),
('MX', 'America/Chihuahua', -7.00, -6.00, -7.00),
('MX', 'America/Hermosillo', -7.00, -7.00, -7.00),
('MX', 'America/Matamoros', -6.00, -5.00, -6.00),
('MX', 'America/Mazatlan', -7.00, -6.00, -7.00),
('MX', 'America/Merida', -6.00, -5.00, -6.00),
('MX', 'America/Mexico_City', -6.00, -5.00, -6.00),
('MX', 'America/Monterrey', -6.00, -5.00, -6.00),
('MX', 'America/Ojinaga', -7.00, -6.00, -7.00),
('MX', 'America/Santa_Isabel', -8.00, -7.00, -8.00),
('MX', 'America/Tijuana', -8.00, -7.00, -8.00),
('MY', 'Asia/Kuala_Lumpur', 8.00, 8.00, 8.00),
('MY', 'Asia/Kuching', 8.00, 8.00, 8.00),
('MZ', 'Africa/Maputo', 2.00, 2.00, 2.00),
('NA', 'Africa/Windhoek', 2.00, 1.00, 1.00),
('NC', 'Pacific/Noumea', 11.00, 11.00, 11.00),
('NE', 'Africa/Niamey', 1.00, 1.00, 1.00),
('NF', 'Pacific/Norfolk', 11.50, 11.50, 11.50),
('NG', 'Africa/Lagos', 1.00, 1.00, 1.00),
('NI', 'America/Managua', -6.00, -6.00, -6.00),
('NL', 'Europe/Amsterdam', 1.00, 2.00, 1.00),
('NO', 'Europe/Oslo', 1.00, 2.00, 1.00),
('NP', 'Asia/Kathmandu', 5.75, 5.75, 5.75),
('NR', 'Pacific/Nauru', 12.00, 12.00, 12.00),
('NU', 'Pacific/Niue', -11.00, -11.00, -11.00),
('NZ', 'Pacific/Auckland', 13.00, 12.00, 12.00),
('NZ', 'Pacific/Chatham', 13.75, 12.75, 12.75),
('OM', 'Asia/Muscat', 4.00, 4.00, 4.00),
('PA', 'America/Panama', -5.00, -5.00, -5.00),
('PE', 'America/Lima', -5.00, -5.00, -5.00),
('PF', 'Pacific/Gambier', -9.00, -9.00, -9.00),
('PF', 'Pacific/Marquesas', -9.50, -9.50, -9.50),
('PF', 'Pacific/Tahiti', -10.00, -10.00, -10.00),
('PG', 'Pacific/Port_Moresby', 10.00, 10.00, 10.00),
('PH', 'Asia/Manila', 8.00, 8.00, 8.00),
('PK', 'Asia/Karachi', 5.00, 5.00, 5.00),
('PL', 'Europe/Warsaw', 1.00, 2.00, 1.00),
('PM', 'America/Miquelon', -3.00, -2.00, -3.00),
('PN', 'Pacific/Pitcairn', -8.00, -8.00, -8.00),
('PR', 'America/Puerto_Rico', -4.00, -4.00, -4.00),
('PS', 'Asia/Gaza', 2.00, 3.00, 2.00),
('PS', 'Asia/Hebron', 2.00, 3.00, 2.00),
('PT', 'Atlantic/Azores', -1.00, 0.00, -1.00),
('PT', 'Atlantic/Madeira', 0.00, 1.00, 0.00),
('PT', 'Europe/Lisbon', 0.00, 1.00, 0.00),
('PW', 'Pacific/Palau', 9.00, 9.00, 9.00),
('PY', 'America/Asuncion', -3.00, -4.00, -4.00),
('QA', 'Asia/Qatar', 3.00, 3.00, 3.00),
('RE', 'Indian/Reunion', 4.00, 4.00, 4.00),
('RO', 'Europe/Bucharest', 2.00, 3.00, 2.00),
('RS', 'Europe/Belgrade', 1.00, 2.00, 1.00),
('RU', 'Asia/Anadyr', 12.00, 12.00, 12.00),
('RU', 'Asia/Irkutsk', 9.00, 9.00, 9.00),
('RU', 'Asia/Kamchatka', 12.00, 12.00, 12.00),
('RU', 'Asia/Khandyga', 10.00, 10.00, 10.00),
('RU', 'Asia/Krasnoyarsk', 8.00, 8.00, 8.00),
('RU', 'Asia/Magadan', 12.00, 12.00, 12.00),
('RU', 'Asia/Novokuznetsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Novosibirsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Omsk', 7.00, 7.00, 7.00),
('RU', 'Asia/Sakhalin', 11.00, 11.00, 11.00),
('RU', 'Asia/Ust-Nera', 11.00, 11.00, 11.00),
('RU', 'Asia/Vladivostok', 11.00, 11.00, 11.00),
('RU', 'Asia/Yakutsk', 10.00, 10.00, 10.00),
('RU', 'Asia/Yekaterinburg', 6.00, 6.00, 6.00),
('RU', 'Europe/Kaliningrad', 3.00, 3.00, 3.00),
('RU', 'Europe/Moscow', 4.00, 4.00, 4.00),
('RU', 'Europe/Samara', 4.00, 4.00, 4.00),
('RU', 'Europe/Volgograd', 4.00, 4.00, 4.00),
('RW', 'Africa/Kigali', 2.00, 2.00, 2.00),
('SA', 'Asia/Riyadh', 3.00, 3.00, 3.00),
('SB', 'Pacific/Guadalcanal', 11.00, 11.00, 11.00),
('SC', 'Indian/Mahe', 4.00, 4.00, 4.00),
('SD', 'Africa/Khartoum', 3.00, 3.00, 3.00),
('SE', 'Europe/Stockholm', 1.00, 2.00, 1.00),
('SG', 'Asia/Singapore', 8.00, 8.00, 8.00),
('SH', 'Atlantic/St_Helena', 0.00, 0.00, 0.00),
('SI', 'Europe/Ljubljana', 1.00, 2.00, 1.00),
('SJ', 'Arctic/Longyearbyen', 1.00, 2.00, 1.00),
('SK', 'Europe/Bratislava', 1.00, 2.00, 1.00),
('SL', 'Africa/Freetown', 0.00, 0.00, 0.00),
('SM', 'Europe/San_Marino', 1.00, 2.00, 1.00),
('SN', 'Africa/Dakar', 0.00, 0.00, 0.00),
('SO', 'Africa/Mogadishu', 3.00, 3.00, 3.00),
('SR', 'America/Paramaribo', -3.00, -3.00, -3.00),
('SS', 'Africa/Juba', 3.00, 3.00, 3.00),
('ST', 'Africa/Sao_Tome', 0.00, 0.00, 0.00),
('SV', 'America/El_Salvador', -6.00, -6.00, -6.00),
('SX', 'America/Lower_Princes', -4.00, -4.00, -4.00),
('SY', 'Asia/Damascus', 2.00, 3.00, 2.00),
('SZ', 'Africa/Mbabane', 2.00, 2.00, 2.00),
('TC', 'America/Grand_Turk', -5.00, -4.00, -5.00),
('TD', 'Africa/Ndjamena', 1.00, 1.00, 1.00),
('TF', 'Indian/Kerguelen', 5.00, 5.00, 5.00),
('TG', 'Africa/Lome', 0.00, 0.00, 0.00),
('TH', 'Asia/Bangkok', 7.00, 7.00, 7.00),
('TJ', 'Asia/Dushanbe', 5.00, 5.00, 5.00),
('TK', 'Pacific/Fakaofo', 13.00, 13.00, 13.00),
('TL', 'Asia/Dili', 9.00, 9.00, 9.00),
('TM', 'Asia/Ashgabat', 5.00, 5.00, 5.00),
('TN', 'Africa/Tunis', 1.00, 1.00, 1.00),
('TO', 'Pacific/Tongatapu', 13.00, 13.00, 13.00),
('TR', 'Europe/Istanbul', 2.00, 3.00, 2.00),
('TT', 'America/Port_of_Spain', -4.00, -4.00, -4.00),
('TV', 'Pacific/Funafuti', 12.00, 12.00, 12.00),
('TW', 'Asia/Taipei', 8.00, 8.00, 8.00),
('TZ', 'Africa/Dar_es_Salaam', 3.00, 3.00, 3.00),
('UA', 'Europe/Kiev', 2.00, 3.00, 2.00),
('UA', 'Europe/Simferopol', 2.00, 4.00, 4.00),
('UA', 'Europe/Uzhgorod', 2.00, 3.00, 2.00),
('UA', 'Europe/Zaporozhye', 2.00, 3.00, 2.00),
('UG', 'Africa/Kampala', 3.00, 3.00, 3.00),
('UM', 'Pacific/Johnston', -10.00, -10.00, -10.00),
('UM', 'Pacific/Midway', -11.00, -11.00, -11.00),
('UM', 'Pacific/Wake', 12.00, 12.00, 12.00),
('US', 'America/Adak', -10.00, -9.00, -10.00),
('US', 'America/Anchorage', -9.00, -8.00, -9.00),
('US', 'America/Boise', -7.00, -6.00, -7.00),
('US', 'America/Chicago', -6.00, -5.00, -6.00),
('US', 'America/Denver', -7.00, -6.00, -7.00),
('US', 'America/Detroit', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Indianapolis', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Knox', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Marengo', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Petersburg', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Tell_City', -6.00, -5.00, -6.00),
('US', 'America/Indiana/Vevay', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Vincennes', -5.00, -4.00, -5.00),
('US', 'America/Indiana/Winamac', -5.00, -4.00, -5.00),
('US', 'America/Juneau', -9.00, -8.00, -9.00),
('US', 'America/Kentucky/Louisville', -5.00, -4.00, -5.00),
('US', 'America/Kentucky/Monticello', -5.00, -4.00, -5.00),
('US', 'America/Los_Angeles', -8.00, -7.00, -8.00),
('US', 'America/Menominee', -6.00, -5.00, -6.00),
('US', 'America/Metlakatla', -8.00, -8.00, -8.00),
('US', 'America/New_York', -5.00, -4.00, -5.00),
('US', 'America/Nome', -9.00, -8.00, -9.00),
('US', 'America/North_Dakota/Beulah', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/Center', -6.00, -5.00, -6.00),
('US', 'America/North_Dakota/New_Salem', -6.00, -5.00, -6.00),
('US', 'America/Phoenix', -7.00, -7.00, -7.00),
('US', 'America/Shiprock', -7.00, -6.00, -7.00),
('US', 'America/Sitka', -9.00, -8.00, -9.00),
('US', 'America/Yakutat', -9.00, -8.00, -9.00),
('US', 'Pacific/Honolulu', -10.00, -10.00, -10.00),
('UY', 'America/Montevideo', -2.00, -3.00, -3.00),
('UZ', 'Asia/Samarkand', 5.00, 5.00, 5.00),
('UZ', 'Asia/Tashkent', 5.00, 5.00, 5.00),
('VA', 'Europe/Vatican', 1.00, 2.00, 1.00),
('VC', 'America/St_Vincent', -4.00, -4.00, -4.00),
('VE', 'America/Caracas', -4.50, -4.50, -4.50),
('VG', 'America/Tortola', -4.00, -4.00, -4.00),
('VI', 'America/St_Thomas', -4.00, -4.00, -4.00),
('VN', 'Asia/Ho_Chi_Minh', 7.00, 7.00, 7.00),
('VU', 'Pacific/Efate', 11.00, 11.00, 11.00),
('WF', 'Pacific/Wallis', 12.00, 12.00, 12.00),
('WS', 'Pacific/Apia', 14.00, 13.00, 13.00),
('YE', 'Asia/Aden', 3.00, 3.00, 3.00),
('YT', 'Indian/Mayotte', 3.00, 3.00, 3.00),
('ZA', 'Africa/Johannesburg', 2.00, 2.00, 2.00),
('ZM', 'Africa/Lusaka', 2.00, 2.00, 2.00),
('ZW', 'Africa/Harare', 2.00, 2.00, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `time_frames`
--

CREATE TABLE `time_frames` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `day` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_orders` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `time_frames`
--

INSERT INTO `time_frames` (`id`, `user_id`, `day`, `start`, `end`, `max_orders`) VALUES
(2, 14, 'monday', '10:00', '00:00', 0),
(3, 14, 'tuesday', '08:30 AM', '11:30 PM', 10);

-- --------------------------------------------------------

--
-- Table structure for table `ulinks`
--

CREATE TABLE `ulinks` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ulinks`
--

INSERT INTO `ulinks` (`id`, `language_id`, `name`, `url`, `created_at`, `updated_at`) VALUES
(36, 176, 'Contact', 'https://codecanyon.megasoft.biz/superv/contact', NULL, NULL),
(37, 176, 'Blogs', 'https://codecanyon.megasoft.biz/superv/blogs', NULL, NULL),
(38, 176, 'Team', 'https://codecanyon.megasoft.biz/superv/team', NULL, NULL),
(39, 176, 'Gallery', 'https://codecanyon.megasoft.biz/superv/gallery', NULL, NULL),
(40, 177, 'link 1', 'https://megasoft.biz/alphasoft/', NULL, NULL),
(41, 177, 'link 2', 'https://megasoft.biz/alphasoft/', NULL, NULL),
(42, 177, 'Test', 'https://www.google.com/', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `featured` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `online_status` tinyint NOT NULL DEFAULT '1' COMMENT '1 = Active ,0 = offline',
  `verification_link` text,
  `email_verified` tinyint NOT NULL DEFAULT '0' COMMENT '1 - verified, 0 - not verified',
  `subdomain_status` tinyint NOT NULL DEFAULT '0' COMMENT '0 - pending, 1 - connected',
  `preview_template` tinyint NOT NULL DEFAULT '0',
  `template_img` varchar(100) DEFAULT NULL,
  `template_serial_number` int NOT NULL DEFAULT '0',
  `pwa` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pass_token` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `admin_id`, `first_name`, `last_name`, `image`, `username`, `email`, `password`, `phone`, `city`, `state`, `address`, `country`, `remember_token`, `featured`, `status`, `online_status`, `verification_link`, `email_verified`, `subdomain_status`, `preview_template`, `template_img`, `template_serial_number`, `pwa`, `created_at`, `updated_at`, `pass_token`) VALUES
(7, NULL, NULL, NULL, NULL, NULL, 'hossain', 'immobile@gmail.com', '$2y$10$aflqSI6.BZ4aOsM68UMSYuGwzqmi3qIagSndqMwEDZ05pPwuseUhm', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 0, 0, NULL, 0, NULL, '2023-09-10 02:40:30', '2023-09-10 02:40:30', NULL),
(9, 2, 7, 'Luis', 'Romero', 'e4626eaf9c08715873c20d12c00d0b01a4be084d.jpeg', 'tester', 'renter@gmail.com', '$2y$10$qzOCwzfMx3dWWXty5zOd8uG.RhMz3ndK6kS9NqOSfrbvRxLIKex4a', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 0, 0, 0, NULL, 0, NULL, '2023-09-10 03:25:45', '2023-09-10 03:25:45', NULL),
(13, NULL, NULL, NULL, NULL, NULL, 'tom', 'tom@gmail.com', '$2y$10$YsnsRHeCy.eYFpXQ3ijojuJnPi9aGyxZd/g7Cmym1ezGMQDFU0xY6', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 0, 0, NULL, 0, NULL, '2023-09-10 11:53:03', '2023-09-10 11:53:03', NULL),
(14, NULL, NULL, 'Samiul Alim', 'Pratik', NULL, 'genius', 'geniustest11@gmail.com1', '$2y$10$yWT510ntvrm2w66i.//qaOEmeolPFAHPNFOoe8z46LE4pGVZmUPPa', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 1, 0, NULL, 0, '{\"short_name\":\"Eorder\",\"name\":\"Eorder\",\"background_color\":\"#1640D3\",\"theme_color\":\"#43D37A\",\"start_url\":\"\",\"display\":\"standalone\",\"icons\":[{\"src\":\"4213721fa532601b77d42867f356319e3935975d.png\",\"type\":\"image\\/png\",\"sizes\":\"128X128\"},{\"src\":\"2566c1f31eff1b65c5ef3b2c5b24691b94801b57.png\",\"type\":\"image\\/png\",\"sizes\":\"256X256\"},{\"src\":\"a75bc1b38479596c2aa5bea37e89e94ed94d476f.png\",\"type\":\"image\\/png\",\"sizes\":\"512X512\"}]}', '2023-09-10 15:39:02', '2024-01-03 16:29:26', NULL),
(26, 4, 14, 'saif', 'islam', '02461a0a38ece1a019ad9ba0d48795afc5d31a19.png', 'saif', 'geniustest11@gmail.com', '$2y$10$/fnmnU8fCjxBGnAzG5E5puQU1847OzEgIukStnB1kN3nXgKBCIDT6', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 0, 0, 0, NULL, 0, NULL, '2023-11-25 14:32:01', '2023-12-25 03:09:33', NULL),
(28, NULL, NULL, 'C4AcHWIAL1', 'OVknj6RIsC', NULL, 'pratik', 'pratik.anwar@gmail.com', '$2y$10$TjdI9A.4XseCGGYUE16UauKjFAO4J59oQQPps11.0SOq1Vk.ZZmX.', '9961532743', 'Kd6iQazfhu', 'hb2xzVev62', 'QcPa80HWrQ', 'JaVz0JSVBg', NULL, 0, 1, 1, '65557f45400a2e7c5afc93284ec3c388', 1, 0, 0, NULL, 0, NULL, '2023-11-29 09:06:57', '2023-11-29 09:07:55', NULL),
(40, NULL, NULL, NULL, NULL, NULL, 'imran', 'imranyeasin75@gmail.com', '$2y$10$ungMVXmRX.3O4wwRra2AO.Tgp14PBGq/LepYyySnFQYD0.z/8wQDy', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 0, 0, NULL, 0, NULL, '2023-12-16 20:35:54', '2023-12-18 14:42:04', 'VvdM6X0bxXvBKAGua7sRcWyoaU1fEN'),
(41, 4, 14, 'Yeasin', 'Hossain', '2ca004e80898acd5eb69dfe5c35107e793b09cf1.jpg', 'imran', 'imranyeasin75@gmail.com', '$2y$10$fZG3prdb0tXIepEGblc4veIez3L.vbi84y.qCjIjl8D2eMbEWy78C', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 0, 0, 0, NULL, 0, NULL, '2023-12-18 14:34:01', '2023-12-18 15:36:25', 's7ysWsenzTQrPY1wenBC1MiefVLO9q'),
(42, NULL, NULL, NULL, NULL, NULL, 'werwer', 'customer@gmail.com', '$2y$10$l4VTZ3eVAEk7DAwww3glhuNYTSUfX2tCIxz0GJyLxCfYqx39YBhv6', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 0, 0, NULL, 0, NULL, '2023-12-18 17:22:26', '2023-12-18 17:22:26', NULL),
(43, NULL, NULL, 'Grace', 'Kidd', NULL, 'cesozipel', 'seqilezef@mailinator.com', '$2y$10$6wGzdAFkSjAvz84NoiRvKO/rcBQVrRraVYEvoDhFsP7WNWcklCZeW', '+1 (243) 298-8098', 'Natus itaque sit as', 'Sequi velit anim ma', 'Ad nostrum dignissim', 'Id ea consequatur f', NULL, 0, 1, 1, '71986f78e0b90f4d6da31200687475b5', 1, 0, 0, NULL, 0, NULL, '2023-12-18 17:29:46', '2023-12-18 17:30:12', NULL),
(44, NULL, NULL, NULL, NULL, NULL, 'genius11', 'geniustest1111@gmail.com', '$2y$10$rQpvemh6f58pk3jh2NwvdekvgbG0SyUDNHRP9fXjcmg3cok.ZLc4K', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 1, 0, 0, NULL, 0, NULL, '2023-12-23 01:47:23', '2023-12-23 01:47:23', NULL),
(46, 4, 14, 'Samiul Alim', 'Pratik', '1193e8cc509a19a64074bb6f7d05a3c58248920b.png', 'genius11', 'geniustest111@gmail.com', '$2y$10$42cdcMcqvNNeVXxYSRNOYOpM1/e/vGAhgNIWMBBhz3OkUTPJhfllu', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 0, 0, 0, NULL, 0, NULL, '2023-12-24 21:47:54', '2023-12-29 20:24:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_basic_extendeds`
--

CREATE TABLE `user_basic_extendeds` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `cookie_alert_status` tinyint NOT NULL DEFAULT '1',
  `cookie_alert_text` blob,
  `cookie_alert_button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_language_direction` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ltr' COMMENT 'ltr / rtl',
  `blogs_meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `blogs_meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_facebook_pixel` tinyint NOT NULL DEFAULT '0',
  `facebook_pixel_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `theme_version` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default_service_category',
  `from_mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_smtp` tinyint NOT NULL DEFAULT '0',
  `smtp_host` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_port` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `encryption` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smtp_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_shape_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slider_bottom_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_bottom_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_section_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial_bg_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_section_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_section_subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_section_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_currency_symbol` blob,
  `base_currency_symbol_position` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `base_currency_text` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USD',
  `base_currency_text_position` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'right',
  `base_currency_rate` decimal(8,2) NOT NULL DEFAULT '1.00',
  `hero_bg` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_bold_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_bold_text_font_size` int NOT NULL DEFAULT '60',
  `hero_section_bold_text_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `hero_section_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_text_font_size` int NOT NULL DEFAULT '18',
  `hero_section_text_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `hero_section_button_text` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_button_text_font_size` int NOT NULL DEFAULT '14',
  `hero_section_button_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FFFFFF',
  `hero_section_button_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hero_section_button2_text` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_button2_text_font_size` int NOT NULL DEFAULT '14',
  `hero_section_button2_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hero_shape_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_bottom_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_section_video_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hero_side_img` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faq_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career_details_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_section_bg` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_version` tinyint NOT NULL DEFAULT '1' COMMENT '1 - menu with col-6, 2 - menu with col-12',
  `qrcode_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `qrcode_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pusher_app_id` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pusher_app_key` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pusher_app_secret` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pusher_app_cluster` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_facebook_login` tinyint NOT NULL DEFAULT '1' COMMENT '1 - Active, 0 - Deactive',
  `facebook_app_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_app_secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_google_login` tinyint NOT NULL DEFAULT '1' COMMENT '1 - Active, 0 - Deactive',
  `google_client_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_client_secret` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'UTC',
  `delivery_date_time_status` tinyint NOT NULL DEFAULT '0',
  `delivery_date_time_required` tinyint NOT NULL DEFAULT '0',
  `qr_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `qr_size` int NOT NULL DEFAULT '250',
  `qr_style` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'square',
  `qr_eye_style` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'square',
  `qr_margin` int NOT NULL DEFAULT '0',
  `qr_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_text_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '000000',
  `qr_text_size` int NOT NULL DEFAULT '15',
  `qr_text_x` int NOT NULL DEFAULT '50',
  `qr_text_y` int NOT NULL DEFAULT '50',
  `qr_inserted_image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_inserted_image_size` int NOT NULL DEFAULT '20',
  `qr_inserted_image_x` int NOT NULL DEFAULT '50',
  `qr_inserted_image_y` int NOT NULL DEFAULT '50',
  `qr_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' COMMENT 'default, image, text',
  `order_close` tinyint NOT NULL DEFAULT '0' COMMENT '1 - order closed, 0 - order open',
  `order_close_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Order is closed now!'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_basic_extendeds`
--

INSERT INTO `user_basic_extendeds` (`id`, `language_id`, `user_id`, `cookie_alert_status`, `cookie_alert_text`, `cookie_alert_button_text`, `to_mail`, `default_language_direction`, `blogs_meta_keywords`, `blogs_meta_description`, `is_facebook_pixel`, `facebook_pixel_script`, `theme_version`, `from_mail`, `from_name`, `is_smtp`, `smtp_host`, `smtp_port`, `encryption`, `smtp_username`, `smtp_password`, `slider_shape_img`, `slider_bottom_img`, `footer_bottom_img`, `menu_section_title`, `menu_section_subtitle`, `menu_section_img`, `special_section_title`, `special_section_subtitle`, `testimonial_bg_img`, `table_section_title`, `table_section_subtitle`, `table_section_img`, `base_currency_symbol`, `base_currency_symbol_position`, `base_currency_text`, `base_currency_text_position`, `base_currency_rate`, `hero_bg`, `hero_section_bold_text`, `hero_section_bold_text_font_size`, `hero_section_bold_text_color`, `hero_section_text`, `hero_section_text_font_size`, `hero_section_text_color`, `hero_section_button_text`, `hero_section_button_text_font_size`, `hero_section_button_color`, `hero_section_button_url`, `hero_section_button2_text`, `hero_section_button2_text_font_size`, `hero_section_button2_url`, `hero_shape_img`, `hero_bottom_img`, `hero_section_video_link`, `hero_side_img`, `faq_title`, `career_title`, `career_details_title`, `special_section_bg`, `menu_version`, `qrcode_url`, `qrcode_color`, `pusher_app_id`, `pusher_app_key`, `pusher_app_secret`, `pusher_app_cluster`, `is_facebook_login`, `facebook_app_id`, `facebook_app_secret`, `is_google_login`, `google_client_id`, `google_client_secret`, `timezone`, `delivery_date_time_status`, `delivery_date_time_required`, `qr_image`, `qr_color`, `qr_size`, `qr_style`, `qr_eye_style`, `qr_margin`, `qr_text`, `qr_text_color`, `qr_text_size`, `qr_text_x`, `qr_text_y`, `qr_inserted_image`, `qr_inserted_image_size`, `qr_inserted_image_x`, `qr_inserted_image_y`, `qr_type`, `order_close`, `order_close_message`) VALUES
(9, 10, 7, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'immobile@gmail.com', 'hossain', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(17, 18, 13, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'tom@gmail.com', 'tom', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(18, 19, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, '312692ed4dc6b0874129962a5e29bc1db3d7d339.png', '01d11a29096da5ca8dae51faf5030481aa5734ec.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, 'FAQ  Page', 'Career Page', 'Career  Details', NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(20, 21, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'geniustest11@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(23, 24, 28, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'pratik.anwar@gmail.com', 'pratik', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(35, 36, 40, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'imran', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(36, 37, 42, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'customer@gmail.com', 'werwer', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(37, 38, 43, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'seqilezef@mailinator.com', 'cesozipel', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!'),
(38, 39, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(39, 40, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(40, 41, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(43, 44, 14, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'imranyeasin75@gmail.com', 'genius', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '1691972', '4306f613fcf402518c80', 'f2c2d5ac0e343b4cae02', 'ap2', 1, NULL, NULL, 1, NULL, NULL, 'Asia/Dhaka', 1, 0, '65895494d9fb9.png', 'FFFFFF', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'image', 0, 'Order is closed now!'),
(50, 51, 44, 1, NULL, NULL, NULL, 'ltr', NULL, NULL, 0, NULL, 'default_service_category', 'geniustest1111@gmail.com', 'genius11', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0x24, 'left', 'USD', 'right', 1.00, NULL, NULL, 60, 'FFFFFF', NULL, 18, 'FFFFFF', NULL, 14, 'FFFFFF', NULL, NULL, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 1, NULL, NULL, 'UTC', 0, 0, NULL, '0', 250, 'square', 'square', 0, NULL, '000000', 15, 50, 50, NULL, 20, 50, 50, 'default', 0, 'Order is closed now!');

-- --------------------------------------------------------

--
-- Table structure for table `user_basic_extras`
--

CREATE TABLE `user_basic_extras` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `whatsapp_order_status_notification` tinyint NOT NULL DEFAULT '0' COMMENT '0 - disable, 1 - enable',
  `whatsapp_home_delivery` tinyint NOT NULL DEFAULT '0' COMMENT '1 - enabled, 0 - disabled',
  `whatsapp_pickup` tinyint NOT NULL DEFAULT '0' COMMENT '1 - enabled, 0 - disabled',
  `whatsapp_on_table` tinyint NOT NULL DEFAULT '0' COMMENT '1 - enabled, 0 - disabled',
  `twilio_sid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twilio_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twilio_phone_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VAPID_PUBLIC_KEY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `VAPID_PRIVATE_KEY` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_notification_icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_basic_extras`
--

INSERT INTO `user_basic_extras` (`id`, `user_id`, `whatsapp_order_status_notification`, `whatsapp_home_delivery`, `whatsapp_pickup`, `whatsapp_on_table`, `twilio_sid`, `twilio_token`, `twilio_phone_number`, `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY`, `push_notification_icon`) VALUES
(6, 7, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 13, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 14, 1, 0, 1, 0, 'AC87db7baafc84b106f2d59eee812b8f7e', '278775c1412d7a19c9c336fc0e635785', '+14155238886', 'BCNNGyioDmDJJHgn_PGbAol8dtRP3jYqQ6cQC5k_Soy8rXZ8n3MuHj3Na8EOFPucr9khzC2wNTUnlhVtrQzz0T8', 'eWyy3PNOecdEAmXzTjRgfGwaN1S1w4AqCOvnC9zkGOQ', '22beecca90a26873fece6ebf6e022c67c41d0b2d.png'),
(15, 28, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 40, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 42, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 43, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 44, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_basic_settings`
--

CREATE TABLE `user_basic_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `favicon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage_usage` float DEFAULT '0',
  `aws_status` tinyint DEFAULT NULL,
  `preloader_status` tinyint DEFAULT '0' COMMENT '0 - deactive, 1 - active',
  `preloader` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'D3A971',
  `secondary_base_color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `support_phone` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumb` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_logo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newsletter_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright_text` blob,
  `intro_section_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `intro_contact_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_contact_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_video_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_signature` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_video_link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `intro_main_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_form_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_mails` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_zoom` int NOT NULL DEFAULT '10',
  `contact_info_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tawk_to_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `google_analytics_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_recaptcha` tinyint NOT NULL DEFAULT '0',
  `google_recaptcha_site_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_recaptcha_secret_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_tawkto` tinyint NOT NULL DEFAULT '1',
  `is_disqus` tinyint NOT NULL DEFAULT '1',
  `disqus_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_analytics` tinyint NOT NULL DEFAULT '1',
  `maintenance_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance_mode` tinyint NOT NULL DEFAULT '0' COMMENT '1 - active, 0 - deactive',
  `maintenance_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ips` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `home_version` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feature_section` tinyint NOT NULL DEFAULT '1',
  `intro_section` tinyint NOT NULL DEFAULT '1',
  `testimonial_section` tinyint NOT NULL DEFAULT '1',
  `team_section` tinyint NOT NULL DEFAULT '1',
  `news_section` tinyint NOT NULL DEFAULT '1',
  `menu_section` int NOT NULL DEFAULT '1',
  `special_section` int NOT NULL DEFAULT '1',
  `instagram_section` int NOT NULL DEFAULT '1',
  `table_section` int NOT NULL DEFAULT '1',
  `top_footer_section` tinyint NOT NULL DEFAULT '1',
  `copyright_section` tinyint NOT NULL DEFAULT '1',
  `is_quote` tinyint NOT NULL DEFAULT '1',
  `office_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_appzi` tinyint NOT NULL DEFAULT '0',
  `appzi_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_addthis` tinyint NOT NULL DEFAULT '0',
  `addthis_script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `token_no_start` int NOT NULL DEFAULT '1',
  `token_no` int NOT NULL DEFAULT '0',
  `postal_code` tinyint NOT NULL DEFAULT '1' COMMENT '1 - enabled, 0 - disabled',
  `qr_call_waiter` tinyint NOT NULL DEFAULT '1',
  `website_call_waiter` tinyint NOT NULL DEFAULT '1',
  `is_whatsapp` tinyint NOT NULL DEFAULT '1' COMMENT '1 - enable, 0 - disable',
  `whatsapp_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp_header_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chat with us on WhatsApp!',
  `whatsapp_popup_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `whatsapp_popup` tinyint NOT NULL DEFAULT '1' COMMENT '1 - enable, 0 - disable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_basic_settings`
--

INSERT INTO `user_basic_settings` (`id`, `language_id`, `user_id`, `favicon`, `logo`, `email`, `from_name`, `storage_usage`, `aws_status`, `preloader_status`, `preloader`, `website_title`, `base_color`, `secondary_base_color`, `support_email`, `support_phone`, `breadcrumb`, `footer_logo`, `footer_text`, `newsletter_text`, `copyright_text`, `intro_section_title`, `intro_title`, `intro_text`, `intro_contact_text`, `intro_contact_number`, `intro_video_image`, `intro_signature`, `intro_video_link`, `intro_main_image`, `contact_form_title`, `contact_address`, `contact_number`, `contact_mails`, `contact_text`, `latitude`, `longitude`, `map_zoom`, `contact_info_title`, `tawk_to_script`, `google_analytics_script`, `is_recaptcha`, `google_recaptcha_site_key`, `google_recaptcha_secret_key`, `is_tawkto`, `is_disqus`, `disqus_script`, `is_analytics`, `maintenance_img`, `maintenance_mode`, `maintenance_text`, `ips`, `home_version`, `feature_section`, `intro_section`, `testimonial_section`, `team_section`, `news_section`, `menu_section`, `special_section`, `instagram_section`, `table_section`, `top_footer_section`, `copyright_section`, `is_quote`, `office_time`, `is_appzi`, `appzi_script`, `is_addthis`, `addthis_script`, `token_no_start`, `token_no`, `postal_code`, `qr_call_waiter`, `website_call_waiter`, `is_whatsapp`, `whatsapp_number`, `whatsapp_header_title`, `whatsapp_popup_message`, `whatsapp_popup`) VALUES
(9, 10, 7, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'hossain', 'D3A971', NULL, 'immobile@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(17, 18, 13, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'tom', 'D3A971', NULL, 'tom@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(18, 19, 14, '2f5266205c4cc8d02ebcc82f485174035b63cf68.jpeg', '5bca4b0c713d85b900ee4152c3ca0d10bdd3e79a.png', 'geniustest11@gmail.com', 'genius', 7.71, NULL, 0, 'b17f3c20058a85101dab6572ca10013dfbdc01b7.gif', 'genius', 'D3A971', NULL, 'geniustest11@gmail.com', NULL, 'a03d7e750b82a16fb3891a054b67a65f25cbcf47.jpg', NULL, 'Get latest updates first eorder', NULL, 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920456f726465722e3c2f703e, NULL, 'Why You Choose Our Templateu', 'Why You Choose Our Templateu Why You Choose Our Templateu', NULL, NULL, NULL, NULL, NULL, '63bd60a1deb68ab39a96c4ab6177597546ba6d3a.png', 'Contact Form Title', 'Uttara Dhaka 1230', '3243263413', 'pratik.anwar@gmail.com', 'Contact form info text', '34.05224', '12400', 1, 'Lorem Ipsum mat', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '9 AM - 5PM', 0, NULL, 0, NULL, 1, 38, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(20, 21, 14, NULL, NULL, NULL, NULL, 7.71, NULL, 0, NULL, NULL, 'D3A971', NULL, 'geniustest11@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 3, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(23, 24, 28, NULL, NULL, NULL, NULL, 1, NULL, 0, NULL, 'pratik', 'D3A971', NULL, 'pratik.anwar@gmail.com', '9961532743', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(35, 36, 40, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'imran', 'D3A971', NULL, 'imranyeasin75@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(36, 37, 42, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'werwer', 'D3A971', NULL, 'customer@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(37, 38, 43, NULL, NULL, NULL, NULL, 2.15, NULL, 0, NULL, 'cesozipel', 'D3A971', NULL, 'seqilezef@mailinator.com', '+1 (243) 298-8098', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(38, 39, 14, NULL, NULL, 'geniustest11@gmail.com', 'genius', 7.71, NULL, 0, NULL, NULL, 'D3A971', NULL, 'geniustest11@gmail.com', NULL, NULL, NULL, 'Get latest updates first eorder', NULL, 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920456f726465722e3c2f703e, NULL, 'Why You Choose Our Templateu', 'Why You Choose Our Templateu Why You Choose Our Templateu', NULL, NULL, NULL, NULL, NULL, NULL, 'Contact Form Title', 'Uttara Dhaka 1230', '01919921118', 'imranyeasin75@gmail.com', 'Contact form info text', '34.05224', '12400', 1, 'Lorem Ipsum mat', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '9 AM - 5PM', 0, NULL, 0, NULL, 1, 33, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(39, 40, 14, NULL, NULL, 'geniustest11@gmail.com', 'genius', 7.71, NULL, 0, NULL, NULL, 'D3A971', NULL, 'geniustest11@gmail.com', NULL, NULL, NULL, 'Get latest updates first eorder', NULL, 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920456f726465722e3c2f703e, NULL, 'Why You Choose Our Templateu', 'Why You Choose Our Templateu Why You Choose Our Templateu', NULL, NULL, NULL, NULL, NULL, NULL, 'Contact Form Title', 'Uttara Dhaka 1230', '01919921118', 'imranyeasin75@gmail.com', 'Contact form info text', '34.05224', '12400', 1, 'Lorem Ipsum mat', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '9 AM - 5PM', 0, NULL, 0, NULL, 1, 33, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(40, 41, 14, NULL, NULL, 'geniustest11@gmail.com', 'genius', 7.71, NULL, 0, NULL, NULL, 'D3A971', NULL, 'geniustest11@gmail.com', NULL, NULL, NULL, 'Get latest updates first eorder', NULL, 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920456f726465722e3c2f703e, NULL, 'Why You Choose Our Templateu', 'Why You Choose Our Templateu Why You Choose Our Templateu', NULL, NULL, NULL, NULL, NULL, NULL, 'Contact Form Title', 'Uttara Dhaka 1230', '01919921118', 'imranyeasin75@gmail.com', 'Contact form info text', '34.05224', '12400', 1, 'Lorem Ipsum mat', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '9 AM - 5PM', 0, NULL, 0, NULL, 1, 33, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(43, 44, 14, NULL, NULL, 'geniustest11@gmail.com', 'genius', 7.71, NULL, 0, NULL, NULL, 'D3A971', NULL, 'geniustest11@gmail.com', NULL, NULL, NULL, 'Get latest updates first eorder', NULL, 0x3c703e436f7079726967687420c2a920323032332e20416c6c2072696768747320726573657276656420627920456f726465722e3c2f703e, NULL, 'Why You Choose Our Templateu', 'Why You Choose Our Templateu Why You Choose Our Templateu', NULL, NULL, NULL, NULL, NULL, NULL, 'Contact Form Title', 'Uttara Dhaka 1230', '01919921118', 'imranyeasin75@gmail.com', 'Contact form info text', '34.05224', '12400', 1, 'Lorem Ipsum mat', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '9 AM - 5PM', 0, NULL, 0, NULL, 1, 33, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1),
(50, 51, 44, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'genius11', 'D3A971', NULL, 'geniustest1111@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 1, NULL, 0, NULL, NULL, 'slider', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, NULL, 0, NULL, 0, NULL, 1, 0, 1, 1, 1, 1, NULL, 'Chat with us on WhatsApp!', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_blogs`
--

CREATE TABLE `user_blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `serial_number` mediumint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_blogs`
--

INSERT INTO `user_blogs` (`id`, `user_id`, `image`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 14, 'c939f424df3ce7f57fd58af40f77236a66f7d7d8.jpg', 1, '2023-09-10 17:40:07', '2023-12-12 15:29:08'),
(3, 14, '1e8954d9bea60fad887fc52e7d3f02814515037b.jpg', 2, '2023-12-12 15:27:38', '2023-12-12 15:27:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_blog_categories`
--

CREATE TABLE `user_blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `serial_number` mediumint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_blog_categories`
--

INSERT INTO `user_blog_categories` (`id`, `language_id`, `user_id`, `name`, `slug`, `status`, `serial_number`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 'cat en 1', 'cat-en-1', 1, 1, '2023-09-10 17:39:45', '2023-12-04 06:14:39'),
(2, 21, 14, 'عندما قامت', 'عندما-قامت', 1, 1, '2023-09-28 12:09:51', '2023-09-28 12:09:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_blog_informations`
--

CREATE TABLE `user_blog_informations` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `blog_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` blob NOT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_blog_informations`
--

INSERT INTO `user_blog_informations` (`id`, `language_id`, `user_id`, `blog_category_id`, `blog_id`, `title`, `slug`, `author`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 1, 1, 'able English. Many desktop publish', 'able-English.-Many-desktop-publish', 'Lorris', 0x3c703e49742069732061206c6f6e672065737461626c6973686564206661637420746861742061207265616465722077696c6c206265206469737472616374656420627920746865207265616461626c6520636f6e74656e74206f6620612070616765207768656e206c6f6f6b696e6720617420697473206c61796f75742e2054686520706f696e74206f66207573696e67204c6f72656d20497073756d2069732074686174206974206861732061206d6f72652d6f722d6c657373206e6f726d616c20646973747269627574696f6e206f66206c6574746572732c206173206f70706f73656420746f207573696e672027436f6e74656e7420686572652c20636f6e74656e742068657265272c206d616b696e67206974206c6f6f6b206c696b65207265616461626c6520456e676c6973682e204d616e79206465736b746f70207075626c697368696e67207061636b6167657320616e6420776562207061676520656469746f7273206e6f7720757365204c6f72656d20497073756d2061732074686569722064656661756c74206d6f64656c20746578742c20616e6420612073656172636820666f7220276c6f72656d20697073756d272077696c6c20756e636f766572206d616e7920776562207369746573207374696c6c20696e20746865697220696e66616e63792e20566172696f75732076657273696f6e7320686176652065766f6c766564206f766572207468652079656172732c20736f6d6574696d6573206279206163636964656e742c20736f6d6574696d6573206f6e20707572706f73652028696e6a65637465642068756d6f757220616e6420746865206c696b65292e3c2f703e, NULL, NULL, '2023-09-10 17:40:07', '2023-09-10 17:40:07'),
(4, 19, 14, 1, 3, 'Cricket ,Asia Cup start 30 auguast and world cup will be later lorem impsum mate', 'Cricket-,Asia-Cup-start-30-auguast-and-world-cup-will-be-later-lorem-impsum-mate', 'Imran', 0x3c703e437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d61746520437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d61746520437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d6174653c2f703e, NULL, NULL, '2023-12-12 15:27:39', '2023-12-12 15:27:39'),
(5, 21, 14, 2, 3, 'Cricket ,Asia Cup start 30 auguast and world cup will be later lorem impsum mate', 'Cricket-,Asia-Cup-start-30-auguast-and-world-cup-will-be-later-lorem-impsum-mate', 'Imran', 0x3c703e437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d61746520437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d61746520437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d6174653c2f703e, NULL, NULL, '2023-12-12 15:27:39', '2023-12-12 15:27:39'),
(6, 21, 14, 2, 1, 'About Electricity of Bangladesh', 'About-Electricity-of-Bangladesh', 'عمران', 0x3c703e437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d617465437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d617465437269636b6574202c4173696120437570207374617274203330206175677561737420616e6420776f726c64206375702077696c6c206265206c61746572206c6f72656d20696d7073756d206d6174653c2f703e, NULL, NULL, '2023-12-12 15:29:08', '2023-12-12 15:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'percentage, fixed',
  `value` decimal(11,2) DEFAULT NULL,
  `start_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `minimum_spend` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_coupons`
--

INSERT INTO `user_coupons` (`id`, `user_id`, `name`, `code`, `type`, `value`, `start_date`, `end_date`, `minimum_spend`, `created_at`, `updated_at`) VALUES
(8, 14, 'bijoy16', 'bijoy16', 'percentage', 16.00, '12/01/2023', '01/31/2024', NULL, '2023-12-23 02:06:42', '2023-12-23 02:06:42'),
(9, 14, 'genius test', 'tr', 'percentage', 46.00, '12/08/2023', '12/30/2023', 33.00, '2023-12-23 02:08:18', '2023-12-23 02:08:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_custom_domains`
--

CREATE TABLE `user_custom_domains` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `requested_domain` varchar(255) DEFAULT NULL,
  `current_domain` varchar(255) DEFAULT NULL,
  `status` tinyint NOT NULL COMMENT '0 - Pending, 1 - Connected, 2 - Rejected, 3 - Removed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_custom_domains`
--

INSERT INTO `user_custom_domains` (`id`, `user_id`, `requested_domain`, `current_domain`, `status`, `created_at`, `updated_at`) VALUES
(2, 14, 'genius.test', '0', 1, '2023-09-11 15:13:32', '2023-09-11 15:13:53'),
(5, 14, 'imranhossain.xyz', 'genius.test', 3, '2023-12-04 07:04:52', '2023-12-04 07:05:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_faqs`
--

CREATE TABLE `user_faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `serial_number` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_faqs`
--

INSERT INTO `user_faqs` (`id`, `language_id`, `user_id`, `question`, `answer`, `serial_number`) VALUES
(1, 21, 14, 'عشر عندما قامت مطبعة م', 'لوريم إيبسوم(Lorem Ipsum) هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار للنص الشكلي منذ القرن الخامس عشر عندما قامت مطبعة مجهولة برص مجموعة من الأحرف بشكل عشوائي أخذتها من نص، لتكوّن كتيّب بمثابة دليل أو مرجع شكلي لهذه الأحرف. خمسة قرون من الزمن لم تقضي على هذا النص، بل انه حتى صار مستخدماً وبشكله الأصلي في الطباعة والتنضيد الإلكتروني. انتشر بشكل كبير في ستينيّات هذا القرن مع إصدار رقائق \"ليتراسيت\" (Letraset) البلاستيكية تحوي مقاطع من هذا النص، وعاد لينتشر مرة أخرى مؤخراَ مع ظهور برامج النشر الإلكتروني مثل \"ألدوس بايج مايكر\" (Aldus PageMaker) والتي حوت أيضاً على نسخ من نص لوريم إيبسوم.', 1),
(2, 19, 14, 'Question', 'xzvvvvvvvvvvvvvvv', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_features`
--

CREATE TABLE `user_features` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_languages`
--

CREATE TABLE `user_languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_default` tinyint NOT NULL DEFAULT '0',
  `rtl` tinyint NOT NULL COMMENT '0 - LTR, 1- RTL',
  `keywords` longtext,
  `user_id` int DEFAULT NULL,
  `datepicker_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_languages`
--

INSERT INTO `user_languages` (`id`, `name`, `code`, `is_default`, `rtl`, `keywords`, `user_id`, `datepicker_name`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 0, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\",\"Page Not Found\":\"Page Not Found\", \"January\": \"January\",   \"February\": \"February\",   \"March\": \"March\",   \"April\": \"April\",   \"May\": \"May\",   \"June\": \"June\",   \"July\": \"July\",   \"August\": \"August\",   \"September\": \"September\",   \"October\": \"October\",   \"November\": \"November\",   \"December\": \"December\",\"Monday\": \"Mo\",   \"Tuesday\": \"Tu\",   \"Wednesday\": \"We\",   \"Thursday\": \"Th\",   \"Friday\": \"Fr\",   \"Saturday\": \"Sa\",   \"Sunday\": \"Su\",\"Showing\":\"Showing\",\"to\":\"to\",\"of\":\"of\",\"entries\":\"entries\",\"Show\":\"Show\"}', NULL, '', NULL, NULL),
(10, 'English', 'en', 1, 0, '{ \"Home\": \"Home\", \"Menu\": \"Menu\", \"Items\": \"Items\", \"Team\": \"Team\", \"Teams\": \"Teams\", \"Contact\": \"Contact\", \"Gallery\": \"Gallery\", \"Team Members\": \"Team Members\", \"Cart\": \"Cart\", \"Reservation\": \"Reservation\", \"Blog\": \"Blog\", \"Add Cart\": \"Add Cart\", \"Opening Time\": \"Opening Time\", \"Buy Now\": \"Buy Now\", \"Discover Food Menu\": \"Discover Food Menu\", \"View All Items\": \"View All Items\", \"Our\": \"Our\", \"Special\": \"Special\", \"Good\": \"Good\", \"Food\": \"Food\", \"Price\": \"Price\", \"View All Menu List\": \"View All Menu List\", \"Product Not Found\": \"Product Not Found\", \"Stars\": \"Stars\", \"Read More\": \"Read More\", \"Book A Table\": \"Book A Table\", \"Full Name\": \"Full Name\", \"Phone\": \"Phone\", \"Date\": \"Date\", \"Time\": \"Time\", \"Person\": \"Person\", \"Book Table\": \"Book Table\", \"Our Blog\": \"Our Blog\", \"No Blogs\": \"No Blogs\", \"Share\": \"Share\", \"All Categories\": \"All Categories\", \"Contact Us\": \"Contact Us\", \"Your Name\": \"Your Name\", \"Email Address\": \"Email Address\", \"Subject\": \"Subject\", \"Write a message\": \"Write a message\", \"Submit Now\": \"Submit Now\", \"Career\": \"Career\", \"Job Details\": \"Job Details\", \"Our Gallery\": \"Our Gallery\", \"FAQ\": \"FAQ\", \"Photos Action\": \"Photos Action\", \"Our Awesome Gallery\": \"Our Awesome Gallery\", \"Exparts Our Team\": \"Exparts Our Team\", \"Your Cart\": \"Your Cart\", \"Total\": \"Total\", \"Products\": \"Products\", \"Product\": \"Product\", \"Product Title\": \"Product Title\", \"Variations\": \"Variations\", \"Variation\": \"Variation\", \"Add On\'s\": \"Add On\'s\", \"Ordered Products\": \"Ordered Products\", \"Select Variation\": \"Select Variation\", \"Select Add On\'s\": \"Select Add On\'s\", \"Optional\": \"Optional\", \"Add to Cart\": \"Add to Cart\", \"Quantity\": \"Quantity\", \"Availability\": \"Availability\", \"Item(s)\": \"Item(s)\", \"Remove\": \"Remove\", \"Avilable Now\": \"Avilable Now\", \"Out Of Stock\": \"Out Of Stock\", \"Cart is empty!\": \"Cart is empty!\", \"Checkout\": \"Checkout\", \"Update Cart\": \"Update Cart\", \"Country\": \"Country\", \"First Name\": \"First Name\", \"Last Name\": \"Last Name\", \"Address\": \"Address\", \"Town \\/ City\": \"Town \\/ City\", \"Contact Email\": \"Contact Email\", \"Shipping Methods\": \"Shipping Methods\", \"Method\": \"Method\", \"Cost\": \"Cost\", \"Free Shipping\": \"Free Shipping\", \"10 to 15 days\": \"10 to 15 days\", \"Order Summary\": \"Order Summary\", \"Cart is empty\": \"Cart is empty\", \"Cart Totals\": \"Cart Totals\", \"Cart Subtotal\": \"Cart Subtotal\", \"Shipping Charge\": \"Shipping Charge\", \"Paid Amount\": \"Paid Amount\", \"Payment Method\": \"Payment Method\", \"Shipping Method\": \"Shipping Method\", \"Order Total\": \"Order Total\", \"Pay Via\": \"Pay Via\", \"Paypal\": \"Paypal\", \"Stripe\": \"Stripe\", \"Card Number\": \"Card Number\", \"CVC\": \"CVC\", \"Month\": \"Month\", \"Year\": \"Year\", \"Pleace Order\": \"Pleace Order\", \"Dashboard\": \"Dashboard\", \"Edit Profile\": \"Edit Profile\", \"Shipping Details\": \"Shipping Details\", \"Billing Details\": \"Billing Details\", \"Change Password\": \"Change Password\", \"My Orders\": \"My Orders\", \"Logout\": \"Logout\", \"Edit Billing Details\": \"Edit Billing Details\", \"Billing First Name\": \"Billing First Name\", \"Billing Last Name\": \"Billing Last Name\", \"Billing Email\": \"Billing Email\", \"Billing User Name\": \"Billing User Name\", \"Billing Phone\": \"Billing Phone\", \"Billing City\": \"Billing City\", \"Billing State\": \"Billing State\", \"Billing Country\": \"Billing Country\", \"Billing Address\": \"Billing Address\", \"Submit\": \"Submit\", \"Reset Password\": \"Reset Password\", \"Re-Type Password\": \"Re-Type Password\", \"Account Information\": \"Account Information\", \"User\": \"User\", \"Username\": \"Username\", \"State\": \"State\", \"City\": \"City\", \"Total Orders\": \"Total Orders\", \"Recent Orders\": \"Recent Orders\", \"Order Number\": \"Order Number\", \"Total Price\": \"Total Price\", \"Action\": \"Action\", \"No Orders\": \"No Orders\", \"Forgot Password\": \"Forgot Password\", \"Login Now\": \"Login Now\", \"Send Mail\": \"Send Mail\", \"Login\": \"Login\", \"Password\": \"Password\", \"LOG IN\": \"LOG IN\", \"Don\'t have an account\": \"Don\'t have an account\", \"Lost your password\": \"Lost your password\", \"Order Details\": \"Order Details\", \"Pending\": \"Pending\", \"Received\": \"Received\", \"Preparing\": \"Preparing\", \"Ready to pick up\": \"Ready to pick up\", \"Picked up\": \"Picked up\", \"Delivered\": \"Delivered\", \"Cancelled\": \"Cancelled\", \"My Order Details\": \"My Order Details\", \"Order Date\": \"Order Date\", \"Order\": \"Order\", \"Download Invoice\": \"Download Invoice\", \"Payment Status\": \"Payment Status\", \"Image\": \"Image\", \"Name\": \"Name\", \"Details\": \"Details\", \"back\": \"back\", \"All Orders\": \"All Orders\", \"My Profile\": \"My Profile\", \"Upload\": \"Upload\", \"Register\": \"Register\", \"Confirmation Password\": \"Confirmation Password\", \"Already have an account ?\": \"Already have an account ?\", \"To login\": \"To login\", \"Click Here\": \"Click Here\", \"Current Password\": \"Current Password\", \"New Password\": \"New Password\", \"Confirm Password\": \"Confirm Password\", \"Edit Shipping Details\": \"Edit Shipping Details\", \"Shipping First Name\": \"Shipping First Name\", \"Shipping Last Name\": \"Shipping Last Name\", \"Shipping Email\": \"Shipping Email\", \"Shipping User Name\": \"Shipping User Name\", \"Shipping Phone\": \"Shipping Phone\", \"Shipping City\": \"Shipping City\", \"Shipping State\": \"Shipping State\", \"Shipping Country\": \"Shipping Country\", \"Shipping Address\": \"Shipping Address\", \"Order Notes\": \"Order Notes\", \"Category\": \"Category\", \"All\": \"All\", \"Product Not Fount\": \"Product Not Fount\", \"Filter Products\": \"Filter Products\", \"Star and higher\": \"Star and higher\", \"Admin\": \"Admin\", \"Reviews For\": \"Reviews For\", \"Success\": \"Success\", \"Your order has been placed successfully!\": \"Your order has been placed successfully!\", \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\", \"Thank you.\": \"Thank you.\", \"You\'re lost\": \"You\'re lost\", \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\", \"Back Home\": \"Back Home\", \"Reviews(S)\": \"Reviews(S)\", \"IN STOCK\": \"IN STOCK\", \"OUT OF STOCK\": \"OUT OF STOCK\", \"Qty\": \"Qty\", \"Description\": \"Description\", \"Comments\": \"Comments\", \"Reviews\": \"Reviews\", \"Comment\": \"Comment\", \"Rating\": \"Rating\", \"Newest Product\": \"Newest Product\", \"Oldest Product\": \"Oldest Product\", \"Price: High To Low\": \"Price: High To Low\", \"Price: Low To High\": \"Price: Low To High\", \"Search Keywords\": \"Search Keywords\", \"Subscribe Here\": \"Subscribe Here\", \"Enter Your Email\": \"Enter Your Email\", \"Jobs\": \"Jobs\", \"NO JOB FOUND\": \"NO JOB FOUND\", \"Deadline\": \"Deadline\", \"Educational Experience\": \"Educational Experience\", \"Work Experience\": \"Work Experience\", \"Search Jobs\": \"Search Jobs\", \"Vacancy\": \"Vacancy\", \"Job Responsibilities\": \"Job Responsibilities\", \"Employment Status\": \"Employment Status\", \"Educational Requirements\": \"Educational Requirements\", \"Experience Requirements\": \"Experience Requirements\", \"Additional Requirements\": \"Additional Requirements\", \"Job Location\": \"Job Location\", \"Salary\": \"Salary\", \"Compensation & Other Benefits\": \"Compensation & Other Benefits\", \"Read Before Apply\": \"Read Before Apply\", \"Job Categories\": \"Job Categories\", \"Send your CV to\": \"Send your CV to\",\"Checkout as Guest\":\"Checkout as Guest\",\"OR\":\"OR\",\"Login via Facebook\":\"Login via Facebook\",\"Login via Google\":\"Login via Google\",\"Serving Method\":\"Serving Method\",\"On Table\":\"On Table\",\"Pick Up\":\"Pick Up\",\"Home Delivery\":\"Home Delivery\",\"Information\":\"Information\",\"Table Number\":\"Table Number\",\"Waiter Name\":\"Waiter Name\",\"Pick up Date\":\"Pick up Date\",\"Pick up Time\":\"Pick up Time\",\"Cart Total\":\"Cart Total\",\"Discount\":\"Discount\",\"Tax\":\"Tax\",\"Coupon\":\"Coupon\",\"Receipt\":\"Receipt\",\"Place Order\":\"Place Order\",\"Return to Website\":\"Return to Website\",\"Paystack\":\"Paystack\",\"Flutterwave\":\"Flutterwave\",\"Razorpay\":\"Razorpay\",\"Instamojo\":\"Instamojo\",\"Paytm\":\"Paytm\",\"PayUmoney\":\"PayUmoney\",\"Mollie\":\"Mollie\",\"Mercadopago\":\"Mercadopago\",\"Shipping Charges\":\"Shipping Charges\",\"Delivery Date\":\"Delivery Date\",\"Delivery Time\":\"Delivery Time\",\"Ready to Serve\":\"Ready to Serve\",\"Served\":\"Served\",\"Ordered From\":\"Ordered From\",\"Website Menu\":\"Website Menu\",\"QR Menu\":\"QR Menu\",\"Complete\":\"Complete\",\"Working Hours\":\"Working Hours\",\"Return to Menu\": \"Return to Menu\",\"Apply\": \"Apply\",\"Token No\": \"Token No\", \"Postal Code\": \"Postal Code\", \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",\"Delivery Area\": \"Delivery Area\",\"Call Waiter\": \"Call Waiter\",\"Table\": \"Table\", \"Select a Table\": \"Select a Table\",\"Restaurant is informed!\": \"Restaurant is informed!\" ,\"Add_To_Menus\":\"Add to Menus\",\"NO_SPECIAL_PRODUCT_FOUND!\":\"NO SPECIAL PRODUCT FOUND!\",\"NO_MEMBERS_FOUND!\":\"NO MEMBERS FOUND!\",\"NO_CLIEND_FOUND!\":\"NO CLIEND FOUND!\",\"NO_BLOG_POST_FOUND!\":\"NO BLOG POST FOUND!\",\"Write_a_message\":\"Write a message\",\"NO_FAQ_FOUND!\":\"NO FAQ FOUND!\",\"NO_GALLERY_IMAGE_FOUND!\":\"NO GALLERY IMAGE FOUND!\",\"NO_TEAM_FOUND!\":\"NO TEAM FOUND!\",\"ALL\":\"ALL\",\"Filter\":\"Filter\",\"Filter_By_Price\":\"Filter By Price\",\"Show_All\":\"Show All\",\"Cart_is_empty\":\"Cart is empty\",\"On_Table\":\"On Table\",\"Pick_UP\":\"Pick Up\",\"Home_Delivery\":\"Home Delivery\",\"Select_a_postal_code\":\"Select a postal code\",\"Select\":\"Select\",\"Type\":\"Type\",\"Item_Total\":\"Item Total\",\"No_Menu_Found!\":\"No Menu Found!\",\"You are lost\":\"You are lost\",\"Get Back to Home\":\"Get Back to Home\"}\n', 7, '', '2023-09-10 02:40:30', '2023-09-10 02:40:30'),
(18, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",   \"Pick Up\": \"Pick Up\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\"}', 13, '', '2023-09-10 11:53:03', '2023-09-10 11:53:03'),
(19, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\",\"Page Not Found\":\"Page Not Found\", \"January\": \"January\",   \"February\": \"February\",   \"March\": \"March\",   \"April\": \"April\",   \"May\": \"May\",   \"June\": \"June\",   \"July\": \"July\",   \"August\": \"August\",   \"September\": \"September\",   \"October\": \"October\",   \"November\": \"November\",   \"December\": \"December\",\"Monday\": \"Mo\",   \"Tuesday\": \"Tu\",   \"Wednesday\": \"We\",   \"Thursday\": \"Th\",   \"Friday\": \"Fr\",   \"Saturday\": \"Sa\",   \"Sunday\": \"Su\",\"Showing\":\"Showing\",\"to\":\"to\",\"of\":\"of\",\"entries\":\"entries\",\"Show\":\"Show\"}', 14, '6583c1dc83024', '2023-09-10 15:39:02', '2023-09-27 16:04:06');
INSERT INTO `user_languages` (`id`, `name`, `code`, `is_default`, `rtl`, `keywords`, `user_id`, `datepicker_name`, `created_at`, `updated_at`) VALUES
(21, 'Arabic', 'ar', 0, 1, '{   \"Home\": \"بيت\",   \"Menu\": \"قائمة طعام\",   \"Items\": \"أغراض\",   \"Team\": \"فريق\",   \"Teams\": \"فرق\",   \"Contact\": \"اتصال\",   \"Gallery\": \"صالة عرض\",   \"Team Members\": \"أعضاء الفريق\",   \"Cart\": \"عربة التسوق\",   \"Reservation\": \"حجز\",   \"Blog\": \"مدونة\",   \"Add Cart\": \"إضافة عربة\",   \"Opening Time\": \"وقت مفتوح\",   \"Buy Now\": \"اشتري الآن\",   \"Discover Food Menu\": \"اكتشف قائمة الطعام\",   \"View All Items\": \"عرض كافة العناصر\",   \"Our\": \"ملكنا\",   \"Special\": \"خاص\",   \"Good\": \"جيد\",   \"Food\": \"طعام\",   \"Price\": \"سعر\",   \"View All Menu List\": \"عرض جميع قائمة القائمة\",   \"Product Not Found\": \"الصنف غير موجود\",   \"Stars\": \"النجوم\",   \"Read More\": \"اقرأ أكثر\",   \"Book A Table\": \"احجز طاولة\",   \"Full Name\": \"الاسم الكامل\",   \"Phone\": \"هاتف\",   \"Date\": \"تاريخ\",   \"Time\": \"وقت\",   \"Person\": \"شخص\",   \"Book Table\": \"طاولة كتب\",   \"Our Blog\": \"مدونتنا\",   \"No Blogs\": \"لا مدونات\",   \"Share\": \"يشارك\",   \"All Categories\": \"جميع الفئات\",   \"Contact Us\": \"اتصل بنا\",   \"Your Name\": \"اسمك\",   \"Email Address\": \"عنوان البريد الإلكتروني\",   \"Subject\": \"موضوع\",   \"Write a message\": \"اكتب رسالة\",   \"Submit Now\": \"أرسل الآن\",   \"Career\": \"حياة مهنية\",   \"Job Details\": \"تفاصيل الوظيفة\",   \"Our Gallery\": \"معرضنا\",   \"FAQ\": \"التعليمات\",   \"Photos Action\": \"صور العمل\",   \"Our Awesome Gallery\": \"معرضنا الرائع\",   \"Exparts Our Team\": \"يتفوق على فريقنا\",   \"Your Cart\": \"عربتك\",   \"Total\": \"المجموع\",   \"Products\": \"منتجات\",   \"Product\": \"منتج\",   \"Product Title\": \"عنوان المنتج\",   \"Variations\": \"الاختلافات\",   \"Variation\": \"تفاوت\",   \"Add On\'s\": \"الإضافات\",   \"Ordered Products\": \"المنتجات المطلوبة\",   \"Select Variation\": \"حدد الاختلاف\",   \"Select Add On\'s\": \"حدد الإضافات\",   \"Optional\": \"خياري\",   \"Add to Cart\": \"أضف إلى السلة\",   \"Quantity\": \"كمية\",   \"Availability\": \"التوفر\",   \"Item(s)\": \"أغراض)\",   \"Remove\": \"يزيل\",   \"Avilable Now\": \"متاح الآن\",   \"Out Of Stock\": \"إنتهى من المخزن\",   \"Cart is empty!\": \"البطاقه خاليه!\",   \"Checkout\": \"الدفع\",   \"Update Cart\": \"تحديث العربة\",   \"Country\": \"دولة\",   \"First Name\": \"الاسم الأول\",   \"Last Name\": \"اسم العائلة\",   \"Address\": \"عنوان\",   \"Town / City\": \"المدينة / المدينة\",   \"Contact Email\": \"تواصل بالبريد الاكتروني\",   \"Shipping Methods\": \"طرق الشحن\",   \"Method\": \"طريقة\",   \"Cost\": \"يكلف\",   \"Free Shipping\": \"ًالشحن مجانا\",   \"10 to 15 days\": \"10 إلى 15 يومًا\",   \"Order Summary\": \"ملخص الطلب\",   \"Cart is empty\": \"البطاقه خاليه\",   \"Cart Totals\": \"إجماليات سلة التسوق\",   \"Cart Subtotal\": \"المجموع الفرعي لسلة التسوق\",   \"Shipping Charge\": \"رسوم الشحن\",   \"Paid Amount\": \"المبلغ المدفوع\",   \"Payment Method\": \"طريقة الدفع او السداد\",   \"Shipping Method\": \"طريقة الشحن\",   \"Order Total\": \"الطلب الكلي\",   \"Pay Via\": \"الدفع عن طريق\",   \"Paypal\": \"باي بال\",   \"Stripe\": \"شريط\",   \"Card Number\": \"رقم البطاقة\",   \"CVC\": \"رمز التحقق من البطاقة\",   \"Month\": \"شهر\",   \"Year\": \"سنة\",   \"Pleace Order\": \"يرجى الطلب\",   \"Dashboard\": \"لوحة القيادة\",   \"Edit Profile\": \"تعديل الملف الشخصي\",   \"Shipping Details\": \"تفاصيل الشحن\",   \"Billing Details\": \"تفاصيل الفاتورة\",   \"Change Password\": \"تغيير كلمة المرور\",   \"My Orders\": \"طلباتي\",   \"Logout\": \"تسجيل خروج\",   \"Edit Billing Details\": \"تحرير تفاصيل الفواتير\",   \"Billing First Name\": \"الاسم الأول للفوترة\",   \"Billing Last Name\": \"الفواتير اسم العائلة\",   \"Billing Email\": \"البريد الالكتروني لقوائم الدفع\",   \"Billing User Name\": \"اسم مستخدم الفوترة\",   \"Billing Phone\": \"فوتير الهاتف\",   \"Billing City\": \"مدينة الفواتير\",   \"Billing State\": \"دولة إرسال الفواتير\",   \"Billing Country\": \"بلد إرسال الفواتير\",   \"Billing Address\": \"عنوان وصول الفواتير\",   \"Submit\": \"يُقدِّم\",   \"Reset Password\": \"إعادة تعيين كلمة المرور\",   \"Re-Type Password\": \"أعد إدخال كلمة السر\",   \"Account Information\": \"معلومات الحساب\",   \"User\": \"مستخدم\",   \"Username\": \"اسم المستخدم\",   \"State\": \"ولاية\",   \"City\": \"مدينة\",   \"Total Orders\": \"إجمالي الطلبات\",   \"Recent Orders\": \"الطلبيات الأخيرة\",   \"Order Number\": \"رقم الأمر\",   \"Total Price\": \"السعر الكلي\",   \"Action\": \"فعل\",   \"No Orders\": \"لا أوامر\",   \"Forgot Password\": \"هل نسيت كلمة السر\",   \"Login Now\": \"تسجيل الدخول الآن\",   \"Send Mail\": \"ارسل بريد\",   \"Login\": \"تسجيل الدخول\",   \"Password\": \"كلمة المرور\",   \"LOG IN\": \"تسجيل الدخول\",   \"Don\'t have an account\": \"ليس لديك حساب\",   \"Lost your password\": \"فقدت كلمة المرور الخاصة بك\",   \"Order Details\": \"تفاصيل الطلب\",   \"Pending\": \"قيد الانتظار\",   \"Received\": \"تلقى\",   \"Preparing\": \"خطة\",   \"Ready to pick up\": \"على استعداد لالتقاط\",   \"Picked up\": \"التقطت\",   \"Delivered\": \"تم التوصيل\",   \"Cancelled\": \"ألغيت\",   \"My Order Details\": \"تفاصيل طلبي\",   \"Order Date\": \"تاريخ الطلب\",   \"Order\": \"طلب\",   \"Download Invoice\": \"تحميل فاتورة\",   \"Payment Status\": \"حالة السداد\",   \"Image\": \"صورة\",   \"Name\": \"اسم\",   \"Details\": \"تفاصيل\",   \"back\": \"خلف\",   \"All Orders\": \"جميع الطلبات\",   \"My Profile\": \"ملفي\",   \"Upload\": \"رفع\",   \"Register\": \"يسجل\",   \"Confirmation Password\": \"تأكيد كلمة المرور\",   \"Already have an account ?\": \"هل لديك حساب ؟\",   \"To login\": \"لتسجيل الدخول\",   \"Click Here\": \"انقر هنا\",   \"Current Password\": \"كلمة السر الحالية\",   \"New Password\": \"كلمة المرور الجديدة\",   \"Confirm Password\": \"تأكيد كلمة المرور\",   \"Edit Shipping Details\": \"تحرير تفاصيل الشحن\",   \"Shipping First Name\": \"الاسم الأول للشحن\",   \"Shipping Last Name\": \"اسم العائلة للشحن\",   \"Shipping Email\": \"البريد الإلكتروني للشحن\",   \"Shipping User Name\": \"اسم مستخدم الشحن\",   \"Shipping Phone\": \"هاتف الشحن\",   \"Shipping City\": \"مدينة الشحن\",   \"Shipping State\": \"دولة الشحن\",   \"Shipping Country\": \"بلد الشحن\",   \"Shipping Address\": \"عنوان الشحن\",   \"Order Notes\": \"ترتيب ملاحظات\",   \"Category\": \"فئة\",   \"All\": \"الجميع\",   \"Product Not Fount\": \"المنتج غير موجود\",   \"Filter Products\": \"منتجات التصفية\",   \"Star and higher\": \"نجمة وأعلى\",   \"Admin\": \"مسؤل\",   \"Reviews For\": \"تعليقات ل\",   \"Success\": \"نجاح\",   \"Your order has been placed successfully!\": \"لقد تم تقديم طلبك بنجاح!\",   \"We have sent you a mail with an invoice.\": \"لقد أرسلنا لك بريدًا يحتوي على فاتورة.\",   \"Thank you.\": \"شكرًا لك.\",   \"You\'re lost\": \"أنت ضائع\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"ربما تم نقل الصفحة التي تبحث عنها، أو أعيدت تسميتها، أو ربما لم تكن موجودة على الإطلاق.\",   \"Back Home\": \"العودة إلى المنزل\",   \"Reviews(S)\": \"التعليقات (التعليقات)\",   \"IN STOCK\": \"في الأوراق المالية\",   \"OUT OF STOCK\": \"إنتهى من المخزن\",   \"Qty\": \"الكمية\",   \"Description\": \"وصف\",   \"Comments\": \"تعليقات\",   \"Reviews\": \"التعليقات\",   \"Comment\": \"تعليق\",   \"Rating\": \"تقييم\",   \"Newest Product\": \"أحدث منتج\",   \"Oldest Product\": \"أقدم منتج\",   \"Price: High To Low\": \"السعر الاعلى الى الادنى\",   \"Price: Low To High\": \"السعر من الارخص للاعلى\",   \"Search Keywords\": \"كلمات البحث\",   \"Subscribe Here\": \"اشترك هنا\",   \"Enter Your Email\": \"أدخل بريدك الإلكتروني\",   \"Jobs\": \"وظائف\",   \"NO JOB FOUND\": \"لم يتم العثور على وظيفة\",   \"Deadline\": \"موعد التسليم\",   \"Educational Experience\": \"الخبرة التعليمية\",   \"Work Experience\": \"خبرة في العمل\",   \"Search Jobs\": \"بحث وظائف\",   \"Vacancy\": \"خالي\",   \"Job Responsibilities\": \"مسؤوليات العمل\",   \"Employment Status\": \"الحالة الوظيفية\",   \"Educational Requirements\": \"المتطلبات التعليمية\",   \"Experience Requirements\": \"متطلبات الخبرة\",   \"Additional Requirements\": \"متطلبات إضافية\",   \"Job Location\": \"مكان العمل\",   \"Salary\": \"مرتب\",   \"Compensation & Other Benefits\": \"تعويض\",   \"Read Before Apply\": \"اقرأ قبل التقديم\",   \"Job Categories\": \"فئات الوظائف\",   \"Send your CV to\": \"أرسل سيرتك الذاتية إلى\",   \"Checkout as Guest\": \"الخروج كضيف\",   \"OR\": \"أو\",   \"Login via Facebook\": \"تسجيل الدخول عبر الفيسبوك\",   \"Login via Google\": \"تسجيل الدخول عبر جوجل\",   \"Serving Method\": \"طريقة التقديم\",   \"On Table\": \"على الطاولة\",   \"Home Delivery\": \"توصيل منزلي\",   \"Information\": \"معلومة\",   \"Table Number\": \"رقم الطاولة\",   \"Waiter Name\": \"اسم النادل\",   \"Pick up Date\": \"اختر تاريخا\",   \"Pick up Time\": \"اختار المعاد\",   \"Cart Total\": \"إجمالي العربة\",   \"Discount\": \"تخفيض\",   \"Tax\": \"ضريبة\",   \"Coupon\": \"قسيمة\",   \"Receipt\": \"إيصال\",   \"Place Order\": \"مكان الامر\",   \"Return to Website\": \"العودة إلى الموقع\",   \"Paystack\": \"الراتب\",   \"Flutterwave\": \"موجة الرفرفة\",   \"Razorpay\": \"رازورباي\",   \"Instamojo\": \"إنستاموجو\",   \"Paytm\": \"بايتم\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"مولي\",   \"Mercadopago\": \"ميركادوباجو\",   \"Shipping Charges\": \"رسوم الشحن\",   \"Delivery Date\": \"تاريخ التسليم او الوصول\",   \"Delivery Time\": \"موعد التسليم\",   \"Ready to Serve\": \"جاهز للخدمة\",   \"Served\": \"خدم\",   \"Ordered From\": \"تم الطلب من\",   \"Website Menu\": \"قائمة الموقع\",   \"QR Menu\": \"قائمة QR\",   \"Complete\": \"مكتمل\",   \"Working Hours\": \"ساعات العمل\",   \"Return to Menu\": \"العودة إلى القائمة\",   \"Apply\": \"يتقدم\",   \"Token No\": \"رقم الرمز المميز\",   \"Postal Code\": \"رمز بريدي\",   \"Billing Address will be Same as Shipping Address\": \"سيكون عنوان إرسال الفواتير هو نفس عنوان الشحن\",   \"Delivery Area\": \"منطقة التسليم\",   \"Call Waiter\": \"استدعاء النادل\",   \"Table\": \"طاولة\",   \"Select a Table\": \"حدد جدولاً\",   \"Restaurant is informed!\": \"تم إبلاغ المطعم!\",   \"Add_To_Menus\": \"إضافة إلى القوائم\",   \"NO SPECIAL PRODUCT FOUND!\": \"لم يتم العثور على منتج خاص!\",   \"NO MEMBERS FOUND!\": \"لم يتم العثور على أعضاء!\",   \"NO CLIEND FOUND!\": \"لم يتم العثور على أي عميل!\",   \"NO BLOG POST FOUND!\": \"لم يتم العثور على أي مشاركة في المدونة!\",   \"NO FAQ FOUND!\": \"لم يتم العثور على الأسئلة الشائعة!\",   \"NO GALLERY IMAGE FOUND!\": \"لم يتم العثور على صورة في المعرض!\",   \"NO TEAM FOUND!\": \"لم يتم العثور على فريق!\",   \"ALL\": \"الجميع\",   \"Filter\": \"منقي\",   \"Filter_By_Price\": \"تصفية حسب السعر\",   \"Show_All\": \"عرض الكل\",   \"Cart_is_empty\": \"البطاقه خاليه\",   \"On_Table\": \"على الطاولة\",   \"Home_Delivery\": \"توصيل منزلي\",   \"Select_a_postal_code\": \"حدد الرمز البريدي\",   \"Select\": \"يختار\",   \"Type\": \"يكتب\",   \"Item Total\": \"مجموع الاشياء\",   \"No Menu Found!\": \"لم يتم العثور على القائمة!\",   \"You are lost\": \"أنت ضائع\",   \"Get Back to Home\": \"العودة إلى المنزل\",   \"Addons\": \"إضافات\",   \"Subcategory\": \"تصنيف فرعي\",   \"Review\": \"مراجعة\",   \"Blog Details\": \"تفاصيل المدونة\",   \"Career Details\": \"التفاصيل المهنية\",   \"Enter your card number\": \"أدخل رقم بطاقتك\",   \"Enter expiry month\": \"أدخل شهر انتهاء الصلاحية\",   \"Enter expiry year\": \"أدخل سنة انتهاء الصلاحية\",   \"Enter card code\": \"أدخل رمز البطاقة\",   \"Select a time frame\": \"حدد إطارًا زمنيًا\",   \"Select Addons\": \"حدد الإضافات\",   \"Authorize\": \"يأذن\",   \"to leave a rating\": \"لترك التقييم\",   \"Website\": \"موقع إلكتروني\",   \"QR\": \"ريال قطري\",   \"Pick_Up\": \"يلتقط\",   \"Pick UP\": \"يلتقط\",   \"Subtotal\": \"المجموع الفرعي\",   \"Grand Total\": \"المجموع الإجمالي\",   \"Completed\": \"مكتمل\",   \"Yes\": \"نعم\",   \"No\": \"لا\",   \"Select a Time Frame\": \"حدد الإطار الزمني\",   \"Receipt image must be .jpg / .jpeg / .png\": \"يجب أن تكون صورة الإيصال .jpg / .jpeg / .png\",   \"Page Not Found\": \"الصفحة غير موجودة\",   \"January\": \"يناير\",   \"February\": \"شهر فبراير\",   \"March\": \"يمشي\",   \"April\": \"أبريل\",   \"May\": \"يمكن\",   \"June\": \"يونيو\",   \"July\": \"يوليو\",   \"August\": \"أغسطس\",   \"September\": \"سبتمبر\",   \"October\": \"اكتوبر\",   \"November\": \"شهر نوفمبر\",   \"December\": \"ديسمبر\",   \"Monday\": \"شهر\",   \"Tuesday\": \"تو\",   \"Wednesday\": \"نحن\",   \"Thursday\": \"ذ\",   \"Friday\": \"الأب\",   \"Saturday\": \"سا\",   \"Sunday\": \"سو\",   \"Showing\": \"عرض\",   \"to\": \"ل\",   \"of\": \"ل\",   \"entries\": \"إدخالات\",\"Show\":\"يعرض\" }', 14, '6583bf785e904', '2023-09-10 17:41:03', '2023-12-20 17:35:31'),
(24, 'English', 'en', 1, 0, '{ \"Home\": \"Home\", \"Menu\": \"Menu\", \"Items\": \"Items\", \"Team\": \"Team\", \"Teams\": \"Teams\", \"Contact\": \"Contact\", \"Gallery\": \"Gallery\", \"Team Members\": \"Team Members\", \"Cart\": \"Cart\", \"Reservation\": \"Reservation\", \"Blog\": \"Blog\", \"Add Cart\": \"Add Cart\", \"Opening Time\": \"Opening Time\", \"Buy Now\": \"Buy Now\", \"Discover Food Menu\": \"Discover Food Menu\", \"View All Items\": \"View All Items\", \"Our\": \"Our\", \"Special\": \"Special\", \"Good\": \"Good\", \"Food\": \"Food\", \"Price\": \"Price\", \"View All Menu List\": \"View All Menu List\", \"Product Not Found\": \"Product Not Found\", \"Stars\": \"Stars\", \"Read More\": \"Read More\", \"Book A Table\": \"Book A Table\", \"Full Name\": \"Full Name\", \"Phone\": \"Phone\", \"Date\": \"Date\", \"Time\": \"Time\", \"Person\": \"Person\", \"Book Table\": \"Book Table\", \"Our Blog\": \"Our Blog\", \"No Blogs\": \"No Blogs\", \"Share\": \"Share\", \"All Categories\": \"All Categories\", \"Contact Us\": \"Contact Us\", \"Your Name\": \"Your Name\", \"Email Address\": \"Email Address\", \"Subject\": \"Subject\", \"Write a message\": \"Write a message\", \"Submit Now\": \"Submit Now\", \"Career\": \"Career\", \"Job Details\": \"Job Details\", \"Our Gallery\": \"Our Gallery\", \"FAQ\": \"FAQ\", \"Photos Action\": \"Photos Action\", \"Our Awesome Gallery\": \"Our Awesome Gallery\", \"Exparts Our Team\": \"Exparts Our Team\", \"Your Cart\": \"Your Cart\", \"Total\": \"Total\", \"Products\": \"Products\", \"Product\": \"Product\", \"Product Title\": \"Product Title\", \"Variations\": \"Variations\", \"Variation\": \"Variation\", \"Add On\'s\": \"Add On\'s\", \"Ordered Products\": \"Ordered Products\", \"Select Variation\": \"Select Variation\", \"Select Add On\'s\": \"Select Add On\'s\", \"Optional\": \"Optional\", \"Add to Cart\": \"Add to Cart\", \"Quantity\": \"Quantity\", \"Availability\": \"Availability\", \"Item(s)\": \"Item(s)\", \"Remove\": \"Remove\", \"Avilable Now\": \"Avilable Now\", \"Out Of Stock\": \"Out Of Stock\", \"Cart is empty!\": \"Cart is empty!\", \"Checkout\": \"Checkout\", \"Update Cart\": \"Update Cart\", \"Country\": \"Country\", \"First Name\": \"First Name\", \"Last Name\": \"Last Name\", \"Address\": \"Address\", \"Town \\/ City\": \"Town \\/ City\", \"Contact Email\": \"Contact Email\", \"Shipping Methods\": \"Shipping Methods\", \"Method\": \"Method\", \"Cost\": \"Cost\", \"Free Shipping\": \"Free Shipping\", \"10 to 15 days\": \"10 to 15 days\", \"Order Summary\": \"Order Summary\", \"Cart is empty\": \"Cart is empty\", \"Cart Totals\": \"Cart Totals\", \"Cart Subtotal\": \"Cart Subtotal\", \"Shipping Charge\": \"Shipping Charge\", \"Paid Amount\": \"Paid Amount\", \"Payment Method\": \"Payment Method\", \"Shipping Method\": \"Shipping Method\", \"Order Total\": \"Order Total\", \"Pay Via\": \"Pay Via\", \"Paypal\": \"Paypal\", \"Stripe\": \"Stripe\", \"Card Number\": \"Card Number\", \"CVC\": \"CVC\", \"Month\": \"Month\", \"Year\": \"Year\", \"Pleace Order\": \"Pleace Order\", \"Dashboard\": \"Dashboard\", \"Edit Profile\": \"Edit Profile\", \"Shipping Details\": \"Shipping Details\", \"Billing Details\": \"Billing Details\", \"Change Password\": \"Change Password\", \"My Orders\": \"My Orders\", \"Logout\": \"Logout\", \"Edit Billing Details\": \"Edit Billing Details\", \"Billing First Name\": \"Billing First Name\", \"Billing Last Name\": \"Billing Last Name\", \"Billing Email\": \"Billing Email\", \"Billing User Name\": \"Billing User Name\", \"Billing Phone\": \"Billing Phone\", \"Billing City\": \"Billing City\", \"Billing State\": \"Billing State\", \"Billing Country\": \"Billing Country\", \"Billing Address\": \"Billing Address\", \"Submit\": \"Submit\", \"Reset Password\": \"Reset Password\", \"Re-Type Password\": \"Re-Type Password\", \"Account Information\": \"Account Information\", \"User\": \"User\", \"Username\": \"Username\", \"State\": \"State\", \"City\": \"City\", \"Total Orders\": \"Total Orders\", \"Recent Orders\": \"Recent Orders\", \"Order Number\": \"Order Number\", \"Total Price\": \"Total Price\", \"Action\": \"Action\", \"No Orders\": \"No Orders\", \"Forgot Password\": \"Forgot Password\", \"Login Now\": \"Login Now\", \"Send Mail\": \"Send Mail\", \"Login\": \"Login\", \"Password\": \"Password\", \"LOG IN\": \"LOG IN\", \"Don\'t have an account\": \"Don\'t have an account\", \"Lost your password\": \"Lost your password\", \"Order Details\": \"Order Details\", \"Pending\": \"Pending\", \"Received\": \"Received\", \"Preparing\": \"Preparing\", \"Ready to pick up\": \"Ready to pick up\", \"Picked up\": \"Picked up\", \"Delivered\": \"Delivered\", \"Cancelled\": \"Cancelled\", \"My Order Details\": \"My Order Details\", \"Order Date\": \"Order Date\", \"Order\": \"Order\", \"Download Invoice\": \"Download Invoice\", \"Payment Status\": \"Payment Status\", \"Image\": \"Image\", \"Name\": \"Name\", \"Details\": \"Details\", \"back\": \"back\", \"All Orders\": \"All Orders\", \"My Profile\": \"My Profile\", \"Upload\": \"Upload\", \"Register\": \"Register\", \"Confirmation Password\": \"Confirmation Password\", \"Already have an account ?\": \"Already have an account ?\", \"To login\": \"To login\", \"Click Here\": \"Click Here\", \"Current Password\": \"Current Password\", \"New Password\": \"New Password\", \"Confirm Password\": \"Confirm Password\", \"Edit Shipping Details\": \"Edit Shipping Details\", \"Shipping First Name\": \"Shipping First Name\", \"Shipping Last Name\": \"Shipping Last Name\", \"Shipping Email\": \"Shipping Email\", \"Shipping User Name\": \"Shipping User Name\", \"Shipping Phone\": \"Shipping Phone\", \"Shipping City\": \"Shipping City\", \"Shipping State\": \"Shipping State\", \"Shipping Country\": \"Shipping Country\", \"Shipping Address\": \"Shipping Address\", \"Order Notes\": \"Order Notes\", \"Category\": \"Category\", \"All\": \"All\", \"Product Not Fount\": \"Product Not Fount\", \"Filter Products\": \"Filter Products\", \"Star and higher\": \"Star and higher\", \"Admin\": \"Admin\", \"Reviews For\": \"Reviews For\", \"Success\": \"Success\", \"Your order has been placed successfully!\": \"Your order has been placed successfully!\", \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\", \"Thank you.\": \"Thank you.\", \"You\'re lost\": \"You\'re lost\", \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\", \"Back Home\": \"Back Home\", \"Reviews(S)\": \"Reviews(S)\", \"IN STOCK\": \"IN STOCK\", \"OUT OF STOCK\": \"OUT OF STOCK\", \"Qty\": \"Qty\", \"Description\": \"Description\", \"Comments\": \"Comments\", \"Reviews\": \"Reviews\", \"Comment\": \"Comment\", \"Rating\": \"Rating\", \"Newest Product\": \"Newest Product\", \"Oldest Product\": \"Oldest Product\", \"Price: High To Low\": \"Price: High To Low\", \"Price: Low To High\": \"Price: Low To High\", \"Search Keywords\": \"Search Keywords\", \"Subscribe Here\": \"Subscribe Here\", \"Enter Your Email\": \"Enter Your Email\", \"Jobs\": \"Jobs\", \"NO JOB FOUND\": \"NO JOB FOUND\", \"Deadline\": \"Deadline\", \"Educational Experience\": \"Educational Experience\", \"Work Experience\": \"Work Experience\", \"Search Jobs\": \"Search Jobs\", \"Vacancy\": \"Vacancy\", \"Job Responsibilities\": \"Job Responsibilities\", \"Employment Status\": \"Employment Status\", \"Educational Requirements\": \"Educational Requirements\", \"Experience Requirements\": \"Experience Requirements\", \"Additional Requirements\": \"Additional Requirements\", \"Job Location\": \"Job Location\", \"Salary\": \"Salary\", \"Compensation & Other Benefits\": \"Compensation & Other Benefits\", \"Read Before Apply\": \"Read Before Apply\", \"Job Categories\": \"Job Categories\", \"Send your CV to\": \"Send your CV to\",\"Checkout as Guest\":\"Checkout as Guest\",\"OR\":\"OR\",\"Login via Facebook\":\"Login via Facebook\",\"Login via Google\":\"Login via Google\",\"Serving Method\":\"Serving Method\",\"On Table\":\"On Table\",\"Home Delivery\":\"Home Delivery\",\"Information\":\"Information\",\"Table Number\":\"Table Number\",\"Waiter Name\":\"Waiter Name\",\"Pick up Date\":\"Pick up Date\",\"Pick up Time\":\"Pick up Time\",\"Cart Total\":\"Cart Total\",\"Discount\":\"Discount\",\"Tax\":\"Tax\",\"Coupon\":\"Coupon\",\"Receipt\":\"Receipt\",\"Place Order\":\"Place Order\",\"Return to Website\":\"Return to Website\",\"Paystack\":\"Paystack\",\"Flutterwave\":\"Flutterwave\",\"Razorpay\":\"Razorpay\",\"Instamojo\":\"Instamojo\",\"Paytm\":\"Paytm\",\"PayUmoney\":\"PayUmoney\",\"Mollie\":\"Mollie\",\"Mercadopago\":\"Mercadopago\",\"Shipping Charges\":\"Shipping Charges\",\"Delivery Date\":\"Delivery Date\",\"Delivery Time\":\"Delivery Time\",\"Ready to Serve\":\"Ready to Serve\",\"Served\":\"Served\",\"Ordered From\":\"Ordered From\",\"Website Menu\":\"Website Menu\",\"QR Menu\":\"QR Menu\",\"Complete\":\"Complete\",\"Working Hours\":\"Working Hours\",\"Return to Menu\": \"Return to Menu\",\"Apply\": \"Apply\",\"Token No\": \"Token No\", \"Postal Code\": \"Postal Code\", \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",\"Delivery Area\": \"Delivery Area\",\"Call Waiter\": \"Call Waiter\",\"Table\": \"Table\", \"Select a Table\": \"Select a Table\",\"Restaurant is informed!\": \"Restaurant is informed!\" ,\"Add_To_Menus\":\"Add to Menus\",\"NO SPECIAL PRODUCT FOUND!\":\"NO SPECIAL PRODUCT FOUND!\",\"NO MEMBERS FOUND!\":\"NO MEMBERS FOUND!\",\"NO CLIEND FOUND!\":\"NO CLIEND FOUND!\",\"NO BLOG POST FOUND!\":\"NO BLOG POST FOUND!\",\"NO FAQ FOUND!\":\"NO FAQ FOUND!\",\"NO GALLERY IMAGE FOUND!\":\"NO GALLERY IMAGE FOUND!\",\"NO TEAM FOUND!\":\"NO TEAM FOUND!\",\"ALL\":\"ALL\",\"Filter\":\"Filter\",\"Filter_By_Price\":\"Filter By Price\",\"Show_All\":\"Show All\",\"Cart_is_empty\":\"Cart is empty\",\"On_Table\":\"On Table\",\"Pick UP\":\"Pick Up\",\"Home_Delivery\":\"Home Delivery\",\"Select_a_postal_code\":\"Select a postal code\",\"Select\":\"Select\",\"Type\":\"Type\",\"Item Total\":\"Item Total\",\"No Menu Found!\":\"No Menu Found!\",\"You are lost\":\"You are lost\",\"Get Back to Home\":\"Get Back to Home\",\"Addons\":\"Addons\",\"Subcategory\":\"Subcategory\",\"Review\":\"Review\",\"Blog Details\":\"Blog Details\",\"Career Details\":\"Career Details\",\"Enter your card number\":\"Enter your card number\",\"Enter expiry month\":\"Enter expiry month\",\"Enter expiry year\":\"Enter expiry year\",\"Enter card code\":\"Enter card code\",\"Town / City\":\"Town / City\",\"Select a time frame\":\"Select a time frame\",\"Select Addons\":\"Select Addons\",\"Authorize\":\"Authorize\",\"to leave a rating\":\"to leave a rating\",\"Website\":\"Website\",\"QR\":\"QR\"}\n', 28, '', '2023-11-29 09:06:57', '2023-11-29 09:06:57'),
(36, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\"}', 40, '', '2023-12-16 20:35:54', '2023-12-16 20:35:54'),
(37, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\",\"Page Not Found\":\"Page Not Found\"}', 42, '', '2023-12-18 17:22:26', '2023-12-18 17:22:26');
INSERT INTO `user_languages` (`id`, `name`, `code`, `is_default`, `rtl`, `keywords`, `user_id`, `datepicker_name`, `created_at`, `updated_at`) VALUES
(38, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\",\"Page Not Found\":\"Page Not Found\"}', 43, '', '2023-12-18 17:29:46', '2023-12-18 17:29:46'),
(51, 'English', 'en', 1, 0, '{   \"Home\": \"Home\",   \"Menu\": \"Menu\",   \"Items\": \"Items\",   \"Team\": \"Team\",   \"Teams\": \"Teams\",   \"Contact\": \"Contact\",   \"Gallery\": \"Gallery\",   \"Team Members\": \"Team Members\",   \"Cart\": \"Cart\",   \"Reservation\": \"Reservation\",   \"Blog\": \"Blog\",   \"Add Cart\": \"Add Cart\",   \"Opening Time\": \"Opening Time\",   \"Buy Now\": \"Buy Now\",   \"Discover Food Menu\": \"Discover Food Menu\",   \"View All Items\": \"View All Items\",   \"Our\": \"Our\",   \"Special\": \"Special\",   \"Good\": \"Good\",   \"Food\": \"Food\",   \"Price\": \"Price\",   \"View All Menu List\": \"View All Menu List\",   \"Product Not Found\": \"Product Not Found\",   \"Stars\": \"Stars\",   \"Read More\": \"Read More\",   \"Book A Table\": \"Book A Table\",   \"Full Name\": \"Full Name\",   \"Phone\": \"Phone\",   \"Date\": \"Date\",   \"Time\": \"Time\",   \"Person\": \"Person\",   \"Book Table\": \"Book Table\",   \"Our Blog\": \"Our Blog\",   \"No Blogs\": \"No Blogs\",   \"Share\": \"Share\",   \"All Categories\": \"All Categories\",   \"Contact Us\": \"Contact Us\",   \"Your Name\": \"Your Name\",   \"Email Address\": \"Email Address\",   \"Subject\": \"Subject\",   \"Write a message\": \"Write a message\",   \"Submit Now\": \"Submit Now\",   \"Career\": \"Career\",   \"Job Details\": \"Job Details\",   \"Our Gallery\": \"Our Gallery\",   \"FAQ\": \"FAQ\",   \"Photos Action\": \"Photos Action\",   \"Our Awesome Gallery\": \"Our Awesome Gallery\",   \"Exparts Our Team\": \"Exparts Our Team\",   \"Your Cart\": \"Your Cart\",   \"Total\": \"Total\",   \"Products\": \"Products\",   \"Product\": \"Product\",   \"Product Title\": \"Product Title\",   \"Variations\": \"Variations\",   \"Variation\": \"Variation\",   \"Add On\'s\": \"Add On\'s\",   \"Ordered Products\": \"Ordered Products\",   \"Select Variation\": \"Select Variation\",   \"Select Add On\'s\": \"Select Add On\'s\",   \"Optional\": \"Optional\",   \"Add to Cart\": \"Add to Cart\",   \"Quantity\": \"Quantity\",   \"Availability\": \"Availability\",   \"Item(s)\": \"Item(s)\",   \"Remove\": \"Remove\",   \"Avilable Now\": \"Avilable Now\",   \"Out Of Stock\": \"Out Of Stock\",   \"Cart is empty!\": \"Cart is empty!\",   \"Checkout\": \"Checkout\",   \"Update Cart\": \"Update Cart\",   \"Country\": \"Country\",   \"First Name\": \"First Name\",   \"Last Name\": \"Last Name\",   \"Address\": \"Address\",   \"Town / City\": \"Town / City\",   \"Contact Email\": \"Contact Email\",   \"Shipping Methods\": \"Shipping Methods\",   \"Method\": \"Method\",   \"Cost\": \"Cost\",   \"Free Shipping\": \"Free Shipping\",   \"10 to 15 days\": \"10 to 15 days\",   \"Order Summary\": \"Order Summary\",   \"Cart is empty\": \"Cart is empty\",   \"Cart Totals\": \"Cart Totals\",   \"Cart Subtotal\": \"Cart Subtotal\",   \"Shipping Charge\": \"Shipping Charge\",   \"Paid Amount\": \"Paid Amount\",   \"Payment Method\": \"Payment Method\",   \"Shipping Method\": \"Shipping Method\",   \"Order Total\": \"Order Total\",   \"Pay Via\": \"Pay Via\",   \"Paypal\": \"Paypal\",   \"Stripe\": \"Stripe\",   \"Card Number\": \"Card Number\",   \"CVC\": \"CVC\",   \"Month\": \"Month\",   \"Year\": \"Year\",   \"Pleace Order\": \"Pleace Order\",   \"Dashboard\": \"Dashboard\",   \"Edit Profile\": \"Edit Profile\",   \"Shipping Details\": \"Shipping Details\",   \"Billing Details\": \"Billing Details\",   \"Change Password\": \"Change Password\",   \"My Orders\": \"My Orders\",   \"Logout\": \"Logout\",   \"Edit Billing Details\": \"Edit Billing Details\",   \"Billing First Name\": \"Billing First Name\",   \"Billing Last Name\": \"Billing Last Name\",   \"Billing Email\": \"Billing Email\",   \"Billing User Name\": \"Billing User Name\",   \"Billing Phone\": \"Billing Phone\",   \"Billing City\": \"Billing City\",   \"Billing State\": \"Billing State\",   \"Billing Country\": \"Billing Country\",   \"Billing Address\": \"Billing Address\",   \"Submit\": \"Submit\",   \"Reset Password\": \"Reset Password\",   \"Re-Type Password\": \"Re-Type Password\",   \"Account Information\": \"Account Information\",   \"User\": \"User\",   \"Username\": \"Username\",   \"State\": \"State\",   \"City\": \"City\",   \"Total Orders\": \"Total Orders\",   \"Recent Orders\": \"Recent Orders\",   \"Order Number\": \"Order Number\",   \"Total Price\": \"Total Price\",   \"Action\": \"Action\",   \"No Orders\": \"No Orders\",   \"Forgot Password\": \"Forgot Password\",   \"Login Now\": \"Login Now\",   \"Send Mail\": \"Send Mail\",   \"Login\": \"Login\",   \"Password\": \"Password\",   \"LOG IN\": \"LOG IN\",   \"Don\'t have an account\": \"Don\'t have an account\",   \"Lost your password\": \"Lost your password\",   \"Order Details\": \"Order Details\",   \"Pending\": \"Pending\",   \"Received\": \"Received\",   \"Preparing\": \"Preparing\",   \"Ready to pick up\": \"Ready to pick up\",   \"Picked up\": \"Picked up\",   \"Delivered\": \"Delivered\",   \"Cancelled\": \"Cancelled\",   \"My Order Details\": \"My Order Details\",   \"Order Date\": \"Order Date\",   \"Order\": \"Order\",   \"Download Invoice\": \"Download Invoice\",   \"Payment Status\": \"Payment Status\",   \"Image\": \"Image\",   \"Name\": \"Name\",   \"Details\": \"Details\",   \"back\": \"back\",   \"All Orders\": \"All Orders\",   \"My Profile\": \"My Profile\",   \"Upload\": \"Upload\",   \"Register\": \"Register\",   \"Confirmation Password\": \"Confirmation Password\",   \"Already have an account ?\": \"Already have an account ?\",   \"To login\": \"To login\",   \"Click Here\": \"Click Here\",   \"Current Password\": \"Current Password\",   \"New Password\": \"New Password\",   \"Confirm Password\": \"Confirm Password\",   \"Edit Shipping Details\": \"Edit Shipping Details\",   \"Shipping First Name\": \"Shipping First Name\",   \"Shipping Last Name\": \"Shipping Last Name\",   \"Shipping Email\": \"Shipping Email\",   \"Shipping User Name\": \"Shipping User Name\",   \"Shipping Phone\": \"Shipping Phone\",   \"Shipping City\": \"Shipping City\",   \"Shipping State\": \"Shipping State\",   \"Shipping Country\": \"Shipping Country\",   \"Shipping Address\": \"Shipping Address\",   \"Order Notes\": \"Order Notes\",   \"Category\": \"Category\",   \"All\": \"All\",   \"Product Not Fount\": \"Product Not Fount\",   \"Filter Products\": \"Filter Products\",   \"Star and higher\": \"Star and higher\",   \"Admin\": \"Admin\",   \"Reviews For\": \"Reviews For\",   \"Success\": \"Success\",   \"Your order has been placed successfully!\": \"Your order has been placed successfully!\",   \"We have sent you a mail with an invoice.\": \"We have sent you a mail with an invoice.\",   \"Thank you.\": \"Thank you.\",   \"You\'re lost\": \"You\'re lost\",   \"The page you are looking for might have been moved, renamed, or might never existed.\": \"The page you are looking for might have been moved, renamed, or might never existed.\",   \"Back Home\": \"Back Home\",   \"Reviews(S)\": \"Reviews(S)\",   \"IN STOCK\": \"IN STOCK\",   \"OUT OF STOCK\": \"OUT OF STOCK\",   \"Qty\": \"Qty\",   \"Description\": \"Description\",   \"Comments\": \"Comments\",   \"Reviews\": \"Reviews\",   \"Comment\": \"Comment\",   \"Rating\": \"Rating\",   \"Newest Product\": \"Newest Product\",   \"Oldest Product\": \"Oldest Product\",   \"Price: High To Low\": \"Price: High To Low\",   \"Price: Low To High\": \"Price: Low To High\",   \"Search Keywords\": \"Search Keywords\",   \"Subscribe Here\": \"Subscribe Here\",   \"Enter Your Email\": \"Enter Your Email\",   \"Jobs\": \"Jobs\",   \"NO JOB FOUND\": \"NO JOB FOUND\",   \"Deadline\": \"Deadline\",   \"Educational Experience\": \"Educational Experience\",   \"Work Experience\": \"Work Experience\",   \"Search Jobs\": \"Search Jobs\",   \"Vacancy\": \"Vacancy\",   \"Job Responsibilities\": \"Job Responsibilities\",   \"Employment Status\": \"Employment Status\",   \"Educational Requirements\": \"Educational Requirements\",   \"Experience Requirements\": \"Experience Requirements\",   \"Additional Requirements\": \"Additional Requirements\",   \"Job Location\": \"Job Location\",   \"Salary\": \"Salary\",   \"Compensation & Other Benefits\": \"Compensation & Other Benefits\",   \"Read Before Apply\": \"Read Before Apply\",   \"Job Categories\": \"Job Categories\",   \"Send your CV to\": \"Send your CV to\",   \"Checkout as Guest\": \"Checkout as Guest\",   \"OR\": \"OR\",   \"Login via Facebook\": \"Login via Facebook\",   \"Login via Google\": \"Login via Google\",   \"Serving Method\": \"Serving Method\",   \"On Table\": \"On Table\",   \"Home Delivery\": \"Home Delivery\",   \"Information\": \"Information\",   \"Table Number\": \"Table Number\",   \"Waiter Name\": \"Waiter Name\",   \"Pick up Date\": \"Pick up Date\",   \"Pick up Time\": \"Pick up Time\",   \"Cart Total\": \"Cart Total\",   \"Discount\": \"Discount\",   \"Tax\": \"Tax\",   \"Coupon\": \"Coupon\",   \"Receipt\": \"Receipt\",   \"Place Order\": \"Place Order\",   \"Return to Website\": \"Return to Website\",   \"Paystack\": \"Paystack\",   \"Flutterwave\": \"Flutterwave\",   \"Razorpay\": \"Razorpay\",   \"Instamojo\": \"Instamojo\",   \"Paytm\": \"Paytm\",   \"PayUmoney\": \"PayUmoney\",   \"Mollie\": \"Mollie\",   \"Mercadopago\": \"Mercadopago\",   \"Shipping Charges\": \"Shipping Charges\",   \"Delivery Date\": \"Delivery Date\",   \"Delivery Time\": \"Delivery Time\",   \"Ready to Serve\": \"Ready to Serve\",   \"Served\": \"Served\",   \"Ordered From\": \"Ordered From\",   \"Website Menu\": \"Website Menu\",   \"QR Menu\": \"QR Menu\",   \"Complete\": \"Complete\",   \"Working Hours\": \"Working Hours\",   \"Return to Menu\": \"Return to Menu\",   \"Apply\": \"Apply\",   \"Token No\": \"Token No\",   \"Postal Code\": \"Postal Code\",   \"Billing Address will be Same as Shipping Address\": \"Billing Address will be Same as Shipping Address\",   \"Delivery Area\": \"Delivery Area\",   \"Call Waiter\": \"Call Waiter\",   \"Table\": \"Table\",   \"Select a Table\": \"Select a Table\",   \"Restaurant is informed!\": \"Restaurant is informed!\",   \"Add_To_Menus\": \"Add to Menus\",   \"NO SPECIAL PRODUCT FOUND!\": \"NO SPECIAL PRODUCT FOUND!\",   \"NO MEMBERS FOUND!\": \"NO MEMBERS FOUND!\",   \"NO CLIEND FOUND!\": \"NO CLIEND FOUND!\",   \"NO BLOG POST FOUND!\": \"NO BLOG POST FOUND!\",   \"NO FAQ FOUND!\": \"NO FAQ FOUND!\",   \"NO GALLERY IMAGE FOUND!\": \"NO GALLERY IMAGE FOUND!\",   \"NO TEAM FOUND!\": \"NO TEAM FOUND!\",   \"ALL\": \"ALL\",   \"Filter\": \"Filter\",   \"Filter_By_Price\": \"Filter By Price\",   \"Show_All\": \"Show All\",   \"Cart_is_empty\": \"Cart is empty\",   \"On_Table\": \"On Table\",   \"Home_Delivery\": \"Home Delivery\",   \"Select_a_postal_code\": \"Select a postal code\",   \"Select\": \"Select\",   \"Type\": \"Type\",   \"Item Total\": \"Item Total\",   \"No Menu Found!\": \"No Menu Found!\",   \"You are lost\": \"You are lost\",   \"Get Back to Home\": \"Get Back to Home\",   \"Addons\": \"Addons\",   \"Subcategory\": \"Subcategory\",   \"Review\": \"Review\",   \"Blog Details\": \"Blog Details\",   \"Career Details\": \"Career Details\",   \"Enter your card number\": \"Enter your card number\",   \"Enter expiry month\": \"Enter expiry month\",   \"Enter expiry year\": \"Enter expiry year\",   \"Enter card code\": \"Enter card code\",   \"Select a time frame\": \"Select a time frame\",   \"Select Addons\": \"Select Addons\",   \"Authorize\": \"Authorize\",   \"to leave a rating\": \"to leave a rating\",   \"Website\": \"Website\",   \"QR\": \"QR\",\"Pick_Up\": \"Pick Up\" ,\"Pick UP\": \"Pick UP\",\"Subtotal\":\"Subtotal\",\"Grand Total\":\"Grand Total\",\"Completed\":\"Completed\",\"Yes\":\"Yes\",\"No\":\"No\",\"Select a Time Frame\":\"Select a Time Frame\",\"Receipt image must be .jpg / .jpeg / .png\":\"Receipt image must be .jpg / .jpeg / .png\",\"Page Not Found\":\"Page Not Found\", \"January\": \"January\",   \"February\": \"February\",   \"March\": \"March\",   \"April\": \"April\",   \"May\": \"May\",   \"June\": \"June\",   \"July\": \"July\",   \"August\": \"August\",   \"September\": \"September\",   \"October\": \"October\",   \"November\": \"November\",   \"December\": \"December\",\"Monday\": \"Mo\",   \"Tuesday\": \"Tu\",   \"Wednesday\": \"We\",   \"Thursday\": \"Th\",   \"Friday\": \"Fr\",   \"Saturday\": \"Sa\",   \"Sunday\": \"Su\",\"Showing\":\"Showing\",\"to\":\"to\",\"of\":\"of\",\"entries\":\"entries\",\"Show\":\"Show\"}', 44, NULL, '2023-12-23 01:47:23', '2023-12-23 01:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_mail_templates`
--

CREATE TABLE `user_mail_templates` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `mail_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_mail_templates`
--

INSERT INTO `user_mail_templates` (`id`, `user_id`, `mail_type`, `mail_subject`, `mail_body`) VALUES
(81, 7, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(82, 7, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(83, 7, 'forget_password', 'Restore Password & Username', '<h4>Hello&nbsp;<span style=\'font-size: 14px;\'>{customer_name}</span>,</h4><div><p><strong>Your current username:</strong>&nbsp;{username}</p><p><strong>Your new password: </strong>{password}</p></div>'),
(84, 7, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(85, 7, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(86, 7, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(87, 7, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(88, 7, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(89, 7, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(90, 7, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(91, 7, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(92, 7, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(93, 7, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(94, 7, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(95, 7, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(96, 7, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(161, 13, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(162, 13, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(163, 13, 'forget_password', 'Restore Password & Username', '<h4>Hello&nbsp;<span style=\'font-size: 14px;\'>{customer_name}</span>,</h4><div><p><strong>Your current username:</strong>&nbsp;{username}</p><p><strong>Your new password: </strong>{password}</p></div>'),
(164, 13, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(165, 13, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(166, 13, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(167, 13, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(168, 13, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(169, 13, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(170, 13, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(171, 13, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(172, 13, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(173, 13, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(174, 13, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(175, 13, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(176, 13, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(177, 14, 'verify_email', 'Verify Your Email Address', '<p>Hi&nbsp;<strong>{customer_name}</strong>,</p>\r\n<p>We just need to verify your email address before you can access to your dashboard.</p>\r\n<p>Verify your email address, {verification_link}.</p>\r\n<p>Thank you.<br>{website_title}</p>'),
(178, 14, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p>\r\n<p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p>\r\n<p>{password_reset_link}</p>\r\n<p>Thanks,<br>{website_title}</p>'),
(180, 14, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(181, 14, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(182, 14, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(183, 14, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(184, 14, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(185, 14, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(186, 14, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(187, 14, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(188, 14, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p>\n<p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p>\n<p><br>{text}<br>{order_link}</p>\n<p>&nbsp;</p>\n<p>Best Regards,<br>{website_title}</p>'),
(189, 14, 'food_checkout', 'Order has been placed', '<p>Hello {customer_name},</p>\r\n<p>Your order has been placed successfully.</p>\r\n<p>Order Number: #{order_number}</p>\r\n<p>&nbsp;{text}</p>\r\n<p>&nbsp;{order_link}</p>\r\n<p>Best Regards,</p>\r\n<p>{website_title}</p>'),
(190, 14, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(191, 14, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(192, 14, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(224, 28, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(225, 28, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(226, 28, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(227, 28, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(228, 28, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(229, 28, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(230, 28, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(231, 28, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(232, 28, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(233, 28, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(234, 28, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(235, 28, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}.<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(236, 28, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(237, 28, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(238, 28, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}.<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(404, 40, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(405, 40, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(406, 40, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(407, 40, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(408, 40, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(409, 40, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(410, 40, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(411, 40, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(412, 40, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(413, 40, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(414, 40, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(415, 40, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(416, 40, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(417, 40, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(418, 40, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(419, 42, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(420, 42, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(421, 42, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(422, 42, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(423, 42, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(424, 42, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(425, 42, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(426, 42, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(427, 42, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(428, 42, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(429, 42, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(430, 42, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(431, 42, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(432, 42, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(433, 42, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(434, 43, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(435, 43, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(436, 43, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(437, 43, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(438, 43, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(439, 43, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(440, 43, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(441, 43, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(442, 43, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(443, 43, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(444, 43, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(445, 43, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(446, 43, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(447, 43, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(448, 43, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(449, 44, 'verify_email', 'Verify Your Email Address', '<p>Hi <b>{username}</b>,</p><p>We just need to verify your email address before you can access to your dashboard.</p><p>Verify your email address, {verification_link}.</p><p>Thank you.<br>{website_title}</p>'),
(450, 44, 'reset_password', 'Recover Password of Your Account', '<p>Hi {customer_name},</p><p>We have received a request to reset your password. If you did not make the request, just ignore this email. Otherwise, you can reset your password using this below link.</p><p>{password_reset_link}</p><p>Thanks,<br>{website_title}</p>'),
(451, 44, 'order_received', 'Order Received', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been received.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(452, 44, 'order_preparing', 'Preparing Your Order', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Chef has started preparing your ordered foods.<br>Order Number:&nbsp; #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(453, 44, 'order_ready_to_pickup', 'Your Order is Ready to Pickup', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(454, 44, 'order_pickup', 'Order has been picked up', '<p>Hello {customer_name},</p><p><br>Your order is picked up for delivery. It will arrive in a few moments.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(455, 44, 'order_pickedup_pick_up', 'You have picked up Ordered Food', '<p>Hello {customer_name},</p><p><br>You have picked up your ordered Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(456, 44, 'order_delivered', 'Order has been Delivered', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been delivered.<br>Order Number: #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>'),
(457, 44, 'order_cancelled', 'Order is Cancelled', '<p style=\'line-height: 1.6;\'>Hello&nbsp;<span style=\'font-weight: 600;\'>{customer_name}</span>,</p><p style=\'line-height: 1.6;\'><br>Your order has been canceled.<br>Order Number: {order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br><span style=\'font-weight: 600;\'>{website_title}</span></p>'),
(458, 44, 'order_ready_to_serve', 'Your order is ready to serve on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(459, 44, 'order_served', 'You order is served on table', '<p>Hello {customer_name},</p><p><br>Your order is served at your table. Enjoy your Food.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(460, 44, 'food_checkout', 'Order has been placed', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order has been placed successfully.<br>Order Number: #{order_number}</p><p><br>{text}<br>{order_link}</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(461, 44, 'reservation_accept', 'Reservation Request Accepted', '<p>Hello {customer_name},</p><p><br>Your reservation request has been accepted.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(462, 44, 'reservation_reject', 'Reservation Request Rejected', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your reservation request has been rejected.</p><p><br></p><p>Best Regards,<br>{website_title}</p>'),
(463, 44, 'order_ready_to_pickup_pick_up', 'Your order is ready to pick up', '<p style=\'line-height: 1.6;\'>Hello {customer_name},</p><p style=\'line-height: 1.6;\'><br>Your order is ready to pick up. Please pick up your order at your chosen date &amp; time.<br>Order Number:&nbsp; #{order_number}</p><p style=\'line-height: 1.6;\'><br>{text}<br>{order_link}</p><p style=\'line-height: 1.6;\'><br></p><p>Best Regards,<br>{website_title}</p>');

-- --------------------------------------------------------

--
-- Table structure for table `user_menus`
--

CREATE TABLE `user_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `language_id` int DEFAULT NULL,
  `menus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_menus`
--

INSERT INTO `user_menus` (`id`, `user_id`, `language_id`, `menus`, `created_at`, `updated_at`) VALUES
(11, 7, 10, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-09-10 02:40:30', '2023-09-10 02:40:30'),
(19, 13, 18, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-09-10 11:53:03', '2023-09-10 11:53:03'),
(24, 14, 21, '[{\"type\":\"home\",\"text\":\"بيت\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"menu\",\"text\":\"قائمة طعام\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"items\",\"text\":\"أغراض\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"cart\",\"text\":\"عربة التسوق\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"checkout\",\"text\":\"الدفع\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"career\",\"text\":\"حياة مهنية\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"team\",\"text\":\"أعضاء الفريق\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"gallery\",\"text\":\"صالة عرض\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"faq\",\"text\":\"التعليمات\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"blog\",\"text\":\"مدونة\",\"href\":\"\",\"target\":\"_self\"},{\"type\":\"contact\",\"text\":\"اتصال\",\"href\":\"\",\"target\":\"_self\"}]', '2023-09-28 11:41:19', '2023-09-28 11:41:19'),
(26, 28, 24, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-11-29 09:06:57', '2023-11-29 09:06:57'),
(28, 14, 19, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"text\":\"About\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"custom\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"},{\"type\":\"3\",\"text\":\"Cricket ,Asia Cup start 30 auguast and world cup will be later lorem impsum mate will be later lorem impsum mate will be later lorem impsum mate\",\"href\":\"\",\"target\":\"_self\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-04 21:07:34', '2023-12-04 21:07:34'),
(40, 40, 36, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-16 20:35:54', '2023-12-16 20:35:54'),
(41, 42, 37, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-18 17:22:26', '2023-12-18 17:22:26'),
(42, 43, 38, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-18 17:29:46', '2023-12-18 17:29:46'),
(43, 14, 39, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-20 15:00:33', '2023-12-20 15:00:33'),
(44, 14, 40, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-20 15:13:04', '2023-12-20 15:13:04'),
(45, 14, 41, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-20 15:30:48', '2023-12-20 15:30:48'),
(48, 14, 44, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-20 16:14:27', '2023-12-20 16:14:27'),
(55, 44, 51, '[{\"text\":\"Home\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"home\"},{\"text\":\"Menu\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"menu\"},{\"text\":\"Items\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"items\"},{\"text\":\"Cart\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"cart\"},{\"text\":\"Checkout\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"checkout\"},{\"type\":\"custom\",\"text\":\"About\",\"href\":\"\",\"target\":\"_self\",\"children\":[{\"text\":\"Career\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"career\"},{\"text\":\"Team Members\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"team\"},{\"text\":\"Gallery\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"gallery\"},{\"text\":\"FAQ\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"faq\"}]},{\"text\":\"Blog\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"blog\"},{\"text\":\"Contact\",\"href\":\"\",\"icon\":\"empty\",\"target\":\"_self\",\"title\":\"\",\"type\":\"contact\"}]', '2023-12-23 01:47:23', '2023-12-23 01:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_offline_gateways`
--

CREATE TABLE `user_offline_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `short_description` text,
  `instructions` blob,
  `status` tinyint NOT NULL DEFAULT '1',
  `serial_number` int NOT NULL DEFAULT '0',
  `is_receipt` tinyint NOT NULL DEFAULT '1',
  `receipt` varchar(100) DEFAULT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_offline_gateways`
--

INSERT INTO `user_offline_gateways` (`id`, `name`, `short_description`, `instructions`, `status`, `serial_number`, `is_receipt`, `receipt`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'cash', 'casg casg casg casg casg', 0x3c703e636173672063617367206361736720636173672063617367206361736720636173672063617367206361736720636173672063617367206361736720636173672063617367206361736720636173672063617367206361736720636173672063617367c2a03c2f703e, 1, 1, 1, NULL, 14, '2023-09-13 18:13:56', '2023-09-13 18:13:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_pages`
--

CREATE TABLE `user_pages` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_pages`
--

INSERT INTO `user_pages` (`id`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 7, 1, '2023-09-10 07:04:27', '2023-09-10 07:04:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_page_contents`
--

CREATE TABLE `user_page_contents` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `page_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` blob NOT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_page_contents`
--

INSERT INTO `user_page_contents` (`id`, `language_id`, `user_id`, `page_id`, `title`, `slug`, `content`, `meta_keywords`, `meta_description`, `created_at`, `updated_at`) VALUES
(3, 10, 7, 2, 'First Product', 'First-Product', 0x3c703e6173647364736473647364736473647364736473647364736473647364736473647364736473647364736473647364736473643c2f703e, NULL, NULL, '2023-09-10 07:04:28', '2023-09-10 07:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `user_page_headings`
--

CREATE TABLE `user_page_headings` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `menu_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_details_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cart_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career_details_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gallery_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reservation_page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blog_details_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `faq_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `forget_password_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_page_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_page_headings`
--

INSERT INTO `user_page_headings` (`id`, `language_id`, `user_id`, `menu_page_title`, `items_page_title`, `items_details_page_title`, `cart_page_title`, `checkout_page_title`, `career_page_title`, `career_details_title`, `gallery_page_title`, `error_page_title`, `team_page_title`, `reservation_page_title`, `blog_page_title`, `blog_details_page_title`, `contact_page_title`, `faq_page_title`, `forget_password_page_title`, `login_page_title`, `signup_page_title`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 'Menu Title', 'Items Title', 'Item Details Title', 'Cart Title', 'Checkout Title', 'Career Title', 'Career Details Title', 'Gallery Title', 'Error Page Title', 'Team Title', 'Reservation Title', 'Blog Title', 'Blog Details Title', 'Contact Title', 'FAQ Title', 'Forget Password Page Title', 'Login Title', 'Signup Title', '2023-12-26 22:54:03', '2023-12-29 17:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_gateways`
--

CREATE TABLE `user_payment_gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'manual',
  `information` mediumtext,
  `keyword` varchar(255) DEFAULT NULL,
  `user_id` int NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_payment_gateways`
--

INSERT INTO `user_payment_gateways` (`id`, `subtitle`, `title`, `details`, `name`, `type`, `information`, `keyword`, `user_id`, `status`) VALUES
(81, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 13, 1),
(82, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 13, 1),
(83, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 13, 1),
(84, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 13, 1),
(85, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 13, 1),
(86, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 13, 1),
(87, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 13, 1),
(88, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 13, 1),
(89, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 13, 1),
(90, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 13, 1),
(91, NULL, NULL, NULL, 'Flutterwave', 'automatic', '{\"public_key\":\"FLWPUBK_TEST-93972d50b7b24582a2050de2803799c0-X\",\"secret_key\":\"FLWSECK_TEST-3c9d39d4b16e9011bc4b9893f882f71e-X\",\"text\":\"Pay via your Flutterwave account.\"}', 'flutterwave', 14, 1),
(92, NULL, NULL, NULL, 'Razorpay', 'automatic', '{\"key\":\"rzp_test_fV9dM9URYbqjm7\",\"secret\":\"nickxZ1du2ojPYVVRTDif2Xr\",\"text\":\"Pay via your Razorpay account.\"}', 'razorpay', 14, 1),
(93, NULL, NULL, NULL, 'Paytm', 'automatic', '{\"environment\":\"local\",\"merchant\":\"tkogux49985047638244\",\"secret\":\"LhNGUUKE9xCQ9xY8\",\"website\":\"WEBSTAGING\",\"industry\":\"Retail\",\"text\":\"Pay via your Paytm account.\"}', 'paytm', 14, 1),
(94, NULL, NULL, NULL, 'Paystack', 'automatic', '{\"key\":\"sk_test_4ac9f2c43514e3cc08ab68f922201549ebda1bfd\",\"email\":null,\"text\":\"Pay via your Paystack account.\"}', 'paystack', 14, 1),
(95, NULL, NULL, NULL, 'Instamojo', 'automatic', '{\"key\":\"test_172371aa837ae5cad6047dc3052\",\"token\":\"test_4ac5a785e25fc596b67dbc5c267\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Instamojo account.\"}', 'instamojo', 14, 1),
(96, NULL, NULL, NULL, 'Stripe', 'automatic', '{\"key\":\"pk_test_UnU1Coi1p5qFGwtpjZMRMgJM\",\"secret\":\"sk_test_QQcg3vGsKRPlW6T3dXcNJsor\",\"text\":\"Pay via your Credit account.\"}', 'stripe', 14, 1),
(97, NULL, NULL, NULL, 'PayPal', 'automatic', '{\"client_id\":\"AVYKFEw63FtDt9aeYOe9biyifNI56s2Hc2F1Us11hWoY5GMuegipJRQBfWLiIKNbwQ5tmqKSrQTU3zB3\",\"sandbox_check\":\"1\",\"client_secret\":\"EJY0qOKliVg7wKsR3uPN7lngr9rL1N7q4WV0FulT1h4Fw3_e5Itv1mxSdbtSUwAaQoXQFgq-RLlk_sQu\",\"text\":\"Pay via your PayPal account.\"}', 'paypal', 14, 1),
(98, NULL, NULL, NULL, 'Mollie', 'automatic', '{\"key\":\"test_kKT2J9nRMHH9cN6acf2CTruN3t5CC6\",\"text\":\"Pay via your Mollie Payment account.\"}', 'mollie', 14, 1),
(99, NULL, NULL, NULL, 'Mercado Pago', 'automatic', '{\"token\":\"TEST-705032440135962-041006-ad2e021853f22338fe1a4db9f64d1491-421886156\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Mercado Pago account.\"}', 'mercadopago', 14, 1),
(100, NULL, NULL, NULL, 'Authorize.net', 'automatic', '{\"login_id\":\"3Ca5hYQ6h\",\"transaction_key\":\"8bt8Kr5gPZ3ZE23C\",\"public_key\":\"7m38JBnNjStNFq58BA6Wrr852ahtT533cGKavWwu6Fge28RDc5wC7wTL8Vsb35B3\",\"sandbox_check\":\"1\",\"text\":\"Pay via your Authorize.net account.\"}', 'authorize.net', 14, 1),
(121, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 28, 1),
(122, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 28, 1),
(123, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 28, 1),
(124, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 28, 1),
(125, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 28, 1),
(126, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 28, 1),
(127, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 28, 1),
(128, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 28, 1),
(129, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 28, 1),
(130, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 28, 1),
(241, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 40, 1),
(242, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 40, 1),
(243, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 40, 1),
(244, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 40, 1),
(245, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 40, 1),
(246, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 40, 1),
(247, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 40, 1),
(248, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 40, 1),
(249, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 40, 1),
(250, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 40, 1),
(251, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 42, 1),
(252, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 42, 1),
(253, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 42, 1),
(254, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 42, 1),
(255, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 42, 1),
(256, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 42, 1),
(257, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 42, 1),
(258, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 42, 1),
(259, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 42, 1),
(260, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 42, 1),
(261, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 43, 1),
(262, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 43, 1),
(263, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 43, 1),
(264, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 43, 1),
(265, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 43, 1),
(266, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 43, 1),
(267, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 43, 1),
(268, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 43, 1),
(269, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 43, 1),
(270, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 43, 1),
(271, NULL, NULL, NULL, 'Flutterwave', 'automatic', NULL, 'flutterwave', 44, 1),
(272, NULL, NULL, NULL, 'Razorpay', 'automatic', NULL, 'razorpay', 44, 1),
(273, NULL, NULL, NULL, 'Paytm', 'automatic', NULL, 'paytm', 44, 1),
(274, NULL, NULL, NULL, 'Paystack', 'automatic', NULL, 'paystack', 44, 1),
(275, NULL, NULL, NULL, 'Instamojo', 'automatic', NULL, 'instamojo', 44, 1),
(276, NULL, NULL, NULL, 'Stripe', 'automatic', NULL, 'stripe', 44, 1),
(277, NULL, NULL, NULL, 'Paypal', 'automatic', NULL, 'paypal', 44, 1),
(278, NULL, NULL, NULL, 'Mollie', 'automatic', NULL, 'mollie', 44, 1),
(279, NULL, NULL, NULL, 'Mercadopago', 'automatic', NULL, 'mercadopago', 44, 1),
(280, NULL, NULL, NULL, 'Authorize.net', 'automatic', NULL, 'authorize.net', 44, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `package_id` int NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `package_id`, `user_id`, `permissions`, `created_at`, `updated_at`) VALUES
(6, 40, 7, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"Contact\"]', '2023-09-10 02:40:30', '2023-09-10 02:40:30'),
(11, 41, 13, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"Contact\"]', '2023-09-10 11:53:03', '2023-09-10 11:53:03'),
(12, 40, 14, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"Contact\"]', '2023-09-10 15:39:02', '2023-12-26 03:18:22'),
(15, 41, 28, '[\"POS\",\"Coupon\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\",\"Contact\"]', '2023-11-29 09:06:57', '2023-11-29 09:06:57'),
(27, 39, 40, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\",\"Contact\"]', '2023-12-16 20:35:54', '2023-12-16 20:35:54'),
(28, 39, 42, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\",\"Contact\"]', '2023-12-18 17:22:26', '2023-12-18 17:22:26'),
(29, 40, 43, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Storage Limit\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Table QR Builder\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"Contact\"]', '2023-12-18 17:29:46', '2023-12-18 17:29:46'),
(30, 39, 44, '[\"Custom Domain\",\"Subdomain\",\"POS\",\"Coupon\",\"Amazon AWS s3\",\"Live Orders\",\"Whatsapp Order & Notification\",\"QR Menu\",\"Table Reservation\",\"Call Waiter\",\"Staffs\",\"Blog\",\"Custom Page\",\"Online Order\",\"On Table\",\"Pick Up\",\"Home Delivery\",\"Postal Code Based Delivery Charge\",\"PWA Installability\",\"Contact\"]', '2023-12-23 01:47:23', '2023-12-23 01:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `user_popups`
--

CREATE TABLE `user_popups` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `type` smallint UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `background_color_opacity` decimal(3,2) UNSIGNED DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `text` text,
  `button_text` varchar(255) DEFAULT NULL,
  `button_color` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `delay` int UNSIGNED NOT NULL COMMENT 'value will be in milliseconds',
  `serial_number` mediumint UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '0 => deactive, 1 => active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_popups`
--

INSERT INTO `user_popups` (`id`, `language_id`, `user_id`, `type`, `image`, `name`, `background_color`, `background_color_opacity`, `title`, `text`, `button_text`, `button_color`, `button_url`, `end_date`, `end_time`, `delay`, `serial_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 2, '2be0b33f9f1344912ea79b1b4f4e40b9d258db3f.jpg', 'JPMorgan Chase & Co.', '9975FF', 0.50, 'fgdfgd', 'dfgdfgd', 'dfgdfg', '5E42FF', 'https://www.youtube.com/', NULL, NULL, 2000, 1, 0, '2023-12-12 15:52:38', '2023-12-19 15:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(2, 7, 'Manager', NULL, '2023-09-10 03:22:53', '2023-09-10 10:12:13'),
(3, 7, 'Editor', NULL, '2023-09-10 03:23:00', '2023-09-10 03:23:00'),
(4, 14, 'editor', '[\"Order Management\",\"Items Management\",\"QR Code Builder\",\"Custom Pages\",\"Tables & QR Builder\",\"Drag & Drop Menu Builder\",\"Blog Management\",\"Language Management\",\"Payment Gateways\",\"Website Pages\",\"Settings\",\"Push Notification\",\"Subscribers\",\"Announcement Popups\",\"Customers\",\"Sitemap\"]', '2023-09-11 15:04:23', '2024-01-03 18:37:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_seos`
--

CREATE TABLE `user_seos` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `language_id` int DEFAULT NULL,
  `home_meta_keywords` varchar(255) DEFAULT NULL,
  `home_meta_description` text,
  `career_meta_keywords` varchar(255) DEFAULT NULL,
  `career_meta_description` text,
  `blogs_meta_keywords` varchar(255) DEFAULT NULL,
  `blogs_meta_description` text,
  `gallery_meta_keywords` varchar(255) DEFAULT NULL,
  `gallery_meta_description` text,
  `login_meta_keywords` varchar(255) DEFAULT NULL,
  `login_meta_description` text,
  `sign_up_meta_keywords` varchar(255) DEFAULT NULL,
  `sign_up_meta_description` text,
  `faqs_meta_description` text,
  `faqs_meta_keywords` varchar(255) DEFAULT NULL,
  `contact_meta_description` text,
  `contact_meta_keywords` varchar(255) DEFAULT NULL,
  `forget_password_meta_description` text,
  `forget_password_meta_keywords` varchar(255) DEFAULT NULL,
  `reservation_meta_keywords` varchar(255) DEFAULT NULL,
  `reservation_meta_description` text,
  `team_meta_keywords` varchar(255) DEFAULT NULL,
  `team_meta_description` text,
  `product_meta_keywords` varchar(255) DEFAULT NULL,
  `product_meta_description` text,
  `checkout_meta_keywords` varchar(255) DEFAULT NULL,
  `checkout_meta_description` text,
  `cart_meta_keywords` varchar(255) DEFAULT NULL,
  `cart_meta_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user_seos`
--

INSERT INTO `user_seos` (`id`, `user_id`, `language_id`, `home_meta_keywords`, `home_meta_description`, `career_meta_keywords`, `career_meta_description`, `blogs_meta_keywords`, `blogs_meta_description`, `gallery_meta_keywords`, `gallery_meta_description`, `login_meta_keywords`, `login_meta_description`, `sign_up_meta_keywords`, `sign_up_meta_description`, `faqs_meta_description`, `faqs_meta_keywords`, `contact_meta_description`, `contact_meta_keywords`, `forget_password_meta_description`, `forget_password_meta_keywords`, `reservation_meta_keywords`, `reservation_meta_description`, `team_meta_keywords`, `team_meta_description`, `product_meta_keywords`, `product_meta_description`, `checkout_meta_keywords`, `checkout_meta_description`, `cart_meta_keywords`, `cart_meta_description`) VALUES
(2, 2, 4, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(6, 7, 10, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(11, 13, 18, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(12, 14, 19, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(15, 28, 24, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(24, 37, 33, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(26, 39, 35, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(27, 40, 36, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(28, 42, 37, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(29, 43, 38, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description'),
(30, 44, 51, 'home_meta_keywords', 'home_meta_description', 'career_meta_keywords', 'career_meta_description', 'blogs_meta_keywords', 'blogs_meta_description', 'gallery_meta_keywords', 'gallery_meta_description', 'login_meta_keywords', 'login_meta_description', 'sign_up_meta_keywords', 'sign_up_meta_description', 'faqs_meta_description', 'faqs_meta_keywords', 'contact_meta_description', 'contact_meta_keywords', 'forget_password_meta_description', 'forget_password_meta_keywords', 'reservation_meta_keywords', 'reservation_meta_description', 'team_meta_keywords', 'team_meta_description', 'product_meta_keywords', 'product_meta_description', 'checkout_meta_keywords', 'checkout_meta_description', 'cart_meta_keywords', 'cart_meta_description');

-- --------------------------------------------------------

--
-- Table structure for table `user_sitemaps`
--

CREATE TABLE `user_sitemaps` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sitemap_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_sitemaps`
--

INSERT INTO `user_sitemaps` (`id`, `user_id`, `sitemap_url`, `filename`, `created_at`, `updated_at`) VALUES
(8, 14, 'https://businesso.xyz/', 'sitemap658accf67b191.xml', '2023-12-25 23:56:24', '2023-12-25 23:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `user_social_links`
--

CREATE TABLE `user_social_links` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial_number` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_subscribers`
--

CREATE TABLE `user_subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_testimonials`
--

CREATE TABLE `user_testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `serial_number` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_ulinks`
--

CREATE TABLE `user_ulinks` (
  `id` bigint UNSIGNED NOT NULL,
  `language_id` int NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_ulinks`
--

INSERT INTO `user_ulinks` (`id`, `language_id`, `user_id`, `name`, `url`, `created_at`, `updated_at`) VALUES
(1, 19, 14, 'Cricket', 'https://www.youtube.com/', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_extendeds`
--
ALTER TABLE `basic_extendeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basic_settings`
--
ALTER TABLE `basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bcategories`
--
ALTER TABLE `bcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bottomlinks`
--
ALTER TABLE `bottomlinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guests_endpoint_unique` (`endpoint`);

--
-- Indexes for table `jcategories`
--
ALTER TABLE `jcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `memberships_user_id_foreign` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_gateways`
--
ALTER TABLE `offline_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_times`
--
ALTER TABLE `order_times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcategories`
--
ALTER TABLE `pcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `popups_language_id_foreign` (`language_id`);

--
-- Indexes for table `postal_codes`
--
ALTER TABLE `postal_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_payment_methods`
--
ALTER TABLE `pos_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_informations`
--
ALTER TABLE `product_informations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_orders`
--
ALTER TABLE `product_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psub_categories`
--
ALTER TABLE `psub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `push_subscriptions_endpoint_unique` (`endpoint`);

--
-- Indexes for table `reservation_inputs`
--
ALTER TABLE `reservation_inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation_input_options`
--
ALTER TABLE `reservation_input_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seos`
--
ALTER TABLE `seos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `serving_methods`
--
ALTER TABLE `serving_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sitemaps`
--
ALTER TABLE `sitemaps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_books`
--
ALTER TABLE `table_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`country_code`,`timezone`);

--
-- Indexes for table `time_frames`
--
ALTER TABLE `time_frames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ulinks`
--
ALTER TABLE `ulinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_basic_extendeds`
--
ALTER TABLE `user_basic_extendeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_basic_extras`
--
ALTER TABLE `user_basic_extras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_basic_settings`
--
ALTER TABLE `user_basic_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_blogs`
--
ALTER TABLE `user_blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_blog_categories`
--
ALTER TABLE `user_blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_categories_language_id_foreign` (`language_id`);

--
-- Indexes for table `user_blog_informations`
--
ALTER TABLE `user_blog_informations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blog_informations_language_id_foreign` (`language_id`),
  ADD KEY `blog_informations_blog_category_id_foreign` (`blog_category_id`),
  ADD KEY `blog_informations_blog_id_foreign` (`blog_id`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_custom_domains`
--
ALTER TABLE `user_custom_domains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_faqs`
--
ALTER TABLE `user_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_features`
--
ALTER TABLE `user_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_languages`
--
ALTER TABLE `user_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_mail_templates`
--
ALTER TABLE `user_mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menus`
--
ALTER TABLE `user_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_offline_gateways`
--
ALTER TABLE `user_offline_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pages`
--
ALTER TABLE `user_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_page_contents`
--
ALTER TABLE `user_page_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_contents_language_id_foreign` (`language_id`),
  ADD KEY `page_contents_page_id_foreign` (`page_id`);

--
-- Indexes for table `user_page_headings`
--
ALTER TABLE `user_page_headings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `page_headings_language_id_foreign` (`language_id`);

--
-- Indexes for table `user_payment_gateways`
--
ALTER TABLE `user_payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permissions_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_popups`
--
ALTER TABLE `user_popups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `popups_language_id_foreign` (`language_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_seos`
--
ALTER TABLE `user_seos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sitemaps`
--
ALTER TABLE `user_sitemaps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_social_links`
--
ALTER TABLE `user_social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_subscribers`
--
ALTER TABLE `user_subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_testimonials`
--
ALTER TABLE `user_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_ulinks`
--
ALTER TABLE `user_ulinks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `basic_extendeds`
--
ALTER TABLE `basic_extendeds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `basic_settings`
--
ALTER TABLE `basic_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `bcategories`
--
ALTER TABLE `bcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `bottomlinks`
--
ALTER TABLE `bottomlinks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jcategories`
--
ALTER TABLE `jcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `offline_gateways`
--
ALTER TABLE `offline_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `order_times`
--
ALTER TABLE `order_times`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=393;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pcategories`
--
ALTER TABLE `pcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `postal_codes`
--
ALTER TABLE `postal_codes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pos_payment_methods`
--
ALTER TABLE `pos_payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `product_informations`
--
ALTER TABLE `product_informations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `product_orders`
--
ALTER TABLE `product_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `psub_categories`
--
ALTER TABLE `psub_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `push_subscriptions`
--
ALTER TABLE `push_subscriptions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation_inputs`
--
ALTER TABLE `reservation_inputs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservation_input_options`
--
ALTER TABLE `reservation_input_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seos`
--
ALTER TABLE `seos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `serving_methods`
--
ALTER TABLE `serving_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `shipping_charges`
--
ALTER TABLE `shipping_charges`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sitemaps`
--
ALTER TABLE `sitemaps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table_books`
--
ALTER TABLE `table_books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `time_frames`
--
ALTER TABLE `time_frames`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ulinks`
--
ALTER TABLE `ulinks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user_basic_extendeds`
--
ALTER TABLE `user_basic_extendeds`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user_basic_extras`
--
ALTER TABLE `user_basic_extras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_basic_settings`
--
ALTER TABLE `user_basic_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `user_blogs`
--
ALTER TABLE `user_blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_blog_categories`
--
ALTER TABLE `user_blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_blog_informations`
--
ALTER TABLE `user_blog_informations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_custom_domains`
--
ALTER TABLE `user_custom_domains`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_faqs`
--
ALTER TABLE `user_faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_features`
--
ALTER TABLE `user_features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_languages`
--
ALTER TABLE `user_languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `user_mail_templates`
--
ALTER TABLE `user_mail_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `user_menus`
--
ALTER TABLE `user_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `user_offline_gateways`
--
ALTER TABLE `user_offline_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_pages`
--
ALTER TABLE `user_pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_page_contents`
--
ALTER TABLE `user_page_contents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_page_headings`
--
ALTER TABLE `user_page_headings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_payment_gateways`
--
ALTER TABLE `user_payment_gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_popups`
--
ALTER TABLE `user_popups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_seos`
--
ALTER TABLE `user_seos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_sitemaps`
--
ALTER TABLE `user_sitemaps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_social_links`
--
ALTER TABLE `user_social_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_subscribers`
--
ALTER TABLE `user_subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_testimonials`
--
ALTER TABLE `user_testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_ulinks`
--
ALTER TABLE `user_ulinks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `popups`
--
ALTER TABLE `popups`
  ADD CONSTRAINT `popups_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

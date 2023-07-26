<?php
ignore_user_abort(1);

$sql = "ALTER TABLE `".$config['db']['pre']."transaction` CHANGE `transaction_ip` `transaction_ip` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL";
if (!mysqli_query($mysqli,$sql)) {
    echo("Error description: " . mysqli_error($mysqli));
}

if ($config['version'] < "2.3") {

    $sql = "ALTER TABLE `".$config['db']['pre']."transaction` CHANGE `seller_id` `user_id` INT(11) NULL DEFAULT NULL";
    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "TRUNCATE TABLE `".$config['db']['pre']."messages`";
    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "ALTER TABLE `".$config['db']['pre']."messages` ADD `post_type` VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'project' AFTER `post_id`";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "ALTER TABLE `".$config['db']['pre']."reviews` ADD `order_id` int(11) NULL DEFAULT NULL AFTER `post_type`";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "ALTER TABLE `".$config['db']['pre']."transaction` ADD `details` TEXT NULL DEFAULT NULL AFTER `taxes_ids`";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }
}
if ($config['version'] < "2.1") {

    $sql = "TRUNCATE TABLE `".$config['db']['pre']."catagory_main`";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "INSERT INTO `".$config['db']['pre']."catagory_main` (`cat_id`, `cat_order`, `post_type`, `cat_name`, `slug`, `icon`, `picture`) VALUES
(1, 0, 'default', 'Websites, IT & Software', 'website-it-software', 'icon-line-awesome-file-code-o', ''),
(2, 1, 'default', 'Writing & Content', 'writing-content', 'icon-line-awesome-pencil', ''),
(3, 2, 'default', 'Design, Media & Architecture', 'design', 'icon-line-awesome-image', ''),
(4, 3, 'default', 'Mobile Phones & Computing', 'mobile-phone', 'icon-line-awesome-mobile', ''),
(5, 4, 'default', 'Engineering , Manufacturing & Science', 'engineering-science', 'icon-line-awesome-cloud-upload', ''),
(6, 5, 'default', 'Business, Accounting & Legal', 'business-account-legal', 'icon-line-awesome-suitcase', ''),
(7, 6, 'default', 'Sales & Marketing', 'sales-marketing', 'icon-line-awesome-pie-chart', ''),
(8, 7, 'default', 'Data Entry & Admin', 'data-entry', 'icon-feather-file-text', ''),
(9, 8, 'default', 'Other', 'other', 'icon-line-awesome-file-code-o', ''),
(12, 0, 'gig', 'Graphics &amp; Design', 'graphics-design', 'icon-line-awesome-image', ''),
(13, 1, 'gig', 'Digital Marketing', 'digital-marketing', 'icon-feather-trending-up', ''),
(14, 2, 'gig', 'Writing &amp; Translation', 'writing-translation', 'icon-line-awesome-pencil', ''),
(15, 3, 'gig', 'Video &amp; Animation', 'video-animation', 'icon-feather-video', ''),
(16, 4, 'gig', 'Music &amp; Audio', 'music-amp-audio', 'icon-feather-music', ''),
(17, 5, 'gig', 'Programming &amp; Tech', 'programming-amp-tech', 'icon-line-awesome-file-code-o', ''),
(18, 6, 'gig', 'Data', 'data-1', 'icon-feather-file-text', ''),
(19, 7, 'gig', 'Business', 'business-1', 'icon-line-awesome-suitcase', ''),
(20, 8, 'gig', 'Lifestyle', 'lifestyle', 'icon-feather-grid', '')";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "TRUNCATE TABLE `".$config['db']['pre']."catagory_sub`";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "INSERT INTO `".$config['db']['pre']."catagory_sub` (`sub_cat_id`, `main_cat_id`, `post_type`, `sub_cat_name`, `slug`, `cat_order`, `photo_show`, `price_show`, `picture`) VALUES
(1, 1, 'default', '.NET', 'net', 1, '1', '1', NULL),
(2, 1, 'default', 'AJAX', 'ajax', 2, '1', '1', NULL),
(3, 1, 'default', 'Android', 'android', 3, '1', '1', NULL),
(4, 1, 'default', 'Codeigniter', 'codeigniter', 4, '1', '1', NULL),
(5, 1, 'default', 'CSS', 'css', 5, '1', '1', NULL),
(6, 1, 'default', 'Database Administration', 'database-administration', 6, '1', '1', NULL),
(7, 1, 'default', 'Ecommerce', 'ecommerce', 7, '1', '1', NULL),
(8, 1, 'default', 'Game Development', 'game-development', 8, '1', '1', NULL),
(9, 1, 'default', 'HTML', 'html', 9, '1', '1', NULL),
(10, 1, 'default', 'IOS', 'ios', 10, '1', '1', NULL),
(11, 1, 'default', 'Javascript', 'javascript', 11, '1', '1', NULL),
(12, 1, 'default', 'jQuery / Prototype', 'jquery-prototype', 12, '1', '1', NULL),
(13, 1, 'default', 'MySQL', 'mysql', 13, '1', '1', NULL),
(14, 1, 'default', 'Node.js', 'nodejs', 14, '1', '1', NULL),
(15, 1, 'default', 'PHP', 'php', 15, '1', '1', NULL),
(16, 1, 'default', 'SEO', 'seo', 16, '1', '1', NULL),
(17, 2, 'default', 'Article Writing', 'article-writing', 17, '1', '1', NULL),
(18, 2, 'default', 'Blog Writing', 'blog-writing', 18, '1', '1', NULL),
(19, 2, 'default', 'Book Writing', 'book-writing', 19, '1', '1', NULL),
(20, 2, 'default', 'Content Writing', 'content-writing', 20, '1', '1', NULL),
(21, 2, 'default', 'Legal Writing', 'legal-writing', 21, '1', '1', NULL),
(22, 2, 'default', 'Translation', 'translation', 22, '1', '1', NULL),
(23, 3, 'default', 'Architecture Design', 'architecture-design', 23, '1', '1', NULL),
(24, 3, 'default', 'App Design', 'app-design', 24, '1', '1', NULL),
(25, 3, 'default', 'Adobe Photoshop', 'adobe-photoshop', 25, '0', '0', ''),
(26, 3, 'default', 'Banner Design', 'banner-design', 26, '1', '1', NULL),
(27, 3, 'default', 'Graphics Design', 'graphics-design', 27, '1', '1', NULL),
(28, 3, 'default', 'Logo Design', 'logo-design', 28, '0', '0', ''),
(29, 3, 'default', 'Product Design', 'product-design', 29, '1', '1', NULL),
(30, 3, 'default', 'Web Design', 'web-design', 30, '1', '1', NULL),
(31, 4, 'default', 'Android', 'android-1', 31, '1', '1', NULL),
(32, 4, 'default', 'iPhone', 'iphone', 32, '1', '1', NULL),
(33, 4, 'default', 'Mobile App Development', 'mobile-app-development', 33, '1', '1', NULL),
(34, 5, 'default', 'AutoCAD', 'autocad', 34, '1', '1', NULL),
(35, 5, 'default', 'Circuit Design', 'circuit-design', 35, '1', '1', NULL),
(36, 5, 'default', 'Data Mining', 'data-mining', 36, '1', '1', NULL),
(37, 5, 'default', 'Electrical Engineering', 'electrical-engineering', 37, '1', '1', NULL),
(38, 5, 'default', 'Engineering', 'engineering', 38, '1', '1', NULL),
(39, 5, 'default', 'Mechanical Engineering', 'mechanical-engineering', 39, '1', '1', NULL),
(40, 6, 'default', 'Accounting', 'accounting', 40, '1', '1', NULL),
(41, 6, 'default', 'Consulting', 'consulting', 41, '1', '1', NULL),
(42, 6, 'default', 'Legal', 'legal-1', 42, '1', '1', NULL),
(43, 6, 'default', 'Tax Advisory', 'tax-advisory', 43, '1', '1', NULL),
(44, 7, 'default', 'Advertising', 'advertising', 44, '1', '1', NULL),
(45, 7, 'default', 'Affiliate Marketing', 'affiliate-marketing', 45, '1', '1', NULL),
(46, 7, 'default', 'Branding', 'branding', 46, '1', '1', NULL),
(47, 7, 'default', 'Email Marketing', 'email-marketing', 47, '1', '1', NULL),
(48, 7, 'default', 'Google Adsense', 'google-adsense', 48, '1', '1', NULL),
(49, 7, 'default', 'Search Engine Marketing', 'search-engine-marketing', 49, '1', '1', NULL),
(50, 7, 'default', 'Social Media Marketing', 'social-media-marketing', 50, '1', '1', NULL),
(51, 8, 'default', 'Article Submission', 'article-submission', 51, '1', '1', NULL),
(52, 8, 'default', 'Call Center', 'call-center', 52, '1', '1', NULL),
(53, 8, 'default', 'Customer Service', 'customer-service', 53, '1', '1', NULL),
(54, 8, 'default', 'Data Entry', 'data-entry', 54, '1', '1', NULL),
(55, 8, 'default', 'Excel', 'excel', 55, '1', '1', NULL),
(56, 8, 'default', 'Email Handling', 'email-handling', 56, '1', '1', NULL),
(57, 9, 'default', 'Business Coaching', 'business-coaching', 57, '1', '1', NULL),
(58, 9, 'default', 'Cooking & Recipes', 'cooking-recipes', 58, '1', '1', NULL),
(59, 9, 'default', 'Education & Tutoring', 'education-tutoring', 59, '1', '1', NULL),
(60, 9, 'default', 'Real Estate', 'real-estate', 60, '1', '1', NULL),
(61, 9, 'default', 'Testing / QA', 'testing-qa', 61, '1', '1', NULL),
(62, 9, 'default', 'Event', 'event', 62, '1', '1', NULL),
(63, 9, 'default', 'Health & Medical', 'health-medical', 63, '0', '0', ''),
(64, 9, 'default', 'Trades & Services', 'trades-services', 64, '1', '1', NULL),
(65, 9, 'default', 'Jobs for Anyone', 'jobs-anyone', 65, '1', '1', NULL),
(66, 12, 'gig', 'Logo Design', 'logo-design-1', 66, '1', '1', NULL),
(67, 12, 'gig', 'Brand Style Guides', 'brand-style-guides', 67, '1', '1', NULL),
(68, 12, 'gig', 'Game Art', 'game-art', 68, '1', '1', NULL),
(69, 12, 'gig', 'Graphics for Streamers', 'graphics-streamers', 69, '1', '1', NULL),
(70, 12, 'gig', 'Business Cards &amp; Stationery', 'business-cards-amp-stationery', 70, '1', '1', NULL),
(71, 12, 'gig', 'Website Design', 'website-design', 71, '1', '1', NULL),
(72, 12, 'gig', 'App Design', 'app-design-1', 72, '1', '1', NULL),
(73, 12, 'gig', 'UX Design', 'ux-design', 73, '1', '1', NULL),
(74, 12, 'gig', 'Landing Page Design', 'landing-page-design', 74, '1', '1', NULL),
(75, 13, 'gig', 'Social Media', 'social-media', 75, '0', '0', ''),
(76, 13, 'gig', 'Search Engine Optimization (SEO)', 'search-engine-optimization-seo', 76, '1', '1', NULL),
(77, 13, 'gig', 'Content Marketing', 'content-marketing', 77, '1', '1', NULL),
(78, 13, 'gig', 'Book &amp; eBook Marketing', 'book-amp-ebook-marketing', 78, '1', '1', NULL),
(79, 13, 'gig', 'Affiliate Marketing', 'affiliate-marketing-1', 79, '1', '1', NULL),
(80, 13, 'gig', 'Other', 'other', 80, '1', '1', NULL),
(81, 14, 'gig', 'Articles &amp; Blog Posts', 'articles-amp-blog-posts', 81, '1', '1', NULL),
(82, 14, 'gig', 'Translation', 'translation-1', 82, '1', '1', NULL),
(83, 14, 'gig', 'Website Content', 'website-content', 83, '1', '1', NULL),
(84, 15, 'gig', 'Video Editing', 'video-editing', 84, '1', '1', NULL),
(85, 15, 'gig', 'Logo Animation', 'logo-animation', 85, '1', '1', NULL),
(86, 15, 'gig', '3D Animation', '3d-animation', 86, '1', '1', NULL),
(87, 16, 'gig', 'Voice Over', 'voice-over', 87, '1', '1', NULL),
(88, 16, 'gig', 'Mixing &amp; Mastering', 'mixing-amp-mastering', 88, '1', '1', NULL),
(89, 16, 'gig', 'Sound Design', 'sound-design', 89, '1', '1', NULL),
(90, 16, 'gig', 'Audio Editing', 'audio-editing', 90, '1', '1', NULL),
(91, 17, 'gig', 'WordPress', 'wordpress', 91, '1', '1', NULL),
(92, 17, 'gig', 'Game Development', 'game-development-1', 92, '1', '1', NULL),
(93, 17, 'gig', 'Web Programming', 'web-programming', 93, '1', '1', NULL),
(94, 17, 'gig', 'Mobile Apps', 'mobile-apps', 94, '1', '1', NULL),
(95, 18, 'gig', 'Databases', 'databases', 95, '1', '1', NULL),
(96, 18, 'gig', 'Data Processing', 'data-processing', 96, '1', '1', NULL),
(97, 18, 'gig', 'Data Engineering', 'data-engineering', 97, '1', '1', NULL),
(98, 18, 'gig', 'Data Analytics', 'data-analytics', 98, '1', '1', NULL),
(99, 18, 'gig', 'Data Entry', 'data-entry-1', 99, '1', '1', NULL),
(100, 19, 'gig', 'CRM Management', 'crm-management', 100, '1', '1', NULL),
(101, 19, 'gig', 'Sales', 'sales', 101, '1', '1', NULL),
(102, 19, 'gig', 'Customer Care', 'customer-care', 102, '1', '1', NULL),
(103, 19, 'gig', 'HR Consulting', 'hr-consulting', 103, '1', '1', NULL),
(104, 20, 'gig', 'Gaming', 'gaming', 104, '1', '1', NULL),
(105, 20, 'gig', 'Online Tutoring', 'online-tutoring', 105, '1', '1', NULL),
(106, 20, 'gig', 'Life Coaching', 'life-coaching', 106, '1', '1', NULL),
(107, 20, 'gig', 'Astrology &amp; Psychics', 'astrology-amp-psychics', 107, '1', '1', NULL),
(108, 20, 'gig', 'Modeling &amp; Acting', 'modeling-amp-acting', 108, '1', '1', NULL),
(109, 20, 'gig', 'Fitness Lessons', 'fitness-lessons', 109, '1', '1', NULL)";

    if (!mysqli_query($mysqli,$sql)) {
        echo("Error description: " . mysqli_error($mysqli));
    }

    $sql = "CREATE TABLE IF NOT EXISTS `" . $config['db']['pre'] . "orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('progress','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'progress',
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `plan_id` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` double(9,2) DEFAULT NULL,
  `purchase_code` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancel_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    mysqli_query($mysqli, $sql);
}
if ($config['version'] < "2.0") {


    $sql = "CREATE TABLE IF NOT EXISTS `".$config['db']['pre']."post` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `sub_category` int(11) DEFAULT NULL,
  `price` double(9,2) DEFAULT NULL,
  `tag` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($mysqli,$sql);


    $sql = "CREATE TABLE IF NOT EXISTS `".$config['db']['pre']."post_options` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    mysqli_query($mysqli,$sql);


    $sql = "ALTER TABLE `".$config['db']['pre']."catagory_main` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' ";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."catagory_sub` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' ";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."custom_fields` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' AFTER `custom_order`";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."custom_data` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' AFTER `product_id`";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."favads` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `product_id`";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."transaction` CHANGE `seller_id` `user_id` INT(11) NULL DEFAULT NULL";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."reviews` ADD `post_type` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default' AFTER `project_id`";
    mysqli_query($mysqli,$sql);
    $sql = "ALTER TABLE `".$config['db']['pre']."reviews` CHANGE `created_at` `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP";
    mysqli_query($mysqli,$sql);
}
?>
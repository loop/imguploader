SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


--
-- Database: `imguploader`
--

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE IF NOT EXISTS `api_keys` (
  `id` int(11) NOT NULL auto_increment,
  `api_key` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `api_keys`
--


-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_last_login` int(11) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_signup` int(11) NOT NULL,
  `premium` int(1) NOT NULL default '0',
  `premium_active` int(1) NOT NULL default '0',
  `premium_start` int(11) NOT NULL,
  `premium_end` int(11) NOT NULL,
  `is_admin` int(1) NOT NULL default '0',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`user_id`, `user_name`, `user_email`, `user_password`, `user_last_login`, `user_ip`, `user_signup`, `premium`, `premium_active`, `premium_start`, `premium_end`, `is_admin`) VALUES
(1, 'admin', 'admin@example.com', 'f865b53623b121fd34ee5426c792e5c33af8c227', 1270446154, '192.168.1.1', 1266190351, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `site_logs`
--

CREATE TABLE IF NOT EXISTS `site_logs` (
  `id` int(11) NOT NULL auto_increment,
  `action` varchar(100) NOT NULL,
  `action_text` text NOT NULL,
  `action_date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL auto_increment,
  `file_id` varchar(100) NOT NULL,
  `delete_id` varchar(100) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  `file_size` int(11) NOT NULL,
  `uploader_ip` varchar(25) NOT NULL,
  `upload_date` varchar(100) NOT NULL,
  `views` int(11) NOT NULL,
  `upload_owner` int(11) NOT NULL,
  `last_access` int(11) NOT NULL default '0',
  `folder_id` varchar(100) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `uploads`
--


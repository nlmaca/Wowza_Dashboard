/* page version: 1.0 */
/* user table for login procedure:  */

CREATE TABLE IF NOT EXISTS `wow_users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` CHAR(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` CHAR(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

/* wowza table for vhost (will be filled by scripts) */
CREATE TABLE IF NOT EXISTS wow_vhost_status ( 
data_id INT auto_increment, 
session_time datetime NOT NULL, 
vhost_name VARCHAR(100) NOT NULL, 
vhost_timerunning VARCHAR(100) NOT NULL, 
vhost_conn_limit INT NOT NULL, 
vhost_conn_current INT NOT NULL,
vhost_conn_total INT NOT NULL,
vhost_conn_accepted INT NOT NULL,
vhost_conn_rejected INT NOT NULL,
vhost_bytes_in VARCHAR(100) NOT NULL,
vhost_bytes_out VARCHAR(100) NOT NULL,
PRIMARY KEY(data_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* wowza table for application level (will be filled by scripts) */
CREATE TABLE IF NOT EXISTS wow_app_status ( 
data_id INT auto_increment, 
session_time datetime NOT NULL, 
app_name VARCHAR(100) NOT NULL, 
app_online INT NOT NULL, 
app_stream_name VARCHAR(100) NOT NULL, 
app_bytes_in VARCHAR(100) NOT NULL,
app_bytes_out VARCHAR(100) NOT NULL,
PRIMARY KEY(data_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* wowza config table for connection settings to wowza server */
CREATE TABLE IF NOT EXISTS wow_connections (
data_id INT auto_increment,
server_name VARCHAR(100) NOT NULL,
server_url VARCHAR(100) NOT NULL,
server_username VARCHAR(100) NOT NULL,
server_password VARCHAR(100) NOT NULL,
server_port INT NOT NULL,
PRIMARY KEY(data_id)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* default user: user: admin / email: admin@dashboard.lan / password: dashboard */
INSERT INTO `wow_users` (`id`, `username`, `password`, `salt`, `email`) VALUES
(1, 'admin', 'd7d3814a18eb8695e5db382e5be61bb5ac920fa44c11c707f548ef3601935217', '1a00eed160382dc3', 'admin@dashboard.lan');

/* default data */
INSERT INTO wow_connections (server_name, server_url, server_username, server_password, server_port) VALUES
('give_a_name', 'your_wowza_url', 'wowza_user', 'wowza_password', '8086' );



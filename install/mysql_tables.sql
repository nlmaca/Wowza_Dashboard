/* page version: 1.0 */
/* user table for login procedure:  */

CREATE TABLE IF NOT EXISTS `wow_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

/* default user: user: admin / email: admin@dashboard.lan / password: dashboard */
INSERT INTO `wow_users` (`id`, `username`, `password`, `salt`, `email`) VALUES
(1, 'admin', 'd7d3814a18eb8695e5db382e5be61bb5ac920fa44c11c707f548ef3601935217', '1a00eed160382dc3', 'admin@dashboard.lan');

/* wowza table for vhost (will be filled by scripts) */
create table wow_vhost_status ( 
data_id int auto_increment, 
session_time datetime not null, 
vhost_name varchar(100) not null, 
vhost_timerunning varchar(100) not null, 
vhost_conn_limit int not null, 
vhost_conn_current int not null,
vhost_conn_total int not null,
vhost_conn_accepted int not null,
vhost_conn_rejected int not null,
vhost_bytes_in varchar(100) not null,
vhost_bytes_out varchar(100) not null,
primary key(data_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* wowza table for application level (will be filled by scripts) */
create table wow_app_status ( 
data_id int auto_increment, 
session_time datetime not null, 
app_name varchar(100) not null, 
app_online int not null, 
app_stream_name varchar(100) not null, 
app_bytes_in varchar(100) not null,
app_bytes_out varchar(100) not null,
primary key(data_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* wowza config table for connection settings to wowza server */
create table wow_connections (
data_id int auto_increment,
server_name varchar(100) not null,
server_url varchar(100) not null,
server_username varchar(100) not null,
server_password varchar(100) not null,
server_port int not null,
primary key(data_id)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* default data */
insert into wow_connections (server_name, server_url, server_username, server_password, server_port) VALUES
('give_a_name', 'your_wowza_url', 'wowza_user', 'wowza_password', '8086' );

/* todo wowza table for extraction of serverinfo */



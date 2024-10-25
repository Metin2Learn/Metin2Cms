ALTER TABLE `account`
ADD web_admin int NOT NULL,
ADD last_ip varchar(255) NOT NULL,
ADD register_ip varchar(255) NOT NULL,
ADD ban_until datetime NULL,
ADD ban_reason varchar(255) NULL,
ADD referrer varchar(255) NOT NULL,
ADD rb_points int NOT NULL



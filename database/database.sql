DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users`(
  id int(10) unsigned NOT NULL auto_increment COMMENT '编号',
  username varchar(20) NOT NULL DEFAULT '' COMMMENT '账户',
  password varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  email varchar(128) NOT NULL DEFAULT '' COMMENT '邮箱',
  phone varchar(30) NOT NULL DEFAULT '' COMMENT '手机',
  PRIMARY KEY(id),
  UNIQUE KEY users_username_unique(username),
  UNIQUE KEY users_password_unique(password)
)ENGINE=INNODB;
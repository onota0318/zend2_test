-- 会員テーブル
drop table if exists member cascade;

create table member (
  id BIGINT(20) not null auto_increment comment '会員ID'
  , login_id varchar(255) not null comment 'ログインID'
  , password varchar(255) not null comment 'パスワード'
  , first_name varchar(255) not null comment '苗字'
  , last_name varchar(255) not null comment '名前'
  , gender tinyint(1) not null comment '性別'
  , pref int(2) not null comment '都道府県'
  , last_login_date DATETIME default '0000-00-00 00:00:00' comment '最終ログイン日時'
  , created_date DATETIME default '0000-00-00 00:00:00' comment '作成日時'
  , modified_date DATETIME default '0000-00-00 00:00:00' comment '変更日時'
  , deleted_date DATETIME default '0000-00-00 00:00:00' comment '削除日時'
  , constraint member_PKC primary key (id)
) comment '会員テーブル' ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- 会員属性
drop table if exists member_attributes cascade;

create table member_attributes (
  member_id BIGINT(20) not null comment '会員ID'
  , `key` VARCHAR(255) not null comment '属性名'
  , `value` VARCHAR(255) comment '属性値'
  , deleted_date DATETIME default '0000-00-00 00:00:00' comment '削除日時'
  , created_date DATETIME default '0000-00-00 00:00:00' comment '作成日時'
  , modified_date DATETIME default '0000-00-00 00:00:00' comment '変更日時'
  , constraint member_attributes_PKC primary key (member_id,`key`,deleted_date)
) comment '会員属性' ENGINE=InnoDB DEFAULT CHARSET=utf8;
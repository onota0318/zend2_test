-- 会員変更履歴
drop table if exists member_history cascade;

create table member_history (
  id BIGINT(20) not null auto_increment comment 'ID'
  , member_id BIGINT(20) not null comment '会員ID'
  , `key` VARCHAR(255) not null comment '変更属性'
  , before_value VARCHAR(255) not null comment '変更前値'
  , after_value VARCHAR(255) not null comment '変更後値'
  , created_date DATETIME not null comment '作成日'
  , modified_date DATETIME default '0000-00-00 00:00:00' comment '変更日時'
  , deleted_date DATETIME default '0000-00-00 00:00:00' comment '削除日時'
  , constraint member_history_PKC primary key (id,member_id)
) comment '会員変更履歴' ENGINE=InnoDB DEFAULT CHARSET=utf8;

create index member_history_IX1
  on member_history(member_id,`key`);

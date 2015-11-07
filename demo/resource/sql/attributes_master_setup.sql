-- 属性管理マスタ
drop table if exists attributes_master cascade;

create table attributes_master (
  `key` VARCHAR(255) not null comment '属性名'
  , detail VARCHAR(255) not null comment '属性説明'
  , is_nullable TINYINT(1) default 0 comment 'NULL許可フラグ'
  , is_secret TINYINT(1) default 1 comment '機密情報フラグ'
  , deleted_date DATETIME default '0000-00-00 00:00:00' comment '削除日時'
  , created_date DATETIME default '0000-00-00 00:00:00' comment '作成日時'
  , modified_date DATETIME default '0000-00-00 00:00:00' comment '変更日時'
  , constraint attributes_master_PKC primary key (`key`,deleted_date)
) comment '属性管理マスタ' ENGINE=InnoDB DEFAULT CHARSET=utf8;
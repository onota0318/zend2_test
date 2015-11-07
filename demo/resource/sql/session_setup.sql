CREATE TABLE IF NOT EXISTS session_front (
  `id` char(255) NOT NULL,
  `name` char(32) NOT NULL,
  `modified` int,
  `lifetime` int,
  `data` text,
  PRIMARY KEY (`id`, `name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS session_system (
  `id` char(255) NOT NULL,
  `name` char(32) NOT NULL,
  `modified` int,
  `lifetime` int,
  `data` text,
  PRIMARY KEY (`id`, `name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

<?php
$config = array();

/**
 * GuestのIPアドレス
 */
$config['guest.ip.addr'] = '192.168.56.4';

/**
 * Guest側のポート
 */
$config['guest.port'] = '22';

/**
 * Guest側のユーザー
 */
$config['guest.login.user.id'] = 'vagrant';

/**
 * Guest用のログインPW（平文だけど・・・）
 */
$config['guest.login.user.password'] = 'vagrant';

/**
 * Guest側synced_holder
 */
$config['guest.synced.dir'] = '/var/www/cgi-bin/';

/**
 * Host側synced_holder
 */
$config['host.synced.dir'] = 'C:/work/workspace/FWDEMO/src/cgi-bin/';

/**
 * Guest側のプロジェクトルート
 */
$config['guest.project.root'] = $config['guest.synced.dir'] . 'demo/';


/**
 * Host側のプロジェクトルート
 */
$config['host.project.root'] = $config['host.synced.dir'] . 'demo/';

/**
 * Guest側テスト対象Dir
 */
$config['guest.test.root.dir'] = $config['guest.project.root'] . 'src/test/';


/**
 * 作業領域（ここは相対パス！！！）
 * Guest側・Host側のsynced_holderからパスを構築
 */
$config['synced.relative.work.dir'] = 'dev/phpunit/netbeans/work/';

/**
 * Guest側のPHPUnitのパス
 */
$config['guest.php.unit.path'] = $config['guest.synced.dir'] . 'lib/vendor/bin/phpunit';

/**
 * Guest側のPHPUnit --configurationのパス
 */
$config['guest.php.unit.config.path'] = $config['guest.test.root.dir'] . 'phpunit.xml';

/**
 * Guest側のPHPUnit --bootstrapのパス
 */
$config['guest.php.unit.bootstrap.path'] = /*$config['guest.test.root.dir'] . 'bootstrap.php'*/ "";

/**
 * Guest側のPHPUnit --include_pathのパス
 */
$config['guest.php.unit.include.path'] = '';

/**
 * Guest側のencoding
 */
$config['guest.internal.encoding'] = 'UTF-8';


return $config;
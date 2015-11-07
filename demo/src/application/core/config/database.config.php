<?php
/*****************************************************/
/*  D A T A B A S E    C O U N F I G U R A T I O N   */
/*****************************************************/

return array(
    'adapters' => array(
        /** 
         * defaultアダプタ
         */
        'adapter:default' => array(
            'driver'         => 'Pdo',
            'dsn'            => 'mysql:dbname='. $env->db_name .';host=' . $env->db_host,
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
            'username' => $env->db_user,
            'password' => $env->db_password,
        ),
        /*
        'adapter:slave' => array(
            'driver'         => 'Pdo',
            'dsn'            => 'mysql:dbname='. $env->db_name .';host=' . $env->db_host,
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
            ),
            'username' => $env->db_user,
            'password' => $env->db_password,
        ),
        */
    ),
);

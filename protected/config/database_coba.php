<?php

// This is the database connection configuration.
return array(
    //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database

    'connectionString' => 'pgsql:host=192.168.1.254;dbname=db_pkb_coba',
    'emulatePrepare' => true,
    'username' => 'postgres',
    'password' => '3l50f7_db',
    'charset' => 'utf8',
    'class' => 'CDbConnection',
);

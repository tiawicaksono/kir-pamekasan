<?php

// This is the database connection configuration.
return array(
    //'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
    // uncomment the following lines to use a MySQL database

    'connectionString' => 'mysql:host=192.168.8.80;dbname=db_sg',
    'emulatePrepare' => true,
    'username' => 'tata',
    'password' => 'tata',
    'charset' => 'utf8',
    'class' => 'CDbConnection',
);

<?php

require 'vendor/autoload.php';
require 'config.php';

use App\Helpers\Database;

try{
    (new Database())->importSql('otrium_challenge.sql');
    echo "Success\n";
}catch(Exception $e){
    echo "Error while import ". $e->getMessage()."\n";
}



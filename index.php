<?php

require './vendor/autoload.php';
require './src/Server.php';


$server = new \TcRest\Server(array(
            'address' => array('controller' => '\TcRest\controllers\AddressController'),
        ));
$server->route();
<?php
$loader = require __DIR__ . '/../vendor/autoload.php';
session_start();
require("src" . DIRECTORY_SEPARATOR . "Server.php");
require("src" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "BaseController.php");
require("src" . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "AddressController.php");
require("src" . DIRECTORY_SEPARATOR . "models" . DIRECTORY_SEPARATOR . "AddressModel.php");
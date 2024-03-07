<?php

namespace Alirezamires\DummyServer;
require_once __DIR__ . '/vendor/autoload.php';
define("PHP_DUMMY_SERVER_ROOT_DIR", __DIR__ . '/data');

Request::save();
Response::send();
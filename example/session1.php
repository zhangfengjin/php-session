<?php
require __DIR__ . "/../vendor/autoload.php";
$bootStrap = new \XYLibrary\Session\Bootstrap(false);
$bootStrap->bootStrap();
app("session.start")->handler();
echo \XYLibrary\Session\Facade\Session::get("username", "zhangfj_get");
app("session.start")->terminate();
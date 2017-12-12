<?php
require __DIR__ . "/../vendor/autoload.php";
$bootStrap = new \XYLibrary\Session\Bootstrap(false);
$bootStrap->bootStrap();
app("session.start")->handler();

echo \XYLibrary\Session\Facade\Session::put("username", "zhangfj");
echo \XYLibrary\Session\Facade\Session::get("username", "zhangfj_get");
echo \XYLibrary\Session\Facade\Session::exists("username");
echo \XYLibrary\Session\Facade\Session::has("username");
echo \XYLibrary\Session\Facade\Session::remove("username");
echo \XYLibrary\Session\Facade\Session::flush();
echo \XYLibrary\Session\Facade\Session::put("username", "zhangfj");

app("session.start")->terminate();

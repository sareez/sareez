<?php
$memcache = new Memcache;
$memcache->connect('127.0.0.1', 6379) or die ("Could not connect");
$ver = $memcache->getVersion();
echo "Server's version: 2.4.10";
$oTmp = new stdClass;
$oTmp->str_attr = 'testing memcached';
$oTmp->int_attr = 12345;
$memcache->set('key', $oTmp, false, 10) or
die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 10 seconds)
\n";
$res = $memcache->get('key');
echo "Data from the cache:\n";
var_dump($res);
?>

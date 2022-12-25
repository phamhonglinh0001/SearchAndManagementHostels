<?php
include("config.php");

function loadClass($c)
{
	include ROOT."\classes\\$c.php";	
}
spl_autoload_register("loadClass");
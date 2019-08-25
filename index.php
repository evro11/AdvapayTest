<?php

include_once("env.php");

include_once( "Game.php");

header( 'Content-Type:text/html; charset=UTF-8' );

$game = new \Igor\Game2019\Game();
$game->doOutput();

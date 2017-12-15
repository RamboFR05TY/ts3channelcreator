<?php
/* Require Library */
Require('Library/TeamSpeak3/TeamSpeak3.php');
/* Require Library End */

/* Config Start with Array */

$config = array();

$config['Username'] = "serveradmin"; //Login name for the Query
$config['Password'] = "8766198766"; //Password for the Query
$config['serverIP'] = "129.232.218.10"; //Server IP or Domain Name
$config['sPort'] = "9987"; //Server Port for the Query | Default: 10011
$config['qPort'] = "10011"; //Query Port for the Query | Default: 10011
$config['BotName'] = rawurlencode("Channel Bot"); //url encoded bot name

/* Bot Config End */

/* TeamSpeak Settings */

$config['ChannelToJoin'] = 723; //user joins channel and gets channel
$config['ChannelToBeSub'] = 150; //top channel of the created channel
$config['TSDomain'] = "ts.rsag.co.za"; //for the link could be ip
$config['ChannelAdmin'] = 5; //channeladmin group
$config['ServerGroupToIgnore'] = "12"; //as the be a string for strpos
/* TeamSpeak Settings */



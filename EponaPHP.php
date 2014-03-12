<?php

error_reporting(0);

class EponaPHP {

function EponaPHP() {
$this->Server = "irc.freenode.net";
$this->FirstChannel = "#bots";
$this->ConnectPassword = "username:pass";
$this->BotNick = "EponaPHP";
$this->Port = 6667;
$this->TriggerChar = "!";
}

function SendRaw($input) {
echo $input.PHP_EOL;
fwrite($this->Socket,sprintf("%s\r\n",$input));
}

function SendMsg($channel,$input) {
fwrite($this->Socket,sprintf("PRIVMSG %s :%s\r\n",$channel,$input));
}

function SendNtc($channel,$input) {
fwrite($this->Socket,sprintf("NOTICE %s :%s\r\n",$channel,$input));
}

function Idle() {
$this->SendRaw("PASS {$this->ConnectPassword}");
$this->SendRaw("USER {$this->BotNick} {$this->BotNick} {$this->BotNick} :EponaPHP IRC bot");
$this->SendRaw("NICK {$this->BotNick}");
while (!feof($this->Socket)) {
$this->Get = fgets($this->Socket, 4096);
echo $this->Get.PHP_EOL;
$line = explode(" ", $this->Get);
$source = substr($line[0], 1);
$dsource = $line[0];
$sourceNick = strstr($source, "!", 1);
$sourceUser = substr(strstr(strstr($source, "@", 1), "!"), 1);
$sourceHost = substr(strstr($source, "@"), 1);
$cmd = $line[1];
$target = $line[2];
$lastParameter = trim(substr(strstr($this->Get, " :"), 2));
switch (strtoupper($cmd)) {
case "PRIVMSG":
$this->Privmsg($sourceNick, $sourceUser, $sourceHost, $target, $lastParameter);
break;
case "PONG":
break;
case "MODE":
$this->SendRaw("JOIN {$this->FirstChannel}");
break;
default:

break;
}
switch (strtoupper($dsource)) {
case "PING":
$this->SendRaw("PONG {$cmd}");
break;
}
}
}

function Privmsg($srcN, $srcU, $srcH, $target, $privmsg) {
$cmdline = explode(" ", $privmsg, 2);
$cmd = $cmdline[0];
$args = $cmdline[1];
switch (strtolower($cmd)) {
case "!about":
$this->SendMsg($target, "PHP Bot made by I_Is_Payton_ much thanks to j4jackj for help.");
break;
case "!md5":
$this->SendMsg($target, sprintf("MD5 sum of input: %s", md5($cmdline[1])));
break;
case "!sha512":
$this->SendMsg($target, sprintf("SHA512 sum of input: %s", hash("sha512", $cmdline[1])));
break;
case "!sha1":
$this->SendMsg($target, sprintf("SHA512 sum of input: %s", sha1($cmdline[1])));
break;
case "!join":
$this->SendNtc($srcN, sprintf("JOINING %s", $cmdline[1]));
$this->SendRaw(sprintf("JOIN %s", $cmdline[1]));
break;
//case "!stop":
//$this->SendMsg($target, sprintf("*EponaPHP OUT*"));
//$this->SendRaw(sprintf("PART %s", $target));
//break;
case "!kill":
$this->SendMsg($target, sprintf("\x01ACTION kills %s with %s arm\x01", $cmdline[1], $srcN));
break;
case '!define':
if (($json = file_get_contents('http://api.duckduckgo.com/?q=' . urlencode($cmdline[1]) . '&format=json'))) {
   if (($json = json_decode($json, true))) {
        $this->SendMsg($target, $json['Definition']);
    }else{
    	$this->SendMsg($target, sprintf("Could not find a Definition."));
    }
}
break;
if ($cmd == "hi") {
$this->SendMsg($target, sprintf("Hello, %s.", $srcN));
}
case "lol":
$this->SendMsg($target, sprintf("haha"));
break;
}
}

function StartBot() {
$this->Socket = fsockopen($this->Server, $this->Port);



$this->Idle();
}

}
$EponaPHP = new EponaPHP();
$EponaPHP->StartBot();

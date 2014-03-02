<?php

/*
Soon:
Plugin Support for commands.
No <br /> xD

*/

//Stops the script from after periods of time.
set_time_limit(0);
//Pesky <br /> error, still works, though. :)
error_reporting(0);

// Edit these settings
$chan = "#bots"; //IRC Channel
$server = "irc.freenode.net"; //IRC server
$port = 6667; //Port default: 6667
$nick = "EponaPHP"; //Name that is displayed
$reason = "This is the default quit message"; //Please set quit reason

$socket = fsockopen("$server", $port);
fputs($socket,"USER $nick $nick $nick $nick :$nick\n");
fputs($socket,"NICK $nick\n");
fputs($socket,"JOIN ".$chan."\n");

while(1) {
    while($data = fgets($socket)) {
            echo nl2br($data);
            flush();

            $ex = explode(' ', $data);
        $rawcmd = explode(':', $ex[3]);
        $oneword = explode('<br />', $rawcmd);
            $channel = $ex[2];
        $nicka = explode('@', $ex[0]);
        $nickb = explode('!', $nicka[0]);
        $nickc = explode(':', $nickb[0]);

        $host = $nicka[1];
        $nick = $nickc[1];
            if($ex[0] == "PING"){
                fputs($socket, "PONG ".$ex[1]."\n");
            }

        $args = NULL; for ($i = 4; $i < count($ex); $i++) { $args .= $ex[$i] . ' '; }

            if ($rawcmd[1] == "!say") {
                fputs($socket, "PRIVMSG ".$channel." :".$args." \n");
            }
        if ($rawcmd[1] == "!md5") {
            fputs($socket, "PRIVMSG ".$channel." :Here is the MD5 hash of $args ".md5($args)."\n");
        }
        if ($rawcmd[1] == "!sqrt") {
            fputs($socket, "PRIVMSG ".$channel." :The square root of $args is ".round(sqrt($args), 3)."\n");
        }
        if ($rawcmd[1] == "!cookie") {
            fputs($socket, "PRIVMSG ".$channel." :This guy/girl gets a cookie --> ".$args."\n");
        }
        if ($rawcmd[1] == "!date") {
            $date = date("m.d.y");
            fputs($socket, "PRIVMSG ".$channel." :Today is ".$date."\n");
        }
        if ($rawcmd[1] == "!stop") {
            $this->_send("QUIT", $reason); // $this->_send is predefined by IRC
        }
        if ($rawcmd[1] == "!nick") {
            fputs($socket, "NICK $args\n");
        }
    }
}
//dont end off the script, it needs to run until MinTTY is closed.

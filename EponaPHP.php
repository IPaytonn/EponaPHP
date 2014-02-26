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
$this->send = $this->_send; IDEK why..

// Edit these settings
$chan = "#MCPEBukkit"; //IRC Channel
$server = "irc.freenode.net"; //IRC server
$port = 6667; //Port default: 6667
$nick = "EponaPHP"; //Name that is displayed

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
            fputs($socket, "PRIVMSG ".$channel." :MD5 ".md5($args)."\n");
        }
        if ($rawcmd[1] == "!sqrt") {
            fputs($socket, "PRIVMSG ".$channel." :SQRT ".round(sqrt($args), 3)."\n");
        }
        if ($rawcmd[1] == "!cookie") {
            fputs($socket, "PRIVMSG ".$channel." :This guy gets a cookie --> ".$args."\n");
        }
        if ($rawcmd[1] == "!date") {
            $date = date("m.d.y");
            fputs($socket, "PRIVMSG ".$channel." :DATE ".$date."\n");
        }
        if ($rawcmd[1] == "!stop") {
            $this->send("QUIT");
        }
    }
}
//dont end off the script, it needs to run until MinTTY is closed.

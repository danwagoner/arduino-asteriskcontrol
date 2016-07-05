#!/usr/bin/php -q

<?php
// Arduino Control
// Original Author: Kate Hartman - http://itp.nyu.edu/~kh928/phonesandobjects.html
// Modified By: Dan Wagoner - www.nerdybynature.com
// Date: 03/11/09
// An AGI script written to connect to your Arduino and send control messages.
// This script could easily be modified to recieve information from an Arduino
// as well.

require("phpagi.php");
$agi = new AGI();

// Change the values below to reflect your setup
$arduino_ip = "tcp://192.168.15.15";
$arduino_port = 23;
$ttsengine = 0; //enter 0 for flite, 1 for cepstral
$enter_prompt = "please enter L E D value. enter zero for off, 1 for on, and 2 for blink.";
$sending_prompt = "sending information to the ar dwee no";
$error_prompt = "error, please try again.";

//open a socket to the Arduino's IP address and port
$fp = fsockopen($arduino_ip, $arduino_port, $errno, $errstr);

if (!$fp) {
   speak($error_prompt);
   exit();
}

$continue = true;
while($continue){
   speak($enter_prompt);
   $return = $agi->get_data('beep', 10000, 1);
   if (($return['result'] >= 0) and ($return['result'] <= 2)){
      speak($sending_prompt);
      $ascii = chr($return['result']); //convert that # to ASCII
      fwrite($fp, $ascii); //send that through the socket to the Arduino
   }
   else{
      speak($error_prompt);
	}
}
fclose($fp);

// Speak function
function speak($text){
global $agi;
    if ($ttsengine == 0){
                $agi->text2wav($text);
        }else {
                $agi->swift($text);
        }
}

?>

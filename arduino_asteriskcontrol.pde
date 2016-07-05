/*
 * Asterisk Controlling Arduino Example
 *
 * A basic example displaying the ability of Asterisk
 * open-source PBX to control an LED on an Arduino with
 * an ethernet shield.
 * 
 * Dan Wagoner
 * http://www.nerdybynature.com
 */

#include <Ethernet.h>

int LEDpin = 4;							      //LED set to pin 4
int x;
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };		//must give WIZnet a MAC
byte ip[] = { 192, 168, 15, 15 };				      //must configure WIZnet IP
Server server = Server(23);					      //TCP port the server is listening on
								            //I'm using telnet, but you could use any
void setup()
{
  Ethernet.begin(mac, ip);
  server.begin();
  Serial.begin(9600);						      //for troubleshooting purposes (not needed)
  pinMode(LEDpin, OUTPUT);
}

void loop () {
Client client = server.available();				     //client connects to server

if (client){							     //if connection present
  x = client.read();						     //read information coming from server
  Serial.println(x);}						     //print to serial (troublshooting only)
  
if (x == 0){							     //if information sent is a zero
  digitalWrite(LEDpin, LOW);}					     //turn of LED
else if (x == 1){						           //if information sent is a one
  digitalWrite(LEDpin, HIGH);}				     //turn on LED
else if (x == 2){						           //if information sent is a two
  digitalWrite(LEDpin, HIGH);					     //blink the LED
  delay(500);
  digitalWrite(LEDpin, LOW);
  delay(500);}
}
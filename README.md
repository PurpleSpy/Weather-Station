# Weather-Station
Things you need are an esp8266 chip
https://www.adafruit.com/product/2821

You will need a BME280 tempature, barometer, and humidity sensor.
https://www.adafruit.com/product/2652

You will need to download the libraries for the sensor at adafruit. They have the pinouts and wiring scmatics to get your project started.

https://learn.adafruit.com/adafruit-bme280-humidity-barometric-pressure-temperature-sensor-breakout

The next step is to get your database together. The sql is the database with the datatable you need to get started on. I used mariadb but you
have custom software for this. You will need to set up a user and make sure that it is setup in php. The mysql user/database will need to be setup
in the ino file. The ino file is a arduino scetch for the esp8266 and you will also need to supply your wifi and password to make it connect.

The server you choose will need to be running PHP https://www.php.net/ the weatherAPI does the lifting for saving and pulling information to your database. The weateherGUI is a dashboard to view all sensors you have running. Each sensor must have its own name without spaces. If you give
two sensors the same name then they will fight for control and look like one entry in the database. Those pins differ then the wiring diagram and they

Refer to the IDE pinout for counting the pins.

BME_SCK 14
BME_MISO 13
BME_MOSI 12
BME_CS 3

headache pin 4
led pin 5

Headache pin is for a NO switch that triggers an interrupt to notate some of the weather data. Pin 5 is used to light an led when headache pin is triggered.

Inside the weatherAPI you will need to add your own mysql user,mysql password and php server IP address.

Once it is set up you will have a functioning dashboard with all sensors available and totally CSS skinable.
If you find bugs add it to the tracker and maybe we squash them.

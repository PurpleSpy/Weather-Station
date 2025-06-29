#include <Adafruit_BME280.h>
#include <Wire.h>
#include <SPI.h>
#include <Adafruit_Sensor.h>
#include <ESP8266WiFi.h>

#include <WiFiClient.h>
#include <WiFiClientSecure.h>
#include <ESP8266HTTPClient.h>


String wifiname="Your SSID";
String wifipass="your wifi password";
String nameSerial = "Sensor name";
String actionIP="server ip or url";
int baudspeed = 9600;

double temp=0;
double humidity=0;
double baro=0;
int waitTimeinms = 30000;
bool headache=false;
#define BME_SCK 14
#define BME_MISO 13
#define BME_MOSI 12
#define BME_CS 3

int headachePin=4; // pin for a no pushbutton switch
int lightPin = 5; //pin for led light

void ICACHE_RAM_ATTR docall();// loads isr into ram
WiFiClient client;
HTTPClient http;
Adafruit_BME280 bme(BME_CS, BME_MOSI, BME_MISO, BME_SCK); 

void setup() {
  // put your setup code here, to run once:
  pinMode(headachePin, INPUT_PULLUP);
  pinMode(lightPin, OUTPUT);
  attachInterrupt(headachePin,docall,FALLING);
  Serial.begin(baudspeed);
  CheckConnection();
  bme.begin();
  
}

void loop() {
  // put your main code here, to run repeatedly:
  CheckConnection();
    Serial.println("CHecking http"); 
       
        if(http.begin(client,MakeGetReq(CtoF(bme.readTemperature()),bme.readHumidity(),toInchesMercury(bme.readPressure()),headache,nameSerial,actionIP))) { 
          
          if(http.GET()>0) {
            String retval ="";

            Serial.println("Connection Accepted");
            retval=http.getString();
            Serial.println(retval);
            headache=0;
            digitalWrite(lightPin,LOW);
          }
        else{
          Serial.println(http.GET());
        }
        
      }    

  
  
  else{

      Serial.println("Connection failed,no connection made");
  }

  
  delay(waitTimeinms);
}

void docall(){
    digitalWrite(lightPin,HIGH);
    headache=true;

}

void CheckConnection(){
  if(WiFi.status()!= WL_CONNECTED){
  
  Serial.println("Connecting");
  WiFi.mode(WIFI_STA);
  WiFi.begin(wifiname,wifipass);
  while(WiFi.status()!= WL_CONNECTED){
    delay(500);
    Serial.print(",");
  }
  Serial.print(WiFi.localIP());
   
  }
}

String MakeGetReq(double temp,double humidity,double baro, bool head,String serialnumber,String actionIP){
  String outstr ="http://"+ actionIP +"/weatherAPI.php?";
  String outstr2="temp=" + String(temp) +"&humid=" + String(humidity) +"&baro=" + String(baro) + "&uid=" +serialnumber +"&head=" + String(head);

  outstr2.replace(" ","%20");
  
  outstr+= outstr2;
    
  return outstr;
}

double CtoF(double c){
  return (c * 9/5)+32;
}

double toInchesMercury(double pval){

  return pval/3386.39;

}
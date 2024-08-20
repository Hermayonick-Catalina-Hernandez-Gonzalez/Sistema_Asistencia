#include <SPI.h>
#include <MFRC522.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <Keypad.h>

#define SS_PIN  5  
#define RST_PIN 17 

MFRC522 rfid(SS_PIN, RST_PIN);

const char* ssid = "IZZI-0787";
const char* password = "778K5YXUBOIS";
const char* serverName = "http://tu-servidor/api/esp32/store";

WiFiClient espClient;

LiquidCrystal_I2C lcd(0x27, 16, 2);

const byte ROWS = 4; 
const byte COLS = 4;
char keys[ROWS][COLS] = {
  {'1','2','3','A'},
  {'4','5','6','B'},
  {'7','8','9','C'},
  {'*','0','#','D'}
};
byte rowPins[ROWS] = {13, 12, 14, 27}; 
byte colPins[COLS] = {26, 25, 33, 32}; 
Keypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);

String matricula = "";
String uuid = "";

void setup() {
  Serial.begin(9600);
  SPI.begin(); 
  rfid.PCD_Init(); 
  connectToWiFi();
}

void connectToWiFi() {
  Serial.println("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    WiFi.mode(WIFI_STA);
    WiFi.begin(ssid, password);
    delay(1000);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  char key = keypad.getKey();
  if (key) {
    if (key == '#') {
      if (matricula.length() > 0 && uuid.length() > 0) {
        enviarDatos(matricula, uuid);
        matricula = "";
        uuid = "";
      }
    } else if (key == '*') {
      if (matricula.length() > 0) {
        matricula.remove(matricula.length() - 1);
      }
    } else {
      if (isdigit(key) && matricula.length() < 7) {
        matricula += key;
      }
    }
    Serial.println("Matrícula: " + matricula);
  }

  if (rfid.PICC_IsNewCardPresent() && rfid.PICC_ReadCardSerial()) {
    uuid = "";
    for (byte i = 0; i < rfid.uid.size; i++) {
      uuid += String(rfid.uid.uidByte[i], HEX);
    }
    Serial.println("UUID: " + uuid);
  }
}

void enviarDatos(String matricula, String uuid) {
  HTTPClient http;
  http.begin(espClient, serverName);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  String postData = "matricula=" + matricula + "&uuid=" + uuid;
  int httpResponseCode = http.POST(postData);

  if (httpResponseCode == 200) {
    String response = http.getString();
    Serial.println("Respuesta del servidor: " + response);
  } else {
    Serial.println("Error: " + String(httpResponseCode));
  }
  http.end();
}


#include <SPI.h>
#include <MFRC522.h>
#include <Servo.h>

#define SS_PIN 10  // SS pin for RFID
#define RST_PIN 9   // RST pin for RFID

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance
Servo myServo;                      // Create Servo instance

void setup() {
  Serial.begin(9600); // Initialize serial communications
  SPI.begin();        // Initialize SPI bus
  mfrc522.PCD_Init(); // Initialize MFRC522 card
  myServo.attach(4);  // 서보 모터 핀에 연결
  myServo.write(90);   // 초기 위치 0도로 설정
  Serial.println("RFID 리더 준비 완료!");  // Setup 완료 메시지 출력
}

void loop() {
  if (Serial.available()) {
    char command = Serial.read(); // 명령 읽기

    if (command == 'c') {          // 'c' 명령어 수신 시
      myServo.write(0);            // 개찰구 닫기
      Serial.println("서보 모터를 원래 위치로 돌아갔습니다.");
    }  
    if (command == 'o') {          // 'o' 명령어 수신 시
      myServo.write(90);  // 90도로 회전
      Serial.println("서보 모터를 90도로 회전했습니다.");
    }
 
  }

  // RFID 읽기 시도
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");  // Ensure two digits for each byte
      uid += String(mfrc522.uid.uidByte[i], HEX); // Convert UID to string
    }
    Serial.println("카드 UID: " + uid); // Send UID via Serial
    Serial.println("전송 완료");  // 전송 완료 메시지 출력
    mfrc522.PICC_HaltA(); // Halt PICC
  }

  // 카드가 없을 경우 대기
  delay(100); // 100ms 대기
}

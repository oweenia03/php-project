#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10    // SS pin for RFID
#define RST_PIN 9    // RST pin for RFID
#define SPEAKER_PIN 8 // Buzzer pin

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance

void setup() {
  Serial.begin(9600);       // Initialize serial communications
  SPI.begin();              // Initialize SPI bus
  mfrc522.PCD_Init();       // Initialize MFRC522 card
  pinMode(SPEAKER_PIN, OUTPUT); // Set speaker pin as output
  Serial.println("RFID 리더 준비 완료!");  // Setup 완료 메시지 출력
}

void loop() {
  // 3초 간격으로 UID 읽기 시도
  delay(3000); // 3초 대기

  if (!mfrc522.PICC_IsNewCardPresent()) {
    Serial.println("카드가 감지되지 않았습니다.");
    return; // If no new card present, exit
  }
  
  if (!mfrc522.PICC_ReadCardSerial()) {
    Serial.println("카드를 읽는 중 오류 발생.");
    return; // If card read failed, exit
  }

  // Read UID and send it via Serial
  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");  // Ensure two digits for each byte
    uid += String(mfrc522.uid.uidByte[i], HEX); // Convert UID to string
  }
  
  Serial.println("카드 UID: " + uid); // Send UID via Serial
  Serial.println("전송 완료");  // 전송 완료 메시지 출력

  // 부저 울리기
  tone(SPEAKER_PIN, 1000); // 1kHz tone
  delay(450);             // 1초 동안 소리 유지
  noTone(SPEAKER_PIN);     // 소리 끄기

  mfrc522.PICC_HaltA(); // Halt PICC
}

#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 10  // RFID SS 핀 (D10에 연결)
#define RST_PIN 9  // RFID RST 핀 (D9에 연결)
#define LED_PIN 8  // LED 핀 (D8에 연결)
#define BUTTON_PIN 7  // 버튼 핀 (D7에 연결)

MFRC522 rfid(SS_PIN, RST_PIN);  // RFID 객체 생성

int ledState = LOW;  // LED 상태 (기본 OFF)
int cur_val = 0;  // 현재 버튼 상태
int pre_val = 0;  // 이전 버튼 상태

void setup() {
  pinMode(LED_PIN, OUTPUT);  // LED 핀을 출력으로 설정
  pinMode(BUTTON_PIN, INPUT_PULLUP);  // 버튼 핀을 내부 풀업 저항 사용하여 입력으로 설정

  SPI.begin();  // RFID 통신 시작
  rfid.PCD_Init();  // RFID 리더 초기화

  Serial.begin(9600);  // 시리얼 통신 시작
  Serial.println("시스템 준비 완료. 버튼을 눌러 LED 제어 및 RFID 읽기 시작...");

  // RFID 초기화 상태 확인
  if (!rfid.PCD_PerformSelfTest()) {
    Serial.println("RFID 리더기가 정상적으로 작동하지 않습니다. 다음 사항을 확인하세요:");
    Serial.println("1. 배선 연결이 올바른지 확인.");
    Serial.println("2. 전원이 제대로 공급되는지 확인.");
  } else {
    Serial.println("RFID 리더기 초기화 성공!");
  }
}

void loop() {
  // 현재 버튼 상태 읽기
  cur_val = digitalRead(BUTTON_PIN);

  // 버튼이 눌려졌을 때 상태 변화 감지
  if (pre_val == HIGH && cur_val == LOW) {
    // LED 상태 토글
    ledState = !ledState;
    digitalWrite(LED_PIN, ledState);

    // LED 상태 변경 출력
    Serial.println(ledState == HIGH ? "LED ON, RFID 읽기 가능." : "LED OFF, RFID 읽기 중단.");

    // LED가 ON 상태로 변경되었을 때 즉시 RFID 읽기 시도
    if (ledState == HIGH) {
      readRFID();  // RFID 읽기 함수 호출
    }
  }

  // 이전 버튼 상태 업데이트
  pre_val = cur_val;

  // LED가 켜져 있을 때만 주기적으로 RFID 읽기 시도
  if (ledState == HIGH) {
    readRFID();  // RFID 읽기 함수 호출
  }

  delay(1000);  // 안정화를 위해 1초 지연
}

// RFID UID를 읽는 함수
void readRFID() {
  if (rfid.PICC_IsNewCardPresent()) {
    if (rfid.PICC_ReadCardSerial()) {
      Serial.print("카드 UID: ");
      for (byte i = 0; i < rfid.uid.size; i++) {
        Serial.print(rfid.uid.uidByte[i] < 0x10 ? "0" : "");  // 두 자리 수로 포맷팅
        Serial.print(rfid.uid.uidByte[i], HEX);
        Serial.print(" ");
      }
      Serial.println();

      // 카드 읽기 완료 후 통신 종료
      rfid.PICC_HaltA();
      rfid.PCD_StopCrypto1();
    } else {
      Serial.println("카드 읽기 실패!");
    }
  } else {
    Serial.println("새로운 카드가 감지되지 않았습니다.");
  }
}
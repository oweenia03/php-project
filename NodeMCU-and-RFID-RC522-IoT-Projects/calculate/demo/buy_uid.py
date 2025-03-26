import requests
import serial
import time

# 시리얼 포트 설정
ser = serial.Serial('COM5', 9600, timeout=1)

while True:
    if ser.in_waiting > 0:
        try:
            line = ser.readline().decode('utf-8', errors='ignore').strip()  # 시리얼 데이터 읽기 및 오류 무시
            print(f"Received raw data: {line}")  # 수신한 원시 데이터 출력

            # '카드 UID:' 메시지를 찾는 조건 추가
            if line.startswith("카드 UID:"):  # UID 데이터가 있는지 확인
                uid = line.split(": ")[1]  # UID 값 추출
                print(f"Received UID: {uid}")

                # 서버로 UID 데이터 전송
                url = 'http://192.168.179.1//NodeMCU-and-RFID-RC522-IoT-Projects/calculate/demo/buy_getUID.php'
                data = {'uid': uid}

                try:
                    response = requests.post(url, data=data)  # 서버에 데이터 전송
                    print(f"Server response: {response.text}")  # 서버 응답 출력
                    # break  # 이 줄을 주석 처리하여 루프를 종료하지 않음
                except requests.exceptions.RequestException as e:
                    print(f"Error sending data to server: {e}")
                    # break  # 에러 발생 시에도 루프를 종료하지 않음
            else:
                print("No UID data received.")

        except UnicodeDecodeError as e:
            print(f"Error decoding data: {e}")

    time.sleep(1)  # 1초 대기 후 다시 시도

import serial
import time
import sys

print("Python script started")
print(sys.argv)  # 전달된 인자 확인

# 아두이노 연결
arduino = serial.Serial('COM5', 9600)  # Windows
# arduino = serial.Serial('/dev/ttyUSB0', 9600)  # Linux

time.sleep(2)  # 아두이노와의 연결 대기

with open('C:\\APM\\Apache24\\htdocs\\NodeMCU-and-RFID-RC522-IoT-Projects\\log.txt', 'a') as f:
    f.write("Reached point A\n")


def rotate_motor():
    arduino.write(b'c')  # 아두이노에 'c' 명령 전송
    print("모터를 90도로 회전시킵니다.")

try:
    rotate_motor()  # 한 번만 호출하여 모터를 회전
except KeyboardInterrupt:
    print("프로그램 종료.")
finally:
    arduino.close()  # 아두이노 연결 종료
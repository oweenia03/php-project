---
layout: post
title: RFID를 이용한 도난 방지 무인 편의점
categories: contest
tags: [MEIT, PHP, Mysql, Arduino, WEB] 
---

![banner](https://github.com/oweenia03/owen/blob/main/_site/assets/images/Intro_Tagon.jpg)

## 주제 소개

| Motivation             | Purpose            |
|:-----------------------:|:---------------------:|
| ![motivation](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_motivation.png)   | ![purpose](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_purpose.png)   |

무인 매장 절도 범죄를 방지하고자 **rfid를 이용한 도난 방지 무인 편의점 구축** 프로젝트를 진행함  
이 아이디어는 **세 가지 목적**을 지님

**1. ALL in One :** 재고 파악/ 관리 / 도난 시도 조회를 하나의 웹사이트에서 한번에  
**2. Just Drop & Pay :** 간편한 결제 과정  
**3. Secure, Every Time :** 미결제 상품 지나갈시 출입구 보안장치 활성화

<br>

## 매커니즘

![](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_process.png)
<br>

<br>

## HW

| 3D printing<br>핸드 리더기 제작            | 최종 핸드 리더기               |
|:-----------------------:|:---------------------:|
| ![3D](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_3d.png)   | ![arduino_hand_reader](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_hw_hand.png)   |
| 계산대                | 출입구               |
|||
| ![arduino_calculate_reader](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_hw_calculate.png) | ![arduino_motor_reader](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_hw_motor.png)   |

> AUtoCAD를 사용해 리더기 모델을 제작하고, 3D 프린터로 출력함<br>리더기에 on/off 버튼과 LED 표시등 장착함
>
> 계산대에서 RFID 태그가 인식되면 부저 소리가 울리게 함   
> 출입문은 서보 모터로 자동 개폐됨

<br>

## SW
### arduino
    * 공통 기능 - uid 읽고 시리얼통신으로 uid 전송
1. handgun_led.ino : 버튼 on/off, led 기능 
2. uid_read.ino : uid 인식 시 부저 기능
3. read_motor_final.ino : 파이썬 스크립트로부터 명령 받아 모터 작동
<br>

### php / Mysql

![](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_sw.png)

    * 이 외 기타 코드
    1. login.php / logout.php / users.sql
    2. user data edit page.php / user data delete page.php<br><br>



### python
  1. 아두이노 시리얼 포트에서 uid 값을 찾아서 이를 php 서버에 전송함
        * first_uid.py / calculate_uid.py / motor_uid.py  
    <br>
  2. 아두이노 서보모터에 개폐 명령을 내림
        * motor_open.py / motor_close.py

<br>

## 결과물 
### 현장
* 시연 환경
![](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_result_1.png)

* 전처리 과정
![Sample GIF](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_gif_handreader.gif)
<br>

* 계산 과정
  
![Sample GIF](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_video_calculate.gif)
![](https://github.com/oweenia03/owen/blob/main/_site/assets/images/calculate_datatable.png)
<br>
<br>

* 모터 작동 과정
![Sample GIF](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_gif_motor.gif)

<br>

### 웹사이트

| 물건 정보 입력            | 재고 정보             |
|:-----------------------:|:---------------------:|
| ![registration form](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_registration.png)   | ![stock data table](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_stock_data_table.png)   |
| 재고 정보 수정 / 삭제              | 재고 검색               |
||||
| ![edit stock data](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_edit_stock_data.png) | ![search stock data](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_search_stock.png)   |
| 태그 읽기             | 태그 읽기 결과              |
||||
| ![read tag](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_scan_tag.png) | ![read tag result](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_scan_tag_result.png)   |
| 모터 기록 조회          | 모터 기록 검색            |
||||
| ![read motor data](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_motor_data.png) | ![search motor data](https://github.com/oweenia03/owen/blob/main/_site/assets/images/meit_motor_search.png)   |



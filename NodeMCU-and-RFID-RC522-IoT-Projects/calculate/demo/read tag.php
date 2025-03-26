<!DOCTYPE html>
<html>
<head>
    <title>Kiosk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="colors.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // buy_UIDcontainer.php의 UID를 주기적으로 로드
            $("#getUID").load("buy_UIDcontainer.php");
            setInterval(function() {
                $("#getUID").load("buy_UIDcontainer.php");
            }, 500);

            // like 버튼 클릭 이벤트 처리
            $('.like-review').click(function() {
                $(this).toggleClass('liked'); // 클릭 시 liked 클래스 추가/제거

                // UID를 가져오기
                var uid = $('#getUID').text().trim();
                if (uid) {
                    // AJAX 요청으로 DB 업데이트
                    $.ajax({
                        type: "POST",
                        url: "update.php", // 데이터베이스 업데이트를 처리할 PHP 파일
                        data: { uid: uid },
                        success: function(response) {
                            alert('Stock status updated!'); // 성공 메시지
                            // tagged products 초기화
                            $('#show_user_data table').find("tr:gt(0)").remove(); // 기존 데이터 삭제
                        },
                        error: function() {
                            alert('Error updating stock status.'); // 에러 메시지
                        }
                    });
                } else {
                    alert('No UID found.');
                }
            });
        });
    </script>
    <style>
        .btn-secondary.liked {
            color: #c0392b; /* 좋아요 눌렀을 때 색상 */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #10a0c5;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1 style="color: navy; font-family: 'Sunflower', sans-serif !important;">Tag-On : Kiosk</h1>

    <input id="night_day" type="button" value="night" onclick="nightDayHandler(this);">

    <div id="grid">
        <ul>
            <img src="왼송이.png" id="kawai-image">
            <br>
            <li style="color: navy; font-family: 'Sunflower', sans-serif !important;">💙Sookmyung Store</li>
            <br><br>

            <footer>
                &copy; <?php echo date("Y"); ?> Tag-On
            </footer>
            <br>
        </ul>

        <div>
            <br>
            <p><strong>Please Scan Tag to Display Product Data</strong></p>

            <div id="show_user_data">
                <table aria-labelledby="user-data-title">
                    <caption id="user-data-title">Product Data</caption>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Expiration Date</th>
                        <th>Stock Status</th>
                    </tr>
                    <!-- UID 데이터가 추가될 위치 -->
                </table>
            </div><br>
            
            <div class="like-content">
                <button class="btn-secondary like-review">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Calculate stock
                </button>
            </div>
        </div>

        <div id="getUID" style="display: none;"></div>

        <script>
            // getUID에서 UID를 받아와서 show_user_data에 출력
            $(document).ready(function() {
                setInterval(function() {
                    var uid = $('#getUID').text().trim(); // UID 가져오기
                    if (uid) {
                        $.ajax({
                            type: "POST",
                            url: "read tag user data.php",
                            data: { uid: uid },
                            success: function(response) {
                                // 기존 데이터 삭제 후 새 데이터 추가
                                var data = JSON.parse(response);
                                var tableRows = '';
                                data.forEach(function(item) {
                                    tableRows += '<tr>';
                                    tableRows += '<td>' + item.id + '</td>'; // item 객체에서 id 속성 참조
                                    tableRows += '<td>' + item.uname + '</td>'; // item 객체에서 uname 속성 참조
                                    tableRows += '<td>' + item.price + '</td>'; // item 객체에서 price 속성 참조
                                    tableRows += '<td>' + item.Expiration + '</td>'; // item 객체에서 Expiration 속성 참조
                                    tableRows += '<td>' + item.stock_status + '</td>'; // item 객체에서 stock_status 속성 참조
                                    tableRows += '</tr>';
                                });
                                $('#show_user_data table').find("tr:gt(0)").remove(); // 기존 데이터 삭제
                                $('#show_user_data table').append(tableRows); // 새 데이터 추가
                            }
                        });
                    }
                }, 1000);
            });
        </script>
    </div>
</body>
</html>

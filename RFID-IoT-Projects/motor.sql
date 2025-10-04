CREATE TABLE `motor_table` (
  `num` int AUTO_INCREMENT NOT NULL,
  `id` varchar(100) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `price` varchar(15) NOT NULL,
  `Expiration` date NOT NULL,
  `stock_status` char(1) NOT NULL,
  `recognized_time` DATETIME NOT NULL,  -- UID가 인식된 시간을 저장하는 컬럼 추가
  PRIMARY KEY (`num`)  -- PRIMARY KEY를 num에 유지
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- utf8mb4로 통일

INSERT INTO `motor_table` (`id`, `uname`, `price`, `Expiration`, `stock_status`, `recognized_time`) VALUES
('866080F8', 'Ramen', '1800', '2026-01-01', 'N', NOW());

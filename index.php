<?php
// Thông số kết nối của bạn
$host = 'localhost';
$db   = 'thuchaoumct3_demo';
$user = 'thuchaoumct3_demo'; // Thử đổi thành 'thuchaoumct3' nếu code này báo lỗi
$pass = 'FMi66hmrtLe5Ax1W';
$port = '3306';

echo "<h2>Đang kiểm tra kết nối Database...</h2>";

try {
    $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    echo "<b style='color:green;'>✅ Kết nối THÀNH CÔNG!</b><br>";
    
    // Kiểm tra xem có bảng sessions không
    $query = $pdo->query("SHOW TABLES LIKE 'sessions'");
    if ($query->rowCount() > 0) {
        echo "✅ Tìm thấy bảng 'sessions'.";
    } else {
        echo "<b style='color:orange;'>⚠️ Kết nối được nhưng không tìm thấy bảng 'sessions'.</b>";
    }

} catch (\PDOException $e) {
    echo "<b style='color:red;'>❌ Kết nối THẤT BẠI:</b> " . $e->getMessage();
}
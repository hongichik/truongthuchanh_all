<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Admin - Authentication Required</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .icon {
            font-size: 64px;
            margin-bottom: 20px;
            color: #667eea;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .message {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .date-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .hint {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
        .password-format {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 12px;
            margin: 15px 0;
            font-family: monospace;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="icon">🔐</div>
        <h1>Master Admin Access</h1>
        <div class="message">{{ $message }}</div>
        
        <div class="date-info">
            <strong>Ngày hiện tại:</strong> {{ $date }}
        </div>
        
        <div class="password-format">
            <strong>Password format:</strong> MD5(hong + ngày/tháng/năm)<br>
            <small>Ví dụ: MD5("hong3/5/2026")</small>
        </div>
        
        <a href="javascript:history.back()" class="btn">← Quay lại</a>
        
        <div class="hint">
            Mật khẩu được tạo mới mỗi ngày<br>
            Liên hệ admin nếu cần hỗ trợ
        </div>
    </div>
</body>
</html>
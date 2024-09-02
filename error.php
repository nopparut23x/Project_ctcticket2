<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อผิดพลาด - 404</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }

        .error-icon {
            font-size: 120px;
            color: #dc3545;
        }

        .error-title {
            font-size: 96px;
            margin: 0;
            font-weight: bold;
            color: #343a40;
        }

        .error-message {
            font-size: 24px;
            color: #495057;
            margin-bottom: 20px;
        }

        .error-description {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-custom-secondary {
            background-color: #6c757d;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-custom-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
        }

        hr {
            width: 50%;
            border: 0;
            border-top: 1px solid #dee2e6;
            margin: 20px 0;
        }

        .footer-note {
            font-size: 14px;
            color: #6c757d;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container error-page">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 class="error-title">404</h1>
        <p class="error-message">ขออภัย, เนื่องจากเกิดข้อผิดพลาดในระบบ</p>
        <p class="error-description">หน้าอาจถูกลบ หรือ URL อาจผิดพลาด โปรดตรวจสอบอีกครั้ง หรือ ติดต่อผู้ดูแลระบบ</p>

        <a href="/" class="btn btn-custom">กลับไปยังหน้าแรก</a>
        <hr>
        <a href="https://www.ctc86years.com/support" class="btn btn-custom-secondary mt-2">ติดต่อฝ่ายสนับสนุน</a>
        <p class="footer-note">© 2024 บริษัทของเรา. สงวนสิทธิ์ทั้งหมด.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>

</html>
<?php
// รายชื่อ URL ของ JSON
$urls = [

    "http://45.144.167.141:82/server/online_app.json",
    "http://199.21.172.201:82/server/online_app.json",
    "http://117.18.124.118:82/server/online_app.json",
    "http://116.206.127.122:82/server/online_app.json",
    "http://64.49.14.154:82/server/online_app.json"
];

// ฟังก์ชันสำหรับดึงข้อมูล JSON จาก URL พร้อมการเช็คการเชื่อมต่อไม่เกิน 5 วินาที
function fetch_json($url) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5, // กำหนด timeout เป็น 5 วินาที
        ]
    ]);
    $json = @file_get_contents($url, false, $context);
    return $json === false ? null : json_decode($json, true);
}

// เก็บข้อมูลทั้งหมด
$all_data = [];
$server_names = [

    "CAT 1",
    "CAT 2",
    "CAT 3",
    "Visper1",
    "SG 1"
];

// ตัวแปรสำหรับเก็บจำนวนคนออนไลน์ทั้งหมด
$total_online = 0;

// ดึงข้อมูลจากแต่ละ URL
foreach ($urls as $index => $url) {
    $data = fetch_json($url);
    if ($data === null) {
        echo "<div class='server-error'>Server " . htmlspecialchars($server_names[$index]) . " is not online.<br>(URL: $url)</div>";
    } else {
        foreach ($data as $item) {
            $item['server_name'] = $server_names[$index]; // กำหนดชื่อเซิร์ฟเวอร์
            $all_data[] = $item;
            // เพิ่มจำนวนคนออนไลน์ในแต่ละเซิร์ฟเวอร์เข้าไปในตัวแปร $total_online
            $total_online += (int)$item['onlines'];
        }
    }
}

// แสดงผลข้อมูลในรูปแบบ HTML พร้อม CSS
echo "<html lang='th'>
<head>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 800px;
            width: 100%;
        }

        h1 {
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 10px;
            font-size: 14px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        li:hover {
            transform: translateY(-3px);
        }

        .server-name {
            font-weight: bold;
            color: #2c3e50;
        }

        .online-count {
            color: #e74c3c;
        }

        .limit-count {
            color: #2980b9;
        }

        .available-slots {
            color: #27ae60;
        }

        .total-online {
            margin-top: 20px;
            padding: 15px;
            background: #dff0d8;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            color: #3c763d;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        .server-error {
            padding: 15px;
            background-color: #ffcccc;
            color: #ff0000;
            border-radius: 6px;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
                max-width: 90%;
            }

            h1 {
                font-size: 20px;
            }

            li {
                padding: 10px;
                font-size: 12px;
            }

            .total-online {
                font-size: 14px;
            }

            .server-error {
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class='container'>
        <h1>ข้อมูลเซิร์ฟเวอร์ออนไลน์</h1>
        <ul>";
foreach ($all_data as $server) {
    if (isset($server['server_name']) && isset($server['onlines']) && isset($server['limite'])) {
        $available_slots = (int)$server['limite'] - (int)$server['onlines']; // คำนวณจำนวนช่องว่างที่เหลือ
        echo "<li><span class='server-name'>ชื่อเซิร์ฟเวอร์:</span> " . htmlspecialchars($server['server_name']) . "<br>
                 <span class='server-name online-count'>จำนวนออนไลน์:</span> " . htmlspecialchars($server['onlines']) . " คน<br>
                 <span class='server-name limit-count'>จำกัด:</span> " . htmlspecialchars($server['limite']) . " คน<br>
                 <span class='server-name available-slots'>ว่าง:</span> " . htmlspecialchars($available_slots) . " คน</li>";
    }
}
echo "    </ul>
        <div class='total-online'>จำนวนคนออนไลน์ทั้งหมด: $total_online คน</div>
    </div>
</body>
</html>";
?>

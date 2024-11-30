<?php
ob_start(); // تفعيل التخزين المؤقت للإخراج

$participant_id = $_GET['participant_id'];
$conn = new mysqli('localhost', 'root', '', 'tournament_db');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استرجاع اسم المشارك
$participant_query = "SELECT name FROM participants WHERE id = $participant_id";
$participant_result = $conn->query($participant_query);
if ($participant_result->num_rows > 0) {
    $participant = $participant_result->fetch_assoc();
    $participant_name = $participant['name'];
} else {
    die("لم يتم العثور على المشارك.");
}

// استرجاع مجموع النقاط من جدول "scores" لكل مسابقة
$scores_query = "SELECT event_id, SUM(points) as total_points FROM scores WHERE participant_id = $participant_id GROUP BY event_id";
$scores_result = $conn->query($scores_query);

// التحقق من نتيجة الاستعلام
if (!$scores_result) {
    die("فشل الاستعلام: " . $conn->error);
}

// عرض النتيجة
if ($scores_result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h2 class='mt-4 text-center'>نتائج المتسابق: $participant_name</h2>";
    echo "<table class='table table-bordered mt-4'>";
    echo "<thead class='thead-dark'><tr><th>المسابقة</th><th>النقاط</th></tr></thead>";
    echo "<tbody>";

    $total_score = 0; // متغير لحساب المجموع الكلي للنقاط

    while ($score = $scores_result->fetch_assoc()) {
        $event_id = $score['event_id'];
        $total_points = $score['total_points'];
        $total_score += $total_points; // حساب المجموع الكلي للنقاط

        // تغيير أسماء المسابقات بناءً على event_id
        switch ($event_id) {
            case 1:
                $event_name = "مسابقة العلوم";
                break;
            case 2:
                $event_name = "مسابقة الرياضيات";
                break;
            case 3:
                $event_name = "مسابقة التاريخ";
                break;
            case 4:
                $event_name = "مسابقة الجغرافيا";
                break;
            case 5:
                $event_name = "مسابقة الثقافة العامة";
                break;
            default:
                $event_name = "مسابقة غير معروفة";
        }

        // عرض النتيجة لكل مسابقة في صف جدول
        echo "<tr><td>$event_name</td><td>$total_points</td></tr>";
    }

    echo "</tbody>";
    echo "<tfoot class='table-success'><tr><th>المجموع الكلي</th><th>$total_score</th></tr></tfoot>"; // عرض المجموع الكلي
    echo "</table>";
    echo "</div>";
} else {
    echo "<p class='text-danger text-center'>لم يتم العثور على نتائج.</p>";
}

// عرض العشرة الأوائل
$top_10_query = "SELECT p.name, SUM(s.points) as total_score 
                 FROM participants p 
                 JOIN scores s ON p.id = s.participant_id 
                 GROUP BY p.id 
                 ORDER BY total_score DESC 
                 LIMIT 10";
$top_10_result = $conn->query($top_10_query);

if ($top_10_result->num_rows > 0) {
    echo "<div class='container mt-5'>";
    echo "<h2 class='text-center'>أفضل 10 متسابقين</h2>";
    echo "<table class='table table-bordered mt-4'>";
    echo "<thead class='thead-dark'><tr><th>اسم المتسابق</th><th>المجموع الكلي</th></tr></thead>";
    echo "<tbody>";

    while ($top_10 = $top_10_result->fetch_assoc()) {
        $top_name = $top_10['name'];
        $top_total_score = $top_10['total_score'];

        // عرض النتائج في جدول
        echo "<tr><td>$top_name</td><td>$top_total_score</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p class='text-danger text-center'>لا يوجد متسابقين في القائمة العشرة الأوائل.</p>";
}

ob_end_flush(); // تعطيل التخزين المؤقت للإخراج
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتائج المسابقات</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to left, aqua, pink);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: black;
            font-weight: bold;
        }
        .table {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            border: 2px solid;
        }
        .table:hover {
            transform: scale(1.02);
        }
        .table-success {
            background-color: #28a745;
            color: color(srgb red green blue);
        }
        .table-dark {
            background-color: purple;
            color: black;

        }
        .text-danger {
            color: black;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- سيتم عرض النتائج في الجداول هنا -->
    </div>
</body>
</html>

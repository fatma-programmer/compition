<?php
$participant_id = $_GET['participant_id'] ?? null; // الحصول على participant_id من الرابط

// تحقق من وجود participant_id
if (!$participant_id) {
    die("لا يمكن العثور على المشارك.");
}

$conn = new mysqli('localhost', 'root', '', 'tournament_db');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// إذا تم إرسال النموذج واختيار المسابقات
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_events = $_POST['events'] ?? [];
    foreach ($selected_events as $event_id) {
        $sql = "INSERT INTO participant_events (participant_id, event_id) VALUES ('$participant_id', '$event_id')";
        if (!$conn->query($sql)) {
            echo "خطأ: " . $conn->error;
        }
    }
    header("Location: start_quiz.php?participant_id=$participant_id"); // توجيه إلى صفحة الأسئلة
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختيار المسابقات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffe0f0, #ffffff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }
        .container {
    background-color: white;
    padding: 10px; /* تقليل البادينج */
    border-radius: 15px; /* جعل الزوايا شبه بيضاوية مع تقليل القيم */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border: 3px solid palevioletred; /* إضافة حواف بلون بنفسجي */
    background: linear-gradient(to right, #E6E6FA, #ADD8E6);

}


        .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    height: 400px; /* زيادة ارتفاع الكارد */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 2px solid transparent; /* إضافة حدود شفافة */
    width: 100%; /* جعل الكارد بملء العرض */
    max-width: 400px; /* تحديد الحد الأقصى للعرض */
}

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            background-color: #f0f8ff; /* تغيير لون الخلفية عند التمرير */
            border: 2px solid palevioletred; /* إضافة حدود ملونة */
        }
        .card img {
            height: 300px; /* تحديد ارتفاع الصورة */
            width: 100%; 
            object-fit: cover; /* استخدام cover */
            border-radius: 10px;
        }
        .btn-primary {
            background-color: purple;
            border:  2px solid palevioletred;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color:darkblue;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .checkbox-label {
            font-size: 18px;
            margin-left: 10px;
        }
        .card-title {
            font-size: 20px; /* زيادة حجم الخط */
            color: #333; /* لون النص */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">اختر المسابقات التي ترغب في المشاركة بها</h2>
        <form method="post" class="row">
            <?php
            // قائمة المسابقات والصور
            $events = [
                ['id' => 1, 'name' => 'مسابقة العلوم', 'image' => 'science.jpg'],
                ['id' => 2, 'name' => 'مسابقة الرياضيات', 'image' => 'math.jpg'],
                ['id' => 3, 'name' => 'مسابقة التاريخ', 'image' => 'history.jpg'],
                ['id' => 4, 'name' => 'مسابقة الجغرافيا', 'image' => 'geography.jpg'],
                ['id' => 5, 'name' => 'مسابقة الثقافة العامة', 'image' => 'general_knowledge.jpg'],
            ];

            foreach ($events as $event) {
                echo "
                <div class='col-md-6'>
                    <div class='card mb-4'>
                        <img src='images/{$event['image']}' alt='{$event['name']}' class='card-img-top'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$event['name']}</h5>
                            <input type='checkbox' name='events[]' value='{$event['id']}'>
                            <label class='checkbox-label'>اختر للمشاركة</label>
                        </div>
                    </div>
                </div>";
            }
            ?>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg mt-4">تسجيل المسابقات</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

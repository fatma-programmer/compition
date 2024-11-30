<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بدء المسابقة</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
      body {
    background-image: url('what_is_a_question_mark.png');
    background-repeat: repeat;
    background-size: 100%; /* تقليل حجم الصورة إلى 50% */
    font-family: 'Arial', sans-serif;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    min-height: 100vh;
    color: black;
}

.container {
    background-color: rgba(255, 255, 255); /* لون خلفية الحاوية مع الشفافية */
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 800px; /* أقصى عرض للحاوية */
    text-align: right;
    border: 2px solid purple;
    margin-bottom: 20px; /* إضافة مساحة أسفل الحاوية */
}


        .event-title {
            font-size: 28px;
            color: #00796b;
            margin: 20px 0;
            border-bottom: 2px solid #00796b;
            padding-bottom: 10px;
        }

        .question-container {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .question-container:hover {
            background-color: #f0f0f0;
        }

        .question-text {
            font-size: 20px;
            color: black;
            margin-bottom: 15px;
        }

        .options {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
        }

        .option {
            margin: 10px 0;
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .option:hover {
            background-color: aquamarine;
            transform: translateY(-2px);
        }

        input[type='radio'] {
            margin-right: 10px;
            cursor: alias;
            accent-color: purple;
        }

        button {
            background-color: #00796b;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 30px;
            width: 100%;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-4">بدء المسابقة</h2>
        
        <?php
        ob_start(); // تفعيل التخزين المؤقت للإخراج

        $participant_id = $_GET['participant_id'];
        $conn = new mysqli('localhost', 'root', '', 'tournament_db');

        // التحقق من الاتصال
        if ($conn->connect_error) {
            die("فشل الاتصال: " . $conn->connect_error);
        }

        // عرض الأسئلة للمسابقات التي اختارها المشارك
        $events_query = "SELECT event_id FROM participant_events WHERE participant_id = $participant_id";
        $events_result = $conn->query($events_query);

        if ($events_result->num_rows > 0) {
            echo "<form method='post'>";
            while ($event = $events_result->fetch_assoc()) {
                $event_id = $event['event_id'];

                // تغيير أسماء المسابقات بناءً على event_id
                switch ($event_id) {
                    case 1:
                        echo "<h3 class='event-title'>مسابقة العلوم</h3>";
                        break;
                    case 2:
                        echo "<h3 class='event-title'>مسابقة الرياضيات</h3>";
                        break;
                    case 3:
                        echo "<h3 class='event-title'>مسابقة التاريخ</h3>";
                        break;
                    case 4:
                        echo "<h3 class='event-title'>مسابقة الجغرافيا</h3>";
                        break;
                    case 5:
                        echo "<h3 class='event-title'>مسابقة الثقافة العامة</h3>";
                        break;
                }

                // استعلام لجلب الأسئلة الخاصة بالمسابقة
                $questions_query = "SELECT * FROM questions WHERE event_id = $event_id";
                $questions_result = $conn->query($questions_query);

                if ($questions_result->num_rows > 0) {
                    while ($question = $questions_result->fetch_assoc()) {
                        echo "<div class='question-container'>";
                        echo "<p class='question-text'>{$question['question_text']}</p>";
                        
                        // عرض الخيارات الثلاثة
                        echo "<div class='options'>";
                        echo "<div class='option'>
                                <input type='radio' name='answers[{$question['id']}]' value='{$question['option_a']}' required>
                                <label>{$question['option_a']}</label>
                              </div>";
                        echo "<div class='option'>
                                <input type='radio' name='answers[{$question['id']}]' value='{$question['option_b']}' required>
                                <label>{$question['option_b']}</label>
                              </div>";
                        echo "<div class='option'>
                                <input type='radio' name='answers[{$question['id']}]' value='{$question['option_c']}' required>
                                <label>{$question['option_c']}</label>
                              </div>";
                        echo "</div>"; // خيارات
                        echo "</div>"; // حاوية السؤال
                    }
                } else {
                    echo "<p>لا توجد أسئلة متاحة لهذه المسابقة.</p>";
                }
            }
            echo "<button type='submit'>إرسال الإجابات</button>";
            echo "</form>";
        }

        // معالجة الإجابات عند إرسال النموذج
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            foreach ($_POST['answers'] as $question_id => $answer) {
                // استرجاع الإجابة الصحيحة
                $correct_answer_query = "SELECT correct_answer FROM questions WHERE id = $question_id";
                $result = $conn->query($correct_answer_query);
                $row = $result->fetch_assoc();
                $correct_answer = $row['correct_answer'];

                // حساب النقاط
                $points = ($answer == $correct_answer) ? 10 : 0; // 10 نقاط للإجابة الصحيحة

                // إدخال النقاط في جدول النقاط
                $sql = "INSERT INTO scores (participant_id, event_id, points) VALUES ('$participant_id', 
                        (SELECT event_id FROM questions WHERE id = $question_id), '$points')";
                $conn->query($sql);
            }

            // توجيه إلى صفحة النتائج
            header("Location: results.php?participant_id=$participant_id");
            exit;
        }

        ob_end_flush(); // تعطيل التخزين المؤقت للإخراج
        ?>
    </div>
</body>
</html>

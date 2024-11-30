<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tournament_db";
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// تنظيف المدخلات
function clean_input($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, $data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = clean_input($_POST['name']);
    $type = clean_input($_POST['type']);
    $members = [];

    // التحقق مما إذا كان نوع المشارك "team"
    if ($type === 'team') {
        $team_name = $name; // اسم الفريق
        // جمع أسماء أعضاء الفريق
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($_POST["member$i"])) {
                $members[] = clean_input($_POST["member$i"]);
            }
        }
        
        // تحويل أعضاء الفريق إلى string لتخزينها في قاعدة البيانات
        $members_string = implode(',', $members);
    }

    // التحقق من ملء جميع الحقول المطلوبة
    if (empty($name) || ($type === 'team' && count($members) < 1)) {
        $message = "يرجى ملء جميع الحقول المطلوبة.";
    } else {
        // إدخال البيانات في جدول المشاركين
        if ($type === 'individual') {
            // إدخال بيانات الفردي
            $password = clean_input($_POST['password']); // كلمة المرور للفردي فقط
            $sql = "INSERT INTO participants (name, type, password) VALUES ('$name', '$type', '$password')";
        } else {
            // إدخال بيانات الفريق
            $sql = "INSERT INTO participants (name, type, members) VALUES ('$team_name', '$type', '$members_string')";
        }
        
        // تنفيذ استعلام الـ SQL والتأكد من نجاحه
        if ($conn->query($sql) === TRUE) {
            $participant_id = $conn->insert_id; // الحصول على ID المشارك
            header("Location: select_events.php?participant_id=$participant_id");
            exit;
        } else {
            $message = "خطأ: " . $sql . "<br>" . $conn->error;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل المشارك</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: url('back1.jpg') no-repeat center center fixed; 
            background-size: cover; 
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            height: 100vh; 
        }

        header {
            background: linear-gradient(to right, #6a0dad, #ff66b3);
            color: white;
            padding: 2px;
            text-align: center;
            height: 90px;
            width: 100%;
            position: fixed; 
            top: 0; /* وضع الهيدر في أعلى الصفحة */
            left: 0;
            z-index: 10;
        }
        header img {
            width: 100px; /* عرض اللوجو */
            height: auto; /* الحفاظ على نسبة العرض والارتفاع */
            margin-bottom: 10px; /* إضافة مسافة بين اللوجو والعنوان */
        }
        header h1 {
            font-size: 5rem; /* زيادة حجم الخط */
            margin: 35px; /* إزالة الهامش */
        }
        .container {
            padding: 10px; /* زيادة الـ padding */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
            max-width: 600px; /* زيادة عرض الفورم */
            width: 100%;
            margin: 40px auto 0; /* توسيط الفورم في الصفحة */
            min-height: 100px; /* زيادة الحد الأدنى للارتفاع */
            border: 2px solid purple; /* إضافة حدود حول الفورم */
            position: relative; /* وضع النسبة لتحديد موقع الإطار */
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9); /* خلفية الفورم مع شفافية */
            border-radius: 10px;
            padding: 20px; /* إضافة padding داخل الفورم */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: black;
            margin-bottom: 30px;
            text-align: center;
        }
        .btn-primary {
            background-color: purple;
            border: black;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #6a0dad;
        }
        .alert {
            margin-bottom: 20px;
        }
        label {
            color: black;
        }
        footer {
            background: linear-gradient(to bottom, #000000, #434343);
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid black;
            height: 45px; /* زيادة ارتفاع حقل الإدخال */
        }
        .form-control:focus {
            border-color: black;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
    </style>
</head>
<body>
    <header>
        <h1 style="font-size:xx-large; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">MIND MARTHON </h1>
    </header>
    
    <div class="container">
        <div class="form-container">
            <h2 class="mt-4">تسجيل المشارك</h2>
            <?php if(isset($message)): ?>
                <div class="alert alert-danger"><?php echo $message; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="type">النوع:</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="">اختر نوع المشارك</option>
                        <option value="individual">فردي</option>
                        <option value="team">فريق</option>
                    </select>
                </div>
                <div class="form-group" id="nameGroup" style="display:none;">
                    <label for="name">الاسم:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group" id="passwordGroup" style="display:none;">
                    <label for="password">كلمة المرور:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group" id="membersGroup" style="display:none;">
                    <label>أعضاء الفريق:</label>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="text" class="form-control mb-2" id="member<?php echo $i; ?>" name="member<?php echo $i; ?>" placeholder="اسم العضو <?php echo $i; ?>" style="display:none;">
                    <?php endfor; ?>
                </div>
                <button type="submit" class="btn btn-primary btn-block">تسجيل</button>
            </form>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2024 بطولة التسجيل. جميع الحقوق محفوظة.</p>
    </footer>

    <script>
        document.getElementById('type').addEventListener('change', function() {
    const membersGroup = document.getElementById('membersGroup');
    const nameGroup = document.getElementById('nameGroup');
    const passwordGroup = document.getElementById('passwordGroup');
    const memberInputs = membersGroup.querySelectorAll('input[type="text"]');

    if (this.value === 'team') {
        nameGroup.style.display = 'block'; // عرض حقل الاسم
        passwordGroup.style.display = 'none'; // إخفاء حقل كلمة المرور
        membersGroup.style.display = 'block'; // عرض أعضاء الفريق
        memberInputs.forEach((input) => {
            input.style.display = 'block'; // عرض حقول الأعضاء
        });
    } else if (this.value === 'individual') {
        nameGroup.style.display = 'block'; // عرض حقل الاسم
        passwordGroup.style.display = 'block'; // عرض حقل كلمة المرور
        membersGroup.style.display = 'none'; // إخفاء أعضاء الفريق
        memberInputs.forEach((input) => {
            input.style.display = 'none'; // إخفاء حقول الأعضاء
        });
    } else {
        nameGroup.style.display = 'none'; // إخفاء حقل الاسم
        passwordGroup.style.display = 'none'; // إخفاء حقل كلمة المرور
        membersGroup.style.display = 'none'; // إخفاء أعضاء الفريق
    }
});

    </script>
</body>
</html>

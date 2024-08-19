<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="loginMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="loginContainer">
        <h2>ログイン</h2>
        <form action="loginMain.php" method="post">
            <div class="group">
                <label for="email">メールアドレス</label>
                <input type="email" name="email" required>
            </div>
            <div class="group">
                <label for="password">パスワード</label>
                <input type="password" id="pass" name="password" required>
                <span class="togglePassword" onclick="togglePasswordVisibility()">
                    <i class="far fa-eye"></i>
                </span>
            </div>
            <button type="submit">ログイン</button>
        </form>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <a href="http://localhost/shopp/script/signUp/signUpMenu.php">新規登録</a>
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('pass');
            const toggleIcon = document.querySelector('.togglePassword i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

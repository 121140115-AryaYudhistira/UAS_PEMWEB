<?php
session_start();
?>
<html>

<head>
    <link rel="stylesheet" href="/assets/css/index.css">
</head>

<body>
    <p style="position: absolute; top:0; left:0; color:white;">Username: ryudhis</p>
    <p style="position: absolute; top:20; left:0; color:white;">Password: 123456</p>
    <form action="login.php" method="post">
        <img src="/assets/img/logo.png" alt="">
        <h2>Login to Toko Barokah</h2>
        <?php if (isset($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; ?> </p>
        <?php }
        unset($_SESSION['error']); ?>
        <label>Username : </label>
        <input class="username" type="textbox" name="username" placeholder="Username">
        <label>Password : </label>
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var usernameInput = document.querySelector('.username'); // Menggunakan querySelector untuk mencari class 'username'

            // Cek apakah cookie ada
            var usernameCookie = getCookie('username');
            if (usernameCookie) {
                window.location.href = 'tokobarokah.php';
            }
        });

        // fungsi fetch cookie berdasarkan username
        function getCookie(name) {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i].trim();
                if (cookie.indexOf(name + '=') === 0) {
                    return cookie.substring(name.length + 1);
                }
            }
            return null;
        }
    </script>
</body>

</html>
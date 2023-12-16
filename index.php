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

    <!-- Pindahkan skrip JavaScript ke bagian bawah sebelum penutup tag </body> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var usernameInput = document.querySelector('.username'); // Menggunakan querySelector untuk mencari class 'username'

            // Check if the 'username' cookie exists
            var usernameCookie = getCookie('username');
            if (usernameCookie) {
                // Pre-fill the username field with the value from the cookie
                window.location.href = 'tokobarokah.php';
            }

            // Check if a success message exists in the session
            var successMessage = '<?php echo isset($_SESSION['success']) ? $_SESSION['success'] : ''; ?>';

            // Display an alert if a success message exists
            if (successMessage.trim() !== '') {
                alert("Login Successful!\n" + successMessage);

                // Clear the success message in the session
                <?php unset($_SESSION['success']); ?>
            }
        });

        // Function to get the value of a cookie by name
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
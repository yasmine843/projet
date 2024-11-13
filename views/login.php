<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk">
        <div class="signup">
            <label for="chk" class="signup-label">Sign Up</label>
            <form id="signup-form" method="POST" action="index.php?action=signup">
                <input type="text" id="signup-username" name="username" placeholder="Username" required>
                <input type="password" id="signup-password" name="password" placeholder="Password" required>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
            </form>
        </div>

        <div class="login">
            <label for="chk" class="login-label">Sign In</label>
            <form id="signin-form" method="POST" action="index.php?action=signin">
                <input type="text" id="signin-username" name="username" placeholder="Username" required>
                <input type="password" id="signin-password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
            </form>
        </div>
    </div>

      <div class="error-message">
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript
    </script>
</body>
</html>

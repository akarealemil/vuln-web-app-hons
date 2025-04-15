<?php
session_start();

$usersFile = '../database/users.json';
$users = json_decode(file_get_contents($usersFile), true);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $parsedPassword = json_decode($password, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $password = $parsedPassword;
    }
    
    $authenticated = false;
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            if (is_array($password) && isset($password['$ne'])) {
                if ($user['password'] !== $password['$ne']) {
                    $authenticated = true;
                    $currentUser = $user;
                    break;
                }
            } else {
                if ($user['password'] === $password) {
                    $authenticated = true;
                    $currentUser = $user;
                    break;
                }
            }
        }
    }
    
    if ($authenticated) {
        session_start();
        $_SESSION['user_id'] = $currentUser['id'];
        $_SESSION['username'] = $currentUser['username'];
        $_SESSION['role'] = $currentUser['role'];
        $_SESSION['email'] = $currentUser['email'];
        
        // Redirect to logged in page
        header("Location: loggedin/loggedin.php");
        exit();
    } else {
        $message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - SnapStorage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            border-radius: 12px 12px 0 0;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--text-bright);
            font-size: 2rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-bright);
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            background-color: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            color: var(--text-color);
            font-family: inherit;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(138, 43, 226, 0.3);
        }
        
        button {
            width: 100%;
            padding: 14px 32px;
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end));
            color: var(--text-bright);
            border: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(75, 0, 130, 0.4);
        }
        
        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(75, 0, 130, 0.6);
        }
        
        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
        }
        
        .success {
            background-color: rgba(0, 128, 0, 0.2);
            border-left: 4px solid #28a745;
            color: #28a745;
        }
        
        .error {
            background-color: rgba(128, 0, 0, 0.2);
            border-left: 4px solid #dc3545;
            color: #dc3545;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-home a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color var(--transition-speed);
        }
        
        .back-to-home a:hover {
            color: var(--accent-hover);
        }
    </style>
</head>
<body>
    <main>
        <div class="login-container">
            <h2>Login to SnapStorage</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $authenticated ? 'success' : 'error'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <div class="back-to-home">
                <a href="/index.php"><i class="fas fa-arrow-left"></i> Back to Homepage</a>
            </div>
        </div>
    </main>
</body>
</html>
<?php
$usersFile = '../../database/users.json';
$users = json_decode(file_get_contents($usersFile), true);

$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    $usernameExists = false;
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            $usernameExists = true;
            break;
        }
    }
    
    if ($usernameExists) {
        $message = "Username already exists!";
        $messageType = "error";
    } else {
        $newId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;
        
        $newUser = [
            'id' => $newId,
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'role' => $role,
            'lastLogin' => date('Y-m-d H:i:s')
        ];
        
        $users[] = $newUser;
        
        file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        
        $message = "User created successfully!";
        $messageType = "success";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New User - SnapStorage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }
        .admin-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffd700;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="password"], input[type="email"], select {
            width: 100%;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #444;
            background-color: #333;
            color: #e0e0e0;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ffd700;
            color: #121212;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 3px;
        }
        .success {
            background-color: rgba(0, 128, 0, 0.3);
            border: 1px solid #006400;
        }
        .error {
            background-color: rgba(128, 0, 0, 0.3);
            border: 1px solid #640000;
        }
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .nav-button {
            padding: 8px 15px;
            background-color: #333;
            color: #e0e0e0;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .restricted-notice {
            background-color: #ff4500;
            color: white;
            padding: 5px 10px;
            text-align: center;
            margin-bottom: 15px;
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="restricted-notice">
            Admin Restricted Area - User Management
        </div>
        
        <h2>Create New User</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="user">User</option>
                    <option value="moderator">Moderator</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            
            <button type="submit">Create User</button>
        </form>
        
        <div class="nav-buttons">
            <a href="login.php" class="nav-button">Back to Login</a>
            <a href="loggedin.php" class="nav-button">Dashboard</a>
        </div>
    </div>
</body>
</html>
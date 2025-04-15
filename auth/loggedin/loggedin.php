<?php
require_once '../../errors/auth_check.php';

require_auth();

$usersFile = '../../database/users.json';
$users = json_decode(file_get_contents($usersFile), true);

$currentUser = null;
foreach ($users as $user) {
    if ($user['id'] === $_SESSION['user_id']) {
        $currentUser = $user;
        break;
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$updateMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newEmail = $_POST['email'];
    
    $targetUserId = isset($_POST['target_user_id']) ? intval($_POST['target_user_id']) : $_SESSION['user_id'];
    
    foreach ($users as $key => $user) {
        if ($user['id'] == $targetUserId) {
            $updatedUser = $user;
            $updatedUser['email'] = $newEmail;
            $users[$key] = $updatedUser;
            
            if ($user['id'] == $_SESSION['user_id']) {
                $_SESSION['email'] = $newEmail;
            }
            break;
        }
    }
    
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
    $updateMessage = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard - SnapStorage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 5px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #444;
        }
        .user-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #2a2a2a;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444;
        }
        th {
            background-color: #333;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .admin {
            background-color: #ff4500;
            color: white;
        }
        .moderator {
            background-color: #4169e1;
            color: white;
        }
        .user {
            background-color: #2e8b57;
            color: white;
        }
        .logout-btn {
            padding: 8px 15px;
            background-color: #cc0000;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px;
            border-radius: 3px;
            border: 1px solid #444;
            background-color: #333;
            color: #e0e0e0;
        }
        button {
            padding: 8px 15px;
            background-color: #ffd700;
            color: #121212;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
            background-color: rgba(0, 128, 0, 0.3);
            border: 1px solid #006400;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h2>SnapStorage Dashboard</h2>
            <a href="?logout=1" class="logout-btn">Logout</a>
        </div>
        
        <?php if (!empty($updateMessage)): ?>
            <div class="alert"><?php echo $updateMessage; ?></div>
        <?php endif; ?>
        
        <div class="user-info">
            <h3>
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                <span class="badge <?php echo strtolower($_SESSION['role']); ?>">
                    <?php echo htmlspecialchars($_SESSION['role']); ?>
                </span>
            </h3>
            <p>Last login: <?php echo htmlspecialchars($currentUser['lastLogin']); ?></p>
        </div>
        
        <h3>Personal Information</h3>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($_SESSION['user_id']); ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?php echo htmlspecialchars($_SESSION['username']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($_SESSION['email']); ?></td>
            </tr>
            <tr>
                <th>Role</th>
                <td><?php echo htmlspecialchars($_SESSION['role']); ?></td>
            </tr>
        </table>
        
        <h3>Update Profile</h3>
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
            </div>
            
            <input type="hidden" name="target_user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
            
            <button type="submit" name="update_profile">Update Profile</button>
        </form>

        <?php if ($_SESSION['role'] === 'admin'): ?>

        <h3>All Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Last Login</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <span class="badge <?php echo strtolower($user['role']); ?>">
                            <?php echo htmlspecialchars($user['role']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($user['lastLogin']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
echo "<h2>Database Error Logs</h2>";
echo "<pre>";
echo "DEBUG: MySQL Error - SELECT * FROM users WHERE username='admin' AND password='admin123';\n";
echo "DEBUG: MySQL Error - SELECT credit_card, cvv FROM payments WHERE user_id=42;\n";
echo "DEBUG: MySQL Dump - INSERT INTO users (id, username, password) VALUES (1, 'admin', 'password123');\n";
echo "</pre>";

echo "<h2>JWT Authentication Tokens</h2>";
echo "<pre>";
echo "JWT_TOKEN=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.signature\n";
echo "JWT_TOKEN=eyJhdWQiOiJzZWNyZXQtYXBwIiwic3ViIjoiYWRtaW4ifQ.signature\n";
echo "</pre>";

echo "<h2>API Keys</h2>";
echo "<pre>";
echo "DEBUG: API_KEY=sk_live_1234567890EXPOSED\n";
echo "DEBUG: API_SECRET=sec_0987654321LEAKED\n";
echo "DEBUG: AWS_ACCESS_KEY_ID=AKIAEXAMPLEACCESSKEY\n";
echo "DEBUG: AWS_SECRET_ACCESS_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY\n";
echo "</pre>";

echo "<h2>System Access Logs</h2>";


echo "<table border='1'>";
echo "<tr><th>Timestamp</th><th>IP Address</th><th>User</th><th>Password</th><th>Hashed Password</th><th>Event</th></tr>";

$logs = [
    [
        "timestamp" => "2025-02-10 14:32:10",
        "ip" => "192.168.1.100",
        "user" => "admin",
        "password" => "admin123",
        "hashed_password" => password_hash("admin123", PASSWORD_DEFAULT),
        "user_agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64)",
        "event" => "Successful login"
    ],
    [
        "timestamp" => "2025-02-10 14:34:22",
        "ip" => "10.0.0.5",
        "user" => "test_user",
        "password" => "testpassword",
        "hashed_password" => md5("testpassword"),
        "user_agent" => "curl/7.68.0",
        "event" => "Failed login attempt"
    ],
    [
        "timestamp" => "2025-02-10 14:35:45",
        "ip" => "127.0.0.1",
        "user" => "root",
        "password" => "rootpassword",
        "hashed_password" => hash("sha256", "rootpassword"),
        "user_agent" => "PostmanRuntime/7.29.2",
        "event" => "Accessing /etc/passwd"
    ],
    [
        "timestamp" => "2025-02-10 14:37:01",
        "ip" => "203.0.113.45",
        "user" => "unknown",
        "password" => "N/A",
        "user_agent" => "SQLMAP/1.5-dev",
        "event" => "Possible SQL Injection Attempt on /login.php"
    ]
];

foreach ($logs as $log) {
    echo "<tr>";
    echo "<td>{$log['timestamp']}</td>";
    echo "<td>{$log['ip']}</td>";
    echo "<td>{$log['user']}</td>";
    echo "<td>{$log['password']}</td>";
    echo "<td>{$log['hashed_password']}</td>";
    echo "<td>{$log['event']}</td>";
    echo "</tr>";
}

echo "</table>";

?>

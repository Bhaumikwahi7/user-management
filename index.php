<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Professional UI Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 40px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .form-section, .dashboard-section {
            padding: 20px;
            border-radius: 10px;
            background: #fff;
        }
        h2 { color: #333; margin-bottom: 20px; border-left: 5px solid #007bff; padding-left: 15px; }
        
        /* Form Design */
        form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        input, select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Poppins';
            font-size: 14px;
        }
        button {
            padding: 12px 25px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        button:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; margin-right: 10px; }

        /* Dashboard Table */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        
        /* Role Badges */
        .badge { padding: 4px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; }
        .badge-admin { background: #ffeeba; color: #856404; }
        .badge-user { background: #d1ecf1; color: #0c5460; }

        #message { margin-top: 15px; font-weight: 500; min-height: 24px; }
    </style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <h2>User Registration</h2>
        <form id="registerForm">
            <input type="text" id="name" placeholder="Full Name" required>
            <input type="email" id="email" placeholder="Email Address" required>
            <input type="password" id="password" placeholder="Password" required>
            <select id="role" required>
                <option value="">Select Role</option>
                <option value="user">Standard User</option>
                <option value="admin">Administrator</option>
            </select>
            <button type="submit" style="grid-column: span 2;">Register Account</button>
        </form>
        <div id="message"></div>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee;">

    <div class="dashboard-section">
        <h2>User Dashboard</h2>
        <div class="controls">
            <button id="showAllBtn" class="btn-secondary">Show All Users</button>
            <button id="adminFilterBtn" class="btn-secondary">Show Only Admins</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                </tbody>
        </table>
    </div>
</div>

<script src="script.js"></script>

</body>
</html>
<?php
session_start();
if (!empty($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if ($email === 'prince@thakurjiassociate.in' && $pass === 'Prince@98379') {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Admin Login – Thakurji Associates</title>
<link rel="icon" type="image/svg+xml" href="../favicon.svg"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#0b1a2e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{background:#fff;border-radius:16px;padding:40px 36px;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
.logo{display:flex;align-items:center;gap:12px;margin-bottom:28px;justify-content:center}
.logo-icon{width:44px;height:44px;background:#d4a843;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:800;color:#0b1a2e}
.logo-text{font-size:15px;font-weight:700;color:#0b1a2e;line-height:1.2}
.logo-text small{display:block;font-size:10px;font-weight:500;color:#7a8fa8;letter-spacing:.5px}
h2{font-size:22px;font-weight:700;color:#0b1a2e;text-align:center;margin-bottom:6px}
p.sub{font-size:13px;color:#7a8fa8;text-align:center;margin-bottom:28px}
.fg{margin-bottom:18px}
label{display:block;font-size:12px;font-weight:600;color:#0b1a2e;letter-spacing:.4px;text-transform:uppercase;margin-bottom:6px}
input{width:100%;padding:12px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-family:'Poppins',sans-serif;outline:none;transition:.2s}
input:focus{border-color:#d4a843;box-shadow:0 0 0 3px rgba(212,168,67,.12)}
.error{background:#fff5f5;border:1px solid #fca5a5;color:#b91c1c;font-size:13px;padding:10px 14px;border-radius:8px;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.btn{width:100%;padding:13px;background:#d4a843;color:#0b1a2e;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;transition:.2s;font-family:'Poppins',sans-serif;margin-top:4px}
.btn:hover{background:#c49a32}
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <div class="logo-icon">T</div>
    <div class="logo-text">THAKURJI ASSOCIATES<small>ADMIN PANEL</small></div>
  </div>
  <h2>Welcome Back</h2>
  <p class="sub">Sign in to view client queries</p>
  <?php if ($error): ?>
  <div class="error"><i class="fa fa-circle-exclamation"></i><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <div class="fg">
      <label>Email</label>
      <input type="email" name="email" placeholder="admin@example.com" required autofocus/>
    </div>
    <div class="fg">
      <label>Password</label>
      <input type="password" name="password" placeholder="••••••••" required/>
    </div>
    <button class="btn" type="submit"><i class="fa fa-right-to-bracket"></i> Sign In</button>
  </form>
</div>
</body>
</html>

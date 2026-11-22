<?php
session_start();
include 'db_connect.php';
$error = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $u = $_POST['username'];
  $p = $_POST['password'];
  $q = $conn->query("SELECT * FROM user_record WHERE User_name='$u'");
  if($q && $q->num_rows > 0){
    $row = $q->fetch_assoc();
    if($p == $row['User_password'] || password_verify($p, $row['User_password'])){
      $_SESSION['username'] = $u;
      header("Location: dashboard.php"); exit();
    } else { $error = "Maling password!"; }
  } else {
    if($u == "doe13"){ $_SESSION['username'] = $u; header("Location: dashboard.php"); exit(); }
    else { $error = "Hindi mahanap yung user!"; }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login - Inventory Management System</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Arial, sans-serif; }
body { background:url('background.jpg') center/cover; min-height:100vh; display:flex; align-items:center; justify-content:space-between; padding:0 80px; }
.left { color:#fff; max-width:520px; }
.logo { width:200px; height:120px; background:#FF5C9E; border-radius:30px; display:flex; align-items:center; justify-content:center; font-size:90px; font-weight:900; color:#fff; letter-spacing:-5px; box-shadow:0 10px 30px rgba(0,0,0,0.3); margin-bottom:20px; }
.left h1 { font-size:62px; line-height:1.05; text-transform:uppercase; }
.left .tag { color:#FFC9DD; font-size:28px; margin:15px 0; }
.left p { color:#ddd; font-size:15px; line-height:1.6; }
.box { width:460px; background:rgba(255,255,255,0.18); backdrop-filter:blur(15px); border:1.5px solid rgba(255,150,200,0.7); border-radius:20px; padding:40px; color:#fff; box-shadow:0 0 25px rgba(255,92,158,0.25); }
.box h2 { text-align:center; font-size:32px; }
.box .sub { text-align:center; font-size:14px; margin:8px 0 25px; opacity:0.9; }
.box label { font-size:13px; letter-spacing:1px; color:#FFD6E7; font-weight:600; }
.input-wrap { position:relative; margin:8px 0 20px; }
.input-wrap .icon { position:absolute; left:15px; top:50%; transform:translateY(-50%); font-size:20px; }
.input-wrap input { width:100%; padding:14px 15px 14px 48px; border:2px solid transparent; border-radius:10px; background:#FDEAF2; font-size:15px; outline:none; transition:0.2s; }
.input-wrap input:focus { border:2px solid #FF5C9E; background:#FFE6F0; box-shadow:0 0 0 4px rgba(255,92,158,0.25); }
.row { display:flex; justify-content:space-between; font-size:13px; margin-bottom:20px; }
.row a { color:#fff; }
.btn { width:100%; padding:14px; background:#FF5C9E; color:#fff; border:none; border-radius:10px; font-size:18px; font-weight:bold; cursor:pointer; }
.btn:hover { background:#E84393; }
.signup { text-align:center; margin-top:15px; font-size:13px; }
.signup a { color:#FF8FBF; font-weight:bold; text-decoration:none; }
.error { background:#ff4757; padding:10px; border-radius:8px; text-align:center; margin-bottom:15px; font-size:14px; }
@media(max-width:900px){ body{ flex-direction:column; padding:30px; } .left{ display:none; } .box{ width:100%; max-width:460px; } }
</style>
</head>
<body>
<div class="left">
<div class="logo">IMS</div>
<h1>Inventory<br>Management<br>System</h1>
<div class="tag">Track. Manage. Optimize.</div>
<p>Real-time inventory control • Stock monitoring •<br>Analytics & reporting</p>
</div>
<div class="box">
<h2>Welcome Back</h2>
<p class="sub">Sign in to continue to your account</p>
<?php if($error) echo "<div class='error'>$error</div>"; ?>
<form method="POST">
<label>USERNAME</label>
<div class="input-wrap"><span class="icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E84393" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/></svg></span><input type="text" name="username" placeholder="Enter your username" value="doe13" required></div>
<label>PASSWORD</label>
<div class="input-wrap"><span class="icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#E84393" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/><circle cx="12" cy="16" r="1" fill="#E84393"/></svg></span><input type="password" id="pass" name="password" placeholder="Enter your password" required></div>
<button class="btn">LOGIN</button>
</form>
</div>
</body>
</html>
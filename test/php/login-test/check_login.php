<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <title></title>
</head>
<body>
   <?php
   session_start();
   $pdo = new PDO('mysql:host=localhost;dbname=librarydb;charset=utf8','mysejong','sj4321');
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      //login.php에서 입력받은 id, password
      $username = $_POST['id'];
      $userpass = $_POST['pw'];
      
      $q = "SELECT * FROM member WHERE mem_id = '$username' AND mem_pw = '$userpass'";
      $result = $pdo->query($q);
      $num = $result->rowCount();
      
      //결과가 존재하면 세션 생성
      if ($num != 0) {
         $row = $result->fetch();
         $_SESSION['username'] = $row['mem_id'];
         $_SESSION['name'] = $row['mem_name'];
         echo "<script>location.replace('index.php');</script>";
         exit;
      }
      
      //결과가 존재하지 않으면 로그인 실패
      if($num == 0){
         echo "<script>alert('Invalid username or password')</script>";
         echo "<script>location.replace('login.php');</script>";
         exit;
      }
   ?>
</body>
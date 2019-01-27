<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$database = "bets";

$con = mysqli_connect($hostname,$username,$password) or die ("connection failed");
mysqli_select_db($con,$database) or die ("error connect database");
session_start();
echo $_SESSION['name'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no" />
<title>USER <?php echo $_SESSION['name']?></title>
<!-- bootstrap-3.3.7 -->
<link rel="stylesheet" href="bootstrap-3.3.7/css/bootstrap.min.css">
<script src="bootstrap-3.3.7/js/bootstrap.min.js"></script>

</head>

Twój stan konta wynosi: <?php
$uzytkownik=$_SESSION['name'];
$uzytkownikID = $con->query("SELECT * FROM users WHERE login = '$uzytkownik'")->fetch_object()->id;
$uzytkownikbalance = $con->query("SELECT balance FROM users WHERE id = '$uzytkownikID'")->fetch_object()->balance;
echo $uzytkownikbalance;

?>
<body>

  <div class="">
      <div class="row">
          <div class="col-xs-6">
              <?php

              if (!empty($_GET['act'])) {

                $obstawienie=$_GET['act'];
                $stary_zaklad=false;
                $wybor = explode("-", $obstawienie); //Rozdzielenie przesłanego value na id zakładu i wybranego ratio.
                $wyborID = $wybor[0];
                $wyborStawki = $wybor[1];
              //  echo "WYBRANO".$wyborStawki ."  ";
                $data = mysqli_query($con,"SELECT * FROM userBets WHERE betsID='$wyborID' AND userID='$uzytkownikID'");
                $data2 = mysqli_query($con,"SELECT * FROM bets WHERE betsID='$wyborID'");
                $row = $data->fetch_assoc();
                $row2 = $data2->fetch_assoc();
                $zysk1 = $row2['rateX'];
                $zysk2 = $row2['rateY'];
              //  echo $row['betsID'];
                if($row['betsID']==0)
                {

                  $stary_zaklad=false;
                }
                else {

                  $stary_zaklad=true;
                }

                if($stary_zaklad==true)
                {
                  echo "Juz obstawiałes coś takiego nie można dwa razy.";

                }
                else {


                //  echo "Obstawiasz graty.";
                  $kasagracza = $uzytkownikbalance - 1000;
                  mysqli_query($con,"UPDATE users SET balance='$kasagracza' WHERE id='$uzytkownikID'");
                //  echo "EEEEEEE".$wyborStawki;
                  if($wyborStawki=='a')
                  {
                    $incik=0;
                    $wygrana = $zysk1*1000;
                    $sql = "INSERT INTO `userbets` (userID,betsID,userChoose,bid,rate) VALUES('" . $uzytkownikID . "', '" . $wyborID . "', '" . $incik . "','" . 1000 . "','". $wygrana ."');  ";
                		echo $result = mysqli_query($con, $sql) or die("error to insert users data");
                  }
                  else {
                    $incik=1;
                    $wygrana = $zysk2*1000;
                    $sql = "INSERT INTO `userbets` (userID,betsID,userChoose,bid,rate) VALUES('" . $uzytkownikID . "', '" . $wyborID . "', '" . $incik . "','" . 1000 . "','". $wygrana ."');  ";
                    echo $result = mysqli_query($con, $sql) or die("error to insert users data");
                  }

                }


              } else {}

echo '
<br>
Do obstawienia
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Kategoria</th>
      <th scope="col">Stawka na druzyne A</th>
      <th scope="col">Stawka na druzyne B</th>
      <th scope="col">Druzyna A</th>
      <th scope="col">Druzyna B</th>
    </tr>
  </thead>
';
$sql = "SELECT betsID,category,rateX,rateY,druzynaA,druzynaB FROM bets";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        echo'
        <tbody>
            <tr>
            <th scope="row">'. $row["betsID"].'</th>
            <td>'. $row["category"].'</td>
            <td>'. $row["rateX"].'</td>
            <td>'. $row["rateY"].'</td>
            <td>'. $row["druzynaA"].'</td>
            <td>'. $row["druzynaB"].'</td>
            <td><form action="gracz.php" method="get">  <input type="hidden" name="act" value="'.$row["betsID"].'-a">  <input type="submit" value="Postaw na '.$row["druzynaA"].'">
</form><td>
<td><form action="gracz.php" method="get">  <input type="hidden" name="act" value="'.$row["betsID"].'-b">  <input type="submit" value="Postaw na '.$row["druzynaB"].'">
</form><td>
          </tr>
        </tbody>
      ';

    }
} else {
    echo "0 results";
}
echo '</table>



          </div>
          <div class="col-xs-6">
          Obstawione
          <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Kategoria</th>
                <th scope="col">Obstawiono</th>
                <th scope="col">Kwota postawiona</th>
                <th scope="col">Mnożnik</th>
                <th scope="col">Do wygrania</th>
              </tr>
            </thead>
            <tbody>';

$sql2 = "SELECT * from users INNER JOIN userbets ON users.id=userbets.userID WHERE id='$uzytkownikID'";
echo $uzytkownikID;
$result2 = $con->query($sql2);
if ($result2->num_rows > 0) {
    while($row = $result2->fetch_assoc()) {
      $betsid=$row["betsID"];
$kategoria = $con->query("SELECT * FROM bets WHERE betsID = $betsid")->fetch_object()->category;

$userchose = $con->query("SELECT * FROM users INNER JOIN userbets WHERE id='$uzytkownikID' AND betsID=$betsid")->fetch_object()->userChoose;

echo'                <tr>
                <th scope="row">'. $row["userbetsID"].'</th>
                <td>'.
                 $kategoria
                 .'</td>
                <td>';

                if($userchose==0)
                {
                  $druzyna=$con->query("SELECT druzynaA FROM bets WHERE betsID = $betsid")->fetch_object()->druzynaA;
                }
                else
                {
                  $druzyna=$con->query("SELECT druzynaB FROM bets WHERE betsID = $betsid")->fetch_object()->druzynaB;
                }

echo $druzyna;
echo
                 '</td>
                 <td>'. $row["bid"].' zł</td>
                <td>';
                if($userchose==0)
                {
                  $druzyna=$con->query("SELECT rateX FROM bets WHERE betsID = $betsid")->fetch_object()->rateX;
                }
                else
                {
                  $druzyna=$con->query("SELECT rateY FROM bets WHERE betsID = $betsid")->fetch_object()->rateY;
                }
                echo $druzyna;
                echo '</td>

                <td>'. $row["rate"].' zł</td>

              </tr>
              ';
            }
              echo '
            </tbody>
            </table>
          </div>
      </div>
  </div>
</div>
</body>
</html>';




}
?>

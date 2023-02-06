<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
</head>
<body>
<?php
    // connexion avec la BD
    $server = "localhost";
    $username = "root";
    $passwd = "";
    $dbname = "loginsystem";

    $conn = new mysqli($server, $username, $passwd, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    ?>
<img src="img/logoS.png" alt="" style="height: 150px; width: 150px;">
  <br><br>
  <form action="LoginSec.php" method="post">
    <label for="id">Username:</label>
    <input type="email" id="id" name="id">
    <br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
  <br><br>
  <input type="reset" value="Reset">
  <input type="submit" value="Valider" name="submit">
  <input type="submit" value="Ajout de compte" name="add">
  </form>

<?php
//boutton valider
if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $password = $_POST['password'];

  //$query = "SELECT * FROM login WHERE id='$id' AND password='$password'";
  //$result = mysqli_query($conn, $query);

    
  $query = "SELECT * FROM login WHERE id='$id'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

      if (password_verify($password, $user['password']))
      {
        // User exists
        echo "<p>Vous êtes connecté</p>";
      }
      else {
        // User does not exist
        echo "<p>Erreur.<br>Recommencé</p>";
      }
  
}
//boutton ajout de compte
if (isset($_POST['add'])) {
  $id = $_POST['id'];
  $password = $_POST['password'];

  $query = "SELECT * FROM login WHERE id='$id'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 0) {
  // User does not exist, insert new user into database
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO login (id, password)
            VALUES ('$id', '$hashed_password')";
    if ((isset($id)) && (isset($password))) {
              mysqli_query($conn, $sql);
    }
      echo "<p>Utilisateur ajouté avec succès</p>";}
  else {
      // User already exists
      echo "<p>Utilisateur déjà existant</p>";
}
}
?>
</body>
</html>
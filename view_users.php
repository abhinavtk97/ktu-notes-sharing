<?php
session_start();
error_reporting(0);
if($_SESSION['admin'])
{
echo '
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="css\bootstrap.min.css">
    <title>View Users</title>
</head>
<style>
    .login-panel {
        margin-top: 150px;
    }
    .table {
        margin-top: 50px;

    }

</style>

<body>
<div class="container">
<div class="table-scrol">
    <h1 align="center">Admin Panel</h1>
    <h2 align="center"><a class="btn btn-primary" href="logout.php">Logout</a></h1>
    <input type="text" onkeyup="myFunction()" id="search" class="form-control" placeholder="Search" autocomplete="off">
<br>
    <center><div  class="btn-group" data-toggle="buttons">
      <label class="btn">
  <p>Search by</p></label>
  <label class="btn btn-primary ">

  <input type="radio" name="ser" value="0" autocomplete="off" checked>Id</label>
  <label class="btn btn-primary">
  <input type="radio" name="ser" value="1" autocomplete="off">Username</label>
  <label class="btn btn-primary active">
  <input type="radio" name="ser" value="2" checked="checked" autocomplete="off">Email</label>
  </div></center>

<div class="table-responsive">

    <table id="allUsers" class="table table-bordered table-hover table-striped" style="table-layout: fixed">
        <thead>

        <tr>

            <th>User Id</th>
            <th>User Name</th>
            <th>User E-mail</th>
            <th>Delete User</th>
            <th>Ban User</th>
            <th>View Books</th>
        </tr>
        </thead>';

        include("conn.php");

        $view_users_query="select * from users";
        $run=mysqli_query($conn,$view_users_query);

        while($row=mysqli_fetch_array($run))
        {
            $user_id=$row[0];
            $user_name=$row[1];
            $user_email=$row[3];

        ?>

        <tr>
            <td><?php echo $user_id;  ?></td>
            <td><?php echo $user_name;  ?></td>
            <td><?php echo $user_email;  ?></td>
            <td><a href="delete.php?del=<?php echo $user_id ?>"><button class="btn btn-danger">Delete</button></a></td>
            <td><a href="ban.php?ban=<?php echo $user_id ?>"><button class="btn btn-danger">Ban</button></a></td>
            <td><a href="view_notes.php?id=<?php echo $user_email ?>"><button class="btn btn-primary">View</button></a></td>
        </tr>

        <?php } ?>

    </table>
        </div>
</div>
</div>
<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, ser;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("allUsers");
  tr = table.getElementsByTagName("tr");
  var radios = document.getElementsByName('ser');

  for (var i = 0, length = radios.length; i < length; i++)
  {
   if (radios[i].checked)
   {
    // do whatever you want with the checked radio
    ser=(radios[i].value);

    // only one radio can be logically checked, don't check the rest
    break;
   }
  }
  console.log(ser);
  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[parseInt(ser)];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>

<?php }
else {
  echo '<html>
  <head lang="en">
      <meta charset="UTF-8">
      <link type="text/css" rel="stylesheet" href="css\bootstrap.min.css">
      <title>View Users</title>
  </head>
  <style>
      .login-panel {
          margin-top: 150px;
      }
      .table {
          margin-top: 50px;

      }

  </style>

  <body>
  <div class="container">

  <h1 align="center">OOPS!!! YOU ARE NOT SUPPOSED TO BE HERE </h1>
  <center><a class="btn btn-danger" href="index.php">Go to Home Page</a></center>
  </div>';
} ?>

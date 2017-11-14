<?php include("conn.php");
error_reporting(0);
session_start();
//$query = "select field1, fieldn from table [where clause][group by clause][order by clause][limit clause]";
function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}
  $i=0;

if( $_GET["sem"] &&$_GET["bra"]) {
  $sem=$_GET['sem'];
  $bra=$_GET["bra"];
  //echo $bra;

  $_SESSION['sem']=$sem;
  $_SESSION['bra']=$bra;
  if($bra=="CSE")
  $bra="Computer Science";
  else if($bra=="MECH")
  $bra="Mechanical";
  else if($bra=="EEE")
  $bra="Electrical";
  else if($bra=="EC")
  $bra="Electronics";
  else if($bra=="CIVIL")
  $bra="Civil";
  if($bra=="S1_S2_Common")
  $head="Sem ".$sem." / S1 and S2";
  else {
    $head="Sem ".$sem." / ".$bra;
  }
  //echo $bra;
  $query = "select name,subject,books.id,path,ups,downs from books where sem='$sem' and branch='$bra'";

   }
     $result = mysqli_query($conn,$query);
 ?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BETTER GRADES</title>
  <meta name="description" content="Get free Class Notes for KTU Engineering Students">
  <meta name="keywords" content="ktu class notes, ktu notes , notes , kerala technological university, engineering notes ">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300|Raleway:300,400,900,700italic,700,300,600">
  <link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/animate.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="dist/bootstrap-tagsinput.css">
  <link rel="stylesheet" type="text/css" href="dist/bootstrap-tagsinput-typeahead.css">

</head>

<body>
  <div class="container">
      <nav class="breadcrumb" dir="ltr">
        <a class="breadcrumb-item" href="index.php"><i class="fa fa-fw fa-home fa-lg"></i> </a>
          <a class="breadcrumb-item" ><?php echo $head  ?></a>
      </nav>

    <div class="row justify-content-end">
      <br>
      <h1 align="center">Search Here</h1>
      <div class="col-xs-12 ">
          <div align="center" class="form-group">

            <div class="btn-group" data-toggle="buttons">
              <label class="btn">
<p>Search by</p></label>
  <label class="btn btn-primary ">

    <input type="radio" name="ser" value="0" autocomplete="off" checked>Name</label>
  <label class="btn btn-primary">
    <input type="radio" name="ser" value="1" autocomplete="off">Subject</label>
    <label class="btn btn-primary active">
      <input type="radio" name="ser" value="2" checked="checked" autocomplete="off">Topic</label>
</div>
<br><br>
        <input type="text" onkeyup="myFunction()" id="search" class="form-control" placeholder="Search" autocomplete="off">
         </div>
      </div>
    </div>
    <div class="table-responsive">
<?php

if (($result)||(mysql_errno == 0))
{
  echo "<table id='maintable' class='table table-hover' ><tr>";
  if (mysqli_num_rows($result)>0)
  {
    echo "<th>Name</th><th>Subject</th><th>Topics</th><th>Download Links</th><th>Ups</th><th>Downs</th><th>Vote</th>";

    echo "</tr>";

    //display the data
    while ($rows = mysqli_fetch_array($result,MYSQL_ASSOC))
    {
      echo "<tr>";
      $xx=0;
      foreach ($rows as $data)
      {
        if($xx==2){
        $qq="";
        $id_temp=$data;
        $query1 = "select title from tags where tag in(select tagid from tagrel where bookid='$data')";
        $result1 = mysqli_query($conn,$query1);
        while ($rows = mysqli_fetch_array($result1,MYSQL_ASSOC)){
          foreach ($rows as $data){
          $qq=$qq." ".$data;
          }
        }
echo "<td>".$qq." </td>";
      }

        else if($xx==3)
        echo "<td ><a href='". $data . "'>Download Here</a></td>";
        else
        echo "<td >".$data."</td>";
        $xx++;
      }
      echo '<td><a href="vote.php?vote=1&id='.$id_temp.'" style="color:green; text-align:left"> <i  class="fa fa-thumbs-o-up"></i></a>  <a style="color:red; text-align:right" href="vote.php?vote=0&id='.$id_temp.'"><i class="fa fa-thumbs-o-down"></i></a></td>';
    }
  }else{
    echo "<tr><td colspan='" . ($i+1) . "'>No Results found!</td></tr>";
  }
  echo "</table>";
}else{
  echo "Error in running query :". mysqli_error();
}
?>



<script src="js/jquery.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/wow.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script src="js/typeahead.js"></script>
<script src="js/custom.js"></script>
<script src="js/myjs.js"></script>
<script src="dist/bootstrap-tagsinput.js"></script>
<script src="dist/bootstrap-tagsinput.min.js"></script>

<script>
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td, i, ser;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("maintable");
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
</body>

</html>

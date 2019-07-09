<?php
// Copyright© 2019 By Fajar Firdaus
// Please Don't recode my program because i take a long time to complete this project
$db = mysqli_connect("localhost", "root", "");
$db1 = mysqli_connect("localhost", "root", "", "project");
$tb = mysqli_query($db1, "SELECT * FROM crud");

if(file_exists("bootstrap.min.css")){

}else{
$css = file_get_contents("https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
$save_css = fopen("bootstrap.min.css", "w+");
fputs($save_css, $css);
fclose($save_css);
}

if(file_exists("./img")){
}else{
    mkdir("img", 0755);
}

if(!$db1){
    mysqli_query($db, "CREATE DATABASE project");
}

if(!$tb){
    mysqli_query($db1, "CREATE TABLE `project`.`crud` ( `id` INT NOT NULL AUTO_INCREMENT , `user` VARCHAR(1000) NOT NULL , `gambar` VARCHAR(1000) NOT NULL , PRIMARY KEY (`id`))");
}

if(isset($_POST['cari-btn'])){
    $user = $_POST['search'];
    $query = mysqli_query($db1, "SELECT * FROM crud WHERE user LIKE '$user'");
    // $query = mysqli_query($db1, "SELECT * FROM crud");
}else{
    $query = mysqli_query($db1, "SELECT * FROM crud");
}

if(isset($_POST['data-baru'])){
    $u = $_POST['user'];
    $g = $_POST['gambar'];

    mysqli_query($db1, "INSERT INTO crud VALUES('', '$u', '$g')");
    if(mysqli_affected_rows($db1) < 0){
        echo "<script>alert('Data Sudah Ada')</script>";
    }else if(mysqli_affected_rows($db1) > 0 ){
        echo "<script>
        alert('Data Berhasil Dimasukan')
        setI
        </script>";
    }
    header("Location: http://localhost");
}

if(isset($_GET['refresh'])){
    header("Location: http://localhost");
}

if(isset($_POST['upload'])){
    move_uploaded_file($_FILES['dir']['tmp_name'], "./img/".$_FILES['dir']['name']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="icon.jpg">
    <link rel="stylesheet" href="http://localhost/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>CRUD By Fajar Firdaus</title>
</head>

<style>
#cari{
    margin-left: 10%;
    width: 35%;
}

#tombol-cari{
    position: absolute;
    margin-left: 45%;
    margin-top: -2.7%;
}

#title{
    position: absolute;
    margin-left: 25%;
    margin-top: -5%;
    width: 45%;
    text-align: center;
}

#name1, label{
    margin-left: 5%;
}

th{
    width: 30%;
}

table{
    margin-top: 5%;
}

#inputdata{
    display: inline;
    position: absolute;
    margin-left: 55%;
    margin-top: -2.7%;
}

#user{
    position: absolute;
}

#gambar{
    position: absolute;
    margin-left: 100%;
}

#refresh{
    position: absolute;
    margin-left: 1%;
}

#data{
    margin-top: 29%;
}

#dir{
    color: transparent;
    background: none;
    font: none;
    overflow: hidden;
    opacity: 0;
}

#lbdir{
    position: absolute;
    margin-left: 55%;
    margin-top: -3%;
}

#up{
    margin-left: 40%;
    margin-top: -7%;
}

#data_img{
    width: 20%;
}

p{
    font: 15px sans-serif;
    text-transform: uppercase;
}

#nameUser{
    position: absolute;
    margin-left: 75%;
    margin-top: -5%;
    width: 15%;
}

#btnname{
    position: absolute;
    margin-left: 31%;
    margin-top: -2%;
    width: 7%
}

#labelgw{
    margin-top: 1%;
    margin-left: 77%;
    position: absolute;
    color: green;
    font: 15px sans-serif
}

#or{
    position: absolute;
    margin-left: 35%;
    margin-top: 1%;
}

</style>

<body>
<p id="labelgw">Copyright© 2019 By Fajar Firdaus</p>
    <div class="jumbotron">

    <label for="name1">Wellcome Back</label><br>
    <h1 id="name1" class="btn btn-primary">User</h1>
    <center>
    <h1 id="title" class="alert alert-primary">CRUD SYSTEM</h1>
    <p id="or">( Create Read Upload Delete ) With Myqli</p>
    </center>
    </div>

    <a id="refresh" class="btn btn-dark" href="?refresh">Refresh</a>

    <form action="" method="post">
    <input type="text" id="cari" autocomplete="off" class="form-control" placeholder="Cari Database" name="search">
    <button id="tombol-cari" type="submit" name="cari-btn" class="btn btn-info">Cari</button>
    </form>

    <form action="" method="post" enctype="multipart/form-data">
    <label for="dir" id="lbdir" class="btn btn-success">Pilih File</label>
    <input type="file" name="dir" id="dir">
    <button type="submit" name="upload" id="up" class="btn btn-danger">Upload</button>
    </form>

    <form id="inputdata" action="" method="post">
    <input type="text" autocomplete="off" name="user" id="user" placeholder="Masukan User" class="form-control">
    <input type="text" autocomplete="off" name="gambar" id="gambar" class="form-control" placeholder="Nama Gambar">
    <button type="submit" name="data-baru" id="data" class="btn btn-warning">Masukan Data Baru</button>
    </form>

    <table border=1 class="table table-dark">
    <tr>
        <th id="id">ID</th>
        <th id="gambaran">Gambar</th>
        <th id="username">User</th>
        <td width="50">Hapus</td>
    </tr>

    <?php $i = 1 ?>
    <?php while($data = mysqli_fetch_assoc($query)){ ?>
    <tr>
        <td><?= $i ?></td>
        <td><img id="data_img" src="./img/<?= $data['gambar'] ?>" alt=""></td>
        <td><p><?= $data['user'] ?></p></td>
        <td><a href="?delete=<?= $data['id'] ?>">Hapus</a></td>
        <?php
        if(isset($_GET['delete'])){
        $del = $_GET['delete'];
        mysqli_query($db1, "DELETE FROM crud WHERE id = $del");
        }
        ?>
    </tr>
    <?php $i++; ?>
    <?php } ?>
    </table>
<script>
var asd = document.geteElementById('nameUser').value;
document.getElementById("name1").innerHTML = "somfsldf"
</script>
</body>
</html>

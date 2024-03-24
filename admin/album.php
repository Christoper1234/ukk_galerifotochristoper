<?php
session_start();
include '../config/koneksi.php';

if ($_SESSION['status'] != 'login') {
  echo "<script>
    alert('Anda Belum Login!');
    location.href='../index.php';
  </script>";
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title> Website Galeri Foto </title>
   <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">

</head>
<body style="background-color:#E7EBF5" >
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: black; box-shadow: 0 0 15px rgba(0, 0, 0, .5);">
  <div class="container">
  <img src="../icongeleri.jpg" style="width:50px"><a class="navbar-brand" href="index.php"><span class="fw-bolder " style="color:red; font-size:35px;">Galeri  </span> <span style="color:blue; text-shadow: 0 0 25px blue, 0 0 4px blue, 0 0 6px blue; font-size:25px;;font-size:40px;">Foto</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home.php" class="nav-link" style="color:blue; text-shadow: 0 0 25px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;"> Home </a>
        <a href="album.php" class="nav-link" style="color:blue; text-shadow: 0 0 25px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;"> Album </a>
        <a href="foto.php" class="nav-link" style="color:blue; text-shadow: 0 0 25px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;"> Foto </a>
      </div>
    
     <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"> Keluar </a>
    </div>
  </div>
</nav>


<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="card mt-2">
        <div class="card-header"style="background-color:#0A2CA1; color:#F5EAED; font-weight:bold; font-size:25px "> Tambah Album </div>
          <div class="card-body" style="background-color:#BAB197 ;">
          <form action="../config/aksi_album.php" method="POST">
            <label class="form-label" style="font-size:15px ;font-weight:bold;"> NamaAlbum</label>
            <input type="text" name="namaalbum" class="form-control" required>
            <label class="form-label" style="font-size:15px ;font-weight:bold;"> Deskripsi </label>
            <textarea class="form-control" name="deskripsi" required></textarea>
            <button type="submit" class="btn btn-primary mt-2" name="tambah"> Tambah Data </button>
          </form>
          </div>
      </div>
    </div>

    <div class="col-md-8">
    <div class="card mt-2">
      <div class="card-header" style="background-color:#0A2CA1; color:#F5EAED; font-weight:bold; font-size:20px;  "> Data Album </div>
        <div class="card-body" style="background-color:#BAB197;">
          <table class="table">
            <thead>
              <tr>
                <th style="background-color:#525252;"> No </th>
                <th style="background-color:#525252;"> Nama Album </th>
                <th style="background-color:#525252;"> Deskripsi </th>
                <th style="background-color:#525252;"> Tanggal</th>
                <th style="background-color:#525252;" > Aksi </th>
              </tr> 
            </thead>
          <tbody>
            <?php
            $no = 1;
            $userid = $_SESSION['userid'];
            $sql = mysqli_query($koneksi, "SELECT * FROM album WHERE userid='$userid'");
            while($data = mysqli_fetch_array($sql)) {
            ?>
             <tr>
                                        <td><?php echo $no++ ?></td>
                                        <td><?php echo $data['namaalbum'] ?></td>
                                        <td><?php echo $data['deskripsi'] ?></td>
                                        <td><?php echo $data['tanggaldibuat'] ?></td>
                                        <td>
        
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['albumid'] ?>"> Edit </button>
                  <div class="modal fade" id="edit<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header" style="background-color:#0A2CA1; color:#F5EAED; box-shadow: 0 0 15px rgba(0, 0, 0, .5);">
                          <h1 class="modal-title fs-5" id="exampleModalLabel"> Edit Data </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body" style="background-color:#C3BAC7">
                          <form action="../config/aksi_album.php" method="POST">
                            <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>">
                            <label class="form-label" style="font-family:arial"> Nama Album </label>
                            <input type="text" name="namaalbum" value="<?php echo $data['namaalbum'] ?>" class="form-control" required>
                            <label class="form-label"  style="font-family:arial"> Deskripsi </label>
                            <textarea class="form-control" name="deskripsi" required>
                            <?php echo $data['deskripsi']; ?>
                            </textarea>
                         </div>
                         <div class="modal-footer" style="background-color:#ADADAD">
                          <button type="submit" name="edit" class="btn btn-primary"> Edit Data </button>
                          </form>
                         </div>
                      </div>
                    </div>
                  </div>
                  
                  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['albumid'] ?>"> Hapus </button>
                  <div class="modal fade" id="hapus<?php echo $data['albumid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header"  style="background-color:#0A2CA1; color:#F5EAED; box-shadow: 0 0 15px rgba(0, 0, 0, .5);">
                          <h1 class="modal-title fs-5" id="exampleModalLabel"> Hapus Data </h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>
                         <div class="modal-body" style="background-color:#C3BAC7">
                          <form action="../config/aksi_album.php" method="POST">
                            <input type="hidden" name="albumid" value="<?php echo $data['albumid'] ?>">
                            Apakah anda yakin ingin menghapus data? <strong> <?php echo $data['namaalbum'] ?> </strong>
                         </div>
                         <div class="modal-footer"  style="background-color:#ADADAD; ">
                          <button type="submit" name="hapus" class="btn btn-primary"> Hapus Data </button>
                          </form>
                         </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  </div>
</div>




<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>

</body>
</html>
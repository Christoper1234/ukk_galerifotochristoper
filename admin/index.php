<?php
session_start();
$userid = $_SESSION['userid'];
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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head> 
<body style="background-color:#E7EBF5">
<nav class="navbar navbar-expand-lg navbar-light" style="background-color:black;  box-shadow: 0 0 15px rgba(0, 0, 0, .5);">
  <div class="container">
  <img src="../icongeleri.jpg" style="width:50px"><a class="navbar-brand" href="index.php"><span class="fw-bolder " style="color:red; font-size:35px;">Galeri  </span> <span style="color:blue; text-shadow: 0 0 25px blue, 0 0 4px blue, 0 0 6px blue; font-size:25px;;font-size:40px;">Foto</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a href="home.php" class="nav-link" style="color:blue; text-shadow: 0 0 25px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;"> Home </a>
        <a href="album.php" class="nav-link" style="color:blue; text-shadow: 0 0 2px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;" > Album </a>
        <a href="foto.php" class="nav-link" style="color:blue; text-shadow: 0 0 1px white, 0 0 4px white, 0 0 6px white; font-size:25px; font-family:arial;" > Foto </a>
      </div>
    
     <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1"> Keluar </a>
    </div>
  </div>
</nav>


<div class="container mt-2">
  <div class="row">
    <?php
    $query = mysqli_query($koneksi, "SELECT * FROM foto");
  while($data = mysqli_fetch_array($query)) {
  ?>

  <div class="col-md-3">
    <a type="button" data-bs-toggle="modal" data-bs-target="#komentar<?php echo $data['fotoid']?>">
    <div class="card">
      <img src="../assets/img/<?php echo $data ['lokasifile'] ?>" class="card-img-top" title="<?php echo $data ['judulfoto']?>"style="height: 12rem;  box-shadow: 10px 10px 35px rgba(0, 0, 10, .5);">
      <div class="card-footer text-center">
         <?php
                    $fotoid = $data['fotoid'];
                    $ceksuka = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    $cekbatalsuka = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid' AND userid='$userid'");
                    if (mysqli_num_rows($ceksuka) == 1) { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-up m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_like.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-up m-1"></i></a>

                    <?php }
                    $like = mysqli_query($koneksi, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($like). ' ';
                    ?>
                    <?php
                    if (mysqli_num_rows($cekbatalsuka) == 1) { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="batalsuka"><i class="fa fa-thumbs-down m-1"></i></a>

                    <?php } else { ?>
                      <a href="../config/proses_unlike.php?fotoid=<?php echo $data ['fotoid'] ?>" type="submit" name="suka"><i class="fa-regular fa-thumbs-down m-1"></i></a>

                    <?php }
                    $unlike = mysqli_query($koneksi, "SELECT * FROM unlikefoto WHERE fotoid='$fotoid'");
                    echo mysqli_num_rows($unlike). ' ';
                    ?>
        <a href=""><i class="fa-regular fa-comment"></i></a>  Komentar
      </div>
    </div>
  </a>
      <!-- Modal -->
      <div class="modal fade" id="komentar<?php echo $data['fotoid'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">gv
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
          <img src="../assets/img/<?php echo $data['lokasifile']?>" class="card-img-top" title="<?php echo $data['judulfoto']?>">
          </div>
          <div class="col-md-4">
            <div class="m-2">
              <div class="overflow-auto">
                <div class="sticky-top">
                  <br><a href="../assets/img/<?php echo $data['lokasifile'] ?>" download="download">Download</a></br>
                  <strong><?php echo $data['judulfoto'] ?></strong>
                  <span class="badge bg-secondary"><?php echo $data['userid'] ?></span>
                  <span class="badge bg-secondary"><?php echo $data['tanggalunggah'] ?></span>
                  <span class="badge bg-primary"><?php echo $data['albumid'] ?></span>
                </div>
                <hr>
                <p align="left">
                  <?php echo $data['deskripsifoto'] ?>
                </p>
                <hr>
                <?php
                $fotoid= $data ['fotoid'];
                $komentar= mysqli_query($koneksi,"SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.UserID=user.UserID WHERE komentarfoto.FotoID='$fotoid'");
                while($row=mysqli_fetch_array($komentar)) { 
                ?>
                <p align="left">  
                  <strong> <?php echo $row ['namalengkap'] ?></strong>
                  <?php echo $row['isikomentar'] ?>
                </p>
                <?php } ?>
                <hr>
                <div class="sticky-bottom">
                  <form action="../config/proses_komentar.php" method="POST">
                    <div class="input-group">
                      <input type="hidden" name="fotoid" value="<?php echo $data['fotoid']?>">
                      <input type="text" name="isikomentar" class="form-control" placeholder="Tambah Komentar">
                      <div class="input-group-prepend"></div>
                      <button type="submit" name="kirimkomentar" class="btn btn-outline-primary">Kirim</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

		</div>
    <?php } ?>

<?php  ?>

  </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
</footer>

<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>
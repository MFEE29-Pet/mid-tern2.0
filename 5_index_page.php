<?php include __DIR__ . '/parts/connect_db.php';
$pageName = 'indexpage';
?>
<?php include __DIR__ . '/parts/index_header.php'; ?>
<style>
  .index_bg {
    background: url('./images/karsten.jpg');
    width: 100%;
    height: 100%;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center 80%;
    display: flex;
    align-items: center;
    justify-content: center;
  }



  .index_box {
    width: 1000px;
  }

  .left {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  h1 {
    font-size: 60px;
    line-height: 80px;
    color: #000;
    font-family: 'Permanent Marker', cursive;
  }

  span {
    font-size: 60px;
    line-height: 80px;
    color: #000;
    font-family: 'Permanent Marker', cursive;
  }

  p {
    font-size: 60px;
    line-height: 80px;
    color: #000;
    font-family: 'Permanent Marker', cursive;
  }
</style>
<?php include __DIR__ . '/parts/index_navber.php'; ?>
<div class="index_bg">
  <div class="index_box">
    <div class="left animate__animated animate__zoomIn">
      <h1 class="animate__animated animate__fadeIn animate__delay-1s">Welcome&nbspTo</h1>
      <p class="animate__animated animate__fadeIn animate__delay-1s">PET&nbspBAN</p>
    </div>
  </div>

</div>
<?php include __DIR__ . '/parts/index_script.php'; ?>
<?php include __DIR__ . '/parts/index_footer.php'; ?>
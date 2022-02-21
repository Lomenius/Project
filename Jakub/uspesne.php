<?php
session_start();
include('udaje.php');
include('funkcie.php');
hlavicka('Objednávka');
include('navigacia.php');
include('db.php');
?>

<section>
<h1>Objednávka bola úspešne odoslaná</h1>
<h2>Budete presmerovaní na hlavnú stránku</h2>
<img src='obrazky/nacitaj.gif'>
<?php    
unset($_SESSION['kosik']);
header("Refresh:4; url='index.php'");
	?>
</section>

<?php
include('pata.php');
?>

<?php
session_start();
include('db.php');
include('udaje.php');
include('funkcie.php');
hlavicka();
include('navigacia.php');
$_SESSION['pole'] = array();
$_SESSION['kos'] = array();


?>
<section>

	<form method="post">
		Zobraziť kategóriu: 
  	<input type="checkbox" name="bolest" value="Bolesť" onclick="this.form.submit();">
	<label for="bolest">Bolesť</label>
  	<input type="checkbox" name="chripka" value="Chrípka" onclick="this.form.submit();">
	<label for="chripka">Chrípka</label>
	<input type="checkbox" name="travenie" value="Trávenie" onclick="this.form.submit();">
	<label for="travenie">Trávenie</label>
	<input type="checkbox" name="zrakasluch" value="Zrak a sluch" onclick="this.form.submit();">
	<label for="zrakasluch">Zrak a sluch</label>
	<input type="checkbox" name="zuby" value="Zuby" onclick="this.form.submit();">
	<label for="zuby">Zuby</label>
	<input type="checkbox" name="alergia" value="Alergia" onclick="this.form.submit();">
	<label for="alergia">Alergia</label>
  </form> 
  <br>
	<form method="post">
		Zoradiť podľa: 
  	<input type="submit" name="nazov1" value="názvu (A-Z)">
  	<input type="submit" name="nazov2" value="názvu (Z-A)">
  	<input type="submit" name="cena1" value="ceny (od najnižšej)">
  	<input type="submit" name="cena2" value="ceny (od najvyššej)">
  </form> 
<?php
vypis_strany($mysqli);
?>
</section>
<?php
include('pata.php');
?>
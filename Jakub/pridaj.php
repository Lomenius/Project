<?php
include('db.php');
include('udaje.php');
include('funkcie.php');
hlavicka();
include('navigacia.php');
?>

<section>
<?php 
$chyby = array();
if (isset($_POST["posli"])) {
	if (isset($_POST['nazov'])) $nazov = osetri($_POST['nazov']); else $nazov = '';	
	if (isset($_POST['popis'])) $popis = osetri($_POST['popis']); else $popis = '';	
	if (isset($_POST['cena'])) $cena = osetri($_POST['cena']); else $cena = '';	
	if (isset($_POST['na_sklade'])) $na_sklade = osetri($_POST['na_sklade']); else $na_sklade = '';	
	if (isset($_POST['skupina'])) $skupina = osetri($_POST['skupina']); else $skupina = '';
	
	if (!nazov_ok($nazov)) $chyby['nazov'] = 'Názov tovaru nemá správnu dĺžku (3-100 znakov)';
	if (empty($nazov)) $chyby['nazov'] = 'Nezadali ste názov';
	if (!popis_ok($popis)) $chyby['popis'] = 'Popis nemá aspoň 10 znakov';
	if (empty($popis)) $chyby['popis'] = 'Nezadali ste popis';
	if (!cena_ok($cena)) $chyby['cena'] = 'Cena musí byť > 0';
	if (empty($cena)) $chyby['cena'] = 'Nezadali ste cenu';
	if (!sklad_ok($na_sklade)) $chyby['na_sklade'] = 'Počet kusov musí byť > 0';
	if (empty($na_sklade)) $chyby['na_sklade'] = 'Nezadali ste počet kusov';
	if (!nazov_ok($nazov)) $chyby['nazov'] = 'Skupina tovaru nemá správnu dĺžku (3-10 znakov)';
	if (empty($nazov)) $chyby['nazov'] = 'Nezadali ste skupinu';
}

if(empty($chyby) && isset($_POST["posli"])) {
	pridaj_tovar($mysqli, $nazov, $popis, $cena, $na_sklade);
} else {
	if (!empty($chyby)) {
		echo '<p class="chyba">Nevyplnili ste všetky povinné údaje (názov, popis, cena, počet kusov na sklade, skupina)</p>';
		echo '<p class="chyba"><strong>Chyby pri pridávaní tovaru</strong>:<br>';
		foreach($chyby as $ch) {
			echo "$ch<br>\n";
		}
		echo '</p>';
	}
?>
	<form method="post">
		<p>
		<label for="nazov">Názov tovaru (3-100 znakov):</label>
		<input type="text" name="nazov" id="nazov" size="30" value="<?php if (isset($_POST['nazov'])) echo $_POST['nazov'] ?>">
		<br>
		<label for="popis">Popis (min. 10 znakov):</label>
		<br>
		<textarea cols="40" rows="4" name="popis" id="popis"><?php if (isset($_POST['popis'])) echo $_POST['popis'] ?></textarea>
		<br>
		<label for="cena">Cena (&gt;0):</label>
		<input type="text" name="cena" id="cena" size="5" maxlength="5" value="<?php if (isset($_POST['cena'])) echo $_POST['cena'] ?>">
		<br>
		<label for="na_sklade">Počet ks na sklade (&gt;0):</label>
		<input type="text" name="na_sklade" id="na_sklade" size="5" maxlength="5" value="<?php if (isset($_POST['na_sklade'])) echo $_POST['na_sklade'] ?>"> 
		<br>
		<label for="skupina">Skupina (3-50):</label>
		<input type="text" name="skupina" id="skupina" size="10" value="<?php if (isset($_POST['skupina'])) echo $_POST['skupina'] ?>">
		<br>
	<input type="submit" name="posli" value="Pridaj tovar">
		</p>  
  </form>
<?php
}
?>	
</section>

<?php
include('pata.php');
?>

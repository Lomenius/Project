<?php
session_start();
include('udaje.php');
include('funkcie.php');
hlavicka('Objednávka');
include('navigacia.php');
include('db.php');
?>

<section>
<?php
$chyby = array();

?>
<h1>Košík</h1>
<legend id=sirka>Obsah košíka:</legend>
 <br><br>

<?php	
if(isset($_SESSION['kosik'])){

 for ($i=0;$i<sizeof($_SESSION['kosik']);$i++){
    $kos=$_SESSION['kosik'][$i];
    if (!$mysqli->connect_errno) {
 		$sql = "SELECT *FROM lekaren_tovar WHERE kod=".'"'.$kos.'"'; 
        if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)){
            $row = $result->fetch_assoc();
                echo '<li id="ohranicenie3" style="list-style: none;">';
            	echo '<h2>'.$row['nazov'].'<br>';
            	echo 'Cena:'.$row["cena"].' € <br> ';
                $naz = "obrazky/".$row['kod'].".jpg";
                if(file_exists($naz)){
                   echo '<img src='.$naz.' width=150 height=130 > '."\n" ;
                        	}
                 echo '</li>';
            $result->free();

        }


 }
 }

if(isset($_POST['vymaz'])){
    unset($_SESSION['kosik']);
    header("Refresh:0; url='objednavka.php'");
}
if (isset($_POST['odosli'])){
    $kos = '';
   for ($i=0;$i<sizeof($_SESSION['kosik']);$i++){
        $kos.= ';'.$_SESSION['kosik'][$i];
        }
  
	 
     
     if ($result = $mysqli->query($sql)) { 

        $mysqli->insert_id;
                 }

	
	$meno = oprav('meno');
	$adresa = oprav('adresa');
	$doprava = oprav('doprava');
	$odberD = oprav('odberD');
	$odberM = oprav('odberM');
	
	if (!spravne_meno($meno)) $chyby['meno'] = 'Meno '.$meno.'nie je v správnom formáte';
	if (empty($meno)) $chyby['meno'] = 'Nezadali ste meno';
	if (!spravna_adresa($adresa)) $chyby['adresa'] = 'Adresa nemá aspoň 10 znakov';
	if (empty($adresa)) $chyby['adresa'] = 'Nezadali ste adresu';
	if (empty($doprava)) $chyby['doprava'] = 'Nezvolili ste dopravu';
	
	
	
     }
     }
else {
	echo  '<h2 id=upozornenie> Košík je prázdny !  </h2>';
}

if(empty($chyby) && isset($_POST["odosli"])){
	$_SESSION["adresa"]=$adresa;
	$_SESSION["meno"]=$meno;
	$_SESSION["odberM"]=$odberM;
	$_SESSION["doprava"]=$doprava;
	$_SESSION["odberD"]=$odberD;
	pridaj_objednavku($mysqli, $_SESSION["meno"], $_SESSION["adresa"], $kos , $_SESSION["doprava"], $_SESSION["odberM"].'-'.$_SESSION["odberD"]);
	header("Refresh:0; url='uspesne.php'");
} else {
	
	if (!empty($chyby)) {
		echo '<p class="chyba">Nevyplnili ste všetky povinné údaje objednávky (meno, adresa, tovar, počet kusov, doprava)</p>';
		echo '<p class="chyba"><strong>Chyby v objednávke</strong>:<br>';

		foreach($chyby as $ch) {
			echo "$ch<br>\n";
		}
		echo '</p>';
}
}

if(isset($_SESSION['kosik'])){
?>
<form method='post'>

<fieldset>
	<legend>Kontaktné údaje</legend>
	<label for="meno">Meno a priezvisko:</label> <input type="text" name="meno" id="meno" size="40" maxlength="30" value="<?php if (isset($meno)) echo $meno; ?>"><br>
	<label for="adresa">Adresa doručenia:</label><br>
	<textarea name="adresa" id="adresa" rows="3" cols="35"><?php if (isset($adresa)) echo $adresa;?></textarea>
</fieldset>
<fieldset>
	<legend>Údaje o objednávke</legend>
	Doprava: 
	<input type="radio" name="doprava" id="doprava_dobierka" value="dobierka"<?php if (isset($doprava) && $doprava=="dobierka") echo ' checked'; ?>> <label for="doprava_kurier">dobierka(+2€)</label>
	<input type="radio" name="doprava" id="doprava_kurier" value="kurier"<?php if (isset($doprava) && $doprava=="kurier") echo ' checked'; ?>> <label for="doprava_taxi">kuriér(+3,50€)</label>
	<input type="radio" name="doprava" id="doprava_vlastna" value="vlastna"<?php if (isset($doprava) && $doprava=="vlastna") echo ' checked'; ?>> <label for="doprava_vlastna">osobný odber</label>
	<br>
	Odber tovaru: 
	<select name="odberD" id="odberD">
<?php 
if (isset($odberD)) 
	vypis_select(1, 31, $odberD); 
else 
	vypis_select(1, 31, date("j")); 
?>
	</select>.
	<select name="odberM" id="odberM">
<?php 
if (isset($odberM)) 
	vypis_select(1, 12, $odberM); 
else 
	vypis_select(1, 12, date("n")); 
?>
	</select> . <?php echo date("Y"); ?><br>

</fieldset>

<input type="submit" name="odosli" value="Odošli objednávku">
<input type="submit"  name="vymaz" value="Zruš obsah košíka"><br>
</form>





<?php
}

?>
</section>

<?php
include('pata.php');
?>

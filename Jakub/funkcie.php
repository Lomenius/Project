<?php
date_default_timezone_set('Europe/Bratislava');

function vypis_select($min, $max, $oznac = -1) {
	for($i = $min; $i <= $max; $i++) {
		echo "<option value='$i'";
		if ($i == $oznac) echo ' selected';
		echo ">$i</option>\n";
	}
}
	
function hlavicka() {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo "Lekáreň Jakub"; ?></title>
<link href="styly.css" rel="stylesheet">
</head>
<body>
<header id=ohranicenie>
<h1><?php echo "Lekáreň Jakub"; ?></h1>
</header>
<?php
}
function ktora_stranka($nadpis){
?>


<h1><?php echo $nadpis; ?></h1>

<?php
}

function vypis_select_tovar($tovar, $oznac = -1) {
	if ($oznac === '') { 
		$oznac = -1; 
	}
	foreach($tovar as $ind => $hodn) {
		echo "<option value='$ind'";
		if ($ind == $oznac) echo ' selected';
		echo ">" . $hodn['nazov'] . ' (' . $hodn['cena'] . " &euro;)</option>\n";
	}
}


function spravne_meno($m) {
  $medzera = strpos($m, ' ');
  if (!$medzera) return false;       
  $priezvisko = substr($m, $medzera+1);  
  return ($medzera > 2 && (strpos($priezvisko, ' ') === FALSE) && strlen($priezvisko) > 2);
}


function spravna_adresa($a) {
  return strlen($a) >= 10;
}

function oprav($co) {
	if (isset($_POST[$co]))
		return addslashes(trim(strip_tags($_POST[$co])));
	else return '';
}


function osetri($co) {
	return trim(strip_tags($co));
}

function nazov_ok ($nazov) {
	return strlen($nazov) >= 3 && strlen($nazov) <= 100;
}

function popis_ok ($popis) {
	return strlen($popis) >= 10;
}

function cena_ok ($cena) {
	return ($cena) > 0;
}

function sklad_ok ($sklad) {
	return (1 * $sklad) > 0;
}


function pridaj_tovar($mysqli, $nazov, $popis, $cena, $na_sklade) {
	if (!$mysqli->connect_errno) {
		$nazov = $mysqli->real_escape_string($nazov);
		$popis = $mysqli->real_escape_string($popis);
		$cena = $mysqli->real_escape_string($cena);
		$na_sklade = $mysqli->real_escape_string($na_sklade);

		$sql = "INSERT INTO lekaren_tovar SET nazov='$nazov', popis='$popis', cena='$cena', na_sklade='$na_sklade'"; // definuj dopyt
	
		if ($result = $mysqli->query($sql)) { 
 	    echo '<p>Tovar s kódom <strong>'. $mysqli->insert_id .'</strong> bol pridaný.</p>'. "\n"; 
		} elseif ($mysqli->errno) {
			echo '<p class="chyba">Nastala chyba pri pridávaní tovaru. (' . $mysqli->error . ')</p>';
		}
	}
}	

function pridaj_objednavku($mysqli, $meno, $adresa, $tovar, $doprava, $datum_odberu) {
	if (!$mysqli->connect_errno) {
		$meno = $mysqli->real_escape_string($meno);
		$adresa = $mysqli->real_escape_string($adresa);
		$tovar = $mysqli->real_escape_string($tovar);
		$doprava = $mysqli->real_escape_string($doprava);
		$doprava = $mysqli->real_escape_string($doprava);

		$sql = "INSERT INTO lekaren_objednavky SET meno='$meno', adresa='$adresa', tovar='$tovar', doprava='$doprava', datum_odberu='$datum_odberu'"; // definuj dopyt
	
		if ($result = $mysqli->query($sql)) {  
 	    echo '<p>Objednávka bola pridaná</p>'. "\n"; 
		} elseif ($mysqli->errno) {
			echo '<p class="chyba">Nastala chyba pri objednávaní tovaru. (' . $mysqli->error . ')</p>';
		}
	}
}	




function vypis_tovar_uprav_zrus($mysqli) {
?>
	<p><a href="pridaj.php">pridaj tovar</a></p>
<?php
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM lekaren_tovar ORDER BY nazov ASC";
		if ($result = $mysqli->query($sql)) { 
		
			echo '<form method="post">';
			echo '<p>'; 
			while ($row = $result->fetch_assoc()) {
    		echo "<input type='checkbox' name='tovar[]' value='{$row['kod']}' id='tovar{$row['kod']}'><label for='tovar{$row['kod']}'>{$row['nazov']}</label><br>\n";
			} 
			echo '</p>'; 
  		echo '<p><input type="submit" name="zrus" value="Zruš tovary"></p>';
  		echo '</form>';
			$result->free();
  	} else {
			
    	echo '<p class="chyba">Nastala chyba pri získavaní údajov z DB.</p>' . "\n";
    }
	}
}



function vypis_kosik($vyrobky) {
	echo '<p><strong>Obsah košíka:</strong></p>';
	echo '<p>Adresa doručenia: ' . $_SESSION["adresa"] . '</p>';
	echo '<p>Tovar: <strong>' . $vyrobky[$_SESSION["tovar"]]['nazov'] . '</strong> v počte kusov <strong>' . $_SESSION["pocet"] . '</strong></p>';
	echo '<p>Cena: ' . ($vyrobky[$_SESSION["tovar"]]['cena']*$_SESSION["pocet"]) . ' &euro;</p>'; 

?>
	<form method="post">
		<p><input type="submit" name="zrus" value="Zruš obsah košíka"></p>
	</form>
<?php
}



function vypis_objednavky($mysqli) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM lekaren_objednavky"; 

		if ($result = $mysqli->query($sql)) {  
			
			echo '<table>';
			echo '<tr><th>číslo objednávky</th><th>meno a priezvisko</th><th>Adresa</th><th>tovar</th><th>dátum odberu</th></tr>';
			while ($row = $result->fetch_assoc()) {
				echo '<tr><td><a href="administracia.php?kod=' . $row['id'] . '">' . $row['id'] . '</a></td><td>' . $row['meno'] . '</td><td> ' . $row['adresa'] . '</td><td>' . $row['tovar'] . '</td><td>' . $row['datum_odberu'] . ';</td>';
				echo "</tr>\n";
			}
			echo '</table>';
			$result->free();
		} else {
		
			echo '<p class="chyba">NEpodarilo sa získať údaje z databázy</p>';
		}
	}
}

function zrus_tovar($mysqli, $idt) {
	if (!$mysqli->connect_errno) {
		$sql="DELETE FROM lekaren_tovar WHERE kod='{$mysqli->real_escape_string($idt)}'"; 
		if ($result = $mysqli->query($sql) && ($mysqli->affected_rows > 0)) {  
			
	    echo "<p>Tovar č. $idt bol zrušený.</p>\n"; 
  	} else {
			
    	echo "<p class='chyba'>Nastala chyba pri rušení tovaru č. $idt.</p>\n";
    }
	}
} 

function vypis_objednavku($mysqli, $id) {
	if (!$mysqli->connect_errno) {
		$id = $mysqli->real_escape_string($id);
		$sql = "SELECT * FROM lekaren_objednavky, lekaren_tovar";
		if (($result = $mysqli->query($sql)) && ($row = $result->fetch_assoc()) ) {  
			echo '<table border="1">';
			echo "<tr><th>číslo objednávky</th><td>{$row['id']}</td></tr>\n";
			echo "<tr><th>meno a priezvisko</th><td>{$row['meno']}</td></tr>\n";
			echo "<tr><th>adresa doručenia</th><td>{$row['adresa']}</td></tr>\n";
			echo "<tr><th>názov tovaru</th><td>{$row['tovar']}</td></tr>\n";
			echo "<tr><th>dátum odberu</th><td>{$row['datum_odberu']}</td></tr>\n";
			echo "<tr><th>doprava</th><td>{$row['doprava']}</td></tr>\n";
			echo '</table>';
		} else {
			echo '<p class="chyba">NEpodarilo sa získať údaje z databázy, resp. objednávka neexistuje</p>' . $mysqli->error ;
		}
	}
}


function over_pouzivatela($mysqli, $username, $pass) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT * FROM lekaren_pouzivatelia WHERE prihlasmeno='$username' AND heslo=MD5('$pass')"; 

		if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {  

			$row = $result->fetch_assoc();
			$result->free();
			return $row;
		} else {

			return false;
		}
	} else {
		
		return false;
	}
}




function zmen_heslo($mysqli, $id, $pass) {
	if (!$mysqli->connect_errno) {
	  $sql="UPDATE lekaren_pouzivatelia SET heslo=MD5('$pass') WHERE id_pouz='$id'";

		if ($result = $mysqli->query($sql)) {  
		
      echo '<p>Heslo bolo zmenené.</p>'. "\n"; 
    } else {
		
      echo '<p class="chyba">Nastala chyba pri zmene hesla.</p>'. "\n"; 
		}
	} else {
		
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
	}
}	




function pridaj_pouzivatela($mysqli, $prihlasmeno, $heslo, $meno, $priezvisko, $admin) {
	if (!$mysqli->connect_errno) {
		$prihlasmeno = $mysqli->real_escape_string($prihlasmeno);
		$heslo = $mysqli->real_escape_string($heslo);
		$meno = $mysqli->real_escape_string($meno);
		$priezvisko = $mysqli->real_escape_string($priezvisko);
		$admin = $mysqli->real_escape_string($admin);
		$sql = "INSERT INTO lekaren_pouzivatelia SET prihlasmeno='$prihlasmeno', heslo=MD5('$heslo'), meno='$meno', priezvisko='$priezvisko', admin='$admin'"; // definuj dopyt
		if ($result = $mysqli->query($sql)) { 
	    echo '<p>Používateľ bol pridaný.</p>'. "\n"; 
			return true;
	 	} else {
			echo '<p class="chyba">Nastala chyba pri pridávaní používateľa';
			if ($mysqli->errno == 1062) echo ' (zadané prihlasovacie meno už existuje)';
			echo '.</p>' . "\n";
			return false;
	  }
	} else {
		echo '<p class="chyba">NEpodarilo sa spojiť s databázovým serverom!</p>';
		return false;
	}
}	




function zisti_p_objednavok($mysqli) {
	if (!$mysqli->connect_errno) {
		$sql = "SELECT count(kod) as vsetky FROM lekaren_tovar WHERE na_sklade>0"; 
		if (($result = $mysqli->query($sql)) && ($result->num_rows > 0)) {  
			$row = $result->fetch_assoc();
			$result->free();
			return $row['vsetky'];
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function vypis_strany($mysqli, $str = 1) {
	$cart = array();
	if (isset($_GET['str'])){
		$str=$_GET['str'];
	}

	$vsetky=zisti_p_objednavok($mysqli);

	if (!$mysqli->connect_errno) {
		$vsetky = zisti_p_objednavok($mysqli);
		$str1 = 5;
		$vsetkys = ceil($vsetky / $str1);
		$poc = 0;

		if ($str == 1){ 
			$i = 1;

			echo '1 ';
			$nasledujuca=$i+1;
			echo "<a href='?str=$nasledujuca'>$nasledujuca</a> ";
			echo "<a href='?str=$vsetkys'>posledná</a> ";
			$poc = 1;
		}

		if ($str == $vsetkys){ 
			$i = $vsetkys;
			
			$pred=$vsetkys-1;
			echo "<a href='?str=1'>prvá</a> ";
			echo "<a href='?str=$pred'>$pred</a> ";
			echo $vsetkys;
			$poc = 1;
		}

		if ($poc == 0){
			$i=$_GET['str'];
			$nasledujuca = $i+1;
			$pred = $i-1;
			echo "<a href='?str=1'>prvá</a> ";
			echo "<a href='?str=$pred'>$pred</a> ";
			echo $i.' ';
			echo "<a href='?str=$nasledujuca'>$nasledujuca</a> ";			
			echo "<a href='?str=$vsetkys'>posledná</a> ";
		}
	}				
	if (!$mysqli->connect_errno) {
	$sql = "SELECT * FROM lekaren_tovar WHERE na_sklade>0 "; }
	
	if (isset($_POST['bolest'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='bolest' "; 
	elseif (isset($_POST['chripka'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='chrípka' "; 
	elseif (isset($_POST['travenie'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='trávenie' "; 
	elseif (isset($_POST['zrakasluch'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='zrakasluch' "; 
	elseif (isset($_POST['zuby'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='zuby' "; 
	elseif (isset($_POST['alergia'])) $sql = "SELECT * FROM lekaren_tovar WHERE skupina='alergia' "; 
	else $sql = "SELECT * FROM lekaren_tovar WHERE na_sklade>0 ";
	
	if (isset($_POST['nazov2'])) $sql .= "ORDER BY nazov DESC"; 
	elseif (isset($_POST['cena1'])) $sql .= 'ORDER BY cena ASC'; 
	elseif (isset($_POST['cena2'])) $sql .= 'ORDER BY cena DESC';
	else $sql .= 'ORDER BY nazov ASC';
	$sql .= " LIMIT " . ($str - 1) * $str1 . ", $str1"; // definuj dopyt 
	if ($result = $mysqli->query($sql)) {
		while ($row = $result->fetch_assoc()) {
			echo '<div id=ohranicenie2>';
			echo '<h2>' . $row['nazov'];
			echo ' (' . $row['cena'] . "&euro;)</h2>\n";
			echo '<p>' . $row['popis'] . "</p>\n";
			$naz='obrazky/'.$row['kod'].'.jpg';
			if(file_exists($naz)){
            	    echo '<img src='.$naz.' width="150" height="130" >';
            	}
				
			if ((isset($_SESSION['uid'])) && $_SESSION['admin'] == 0){
                    $cesta = "ponuka.php?kod=".$row['kod'];
                    echo '<a href='.$cesta.'>Do kosika</a>';
                }
			$cesta = "ponuka.php?kod=".$row['kod'];
            echo '<br><a id=kosikstyl href='.$cesta.'>Do košíka</a>';
			echo '</div>';
		}
		
			
		$result->free();
	} elseif ($mysqli->errno) {
		echo '<p class="chyba">NEpodarilo sa vykonať dopyt! (' . $mysqli->error . ')</p>';
		}
		
		if (isset($_GET['kod'])){
	    if (!isset($_SESSION['kosik'])) {
            $_SESSION['kosik'] = array();

        }
        array_push($_SESSION['kosik'],$_GET['kod']);

	}

	
	}

?>

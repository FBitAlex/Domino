<?php 

//include 'vars.php';
// инициализация - заполняем массив "база костей"

	$last_bone = -1;
	$first_gamer = 0; // кто первый ходит

	$fn = 0;
	$sn = 0;
	$gamers = 2; // количество игроков
	$temp = 0; // временное хранилище для раздачи
	$cnt_bone = 28;

	$table = [];
	$left_bone = -1;
	$right_bone = -1;

	$bazar = $cnt_bone - ($gamers * 7);
	$bazar_bones = [];
	$access_bones = [];

	// инициализация базы
	for ($i = 0; $i < $cnt_bone; $fn++) {
		for ($sn = $fn; $sn <= 6 ; $sn++, $i++) { 
			$baza[$i][0] = $fn;
			$baza[$i][1] = $sn;
			$baza[$i][2] = 0;
		}
	}

	require_once('func.php');

	echo "first_gamer = ". $first_gamer;

	// echo "<br> next => " . next_gamer($first_gamer);

	// первый ход
	$baza[$last_bone][2] = -1;
	$table = [ $baza[$last_bone][0], $baza[$last_bone][1] ];
	// запомнили крайние цифры
	$left_bone = $baza[$last_bone][0];
	$right_bone = $baza[$last_bone][1];

	show_result();
	$next_gamer = next_gamer($first_gamer);

	while ( !$end_game ) {
		search_bone_in_gamer();

		// если нет кости у игрока
		if ( count($access_bones) == 0 ) {
			
			if  ( count($bazar_bones) == 0 ) { 
				// передаем ход следующему
				$next_gamer = next_gamer($next_gamer);
		
			} else {
				// берем кость на базаре
				get_bone_from_bazar();
			}
		// есть подходящая кость для игры
		} else {
			// берем случайную кость из доступных
			$elem = rand(0, count($access_bones)-1);
			// убираем с базы (у игрока)
			$baza[ $access_bones[$elem][2] ][2] = -1;
			// ложим кость на стол

		}

		check_cnt_bone_in_user();
	}

	echo "<br><h2>ИГРА ЗАКОНЧЕНА !</h2>";
	// echo "<br> ==>> " .  rand(0, count($access_bones)-1 );
	// array_unshift()
?>

<h2>============== подходящие кости текущего игрока =============</h2>
<pre>
<?php  print_r($access_bones);?>
<br>
<br>

<h2>============== стол =============</h2>
<pre>
<?php  print_r($table);?>
<br>
<br>

<h2>============== БАЗА =============</h2>
<br>
	<?php  print_r($baza);?>
</pre>

<?
	// $baza

	// $fn = 0;
	// $sn = 0;

	// for ($i=0; $i<28; $i++) {

	// 	$baza[$i][0] = $fn;
	// 	$baza[$i][1] = $sn;
	// 	$baza[$i][2] = true;

	// 	if ( $sn<6 ) {
	// 		$sn++;
	// 	} else {
	// 		$sn = ++$fn;
	// 	}

		// ( $sn < 6 ) ? $sn++ : $sn = ++$fn;

	// }
	// $num = rand(0, count($baza)-1);
	// echo $num . "<br>";
	// echo $baza[$num][0]  . "<>" . $baza[$num][1];
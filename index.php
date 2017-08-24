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

	$table = []; // массив стола
	$left_bone = -1;
	$right_bone = -1;

	$bazar = $cnt_bone - ($gamers * 7);
	$bazar_bones = [];
	$access_bones = [];
	$go_game = true;


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

show_result();

	// первый ход
	$baza[$last_bone][2] = -1;
	$table[] = [ $baza[$last_bone][0], $baza[$last_bone][1] ];
	// запомнили крайние цифры
	$left_bone = $baza[$last_bone][0];
	$right_bone = $baza[$last_bone][1];

	echo "<strong><br>==== ОЧЕРЕДНОСТЬ ХОДОВ ==== <br></strong>";
	echo "<br> $first_gamer  =>  [" . $baza[ $last_bone ][0] . " | ". $baza[ $last_bone ][1] . "]";

	//show_result();
	$next_gamer = next_gamer($first_gamer);
	$go_to_bazar = false;

	while ( $go_game ) {

		// поиск кости у игрока для хода - заполняет $access_bones
		search_bone_in_gamer();

		// если нет кости у игрока
		if ( count($access_bones) == 0) {
			
			// заполняем базар ($bazar_bones)
			search_bone_in_bazar();

			if  ( count($bazar_bones) != 0 ) { 
			 	// берем кость на базаре
				get_bone_from_bazar();
				$go_to_bazar = true;
				continue;
			}

		// есть подходящая кость для игры
		} else {
			// берем случайную кость из доступных
			$elem = rand(0, count($access_bones)-1);
			// убираем с базы (у игрока)
			$buffer_bone = $access_bones[$elem][2];
			$baza[ $buffer_bone ][2] = -1;
			
			// ложим кость на стол
			if ( $left_bone == $baza[ $buffer_bone ][0] ) {
				array_unshift($table, [ $baza[ $buffer_bone ][1], $baza[ $buffer_bone ][0] ] );
				echo "<br> $next_gamer  =>  [" . $baza[ $buffer_bone ][1] . " | ". $baza[ $buffer_bone ][0] . "]";
				echo ($go_to_bazar) ? " - С БАЗАРА" : "";

			} else if ( $left_bone == $baza[ $buffer_bone ][1] ) {
				array_unshift($table, [ $baza[ $buffer_bone ][0], $baza[ $buffer_bone ][1] ] );
				echo "<br> $next_gamer  =>  [" . $baza[ $buffer_bone ][0] . " | ". $baza[ $buffer_bone ][1] . "]";
				echo ($go_to_bazar) ? " - С БАЗАРА" : "";
			
			} else if ( $right_bone == $baza[ $buffer_bone ][0] ) {
				$table[] = [ $baza[ $buffer_bone ][0], $baza[ $buffer_bone ][1] ];
				echo "<br> $next_gamer  =>  [" . $baza[ $buffer_bone ][0] . " | ". $baza[ $buffer_bone ][1] . "]";
				echo ($go_to_bazar) ? " - С БАЗАРА" : "";
			
			} else if ( $right_bone == $baza[ $buffer_bone ][1] ) {
				$table[] = [ $baza[ $buffer_bone ][1], $baza[ $buffer_bone ][0] ];
				echo "<br> $next_gamer  =>  [" . $baza[ $buffer_bone ][1] . " | ". $baza[ $buffer_bone ][0] . "]";
				echo ($go_to_bazar) ? " - С БАЗАРА" : "";
			}				
			$go_to_bazar = false;
			// запомнили крайние цифры
			$left_bone = $table[0][0];
			$right_bone = $table[ count($table)-1 ][1];
		}

		check_cnt_bone_in_user();
		// check_for_fish();
		if ( !search_bone_in_gamers() || !$go_game) {
			if ( !$go_game ) {
				echo "<br><h2>ИГРА ЗАКОНЧЕНА !  Победил Игрок № $next_gamer</h2>";
			} else {
				echo "<br><h2>РЫБА! ИГРА ЗАКОНЧЕНА!</h2>";
			}
			break;
		}
		// передаем ход следующему
		$next_gamer = next_gamer($next_gamer);
		// break;
	} // end while


	
	// echo "<br> ==>> " .  rand(0, count($access_bones)-1 );
	// array_unshift()


	// echo "<br>=== ДОСТУПНЫ КОСТИ ====";
	// $echo_str = '<br>';
	// for ( $i=0; $i < count($baza); $i++ ) {
	// 	$bz = ($baza[$i][2] == -1) ? "X" : $baza[$i][2];
	// 	$echo_str .= "<br>[ " .$baza[$i][0] ." | ". $baza[$i][1] . " ] => ". $bz;
	// }
	// echo $echo_str;

	echo "<br><br><strong>=== СТОЛ ====</strong>";
	$echo_str = '<br>';
	$j = 0;
	for ( $i=0; $i < count($table); $i++ ) {
		$j++;
		$echo_str .= "<br>[ " .$table[$i][0] ." | ". $table[$i][1] . " ]";
	}
	echo "<br>Всего => ".$j;
	echo $echo_str;

	echo "<strong><br><br>=== БАЗАР ====</strong>";
	$echo_str = '<br>';
	$j = 0;
	for ( $i=0; $i < count($baza); $i++ ) {
		if ( $baza[$i][2] == 0 ) {
			$j++;
			$echo_str .= "<br>[ " .$baza[$i][0] ." | ". $baza[$i][1] . " ]";
		}
	}
	echo "<br>Всего => ".$j;
	echo $echo_str;

	echo "<strong><br><br>=== 1 ИГРОК ====</strong>";
	$echo_str = '<br>';
	$j = 0;
	for ( $i=0; $i < count($baza); $i++ ) {
		if ( $baza[$i][2] == 1 ) {
			$j++;
			$echo_str .= "<br>[ " .$baza[$i][0] ." | ". $baza[$i][1] . " ]";
		}
	}
	echo "<br>Всего => ".$j;
	echo $echo_str;

	echo "<strong><br><br>=== 2 ИГРОК ====</strong>";
	$echo_str = '<br>';
	$j = 0;
	for ( $i=0; $i < count($baza); $i++ ) {
		if ( $baza[$i][2] == 2 ) {
			$j++;
			$echo_str .= "<br>[ " .$baza[$i][0] ." | ". $baza[$i][1] . " ]";
		}
	}
	echo "<br>Всего => ".$j;
	echo $echo_str;


	// print_r($baza);


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
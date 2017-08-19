<?php

	// поиск кости у игрока для хода
	function search_bone_in_gamer () {

		global $baza, $cnt_bone, $left_bone, $right_bone, $next_gamer, $access_bones;
		$access_bones = [];

			for ($i = 0; $i < $cnt_bone; $i++) {

				if (	$baza[$i][2] == $next_gamer &&

						($baza[$i][0] == $left_bone ||
						$baza[$i][1] == $left_bone ||
						$baza[$i][0] == $right_bone || 
						$baza[$i][1] == $right_bone)
					) {
					$access_bones[] = [
						$baza[$i][0],
						$baza[$i][1],
						$i
					];


				}

			}

	}

	function get_bone_from_bazar () {

		global $baza, $cnt_bone, $bazar_bone, $next_gamer;

			for ($i = 0; $i < $cnt_bone; $i++) {

				if ( $baza[$i][2] == 0 ) {
					$baza[$i][2] = $next_gamer;
					break;
				}

			}

	}


	function check_cnt_bone_in_user () {
		global $baza, $cnt_bone, $next_gamer, $end_game;

		for ($i = 0; $i < $cnt_bone; $i++) {
			if ( $baza[$i][2] == $next_gamer ) {
				$end_game = false;
				break;
			}
		}
		$end_game = true;
	}
	

	// function search_bone_in_bazar () {

	// 	global $baza, $cnt_bone, $bazar_bones;
	// 	$bazar_bones = [];

	// 		for ($i = 0; $i < $cnt_bone; $i++) {

	// 			if ( $baza[$i][2] == 0 ) {
	// 				$bazar_bones[$i] = $baza[$i];
	// 			}

	// 		}

	// }


	function next_gamer ( $gamer_num ) {
		global $gamers;
		return ($gamer_num % $gamers)+1;
	}

	function show_result () {
		global $gamers, $baza, $cnt_bone;

		echo "<br>RESULT: <br>";
		for ($g = 1; $g <= $gamers; $g++) {
			$str = '<br>';
			for ($i = 0; $i < $cnt_bone; $i++) {

				if ($baza[$i][2] == $g) {
					$str = $str . " || "  . $baza[$i][0] . ", ". $baza[$i][1];
				}

			}
			echo "Gamer $g => " . $str . "<br><br>";
		}
	}


		// раздача костяшек игрокам
		for ($gamer = 1; $gamer <= $gamers; $gamer++) {
			$i = 0;
			
			// if ( $gamer == 4 ) {
			// 	for ($j = 0; $j < $cnt_bone; $j++) {
			// 		if ( $baza[$j][2] == 0 ) {
			// 			$baza[$j][2] = 4;
			// 			echo "<br>$gamer => $j<br>";
			// 		}

			// 	}

			// } else {
				$str = "<br>Gamer $gamer =>";
				while ( $i < 7 ) {
					$temp = rand(0, 27);

					if ( $baza[$temp][2] == 0 ){
						$baza[$temp][2] = $gamer; // ???
						$str = $str . " || "  . $baza[$temp][0] . ", ". $baza[$temp][1];
						$i++;

						/*=============================*/
						// проверка на наименьшую розданную кость

						// проверка на меньший дубль дубль
						// if ( (($baza[$temp][0] == $baza[$temp][1]) && ($baza[$last_bone][0] != $baza[$last_bone][1]))|| ($last_bone == -1) ) {
						if ( (($baza[$temp][0] == $baza[$temp][1]) && ($baza[$last_bone][0] != $baza[$last_bone][1]))|| ($last_bone == -1) ) {
								$last_bone = $temp;
								$first_gamer = $baza[$temp][2];
								
		//						}
						} else if ( ($baza[$temp][0] == $baza[$temp][1]) && ($baza[$last_bone][0] == $baza[$last_bone][1]) && ($baza[$temp][0] < $baza[$last_bone][0]) ) {
								$last_bone = $temp;
								$first_gamer = $baza[$temp][2];

						// сумму (наименьшая цифра)
						} else if ( ($baza[$temp][0] < $baza[$last_bone][0]) && ($baza[$last_bone][0] != $baza[$last_bone][1]) ) {
								$last_bone = $temp;
								$first_gamer = $baza[$temp][2];

						} else {

							$sum_temp = $baza[$temp][0] + $baza[$temp][1]; // 2
							$sum_last = $baza[$last_bone][0] + $baza[$last_bone][1]; // 0


							if ( ($sum_temp < $sum_last) && ($baza[$last_bone][0] != $baza[$last_bone][1]) ) {

								$last_bone = $temp;
								$first_gamer = $baza[$temp][2];
							 }

						}			
					}
					
				}
				echo $str . "<br><br>";
			//}
		}


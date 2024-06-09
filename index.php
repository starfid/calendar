<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Calendar</title>
		<style>
			#calendar {font-family:arial;width:100%;font-size:2vw}
			#calendar td {width:14.2%;height:10.8vh;padding-right:2vw;}
			#calendar a {text-decoration:none;color:black;font-weight:bolder}
			#calendar .colRed {color:#E60000!important}
			#calToday {background-color:#d7d7d7;animation:calToday 1s infinite;}

			@keyframes calToday { from{background-color:#d7d7d7} to {background-color:#ffffff} }

			@media (max-width: 1000px) {
				#calendar { font-size:2.5vh; }
				#calendar td {height:7vh;}
			}
		</style>
	</head>
	<body>
		<div style="max-width:1200px;margin:0 auto;padding-right:10px">
		<?php

			if(isset($_GET['prevMonth']) && isset($_GET['prevYear']) && !empty($_GET['prevMonth']) && !empty($_GET['prevYear'])){
				$month = date('m',strtotime($_GET['prevYear']."-".$_GET['prevMonth']."-01 -1 months"));
				$year = date('Y',strtotime($_GET['prevYear']."-".$_GET['prevMonth']."-01 -1 months"));
			}
			elseif(isset($_GET['nextMonth']) && isset($_GET['nextYear']) && !empty($_GET['nextMonth']) && !empty($_GET['nextYear'])){
				$month = date('m',strtotime($_GET['nextYear']."-".$_GET['nextMonth']."-01 +1 months"));
				$year = date('Y',strtotime($_GET['nextYear']."-".$_GET['nextMonth']."-01 +1 months"));
			}
			elseif(isset($_GET['curMonth']) && isset($_GET['curYear']) && !empty($_GET['curMonth']) && !empty($_GET['curYear'])) {
				$month = date('m',strtotime($_GET['curYear']."-".$_GET['curMonth']."-01"));
				$year = date('Y',strtotime($_GET['curYear']."-".$_GET['curMonth']."-01"));
			}
			else {
				$month = date("m");
				$year = date("Y");
			}

			$firstDay = mktime(0,1,0,$month,1,$year);
			$daysInMonth = date("t",$firstDay);
			$firstDay = date("w",$firstDay);


			/*********************
			    * SET HOLIDAY *
			*********************/

			$holidays = [
				'2024-06-01',
				'2024-06-17',
				'2024-06-18',
			];



			echo "<table id='calendar' border='0' cellspacing='2' cellpadding='2'>";
			
			echo "<tr>";
				echo "<td align='center'><a href='?prevMonth=".$month."&prevYear=".$year."'>&lt;</a></td>";
				echo "<td colspan='5' align='center'><strong><a href=\"?\">".date('F Y',strtotime($year."-".$month."-01"))."</a></strong></td>";
				echo "<td align='right'><a href='?nextMonth=".$month."&nextYear=".$year."'>&gt;</a></td>";
			echo "</tr>";

			echo "<tr align='right'>";
				echo "<td class='colRed'>Mig</td>";
				echo "<td>Sen</td>";
				echo "<td>Sel</td>";
				echo "<td>Rab</td>";
				echo "<td>Kam</td>";
				echo "<td>Jum</td>";
				echo "<td>Sab</td>";
			echo "</tr>";
			
			$totalCells = $firstDay + $daysInMonth;
			if($totalCells < 36){
				$rowNumber = 5;
			}
			else {
				$rowNumber = 6;
			}

			$dayNumber = 1;

			for($currentRow=1; $currentRow <= $rowNumber; $currentRow++){



				if($currentRow == 1){
					echo "<tr align='right'>";
					for($currentCell  = 0; $currentCell<7; $currentCell++){
						
						$day = $dayNumber<10?"0".$dayNumber:$dayNumber;
						$fullDate = $year."-".$month."-".$day;
						$set = "set=".$year."-".$month."-".$day."&curYear=".$year."&curMonth=".$month;
						$today = date("Y-m-d") == $fullDate?" id='calToday'":"";
						$red = $currentCell == 0 || in_array($fullDate, $holidays)?" class='colRed'":"";

						if($currentCell == $firstDay){
							echo "<td><a".$today." href='?".$set."'".$red.">".$dayNumber."</a></td>";
							$dayNumber++;
						}
						else {
							if($dayNumber > 1){
								echo "<td><a".$today." href='?".$set."'".$red.">" . $dayNumber . "</a></td>";
								$dayNumber++;
							}
							else {
								echo "<td>&nbsp;</td>";
							}
						}
					}
					echo "</tr>";
				}
				else {
					echo "<tr align='right'>";

					for($currentCell = 0; $currentCell < 7; $currentCell++){

						$day = $dayNumber<10?"0".$dayNumber:$dayNumber;
						$fullDate = $year."-".$month."-".$day;
						$set = "set=".$year."-".$month."-".$day."&curYear=".$year."&curMonth=".$month;
						$today = date("Y-m-d") == $fullDate?" id='calToday'":"";

						if($dayNumber > $daysInMonth){
							echo "<td>&nbsp;</td>";
						}
						else {
							
							$red = $currentCell == 0 || in_array($fullDate, $holidays)?" class='colRed'":"";
							

							echo "<td><a".$today." href='?".$set."'".$red.">" . $dayNumber . "</a></td>";
							$dayNumber++;
						}
					}
					echo "</tr>";
				}
			}
			echo "</table>";
		?>
		</div>
	</body>
</html>

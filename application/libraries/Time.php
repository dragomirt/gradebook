<?php
class Time{

	public function get_year_us($date){
		$year = substr($date, 0, 4);
		return $year;
	}

	public function get_month_us($date){
		$month = substr($date, 5, 2);
		return $month;
	}

	public function get_day_us($date){
		$day = substr($date, 8, 2);
		return $day;
	}

	public function get_year_eu($date){
		$year = substr($date, 6, 4);
		return $year;
	}

	public function get_month_eu($date){
		$month = substr($date, 3, 2);
		return $month;
	}

	public function get_day_eu($date){
		$day = substr($date, 0, 2);
		return $day;
	}

	public function convert_us_to_eu($date){
		$year = $this->get_year_us($date);
		$month = $this->get_month_us($date);
		$day = $this->get_day_us($date);
		return $day . '-' . $month . '-' . $year;
	}

	public function convert_eu_to_us($date){
		$year = $this->get_year_eu($date);
		$month = $this->get_month_eu($date);
		$day = $this->get_day_eu($date);
		return $year . '-' . $month . '-' . $day;
	}

	public function get_sem($date, $type){
		if($type == 'us')$month = $this->get_month_us($date); else
		$month = $this->get_month_eu($date);

		if($month >= 1 && $month < 9) $sem = 2; else $sem = 1;
		return $sem;
	}

	public function semMin($sem){
		if($sem == 1){ return 9; } elseif ($sem == 2){ return 1; }
	}

	public function semMax($sem){
		if($sem == 1){ return 12; } elseif ($sem == 2){ return 5; }
	}

	public function get_current_date(){
		return date("Y-m-d");
	}

	public function convert_to_full_time($tm){
		if(strlen($tm) == 1){ return 0 . $tm; }else{ return $tm; }
	}
}
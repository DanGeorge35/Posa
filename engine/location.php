<?php

class location{

var  $c_country;
var  $c_state;
var  $country_id;
var  $country_name;
var  $iso_code;

function __construct() {
   $this->c_country = simplexml_load_file(__DIR__."/country.xml");
   $this->c_state = simplexml_load_file(__DIR__."/state.xml");
}

 function get_country($dCountry_id){
	$name= "";
	foreach($this->c_country as $country) { 
		if(trim($country->country_id) == trim($dCountry_id)){
			$name = $country->name;	
		}		
	}
	return $name;
}

 function get_country_id($name){
	$dCountry_id= "";
	foreach($this->c_country as $country) { 
		if(trim($country->name) == trim($name)){
			$dCountry_id = $country->country_id;	
		}		
	}
	return $dCountry_id;
}

 function get_zone($dCountry_id){
	$dhl_zone= "";
	foreach($this->c_country as $country) { 
		if(trim($country->country_id) == trim($dCountry_id)){
			$dhl_zone = $country->dhl_zone;	
		}		
	}
	return $dhl_zone;
}


 function get_country_state($name){
	$name= "";
	foreach($this->c_state as $state) { 
	if(trim($state->name) == trim($name)) {
			$count_name = $this->get_country($state->country_id);	
		}		
	}
	return $count_name;
}

 function get_state($dCountry_id,$abr){
	$name= "";
	foreach($this->c_state as $state) { 
		if(($state->country_id == $dCountry_id) && ($state->abbreviation == $abr)) {
			$name = $state->name;	
		}		
	}
	return $name;
}

 function get_state_abr_list($dCountry_id){
	$abbreviation= [];
	foreach($this->c_state as $state){
		 if(trim($state->country_id,"") == trim($dCountry_id,"")){
		 	$abbreviation[] = $state->abbreviation;	
		 }				
	}
	return $abbreviation;
}

 function get_state_list($dCountry_id ='1157'){
	$name = [];
foreach($this->c_state as $state){
 if(trim($dCountry_id,"") == trim($state->country_id,"")) {
	 	$name[] = $state->name;	
	 }
}

	return $name;

}

 function country_id_list(){
		$ids=[];
	foreach($this->c_country as $country) { 
		$ids[] = $country->country_id;			
	}
	return $ids;
}
	
 function country_name_list(){
		$name= [];
	foreach($this->c_country as $country) { 
		$name[] = $country->name;			
	}
	return $name;
}
	
 function country_iso_list(){
	$iso= [];
	foreach($this->c_country as $country) { 
		$iso[] = $country->iso_code;			
	}
	return $iso;
}
	
	
 function fetch_edit($id){
	foreach($this->c_country as $country) { 
		if(trim($country->country_id,"") == trim($id,"")){
			$this->country_name = $country->name;
			$this->country_id = $id;
			$this->iso_code = $country->iso_code;
		}
		
	}
}


	
}
?>
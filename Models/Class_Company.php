<?php



class Company{
	
	private $name;
	private $areaOfWork;
	private $establised;
	private $employees;
	private $revenue;
	private $ofcAddress;
	private $email;
	private $phone;
	private $logo;
	
	public function __construct ( $Name, $AreaOfWork, $Establised, $Employees, $Revenue, $OfcAddress, $Email, $Phone, $Logo) {
    $this->name = $Name;
    $this->areaOfWork = $AreaOfWork;
    $this->establised = $Establised;
    $this->employees = $Employees;
    $this->revenue = $Revenue;
    $this->ofcAddress = $OfcAddress;
    $this->email = $Email;
    $this->phone = $Phone;
    $this->logo = $Logo;
  }
	
	public function getName(){
		return $this->name;
	}
	public function getAreaOfWork(){
		return $this->areaOfWork;
	}
	public function getEstablised(){
		return $this->establised;
	}
	public function getEmployees(){
		return $this->employees;
	}
	public function getRevenue(){
		return $this->revenue;
	}
	public function getOfcAddress(){
		return $this->ofcAddress;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function getLogo(){
		return $this->logo;
	}
}




?>
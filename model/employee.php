<?php
	class Employee{		

		private $id;
		private $name;
		private $address;
		private $salary;
				
		function __construct($id, $name, $address, $salary){
			$this->setId($id);
			$this->setName($name);
			$this->setAddress($address);
			$this->setSalary($salary);
			}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getAddress(){
			return $this->address;
		}
		
		public function setAddress($address){
			$this->address = $address;
		}

		public function getsalary(){
			return $this->salary;
		}

		public function setSalary($salary){
			$this->salary = $salary;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

	}
?>
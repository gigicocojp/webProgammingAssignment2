<?php
	class FootballPlayer{		

		private $id;
		private $name;
		private $club;
		private $salary;
        private $birthdate;
        private $imgsrc;
				
		function __construct($id, $name, $club, $birthdate, $salary, $imgsrc){
			$this->setId($id);
			$this->setName($name);
			$this->setClub($club);
            $this->setBirthdate($birthdate);
			$this->setSalary($salary);
            $this->setImgsrc($imgsrc);
		}		
		
		public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getClub(){
			return $this->club;
		}
		
		public function setClub($club){
			$this->club = $club;
		}

		public function getSalary(){
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
        public function setBirthdate($birthdate){
            $this->birthdate = $birthdate;
        }

        public function getBirthdate(){
            return $this->birthdate;
        }

        public function setImgsrc($imgsrc){
            $this->imgsrc = $imgsrc;
        }
        
        public function getImgsrc(){
            return $this->imgsrc;
        }

	}
?>
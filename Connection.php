<?php
	class Connection{
		private $host;
		private $database;
		private $user;
		private $password;
		private $pdo;

		public function __construct(){
			$this->host = 'localhost';
			$this->database = 'database';			
			$this->user = 'root';
			$this->password = '';
			$this->pdo = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8",$this->user,$this->password);
		}

		public function select(array $columns, string $table, $WHEREthis = '', $isEQUAL = ''){ $columns = implode(",", $columns);
			if ($WHEREthis == '' || $isEQUAL == '') {
				$stringdeconexao = "SELECT $columns FROM $table";
				$stmt = $this->pdo->prepare($stringdeconexao);
				$stmt->execute();
			}else{
				$stringdeconexao = "SELECT $columns FROM $table WHERE $WHEREthis = ?";
				$stmt = $this->pdo->prepare($stringdeconexao);
				$stmt->execute([$isEQUAL]);
			}
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function insert(string $table,array $columns, array $values){ $columns = implode(",", $columns); 	
			$stringdeconexao = "INSERT INTO $table ($columns) VALUES (?)";	 $values = implode(",", $values);	
			$stmt = $this->pdo->prepare($stringdeconexao);
			$stmt->execute([$values]);
		}

		public function update(string $table, array $column_value, $WHEREthis, $isEQUAL){ $column_value_dict = [];
			foreach ($column_value as $column => $value) {
				$column_value_dict[] = "$column = '$value'";
			}
			$column_value_dict = implode(',', $column_value_dict);
			$stringdeconexao = "UPDATE $table SET $column_value_dict WHERE $WHEREthis = ?";
			
			$stmt = $this ->pdo->prepare($stringdeconexao);
			$stmt->execute([$isEQUAL]);
		}

		public function delete($table, $WHEREthis, $isEQUAL){
			$stringdeconexao = "DELETE FROM $table WHERE $WHEREthis = ?";
			$stmt = $this->pdo->prepare($stringdeconexao);
			$stmt->execute([$isEQUAL]);
			print_r($stringdeconexao);
		}
	}
	

?>

<?php
class Database
{

	protected $data, $conn;

	function __construct()
	{
		$dsn = "mysql:host=" . HOST . "; dbname=" . DB;
		try {
			$this->conn = new PDO($dsn, USER, PASS);
			$this->conn->query("set names 'utf8' ");
		} catch (Exception $e) {
			echo 'Lỗi: ' . $e->getMessage();
			exit;
		}
	}
	public function __destruct()
	{
		$this->conn = null;
	}

	public function query($sql, $arr = array())
	{
		$stm = $this->conn->prepare($sql);
		$stm->execute($arr);
		$this->data = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $this->data;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getRowCount()
	{
		return count($this->data);
	}

	public function queryCart($sql, $arr = array(), $mode = PDO::FETCH_ASSOC)
	{
		$stm = $this->conn->prepare($sql);
		if (!$stm->execute($arr)) {
			echo "Sql lỗi.";
			exit;
		}
		
		return $stm->fetchAll($mode);
	}
}

<?php
namespace app\model;

use mysqli;

class Login
{
	public function __construct()
	{
	}

	public function register($user,$pass)
	{
		####################################################
		####################################################
		$conn=new mysqli('localhost','root','', 'csc350');
		if ($conn->connect_error) die($conn->connect_error);
		####################################################
		$query="SELECT * from csc350.users";
		$result = $conn->query($query);
		if(!$result) die($conn->error);
		####################################################
		$rows=$result->num_rows;
		for($i=0;$i<$rows;++$i)
		{
			$result->data_seek($i);
			$row=$result->fetch_array(MYSQLI_ASSOC);
			if($row['username'] == $user)
			{
				$result->close();
				$conn->close();
				return false;
			}
		}
		####################################################
		$query="insert into csc350.users (username, password)
            values( '$user' , '$pass')";
		$result = $conn->query($query);
		if(!$result) die($conn->error);
		####################################################
		//$result->close();
		$conn->close();
		//include("index.php");
		return true;
	}

	public function login($user, $pass)
	{
		####################################################
		$servername = 'localhost';
		$dbusername = 'root';
		$dbpassword = '';
		$dbname = 'csc350';
		####################################################
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
		if ($conn->connect_error) die($conn->connect_error);
		####################################################
		$query = "SELECT * from csc350.users";
		$result = $conn->query($query);
		if (!$result) die($conn->error);
		####################################################
		$rows = $result->num_rows;
		for ($i = 0; $i < $rows; ++$i) {
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$userid = $row['username'];
			$password = $row['password'];
			if (($user == $userid) && ($pass == $password)) {
				return true;
			}
		}
		####################################################
		$result->close();
		$conn->close();
		return false;
	}
	function getCustomerId($username) {
		$serverName = 'localhost';
		$dbUsername = 'root';
		$dbPassword = '';
		$dbName = 'csc350';

		try {
			$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			$username = mysqli_real_escape_string($conn, $username);

			$sql = "SELECT customerId FROM csc350.users WHERE username = '$username'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$customerId = $row['customerId'];
				mysqli_close($conn);
				return $customerId;
			} else {
				mysqli_close($conn);
				return null; // Customer not found
			}
		} catch (\Exception $error) {
			error_log('There was an error fetching customerId: ' . $error->getMessage());
			return null;
		}
	}
}


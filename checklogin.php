<?php

	include_once("db/connection.inc.php");
	include_once("db/mysql_database.inc.php");

// предаване на параметрите username and password от входящата форма 
	$myusername=$_POST['myusername'];
	$mypassword=$_POST['mypassword']; 

//създаване на обект към DB
	$db=DBFactory::CreateDatabaseObject("MySqlDatabase");
	$db->Connect($server, $database, $username, $password);

	$dt=$db->Execute("SELECT UserID, CategoryID FROM Users WHERE UserName='$myusername' AND Password='$mypassword'");
	
	//проверка за наличие на записи в БД
	$count=$dt->Count();
	if($count==1){
		while($dt->MoveNext())
		{
			$par=$dt->__get('CategoryID');
			$user_id=$dt->__get('UserID');
			
		}	
	}
	else {
		echo "Грешна парола или потребител!";
		header("location:error_index.php");
	}
	
	
//проверява се върнатия резултат от заявката към БД и се определя към кой модул да се премине
	switch(($par))
	{
		case 0:
			throw new Exception("Error");
			header("location:error_index.php");
		case 1:
			//echo "студент!";					
			header("Location: student/index.php?id=$user_id");
			break;
		case 2:
			//echo "учител!";						
			header("location:teacher/index.php");
			break;
		case 3:
			echo "Администратор!";					
			header("location:admin/index.php?id=$user_id");
			break;
		case 4:
			echo "user: Root!";					
			header("location:root/index.php");
			break;

		default:
			echo "Opa!";
			header("location:error_index.php");		
			break;		
	}	
?>

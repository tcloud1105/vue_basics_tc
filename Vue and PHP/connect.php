<?php
   $db = @new MySqli('localhost','root','','vue');
   if($db->connect_error){
	   exit('cannot connect to the database');
   }
?>
<?php
	function hello ($h){
		echo "hello".$h;
	}
	function redirect_to($new)
	{
		header("Location: ".$new);
		exit;
	}
	function error($alertr=array())
	{
		$output="";
		if(!empty($alertr))
		{
	
			foreach ($alertr as $key => $value) {
				$output.= "{$value}<br/>";
			}
			
		}
		return $output;
	}
	function encrypt_password($password){
			$hash_format="$2y$10$";
            $salt= uniqid(mt_rand(), true);
            $format_and_salt=$hash_format . $salt;
            $hash=crypt($password,$format_and_salt);
            return $hash;
            }

	?>
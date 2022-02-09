<?php

function check_login($conn)
{

	if(isset($_SESSION['user_id']))
	{

		//read from database
		
		//read from database
		$query = "select * from wuser where wid = :id;";
		$stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->fetch();

		if($result)
		{
			return $result;
		}
	} else {
        //redirect to login
        header("Location: login.php");
        exit();
    }
}

function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action === 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action === 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function display_mycourses($conn)
{

	if(isset($_SESSION['user_id']))
	{
	
		//read from database
			
		$query = "SELECT wuser.wid            AS wid,
		wuser.wname          AS wname,
		wuser.img_dir        AS img_dir,
		wuser.wemail         AS wemail,
		wuser.wpassword      AS wpassword,
		wuser.date_join      AS date_join,
		wuser.access_level   AS access_level,
		courses.video_id     AS video_id,
		courses.video_name   AS video_name,
		courses.wdescription AS wdescription,
		courses.uploader     AS uploader,
		courses.video_dir    AS video_dir
 FROM   wuser
		LEFT JOIN courses
			   ON wuser.wid = courses.uploader
 WHERE  wuser.wid = :id;";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':id', $_SESSION['user_id']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		if($result)
		{
			return $result;
		}
	} else{
			//redirect to login
			header("Location: login.php");
			exit();
		}
}

function display_profile($conn)
{
	if(isset($_SESSION['user_id']))
	{
	
		//read from database
			
		$query = "SELECT wuser.wid            AS wid,
		wuser.wname           AS wname,
		wuser.img_dir         AS img_dir,
		wuser.wemail          AS wemail,
		wuser.wpassword       AS wpassword,
		wuser.date_join       AS date_join,
		wuser.access_level    AS access_level,
		wprofile.profile_id   AS profile_id,
		wprofile.wid          AS wid,
		wprofile.fullName     AS fullName,
		wprofile.specialty    AS specialty,
		wprofile.job          AS job,
		wprofile.country      AS country,
		wprofile.phone        AS phone,
		wprofile.email        AS email,
		wprofile.about        AS about,
		wprofile.addres       AS addres
 FROM   wuser
		LEFT JOIN wprofile
			   ON wuser.wid = wprofile.wid
 WHERE  wuser.wid = :id;";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':id', $_SESSION['user_id']);
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		if($result)
		{
			return $result;
		}
	} else{
			//redirect to login
			header("Location: login.php");
			exit();
		}
}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}
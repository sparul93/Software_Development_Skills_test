<?php
//phpinfo();
   //url declaration
$url = "https://reqres.in/api/users";

  //data array to be POSTED
$information_array = array(
'Name' => 'Parul Parul',
'Job' => 'Software Developer',
'Following Data is fetched from 2 different APIs' => 'https://jsonplaceholder.typicode.com/users
 and https://jsonplaceholder.typicode.com/todos ');

$data = http_build_query($information_array);

  //Commands for POST
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);
  //errors check
if($e = curl_error($ch))
{
	echo $e;
}
else
{
	$decoded = json_decode($resp);
	foreach ($decoded as $key => $val)
	{
		echo $key . ': ' . $val . '<br>';
	}
}
curl_close($ch);

class cURL {
	  //Initialize value
	 public $curl = null;

	  //Function to call curl_init to store the resource internally
	 public function __construct($url = null){
		return $this->init($url);
	}

	  //Calling for the class
	  //Called function will return value
	 public function __call($n,$p){
		if($n=='init' || $n=='multi_init'){
			  //Connection closed
			if($this->curl) curl_close($this->curl);
			  //Resource saved internally
			return $this->curl = call_user_func_array('curl_'.$n,$p);
		} else {
			  //Current resource to the function call
			array_unshift($p,$this->curl);
			return call_user_func_array('curl_'.$n,$p);
		}
	}
}

  //Executing class for API 1

$http = new cURL("https://jsonplaceholder.typicode.com/users");
$http->setopt(CURLOPT_HEADER, 0);
$http->setopt(CURLOPT_RETURNTRANSFER, 1);
echo '<pre>';
echo '<hr /><h1> List of Users and their information </h1>';
echo $http->exec();
echo '</pre>';
$http->close();

  //Executing class for API 2
$http = new cURL("https://jsonplaceholder.typicode.com/todos");
$http->setopt(CURLOPT_HEADER, 0);
$http->setopt(CURLOPT_RETURNTRANSFER, 1);
echo '<pre>';
echo '<hr /><h1> List of TODOS </h1>';
echo $http->exec();
echo '</pre>';
$http->close();

?>

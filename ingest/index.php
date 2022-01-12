
<?php
if (isset($_POST['submit']))
{
		$method = $_POST['method'];
		$urlInput = 'http://sample_domain_endpoint.com/data?title={mascot}&image={location}&foo={bar}';
    $mascot = $_POST['mascot'];
		$location = $_POST['location'];
    $foo = $_POST['foo'];

}

?>
<html>

<head>
	<title>PHP Ingestion Agent</title>
</head>

<body>
	<h1>PHP Ingestion Agent</h1>
	<fieldset>
		<form id="form1" method="post" action="ingest.php">
			<?php
				if (isset($_POST['submit']))
				{
					if (isset($error))
					{
						echo "<p style='color:red;'>"
						. $error . "</p>";
					}
				}
				?>
				method:
				<input type="radio" value="GET" name="method" checked="checked"/> GET
        <input type="radio" value="POST" name="method"/> POST
				<br>
				<br>
				URL:
				<input type="text" 
          name="urlInput" 
          placeholder='http://sample_domain_endpoint.com/data?title={mascot}&image={location}&foo={bar}' 
          disabled 
          value='http://sample_domain_endpoint.com/data?title={mascot}&image={location}&foo={bar}'/>
				<br>
				<br>
        Mascot:
        <input type="text" name="mascot" placeholder="Gopher"/>
				<br>
				<br>
        Location:
        <input type="text" name="location" placeholder='https://bloc.golang.org/gopher/gopher.png'/>
				<br>
				<br>
        Foo:
        <input type="text" name="foo" placeholder="bar"/>
				<br>
				<br>
				<input type="submit" value="Submit" name="submit" />
		</form>
	</fieldset>
	<?php
	if(isset($_POST['submit']))
	{		
    // $url = 'redis';
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $data = array('method' => $method, 'url' => $urlInput, 'mascot' => $mascot, 'location' => $location, 'foo' => $foo);
    $endpoint = new stdClass();
    $endpoint->method = $method;
    $endpoint->url = $urlInput;
    $dataObj = new stdClass();
    $dataObj->mascot = $mascot;
    $dataObj->location = $location;
    $postDataObj = new stdClass();
    $postDataObj->endpoint = $endpoint;
    $postDataObj->data = array($dataObj);
    $postDataJson = json_encode($postDataObj);

    $redisUrl = "redis-server";
    //Connecting to Redis server on localhost 
    $redis = new Redis(); 
    echo "connecting to redis...";
    echo "<br>";
    $redis->connect($redisUrl); 
    echo "Connection to server sucessfully"; 
    echo "<br>";
    //store data in redis list 
    // $redis->rpush("postback-queue", serialize($postDataJson)); 
    $redis->rpush("postback-queue", $postDataJson); 
    $channel = "postback-queue-pub-sub";
    // $redis->publish($channel, serialize($postDataJson));
    $redis->publish($channel, $postDataJson);
    
    // Get the stored data and print it 
    $arList = $redis->lrange("postback-queue", 0 ,5); 
    echo "<br>";
    echo "Stored string in redis:: "; 
    print_r($arList); 
    echo "<br>";
    // echo stripslashes($arList[0]);
    echo "<br>";
	}
	?>
</body>

</html>


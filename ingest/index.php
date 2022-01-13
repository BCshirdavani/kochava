
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
    $data = array('method' => $method, 'url' => $urlInput, 'mascot' => $mascot, 'location' => $location, 'foo' => $foo);
    $endpoint = new stdClass();
    $endpoint->method = $method;
    $endpoint->url = $urlInput;
    $dataObj = new stdClass();
    $dataObj->mascot = $mascot;
    $dataObj->location = $location;
		$dataObj->foo = $foo;
    $postDataObj = new stdClass();
    $postDataObj->endpoint = $endpoint;
    $postDataObj->data = array($dataObj);
    $postDataJson = json_encode($postDataObj);

    $redisUrl = "redis-server";
    //Connecting to Redis server on localhost 
    $redis = new Redis(); 
    $redis->connect($redisUrl); 
    //publish data
    $channel = "postback-queue-pub-sub";
    $redis->publish($channel, $postDataJson);
    echo "<br>";
    echo "postback has been pushed to redis queue";
	}
	?>
</body>

</html>


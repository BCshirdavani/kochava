<!-- <html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php echo '<p>Hello World</p>'; ?> 
 </body>
</html> -->


<?php
if (isset($_POST['submit']))
{
		$method = $_POST['method'];
		$url = $_POST['url'];
    $mascot = $_POST['mascot'];
		$location = $_POST['location'];
    $foo = $_POST['foo'];
}
?>
<html>

<head>
	<title>Simple Form Processing</title>
</head>

<body>
	<h1>Form Processing using PHP</h1>
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
				<input type="text" name="url" placeholder="http://sample_domain.com"/>
				<br>
				<br>
        Mascot:
        <input type="text" name="mascot" placeholder="Gopher"/>
				<br>
				<br>
        Location:
        <input type="text" name="location" placeholder="https://bloc.golang.org/gopher/gopher.png"/>
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
    $data = array('method' => $method, 'url' => $url, 'mascot' => $mascot, 'location' => $location, 'foo' => $foo);

    $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { 
      echo "error";
    } else {
      var_dump($result);
      echo $result;
    }
    
    
    $url2 = 'https://jsonplaceholder.typicode.com/todos/1';
    $options2 = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'GET'
      )
    );
    $context2  = stream_context_create($options2);
    $result2 = file_get_contents($url2, false, $context2);
    if ($result2 === FALSE) {
      echo "Error";
    } else {
      echo $result2;
    }
  
	}
	?>
</body>

</html>


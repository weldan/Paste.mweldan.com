<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Paste!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">Paste!</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="index.php">New</a></li>
              <li class="active"><a href="archive.php">Archive</a></li>
              <li><a href="#myModal" data-toggle="modal">About</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
    
    <?php
    //get data from db
	require_once 'config.php';
	$db = new PDO(
		'mysql:host='.$db['host'].';dbname='.$db['name'].';charset=utf8', 
		$db['user'], 
		$db['pass']
	);    
	$stmt = $db->query("select * from items order by id desc");
	$output = $stmt->fetchAll();
	
	foreach($output as $out):
    ?> 

	<dl>
		<dt><?php echo $out['gist_id']; ?></dt>
		<dd>[ <a href="<?php echo $out['gist_url']; ?>" target="_blank">View</a> ]</dd>
		<dd> [ <a href="<?php echo $out['gist_rawurl']; ?>" target="_blank">Download</a> ]</dd>
	</dl>
	
	<?php
	endforeach;
	?>

    </div> <!-- /container -->
    
	<!-- About Modal -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">About</h3>
	  </div>
	  <div class="modal-body">
		<p>Paste! by <a href="http://mweldan.com">Weldan Jamili</a></p>
	  </div>
	  <div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
	  </div>
	</div>    

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>


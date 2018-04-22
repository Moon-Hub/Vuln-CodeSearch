<?php

/* === [ FOR USE WITH COMMAND LINE INTERFACE ] ===

 - EG: php myscript.php -a foo -b bar -c baz
   
   OUTPUT -

   Array
   	(
   		[a] => foo
   		[b] => bar
   		[c] => baz
   	)

*/

// GRAB OUR FUNCTIONS FOR USE
include 'inc/functions.php';

set_time_limit(0); // NEEDS LONG EXECUTION TIME IF USING MANY SEARCH TERMS FROM FILE

// CLI VARIABLES -- SEARCH PARAMETERS ( >php index.php -l [language] -p [num_per_page] > output.php )
$args = getopt("l:p:");

// SEARCH TERMS - FROM FILE
$tests = file('SearchTerms.txt');

$lang = '';
$pp = '';

$lang = $args['l'];
$pp = $args['p'];

// AUTHENTICATION VARIABLES
$user = 'user';
$pwd = 'password';

// $term = '$_GET["cmd';
// $lang = 'php';
// $pp = '5';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>GitHub CodeSearch</title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> <!-- Import Open Source Icons-->
	<link href="css/main.css" rel="stylesheet">
</head>
<body>

	<div class="container d-flex h-100" id="loader">
		<div class="row" style="width: 100%;" id="mob">
			<div class="card border-primary mb-3 text-center justify-content-center align-self-center" style="width: 100%;">
				<div class="card-block" style="width: 100%;">
					<div class="progress">
						<div id="bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 100%"><strong>Loading</strong></div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">GitHub CodeSearch</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Main
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://github.com/">GitHub</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="" data-toggle="modal" data-target="#disclaimer">Disclaimer</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>


    <div class="container" id="top">
    	<div class="modal fade" id="disclaimer">
    		<div class="modal-dialog modal-lg" role="document">
    			<div class="modal-content">
    				<div class="modal-header">
    					<h5 class="modal-title">Disclaimer</h5>
    				</div>
    				<div class="modal-body">
    					<h5>Considerations for code search</h5>
    					<p>Due to the complexity of searching code, there are a few restrictions on how searches are performed:</p>
    					<ul class="list-group">
    						<li class="list-group-item">Only the default branch is indexed for code search. In most cases, this will be the <code>master</code> branch.</li>
    						<li class="list-group-item">Forks with fewer stars than the parent repository are <strong>not</strong> indexed for code search</li>
    						<li class="list-group-item">Only files smaller than 384 KB are searchable.</li>
    						<li class="list-group-item">Only repositories with fewer than 500,000 files are searchable.</li>
    						<li class="list-group-item">Logged in users can search all public repositories while anonymous searches must include a limit on <code>org:</code>, <code>user:</code>, or <code>repo:</code>.</li>
    						<li class="list-group-item">Except with <code>filename</code> searches, you must always include at least one search term when searching source code. For example, searching for <code>language:javascript</code> is not valid, while <code>amazing language:javascript is.</code></li>
    						<li class="list-group-item">At most, search results can show two fragments from the same file, but there may be more results within the file.</li>
    						<li class="list-group-item">You can't use the following wildcard characters as part of your search query: <code>. , : ; / \ ` ' " = * ! ? # $ &mp; + ^ | ~ < > ( ) { } [ ]</code>. The search will simply ignore these symbols.</li>
    					</ul>
    				</div>
    				<div class="modal-footer">
    					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</div>
    	</div>

    <?php

 	foreach($tests as $term) { // LOOP THROUGH EACH SEARCH TERM IN THE TEXT FILE - TRY NOT TO USE MORE THAN 5 AT A TIME

 		// GRAB FIRST API CONNECTION
 		include 'inc/connections/codeconnection.php';

    ?>

    	<div class="alert alert-info alert-dismissible fade show" role="alert">
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
    		</button>
    		<strong>Total Results:</strong> <?php echo number_format($items['total_count']) ?>
    	</div>

    	<?php 

	    	foreach($items['items'] as $item) { 

			// GRAB SECOND API CONNECTION
			include 'inc/connections/repoconnection.php';

		?>

		<div class="card">
			<h3 class="card-header">
				<img src="<?php echo $item['repository']['owner']['avatar_url'] ?>"
					height="35" width="35" class="img-thumbnail" alt="<?php echo $item['repository']['owner']['login'] . ' Avatar' ?>"">
					<span class="displace"> <?php echo $item['repository']['owner']['login']?> / 
						<a href="<?php echo $item['repository']['html_url'] ?>" alt="Repository Url"><?php echo $item['repository']['name'] ?></a>
					</span>
					<span class="stars">
						<?php echo '<span class="badge badge-primary stargazer"><i class="fa fa-star"></i> ' . number_format($repo['items'][0]['stargazers_count']) . '</span>' ?>
					</span>
			</h3>
			<div class="card-block">
				<div class="row">
					<div class="col-md-5">
						<ul class="list-group">

						<?php

							for($i = 0; $i < count($item['text_matches']); $i++) {

							// WE WANT TO GRAB THE EXACT LINE IN THE FILE THAT OUR CODE FRAGMENT IS IN  - SO WE NEED ANOTHER API CONNECTION 
							// TAKE OUR THE TEXT_MATCHES OBJECT URL TO GRAB THE DOWNLOADABLE FILE
							include 'inc/connections/objurlconnection.php';

							// PUT OUR RAW FILE INTO A BUNCH OF ARRAYS - EG EACH LINE OF FILE - $FILE[0] $FILE[1] ETC
							$searchterm = htmlspecialchars($item['text_matches'][$i]['matches'][0]['text']);
							
							$file = @file($obj['download_url']);

							// THE SNIPPET
							$search = htmlspecialchars($item['text_matches'][$i]['fragment']);

							$line_number = false;
							$error = '';
		
							// LOCATE THE FRAGMENT USING THE MATCH TEXT
							if($file != null) {
								while (list($key, $line) = each($file) and !$line_number) {
									$line_number = (strpos($line, $searchterm) !== FALSE) ? $key + 1 : $line_number;
								}
							} else {
								$error = 'Line: <span class="badge badge-danger">Not Available - API ERROR';
							}

						?>
							<li class="list-group-item">Search Fragment: <code><?php echo $searchterm ?></code></li>
							<li class="list-group-item">File Name: 
								<a href="<?php echo $item["html_url"] ?>" title="File Url">
									<?php 

									// IF FILENAME IS TOO LONG, SHORTEN IT
									if(strlen($item['name']) > 25) {
										$substr = substr($item['name'], 0, 25);
										echo $substr . '...';
									} else {
										echo $item['name'];
									}

									?>	
								</a>
							</li>
							<li class="list-group-item"> 
								<?php 
								if($line_number != null) {
									echo 'Line: <span class="badge badge-primary">' .$line_number; 
								} else {
									echo $error;
								}
								?>
								</span>
							</li>
						</ul>
					</div>
					<div class="col-md-7">
						<div class="card" id="code">
							<div class="card-block">
								<?php echo '<pre><span class="color">' . $search . '</span></pre>'; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php 

								}
							}

	?>

	<?php 

						}				

	?>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $('#loader').remove();
    $('#top').fadeToggle();
});
</script>
</body>
</html>
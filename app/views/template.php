
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>GasPHP - <?php echo $title; ?></title>
    <link href="<?php echo BASEURL; ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo BASEURL; ?>css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo BASEURL; ?>css/styles.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo BASEURL; ?>">GasPHP</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li><a href="<?php echo BASEURL; ?>">Home</a></li>
              <li><a href="<?php echo BASEURL; ?>welcome/docs">Docs</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
      <?php echo $content; ?>
    </div><!-- /container -->
    <footer></footer>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo BASEURL; ?>js/jquery-1.8.2.min.js"><\/script>')</script>
    <script src="<?php echo BASEURL; ?>js/bootstrap.min.js"></script>
    <script src="<?php echo BASEURL; ?>js/scripts.js"></script>
  </body>
</html>
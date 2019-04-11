<!DOCTYPE html>
<html>
    <head>
    	<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    	<title><?php echo gettitle()?></title>
    	<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
    	<link rel="stylesheet" href="<?php echo $css; ?>front.css" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
      <div class="upper_bar">
        <div class="container">
          <?php 
              if (isset($_SESSION['user'])) {
                  echo "Welcmoe " . $sessionuser . ' ';
                  echo '<a href="profile.php">My Profile</a>';
                  echo ' - <a href="new_ad.php">New ad</a>';
                  echo ' - <a href="logout.php">Logout</a>';
                 $userstat = checkuserstatus($sessionuser);
                 if ($userstat == 1) {
                    // user is not activ
                 }
              } else {
          ?>
          <a href="login.php">
            <span class="pull-right">Login/Signup</span>
          </a>
        <?php } ?>
        </div>
      </div>
      <nav class="navbar navbar-inverse">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><?php echo lang('HOME_ADMIN')?></a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav navbar-right">
              <?php 
                foreach (getcat() as $cat) {
                  echo '<li>
                          <a href="cat.php?pageid='. $cat['id'] . '">
                            '. $cat['name'] . 
                          '</a>
                        </li>';
                }
              ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
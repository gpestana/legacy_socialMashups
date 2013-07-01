<?php 

// We include PHP SDK v.3.0.0 of Facebook.   
    require 'php-sdk/facebook.php';
 
// Create a new Facebook object with the data application, the id and the secret number.
    $facebook = new Facebook(array(
      'appId'  => '221112868027944',
      'secret' => '177ebfee0eaff80bf6e788d51e52b3dd',
    ));

// We get the id of the user
    $user = $facebook->getUser();
 
// And we control if the user is authenticated
 
    if ($user) {
      try {
        // We create two variables, one with the information about the user, and the other with the information about the friends
        $user_profile = $facebook->api('/me');
        $user_friends_data = $facebook->api('/me/friends', 'get', array("fields"=>"name,id,hometown"));
      } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
      }
    }

    if ($user) {
      $logoutUrl = $facebook->getLogoutUrl();
    } else {
      $loginUrl = $facebook->getLoginUrl( array(
                    'scope' => 'publish_stream,user_about_me,user_hometown,friends_hometown'
                ));
    }
        if (!$user) {
            echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";
            exit;
        }
?>



<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../public_html/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style>
         body {
           padding-top: 60px;
           padding-left: 90px;
         }
    </style>
      <script src="http://connect.facebook.net/en_US/all.js"></script>
      <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
      <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>

    <title></title>
        
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

        <a class="brand" href="http://group03.naf.cs.hut.fi/pestana_workbench/public_html/index.php" target='_blank'>Group3</a>
        <div class="nav-collapse collapse">
          <ul class="nav">
            <li><a href="http://group03.naf.cs.hut.fi/pestana_workbench/public_html/contact.php" target='_blank'>Contact</a></li>
            <li><a href="http://group03.naf.cs.hut.fi/pestana_workbench/public_html/aboutyou.php" target='_blank'>About(you!)</a></li>
            <li><a href="http://group03.naf.cs.hut.fi/pestana_workbench/public_html/photouploader.php" target='_blank'>Photo Uploader</a></li>
            <li><a href="http://group03.naf.cs.hut.fi/pestana_workbench/public_html/buddiesbdays.php" target='_blank'>Buddies' Bdays</a></li>
            <li class = "active"><a href="http://apps.facebook.com/webappframe/" target='_blank'>Canvas</a></li>
          </ul>
        </div>
      </div>
    </div>
    </div>

    <div class="container-fluid">
    <div class="row-fluid">

    <!--Main content-->
    <div class="span10">

      <!-- title -->
      <div class="span12">
        <h1>Friends HomeTown</h1><br>
      </div>

      <div id="cont"></div>

      <div class="row">
        <!-- picture -->
        <div class="span4">
          <!-- get the user information -->
          <h3>You!</h3>
          <center><img class='img-rounded' src="https://graph.facebook.com/<?php echo $user_profile['id']; ?>/picture?type=large"><br/><br/>
          <form method='post' action='generateMap.php' target='_blank'>
          <input type='hidden' name='hTown' value='<?php echo $user_profile['hometown']['name']; ?>' >
          <button class='btn btn-large btn-primary' name='send' type='submit'>My HomeTown</button> 
          </form> 

        </div>

        <!-- get the user friends information -->
        <div class="span8">

            <?php
              $count = 0;
              foreach ($user_friends_data as $user_data) {
                foreach ($user_data as $key => $value) {
                  if ($count == 0) {
                    echo "<div class='row'>";
                  }
                  echo "<div class='span3'>";
                  echo $value['name']."<br/>";
                  echo "<img class='img-rounded' src='https://graph.facebook.com/" . $value['id'] . "/picture?type=large'><br/><br/>";
                  
                  if (!empty($value['hometown']['name'])){
                    $city = $value['hometown']['name'];
                    echo "<form method='post' action='generateMap.php' target='_blank'>
                          <input type='hidden' name='hTown' value=".$city.">
                          <button class='btn btn-mini btn-primary' name='send' type='submit'>HomeTown</button>
                          </form>";
                  }
                  echo "<br/>";
                  echo "<br/></div>";
                  $count++;
                  if ($count == 4 ) {
                    echo "</div>";
                    $count = 0;
                  }
                }
              }
              if ($count != 0) {
                echo "</div>";
              }
              ?>
        </div>
      </div>


    </div>
  </div>
</div>
      <?php //foreach($user_friends as $key=>$value){
       /*foreach($user_friends_data as $user_data){
            foreach($user_data as $key=>$value){
                if (empty($value['hometown']['name'])) {
                    echo "no";
                    echo '<br/>';
                }
                else {
                    echo $value['id'];
                    echo '<br/>';
                    echo $value['hometown']['name'];
                    echo '<br/>';
                }
            }
            //echo $value['hometown']['name'];
          //echo $value[0];
      }
      foreach ($user_friends_data as $user_data) {
        foreach ($user_data as $key => $value) {
          echo "<div class='span3'>";
          echo $key."-> ".$value['name']."<br/>";
          echo "<img class='img-rounded' src='https://graph.facebook.com/" . $value['id'] . "/picture?type=large'>";
          echo "</div>";
        }
        print_r($user_data);
      }*/
      ?>
  </body>
</html>



<!--
<html>
<head>
<meta charset="UTF-8" />
</head>
<body style="background-color: yellow; margin:0 auto; padding:20px;">
    <div style="height: 500px; background:#EEEEFF; padding: 10px;">
        <h1>Canvas app</h1>
        <p id="step1" style="display: none;">Estás desconectado de esta aplicación. Pulsa <a href="#" onclick="connect()">aquí</a> para conectar y acceder al contenido privado.</p>
        <p id="step2" style="display: none;">Estás en el contenido privado de esta aplicación  
        <br /><br />Si ya habías concedido permisos a esta aplicación, puedes borrarlos en los <a href="http://www.facebook.com/settings/?tab=applications" target="_blank">ajustes de aplicaciones</a> para ver el diálogo OAuth.</p>
    </div>
    <div id="fb-root"></div>


    <script type="text/javascript" src="http://connect.facebook.net/es_ES/all.js"></script>
    <script type="text/javascript">
        FB.init({
            appId  : '221112868027944',
            status : true, // comprobar estado de login
            cookie : true, // habilitar cookies para permitir al servidor acceder a la sesión
            xfbml  : true, // ejecutar código XFBML
            channelURL : 'http://www.webberis.com/WAF/channel.html', // fichero channel.html
            oauth  : true // habilita OAuth 2.0
        });

        FB.getLoginStatus(function(response) {
            if (response.authResponse) {
                document.getElementById('step2').style.display = 'block';
            } else {
                document.getElementById('step1').style.display = 'block';
            }
        });

        function connect() {
            top.location.href = 'https://www.facebook.com/dialog/oauth?client_id=221112868027944&redirect_uri=http://apps.facebook.com/webappframe/&scope=publish_stream,friends_hometown'
        }
    </script>
</body>
</html>-->

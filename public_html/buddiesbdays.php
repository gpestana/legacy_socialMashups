 <!DOCTYPE html>

 <html>
 <head>
  <title>GROUP 3 Network Application Framework - Social Mashups</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <!-- Style -->
  <style>
  body {
    padding-top: 60px;
  }
  </style>
  <!-- JavaScript & JQuery -->

  <!-- imports -->
  <script type="text/javascript">  


  // Additional JS functions here
  function fbAsyncInit() {
    FB.init({
      appId      : '304879432972669', // App ID
      channelUrl : '//http://group03.naf.cs.hut.fi/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });


//
FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    //you're logged in!    
    $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='logout()' type='button'>Facebook LOGOUT</button>");

    $("#calendarButton").html(" <a href='#' id='authorize-button' onclick='handleAuthClick();'>Generate Calendar</a>");

    console.log("connected to fb");
              


  } else if (response.status === 'not_authorized') {
    //not authorized
    $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='login()' type='button'>Facebook LOGIN</button>");


console.log("not_auth");

  } else {
    //not logged in
    $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='login()' type='button'>Facebook LOGIN</button>");


console.log("not_log");

  }
});
};

  // Load the SDK Asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
 }(document));

//LogIN function
function login() {
  FB.login(function(response) {
    if (response.authResponse) {
      window.location.href = "index.php";
    } else {
            // cancelled (error?)
          }
        },{scope: 'email,read_friendlists,manage_friendlists,friends_birthday,user_photos,friends_photos,publish_actions'}); //extended token permissions
}

//LogOut function
function logout() {
  FB.logout(function(response) {
    alert('You are not logged in anymore!');
    window.location.href = "index.php";
  });
}


//Facebook Like and Twitter
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=304879432972669";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

!function(d,s,id){
  var js,fjs=d.getElementsByTagName(s)[0];
  if(!d.getElementById(id)){
    js=d.createElement(s);
    js.id=id;js.src="//platform.twitter.com/widgets.js";
    fjs.parentNode.insertBefore(js,fjs);
  }
}
(document,"script","twitter-wjs");


</script>

</head>

<body>

  <!-- MENU -->

  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>

        <a class="brand" href="index.php">Group3</a>
        <div class="nav-collapse collapse">
          <ul class="nav">
            <li><a href="contact.php">Contact</a></li>
            <li><a href="aboutyou.php">About(you!)</a></li>
            <li><a href="photouploader.php">Photo Uploader</a></li>
            <li class ="active"><a href="buddiesbdays.php">Buddies' Bdays</a></li>
            <li><a href="http://apps.facebook.com/webappframe/">Canvas</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- /MENU -->

  <div id="fb-root"></div>

  <div class="container-fluid">
    <div class="row-fluid">
     <div class="span2">
      <!--Sidebar content-->

      <div id="fbbutton"></div>
      <br>
      <br>
      <div id="likes">
        <div class="fb-like" data-href="http://http://group03.naf.cs.hut.fi/" data-send="false" data-layout="button_count" data-width="550" data-show-faces="true"></div>
       <!-- <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a> -->

      </div>


    </div>
    <div class="span10">
      <!--Body content-->

      <h1>Buddies Bdays!</h1><br>


      <div id="calendarButton"></div>


      <div id="calendarCreated"></div>

      <div id="calendar"></div>

      <div id="eventsTitle"></div>
      <div id="events"></div>

    </div>

  </div>



</div>
</div>


</div>
</body>

  <script src="http://connect.facebook.net/en_US/all.js"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script src="http://connect.facebook.net/en_US/all.js"></script>
  <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
  <!-- google calendar lib written by us -->
  <script src="googlecalendar.js"></script>


</html>

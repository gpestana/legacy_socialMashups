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
      channelUrl : '//http://http://group03.naf.cs.hut.fi/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });


//
FB.getLoginStatus(function(response) {
  if (response.status === 'connected') {
    //you're logged in!    
      //fbbutton
      $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='logout()' type='button'>Facebook LOGOUT</button>");

      $("#photostitle").append("<h4>Random Photos</h4>");
      $("#friendstitle").append("<br><h4>Random Friends</h4>");

      getPicture();
      getPersonalInfo();

      getLastFeed();
      getRandomPics();
      getFriends();


    } else if (response.status === 'not_authorized') {
    //not authorized
      //fbbutton
      $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='login()' type='button'>Facebook LOGIN</button>");

      $("#cont").html("<p> You can navigate in this website only if you are logged on Facebook. Use the button to log in.</p><br>");


    } else {
    //not logged in
      //fbbutton
      $("#fbbutton").html(" <button class='btn btn-large btn-primary' onclick='login()' type='button'>Facebook LOGIN</button>");

      $("#cont").html("<p> You can navigate in this website only if you are logged on Facebook. Use the button to log in.</p><br>");


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
      window.location.href = "http://group03.naf.cs.hut.fi/pestana_workbench/public_html/aboutyou.php";
    } else {
            // cancelled (error?)
          }
        },{scope: 'email,read_friendlists,manage_friendlists,friends_birthday,user_photos,friends_photos,publish_actions'}); //extended token permissions
}

//LogOut function
function logout() {
  FB.logout(function(response) {
    alert('You are not logged in anymore!');
    window.location.href = "aboutyou.php";
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


  //fetch user profile picture
  function getPicture() {

    FB.api('/me', function(response) {

      var pic = "https://graph.facebook.com/"+response.id+"/picture?type=large";

      $("#picture").html("<center><img src="+pic+" class='img-rounded'></center>");

    });

  }

//get some personal information
function getPersonalInfo() {

  FB.api('/me', function(response) {

    $("#personalinfo").html("<center><b>"+response.name+"</b><br>");
    $("#personalinfo").append("<center>"+response.email+"<br>");
    $("#personalinfo").append("<center>"+response.hometown.name+"<br>");
  });

}

//get 3 random pictures
function getRandomPics() {
  FB.api('/me/photos', function(response) {

    nr_photos = response.data.length;

    var rand1 = Math.floor(Math.random()*nr_photos);
    var rand2 = Math.floor(Math.random()*nr_photos);
    var rand3 = Math.floor(Math.random()*nr_photos);

    $("#photo1").html("<center><a href="+response.data[rand1].source+"><img src="+response.data[rand1].source+" class='img-rounded'></center><a>");
    $("#photo2").html("<center><a href="+response.data[rand2].source+"><img src="+response.data[rand2].source+" class='img-rounded'></center><a>");
    $("#photo3").html("<center><a href="+response.data[rand3].source+"><img src="+response.data[rand3].source+" class='img-rounded'></center><a>");



  });
}

//get 3 first friends
function getFriends() {

  var userID;
  //get user ID
  FB.api('/me/friends', function(response) {

    var c = 0;
    if(response.data) {

      //get 3 random friends
      nr_friends = response.data.length;

      //set nr of friends
      $("#nrfriends").html("<p> You have <b>"+ nr_friends +"</b> friends.</p><br>");

      var rand1 = Math.floor(Math.random()*nr_friends);
      var rand2 = Math.floor(Math.random()*nr_friends);
      var rand3 = Math.floor(Math.random()*nr_friends);

      //profile link ??
      var pic1 = "https://graph.facebook.com/"+response.data[rand1].id+"/picture?type=large";
      $("#friend1").html("<a href=http://facebook.com/"+response.data[rand1].id+"><center><img src="+pic1+" class='img-rounded'></center><a>");

      var pic2 = "https://graph.facebook.com/"+response.data[rand2].id+"/picture?type=large";
      $("#friend2").html("<a href=http://facebook.com/"+response.data[rand2].id+"><center><img src="+pic2+" class='img-rounded'></center></a>");

      var pic3 = "https://graph.facebook.com/"+response.data[rand3].id+"/picture?type=large";
      $("#friend3").html("<a href=http://facebook.com/"+response.data[rand3].id+"><center><img src="+pic3+" class='img-rounded'></center></a>");


    } else {
      location.reload();
    }
  });
}

 //get last feed
 function getLastFeed() {
  FB.api('/me/feed', function(response) {

    $("#lastfeed").html("<b>Your last feed:</b><p>"+response.data[0].story+"</p><br>");

  });
}

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
            <li class = "active"><a href="aboutyou.php">About(you!)</a></li>
            <li><a href="photouploader.php">Photo Uploader</a></li>
            <li><a href="buddiesbdays.php">Buddies' Bdays</a></li>
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

     <!--Sidebar content-->
     <div class="span2">
      <!-- login/logout button -->
      <div id="fbbutton"></div>
      <br>
      <br>
      <div id="likes">
        <div class="fb-like" data-href="http://http://group03.naf.cs.hut.fi/" data-send="false" data-layout="button_count" data-width="550" data-show-faces="true"></div>
        <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
      </div>

    </div>

    <!--Main content-->
    <div class="span10">

      <!-- title -->
      <div class="span12">
        <h1>About(you)</h1><br>
      </div>

      <!-- Not log in advertisement -->
      <div id="cont"></div>

      <div class="row">
        <!-- picture -->
        <div class="span3">

          <div id="picture"></div>
          <br><br>
          <div id="personalinfo"></div>

        </div>

        <!-- info -->
        <div class="span6">

          <div id="nrfriends"></div>

          <div id="lastfeed"></div>

          <div class="row">
            <div id="photostitle"></div>
            <div class="span3" id="photo1"></div>
            <div class="span3" id="photo2"></div>
            <div class="span3" id="photo3"></div>
          </div>  

          <div class="row">
            <div id="friendstitle"></div>
            <div class="span3" id="friend1"></div>
            <div class="span3" id="friend2"></div>
            <div class="span3" id="friend3"></div>
          </div>  

        </div>
      </div>


    </div>
  </div>
</div>
</div>

</body>

  <script src="http://connect.facebook.net/en_US/all.js"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
</html>

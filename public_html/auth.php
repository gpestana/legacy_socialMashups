<script>

//vars
var clientId = '402017866531-ppf3schgpa7gktq9lboragbu3r3s39bu.apps.googleusercontent.com';
var apiKey = 'AIzaSyB7IjGYJ8BwDySjfWLHymNS5-XTU_WaIek';
var scopes = 'https://www.googleapis.com/auth/calendar';

//after click login button
function handleClientLoad() {
  gapi.client.setApiKey(apiKey);
  window.setTimeout(checkAuth,1);
  checkAuth();
}

//check if client had authorized the application and calss handleAuthResult to handle it
function checkAuth() {
  gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true},
    handleAuthResult);
}


function handleAuthResult(authResult) {
  var authorizeButton = document.getElementById('authorize-button');

//if the client already had gave authorization
if (authResult) {
  authorizeButton.style.visibility = 'hidden';
  makeApiCall();

//if not, calls handleAuthClick to ask for permission
} else {
  authorizeButton.style.visibility = '';
  authorizeButton.onclick = handleAuthClick;
}
}

//ask for permission!
function handleAuthClick(event) {
  gapi.auth.authorize(
    {client_id: clientId, scope: scopes, immediate: false},
    handleAuthResult);
  return false;
}

//finally, with the authorization, the google calendar is accessed
function makeApiCall() {
  gapi.client.load('calendar', 'v3', function() {
    var request = gapi.client.calendar.events.list({
      'calendarId': 'primary'
    });

    request.execute(function(resp) {
      for (var i = 0; i < resp.items.length; i++) {
        var li = document.createElement('li');
        li.appendChild(document.createTextNode(resp.items[i].summary));
        document.getElementById('events').appendChild(li);
      }
    });
  });
}

</script>

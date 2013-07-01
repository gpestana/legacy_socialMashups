/*
 This Library handles the Google Calendar authorizations and logic to displays
the Facebook friends' birthdays in a GCalendar.
*/

//vars
//NAF2
var clientId = '402017866531-ppf3schgpa7gktq9lboragbu3r3s39bu.apps.googleusercontent.com';
var apiKey = 'AIzaSyB7IjGYJ8BwDySjfWLHymNS5-XTU_WaIek';
//NAF3
//var clientId = '13643687683.apps.googleusercontent.com';
//var apiKey = 'AIzaSyCgE19E4JN-_1n--u-5DkFDWqL6RB8AuTY';

var scopes = 'https://www.googleapis.com/auth/calendar';
var events = new Array();
var calID;
var nr_friends = 20;


/*
function generateCalendar(nrFriends) {
  nr_friends = nrFriends;
  handleAuthClick();
}
*/

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
  //init Calendar
  initCalendar();

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

//1st Initialize 
function initCalendar() {

  console.log("InitCalendar()");

//asynchronous api request 
gapi.client.load('calendar', 'v3', function() {

  var request = gapi.client.calendar.calendarList.list({
    'fields': 'items(summary,id)'
  });

//check if calendar already exists
request.execute( function(resp) {
  var exists = false;

  for(var i =0; i<resp.items.length;i++) {

    if(resp.items[i].summary == 'NAFcalendar') {
      exists = true;

      console.log("Calendar exists with Id: "+resp.items[i].id);
      //show calendar!!
      calID = resp.items[i].id;

      showCalendar(resp.items[i].id);
      $("#calendarCreated").html("<h4>Calendar already exists!</h4>");

    }
  }

    //if calendar does not exists, create new one, populate and show it!!
    if(exists==false) {

      //create calendar
      var request = gapi.client.calendar.calendars.insert({
        "resource" : {
          'calendarId': 'NAFcalendar',
          'summary': 'NAFcalendar',
          'description':'NAF Calendar!'
        }
      });

      request.execute( function(resp) {
        console.log("NEW CALENDAR CREATED: ");
        console.log(resp);
        //populate calendar
        calID = resp.id;
        populate(resp.id);
      });
      //calendar already exists => show calendar
      //showCalendar(resp.id);
    }

  }); 
});
}


//3rd populate calendar

//wait for callback funtion
function populate(calendarId) { 

  console.log("populating calendar "+calendarId);

  //query
  FB.api(
  {
    method: 'fql.query',
    query: 'SELECT name,birthday,uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me())'

  //function that handles request
}, function(response) {

  var date = new Date();
  var month;
  var sp;
  var sp2;

    for (var i=0; i<nr_friends; i++) {

     if(response[i].birthday != null) {

      //convertData
      sp=response[i].birthday.split(" ");
      sp2=sp[1].split(",");

      month = parseMonth(sp[0]);

      date = new Date(2013,parseInt(month),parseInt(sp2[0]));

      //BAT OK!
      console.log(date);

      //define New Event
      var newEvent = {
        "summary": response[i].name+" BDay!!",
        "start": {
          "dateTime": date
        },
        "end": {
          "dateTime": date
        }
      };      

/*
      // BAT0: OK!!
      console.log("->");
      console.log(newEvent);
     */

      events.push(newEvent);
    } //closes if != null
  } //closes for

console.log("------ last BAT:");
console.log(events[0]);
console.log(events[1]);
console.log(events[2]);
console.log("------")



var makeRequest = function(resource) {
  //console.log(resource);
  var request = gapi.client.calendar.events.insert({
    'calendarId': calendarId,
    'resource': resource
  });
  request.execute(function(resp) {
    console.log(resp);
  });
};

for(var j = 0; j<events.length; j++) {
  makeRequest(events[j]);
}

      $("#calendarCreated").html("<h4>Calendar created with success!</h4>");
showCalendar(calendarId);

}); //closes callback


}



function showEvents() {
  console.log(events);
}


function showCalendar(calendarId) {
  console.log("showCalendar with id: "+calendarId);
  console.log("https://www.google.com/calendar/embed?src="+calendarId+"&ctz=Europe/Helsinki");

  $("#calendar").html("<a href='http://google.com/calendar'>Check the calendar</a>");
  $("#eventsTitle").html(" <a href='#' onclick='showEventsList();'>Show Bday events list</a>");

  //showEventsList(calendarId);

//does not work and we don't know why...
//  $("#calendar").html("<iframe src='https://www.google.com/calendar/embed?src="+calendarId+"&ctz=Europe/Helsinki' style='border: 0' width='800' height='600' frameborder='0' scrolling='no'></iframe>");

}


function parseMonth(rawDate) {

  var month;

  switch(rawDate)
  {
    case "January":
    month = "00";
    break;
    case "February":
    month = "01"
    break;
    case "March":
    month = "02";
    break;
    case "April":
    month = "03";
    break;
    case "May":
    month = "04";
    break;
    case "June":
    month = "05";
    break;
    case "July":
    month = "06";
    break;
    case "August":
    month = "07";
    break;
    case "September":
    month = "08";
    break;
    case "October":
    month = "9";
    break;
    case "November":
    month = "10";
    break;
    default:
    month = "11";
  }

  return month;

}

//Show all the events in the calendar!
function showEventsList() {
  gapi.client.load('calendar', 'v3', function() {
    var request = gapi.client.calendar.events.list({
      'calendarId': calID
    });
          
  $("#eventsTitle").html("<br><br><h4>Events List:</h4>");

    request.execute(function(resp) {
      for (var i = 0; i < resp.items.length; i++) {
        var li = document.createElement('li');
        li.appendChild(document.createTextNode(resp.items[i].summary+" at "+resp.items[i].start.dateTime));
        document.getElementById('events').appendChild(li);
      }
    });
  });
}
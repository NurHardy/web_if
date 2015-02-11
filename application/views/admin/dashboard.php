<div>
	<button id="authorize-button" style="visibility: hidden">Authorize</button><br/>
    <button id="make-api-call-button" style="visibility: hidden">Get Sessions</button>
</div>

<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
<script>

var clientId = '619433855171-ellh8as0mnr720d6uo6i6a06bqv5qsl2.apps.googleusercontent.com';
var apiKey = 'AIzaSyCB_Tzs_EZ1exoXELhuq_sOlkqhrifjezw';
var scopes = 'https://www.googleapis.com/auth/analytics.readonly';

// This function is called after the Client Library has finished loading

$(document).ready(function(){
	//handleClientLoad();
});
function handleClientLoad() {
	alert("Hello!");
  gapi.client.setApiKey(apiKey);
  window.setTimeout(checkAuth,1);
}

function checkAuth() {
  gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
}

function handleAuthResult(authResult) {
  if (authResult) {
    // The user has authorized access
    // Load the Analytics Client. This function is defined in the next section.
    loadAnalyticsClient();
  } else {
    // User has not Authenticated and Authorized
    handleUnAuthorized();
  }
}


// Authorized user
function handleAuthorized() {
	alert('handleAuthorized');
	
  var authorizeButton = document.getElementById('authorize-button');
  var makeApiCallButton = document.getElementById('make-api-call-button');

  makeApiCallButton.style.visibility = '';
  authorizeButton.style.visibility = 'hidden';
  makeApiCallButton.onclick = makeApiCall;
}


// Unauthorized user
function handleUnAuthorized() {
	alert('handleUnAuthorized');
  var authorizeButton = document.getElementById('authorize-button');
  var makeApiCallButton = document.getElementById('make-api-call-button');

  makeApiCallButton.style.visibility = 'hidden';
  authorizeButton.style.visibility = '';
  authorizeButton.onclick = handleAuthClick;
}


function handleAuthClick(event) {
  gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
  return false;
}


function loadAnalyticsClient() {
  // Load the Analytics client and set handleAuthorized as the callback function
  gapi.client.load('analytics', 'v3', handleAuthorized);
}


function makeApiCall() {
  queryAccounts();
}

function queryAccounts() {
  console.log('Querying Accounts.');

  // Get a list of all Google Analytics accounts for this user
  gapi.client.analytics.management.accounts.list().execute(handleAccounts);
}

function handleAccounts(results) {
  if (!results.code) {
    if (results && results.items && results.items.length) {

      // Get the first Google Analytics account
      var firstAccountId = results.items[0].id;

      // Query for Web Properties
      queryWebproperties(firstAccountId);

    } else {
      console.log('No accounts found for this user.')
    }
  } else {
    console.log('There was an error querying accounts: ' + results.message);
  }
}

function queryWebproperties(accountId) {
  console.log('Querying Webproperties.');

  // Get a list of all the Web Properties for the account
  gapi.client.analytics.management.webproperties.list({'accountId': accountId}).execute(handleWebproperties);
}

function handleWebproperties(results) {
  if (!results.code) {
    if (results && results.items && results.items.length) {

      // Get the first Google Analytics account
      var firstAccountId = results.items[0].accountId;

      // Get the first Web Property ID
      var firstWebpropertyId = results.items[0].id;

      // Query for Views (Profiles)
      queryProfiles(firstAccountId, firstWebpropertyId);

    } else {
      console.log('No webproperties found for this user.');
    }
  } else {
    console.log('There was an error querying webproperties: ' + results.message);
  }
}

function queryProfiles(accountId, webpropertyId) {
  console.log('Querying Views (Profiles).');

  // Get a list of all Views (Profiles) for the first Web Property of the first Account
  gapi.client.analytics.management.profiles.list({
      'accountId': accountId,
      'webPropertyId': webpropertyId
  }).execute(handleProfiles);
}

function handleProfiles(results) {
  if (!results.code) {
    if (results && results.items && results.items.length) {

      // Get the first View (Profile) ID
      var firstProfileId = results.items[0].id;

      // Step 3. Query the Core Reporting API
      queryCoreReportingApi(firstProfileId);

    } else {
      console.log('No views (profiles) found for this user.');
    }
  } else {
    console.log('There was an error querying views (profiles): ' + results.message);
  }
}

function queryCoreReportingApi(profileId) {
  console.log('Querying Core Reporting API.');

  // Use the Analytics Service Object to query the Core Reporting API
  gapi.client.analytics.data.ga.get({
    'ids': 'ga:' + profileId,
    'start-date': '2012-03-03',
    'end-date': '2012-03-03',
    'metrics': 'ga:sessions'
  }).execute(handleCoreReportingResults);
}

function handleCoreReportingResults(results) {
  if (results.error) {
    console.log('There was an error querying core reporting API: ' + results.message);
  } else {
    printResults(results);
  }
}

function printResults(results) {
  if (results.rows && results.rows.length) {
    console.log('View (Profile) Name: ', results.profileInfo.profileName);
    console.log('Total Sessions: ', results.rows[0][0]);
  } else {
    console.log('No results found');
  }
}
</script>

<p>Selamat datang, <?php echo $username_; ?></p>

<div><?php
if (!isset($userprev)) $userprev = 0;
if ($userprev & 2) {
	echo "<a class='admin_dashb_item' href='".base_url('/admin/posts/newpost')."'>Tulis posting baru</a>\n";
	echo "<a class='admin_dashb_item' href='".base_url('/admin/posts/')."'>Edit Posting</a>\n";
}
if ($userprev & 16) echo "<a class='admin_dashb_item' href='".base_url('/admin/links')."'>Atur Tautan</a>\n";
if ($userprev & 8) echo "<a class='admin_dashb_item' href='".base_url('/admin/events')."'>Atur Agenda</a>\n";
if ($userprev & 32) echo "<a class='admin_dashb_item' href='".base_url('/admin/media')."'>Atur berkas media</a>\n";
if ($userprev & 64) echo "<a class='admin_dashb_item' href='".base_url('/admin/slider')."'>Atur gambar slider</a>\n";
if ($userprev & 4) echo "<a class='admin_dashb_item' href='".base_url('/admin/pages')."'>Atur halaman</a>\n";
if ($userprev & 1) echo "<a class='admin_dashb_item' href='".base_url('/admin/users')."'>Atur pengguna</a>\n";
?></div>
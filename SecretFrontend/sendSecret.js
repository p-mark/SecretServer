document.getElementById('secret-form').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission behavior

  // Get form values
  var secretText = document.getElementById('secret-text').value;
  var expireViews = parseInt(document.getElementById('expire-views').value);
  var expireTime = parseInt(document.getElementById('expire-time').value);

  // Create an object to hold the form data
  var formData = {
      secretText: secretText,
      expireViews: expireViews,
      expireTime: expireTime
  };

  // Convert the form data to JSON
  var jsonData = JSON.stringify(formData);

  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Set up the request
  xhr.open('POST', '../SecretAPI/addSecret.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json');

  // Set the Accept header based on the selected response format
  var responseFormat = document.getElementById('response-format').value;
  switch (responseFormat) {
      case 'json':
          xhr.setRequestHeader('Accept', 'application/json');
          break;
      case 'xml':
          xhr.setRequestHeader('Accept', 'application/xml');
          break;
          // Add more format cases here if needed
      default:
          location.reload(); //Reload the site, something might went wrong
          break;
  }

  // Handle the response
  xhr.onload = function() {
      if (xhr.status === 200) {
          // Request successful, handle the response here
          console.log(xhr.responseText);
      } else {
          // Request failed, handle the error here
          console.error('Request failed. Status:', xhr.status);
      }
  };

  // Send the request
  xhr.send(jsonData);
});
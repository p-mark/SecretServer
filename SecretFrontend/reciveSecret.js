document.getElementById('retrieve-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get form values
    var secretHash = document.getElementById('secret-hash').value;

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open('GET', '../SecretAPI/getSecret.php?hash=' + encodeURIComponent(secretHash), true);

    // Set the Accept header based on the selected response format
    var responseFormat = document.getElementById('response-format-retrieve').value;
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
            var response = xhr.responseText;

            // Process the response based on the asked response format
            switch (responseFormat) {
                case 'json':
                    handleJSONResponse(response);
                    break;
                case 'xml':
                    handleXMLResponse(response);
                    break;
                    // Add more format cases here if needed
            }

            // Show the secret result element
            var secretResultElement = document.getElementById('secret-result');
            secretResultElement.classList.remove('hidden');
        } else {
            // Request failed, handle the error here
            console.error('Request failed. Status:', xhr.status);
        }
    };

    // Send the request
    xhr.send();
});

// Function to handle JSON response
function handleJSONResponse(response) {
    console.log("JSON response: " + response);
    // Try to parse the response
    try {var secretData = JSON.parse(response)}
    catch (e) {
        console.log("JSON could not be parsed. (JS62)");
        return false;
    }

    var secretInfoElement = document.getElementById('secret-info');

    // Update the secret information in the HTML
    secretInfoElement.textContent = "Secret Text: " + secretData.secretText +
        ", Expire After Views: " + secretData.remainingViews +
        ", Expire After Time: " + secretData.expiresAt;
}

// Function to handle XML response
function handleXMLResponse(response) {
    // Process XML response here and update the secret information in the HTML
}
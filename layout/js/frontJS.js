setTimeout(function() {
    var successDiv = document.getElementById('success-alert');
    successDiv.parentNode.removeChild(successDiv);
  }, 5000); // Remove the div after 5 seconds (5000 milliseconds)


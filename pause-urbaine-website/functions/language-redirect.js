// CloudFront Function for language detection and redirect
// This function runs on viewer request to detect user's preferred language
// and redirect to the appropriate language path (/fr/ or /en/)

function handler(event) {
  var request = event.request;
  var uri = request.uri;
  
  // Only redirect if requesting the root path
  if (uri !== '/' && uri !== '') {
    return request;
  }
  
  // Get Accept-Language header
  var headers = request.headers;
  var acceptLanguage = headers['accept-language'] ? headers['accept-language'].value : '';
  
  // Default to French
  var targetLanguage = 'fr';
  
  // Check if English is preferred
  // Accept-Language format: "en-US,en;q=0.9,fr;q=0.8"
  if (acceptLanguage) {
    var languages = acceptLanguage.toLowerCase().split(',');
    
    for (var i = 0; i < languages.length; i++) {
      var lang = languages[i].split(';')[0].trim();
      
      // Check if English is the first preference
      if (i === 0 && (lang.indexOf('en') === 0)) {
        targetLanguage = 'en';
        break;
      }
    }
  }
  
  // Return 302 redirect to the appropriate language path
  var response = {
    statusCode: 302,
    statusDescription: 'Found',
    headers: {
      'location': { value: '/' + targetLanguage + '/' }
    }
  };
  
  return response;
}

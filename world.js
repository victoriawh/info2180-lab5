document.addEventListener('DOMContentLoaded',function() {
	const lookupButton = document .getElementById('lookup');
	const countryInput = document.getElementById('country');
	const resultDiv = document.getElementById('result');

	lookupButton.addEventListener('click', function(){
		const country = countryInput.value.trim()
		const xhr = new XMLHttpRequest();
		if(!country){
			xhr.open('GET', 'world.php', true)
			resultDiv.innerHTML = xhr.responseText;
			
		}
		
		xhr.open('GET', `world.php?country=${encodeURIComponent(country)}`, true);
		
		xhr.onload = function () {
			if(xhr.status >= 200 && xhr.status < 300){
				resultDiv.innerHTML = xhr.responseText;
			}else{
				resultDiv.innerHTML = 'Error: Could not fetch data. Status: ' + xhr.status;
			}
		};
		xhr.onerror = function(){
			resultDiv.innerHTML = 'Error: There was an issue with the request.';
		};
		xhr.send();
	});
});
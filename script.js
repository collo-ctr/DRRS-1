const form = document.getElementById('emergencyForm');
const scoreBar = document.getElementById('scoreBar');
const scoreText = document.getElementById('scoreText');
const scoreInput = document.getElementById('scoreInput');

function updateScore() {
    let total = 20; // Base score

    // Get selected type weight
    const selectedType = document.querySelector('input[name="type"]:checked');
    if (selectedType) total += parseInt(selectedType.getAttribute('data-weight'));

    // Get selected severity weight
    const selectedSeverity = document.querySelector('input[name="severity"]:checked');
    if (selectedSeverity) total += parseInt(selectedSeverity.getAttribute('data-weight'));

    // Update UI
    scoreBar.style.width = total + "%";
    scoreText.innerText = total;
    scoreInput.value = total;
}

// Listen for any changes in the form
form.addEventListener('change', updateScore);

function getLocation() {
    const btn = document.querySelector('button[onclick="getLocation()"]');
    btn.textContent = '⏳ Getting location...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(function(pos) {
        const lat = pos.coords.latitude;
        const lng = pos.coords.longitude;

        document.getElementById('latInput').value = lat;
        document.getElementById('lngInput').value = lng;
        document.getElementById('locationInput').value = 'GPS: ' + lat.toFixed(5) + ', ' + lng.toFixed(5);

        btn.textContent = '✓ Location Captured';
        btn.style.borderColor = '#27ae60';
        btn.style.color = '#27ae60';
    }, function(err) {
        btn.textContent = '⌖ Use GPS';
        btn.disabled = false;
        alert('Could not get location. Please type it manually.');
    });
}

// Keep your existing updateScore() function here too!
const menu = document.querySelector('#mobile-menu');
const menuLinks = document.querySelector('.navbar__menu');

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
});

// Website User Alert With Location
let locationSent = false;

function getLocation() {
    if (locationSent) return; // Prevent duplicate submissions

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Send data to the server
                fetch('/send_location.php', { // Replace with your server script
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ latitude, longitude })
                })
                .then(response => {
                    locationSent = true;
                    console.log('Location sent successfully.');
                })
                .catch(error => {
                    console.error('Error sending location:', error);
                });
            },
            function (error) {
                console.error('Error getting location:', error);
            },
            { enableHighAccuracy: true, timeout: 5000 }
        );
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}

// Call function when page loads
window.onload = getLocation;

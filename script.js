document.addEventListener("DOMContentLoaded", function() {
    // Get the soil moisture level from the server
    getSoilMoistureLevel();

    // Add event listener to the watering form
    document.getElementById("watering-form").addEventListener("submit", function(event) {
        event.preventDefault();
        startWatering();
    });
});

function getSoilMoistureLevel() {
    fetch("get_soil_moisture.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("soil-moisture").textContent = data;
        })
        .catch(error => {
            console.log("An error occurred while retrieving soil moisture level:", error);
        });
}

function startWatering() {
    var duration = document.getElementById("watering-duration").value;

    fetch("start_watering.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "duration=" + encodeURIComponent(duration)
    })
        .then(response => response.text())
        .then(data => {
            console.log("Watering started successfully.");
        })
        .catch(error => {
            console.log("An error occurred while starting watering:", error);
        });
}
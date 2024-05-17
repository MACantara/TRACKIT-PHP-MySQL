<script>
    function updateEventStatus(eventsId, status) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "includes/update-event-status.inc.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                console.log(this.responseText);
                // Update the class of the event-status-indicator div
                var indicator = document.getElementById('event-status-indicator-' + eventsId);
                indicator.className = 'event-status-indicator ' + status.toLowerCase();
            }
        }
        xhr.send("events_id=" + eventsId + "&events_status=" + status);
    }
</script>
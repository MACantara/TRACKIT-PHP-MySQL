<script>
function toggleEventDescription(eventId) {
    document.getElementById('showMoreButton-' + eventId).addEventListener('click', function() {
        document.getElementById('eventDescriptionShort-' + eventId).style.display = 'none';
        document.getElementById('eventDescriptionFull-' + eventId).style.display = 'block';
        document.getElementById('showMoreButton-' + eventId).style.display = 'none';
        document.getElementById('showLessButton-' + eventId).style.display = 'block';
    });

    document.getElementById('showLessButton-' + eventId).addEventListener('click', function() {
        document.getElementById('eventDescriptionShort-' + eventId).style.display = 'block';
        document.getElementById('eventDescriptionFull-' + eventId).style.display = 'none';
        document.getElementById('showMoreButton-' + eventId).style.display = 'block';
        document.getElementById('showLessButton-' + eventId).style.display = 'none';
    });
}
toggleEventDescription(<?php echo $event['events_id']; ?>);
</script>
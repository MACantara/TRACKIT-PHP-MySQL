<script>
function toggleEventDescription(eventId) {
    var moreText = document.getElementById('more-' + eventId);
    var showMoreLink = document.getElementById('showMore-' + eventId);
    var showLessLink = document.getElementById('showLess-' + eventId);

    showMoreLink.addEventListener('click', function(event) {
        event.preventDefault();
        var fadeOutElement = document.querySelector('#eventDescription-' + eventId + ' .fade-out');
        fadeOutElement.classList.remove('fade-out');
        moreText.style.display = 'inline';
        setTimeout(function() {
            moreText.style.opacity = '1';
        }, 1);
        showMoreLink.style.display = 'none';
        showLessLink.style.display = 'inline';
    });

    showLessLink.addEventListener('click', function(event) {
        event.preventDefault();
        var fadeOutElement = document.querySelector('#eventDescription-' + eventId + ' span');
        fadeOutElement.classList.add('fade-out');
        moreText.style.opacity = '0';
        setTimeout(function() {
            moreText.style.display = 'none';
        }, 500);
        showMoreLink.style.display = 'inline';
        showLessLink.style.display = 'none';
    });
}
toggleEventDescription(<?php echo $event['events_id']; ?>);
</script>
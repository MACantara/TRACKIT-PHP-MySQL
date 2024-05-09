<div class="pagination">
    <?php
    echo "<div class='pagination'>";
    if ($page > 1) {
        echo "<a href='event-dashboard.php?events_id=" . $eventsId . "&page=" . ($page - 1) . "&sort=" . $sort . "&filter=" . $filterDays . "'><i class='bi bi-arrow-left'></i></a> ";
    }
    echo "Page " . $page . " of " . $totalPages;
    if ($page < $totalPages) {
        echo " <a href='event-dashboard.php?events_id=" . $eventsId . "&page=" . ($page + 1) . "&sort=" . $sort . "&filter=" . $filterDays . "'><i class='bi bi-arrow-right'></i></a>";
    }
    echo "</div>";
    ?>
</div>
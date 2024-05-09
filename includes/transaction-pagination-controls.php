<?php
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $recordsPerPage = 25; // Change this to 50, 75, or 100 as needed
    $startFrom = ($page - 1) * $recordsPerPage;

    // Add pagination links at the end of the transaction history table
    $totalRecords = count(getTransactions($conn, $eventsId, $sort, $filterDays === 0 ? null : $filterDays, $transactionType));
    $totalPages = ceil($totalRecords / $recordsPerPage);
?>

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
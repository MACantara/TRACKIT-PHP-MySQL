<div class="controls">
    <form action="event-dashboard.php" method="get" class="filter-form">
        <input type="hidden" name="events_id" value="<?php echo $eventsId; ?>">
        <label for="sort" class="filter-label">Sort by date:</label>
        <select name="sort" id="sort" class="filter-select">
            <option value="ASC" <?php echo $sort == 'ASC' ? 'selected' : ''; ?>>Old to Recent</option>
            <option value="DESC" <?php echo $sort == 'DESC' ? 'selected' : ''; ?>>Recent to Old</option>
        </select>
        <label for="filter" class="filter-label">Filter by date:</label>
        <select name="filter" id="filter" class="filter-select">
            <option value="" <?php echo $filterDays === null ? 'selected' : ''; ?>>All</option>
            <option value="1" <?php echo $filterDays == '1' ? 'selected' : ''; ?>>Today</option>
            <option value="2" <?php echo $filterDays == '2' ? 'selected' : ''; ?>>Yesterday</option>
            <option value="7" <?php echo $filterDays == '7' ? 'selected' : ''; ?>>Last 7 days</option>
            <option value="14" <?php echo $filterDays == '14' ? 'selected' : ''; ?>>Last 14 days</option>
            <option value="30" <?php echo $filterDays == '30' ? 'selected' : ''; ?>>Last 30 days</option>
            <option value="60" <?php echo $filterDays == '60' ? 'selected' : ''; ?>>Last 60 days</option>
            <option value="90" <?php echo $filterDays == '90' ? 'selected' : ''; ?>>Last 90 days</option>
        </select>
        <label for="transaction_type" class="filter-label">Filter by transaction type:</label>
        <select name="transaction_type" id="transaction_type" class="filter-select">
            <option value="">All</option>
            <option value="income" <?php echo $_SESSION['transaction_type'] == 'income' ? 'selected' : ''; ?>>
                Income</option>
            <option value="expense" <?php echo $_SESSION['transaction_type'] == 'expense' ? 'selected' : ''; ?>>
                Expense</option>
        </select>
        <button type="submit" class="filter-button">Apply</button>
        <a href="event-dashboard.php?events_id=<?php echo $eventsId; ?>&sort=DESC&filter=&transaction_type="
            class="filter-button">Reset</a>
    </form>
</div>
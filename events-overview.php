<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/event-functions.inc.php';

$usersId = $_SESSION["users_id"];
$events = getUserEvents($conn, $usersId);

// Get user's role
$usersRole = getUserRole($conn, $usersId);

require_once 'includes/user-functions.inc.php';
requireLogin();
checkSessionTimeout();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "templates/meta-tags.tpl.php"; ?>
    <title>Events Overview</title>
    <?php include "templates/external-links.tpl.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <?php include 'templates/generate-summary-report-modal.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Events Overview</h1>
            <div class="button-container">
                <?php if ($usersRole == 'Student-Council-Officer' || $usersRole == 'Admin'): ?>
                    <a class="button margin-top-16" href="create-event.php"><i class="bi bi-plus-circle"></i> Create New
                        Event</a>
                <?php endif; ?>
                <?php
                if (isset($_GET["create-event"])) {
                    if ($_GET["create-event"] == "success") {
                        echo "<p class='success-message'>Event successfully created!</p>";
                    } else if ($_GET["create-event"] == "error") {
                        echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                    }
                }
                if (isset($_GET["event-updated"])) {
                    if ($_GET["event-updated"] == "success") {
                        echo "<p class='success-message'>Event successfully updated!</p>";
                    } else if ($_GET["event-updated"] == "error") {
                        echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                    }
                }
                ?>
            </div>
        </section>
        <?php
        // Fetch the events, ordered by events_academic_year, events_semester, and events_start_date
        $sql = "SELECT * FROM events ORDER BY events_academic_year DESC, events_semester DESC, events_start_date DESC";
        $result = mysqli_query($conn, $sql);
        $events = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $currentGroup = null;

        // Group the events by academic year and semester
        $groupedEvents = [];
        foreach ($events as $event) {
            $group = $event['events_semester'] . ' - ' . "AY " . $event['events_academic_year'];
            if (!isset($groupedEvents[$group])) {
                $groupedEvents[$group] = [];
            }
            $groupedEvents[$group][] = $event;
        }
        ?>
        <div class="events-grid">
            <?php foreach ($groupedEvents as $group => $events): ?>
                <h2 class="group-separator"><?php echo $group; ?></h2>
                <?php foreach ($events as $event): ?>
                    <?php
                    // Get the data for the current event
                    $eventsId = $event['events_id'];
                    $row = getEvent($conn, $eventsId);
                    $expenses = getTotalEventExpenses($conn, $eventsId);
                    $income = getTotalEventIncome($conn, $eventsId);
                    $remainingBudget = getEventRemainingBudget($conn, $eventsId);
                    $transactions = getTransactions($conn, $eventsId);
                    $totalExpenses = $expenses + $income;

                    list($expensesWithinBudget, $expensesOverBudget, $remainingBudget) = calculateBudget($totalExpenses, $remainingBudget, $transactions, $row, $eventsId, $conn);
                    ?>
                    <section>
                        <div>
                            <?php
                            // Fetch the events_status from the events table
                            $eventsStatus = getEventStatus($conn, $event['events_id']);
                            ?>
                            <div class="event-status-container">
                                <?php if ($usersRole == 'Faculty' || $usersRole == 'Staff'): ?>
                                    <div class="event-status-text-container">
                                        <div id="event-status-indicator-<?php echo $event['events_id']; ?>"
                                            class="event-status-indicator <?php echo strtolower($eventsStatus); ?>"></div>
                                        <p class="event-status-text"><?php echo $eventsStatus; ?></p>
                                    </div>
                                <?php else: ?>
                                    <div id="event-status-indicator-<?php echo $event['events_id']; ?>"
                                        class="event-status-indicator <?php echo strtolower($eventsStatus); ?>"></div>
                                    <select class="event-status-dropdown" name="events_status"
                                        onchange="updateEventStatus(<?php echo $event['events_id']; ?>, this.value)">
                                        <option value="Upcoming" <?php echo $eventsStatus == 'Upcoming' ? 'selected' : ''; ?>>Upcoming
                                        </option>
                                        <option value="Postponed" <?php echo $eventsStatus == 'Postponed' ? 'selected' : ''; ?>>
                                            Postponed</option>
                                        <option value="Done" <?php echo $eventsStatus == 'Done' ? 'selected' : ''; ?>>Done</option>
                                        <option value="Canceled" <?php echo $eventsStatus == 'Canceled' ? 'selected' : ''; ?>>Canceled
                                        </option>
                                    </select>
                                <?php endif; ?>
                                <?php include 'includes/update-event-status-js-functions.inc.php'; ?>
                            </div>
                            <h2><a
                                    href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>"><?php echo $event['events_name']; ?></a>
                            </h2>
                            <div class="event-description" id="eventDescription-<?php echo $event['events_id']; ?>">
                                <span class="fade-out">
                                    <?php echo limit_words($event['events_description'], 20); ?>
                                </span>
                                <span id="more-<?php echo $event['events_id']; ?>" style="display: none; opacity: 0;">
                                    <?php echo substr($event['events_description'], strlen(limit_words($event['events_description'], 20))); ?>
                                </span>
                                <a href="#" class="showMore" id="showMore-<?php echo $event['events_id']; ?>"
                                    style="display: inline;">...more</a>
                                <a href="#" class="showLess" id="showLess-<?php echo $event['events_id']; ?>"
                                    style="display: none;">Show less</a>
                            </div>
                            <?php include "includes/display-event-description-js-functions.inc.php"; ?>
                            <p class="margin-top-16">
                                Date: <?php echo date('F j, Y', strtotime($event['events_start_date'])); ?>
                            </p>
                            <p>
                                Time: <?php echo date('g:i A', strtotime($event['events_start_date'])); ?> -
                                <?php echo date('g:i A', strtotime($event['events_end_date'])); ?>
                            </p>
                            <p>Venue: <?php echo $event['events_venue']; ?></p>
                            <p class="margin-top-16">Initial Budget: &#8369;
                                <?php echo number_format($event['events_budget'], 2); ?></p>
                            <canvas class="event-overview-chart" id="myChart<?php echo $eventsId; ?>"></canvas>
                            <script>
                                var ctx = document.getElementById('myChart<?php echo $eventsId; ?>').getContext('2d');

                                var datasets = [{
                                    label: 'Remaining Budget',
                                    data: [<?php echo $remainingBudget; ?>],
                                    backgroundColor: 'green',
                                    stack: 'Stack 0',
                                }];

                                // If remaining budget is 0 or less, add the "Expenses (over budget)" dataset
                                if (<?php echo $remainingBudget; ?> <= 0) {
                                    var expensesWithinBudget = <?php echo $expensesWithinBudget; ?>;
                                    var expensesOverBudget = <?php echo $expensesOverBudget; ?>;

                                    datasets.push({
                                        label: 'Expenses (Within budget)',
                                        data: [expensesWithinBudget],
                                        backgroundColor: 'red',
                                        stack: 'Stack 1',
                                    }, {
                                        label: 'Expenses (Over budget)',
                                        data: [expensesOverBudget],
                                        backgroundColor: 'darkred',
                                        stack: 'Stack 1',
                                    });
                                } else {
                                    datasets.push({
                                        label: 'Expenses',
                                        data: [<?php echo $expenses; ?>],
                                        backgroundColor: 'red',
                                    });
                                }

                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: [''],
                                        datasets: datasets
                                    },
                                    options: {
                                        indexAxis: 'y', // Change this line
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                stacked: true,
                                            },
                                            y: {
                                                stacked: true,
                                            }
                                        }
                                    }
                                });
                            </script>
                            <div class="grid-container">
                                <a class="button button-primary margin-top-16"
                                    href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>"><i
                                        class="bi bi-eye"></i> View</a>
                                <?php if ($usersRole == 'Student-Council-Officer' || $usersRole == 'Admin'): ?>
                                    <a class="button secondary-outline-button margin-top-16"
                                        href="update-event.php?events_id=<?php echo $event['events_id']; ?>"><i
                                            class="bi bi-pencil-square"></i> Update</a>
                                    <a class="button secondary-outline-button margin-top-16"
                                        href="invite-user.php?events_id=<?php echo $event['events_id']; ?>"><i
                                            class="bi bi-person-plus"></i> Invite</a>
                                <?php endif; ?>
                            </div>
                            <?php if ($usersRole == 'Student-Council-Officer' || $usersRole == 'Admin'): ?>
                                <form method="post" action="includes/delete-event.inc.php">
                                    <input type="hidden" name="events_id" value="<?php echo $event['events_id']; ?>">
                                    <button type="submit" class="button button-outline-danger margin-top-16"><i
                                            class="bi bi-trash"></i>
                                        Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>
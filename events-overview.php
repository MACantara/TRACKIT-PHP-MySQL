<?php
session_start();
require_once 'includes/db-connection.inc.php';
require_once 'includes/event-functions.inc.php';

$userId = $_SESSION["users_id"];
$events = getUserEvents($conn, $userId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Overview</title>
    <?php include "templates/external-links.tpl.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'templates/header.tpl.php'; ?>
    <main>
        <section class="section-container">
            <h1>Events Overview</h1>
            <div class="button-container">
                <a class="button margin-top-16" href="create-event.php"><i class="bi bi-plus-circle"></i> Create New
                    Event</a>
                <?php
                if (isset($_GET["create-event"])) {
                    if ($_GET["create-event"] == "success") {
                        echo "<p class='success-message'>Event successfully created!</p>";
                    } else if ($_GET["create-event"] == "error") {
                        echo "<p class='error-message'>Something went wrong. Please try again!</p>";
                    }
                }
                ?>
            </div>
        </section>
        <div class="events-grid">
            <?php foreach ($events as $event): ?>
                <?php
                // Get the data for the current event
                $eventId = $event['events_id'];
                $expenses = getTotalEventExpenses($conn, $eventId);
                $income = getTotalEventIncome($conn, $eventId);
                $remainingBudget = getEventRemainingBudget($conn, $eventId);

                // Calculate expenses within and over budget
                $expensesWithinBudget = abs(min($expenses, $remainingBudget));
                $expensesOverBudget = max(0, $expenses - $remainingBudget);

                // If remaining budget is less than 0, set it to 0
                if ($remainingBudget < 0) {
                    $remainingBudget = 0;
                }

                // If there are no expenses or income, use the initial budget
                if ($expenses == 0 && $income == 0) {
                    $expenses = 0;
                    $income = 0;
                    $remainingBudget = $event['events_budget'];
                }
                ?>
                <section>
                    <div>
                        <h2><a
                                href="event-dashboard.php?events_id=<?php echo $event['events_id']; ?>"><?php echo $event['events_name']; ?></a>
                        </h2>
                        <p><?php echo $event['events_description']; ?></p>
                        <p class="margin-top-16">Date: <?php echo date('F j, Y', strtotime($event['events_date'])); ?>
                            <?php echo date('h:i A', strtotime($event['events_date'])); ?>
                        </p>
                        <p>Initial Budget: &#8369; <?php echo number_format($event['events_budget'], 2); ?></p>
                        <canvas class="event-overview-chart" id="myChart<?php echo $eventId; ?>"></canvas>
                        <script>
                            var ctx = document.getElementById('myChart<?php echo $eventId; ?>').getContext('2d');
                        
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
                                    label: 'Expenses (within budget)',
                                    data: [expensesWithinBudget],
                                    backgroundColor: 'red',
                                    stack: 'Stack 1',
                                }, {
                                    label: 'Expenses (over budget)',
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
                            <a class="button secondary-outline-button margin-top-16"
                                href="update-event.php?events_id=<?php echo $event['events_id']; ?>"><i
                                    class="bi bi-pencil-square"></i> Update</a>
                            <a class="button secondary-outline-button margin-top-16"
                                href="invite-user.php?events_id=<?php echo $event['events_id']; ?>"><i
                                    class="bi bi-person-plus"></i> Invite</a>
                        </div>
                        <form method="post" action="includes/delete-event.inc.php">
                            <input type="hidden" name="events_id" value="<?php echo $event['events_id']; ?>">
                            <button type="submit" class="button button-outline-danger margin-top-16"><i
                                    class="bi bi-trash"></i> Delete</button>
                        </form>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </main>
    <?php include 'templates/footer.tpl.php'; ?>
</body>

</html>
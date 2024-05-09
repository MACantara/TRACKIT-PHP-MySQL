<?php
    $colors = [
        '#B71C1C', // Red
        '#880E4F', // Pink
        '#4A148C', // Purple
        '#311B92', // Deep Purple
        '#1A237E', // Indigo
        '#0D47A1', // Blue
        '#01579B', // Light Blue
        '#006064', // Cyan
        '#004D40', // Teal
        '#1B5E20', // Green
        '#33691E', // Light Green
        '#827717', // Lime
        '#F57F17', // Yellow
        '#FF6F00', // Amber
        '#E65100', // Orange
        '#BF360C'  // Deep Orange
    ];

    $groupedExpenseTransactions = groupTransactionsByCategory($expenses);
    $groupedIncomeTransactions = groupTransactionsByCategory($incomes);

    // Sort by total amount in descending order and take top 5
    arsort($groupedExpenseTransactions);
    arsort($groupedIncomeTransactions);

    $topExpenseCategories = array_slice($groupedExpenseTransactions, 0, 5, true);
    $topIncomeCategories = array_slice($groupedIncomeTransactions, 0, 5, true);

    // Add "Other" category
    $topExpenseCategories = groupOtherCategories($groupedExpenseTransactions, 5);
    $topIncomeCategories = groupOtherCategories($groupedIncomeTransactions, 5);
?>

<script>
    // Pie chart - Expenses
    const pieChartCtx1 = document.getElementById("pieChart1").getContext("2d");
    new Chart(pieChartCtx1, {
        type: "doughnut",
        data: {
            labels: <?php echo json_encode(array_keys($topExpenseCategories)); ?>,
            datasets: [
                {
                    data: <?php echo json_encode(array_values($topExpenseCategories)); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>,
                },
            ],
        },
        options: {
            responsive: true,
        },
    });
    // Pie chart - Incomes
    const pieChartCtx2 = document.getElementById("pieChart2").getContext("2d");
    new Chart(pieChartCtx2, {
        type: "doughnut",
        data: {
            labels: <?php echo json_encode(array_keys($topIncomeCategories)); ?>,
            datasets: [
                {
                    data: <?php echo json_encode(array_values($topIncomeCategories)); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>,
                },
            ],
        },
        options: {
            responsive: true,
        },
    });
    // Bar chart - Remaining Budget
    const barChartCtx = document.getElementById("barChart").getContext("2d");
    new Chart(barChartCtx, {
        type: "doughnut",
        data: {
            labels: ["Remaining Budget", "Expenses Within Budget", "Expenses Over Budget"],
            datasets: [
                {
                    label: "Budget (In PHP)",
                    data: [
                        <?php echo $remainingBudget; ?>,
                        <?php echo $expensesWithinBudget; ?>,
                        <?php echo $expensesOverBudget; ?>
                    ],
                    backgroundColor: [
                        "green",
                        "red",
                        "darkred"
                    ]
                },
            ],
        },
    });
</script>
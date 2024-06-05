<?php
    $expenseColors = [
        '#EF5350', // Red 400
        '#F44336', // Red 500
        '#E53935', // Red 600
        '#D32F2F', // Red 700
        '#C62828', // Red 800
        '#B71C1C'  // Red 900
    ];

    $incomeColors = [
        '#66BB6A', // Green 400
        '#4CAF50', // Green 500
        '#43A047', // Green 600
        '#388E3C', // Green 700
        '#2E7D32', // Green 800
        '#1B5E20'  // Green 900
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
                    backgroundColor: <?php echo json_encode($expenseColors); ?>,
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
                    backgroundColor: <?php echo json_encode($incomeColors); ?>,
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
// Pie chart 1
const pieChart1Ctx = document.getElementById("pieChart1").getContext("2d");
new Chart(pieChart1Ctx, {
    type: "pie",
    data: {
        labels: ["Red", "Blue", "Yellow"],
        datasets: [
            {
                data: [300, 50, 100],
                backgroundColor: [
                    "rgb(255, 99, 132)",
                    "rgb(54, 162, 235)",
                    "rgb(255, 205, 86)",
                ],
            },
        ],
    },
    options: {
        responsive: true,
    },
});

// Pie chart 2
const pieChart2Ctx = document.getElementById("pieChart2").getContext("2d");
new Chart(pieChart2Ctx, {
    type: "pie",
    data: {
        labels: ["Green", "Purple", "Orange"],
        datasets: [
            {
                data: [200, 150, 50],
                backgroundColor: [
                    "rgb(75, 192, 192)",
                    "rgb(153, 102, 255)",
                    "rgb(255, 159, 64)",
                ],
            },
        ],
    },
    options: {
        responsive: true,
    },
});

// Bar chart
const barChartCtx = document.getElementById("barChart").getContext("2d");
new Chart(barChartCtx, {
    type: "bar",
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
            {
                label: "# of Votes",
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.2)",
                    "rgba(54, 162, 235, 0.2)",
                    "rgba(255, 206, 86, 0.2)",
                    "rgba(75, 192, 192, 0.2)",
                    "rgba(153, 102, 255, 0.2)",
                    "rgba(255, 159, 64, 0.2)",
                ],
                borderColor: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});
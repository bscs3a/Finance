<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Management</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">

    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    require_once './src/dbconn.php';

    // Get PDO instance
    $database = Database::getInstance();
    $pdo = $database->connect();

    // Query for years
    $sqlYears = "SELECT DISTINCT YEAR(MonthYear) AS Year FROM TargetSales ORDER BY Year DESC";
    $stmtYears = $pdo->query($sqlYears);
    $years = $stmtYears->fetchAll(PDO::FETCH_ASSOC);

    // Query for target sales
    $sqlTargetSales = "SELECT MonthYear, TargetAmount FROM TargetSales ORDER BY MonthYear";
    $stmtTargetSales = $pdo->query($sqlTargetSales);
    $targetSales = $stmtTargetSales->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the labels and data for the chart
    $labels = [];
    $data = [];
    foreach ($targetSales as $targetSale) {
        $labels[] = date('Y-F', strtotime($targetSale['MonthYear']));  // Format the date as 'Year-MonthName'
        $data[] = $targetSale['TargetAmount'];
    }

    // Query for total sales
    $sqlTotalSales = "
    SELECT DATE_FORMAT(SaleDate, '%Y-%m-01') AS MonthYear, SUM(TotalAmount) AS TotalSales 
    FROM Sales 
    GROUP BY MonthYear 
    ORDER BY MonthYear
";
    $stmtTotalSales = $pdo->query($sqlTotalSales);
    $totalSales = $stmtTotalSales->fetchAll(PDO::FETCH_ASSOC);

    // Prepare the data for the chart
    $totalSalesData = [];
    foreach ($totalSales as $totalSale) {
        $totalSalesData[] = $totalSale['TotalSales'];
    }
    ?>

</head>

<body>
    <?php include "components/sidebar.php" ?>

    <!-- Start: Dashboard -->
    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">

        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Sales Management</p>
                </li>

            </ul>

            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">

                <div class="relative inline-block text-left">
                    <div>
                        <a class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-black bg-white rounded-md shadow-sm hover:bg-gray-50 focus:outline-none hover:cursor-pointer" id="options-menu" aria-haspopup="true" aria-expanded="true">
                            <div class="text-black font-medium mr-4 ">
                                <?= $_SESSION['employee_name']; ?>
                            </div>
                            <i class="ri-arrow-down-s-line"></i>
                        </a>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-4 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden" id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="py-1" role="none">
                            <a route="/sls/logout" class="block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                <i class="ri-logout-box-line"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('options-menu').addEventListener('click', function() {
                        var dropdownMenu = document.getElementById('dropdown-menu');
                        if (dropdownMenu.classList.contains('hidden')) {
                            dropdownMenu.classList.remove('hidden');
                        } else {
                            dropdownMenu.classList.add('hidden');
                        }
                    });
                </script>
            </ul>

            <!-- End: Profile -->
        </div>

        <!-- End: Header -->

        <div class="flex flex-col items-center min-h-screen mb-10">
            <!-- Title -->
            <h1 class="text-2xl font-semibold mb-6 mt-6">Sales Management</h1>

            <!-- Sales Chart Card -->
            <div class="w-full max-w-3xl bg-white rounded-md border border-gray-200 p-6 shadow-md">
                <!-- Card header -->
                <div class="flex justify-between items-center mb-6">
                    <!-- Card title -->
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="ri-funds-box-fill ri-fw" style="color: #262261;"></i> Sales Overview
                    </h2>
                    <!-- Year Select -->
                    <div>
                        <select id="yearSelect" class="border rounded-md px-2 py-1">
                            <?php foreach ($years as $year) : ?>
                                <option value="<?php echo $year['Year']; ?>"><?php echo $year['Year']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Sales Chart -->
                <div class="h-60">
                    <canvas id="myChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Previous Target Sales Table -->
            <section id="previous-target-sales" class="w-full max-w-3xl mt-8">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                    <h2 class="mb-4 text-lg font-bold text-gray-700">Previous Target Sales</h2>
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Month and Year</th>
                                <th class="px-4 py-2">Target Sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($targetSales as $sale) : ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo date("F Y", strtotime($sale['MonthYear'])); ?></td>
                                    <td class="border px-4 py-2"><?php echo $sale['TargetAmount']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Target Sales Form -->
            <section id="target-sales-form" class="w-full max-w-3xl mt-8">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
                    <h2 class="mb-4 text-lg font-bold text-gray-700">Set Target Sales for This Month</h2>
                    <form action="/AddTarget" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="month-year">Month and Year:</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="month" id="month-year" name="month_year" value="<?php echo date('Y-m'); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="target-sales">Target Sales:</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="target-sales" name="target_sales" required>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Set Target</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>


    </main>

    <script src="./../src/form.js"></script>
    <script src="./../src/route.js"></script>
    <script>
        // Trigger the change event for the year select element on page load
        window.onload = function() {
            var event = new Event('change');
            document.getElementById('yearSelect').dispatchEvent(event);
        };

        document.getElementById('yearSelect').addEventListener('change', function() {
            // Get the selected year
            var selectedYear = this.value;

            // Get the original labels and data
            var originalLabels = <?php echo json_encode($labels); ?>;
            var originalData = <?php echo json_encode($data); ?>;
            var originalTotalSalesData = <?php echo json_encode($totalSalesData); ?>;

            // Filter the labels and data based on the selected year
            var labels = [];
            var data = [];
            var totalSalesData = [];
            for (var i = 0; i < originalLabels.length; i++) {
                if (originalLabels[i].startsWith(selectedYear)) {
                    labels.push(originalLabels[i]);
                    data.push(originalData[i]);
                    totalSalesData.push(originalTotalSalesData[i]);
                }
            }

            // Update the chart labels and data
            myChart.data.labels = labels;
            myChart.data.datasets[0].data = data;
            myChart.data.datasets[1].data = totalSalesData;
            myChart.update();
        });
    </script>

    <!-- Chart.js configurations -->
    <script>
        // Line Chart for Sales
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>, // Pass the labels
                datasets: [{
                    label: 'Target',
                    data: <?php echo json_encode($data); ?>, // Pass the target sales data
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }, {
                    label: 'Total Sales',
                    data: <?php echo json_encode($totalSalesData); ?>, // Pass the total sales data
                    backgroundColor: 'transparent',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bar Chart for Stocks
        var ctx = document.getElementById('stocksChart').getContext('2d');
        var stocksChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Stocks'],
                datasets: [{
                        label: 'Sold',
                        data: [300],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Remaining',
                        data: [200],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 500 // Set the maximum value of the y-axis to 500
                    }
                }
            }
        });
    </script>

</body>

</html>
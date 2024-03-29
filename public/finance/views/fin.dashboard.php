<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
</head>

<body>
    <!-- Start: Sidebar -->
    <?php

    include "components/sidebar.php";

    // addAccountantAuditLog('Log in');
    ?>

    <!-- End: Sidebar -->
    <!-- Start: Dashboard -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main font-sans">


        <!-- Start: Header -->

        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">

            <!-- Start: Active Menu -->

            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>

            <ul class="flex items-center text-md ml-4">

                <li class="mr-2">
                    <p class="text-black font-medium">Dashboard</p>
                </li>

            </ul>

            <!-- End: Active Menu -->

            <!-- Start: Profile -->

            <ul class="ml-auto flex items-center">

                <div class="relative inline-block text-left">
                    <div>
                        <a class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-black bg-white rounded-md shadow-sm hover:bg-gray-50 focus:outline-none hover:cursor-pointer"
                            id="options-menu" aria-haspopup="true" aria-expanded="true">
                            <div class="text-black font-medium mr-4 ">
                                <?= $_SESSION['fullname']; ?>
                            </div>
                            <i class="ri-arrow-down-s-line"></i>
                        </a>
                    </div>

                    <div class="origin-top-right absolute right-0 mt-4 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                        id="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <div class="py-1" role="none">
                            <a route="/fin/logout"
                                class="block px-4 py-2 text-md text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                role="menuitem">
                                <i class="ri-logout-box-line"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('options-menu').addEventListener('click', function () {
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

        <!-- Start: Inner Dashboard Analytics-->
        <div class="w-full h-1/4 p-6 bg-white">
            <!-- Start: Top Section -->
            <div class=" mb-6">
                <!-- Start: Top Left-Side Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6 ">
                    <div class="col-span-1 border-solid border-gray-400 shadow-md rounded-xl px-5 py-10 bg-wave bg-cover bg-[center_top_6rem] bg-[length:100%_70%] bg-no-repeat
                            
                        ">
                        <!-- Start: Welcome Message -->
                        <div class="flex justify-between mb-5">
                            <div>

                                <h1 class="font-sans font-bold  text-5xl">Hello, Sample User!</h1>
                                <p class=" w-3/4 text wrap mt-3 font-sans text-md text-gray-400 ">Welcome back! Ready to
                                    gear
                                    up for another productive day?</p>
                                <!-- End: Welcome Message -->
                            </div>


                            <div class="text-right">
                                <p class="font-sans font-bold text-xl text-gray-500">Today,</p>
                                <!-- Expected format: March 04, 2024 -->
                                <p class="font-sans font-bold text-xl text-gray-500">
                                    <?= date('F j, Y'); ?>
                                </p>
                            </div>
                        </div>

                        <!-- End: Welcome Message -->
                        <!-- Start: Mini-Dashboard Analytics -->
                        <div id="mini-dashboard" class="mt-10 grid grid-cols-1  md:grid-cols-2  gap-4">
                            <!-- Start: Dashboard Analytics: Total Sales -->
                            <div class="bg-white rounded-md border border-gray-300 p-4 shadow-lg">
                                <div class="flex justify-between mb-4">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <div class="text-4xl font-semibold text-[#F8B721]">
                                                <?php
                                                $amount = 2000;
                                                echo number_format($amount, 2);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-400">Total Sales</div>
                                    </div>
                                    <div>
                                        <img src="../public/finance/img/Profit.png" alt="Profit.png"
                                            class="bg-radial-gradient from-[#FFEB95] to-[#FECE01] py-2 px-2 rounded-full">
                                    </div>
                                </div>
                            </div>
                            <!-- End: Dashboard Analytics: Total Sales -->
                            <!-- Start: Dashboard Analytics: Total Expense -->
                            <div class="bg-white rounded-md border border-gray-300 p-4 shadow-lg">
                                <div class="flex justify-between mb-4">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <div class="text-4xl font-semibold text-[#F8B721]">
                                                <?php
                                                $amount = 10000;
                                                echo '₱' . number_format($amount, 2);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-gray-400">Total Expense</div>
                                    </div>
                                    <div>
                                        <img src="../public/finance/img/RequestMoney.png" alt="request-money.png"
                                            class="bg-radial-gradient from-[#FFEB95] to-[#FECE01] max-w-full h-auto py-2 px-1 rounded-full sm:hidden">
                                    </div>
                                </div>
                            </div>
                            <!-- End: Dashboard Analytics: Total Expense -->
                        </div>
                        <!-- End: Mini-Dashboard Analytics -->
                    </div>

                    <div class=" col-span-1 bg-gradient-to-b from-[#F8B721] to-[#FBCF68] rounded-xl drop-shadow-md">
                        <div class="mx-5 my-5 py-3 px-3 text-white">
                            <h1 class="text-3xl font-bold">Total Balance</h1>
                            <p class="mt-5 text-3xl font-medium">0</p>
                            <p class="mt-5 text-md font-bold">Summary</p>
                        </div>
                    </div>



                </div>
                <!-- End: Top Left-Side Section -->
            </div>
            <!-- End: Top Section -->

            <!-- Start: Request Section -->
            <?php include "components/dashboard/dashboard.request.php" ?>
            <!-- End: Request Section -->

            <!-- Start: Report Section -->
            <?php include "components/dashboard/dashboard.reports.php" ?>
            <!-- End: Report Section -->
        </div>
        <!-- End: Inner Dashboard Analytics-->
    </main>
    <!-- End: Dashboard -->
    <script src="./../src/route.js"></script>
</body>

</html>
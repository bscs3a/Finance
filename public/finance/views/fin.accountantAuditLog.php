<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
</head>

<body>
    <!-- Start: Sidebar -->
    <?php include "components/sidebar.php" ?>
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
                    <p class="text-black font-medium">Audit Logs</p>
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

        <h2>Hellow</h2>

        <!-- Start: Audit Logs Table -->
        <div class="mt-20 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <!-- <th class="px-6 py-3 taxt-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th> -->
                            <th class="px-6 py-3 taxt-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 taxt-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 taxt-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Tagle, Aries</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Log in</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">March 29, 2024</td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <!-- End: Audit Logs Table -->
    </body>

</html>


<?php
// Fetch audit logs from the database
// $query = "SELECT * FROM audit_logs ORDER BY timestamp DESC";
// $result = mysqli_query($conn, $query);

// echo '<table class="min-w-full divide-y divide-gray-200">';
// echo '<thead class="bg-gray-50">';
// echo '<tr>';
// echo '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>';
// echo '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>';
// echo '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>';
// echo '<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>';
// echo '</tr>';
// echo '</thead>';
// echo '<tbody class="bg-white divide-y divide-gray-200">';

// while ($row = mysqli_fetch_assoc($result)) {
//     echo '<tr>';
//     echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['id'] . '</td>';
//     echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['action'] . '</td>';
//     echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['timestamp'] . '</td>';
//     echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">' . $row['user'] . '</td>';
//     echo '</tr>';
// }

// echo '</tbody>';
// echo '</table>';
?>
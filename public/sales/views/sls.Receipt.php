<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="./../src/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
</head>

<body>
    <?php include "components/sidebar.php" ?>

    <main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
        <div class="py-2 px-6 bg-white flex items-center shadow-md sticky top-0 left-0 z-30">
            <button type="button" class="text-lg sidebar-toggle">
                <i class="ri-menu-line"></i>
            </button>
            <ul class="flex items-center text-md ml-4">
                <li class="mr-2">
                    <p class="text-black font-medium">Sales / Receipt</p>
                </li>
            </ul>
        </div>

        <!-- receipt -->
        <div class="flex flex-col items-center min-h-screen">
            <div class="w-96 max-w-6xl mt-10">
                <h1 class="mb-3 text-xl font-bold text-black">Receipt</h1>
                <!-- Add receipt details here -->
                <div id="receipt" class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Purchased Items</h2>
                    <ul id="cart-items">
                        <!-- Cart items will be added here by JavaScript -->
                    </ul>
                    <h2 id="total" class="text-xl font-semibold mb-4 mt-6"></h2>
                </div>
                <button class="print-button mt-4 bg-blue-500 text-white py-2 px-4 rounded">Print Receipt</button>
            </div>
        </div>

        <script>
            // Get the cart items from localStorage
            var cart = JSON.parse(localStorage.getItem('cart')) || [];

            // Get the cart items element
            var cartItemsElement = document.getElementById('cart-items');

            // Add each cart item to the cart items element
            for (var i = 0; i < cart.length; i++) {
                var item = cart[i];
                var li = document.createElement('li');
                li.textContent = item.quantity + ' x ' + item.name + ': ₱' + item.price * item.quantity;
                cartItemsElement.appendChild(li);
            }

            // Calculate the total price
            var total = cart.reduce(function(total, item) {
                return total + item.price * item.quantity;
            }, 0);

            // Display the total price
            document.getElementById('total').textContent = 'Total: ₱' + total;
        </script>
    </main>

    <script>
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
            document.getElementById('sidebar-menu').classList.toggle('transform');
            document.getElementById('sidebar-menu').classList.toggle('-translate-x-full');
            document.getElementById('mainContent').classList.toggle('md:w-full');
            document.getElementById('mainContent').classList.toggle('md:ml-64');
        });
    </script>

    <script>
        function printReceipt() {
            var receipt = document.getElementById('receipt').innerHTML;
            var originalContent = document.body.innerHTML;

            document.body.innerHTML = receipt;

            window.print();

            document.body.innerHTML = originalContent;
        }

        document.querySelector('.print-button').addEventListener('click', printReceipt);
    </script>

    <script src="./../src/route.js"></script>
</body>

</html>
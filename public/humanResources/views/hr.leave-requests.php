<?php
$db = Database::getInstance();
$conn = $db->connect();

$search = $_POST['search'] ?? '';
$query = "SELECT leave_requests.*, employees.image_url, employees.first_name, employees.middle_name, employees.last_name, employees.position, employees.department FROM leave_requests";
$query .= " LEFT JOIN employees ON leave_requests.employees_id = employees.id";

$params = [];

if (!empty($search)) {
  $query .= " WHERE (employees.first_name = :search OR employees.last_name = :search OR employees.position = :search OR employees.department = :search OR leave_requests.id = :search OR leave_requests.type = :search OR leave_requests.employees_id = :search) AND";
  $params[':search'] = $search;
} else {
  $query .= " WHERE";
}

$query .= " leave_requests.status = 'pending'";

$query .= " ORDER BY leave_requests.id DESC";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdo = null;
$stmt = null;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
  <link href="./../src/tailwind.css" rel="stylesheet">
  <title>Leave Requests</title>
</head>
<body class="text-gray-800 font-sans">

<!-- sidenav -->
<?php 
    include 'inc/sidenav.php';
?>
<!-- end of sidenav -->

<!-- Start Main Bar -->
<main id="mainContent" class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main">
  <!-- Top Bar -->
  <div class="py-2 px-6 bg-white flex items-center shadow-md shadow-black/10">
   <button type="button" class="text-lg text-gray-600 sidebar-toggle">
  <i class="ri-menu-line"></i>
   </button>
   <ul class="flex items-center text-sm ml-4">  
  <li class="mr-2">
    <a route="/hr/dashboard" class="text-[#151313] hover:text-gray-600 font-medium">Human Resources</a>
  </li>
  <li class="text-[#151313] mr-2 font-medium">/</li>
  <a href="#" class="text-[#151313] mr-2 font-medium hover:text-gray-600">Leave Requests</a>
   </ul>
   <ul class="ml-auto flex items-center">
  <li class="mr-1">
  <?php
  $username = $_SESSION['user']['username'];
  ?>
    <a href="#" class="text-[#151313] hover:text-gray-600 text-sm font-medium"><?php echo $username; ?></a>
  </li>
  <li class="mr-1 relative">
    <button type="button" class="w-8 h-8 rounded justify-center hover:bg-gray-300 dropdown-btn"><i class="ri-arrow-down-s-line"></i></button>
    <div class="dropdown-content hidden absolute right-0 mt-2 w-48 bg-white border border-gray-300 divide-y divide-gray-100 rounded-md shadow-lg">
      <form method="post" action="/logout">
          <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
      </form>
    </div>
</li>
  <script>
      document.querySelector('.dropdown-btn').addEventListener('click', function() {
          document.querySelector('.dropdown-content').classList.toggle('hidden');
      });
  </script>
   </ul>
  </div>
  <!-- End Top Bar -->

<!-- requests tabs -->
<div class="mt-4 ml-4 mb-4">
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex flex-wrap gap-6" aria-label="Tabs">
                <a route="/hr/leave-requests"
                    class="cursor-pointer shrink-0 border-b-2 border-sidebar px-1 pb-4 text-sm font-medium text-sidebar"
                    aria-current="page">
                    All Requests
                </a>
                <a route="/hr/leave-requests/reviewed"
                    class="cursor-pointer shrink-0 border-b-2 border-transparent px-1 pb-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Reviewed Requests
                </a>
            </nav>
        </div>
    </div>
</div>
<!-- end requests tabs -->

  <!-- Leave Requests -->
  <div class="flex flex-wrap">
    <button route="/hr/leave-requests/file-leave" class="mt-9 mr-4 flex ml-6 font-medium bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">File a Leave</button>

    <form action="/hr/leave-requests" method="POST" class="mt-6 ml-auto mr-4 flex">
      <input type="search" id="search" name="search" placeholder="Search" class="w-40 px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
      <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600"><i class="ri-search-line"></i></button>
    </form>
  </div> 

  <!-- UNCOMMENT THIS AFTER FINISHING THE BACKEND FOR LEAVE REQUESTS -->
  <?php 
    if (empty($leaveRequests)) {
        require_once 'inc/noResult.php';
    } 
    else {
        require_once 'inc/leave-requests.table.php';
    } 
  ?>
<!-- End Leave Requests -->
  
</main>
<!-- End Main Bar -->
<script  src="./../src/route.js"></script>
<script  src="./../src/form.js"></script>
<script type="module" src="../public/humanResources/js/sidenav-active-inactive.js"></script>
<script>
  // REJECT MODAL
  document.querySelectorAll('.rejectButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      document.getElementById('idToReject').value = id;
      document.getElementById('rejectModal').classList.remove('hidden');
    });
  });

  document.getElementById('cancelReject').addEventListener('click', function() {
    document.getElementById('rejectModal').classList.add('hidden');
  });

  document.getElementById('confirmReject').addEventListener('click', function() {
    document.getElementById('rejectModal').submit();
  });

  // ACCEPT MODAL
  document.querySelectorAll('.acceptButton').forEach(function(button) {
    button.addEventListener('click', function() {
      var id = this.getAttribute('data-id');
      document.getElementById('idToAccept').value = id;
      document.getElementById('acceptModal').classList.remove('hidden');
    });
  });

  document.getElementById('cancelAccept').addEventListener('click', function() {
    document.getElementById('acceptModal').classList.add('hidden');
  });

  document.getElementById('confirmAccept').addEventListener('click', function() {
    document.getElementById('acceptModal').submit();
  });
</script>
</body>
</html> 
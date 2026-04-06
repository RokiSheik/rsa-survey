<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
require_once '../config.php';
$id = $_GET['id'] ?? 0;
$conn = get_conn();
$stmt = $conn->prepare("SELECT * FROM submissions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    echo "Record not found.";
    exit();
}

$current_page = 'submissions';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submission - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <button id="mobile-toggle" class="lg:hidden fixed top-6 left-6 z-[60] bg-slate-900 text-white p-3 rounded-xl shadow-xl">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-72 bg-slate-900 text-white flex flex-col fixed h-full z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="px-6 py-8 flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center font-bold text-xl text-white">R</div>
            <div>
                <h1 class="text-xl font-bold tracking-tight">RSA Admin</h1>
                <p class="text-xs text-slate-400 font-medium">Control Center</p>
            </div>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="dashboard.php" class="<?php echo $current_page == 'dashboard' ? 'bg-green-600' : 'hover:bg-slate-800'; ?> flex items-center space-x-3 px-4 py-3 rounded-xl transition-all">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="settings.php" class="<?php echo $current_page == 'settings' ? 'bg-green-600' : 'hover:bg-slate-800'; ?> flex items-center space-x-3 px-4 py-3 rounded-xl transition-all">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                <span class="font-medium">Logo & Site Name</span>
            </a>
            <a href="submissions.php" class="<?php echo $current_page == 'submissions' ? 'bg-green-600' : 'hover:bg-slate-800'; ?> flex items-center space-x-3 px-4 py-3 rounded-xl transition-all">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 0-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <span class="font-medium">Submissions</span>
            </a>
        </nav>
        <div class="px-4 py-6 border-t border-slate-800 mt-auto">
            <a href="logout.php" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-red-500/10 text-red-400 font-medium transition-all group">
                <svg class="w-5 h-5 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 lg:ml-72 p-6 lg:p-10 min-h-screen">
        <header class="flex justify-between items-center mb-10">
            <div>
                <nav class="flex text-sm text-slate-400 font-bold uppercase tracking-widest mb-4">
                    <a href="submissions.php" class="hover:text-green-600 transition-all">Submissions</a>
                    <span class="mx-2">&bull;</span>
                    <span class="text-slate-800">Application Details</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight"><?php echo htmlspecialchars($data['outlet_name']); ?></h2>
                <div class="flex items-center space-x-4 mt-2">
                    <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-lg text-xs uppercase"><?php echo date('F d, Y', strtotime($data['created_at'])); ?></span>
                    <span class="text-slate-400 text-sm font-medium">Ref ID: #<?php echo str_pad($data['id'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                 <button onclick="window.print()" class="bg-white hover:bg-slate-50 text-slate-800 font-bold py-3 px-6 rounded-xl border border-slate-200 transition-all shadow-sm flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Print Form</span>
                </button>
                <a href="submissions.php" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition-all">Back to List</a>
            </div>
        </header>

        <div class="w-full space-y-10">
            <!-- Unified Simple View -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-slate-50/50 px-8 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-600 flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Full Survey Data (29 Questions)</span>
                    </h3>
                </div>
                <div class="p-8 space-y-6">
                    <?php 
                    $fields = [
                        '1. Name of Wing' => $data['name_of_wing'],
                        '2. Name of Division' => $data['division_name'],
                        '3. Name of Territory' => $data['territory_name'],
                        '4. Name of Zone' => $data['zone_name'],
                        '5. Code of Zone' => $data['zone_code'],
                        '6. Route Name' => $data['route_name'],
                        '7. Route Code' => $data['route_code'],
                        '8. Outlet Name' => $data['outlet_name'],
                        '9. Outlet Code' => $data['outlet_code'],
                        '10. Retailer Name' => $data['retailer_name'],
                        '11. Retailer Number' => $data['retailer_number'],
                        '12. Surveyor Name' => $data['surveyor_name'],
                        '13. Visit Date' => $data['visit_date'],
                        '14. ADS 10 Taka Plus (Sticks)' => $data['ads_10taka_plus'],
                        '15. ADS Slim Cigarette (Sticks)' => $data['ads_slim_cigarette'],
                        '16. ADS Prime Cigarette (Sticks)' => $data['ads_prime_cigarette'],
                        '17. ADS Mango Cigarette (Sticks)' => $data['ads_mango_cigarette'],
                        '18. Availability (Inventory) - Prime' => $data['availability_prime'],
                        '19. Availability (Inventory) - Mango' => $data['availability_mango'],
                        '20. Visibility of Prime' => $data['visibility_prime'],
                        '21. Visibility of Mango' => $data['visibility_mango'],
                        '22. Buying Price of Prime (BDT/Pack)' => $data['buying_price_prime'],
                        '23. Buying Price of Mango (BDT/Pack)' => $data['buying_price_mango'],
                        '24. Selling Price per stick - Prime' => $data['selling_price_prime'],
                        '25. Selling Price per stick - Mango' => $data['selling_price_mango'],
                        '26. Is there Trade Scheme?' => $data['trade_scheme'],
                        '27. Purchase Time' => $data['purchase_time'],
                        '28. Feedback of Prime' => $data['feedback_prime'],
                        '29. Feedback of Mango' => $data['feedback_mango'],
                    ];

                    foreach($fields as $label => $val):
                    ?>
                        <div class="border-b border-slate-50 pb-4">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo $label; ?></p>
                            <p class="text-slate-800 font-semibold"><?php echo htmlspecialchars($val); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Mobile Sidebar Toggle
        const toggle = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html><?php $conn->close(); ?>

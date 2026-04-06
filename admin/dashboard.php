<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
require_once '../config.php';
$conn = get_conn();
$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$site_name = $settings['site_name'] ?? 'RSA Dealership';
$logo_path = $settings['logo_path'] ?? '';

// Basic stats
$total_submissions = $conn->query("SELECT COUNT(*) as count FROM submissions")->fetch_assoc()['count'];
$today_submissions = $conn->query("SELECT COUNT(*) as count FROM submissions WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];
$conn->close();

$current_page = 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex min-h-screen">
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
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
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

    <!-- Main Content -->
    <main class="flex-1 lg:ml-72 p-6 lg:p-10 min-h-screen">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Good Day, Administrator</h2>
                <p class="text-slate-500 font-medium mt-1">Here is a quick overview of your system.</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100 font-medium text-slate-600 flex items-center">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    System Online
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all border-b-4 border-b-green-500">
                <div class="flex justify-between items-center relative z-10">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Total Submissions</p>
                        <h3 class="text-4xl font-black text-slate-800"><?php echo number_format($total_submissions); ?></h3>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-green-600 bg-green-50 inline-block px-2 py-1 rounded-lg">+ Life Time</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all border-b-4 border-b-blue-500">
                <div class="flex justify-between items-center relative z-10">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Today's Entries</p>
                        <h3 class="text-4xl font-black text-slate-800"><?php echo number_format($today_submissions); ?></h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-blue-600 bg-blue-50 inline-block px-2 py-1 rounded-lg">Last 24 Hours</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all border-b-4 border-b-amber-500">
                <div class="flex justify-between items-center relative z-10">
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">System Status</p>
                        <h3 class="text-4xl font-black text-slate-800">Healthy</h3>
                    </div>
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-amber-600 bg-amber-50 inline-block px-2 py-1 rounded-lg">Active</p>
            </div>
        </div>

        <!-- Quick Info -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h4 class="text-xl font-bold text-slate-800 mb-6">Latest Configuration</h4>
            <div class="flex items-center justify-between p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center overflow-hidden p-2">
                        <?php if ($logo_path): ?>
                            <img src="../<?php echo $logo_path; ?>" class="max-h-full object-contain">
                        <?php else: ?>
                            <span class="text-green-600 font-bold">LOGO</span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-400 uppercase mb-1">Site Title</p>
                        <h5 class="text-2xl font-bold text-slate-800"><?php echo $site_name; ?></h5>
                        <p class="text-sm text-slate-500 mt-1">Logo and Site Title are visible on the public application form.</p>
                    </div>
                </div>
                <a href="settings.php" class="bg-white hover:bg-slate-50 text-slate-800 font-bold py-3 px-6 rounded-xl border border-slate-200 transition-all shadow-sm">
                    Modify Settings
                </a>
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
</html>

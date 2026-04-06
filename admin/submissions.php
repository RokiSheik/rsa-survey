<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
require_once '../config.php';
$conn = get_conn();

// Filters
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where = " WHERE 1=1 ";
if ($filter == 'today') {
    $where .= " AND DATE(created_at) = CURDATE() ";
} elseif ($filter == 'week') {
    $where .= " AND created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ";
} elseif ($filter == 'month') {
    $where .= " AND created_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) ";
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$count_sql = "SELECT COUNT(*) as total FROM submissions " . $where;
$total_rows = $conn->query($count_sql)->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

$sql = "SELECT * FROM submissions " . $where . " ORDER BY created_at DESC LIMIT $offset, $limit";
$result = $conn->query($sql);

$current_page = 'submissions';

// For Excel Export (fetch all filtered rows)
$export_sql = "SELECT * FROM submissions " . $where . " ORDER BY created_at DESC";
$export_result = $conn->query($export_sql);
$all_submissions = [];
while($row = $export_result->fetch_assoc()) {
    $all_submissions[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submissions - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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

    <main class="flex-1 lg:ml-72 p-6 lg:p-10 min-h-screen transition-all">
        <header class="flex flex-col md:flex-row space-y-4 md:space-y-0 justify-between items-start md:items-center mb-10 mt-14 lg:mt-0">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 tracking-tight">Customer Submissions</h2>
                <p class="text-slate-500 font-medium mt-1 text-sm md:text-base">Review and manage survey submissions.</p>
            </div>
            <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full md:w-auto">
                <button onclick="exportToExcel()" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Export to Excel</span>
                </button>
            </div>
        </header>

        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-4 mb-8">
            <span class="text-sm font-bold text-slate-400 uppercase tracking-wide">Filters:</span>
            <div class="flex bg-white p-1.5 rounded-xl shadow-sm border border-slate-200">
                <a href="?filter=all" class="<?php echo $filter == 'all' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50'; ?> px-4 py-2 rounded-lg font-bold text-sm transition-all">All Time</a>
                <a href="?filter=today" class="<?php echo $filter == 'today' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50'; ?> px-4 py-2 rounded-lg font-bold text-sm transition-all">Today</a>
                <a href="?filter=week" class="<?php echo $filter == 'week' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50'; ?> px-4 py-2 rounded-lg font-bold text-sm transition-all">This Week</a>
                <a href="?filter=month" class="<?php echo $filter == 'month' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50'; ?> px-4 py-2 rounded-lg font-bold text-sm transition-all">This Month</a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider">Wing / Div</th>
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider">Territory</th>
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider">Outlet</th>
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider">Surveyor</th>
                            <th class="px-6 py-5 text-sm font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-slate-50/50 transition-all">
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-semibold text-slate-800"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
                                        <div class="text-xs text-slate-400 font-medium"><?php echo date('h:i A', strtotime($row['created_at'])); ?></div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($row['name_of_wing']); ?></div>
                                        <div class="text-xs text-slate-400"><?php echo htmlspecialchars($row['division_name']); ?></div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600"><?php echo htmlspecialchars($row['territory_name']); ?></td>
                                    <td class="px-6 py-5 font-bold text-slate-800"><?php echo htmlspecialchars($row['outlet_name']); ?></td>
                                    <td class="px-6 py-5 text-sm font-medium text-slate-600"><?php echo htmlspecialchars($row['surveyor_name']); ?></td>
                                    <td class="px-6 py-5 text-right space-x-2">
                                        <a href="view_submission.php?id=<?php echo $row['id']; ?>" class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg font-bold text-xs hover:bg-blue-600 hover:text-white transition-all">
                                            VIEW
                                        </a>
                                        <button onclick="deleteSubmission(<?php echo $row['id']; ?>)" class="inline-flex items-center px-3 py-2 bg-red-50 text-red-500 rounded-lg font-bold text-xs hover:bg-red-500 hover:text-white transition-all">
                                            DELETE
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400 font-medium">No submissions found matching your filters.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="bg-slate-50 px-6 py-4 flex items-center justify-between border-t border-slate-100">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?> (<?php echo $total_rows; ?> Total)
                    </div>
                    <div class="flex space-x-2">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page-1; ?>&filter=<?php echo $filter; ?>" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-100 transition-all">Previous</a>
                        <?php endif; ?>
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page+1; ?>&filter=<?php echo $filter; ?>" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-100 transition-all">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Mobile Sidebar Toggle
        const toggle = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        function deleteSubmission(id) {
            if (confirm('Are you sure you want to delete this submission?')) {
                window.location.href = 'delete_submission.php?id=' + id;
            }
        }

        function exportToExcel() {
            const data = <?php echo json_encode($all_submissions); ?>;
            const worksheet = XLSX.utils.json_to_sheet(data);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Submissions");
            XLSX.writeFile(workbook, "RSA_Survey_Export.xlsx");
        }
    </script>
</body>
</html><?php $conn->close(); ?>

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
    <!-- Sidebar -->
    <aside class="w-72 bg-slate-900 text-white flex flex-col fixed h-full z-50">
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

    <main class="flex-1 ml-72 p-10 min-h-screen">
        <header class="flex justify-between items-center mb-10">
            <div>
                <nav class="flex text-sm text-slate-400 font-bold uppercase tracking-widest mb-4">
                    <a href="submissions.php" class="hover:text-green-600 transition-all">Submissions</a>
                    <span class="mx-2">&bull;</span>
                    <span class="text-slate-800">Application Details</span>
                </nav>
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight"><?php echo htmlspecialchars($data['firm_name']); ?></h2>
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Basic Information Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Owner Information</h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">2. Owner Name</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['owner_name']); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">5. Email Id</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['email']); ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">3. Personal Cell No.</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['personal_phone']); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">4. Office Cell No.</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['office_phone'] ?: 'N/A'); ?></p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">6. Address (City/State)</p>
                        <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['city_state']); ?> (7. Pin: <?php echo htmlspecialchars($data['pin_code']); ?>)</p>
                    </div>
                </div>
            </div>

            <!-- Business Information Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Business Profile</h3>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">10. Nature of Business</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['nature_of_business']); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">11. Monthly Sale</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['monthly_sale']); ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">12. Years in Business</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['years_in_business']); ?> Years</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">13. No. of Employees</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['no_employee']); ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">8. GST No.</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['gst_no'] ?: 'N/A'); ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">9. PAN No.</p>
                            <p class="text-slate-800 font-bold"><?php echo htmlspecialchars($data['pan_no']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logistics & Experience -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden lg:col-span-2">
                <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/50 flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 11V9m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Logistics & Market Expertise</h3>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">15. Area Coverage</p>
                        <p class="text-slate-800 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100"><?php echo htmlspecialchars($data['area_covering'] ?: 'Not Specified'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">16. Office / Godown Facility</p>
                        <div class="flex items-center space-x-3 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                             <?php if ($data['office_godown'] == 'Yes'): ?>
                                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                                <span class="text-slate-800 font-extrabold uppercase tracking-widest">Available</span>
                             <?php else: ?>
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                <span class="text-slate-800 font-extrabold uppercase tracking-widest text-slate-400">Not Available</span>
                             <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Existing Brands Dealing in</p>
                        <p class="text-slate-800 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100"><?php echo htmlspecialchars($data['existing_brand_dealer'] ?: 'None'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">14. Field Experience</p>
                        <p class="text-slate-800 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100"><?php echo htmlspecialchars($data['experience'] ?: 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">18. Monthly Turnover</p>
                        <p class="text-slate-800 font-bold bg-slate-50 p-4 rounded-2xl border border-slate-100"><?php echo htmlspecialchars($data['turnover'] ?: 'N/A'); ?></p>
                    </div>
                </div>
                 <div class="p-8 border-t border-slate-50">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">19. Products of Interest</p>
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        $prods = explode(', ', $data['product_interest']);
                        foreach($prods as $p):
                            if($p != 'None Selected'):
                        ?>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200"><?php echo htmlspecialchars($p); ?></span>
                        <?php 
                            else:
                                echo '<span class="text-slate-400 italic text-sm">No products selected</span>';
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                 <div class="p-8 border-t border-slate-50">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">17. Any Other Business</p>
                    <p class="text-slate-800 font-medium italic"><?php echo htmlspecialchars($data['any_other_business'] ?: 'No other business reported.'); ?></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html><?php $conn->close(); ?>

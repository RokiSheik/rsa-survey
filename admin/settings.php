<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
require_once '../config.php';
$conn = get_conn();

$message = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_name = $_POST['site_name'];
    $logo_path = $_POST['current_logo'];

    // Handle Logo Upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $file_name = "logo_" . time() . "." . $file_extension;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $logo_path = "uploads/" . $file_name;
        } else {
            $error = "Failed to upload logo.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("UPDATE settings SET site_name = ?, logo_path = ? WHERE id = 1");
        $stmt->bind_param("ss", $site_name, $logo_path);
        if ($stmt->execute()) {
            $message = "Settings updated successfully!";
        } else {
            $error = "Error updating database: " . $stmt->error;
        }
        $stmt->close();
    }
}

$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$site_name = $settings['site_name'];
$logo_path = $settings['logo_path'];
$conn->close();

$current_page = 'settings';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <!-- Sidebar (Same as dashboard) -->
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

    <main class="flex-1 ml-72 p-10 min-h-screen">
        <header class="mb-10">
            <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">System Configuration</h2>
            <p class="text-slate-500 font-medium mt-1">Manage branding and identity for your public application form.</p>
        </header>

        <?php if ($message): ?>
            <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-bold"><?php echo $message; ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                <span class="font-bold"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 max-w-2xl">
            <form action="" method="POST" enctype="multipart/form-data" class="space-y-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Logo Preview</label>
                    <div class="w-32 h-32 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden p-4 group relative">
                        <?php if ($logo_path): ?>
                            <img src="../<?php echo $logo_path; ?>" class="max-h-full object-contain" id="logo-preview">
                        <?php else: ?>
                            <div id="no-logo" class="text-slate-400 text-xs font-bold text-center">NO LOGO SET</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Upload Custom Logo</label>
                    <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer transition-all">
                    <p class="text-xs text-slate-400 mt-2">Recommended: PNG or SVG with transparent background.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Site Name / Heading</label>
                    <input type="text" name="site_name" value="<?php echo $site_name; ?>" required class="w-full px-6 py-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none text-slate-800 font-medium">
                </div>

                <input type="hidden" name="current_logo" value="<?php echo $logo_path; ?>">

                <div class="pt-4">
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
                        Save Identity Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

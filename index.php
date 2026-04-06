<?php
require_once 'config.php';

// Fetch settings
$conn = get_conn();
$settings = $conn->query("SELECT * FROM settings LIMIT 1")->fetch_assoc();
$site_name = $settings['site_name'] ?? 'RSA Dealership';
$logo_path = $settings['logo_path'] ?? '';
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?> - Application Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    <div class="max-w-4xl mx-auto py-10 px-4">
        <!-- Logo Section -->
        <div class="flex flex-col items-center mb-8">
            <?php if ($logo_path): ?>
                <img src="<?php echo $logo_path; ?>" alt="Logo" class="max-h-24 mb-4 object-contain">
            <?php else: ?>
                <div class="text-4xl font-extrabold text-green-700 tracking-tighter mb-2">RSA</div>
            <?php endif; ?>
            <h1 class="text-3xl font-bold text-green-800 text-center uppercase tracking-wider"><?php echo $site_name; ?> Survey Form</h1>
            <div class="w-24 h-1 bg-green-500 mt-4 rounded-full"></div>
        </div>

        <!-- Form Section -->
        <div class="bg-white shadow-2xl rounded-2xl p-8 border border-green-50/50">
            <form action="submit.php" method="POST" class="space-y-8">
                <!-- 29 Numbered Fields In Order -->
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">1. Name of Wing <span class="text-red-500">*</span></label>
                    <input type="text" name="name_of_wing" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">2. Name of Division <span class="text-red-500">*</span></label>
                    <input type="text" name="division_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">3. Name of Territory <span class="text-red-500">*</span></label>
                    <input type="text" name="territory_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">4. Name of Zone <span class="text-red-500">*</span></label>
                    <input type="text" name="zone_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">5. Code of Zone <span class="text-red-500">*</span></label>
                    <input type="text" name="zone_code" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">6. Route Name <span class="text-red-500">*</span></label>
                    <input type="text" name="route_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">7. Route Code <span class="text-red-500">*</span></label>
                    <input type="text" name="route_code" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">8. Outlet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="outlet_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">9. Outlet Code <span class="text-red-500">*</span></label>
                    <input type="text" name="outlet_code" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">10. Retailer Name <span class="text-red-500">*</span></label>
                    <input type="text" name="retailer_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">11. Retailer Number <span class="text-red-500">*</span></label>
                    <input type="text" name="retailer_number" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">12. Surveyor Name <span class="text-red-500">*</span></label>
                    <input type="text" name="surveyor_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">13. Visit Date <span class="text-red-500">*</span></label>
                    <input type="date" name="visit_date" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">14. ADS (Average Daily Sales) 10 taka Plus (Sticks)</label>
                    <input type="number" name="ads_10taka_plus" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">15. ADS (Average Daily Sales) Slim Cigarete (sticks)</label>
                    <input type="number" name="ads_slim_cigarette" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">16. ADS (Average Daily Sales) Prime Cigarette (sticks)</label>
                    <input type="number" name="ads_prime_cigarette" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">17. ADS (Average Daily Sales) Mango Cigarete (sticks)</label>
                    <input type="number" name="ads_mango_cigarette" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">18. Availability (Inventory) – Prime</label>
                    <input type="text" name="availability_prime" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">19. Availability (Inventory) – Mango</label>
                    <input type="text" name="availability_mango" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">20. Visibility of Prime</label>
                    <div class="space-y-3 mt-2">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="visibility_prime" value="Yes" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">Yes</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="visibility_prime" value="No" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">21. Visibility of Mango</label>
                    <div class="space-y-3 mt-2">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="visibility_mango" value="Yes" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">Yes</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="visibility_mango" value="No" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">22. Retailer Buying Price (RSP) of Prime (BDT per pack)</label>
                    <input type="number" name="buying_price_prime" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">23. Retailer Buying Price (RSP) of Mango (BDT per pack)</label>
                    <input type="number" name="buying_price_mango" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">24. Selling Price per stick of Prime</label>
                    <input type="text" name="selling_price_prime" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">25. Selling Price per stick of Mango</label>
                    <input type="text" name="selling_price_mango" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">26. Is there Trade Scheme?</label>
                    <div class="space-y-3 mt-2">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="trade_scheme" value="Yes" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">Yes</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="trade_scheme" value="No" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">27. Purchase Time</label>
                    <div class="space-y-3 mt-2">
                        <?php foreach(['1', '2', '3', '4', 'More'] as $time): ?>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="purchase_time" value="<?php echo $time; ?>" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors"><?php echo $time; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">28. Feedback of Prime</label>
                    <div class="space-y-3 mt-2">
                        <?php foreach(['Taste is good', 'Design is good', 'Price is good', 'Taste not Good', 'Design not Good', 'Price not Good'] as $f): ?>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="feedback_prime" value="<?php echo $f; ?>" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors"><?php echo $f; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">29. Feedback of Mango</label>
                    <div class="space-y-3 mt-2">
                        <?php foreach(['Taste is good', 'Design is good', 'Price is good', 'Taste not Good', 'Design not Good', 'Price not Good'] as $f): ?>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="radio" name="feedback_mango" value="<?php echo $f; ?>" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors"><?php echo $f; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-10">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-5 px-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 text-lg uppercase tracking-widest">
                        Submit Survey
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4">By submitting, you agree to our terms and conditions.</p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> <?php echo $site_name; ?>. All rights reserved.
        </div>
    </div>
</body>
</html>

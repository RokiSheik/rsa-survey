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
            <h1 class="text-3xl font-bold text-green-800 text-center uppercase tracking-wider"><?php echo $site_name; ?> Dealer Application Form</h1>
            <div class="w-24 h-1 bg-green-500 mt-4 rounded-full"></div>
        </div>

        <!-- Form Section -->
        <div class="bg-white shadow-2xl rounded-2xl p-8 border border-green-50/50">
            <form action="submit.php" method="POST" class="space-y-8">
                <!-- Single Column Layout For All Fields -->
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">1. Name of Firm <span class="text-red-500">*</span></label>
                    <input type="text" name="firm_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">2. Name of Owner <span class="text-red-500">*</span></label>
                    <input type="text" name="owner_name" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">3. Personal Cell No. <span class="text-red-500">*</span></label>
                    <input type="tel" name="personal_phone" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">4. Office Cell No.</label>
                    <input type="tel" name="office_phone" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">5. Email Id <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">6. City / State <span class="text-red-500">*</span></label>
                    <input type="text" name="city_state" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">7. Pin Code <span class="text-red-500">*</span></label>
                    <input type="text" name="pin_code" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">8. GST No.</label>
                    <input type="text" name="gst_no" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">9. PAN No. <span class="text-red-500">*</span></label>
                    <input type="text" name="pan_no" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">10. Nature of Business <span class="text-red-500">*</span></label>
                    <input type="text" name="nature_of_business" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">11. Monthly Sale <span class="text-red-500">*</span></label>
                    <input type="text" name="monthly_sale" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">12. Years in Business <span class="text-red-500">*</span></label>
                    <input type="number" name="years_in_business" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">13. No. of Employee</label>
                    <input type="number" name="no_employee" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">14. Experience in this field</label>
                    <input type="text" name="experience" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">15. Area you are covering?</label>
                    <input type="text" name="area_covering" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">16. Do you have office / godown?</label>
                    <div class="flex items-center space-x-6 mt-2">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="office_godown" value="Yes" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600">Yes</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="office_godown" value="No" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">17. Any other business you are doing?</label>
                    <input type="text" name="any_other_business" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">18. Monthly Turnover</label>
                    <input type="text" name="turnover" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">19. Which products are you interested in dealing with?</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-green-50/30 p-6 rounded-xl border border-green-100">
                        <?php 
                        $products = ['Battery', 'Charger', 'E-Rickshaw', 'E-Loader', 'Tyres', 'Spare Parts'];
                        foreach($products as $prod): 
                        ?>
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <input type="checkbox" name="product_interest[]" value="<?php echo $prod; ?>" class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600 group-hover:text-green-700 transition-colors"><?php echo $prod; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-10">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-5 px-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 text-lg uppercase tracking-widest">
                        Submit Application
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

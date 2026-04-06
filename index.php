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
                <!-- 29 Numbered Fields In Order -->
                
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
                    <label class="block text-sm font-bold text-gray-700 mb-2">10. Educational Qualification</label>
                    <input type="text" name="educational_qualification" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">11. Nature of Business <span class="text-red-500">*</span></label>
                    <input type="text" name="nature_of_business" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">12. Monthly Sale <span class="text-red-500">*</span></label>
                    <input type="text" name="monthly_sale" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">13. Years in Business <span class="text-red-500">*</span></label>
                    <input type="number" name="years_in_business" required class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">14. No. of Employee</label>
                    <input type="number" name="no_employee" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">15. Do you have any prior experience in similar business?</label>
                    <div class="flex items-center space-x-6 mt-2">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="prior_experience" value="Yes" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600">Yes</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="prior_experience" value="No" class="w-5 h-5 text-green-600 border-gray-300 focus:ring-green-500 cursor-pointer">
                            <span class="text-sm font-semibold text-gray-600">No</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">16. If yes, for how long (duration)?</label>
                    <input type="text" name="experience_duration" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">17. Experience in current field</label>
                    <input type="text" name="experience" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">18. Area you are covering?</label>
                    <input type="text" name="area_covering" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">19. Do you have office / godown?</label>
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
                    <label class="block text-sm font-bold text-gray-700 mb-2">20. Mention space of your office/godown? (sq ft)</label>
                    <input type="text" name="godown_space" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">21. Any other business you are doing?</label>
                    <input type="text" name="any_other_business" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">22. Monthly Turnover of current business</label>
                    <input type="text" name="turnover" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">23. Expected Monthly Investment</label>
                    <input type="text" name="investment_capacity" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">24. No. of Sales People</label>
                        <input type="number" name="sales_staff" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">25. No. of Service People</label>
                        <input type="number" name="service_staff" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">26. How did you hear about us?</label>
                    <select name="hear_about_us" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                        <option value="Google Search">Google Search</option>
                        <option value="Social Media">Social Media (FB, Inst, etc.)</option>
                        <option value="Newspaper">Newspaper</option>
                        <option value="Referral">Referral</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">27. Why are you interested in our dealership?</label>
                    <textarea name="why_join" rows="3" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">28. Expected date of launch (if awarded)?</label>
                    <input type="date" name="expected_launch" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all outline-none bg-gray-50/20">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-3">29. Which products are you interested in dealing with?</label>
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

<x-guest-layout>

    <style>
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: thin;
            }
            
            .table-container::-webkit-scrollbar {
                height: 8px;
            }
            
            .table-container::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            
            .table-container::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }
            
            .table-container::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
            
            table {
                font-size: 0.875rem;
            }
            
            th, td {
                padding: 0.5rem 0.75rem !important;
                min-width: 120px !important;
            }
            
            th:first-child, td:first-child {
                min-width: 140px !important;
                position: sticky;
                left: 0;
                z-index: 10;
            }
            
            .mobile-header {
                font-size: 1.5rem !important;
            }
            
            .mobile-subtitle {
                font-size: 0.875rem !important;
            }
        }
        
        @media (max-width: 640px) {
            body {
                padding: 0.5rem !important;
            }
            
            .mobile-header {
                font-size: 1.25rem !important;
                padding: 1rem !important;
            }
            
            .mobile-subtitle {
                font-size: 0.75rem !important;
            }
            
            table {
                font-size: 0.75rem;
            }
            
            th, td {
                padding: 0.375rem 0.5rem !important;
                min-width: 100px !important;
            }
            
            th:first-child, td:first-child {
                min-width: 120px !important;
            }
            
            .card-bin {
                font-size: 0.75rem !important;
            }
        }
    </style>
    <!-- Hero Section -->
    <section class="pt-10 pb-4 bg-blue-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6">
                Pricing
            </h1>
            <p class="text-xl text-white max-w-3xl mx-auto mb-8">
                Choose the perfect plan for your digital payment needs. No hidden fees, no surprises.
            </p>
        </div>
    </section>

    <!-- Detailed Pricing Table -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto table-container border">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b-2 border-gray-200">
                                <th
                                    class="px-4 py-4 text-left font-semibold text-gray-700 sticky left-0 bg-gray-50 z-10 border-r border-gray-200 min-w-[180px]">
                                    Card Features
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">493875</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">537100</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">428852</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">517746</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">428820</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">512631</div>
                                </th>
                                <th
                                    class="px-4 py-4 text-center font-semibold text-gray-700 border-r border-gray-200 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">513989</div>
                                </th>
                                <th class="px-4 py-4 text-center font-semibold text-gray-700 min-w-[150px]">
                                    <div class="font-bold text-blue-600 card-bin">543691</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Card Brand -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-white z-10 border-r border-gray-200">
                                    Card Brand
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">VISA</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">MASTERCARD</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">VISA</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">MASTERCARD</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">VISA</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">MASTERCARD</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">MASTERCARD</td>
                                <td class="px-4 py-3 text-center">MASTERCARD</td>
                            </tr>

                            <!-- Card Issue Cost -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 bg-blue-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-blue-50 z-10 border-r border-gray-200">
                                    Card Issue Cost
                                </td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600 border-r border-gray-200">
                                    $5.00</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">$5.00</td>
                            </tr>

                            <!-- Card Top-up Fees -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-white z-10 border-r border-gray-200">
                                    Card Top-up Fees
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">10%</td>
                                <td class="px-4 py-3 text-center">10%</td>
                            </tr>

                            <!-- Monthly Charges -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 bg-green-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-green-50 z-10 border-r border-gray-200">
                                    Monthly Charges
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-green-600 font-semibold">None</span>
                                </td>
                            </tr>

                            <!-- Reloadable -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-white z-10 border-r border-gray-200">
                                    Reloadable
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                            </tr>

                            <!-- Multi-Currency Support -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 bg-blue-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-blue-50 z-10 border-r border-gray-200">
                                    Multi-Currency Support
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                            </tr>

                            <!-- Card Type -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-white z-10 border-r border-gray-200">
                                    Card Type
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CREDIT</td>
                                <td class="px-4 py-3 text-center">CREDIT</td>
                            </tr>

                            <!-- Card Level -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-gray-50 z-10 border-r border-gray-200">
                                    Card Level
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CORPORATE PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CORPORATE PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CORPORATE PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">PURCHASING</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">CORPORATE PURCHASING</td>
                                <td class="px-4 py-3 text-center">PURCHASING</td>
                            </tr>

                            <!-- Card Issuer Country -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-white z-10 border-r border-gray-200">
                                    Card Issuer Country
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">🇭🇰 Hong Kong</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">United States</td>
                                <td class="px-4 py-3 text-center">United States</td>
                            </tr>

                            <!-- 3D Secure Payments -->
                            <tr class="border-b border-gray-200 hover:bg-gray-50 bg-green-50">
                                <td
                                    class="px-4 py-3 font-medium text-gray-700 sticky left-0 bg-green-50 z-10 border-r border-gray-200">
                                    3D Secure Payments
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center border-r border-gray-200">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-green-600 font-semibold">✓ Yes</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-black mb-4">Pricing FAQ</h2>
                <p class="text-xl text-gray-600">Common questions about our pricing plans</p>
            </div>

            <div class="space-y-8">
                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-black mb-4">Can I change my plan anytime?</h3>
                    <p class="text-gray-600">
                        Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately, and
                        we'll prorate any billing differences. Basic plan is always free with 5 cards per month.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-black mb-4">What card values are included?</h3>
                    <p class="text-gray-600">
                        Basic package includes a $40 Mastercard for FREE. Standard package provides a $7 Mastercard.
                        Premium package offers a $10 Visa card. Each package includes the full card value as part of
                        your monthly subscription.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-black mb-4">What are the card values and costs?</h3>
                    <p class="text-gray-600">
                        Basic package includes a $40 Mastercard for FREE. Standard package offers a $7 Mastercard.
                        Premium package provides a $10 Visa card. All packages include the card value as part of the
                        monthly subscription.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-black mb-4">Which countries and card brands are supported?</h3>
                    <p class="text-gray-600">
                        Basic: US only with Mastercard. Standard: US, UK, EU with Mastercard & Visa. Premium: Global
                        coverage (50+ countries) with Mastercard & Visa. All plans support both virtual debit and credit
                        cards (except Basic which is debit only).
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-black mb-4">Do you offer refunds?</h3>
                    <p class="text-gray-600">
                        We offer a 30-day money-back guarantee for all paid plans. If you're not satisfied, contact our
                        support team for a full refund. Basic plan is free so no refund needed.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
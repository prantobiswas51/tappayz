<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>



                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Transactions</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">View and manage your transaction history</p>
                </div>
            </div>
            <div class="toolbar">
                <div class="filters">
                    <div class="search-container">
                        <input class="input search-input" placeholder="Search merchant or amount"
                            style="width:280px; padding-left:40px; background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        <div class="search-icon" style="color: #6c757d;">🔍</div>
                    </div>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>All statuses</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Declined</option>
                    </select>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>All cards</option>
                        <option>Marketing</option>
                        <option>Subscriptions</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="border p-2 rounded-lg">
            <a href="{{ route('get_transactions') }}">Get Transactions</a>
        </div>

        <div class="card"
            style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-top: 20px;">
            <table class="table" style="color: #333;">
                <thead>
                    <tr>
                        <th style="color: #6c757d; border-bottom: 1px solid #e9ecef; padding: 12px;">Merchant</th>
                        <th style="color: #6c757d; border-bottom: 1px solid #e9ecef; padding: 12px;">Card</th>
                        <th style="color: #6c757d; border-bottom: 1px solid #e9ecef; padding: 12px;">Date</th>
                        <th style="color: #6c757d; border-bottom: 1px solid #e9ecef; padding: 12px;">Amount</th>
                        <th style="color: #6c757d; border-bottom: 1px solid #e9ecef; padding: 12px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="border-bottom: 1px solid #f8f9fa;">
                        <td style="padding: 12px;">Google Ads</td>
                        <td style="padding: 12px;">Marketing</td>
                        <td style="padding: 12px;">Sep 12</td>
                        <td style="padding: 12px; font-weight: 600;">$220.00</td>
                        <td style="padding: 12px;"><span class="status success">Completed</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8f9fa;">
                        <td style="padding: 12px;">Meta Ads</td>
                        <td style="padding: 12px;">Marketing</td>
                        <td style="padding: 12px;">Sep 11</td>
                        <td style="padding: 12px; font-weight: 600;">$120.50</td>
                        <td style="padding: 12px;"><span class="status pending">Pending</span></td>
                    </tr>
                    <tr style="border-bottom: 1px solid #f8f9fa;">
                        <td style="padding: 12px;">Figma</td>
                        <td style="padding: 12px;">Subscriptions</td>
                        <td style="padding: 12px;">Sep 10</td>
                        <td style="padding: 12px; font-weight: 600;">$12.00</td>
                        <td style="padding: 12px;"><span class="status failed">Declined</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 12px;">Amazon AWS</td>
                        <td style="padding: 12px;">DevOps</td>
                        <td style="padding: 12px;">Sep 09</td>
                        <td style="padding: 12px; font-weight: 600;">$480.90</td>
                        <td style="padding: 12px;"><span class="status success">Completed</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</x-app-layout>
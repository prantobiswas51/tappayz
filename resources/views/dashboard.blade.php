<x-app-layout>

    <main class="main min-h-screen" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>Overview | {{ Auth::user()->name }} </div>
            </div>
            <input class="input search" placeholder="Search…"
                style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
        </div>
        <section class="grid grid-4" style="max-width: 800px; margin: 0;">
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Total Balance</div>
                <div class="value" style="color: #28a745; font-weight: 700; font-size: 18px;">${{ Auth::user()->balance }} </div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Active Cards</div>
                <div class="value" style="color: #007bff; font-weight: 700; font-size: 18px;">{{ Auth::user()->active_cards }}</div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Spending (30d)</div>
                <div class="value" style="color: #fd7e14; font-weight: 700; font-size: 18px;">$4,902.55</div>
            </div>
            <div class="widget kpi" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333; padding: 16px;">
                <div class="label" style="color: #6c757d; font-size: 12px;">Pending Authorizations</div>
                <div class="value" style="color: #ffc107; font-weight: 700; font-size: 18px;">3</div>
            </div>
        </section>

        <section class="grid grid-1" style="margin-top:16px;">
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-header">
                    <div class="card-title" style="color: #333;">Recent Transactions</div>
                    <a class="btn" href="transactions.html">View all</a>
                </div>
                <table class="table" style="color: #333;">
                    <thead>
                        <tr>
                            <th style="color: #6c757d; border-bottom: 1px solid #e9ecef;">Merchant</th>
                            <th style="color: #6c757d; border-bottom: 1px solid #e9ecef;">Date</th>
                            <th style="color: #6c757d; border-bottom: 1px solid #e9ecef;">Amount</th>
                            <th style="color: #6c757d; border-bottom: 1px solid #e9ecef;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Google Ads</td>
                            <td>Sep 12</td>
                            <td>$220.00</td>
                            <td><span class="status success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Meta Ads</td>
                            <td>Sep 11</td>
                            <td>$120.50</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Figma</td>
                            <td>Sep 10</td>
                            <td>$12.00</td>
                            <td><span class="status failed">Declined</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</x-app-layout>
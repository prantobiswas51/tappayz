<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Cards</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your virtual cards</p>
                </div>
            </div>
            <div class="toolbar">
                <div class="filters">
                    <div class="search-container">
                        <input class="input search-input" placeholder="Search label or last 4"
                            style="width:280px; padding-left:40px; background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" />
                        <div class="search-icon" style="color: #6c757d;">🔍</div>
                    </div>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>All Status</option>
                        <option>Active</option>
                        <option>Frozen</option>
                        <option>Terminated</option>
                    </select>
                    <select class="input filter-select"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;">
                        <option>Any Currency</option>
                        <option>USD</option>
                        <option>EUR</option>
                        <option>GBP</option>
                    </select>
                </div>
                <a class="btn btn-brand create-btn" href="{{ route('show_bins') }}">
                    <span>+</span>
                    <span>Create Card</span>
                </a>
                <a class="btn btn-brand create-btn" href="{{ route('fetch_bins') }}">
                    <span>Sync BINs</span>
                </a>
            </div>
        </div>

        <section id="cards-grid" class="cards-list" data-create-card-url="{{ route('show_bins') }}">
        </section>
        
    </main>
</x-app-layout>
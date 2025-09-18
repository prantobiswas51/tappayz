<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Settings</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your account settings and preferences
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-2">
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Profile</div>
                <form class="form">
                    <div class="field"><label class="label" style="color: #6c757d;">Full name</label><input
                            class="input" value="John Doe"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                    <div class="field"><label class="label" style="color: #6c757d;">Email</label><input class="input"
                            value="you@business.com"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                    <a class="btn btn-brand" href="#">Save</a>
                </form>
            </div>
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Security</div>
                <div class="field"><label class="label" style="color: #6c757d;">Current password</label><input
                        class="input" type="password"
                        style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                <div class="field"><label class="label" style="color: #6c757d;">New password</label><input class="input"
                        type="password" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                <a class="btn btn-brand mt-4" href="#">Update password</a>
            </div>
        </div>
    </main>
</x-app-layout>
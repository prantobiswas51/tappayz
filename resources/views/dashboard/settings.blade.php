<x-app-layout>
    <main class="p-4" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">

                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">Settings</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Manage your account settings and preferences
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

            <div class="card">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Profile</div>
                <form class="form">
                    <div class="field">
                        <label class="label" style="color: #6c757d;">Full name</label><input
                            class="input" value="{{ Auth::user()->name }}" /></div>
                    <div class="field"><label class="label" style="color: #6c757d;">Email</label><input class="input"
                            value="{{ Auth::user()->email }}" /></div>
                    <a class="btn btn-brand" href="#">Save</a>
                </form>
            </div>

            <div class="card">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Security</div>

                <div class="field">
                    <label class="label" style="color: #6c757d;">Current password</label>
                    <input class="input" type="password" />
                </div>

                <div class="field">
                    <label class="label" style="color: #6c757d;">New password</label><input class="input"
                        type="password" />
                </div>

                <div class="field">
                    <label class="label" style="color: #6c757d;">Retype New password</label><input class="input"
                        type="password" />
                </div>

                <a class="btn btn-brand mt-4" href="#">Update password</a>
            </div>
        </div>
    </main>
</x-app-layout>
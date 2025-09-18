<x-app-layout>
    <main class="main" style="background: white; color: #333;">
        <div class="topbar">
            <div class="brand" style="gap:8px;">
                <div class="brand-badge" style="width:28px;height:28px;"></div>
                <div>
                    <h1 style="margin:0; font-size:24px; font-weight:700; color: #333;">KYC Verification</h1>
                    <p style="margin:0; color: #6c757d; font-size:14px;">Complete your Know Your Customer verification
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-2">
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Business Details</div>
                <form class="form">
                    <div class="field"><label class="label" style="color: #6c757d;">Company name</label><input
                            class="input" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                    <div class="field"><label class="label" style="color: #6c757d;">Registration number</label><input
                            class="input" style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                    <div class="field"><label class="label" style="color: #6c757d;">Country</label><input class="input"
                            style="background: #f8f9fa; border: 1px solid #e9ecef; color: #333;" /></div>
                    <a class="btn btn-brand" href="#">Save</a>
                </form>
            </div>
            <div class="card"
                style="background: white; border: 1px solid #e9ecef; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <div class="card-title" style="margin-bottom:8px; color: #333;">Directors/Owners</div>
                <div class="help" style="color: #6c757d;">Upload ID and proof of address for each person.</div>
                <div style="display:flex; gap:8px; margin-top:10px;">
                    <a class="btn btn-ghost" href="#">Add person</a>
                    <a class="btn btn-brand" href="#">Submit</a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
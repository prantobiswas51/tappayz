<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tappayz – Fast, Secure Payments</title>
    <meta name="description"
        content="Tappayz is the fastest way to send and receive money globally with secure transactions and low fees." />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="site">
        <div class="container" style="display:flex; align-items:center; justify-content:space-between; padding:16px 0;">
            <a href="/" class="brand" style="text-decoration:none; color:inherit;">
                <div class="brand-badge"></div>
                <div>Tappayz</div>
            </a>
            <nav style="display:flex; gap:14px; align-items:center;">
                <a href="#features" class="help">Features</a>
                <a href="{{ route('pricing') }}" class="help">Pricing</a>
                <a href="{{ route('faq') }}" class="help">FAQ</a>
                <a href="{{ route('contact') }}" class="help">Contact</a>
                @auth
                <a class="btn btn-brand" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                <a class="btn btn-ghost" href="{{ route('login') }}">Sign in</a>
                <a class="btn btn-brand" href="{{ route('register') }}">Get started</a>
                @endauth
            </nav>
        </div>
    </header>


    <section class="container" style="padding:40px 0;">
        <h1 style="margin:0 0 8px;">Frequently asked questions</h1>
        <div class="grid grid-2" style="margin-top:16px;">
            <div class="card">
                <div class="card-title">How fast can I issue a card?</div>
                <div class="help">Instantly after account setup and KYC review.</div>
            </div>
            <div class="card">
                <div class="card-title">Do you support global merchants?</div>
                <div class="help">Yes, cards work online wherever Visa/Mastercard is accepted.</div>
            </div>
            <div class="card">
                <div class="card-title">What are the fees?</div>
                <div class="help">Starter is free; Growth is $29/mo; usage fees may apply.</div>
            </div>
            <div class="card">
                <div class="card-title">Can I set spending limits?</div>
                <div class="help">Yes, per-card monthly limits and instant freeze/terminate.</div>
            </div>
        </div>
    </section>

</body>

</html>
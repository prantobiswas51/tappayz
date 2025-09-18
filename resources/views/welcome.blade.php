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
    <section class="banner sky">
        <div class="container banner-inner">
            <div>
                <div class="badge text-white">New</div>
                <h2 class="heading text-white">Launch cards in minutes, not weeks</h2>
                <div class="sub text-white">No paperwork marathon. Create virtual cards instantly and
                    control spend in real time.</div>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a class="btn btn-brand" href="{{ route('register') }}">Start free</a>
                    <a class="btn btn-ghost" href="{{ route('login') }}">Sign in</a>
                </div>
                <div style="margin-top:24px; padding-top:20px; border-top:1px solid #e9ecef;">
                    <h1 class="text-white" style="margin:0 0 6px; font-size:32px; line-height:1.1;">Issue virtual cards
                        with
                        control and clarity</h1>
                    <p class="help" style="max-width:600px; margin:0 0 18px; color: #6c757d;">Empower your team to spend
                        securely. Real-time limits, instant cards, and detailed reporting — all in one elegant
                        dashboard.</p>
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        <a class="btn btn-brand" href="{{ route('dashboard') }}">Create free account</a>
                        <a class="btn btn-ghost" href="#features"
                            style="background: #f8f9fa; color: #333; border: 1px solid #e9ecef;">Explore features</a>
                    </div>
                </div>
            </div>
            <div class="right" style="display:grid; gap:14px; justify-items:end;">
                <div class="world-scene">
                    <svg class="world-map" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <defs>
                            <linearGradient id="sea" x1="0" x2="1">
                                <stop offset="0" stop-color="#0a1b34" />
                                <stop offset="1" stop-color="#0e2547" />
                            </linearGradient>
                            <linearGradient id="land" x1="0" x2="1">
                                <stop offset="0" stop-color="#1b365f" />
                                <stop offset="1" stop-color="#24477a" />
                            </linearGradient>
                        </defs>
                        <rect width="600" height="400" fill="url(#sea)" rx="16" />
                        <g fill="url(#land)" opacity=".9">
                            <path d="M60 150l40-20 30 10 30-12 25 10 10 20-20 10-30 5-35-10-25-13z" />
                            <path d="M210 120l34-10 40 15 30 2 22 14-18 18-28 8-38-6-22-12z" />
                            <path d="M400 130l30-6 24 8 28 18-12 20-24 10-26-6-22-18z" />
                            <path d="M120 230l24-6 20 8 16 14-10 16-22 8-20-6-12-14z" />
                        </g>
                    </svg>
                    <div class="vcard blue animate card-on-map">
                        <div class="brandmark"></div>
                        <div class="number">5244 ••42 ••65 ••88</div>
                        <div class="meta">
                            <div>Marketing</div>
                            <div>12/29</div>
                        </div>
                    </div>
                    <span class="pin us"></span>
                    <span class="pin eu"></span>
                    <span class="pin asia"></span>
                    <span class="pin sa"></span>
                    <span class="pulse small" style="left:88px; top:88px;"></span>
                    <span class="pulse medium" style="left:216px; top:70px;"></span>
                    <span class="pulse large" style="right:68px; top:96px;"></span>
                    <span class="line us-eu"></span>
                    <span class="line eu-asia"></span>
                    <span class="line us-sa"></span>
                </div>
            </div>
        </div>
    </section>

    <section class="brands">
        <div class="container brands-inner">
            <div class="brands-track">
                <span class="brand-chip"><span class="brand-dot"></span> PayPal</span>
                <span class="brand-chip"><span class="brand-dot"></span> AliExpress</span>
                <span class="brand-chip"><span class="brand-dot"></span> Alibaba</span>
                <span class="brand-chip"><span class="brand-dot"></span> eBay</span>
                <span class="brand-chip"><span class="brand-dot"></span> Amazon</span>
                <span class="brand-chip"><span class="brand-dot"></span> Google Ads</span>
                <span class="brand-chip"><span class="brand-dot"></span> Meta Ads</span>
                <span class="brand-chip"><span class="brand-dot"></span> Netflix</span>
                <span class="brand-chip"><span class="brand-dot"></span> Spotify</span>
                <span class="brand-chip"><span class="brand-dot"></span> Azure</span>
                <span class="brand-chip"><span class="brand-dot"></span> AWS</span>
                <span class="brand-chip"><span class="brand-dot"></span> DigitalOcean</span>
                <span class="brand-chip"><span class="brand-dot"></span> Payoneer</span>
                <span class="brand-chip"><span class="brand-dot"></span> Wise</span>
                <!-- duplicate for seamless loop -->
                <span class="brand-chip"><span class="brand-dot"></span> PayPal</span>
                <span class="brand-chip"><span class="brand-dot"></span> AliExpress</span>
                <span class="brand-chip"><span class="brand-dot"></span> Alibaba</span>
                <span class="brand-chip"><span class="brand-dot"></span> eBay</span>
                <span class="brand-chip"><span class="brand-dot"></span> Amazon</span>
                <span class="brand-chip"><span class="brand-dot"></span> Google Ads</span>
                <span class="brand-chip"><span class="brand-dot"></span> Meta Ads</span>
                <span class="brand-chip"><span class="brand-dot"></span> Netflix</span>
                <span class="brand-chip"><span class="brand-dot"></span> Spotify</span>
                <span class="brand-chip"><span class="brand-dot"></span> Azure</span>
                <span class="brand-chip"><span class="brand-dot"></span> AWS</span>
                <span class="brand-chip"><span class="brand-dot"></span> DigitalOcean</span>
                <span class="brand-chip"><span class="brand-dot"></span> Payoneer</span>
                <span class="brand-chip"><span class="brand-dot"></span> Wise</span>
            </div>
        </div>
    </section>

    <section class="section-alt">
        <div class="container" style="padding:24px 0 28px;">
            <div class="panel-curved">
                <div class="grid grid-2">
                    <div class="feature-rows">
                        <div class="feature-row">
                            <div class="icon"></div>
                            <div class="content">
                                <div class="title">Controls your finance team will love</div>
                                <div class="desc">Set per-card limits, freeze instantly, and label spend by team or
                                    project.</div>
                            </div>
                        </div>
                        <div class="feature-row">
                            <div class="icon" style="background:linear-gradient(135deg, var(--accent), var(--brand));">
                            </div>
                            <div class="content">
                                <div class="title">Faster onboarding</div>
                                <div class="desc">Create your first card right after signup. No long waits.</div>
                            </div>
                        </div>
                        <div class="feature-row">
                            <div class="icon"
                                style="background:linear-gradient(135deg, var(--success), var(--brand-strong));"></div>
                            <div class="content">
                                <div class="title">Real-time insights</div>
                                <div class="desc">Track every transaction and keep teams on budget.</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="stats-strip">
                            <div class="stat">
                                <div class="num">$12.4k</div>
                                <div class="lbl">Balance</div>
                            </div>
                            <div class="stat">
                                <div class="num">8</div>
                                <div class="lbl">Active cards</div>
                            </div>
                            <div class="stat">
                                <div class="num">$4.9k</div>
                                <div class="lbl">30d spend</div>
                            </div>
                            <div class="stat">
                                <div class="num">3</div>
                                <div class="lbl">Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="features" class="container" style="padding:30px 0 10px;">
        <div class="grid grid-3">
            <div class="widget">
                <div class="kpi">
                    <div class="label">Instant issuance</div>
                    <div class="value">Create in seconds</div>
                </div>
                <div class="help" style="margin-top:8px;">Spin up virtual cards with custom limits and labels.</div>
            </div>
            <div class="widget">
                <div class="kpi">
                    <div class="label">Powerful controls</div>
                    <div class="value">Per-card limits</div>
                </div>
                <div class="help" style="margin-top:8px;">Freeze, terminate, and set spend policies with ease.</div>
            </div>
            <div class="widget">
                <div class="kpi">
                    <div class="label">Detailed insights</div>
                    <div class="value">Real-time data</div>
                </div>
                <div class="help" style="margin-top:8px;">Track transactions and budgets in a modern UI.</div>
            </div>
        </div>
    </section>

    <section class="container" style="padding:10px 0 10px;">
        <div class="grid grid-3">
            <div class="card">
                <div class="card-title">Use cases</div>
                <ul class="help" style="margin:8px 0 0; padding-left:18px;">
                    <li>Ad accounts and media buying</li>
                    <li>Subscriptions and SaaS trials</li>
                    <li>Team budgets and one-off purchases</li>
                </ul>
            </div>
            <div class="card">
                <div class="card-title">How it works</div>
                <ol class="help" style="margin:8px 0 0; padding-left:18px;">
                    <li>Create account and verify KYC</li>
                    <li>Fund your balance</li>
                    <li>Issue cards with limits and labels</li>
                </ol>
            </div>
            <div class="card">
                <div class="card-title">Security & compliance</div>
                <ul class="help" style="margin:8px 0 0; padding-left:18px;">
                    <li>Card tokenization</li>
                    <li>Spend controls and monitoring</li>
                    <li>Data encryption in transit and at rest</li>
                </ul>
            </div>
        </div>
    </section>




    <section class="container" style="padding:10px 0 40px;">
        <div class="card">
            <div class="card-title" style="margin-bottom:6px;">FAQ</div>
            <div class="grid grid-2">
                <div>
                    <div class="help"><strong>How do I fund my account?</strong> Bank transfer, crypto USDT, or card
                        top-up.</div>
                    <div class="help" style="margin-top:8px;"><strong>Can I cancel a card?</strong> Yes, freeze or
                        terminate instantly.</div>
                </div>
                <div>
                    <div class="help"><strong>Is there an API?</strong> Yes, integrate issuance and controls with your
                        stack.</div>
                    <div class="help" style="margin-top:8px;"><strong>Do you support multi-currency?</strong> Yes,
                        USD/EUR/GBP today.</div>
                </div>
            </div>
            <a class="btn btn-ghost" style="margin-top:12px;" href="pages/faq.html">See all FAQs</a>
        </div>
    </section>

    <section class="container" style="padding:20px 0 60px;">
        <div class="card"
            style="display:flex; gap:16px; align-items:center; justify-content:space-between; flex-wrap:wrap;">
            <div>
                <div class="card-title">Ready to get started?</div>
                <div class="card-subtitle">Sign up in minutes and issue your first card today.</div>
            </div>
            <div style="display:flex; gap:10px;">
                <a class="btn btn-brand" href="pages/register.html">Create account</a>
                <a class="btn btn-ghost" href="{{ route('login') }}">Sign in</a>
            </div>
        </div>
    </section>

    <footer style="background:#0b1124; border-top:1px solid var(--border); margin-top:40px;">
        <div class="container" style="padding:40px 0 30px;">
            <div class="grid grid-4" style="margin-bottom:30px;">
                <div>
                    <div class="brand" style="gap:8px; margin-bottom:12px;">
                        <div class="brand-badge" style="width:28px;height:28px;"></div>
                        <div>Tappayz</div>
                    </div>
                    <div class="help" style="margin-bottom:8px;">123 Business Street, Suite 100<br />New York, NY 10001,
                        USA</div>
                    <div class="help">support@tappayz.com<br />+1 (555) 123-4567</div>
                </div>
                <div>
                    <div class="card-title" style="margin-bottom:12px;">Product</div>
                    <div style="display:grid; gap:8px;">
                        <a href="pages/pricing.html" class="help" style="text-decoration:none;">Pricing</a>
                        <a href="#features" class="help" style="text-decoration:none;">Features</a>
                        <a href="pages/faq.html" class="help" style="text-decoration:none;">FAQ</a>
                        <a href="pages/support.html" class="help" style="text-decoration:none;">Support</a>
                    </div>
                </div>
                <div>
                    <div class="card-title" style="margin-bottom:12px;">Company</div>
                    <div style="display:grid; gap:8px;">
                        <a href="pages/about.html" class="help" style="text-decoration:none;">About</a>
                        <a href="pages/contact.html" class="help" style="text-decoration:none;">Contact</a>
                        <a href="pages/privacy.html" class="help" style="text-decoration:none;">Privacy Policy</a>
                        <a href="pages/terms.html" class="help" style="text-decoration:none;">Terms of Service</a>
                    </div>
                </div>
                <div>
                    <div class="card-title" style="margin-bottom:12px;">Payment Methods</div>
                    <div style="display:grid; gap:8px;">
                        <div class="help">We accept:</div>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <span class="status success">Bitcoin</span>
                            <span class="status success">USDT</span>
                            <span class="status success">Ethereum</span>
                            <span class="status success">Bank Transfer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div
                style="border-top:1px solid var(--border); padding-top:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
                <div class="help">© 2025 Tappayz. All rights reserved.</div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <div class="help">Trusted by 10,000+ businesses</div>
                    <div style="display:flex; align-items:center; gap:4px;">
                        <span style="color:#ffd700;">★★★★★</span>
                        <span class="help">4.9/5 on Trustpilot</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="assets/js/main.js"></script>
</body>

</html>
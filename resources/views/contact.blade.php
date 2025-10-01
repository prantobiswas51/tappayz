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


    <!-- Hero Section -->
    <section class="py-20 bg-gradient-to-br from-blue-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-5xl lg:text-6xl font-bold text-black mb-6">
                Get in
                <span class="bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                    Touch
                </span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                We're here to help! Reach out to our support team for any questions, concerns, or assistance with your
                Tappayz account.
            </p>
        </div>
    </section>

    <!-- Contact Methods -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Email Support -->
                <div class="text-center p-8 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-primary-blue rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-black mb-4">Email Support</h3>
                    <p class="text-gray-600 mb-4">Get help via email within 24 hours</p>
                    <a href="mailto:support@tappayz.com" class="text-primary-blue font-semibold hover:underline">
                        support@tappayz.com
                    </a>
                </div>

                <!-- Live Chat -->
                <div class="text-center p-8 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-primary-green rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-black mb-4">Live Chat</h3>
                    <p class="text-gray-600 mb-4">Chat with our support team instantly</p>
                    <button
                        class="bg-primary-green text-gray-400 px-6 py-3 rounded-lg font-medium hover:bg-green-600 transition-colors">
                        Start Chat
                    </button>
                </div>

                <!-- Phone Support -->
                <div class="text-center p-8 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                    <div class="w-16 h-16 bg-primary-orange rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-black mb-4">Phone Support</h3>
                    <p class="text-gray-600 mb-4">Call us for immediate assistance</p>
                    <a href="tel:+1234567890" class="text-primary-orange font-semibold hover:underline">
                        +1 (234) 567-890
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form and Info -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-black mb-6">Send us a Message</h2>
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">First
                                    Name</label>
                                <input type="text" id="firstName" name="firstName"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                                    placeholder="John">
                            </div>
                            <div>
                                <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">Last
                                    Name</label>
                                <input type="text" id="lastName" name="lastName"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                                    placeholder="Doe">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                Address</label>
                            <input type="email" id="email" name="email"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                                placeholder="john@example.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                                placeholder="+1 (234) 567-890">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select id="subject" name="subject"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent">
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="feature">Feature Request</option>
                                <option value="partnership">Partnership</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea id="message" name="message" rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-blue focus:border-transparent"
                                placeholder="Tell us how we can help you..."></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-primary-blue text-gray-400 py-4 rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Office Address -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary-blue rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-black mb-2">Office Address</h3>
                                <p class="text-gray-600">
                                    123 Financial District<br>
                                    New York, NY 10004<br>
                                    United States
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary-green rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-black mb-2">Business Hours</h3>
                                <div class="text-gray-600 space-y-1">
                                    <p>Monday - Friday: 9:00 AM - 6:00 PM EST</p>
                                    <p>Saturday: 10:00 AM - 4:00 PM EST</p>
                                    <p>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Response Time -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-primary-orange rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-black mb-2">Response Time</h3>
                                <div class="text-gray-600 space-y-1">
                                    <p>Email: Within 24 hours</p>
                                    <p>Live Chat: Immediate</p>
                                    <p>Phone: Immediate during business hours</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-gray-50 rounded-2xl p-8">
                        <h3 class="text-xl font-bold text-black mb-4">Follow Us</h3>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-10 h-10 bg-primary-blue rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-primary-blue rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-primary-blue rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 bg-primary-blue rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24c6.624 0 11.99-5.367 11.99-11.987C24.007 5.367 18.641.001 12.017.001z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-black mb-4">Frequently Asked Questions</h2>
                <p class="text-xl text-gray-600">Quick answers to common questions</p>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-black mb-4">How do I create a virtual card?</h3>
                    <p class="text-gray-600">
                        Creating a virtual card is simple! Sign up for a Tappayz account, choose your plan, and click
                        "Create Card" in your dashboard. Your virtual card will be ready in under 30 seconds.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-black mb-4">What currencies are supported?</h3>
                    <p class="text-gray-600">
                        We support multiple currencies including USD, EUR, GBP, and many more. Check our pricing page
                        for the complete list of supported currencies in your region.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-black mb-4">Is my money safe with Tappayz?</h3>
                    <p class="text-gray-600">
                        Absolutely! We use bank-level security and encryption to protect your funds. All transactions
                        are processed through secure, PCI-compliant systems, and your money is held in segregated
                        accounts.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-black mb-4">Can I use my virtual card internationally?</h3>
                    <p class="text-gray-600">
                        Yes! Tappayz virtual cards work worldwide wherever Mastercard and Visa are accepted. Perfect for
                        international online purchases, subscriptions, and transactions.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <h3 class="text-xl font-bold text-black mb-4">How do I fund my virtual card?</h3>
                    <p class="text-gray-600">
                        You can fund your virtual cards through bank transfers, credit/debit cards, or cryptocurrency.
                        Funding is instant and secure, with real-time balance updates.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary-blue to-primary-purple">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-400 mb-6">Still Have Questions?</h2>
            <p class="text-xl text-blue-500 mb-8">
                Our support team is here to help you 24/7. Don't hesitate to reach out!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button
                    class="bg-white text-primary-blue px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Start Live Chat
                </button>
                <button
                    class="border-2 border-white text-gray-400 px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary-blue transition-colors">
                    Call Us Now
                </button>
            </div>
        </div>
    </section>

</body>

</html>
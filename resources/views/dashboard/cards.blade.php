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
            <div class="toolbar ">
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

        <div class="my-3">
            <form action="{{ route('get_all_cards') }}" method="get">
                @csrf
                <button type="submit" class="btn btn-ghost">Get All Cards</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center space-x-6">
                <!-- Card Icon -->
                <div
                    class="w-16 h-12 bg-gradient-to-r from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                    <div class="w-8 h-6 bg-white rounded-sm flex items-center justify-center">
                        <div
                            class="w-6 h-4 bg-gradient-to-r from-blue-400 to-blue-600 rounded-sm relative overflow-hidden">
                            <div class="absolute top-1 left-1 w-1 h-1 bg-white rounded-full"></div>
                            <div class="absolute top-1 right-1 w-1 h-1 bg-white rounded-full"></div>
                            <div class="absolute bottom-1 left-1 w-1 h-1 bg-white rounded-full"></div>
                            <div class="absolute bottom-1 right-1 w-1 h-1 bg-white rounded-full"></div>
                        </div>
                    </div>
                </div>

                <!-- Card Details -->
                <div class="flex-1 grid grid-cols-2 md:grid-cols-6 gap-6">
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Type:</div>
                        <div class="text-sm font-medium text-gray-800">Visa</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Card Number:</div>
                        <div class="text-sm font-medium text-gray-800 font-mono">4576 62** **** ****</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Expire:</div>
                        <div class="text-sm font-medium text-gray-800">12/27</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">CVV:</div>
                        <div class="text-sm font-medium text-gray-800">455</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Name in Card:</div>
                        <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 mb-1">Balance:</div>
                        <div class="text-sm font-medium text-gray-800 ">
                            <form action="{{ route('get_card_balance') }}" method="get">
                                <p class="h3 p-2 border rounded-3xl max-w-max" id="balance_holder">
                                    Tap to check
                                </p>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-4">
                    <button id="seeNumberBtn"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                        See Number
                    </button>
                    <button id="topUpBtn"
                        class="text-blue-600 hover:text-blue-800 text-sm font-bold uppercase transition-colors">
                        TOP UP
                    </button>
                    <div class="relative">
                        <button id="menuBtn" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50">
                            <div class="py-2">
                                <button id="freezeBtn"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                                    <i class="fas fa-snowflake text-blue-500"></i>
                                    <span>Freeze Card</span>
                                </button>
                                <button id="terminateBtn"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center space-x-2">
                                    <i class="fas fa-times-circle text-red-500"></i>
                                    <span>Terminate Card</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</x-app-layout>
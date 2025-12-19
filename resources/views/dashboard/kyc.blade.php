<x-app-layout>
    <main class="p-2 bg-white text-gray-800">
        <div class="topbar border-b border-gray-200 flex items-center justify-between">
            <div class="brand flex items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">KYC Verification</h1>
                    <p class="text-gray-500 text-sm">Complete your Know Your Customer verification</p>
                </div>
            </div>
        </div>

        <div
            class="mx-auto flex items-center w-fit p-2 rounded-lg btn btn-brand create-btn text-white text-3xl border">
            {{-- KYC Status Message --}}
            @if($status)
            <div class="text-gray-800 text-lg">KYC status: {{ $status }}</div>
            @else
            <div class="text-red-500">KYC status not found.</div>
            @endif
        </div>

        @if ($status != 'Approved')
        <div class="grid my-4">
            <!-- Left Form -->
            <div class="max-w-2xl border mx-auto bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-semibold text-sky-300 text-center uppercase mb-2">
                    Tell us about yourself
                </h2>
                <p class="text-gray-500 text-center mb-6">
                    Let's start with some basic information.<br>
                    You must be 18 years or older to be eligible.
                </p>

                <!-- Progressbar -->
                <ul id="progressbar" class="flex justify-between mb-6 text-gray-400 text-sm font-medium">
                    <li class="relative flex-1 text-center active text-sky-300" data-step="1">
                        <span
                            class="w-10 h-10 flex items-center justify-center mx-auto mb-2 rounded-full bg-sky-400 text-white"><i
                                class="fas fa-user"></i></span>
                        Personal
                    </li>
                    <li class="relative flex-1 text-center" data-step="2">
                        <span
                            class="w-10 h-10 flex items-center justify-center mx-auto mb-2 rounded-full bg-gray-300 text-white"><i
                                class="fas fa-map-marker-alt"></i></span>
                        Address
                    </li>
                    <li class="relative flex-1 text-center" data-step="3">
                        <span
                            class="w-10 h-10 flex items-center justify-center mx-auto mb-2 rounded-full bg-gray-300 text-white"><i
                                class="fas fa-phone"></i></span>
                        Contact
                    </li>
                    <li class="relative flex-1 text-center" data-step="4">
                        <span
                            class="w-10 h-10 flex items-center justify-center mx-auto mb-2 rounded-full bg-gray-300 text-white"><i
                                class="fas fa-passport"></i></span>
                        Passport
                    </li>
                    <li class="relative flex-1 text-center" data-step="5">
                        <span
                            class="w-10 h-10 flex items-center justify-center mx-auto mb-2 rounded-full bg-gray-300 text-white"><i
                                class="fas fa-check"></i></span>
                        Finish
                    </li>
                </ul>

                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-8">
                    <div id="progress" class="bg-sky-400 h-2.5 rounded-full transition-all duration-500"
                        style="width: 20%;"></div>
                </div>

                <!-- Form -->
                <form id="multiForm" class="space-y-6" method="POST" enctype="multipart/form-data"
                    action="{{ route('submit_kyc') }}">
                    @csrf
                    <!-- Step 1 -->
                    <fieldset class="step">
                        <h2 class="text-xl text-sky-300 mb-4">Personal Information</h2>
                        <div class="space-y-3">
                            <label>Legal First Name</label>
                            <input type="text" placeholder="Alex" name="first_name" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Legal Last Name</label>
                            <input type="text" placeholder="Doe" name="last_name" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Date of Birth</label>
                            <input type="date" name="date_of_birth" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button"
                                class="next px-6 py-2 bg-sky-400 text-white rounded hover:bg-sky-800">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 2 -->
                    <fieldset class="step hidden">
                        <h2 class="text-xl text-sky-300 mb-4">Address Information</h2>
                        <div class="space-y-3">
                            <label>Street Address</label>
                            <input type="text" placeholder="Street Address" name="street_address" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Apt/Unit (optional)</label>
                            <input type="text" placeholder="Apt/Unit" name="apt_unit"
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Zip Code</label>
                            <input type="number" placeholder="23002" name="zip_code" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="button"
                                class="prev px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Previous</button>
                            <button type="button"
                                class="next px-6 py-2 bg-sky-400 text-white rounded hover:bg-sky-800">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 3 -->
                    <fieldset class="step hidden">
                        <h2 class="text-xl text-sky-300 mb-4">Contact Information</h2>
                        <div class="space-y-3">
                            <label>Phone Number</label>
                            <input type="number" name="phone_number" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Email Address</label>
                            <input type="email" name="email_address" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="button"
                                class="prev px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Previous</button>
                            <button type="button"
                                class="next px-6 py-2 bg-sky-400 text-white rounded hover:bg-sky-800">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 4 -->
                    <fieldset class="step hidden">
                        <h2 class="text-xl text-sky-300 mb-4">Passport Info</h2>
                        <div class="space-y-3">
                            <label>Country</label>
                            <input type="text" name="country" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Passport Number</label>
                            <input type="text" name="passport_number" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">

                            <label>Passport File Upload</label>
                            <input type="file" name="passport_img" required
                                class="w-full p-3 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-sky-500">
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="button"
                                class="prev px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Previous</button>
                            <button type="button"
                                class="next px-6 py-2 bg-sky-400 text-white rounded hover:bg-sky-800">Next</button>
                        </div>
                    </fieldset>

                    <!-- Step 5 -->
                    <fieldset class="step hidden text-center">
                        <h2 class="text-2xl font-semibold text-sky-300 mb-4">All Done!</h2>
                        <p class="text-gray-600 mb-3">Click to submit the form</p>
                        <button type="submit"
                            class="px-6 py-2 bg-sky-400 text-white rounded hover:bg-sky-800">Submit</button>
                    </fieldset>
                </form>
            </div>
        </div>
        @endif
    </main>

    <script>
        const steps = document.querySelectorAll(".step");
    const nextBtns = document.querySelectorAll(".next");
    const prevBtns = document.querySelectorAll(".prev");
    const progress = document.getElementById("progress");
    const stepIndicators = document.querySelectorAll("#progressbar li");
    let current = 0;

    function updateSteps() {
        steps.forEach((step, index) => step.classList.toggle("hidden", index !== current));

        stepIndicators.forEach((li, index) => {
            li.classList.toggle("active", index <= current);
            const span = li.querySelector("span");
            span.classList.toggle("bg-sky-400", index <= current);
            span.classList.toggle("bg-gray-300", index > current);
        });

        const percent = ((current + 1) / steps.length) * 100;
        progress.style.width = percent + "%";
    }

    // ✅ Validation before going to next step
    function validateCurrentStep() {
        const currentStep = steps[current];
        const requiredInputs = currentStep.querySelectorAll("[required]");
        let valid = true;

        requiredInputs.forEach((input) => {
            if (!input.value.trim()) {
                input.classList.add("border-red-500", "focus:ring-red-500");
                valid = false;
            } else {
                input.classList.remove("border-red-500", "focus:ring-red-500");
            }
        });

        return valid;
    }

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (!validateCurrentStep()) {
                
                return;
            }
            if (current < steps.length - 1) current++;
            updateSteps();
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (current > 0) current--;
            updateSteps();
        });
    });

    updateSteps();
    </script>

</x-app-layout>
<x-layouts::auth :title="__('Register')">

    <div class="w-full text-slate-900">

        <div class="mb-7 text-center">

            <img
                src="{{ asset(
                    'images/hot-wheels-market-tracker-logo.png'
                ) }}"
                alt="Hot Wheels Market Tracker"
                class="mx-auto h-24 w-auto object-contain"
            >

            <h1
                class="
                    mt-5
                    text-3xl
                    font-black
                    tracking-tight
                    text-slate-900
                "
            >
                Create Collector Account
            </h1>

            <p
                class="
                    mx-auto
                    mt-2
                    max-w-md
                    text-sm
                    leading-6
                    text-slate-600
                "
            >
                Join the Hot Wheels Market Tracker to save
                favorites and submit market prices.
            </p>

        </div>


        <x-auth-session-status
            class="mb-5 text-center"
            :status="session('status')"
        />


        <form
            method="POST"
            action="{{ route('register.store') }}"
            class="space-y-5"
        >

            @csrf


            {{-- Username --}}

            <div>

                <label
                    for="username"
                    class="
                        mb-2
                        block
                        text-sm
                        font-bold
                        text-slate-700
                    "
                >
                    Username
                </label>

                <input
                    id="username"
                    name="username"
                    type="text"
                    value="{{ old('username') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Choose a username"
                    class="
                        w-full
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-4
                        py-3
                        text-slate-900
                        outline-none
                        transition
                        placeholder:text-slate-400
                        focus:border-[#1268d1]
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >

                @error('username')

                    <p
                        class="
                            mt-1.5
                            text-sm
                            font-semibold
                            text-red-600
                        "
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Email --}}

            <div>

                <label
                    for="email"
                    class="
                        mb-2
                        block
                        text-sm
                        font-bold
                        text-slate-700
                    "
                >
                    Email Address
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="
                        w-full
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-4
                        py-3
                        text-slate-900
                        outline-none
                        transition
                        placeholder:text-slate-400
                        focus:border-[#1268d1]
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >

                @error('email')

                    <p
                        class="
                            mt-1.5
                            text-sm
                            font-semibold
                            text-red-600
                        "
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Password --}}

            <div>

                <label
                    for="password"
                    class="
                        mb-2
                        block
                        text-sm
                        font-bold
                        text-slate-700
                    "
                >
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Minimum 8 characters"
                    class="
                        w-full
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-4
                        py-3
                        text-slate-900
                        outline-none
                        transition
                        placeholder:text-slate-400
                        focus:border-[#1268d1]
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >

                @error('password')

                    <p
                        class="
                            mt-1.5
                            text-sm
                            font-semibold
                            text-red-600
                        "
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- Confirm password --}}

            <div>

                <label
                    for="password_confirmation"
                    class="
                        mb-2
                        block
                        text-sm
                        font-bold
                        text-slate-700
                    "
                >
                    Confirm Password
                </label>

                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Enter password again"
                    class="
                        w-full
                        rounded-lg
                        border
                        border-slate-300
                        bg-white
                        px-4
                        py-3
                        text-slate-900
                        outline-none
                        transition
                        placeholder:text-slate-400
                        focus:border-[#1268d1]
                        focus:ring-2
                        focus:ring-blue-100
                    "
                >

            </div>


            <div
                class="
                    rounded-lg
                    border
                    border-blue-100
                    bg-blue-50
                    p-4
                "
            >

                <p
                    class="
                        text-sm
                        leading-6
                        text-slate-600
                    "
                >
                    New accounts are automatically created as
                    <strong class="text-slate-900">
                        Collector
                    </strong>
                    accounts.
                </p>

            </div>


            <button
                type="submit"
                data-test="register-user-button"
                class="
                    w-full
                    rounded-lg
                    bg-yellow-400
                    px-5
                    py-3.5
                    text-base
                    font-black
                    text-slate-900
                    shadow-sm
                    transition
                    hover:bg-yellow-300
                "
            >
                Create Account
            </button>

        </form>


        <div
            class="
                mt-7
                border-t
                border-slate-200
                pt-6
                text-center
            "
        >

            <p class="text-sm text-slate-600">
                Already have an account?

                <a
                    href="{{ route('login') }}"
                    class="
                        ml-1
                        font-black
                        text-[#1268d1]
                        hover:underline
                    "
                >
                    Log In
                </a>
            </p>

        </div>

    </div>

</x-layouts::auth>
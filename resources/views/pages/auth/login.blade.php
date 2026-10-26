<x-layouts::auth :title="__('Log in')">

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
                Welcome Back
            </h1>

            <p class="mt-2 text-sm text-slate-600">
                Log in to manage your Hot Wheels collection
                and track market prices.
            </p>

        </div>


        <x-auth-session-status
            class="mb-5 text-center"
            :status="session('status')"
        />


        <x-passkey-verify />


        <form
            method="POST"
            action="{{ route('login.store') }}"
            class="mt-6 space-y-5"
        >

            @csrf


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
                    autofocus
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

                <div
                    class="
                        mb-2
                        flex
                        items-center
                        justify-between
                    "
                >

                    <label
                        for="password"
                        class="
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Password
                    </label>


                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="
                                text-sm
                                font-bold
                                text-[#1268d1]
                                hover:underline
                            "
                        >
                            Forgot password?
                        </a>

                    @endif

                </div>


                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
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


            {{-- Remember me --}}

            <label
                class="
                    flex
                    cursor-pointer
                    items-center
                    gap-3
                    text-sm
                    font-semibold
                    text-slate-600
                "
            >

                <input
                    name="remember"
                    type="checkbox"
                    value="1"
                    @checked(old('remember'))
                    class="
                        h-4
                        w-4
                        rounded
                        border-slate-300
                        text-[#1268d1]
                        focus:ring-[#1268d1]
                    "
                >

                Remember me

            </label>


            <button
                type="submit"
                data-test="login-button"
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
                Log In
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
                Don't have an account?

                <a
                    href="{{ route('register') }}"
                    class="
                        ml-1
                        font-black
                        text-[#1268d1]
                        hover:underline
                    "
                >
                    Create Account
                </a>
            </p>

        </div>

    </div>

</x-layouts::auth>
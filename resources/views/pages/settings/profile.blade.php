<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Profile settings')] class extends Component {
    use ProfileValidationRules;

    public string $username = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->username = Auth::user()->username ?? '';
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        // Keep Laravel's existing name field synchronized with the username.
        $validated['name'] = $validated['username'];

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        Flux::toast(variant: 'success', text: __('Profile updated.'));
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! Auth::user() instanceof MustVerifyEmail
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }
}; ?>

<section class="w-full text-slate-900">

    @php
        $user = auth()->user();

        $favoriteCars = $user->favorites;

        $submissionCount = $user
            ->priceSubmissions()
            ->count();

        $roleLabel = $user->isAdministrator()
            ? 'Administrator'
            : 'Collector';
    @endphp


    {{-- =====================================================
         PROFILE HEADER
    ====================================================== --}}

    <div
        class="
            mb-8
            overflow-hidden
            rounded-2xl
            bg-gradient-to-r
            from-[#0b57a8]
            to-[#1976d2]
            p-6
            text-white
            shadow-md
            sm:p-8
        "
    >

        <div
            class="
                flex
                flex-col
                gap-6
                md:flex-row
                md:items-center
                md:justify-between
            "
        >

            <div
                class="
                    flex
                    items-center
                    gap-5
                "
            >

                {{-- Avatar --}}

                <div
                    class="
                        flex
                        h-20
                        w-20
                        shrink-0
                        items-center
                        justify-center
                        rounded-full
                        border-4
                        border-white/30
                        bg-white
                        text-2xl
                        font-black
                        text-[#1268d1]
                        shadow
                    "
                >
                    {{ $user->initials() }}
                </div>


                <div>

                    <p
                        class="
                            text-sm
                            font-bold
                            uppercase
                            tracking-[0.12em]
                            text-yellow-300
                        "
                    >
                        {{ $roleLabel }}
                    </p>

                    <h1
                        class="
                            mt-1
                            text-3xl
                            font-black
                            tracking-tight
                            text-white
                        "
                    >
                        {{ $user->username ?? $user->name }}
                    </h1>

                    <p
                        class="
                            mt-1
                            text-blue-100
                        "
                    >
                        {{ $user->email }}
                    </p>

                </div>

            </div>


            <a
                href="{{ route('cars.index') }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-lg
                    bg-yellow-400
                    px-5
                    py-3
                    font-black
                    text-slate-900
                    shadow-sm
                    transition
                    hover:bg-yellow-300
                "
            >
                Browse Hot Wheels
            </a>

        </div>

    </div>


    {{-- =====================================================
         PROFILE STATS
    ====================================================== --}}

    <div
        class="
            mb-8
            grid
            gap-5
            sm:grid-cols-3
        "
    >

        {{-- Favorites --}}

        <div
            class="
                rounded-xl
                border
                border-slate-200
                bg-white
                p-5
                shadow-sm
            "
        >

            <p
                class="
                    text-sm
                    font-bold
                    text-slate-500
                "
            >
                Saved Favorites
            </p>

            <div
                class="
                    mt-3
                    flex
                    items-end
                    justify-between
                "
            >

                <p
                    class="
                        text-4xl
                        font-black
                        text-yellow-500
                    "
                >
                    {{ $favoriteCars->count() }}
                </p>

                <span
                    class="
                        text-3xl
                        text-yellow-400
                    "
                >
                    ★
                </span>

            </div>

        </div>


        {{-- Submissions --}}

        <div
            class="
                rounded-xl
                border
                border-slate-200
                bg-white
                p-5
                shadow-sm
            "
        >

            <p
                class="
                    text-sm
                    font-bold
                    text-slate-500
                "
            >
                Price Submissions
            </p>

            <div
                class="
                    mt-3
                    flex
                    items-end
                    justify-between
                "
            >

                <p
                    class="
                        text-4xl
                        font-black
                        text-[#1268d1]
                    "
                >
                    {{ $submissionCount }}
                </p>

                <span
                    class="
                        text-3xl
                        font-black
                        text-blue-300
                    "
                >
                    $
                </span>

            </div>

        </div>


        {{-- Role --}}

        <div
            class="
                rounded-xl
                border
                border-slate-200
                bg-white
                p-5
                shadow-sm
            "
        >

            <p
                class="
                    text-sm
                    font-bold
                    text-slate-500
                "
            >
                Account Type
            </p>

            <p
                class="
                    mt-4
                    text-2xl
                    font-black
                    text-red-600
                "
            >
                {{ $roleLabel }}
            </p>

        </div>

    </div>


    {{-- =====================================================
         PROFILE SETTINGS + ACCOUNT NAVIGATION
    ====================================================== --}}

    <div
        class="
            grid
            gap-6
            lg:grid-cols-[1fr_300px]
        "
    >

        {{-- Profile information --}}

        <div
            class="
                rounded-xl
                border
                border-slate-200
                bg-white
                p-6
                shadow-sm
                sm:p-8
            "
        >

            <div
                class="
                    border-b
                    border-slate-200
                    pb-5
                "
            >

                <p
                    class="
                        text-sm
                        font-bold
                        uppercase
                        tracking-[0.12em]
                        text-[#1268d1]
                    "
                >
                    Account Information
                </p>

                <h2
                    class="
                        mt-1
                        text-2xl
                        font-black
                        text-slate-900
                    "
                >
                    Edit Profile
                </h2>

                <p
                    class="
                        mt-1
                        text-sm
                        text-slate-600
                    "
                >
                    Update your username and email address.
                </p>

            </div>


            <form
                wire:submit="updateProfileInformation"
                class="
                    mt-6
                    space-y-6
                "
            >

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
                        wire:model="username"
                        type="text"
                        required
                        autofocus
                        autocomplete="username"
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
                        wire:model="email"
                        type="email"
                        required
                        autocomplete="email"
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


                    @if ($this->hasUnverifiedEmail)

                        <div
                            class="
                                mt-3
                                rounded-lg
                                border
                                border-yellow-200
                                bg-yellow-50
                                p-4
                            "
                        >

                            <p
                                class="
                                    text-sm
                                    font-semibold
                                    text-yellow-800
                                "
                            >
                                Your email address is not verified.
                            </p>

                            <button
                                type="button"
                                wire:click.prevent="
                                    resendVerificationNotification
                                "
                                class="
                                    mt-2
                                    text-sm
                                    font-bold
                                    text-[#1268d1]
                                    hover:underline
                                "
                            >
                                Send verification email again
                            </button>

                            @if (
                                session('status')
                                === 'verification-link-sent'
                            )

                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        font-semibold
                                        text-green-700
                                    "
                                >
                                    A new verification link
                                    has been sent.
                                </p>

                            @endif

                        </div>

                    @endif

                </div>


                {{-- Save --}}

                <div
                    class="
                        flex
                        justify-end
                        border-t
                        border-slate-200
                        pt-5
                    "
                >

                    <button
                        type="submit"
                        data-test="update-profile-button"
                        class="
                            rounded-lg
                            bg-yellow-400
                            px-7
                            py-3
                            font-black
                            text-slate-900
                            shadow-sm
                            transition
                            hover:bg-yellow-300
                        "
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>


        {{-- Settings navigation --}}

        <aside
            class="
                h-fit
                rounded-xl
                border
                border-slate-200
                bg-white
                p-5
                shadow-sm
            "
        >

            <p
                class="
                    text-xs
                    font-black
                    uppercase
                    tracking-[0.13em]
                    text-slate-400
                "
            >
                Account Settings
            </p>


            <nav class="mt-4 space-y-2">

                <a
                    href="{{ route('profile.edit') }}"
                    class="
                        block
                        rounded-lg
                        bg-blue-50
                        px-4
                        py-3
                        font-bold
                        text-[#1268d1]
                    "
                >
                    Profile
                </a>


                <a
                    href="{{ route('security.edit') }}"
                    class="
                        block
                        rounded-lg
                        px-4
                        py-3
                        font-bold
                        text-slate-700
                        transition
                        hover:bg-slate-50
                    "
                >
                    Security
                </a>


                <a
                    href="{{ route('appearance.edit') }}"
                    class="
                        block
                        rounded-lg
                        px-4
                        py-3
                        font-bold
                        text-slate-700
                        transition
                        hover:bg-slate-50
                    "
                >
                    Appearance
                </a>

            </nav>

        </aside>

    </div>


    {{-- =====================================================
         FAVORITES
    ====================================================== --}}

    <section
        id="favorites"
        class="mt-10"
    >

        <div
            class="
                mb-5
                flex
                flex-wrap
                items-end
                justify-between
                gap-4
            "
        >

            <div>

                <p
                    class="
                        text-sm
                        font-bold
                        uppercase
                        tracking-[0.12em]
                        text-[#1268d1]
                    "
                >
                    My Collection
                </p>

                <h2
                    class="
                        mt-1
                        text-2xl
                        font-black
                        text-slate-900
                    "
                >
                    Saved Favorites
                </h2>

                <p
                    class="
                        mt-1
                        text-slate-600
                    "
                >
                    Hot Wheels cars you have saved
                    to your collection.
                </p>

            </div>


            <a
                href="{{ route('cars.index') }}"
                class="
                    font-bold
                    text-[#1268d1]
                    hover:underline
                "
            >
                Find More Cars
            </a>

        </div>


        @if ($favoriteCars->isEmpty())

            <div
                class="
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    px-6
                    py-14
                    text-center
                    shadow-sm
                "
            >

                <div
                    class="
                        mx-auto
                        flex
                        h-16
                        w-16
                        items-center
                        justify-center
                        rounded-full
                        bg-yellow-50
                        text-3xl
                        text-yellow-400
                    "
                >
                    ☆
                </div>

                <h3
                    class="
                        mt-5
                        text-xl
                        font-black
                        text-slate-900
                    "
                >
                    No favorite cars yet
                </h3>

                <p
                    class="
                        mx-auto
                        mt-2
                        max-w-md
                        text-slate-600
                    "
                >
                    You have not saved any favorite cars yet.
                    Browse the Hot Wheels database and save TH or STH
                    cars you want to track.
                </p>

                <a
                    href="{{ route('cars.index') }}"
                    class="
                        mt-5
                        inline-block
                        rounded-lg
                        bg-yellow-400
                        px-5
                        py-2.5
                        font-black
                        text-slate-900
                        hover:bg-yellow-300
                    "
                >
                    Browse Cars
                </a>

            </div>

        @else

            <div
                class="
                    grid
                    gap-5
                    sm:grid-cols-2
                    lg:grid-cols-3
                    xl:grid-cols-4
                "
            >

                @foreach ($favoriteCars as $car)

                    @php

                        $imageUrl = null;

                        if ($car->image) {

                            $imageUrl =
                                \Illuminate\Support\Str::startsWith(
                                    $car->image,
                                    [
                                        'http://',
                                        'https://',
                                    ]
                                )
                                    ? $car->image
                                    : asset(
                                        ltrim(
                                            $car->image,
                                            '/'
                                        )
                                    );

                        }

                    @endphp


                    <article
                        class="
                            overflow-hidden
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            shadow-sm
                            transition
                            hover:-translate-y-1
                            hover:shadow-lg
                        "
                    >

                        {{-- Image --}}

                        <div
                            class="
                                relative
                                flex
                                h-40
                                items-center
                                justify-center
                                overflow-hidden
                                bg-gradient-to-br
                                from-blue-50
                                via-white
                                to-yellow-50
                            "
                        >

                            @if ($imageUrl)

                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $car->model_name }}"
                                    class="
                                        h-full
                                        w-full
                                        object-cover
                                    "
                                >

                            @else

                                <img
                                    src="{{ asset(
                                        'images/hot-wheels-market-tracker-logo.png'
                                    ) }}"
                                    alt=""
                                    class="
                                        w-32
                                        opacity-50
                                    "
                                >

                            @endif


                            <span
                                class="
                                    absolute
                                    right-3
                                    top-2
                                    text-2xl
                                    text-yellow-400
                                "
                            >
                                ★
                            </span>

                        </div>


                        <div class="p-5">

                            <div
                                class="
                                    flex
                                    items-start
                                    justify-between
                                    gap-3
                                "
                            >

                                <div>

                                    <h3
                                        class="
                                            font-black
                                            text-slate-900
                                        "
                                    >
                                        {{ $car->model_name }}
                                    </h3>

                                    <p
                                        class="
                                            mt-1
                                            text-sm
                                            text-slate-500
                                        "
                                    >
                                        {{ $car->series_name }}
                                    </p>

                                </div>


                                <span
                                    class="
                                        rounded-md
                                        px-2
                                        py-1
                                        text-xs
                                        font-black

                                        {{ $car->category === 'STH'
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-yellow-100 text-yellow-800'
                                        }}
                                    "
                                >
                                    {{ $car->category }}
                                </span>

                            </div>


                            <p
                                class="
                                    mt-4
                                    text-sm
                                    font-bold
                                    text-slate-500
                                "
                            >
                                Release Year:
                                <span
                                    class="
                                        text-slate-900
                                    "
                                >
                                    {{ $car->release_year }}
                                </span>
                            </p>


                            <a
                                href="{{ route(
                                    'cars.show',
                                    $car
                                ) }}"
                                class="
                                    mt-5
                                    block
                                    rounded-lg
                                    bg-yellow-400
                                    px-4
                                    py-2.5
                                    text-center
                                    text-sm
                                    font-black
                                    text-slate-900
                                    hover:bg-yellow-300
                                "
                            >
                                View Car
                            </a>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </section>


    {{-- =====================================================
         DELETE ACCOUNT
    ====================================================== --}}

    @if ($this->showDeleteUser)

        <div
            class="
                mt-10
                rounded-xl
                border
                border-red-200
                bg-white
                p-6
                shadow-sm
            "
        >

            <livewire:pages::settings.delete-user-form />

        </div>

    @endif

</section>
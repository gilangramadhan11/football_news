<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex justify-center items-center mb-4">
        <a href="/">
            <x-application-logo class="w-20 h-20 p-3 mt-3 fill-current text-neutral-100 bg-neutral-700 rounded-3xl" />
        </a>
    </div>
    <div class="text-center mb-4">
        <h1 class="text-2xl font-bold text-neutral-900">Welcome Back!</h1>
        <p class="text-neutral-400">Please enter your login details.</p>

    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" class="block text-sm font-medium text-neutral-700" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-neutral-200 border-0 focus:border-0 focus:outline-none focus:ring-0" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative mt-4">
            <x-input-label for="password" class="block text-sm font-medium text-neutral-700" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full bg-neutral-200 border-0 focus:border-0 focus:outline-none focus:ring-0"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <button 
                type="button" 
                class="absolute inset-y-0 right-0 flex items-center px-2 pt-6 text-gray-500 hover:text-neutral-700">
                <i id="passwordIcon" class="bx bx-show text-xl"></i>
            </button>
        </div>

        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="rounded border-neutral-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                    name="remember">
                <label for="remember_me" class="ms-2 text-sm text-neutral-800">{{ __('Remember me') }}</label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-neutral-800 hover:text-neutral-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot Password?') }}
                </a>
            @endif
        </div>

        <div class="flex mt-6 rounded-4xl">
            <button class="w-full rounded-lg text-neutral-100 py-2 justify-center bg-neutral-700 hover:bg-neutral-900 focus:bg-neutral-900 active:bg-neutral-900">
                {{ __('Login') }}
            </button>
        </div>
        <div class="my-3 rounded-xl border border-neutral-500/30 bg-neutral-800/80 p-4 text-left shadow-lg backdrop-blur-sm">
            <div class="mb-2 flex items-center gap-2 text-neutral-100 font-semibold text-xs uppercase tracking-wider">
                <i class="bx bx-info-circle text-base"></i>
                <span>Akun Demo Login</span>
            </div>
            <div class="space-y-2 text-xs text-neutral-300 font-mono">
                <div class="flex justify-between items-center bg-neutral-900/60 px-3 py-2 rounded border border-neutral-700/50">
                    <span>Email: <strong class="text-white">admin@footballnews.test</strong></span>
                    <button 
                        type="button" 
                        onclick="navigator.clipboard.writeText('admin@footballnews.test')"
                        class="text-neutral-400 hover:text-lime-400 transition"
                        title="Salin Email"
                    >
                        <i class="bx bx-copy text-sm"></i>
                    </button>
                </div>
                <div class="flex justify-between items-center bg-neutral-900/60 px-3 py-2 rounded border border-neutral-700/50">
                    <span>Pass : <strong class="text-white">password</strong></span>
                    <button 
                        type="button" 
                        onclick="navigator.clipboard.writeText('password')"
                        class="text-neutral-400 hover:text-lime-400 transition"
                        title="Salin Password"
                    >
                        <i class="bx bx-copy text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-4 my-4">
            <div class="h-px flex-1 bg-neutral-200"></div>
            <span class="text-sm text-neutral-600 font-semibold">
                OR
            </span>
            <div class="h-px flex-1 bg-neutral-200"></div>
        </div>
        <div class="flex items-center justify-center mt-4 gap-2">
            <div class="flex gap-2 w-full">
                <a href="" class="flex w-full items-center justify-center gap-2 border border-neutral-200 rounded-lg text-neutral-700 py-2.5 bg-white font-semibold transition-colors duration-200 hover:bg-neutral-300 hover:text-neutral-800 focus:bg-neutral-300 focus:text-neutral-800 active:bg-neutral-100">
                    <i class='bx bxl-google text-xl'></i>
                    <span class="text-sm text-neutral-700">
                        {{ __('With Google') }}
                    </span>
                </a>
            </div>
            <div class="flex gap-2 w-full">
                <a href="" class="flex w-full items-center justify-center gap-2 border border-neutral-200 rounded-lg text-neutral-700 py-2.5 bg-white font-semibold transition-colors duration-200 hover:bg-neutral-300 hover:text-neutral-800 focus:bg-neutral-300 focus:text-neutral-800 active:bg-neutral-100">
                    <i class='bx bxl-facebook text-xl'></i>
                    <span class="text-sm text-neutral-700">
                        {{ __('With Facebook') }}
                    </span>
                </a>
            </div>
        </div>
        <div class="flex text-center justify-center mt-4">
            <p class="items-center justify-center text-neutral-500">Dont have an account?</p>
            <a href="#" class="ms-1 underline font-semibold text-neutral-900"> Register now</a>
        </div>
        </div>
    </form>
</x-guest-layout>

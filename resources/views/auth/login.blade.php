<x-guest-layout>
<link rel="stylesheet" href="/css/connection.css">
<title>connection</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div id="logo1">
        <img id="logo-FS" src="https://media.discordapp.net/attachments/936584358654005321/972050887025508412/LOGO.png?width=820&height=670" alt="Familles de la sarthe">
    </div>
    <div>
        <img id="logo-YC" src="https://media.discordapp.net/attachments/936584358654005321/971697589365911562/unknown.png" alt="YouClock">
    </div>

    <div id="form-connection">
<h3 id="bonjour">Bonjour</h3>
        <p id="text-con">Connectez-vous pour renseigner votre feuille horaire</p>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input id="input-id" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">

                <x-input id="input-pass" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                placeholder="mot de passe"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                </label>
            </div>
            <div id="mdp-oublie">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/forgotpass">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
            </div>

                <button id="button-con"  class="btn btn-primary">
                    {{ __('CONNECTION') }}
                </button>
            
        </form>
    </div>
</x-guest-layout>

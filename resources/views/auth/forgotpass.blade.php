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

    <div id="form-connection" style="margin-top: -22%;">
<h3 id="bonjour">réinitialiser le mot de passe</h3>
        <p id="text-con">Veuillez entrer votre adresse mail</p>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-auth-session-status class="mb-4" :status="session('error')" style="color:red"/>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        
        <form method="POST" action="">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input id="input-id" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="email" required autofocus />
            </div>

                <button id="button-con"  class="btn btn-primary">
                    {{ __('confirmer') }}
                </button>
            
        </form>
    </div>
</x-guest-layout>

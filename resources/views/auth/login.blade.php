<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Select Murid (fills email) -->
        @php
            $__murids = \App\Models\Murid::with('user')->get();
        @endphp
        <div class="mb-3">
            <label class="block text-sm">Pilih Murid (scroll-select)</label>
            <select id="murid_select" class="block mt-1 w-full rounded border-gray-300">
                <option value="">-- pilih nama --</option>
                @foreach($__murids as $m)
                    @if($m->user)
                        <option value="{{ $m->user->email }}">{{ $m->nama }} — {{ $m->kelas->nama ?? 'Kelas' }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        <input type="hidden" name="role" id="role_input" value="">
    </form>
    <!-- Role selection modal -->
    <div id="roleModal" class="fixed inset-0 hidden items-center justify-center z-50 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-80">
            <h3 class="text-lg font-semibold mb-4">Pilih role untuk login</h3>
            <div class="flex flex-col gap-2">
                <button data-role="admin" class="role-btn px-3 py-2 bg-gray-800 text-white rounded">Admin</button>
                <button data-role="guru" class="role-btn px-3 py-2 bg-gray-800 text-white rounded">Guru</button>
                <button data-role="murid" class="role-btn px-3 py-2 bg-gray-800 text-white rounded">Murid</button>
                <button id="roleCancel" class="mt-2 px-3 py-2 bg-gray-200 rounded">Batal</button>
            </div>
        </div>
    </div>

    <script>
        // fill email when murid selected
        document.getElementById('murid_select')?.addEventListener('change', function(e){
            const email = e.target.value;
            if(email){
                document.getElementById('email').value = email;
            }
        });

        // show role modal when pressing login
        const form = document.querySelector('form[action="{{ route('login') }}"]');
        const roleModal = document.getElementById('roleModal');
        const roleInput = document.getElementById('role_input');

        form.addEventListener('submit', function(ev){
            ev.preventDefault();
            // show modal
            roleModal.classList.remove('hidden');
            roleModal.classList.add('flex');
        });

        document.querySelectorAll('.role-btn').forEach(btn => {
            btn.addEventListener('click', function(){
                const role = this.dataset.role;
                roleInput.value = role;
                // submit form
                roleModal.classList.add('hidden');
                roleModal.classList.remove('flex');
                form.submit();
            });
        });

        document.getElementById('roleCancel')?.addEventListener('click', function(){
            roleModal.classList.add('hidden');
            roleModal.classList.remove('flex');
        });
    </script>
</x-guest-layout>

<div>
    @if (session()->has('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif

    @if ($page === 'login')
        <h2 class="text-xl font-bold">Login</h2>
        <input type="email" wire:model="email" placeholder="Email">
        <input type="password" wire:model="password" placeholder="Password">
        <button wire:click="login">Login</button>
        <p>Belum punya akun? <a href="#" wire:click.prevent="setPage('register')">Register</a></p>

    @elseif ($page === 'register')
        <h2 class="text-xl font-bold">Register</h2>
        <input type="text" wire:model="name" placeholder="Nama">
        <input type="email" wire:model="email" placeholder="Email">
        <input type="password" wire:model="password" placeholder="Password">
        <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password">
        <button wire:click="register">Register</button>
        <p>Sudah punya akun? <a href="#" wire:click.prevent="setPage('login')">Login</a></p>
    @endif
</div>

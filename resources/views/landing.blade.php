<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OSC ENERGY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-950">
    <main>
        <section class="min-h-[88vh] bg-[linear-gradient(90deg,rgba(255,247,237,.96),rgba(255,255,255,.88),rgba(14,165,233,.20)),url('https://images.unsplash.com/photo-1542367597-8849eb950fd8?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center">
            <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
                <a href="{{ route('landing') }}" class="rounded-md bg-slate-950 px-3 py-2 text-lg font-black tracking-wide text-white shadow-lg"><span>OSC</span> <span class="text-orange-400">ENERGY</span></a>
                <div class="flex items-center gap-3 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="rounded-md bg-orange-500 px-4 py-2 font-semibold text-white shadow-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-md px-4 py-2 font-semibold text-slate-800 hover:bg-white/70">Login</a>
                        <a href="{{ route('register') }}" class="rounded-md bg-orange-500 px-4 py-2 font-semibold text-white shadow-sm">Register</a>
                    @endauth
                </div>
            </nav>
            <div class="mx-auto flex min-h-[70vh] max-w-7xl items-center px-6">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[.2em] text-orange-600">Gasabo District Operations</p>
                    <h1 class="mt-4 text-4xl font-black leading-tight text-slate-950 sm:text-6xl">OSC ENERGY</h1>
                    <p class="mt-5 max-w-2xl text-lg font-medium text-slate-700">A secure Laravel platform for fuel stock, sales, customer purchases, daily transactions, invoices, and revenue reporting.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('register') }}" class="rounded-md bg-orange-500 px-5 py-3 font-bold text-white shadow-md">Start as Customer</a>
                        <a href="#about" class="rounded-md border border-slate-300 bg-white/80 px-5 py-3 font-bold text-slate-900 shadow-sm">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
        <section id="about" class="bg-white px-6 py-16 text-slate-950">
            <div class="mx-auto grid max-w-7xl gap-8 md:grid-cols-3">
                <div class="border-l-4 border-orange-500 pl-5"><h2 class="text-2xl font-bold">Clear Stock</h2><p class="mt-2 text-slate-600">Real-time quantities, stock movement history, and low-stock alerts.</p></div>
                <div class="border-l-4 border-sky-500 pl-5"><h2 class="text-2xl font-bold">Accurate Revenue</h2><p class="mt-2 text-slate-600">Automatic totals, transaction-safe sales, and daily/monthly reports.</p></div>
                <div class="border-l-4 border-slate-900 pl-5"><h2 class="text-2xl font-bold">Modern Access</h2><p class="mt-2 text-slate-600">Customer purchases, invoices, administrator dashboards, and REST APIs.</p></div>
            </div>
        </section>
        <section id="contact" class="bg-orange-50 px-6 py-12 text-slate-900">
            <div class="mx-auto max-w-7xl">
                <h2 class="text-2xl font-bold">Contact</h2>
                <p class="mt-2 text-slate-600">OSC ENERGY Fuel Station Management Office. Email: support@oscenergy.test</p>
            </div>
        </section>
    </main>
</body>
</html>

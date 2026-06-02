<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::where('role', 'customer')
            ->withCount('sales')
            ->withSum('sales', 'total_amount')
            ->when($request->search, fn ($query, $search) => $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('username', 'like', "%{$search}%")))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('manager.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('manager.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'alpha_dash', 'max:255', 'unique:users,username'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data['role'] = 'customer';
        $data['email_verified_at'] = now();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('manager.customers.index')->with('success', 'Customer created successfully.');
    }

    public function edit(User $customer): View
    {
        abort_unless($customer->role === 'customer', 404);

        return view('manager.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        abort_unless($customer->role === 'customer', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$customer->id],
            'username' => ['required', 'alpha_dash', 'max:255', 'unique:users,username,'.$customer->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $customer->update($data);

        return redirect()->route('manager.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_unless($customer->role === 'customer', 404);
        $customer->delete();

        return redirect()->route('manager.customers.index')->with('success', 'Customer deleted successfully.');
    }
}

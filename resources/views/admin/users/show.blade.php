@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.users') }}" class="text-emerald-600 hover:text-emerald-700 text-sm">← Back to Users</a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">User Details</h1>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <p class="text-gray-500 text-sm">Name</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Email</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Phone</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Joined</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <form action="{{ route('admin.update_user_role', $user->id) }}" method="POST" class="mt-8 pt-8 border-t border-gray-200">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">User Role</label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-emerald-500">
                    <option value="buyer" {{ $user->role === 'buyer' ? 'selected' : '' }}>Buyer</option>
                    <option value="artist" {{ $user->role === 'artist' ? 'selected' : '' }}>Artist</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">
                Update Role
            </button>
        </form>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <div class="grid grid-cols-1 gap-5 mt-6 sm:grid-cols-1 lg:grid-cols-3">
        <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">Total Emails</span>
                    <span class="text-lg font-semibold">{{$emailCount}}</span>
                </div>
                <div class="p-10 bg-gray-200 rounded-md"></div>
            </div>
        </div>
        <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">Total Customers</span>
                    <span class="text-lg font-semibold">{{$counsellorsCount}}</span>
                </div>
                <div class="p-10 bg-gray-200 rounded-md"></div>
            </div>
        </div>
        <div class="p-4 transition-shadow border rounded-lg shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex flex-col space-y-2">
                    <span class="text-gray-400">Total Users</span>
                    <span class="text-lg font-semibold">{{$usersCount}}</span>
                </div>
                <div class="p-10 bg-gray-200 rounded-md"></div>
            </div>
        </div>
    </div>     
@endsection
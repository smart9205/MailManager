{{-- <a href="{{url('/admin/user/edit/' . $user->id)}}" class=" p-2 m-2 rounded-md bg-blue-600 text-white text-md">
    <span class="inline-flex"><i class="bx bxs-edit mr-1"></i></span>
    Edit
</a>
<a href="{{url('/admin/user/view/' . $user->id)}}" class=" p-1 m-2 rounded-md bg-indigo-600 text-white text-md">
    <span class="inline-flex"><i class="bx bxs-edit mr-1"></i></span>
    View
</a> --}}

<a href="{{url('/customer/user/edit/' .$user->id)}}" class="p-2 m-2 rounded-md bg-indigo-600 text-white text-md">
    <span class="inline-flex"><i class="bx bxs-edit mr-1"></i></span>
    Edit
</a>

<a href="{{url('/customer/user/view/' . $user->id)}}" class="p-2 m-2 rounded-md bg-indigo-600 text-white text-md">
    <span class="inline-flex"><i class="bx bxs-edit mr-1"></i></span>
    View Chats
</a>

<form action="{{url('/customer/user/delete/' .$user->id)}}" class="inline-block" method="POST">
    @csrf
    <button type="submit" class="bg-red-500 text-white rounded-lg text-md p-2 ml-4" onclick="return confirm('{{"Are you sure you want to delete this user?"}}')">
        <span><i class="bx bx-trash"></i></span>
         Delete
    </button>
</form>

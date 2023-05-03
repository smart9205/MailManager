<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Domain;
use App\Models\ChMessage as Message;
use App\Http\Controllers\vendor\Chatify\MessagesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\DB;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{

    protected $perPage = 30;
    protected $messengerFallbackColor = '#2180f3';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $unreadMessages = MessagesController::getCountOfUnreadMessages(Auth::user()->id);
        return view('home')->with('unreadMsg', $unreadMessages);
    }

    public function adminIndex()
    {
        // $allUsersCount = User::totalUsersCount();
        $usersCount = User::usersCount();
        $counsellorsCount = User::counsellorsCount();
        $emailCount = Domain::emailCount();
        // return view('admin.users.user-view')->with(['user' => $user]);
        return view('admin.index')->with(
            ['usersCount' => $usersCount,
            'counsellorsCount' => $counsellorsCount,
            'emailCount' => $emailCount
            ]
        );
    }

    public function Customindex(){
        $customer = Auth::user();
        $domain_name = $customer->domain->domain_name;
        $email_used = User::where([['type', '=', (string)\UserType::USER],['domain_id', '=', $customer->domain_id]])->count();
        $email_limits = $customer->domain->email_limits;
        return view('customer.index')->with(
            ['domain_name' => $domain_name,
            'email_limits' => $email_limits,
            'email_used' => $email_used
            ]
        );
    }

    public function renderCounsellorsPage()
    {
        return view('admin.counsellor.counsellors');
    }

    public function displayCounsellors()
    {
        $customers = User::where('type', '=', (string)\UserType::COUNSELLOR)
        ->orderBy('id', 'DESC');
        

        return Datatables::of($customers)
        ->editColumn('is_active', function ($customer) {
            return \ActiveStatus::getValueInHtml($customer->is_active);
        })
        ->addColumn('name', function($customer){
            return $customer->last_name.' '.$customer->first_name;
        })
        ->addColumn('domain_name', function($customer){
            return $customer->domain->domain_name;
        })
        ->addColumn('email_limit', function($customer){
            return $customer->domain->email_limits;
        })
        ->addColumn('email_used', function($customer){
            $users = User::where([['type', '=', (string)\UserType::USER],['domain_id', '=', $customer->domain_id]]);
            return $users->count();
        })
        ->addColumn('action', function ($customer) {
            return view('admin.partials.admin_counsellor_action')->with([
                'user' => $customer,
            ]);
        })
        ->editColumn('created_at', function ($customer) {
            return $customer->created_at->format('d/m/Y');
        })
        ->rawColumns(['action', 'is_active'])
        ->make(true);
    }

    public function renderUsersPage(Request $request)
    {
        // $domain_id = $request->segment(3);
        // $domain_id =(request()->segment(count(request()->segments())));

        $url = URL::current();
        $url_arr = explode('/', $url);
        $domain_id = $url_arr[count($url_arr) - 1];

        return view('admin.users')->with( ["domain_id"=>$domain_id]);
    }

    public function displayUsers(Request $request)
    {
        $domain_id = $request->domain_id;
        
        $data= User::where([['type', '=', (string)\UserType::USER], ['domain_id', '=', $domain_id]])
        ->orderBy('id', 'DESC');

        return Datatables::of($data)
        ->editColumn('is_active', function ($user) {
            return \ActiveStatus::getValueInHtml($user->is_active);
        })
        ->addColumn('name', function($user){
            return $user->last_name.' '.$user->first_name;
        })
        ->addColumn('action', function ($user) {
            return view('customer.customer_user_action')->with([
                'user' => $user
            ]);
        })
        ->editColumn('created_at', function ($user) {
            return $user->created_at->format('d/m/Y');
        })
        ->rawColumns(['action', 'is_active'])
        ->make(true);
    }

    public function editUsers(Request $request)
    {
        $id = $request->segment(4);
        $user = User::FindOrFail($id);
        return view('customer.customer_user_edit')->with(['user' => $user]);
    }

    public function deleteUsers($id)
    {
        $user = User::FindOrFail($id);
        if ($user->type == \UserType::USER) {
            $user->delete();
            \session()->flash('success', 'User deleted');

            return redirect()->back()->with('success', 'User deleted successfully'); 
        }
        return redirect()->back();


    }

    public function viewUsers($id)
    {   
        $user1 = User::Find($id);
       
        
       
        // $routeName= FacadesRequest::route()->getName();
        $counsellor = User::where('type', '=', ''.\UserType::USER.'')->get()->toArray();
        // $type = in_array($routeName, ['user','group'])
        //     ? $routeName
        //     : 'user';
        
        // ->where(function ($q) {
        //     $q->where('ch_messages.from_id', 3)
        //     ->orWhere('ch_messages.to_id', 3);
        // })
         
        $users = Message::join('users',  function ($join) {
            $join->on('ch_messages.from_id', '=', 'users.id')
                ->orOn('ch_messages.to_id', '=', 'users.id');
        })->where('users.id','!=',$id)->where(function ($q) use ($id) {
            $q->where('ch_messages.from_id', $id)
            ->orWhere('ch_messages.to_id', $id);
        })
        ->select('users.*',DB::raw('MAX(ch_messages.created_at) max_created_at'))
        ->orderBy('max_created_at', 'desc')
        ->groupBy('users.id')
        ->paginate(30 ?? $this->perPage);
        $usersList =$users->items();

        if (count($usersList) > 0) {
            $contacts = $usersList;
           
        }
        else{
            $contacts = null;
        }
        $lastMessage =  Message::where('from_id', $id)
        ->orWhere('from_id', $id)->latest()->first();

       
        $unseenCounter =Chatify::countUnseenMessages($id);
        

        return view('customer.viewUser', [
            'id' => $id,
            'type' => $type ?? 'user',
            'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
            'counsellor' => $counsellor,
            'contacts'=>$contacts,
            'user1'=>$user1
        ]);
    }


    public function viewUser(Request $request)
    {
        $id = $request->segment(4);
        // $id = getDecodedId($encodedId);
        $user = User::FindOrFail($id);
        return view('admin.users.user-view')->with(['user' => $user]);
    }

    public function updateUsers(Request $request)
    {
        $postData = request()->all();
        $user = Auth::user();
        if ($user instanceof User && $user->type != \UserType::USER) {
            $validators = Validator::make($request->input(), [
                // 'email' => 'required|email|unique:users',
                'first_name' => 'required|string|max:30',
                'is_active' => 'required|numeric',
            ]);
            if ($validators->fails()) {
                return redirect()->back()->withErrors($validators)->withInput();
            }
             /** @var User $getUser */
             
            $getUser = User::get($postData['id']);

            // $mail_arr = explode('@', $postData['email']);
            // if ($getUser->domain->domain_name != $mail_arr[1])
            //     return redirect()->back()->with('error', 'Domain name is not allowed');            

            $getUser->edit();
            return redirect()->back()->with('success', 'User updated successfully');  
        } else {
            \session()->flash('error', 'User not authenticated');
            return redirect()->back();
        }

    }

    public function renderAddUsersPage($domain_id)
    {
        return view('customer.add_user')->with(['domain_id' => $domain_id]);
    }

    public function addUser(Request $request)
    {
        $postData = request()->all();
        $customer = Auth::user();

        $email_used = User::where([['type', '=', (string)\UserType::USER],['domain_id', '=', $customer->domain_id]])->count();
        $email_limits = $customer->domain->email_limits;
        
        if($email_limits <= $email_used)
            return redirect()->back()->with('error', 'You have no limit for email!');  

        if ($customer instanceof User && $customer->type != \UserType::USER) {
            $validators = Validator::make($request->input(), [
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'first_name' => 'required|string|max:30'
            ]);
            if ($validators->fails()) {
                return redirect()->back()->withErrors($validators)->withInput();
            }

            $mail_arr = explode('@', $postData['email']);
            

            if ($customer->domain->domain_name != $mail_arr[1])
                return redirect()->back()->with('error', 'Domain name is not allowed');            

            $user = new User(); 
            $user->first_name = $postData['first_name'];
            $user->last_name = $postData['last_name'];
            $user->mobile_number = $postData['mobile_number'];
            $user->email = $postData['email'];
            $user->password = Hash::make($postData['password']);            
            $user->type = '10';
            $user->domain_id = $customer->domain_id;
            $user->save();
            
            return redirect()->back()->with('success', 'User added successfully');  
        } else {

            \session()->flash('error', 'User not authenticated');
            return redirect()->back();
        }
    }

    /**
     * Delete Counsellor.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function deleteCounsellor($id)
    {
        $customer = User::FindOrFail($id);
        // $user = User::findOrFail($decodedId);
        if ($customer->type == \UserType::COUNSELLOR) {
            $customer->delete();
            $domain=$customer->domain;
            $domain->delete();

            $users = User::where([['type', '=', (string)\UserType::USER],['domain_id', '=', $customer->domain_id]])->get();                
            foreach($users as $ur)
            {
                $ur->delete();
            }

            \session()->flash('success', 'Customer deleted');

            return redirect(url('/admin/counsellors'));
        }
        return redirect()->back();
    }

    /**
     * Render counsellor update view.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function editCounsellor(Request $request)
    {
        $id = $request->segment(4);
        $customer = User::FindOrFail($id);
        $domain = $customer->domain;
        return view('admin.counsellor.counsellor-edit')->with(['customer' => $customer, 'domain' => $domain]);
    }

    public function updateCounsellors(Request $request)
    {
        $postData = request()->all();
        $user = Auth::user();
        if ($user instanceof User && $user->type != \UserType::USER) {
            $validators = Validator::make($request->input(), [
                'email_limits' => 'required|numeric',
                'first_name' => 'required|string|max:30',
                // 'mobile_number' => 'bail|numeric|digits_between:11,12',
                'is_active' => 'required|numeric',
            ]);
            if ($validators->fails()) {
                return redirect()->back()->withErrors($validators)->withInput();
            }

             $getUser = User::get($postData['id']);
             $getUser->first_name = $postData['first_name'];
             $getUser->last_name = $postData['last_name'];
            //  $getUser->mobile_number = $postData['mobile_number'];
             
             $getUser->is_active = $postData['is_active'];
             $getUser->save();

             $domain = $getUser->domain;
             $domain->email_limits = $postData['email_limits'];
             $domain->is_active = $postData['is_active'];
             if ($postData['is_active'] == 0)
             {
                $users = User::where([['type', '=', (string)\UserType::USER],['domain_id', '=', $getUser->domain_id]])->get();                
                foreach($users as $ur)
                {
                    $ur->is_active = $postData['is_active'];
                    $ur->save();
                }
             }
             $domain->save();
     
             return redirect()->back()->with('success', 'User updated successfully');  
        } else {
            \session()->flash('error', 'User not authenticated');
            return redirect()->back();
        }
        
    }

    public function updateUser(Request $request)
    {
        $id = $request->segment(3);
        $user = User::FindOrFail($id);
        $user->edit();
        \session()->flash('success', 'User updated');
        return redirect()->back();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password'=>'required|min:6|max:100',
            'new_password'=>'required|min:6|max:100',
            'confirm_password'=>'required|same:new_password'
        ]);
        $id = $request->segment(3);
        $user = User::FindOrFail($id);
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password'=>bcrypt($request->new_password)
            ]);
            return redirect()->back()->with('success', 'Password updated');
        }
        else {
            return redirect()->back()->with('error', 'Old password does not match current password');
        }
    }

    public function renderAddCounsellorsPage()
    {
        return view('admin.counsellor.add-counsellor');
    }

  
 
    public function addCounsellor(Request $request)
    {
        $validators = Validator::make($request->input(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'email_limits' => 'required|numeric',
            'first_name' => 'required|string|max:30',
            'domain_name' => 'required|unique:domains'
        ]);
        if ($validators->fails()) {
            return redirect()->back()->withErrors($validators)->withInput();
        }

        $domain = new Domain();
        $customerData = request()->all();       

        $domain->email_limits = $customerData['email_limits'];
        $domain->domain_name = $customerData['domain_name'];        
        $domain->save();

        $user = new User(); 
        $user->first_name = $customerData['first_name'];
        $user->last_name = $customerData['last_name'];
        $user->email = $customerData['email'];
        $user->password = Hash::make($customerData['password']);            
        $user->type = '20';
        $user->domain_id = $domain->id;    
        $user->save();
        
        return redirect()->back()->with('success', 'Customer added');
    }

    public function fetch(Request $request)
    {
       
        // $query = Message::where('from_id',$request->id)->orWhere('to_id', $request->id)->latest();

        // $query = DB::table('ch_messages')
        //             ->join('users AS from', 'from.id', '=', 'ch_messages.from_id')
        //             ->join('users AS to', 'to.id', '=', 'ch_messages.to_id')
        //             ->select('ch_messages.*', 'from.domain_id AS from_domain', 'to.domain_id AS to_domain');            


        $query = Message::where('from_id',$request->domain_id)->where('to_id', $request->id)
        ->orWhere('from_id', $request->id)->where('to_id', $request->domain_id)->latest();
        $messages = $query->paginate($request->per_page ?? $this->perPage);

        $totalMessages = $messages->total();
        $lastPage = $messages->lastPage();
        $response = [
            'total' => $totalMessages,
            'last_page' => $lastPage,
            'last_message_id' => collect($messages->items())->last()->id ?? null,
            'messages' => '$nums',
        ];

        // if there is no messages yet.
        if ($totalMessages < 1) {
            $response['messages'] ='<p class="message-hint center-el"><span>Say \'hi\' and start messaging</span></p>';
            return Response::json($response);
        }
        if (count($messages->items()) < 1) {
            $response['messages'] = '';
            return Response::json($response);
        }
        $allMessages = null;
        foreach ($messages->reverse() as $message) {
            $allMessages .= Chatify::messageCard(
                $this->fetchMessage1($message->id,$request->domain_id)
            );
        }
        if (Auth::user()->type == \UserType::USER) {
            $response['messages'] .= '';
        }
        $response['messages'] = $allMessages;
        return Response::json($response);
    }

    public function fetchMessage1($id,$domain_id, $index = null)
    {
        $attachment = null;
        $attachment_type = null;
        $attachment_title = null;

        $msg = Message::where('id', $id)->first();
        if(!$msg){
            return [];
        }

        if (isset($msg->attachment)) {
            $attachmentOBJ = json_decode($msg->attachment);
            $attachment = $attachmentOBJ->new_name;
            $attachment_title = htmlentities(trim($attachmentOBJ->old_name), ENT_QUOTES, 'UTF-8');

            $ext = pathinfo($attachment, PATHINFO_EXTENSION);
            $attachment_type = in_array($ext, $this->getAllowedImages()) ? 'image' : 'file';
        }

        return [
            'index' => $index,
            'id' => $msg->id,
            'from_id' => $msg->from_id,
            'to_id' => $msg->to_id,
            'message' => $msg->body,
            'attachment' => [$attachment, $attachment_title, $attachment_type],
            'time' => $msg->created_at->diffForHumans(),
            'fullTime' => $msg->created_at,
            'viewType' => ($msg->from_id == $domain_id) ? 'sender' : 'default',
            'seen' => $msg->seen,
        ];
    }


    public function getAllowedImages()
    {
        return config('chatify.attachments.allowed_images');
    }

}



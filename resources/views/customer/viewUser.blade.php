@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            {{-- Tabs --}}
            <div class="messenger-listView-tabs">
                <a href="#" @if($type == 'user') class="active-tab" @endif data-view="users">
                    <span class="far fa-user"></span> People</a>
                {{-- <a href="#" @if($type == 'group') class="active-tab" @endif data-view="groups">
                    <span class="fas fa-users"></span> Groups</a> --}}
            </div>
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
           {{-- Lists [Users/Group] --}}
           {{-- ---------------- [ User Tab ] ---------------- --}}
           <div class="@if($type == 'user') show @endif messenger-tab users-tab app-scroll" data-view="users">

               {{-- Favorites --}}
               <div class="favorites-section">
                <p class="messenger-title">Favorites</p>
                <div class="messenger-favorites app-scroll-thin"></div>
               </div>

               <h4 class="head-text">Contacts</h4>
               <div class="listOfuserContacts">
                
                @if($contacts!=null)
          
               @foreach ($contacts as $user)
                    <table class="messenger-list_item" data-contact="{{ $user->id }}">
                        <tr data-action="0">
                            {{-- Avatar side --}}
                            <td style="position: relative">
                                @if($user->active_status)
                                    <span class="activeStatus"></span>
                                @endif
                                <div class="avatar av-m"
                                style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar) }}');">
                                </div>
                            </td>
                            {{-- center side --}}
                            <td>
                            <p data-id="{{ $user->id }}" data-type="user">
                                {{ strlen($user->first_name) > 12 ? trim(substr($user->first_name,0,12)).'..' : $user->first_name }}
                            
                            <span>
                                {{-- Last Message user indicator --}}
                            
                                {{-- Last message body --}}
                            
                            </span>
                            </td>

                        </tr>    
                    </table>
               @endforeach
               @else
                    <p class="message-hint center-el"><span>No Contacts</span></p>
               @endif
           
               </div>

           
               
               {{-- Contact --}}

              
               {{-- <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);position: relative;">
                </div> --}}

               
                

           </div>

           {{-- ---------------- [ Group Tab ] ---------------- --}}
           <div class="@if($type == 'group') show @endif messenger-tab groups-tab app-scroll" data-view="groups">
                {{-- items --}}
                <p style="text-align: center;color:grey;margin-top:30px">
                    <a target="_blank" style="color:{{$messengerColor}};" href="https://chatify.munafio.com/notes#groups-feature">Click here</a> for more info!
                </p>
             </div>

             {{-- ---------------- [ Search Tab ] ---------------- --}}
           <div class="messenger-tab search-tab app-scroll"app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title">Search</p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
             </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav>
                {{-- header back button, avatar and user name --}}
                <div style="display: inline-flex;">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div>
                    <a href="#" class="user-name">Chat History</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/customer"><i class="fas fa-home"></i></a>
                    <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                </nav>
            </nav>
        </div>
        {{-- Internet connection --}}
        <div class="internet-connection">
            <span class="ic-connected">Connected</span>
            <span class="ic-connecting">Connecting...</span>
            <span class="ic-noInternet">No internet access</span>
        </div>
        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                <p class="message-hint center-el"><span>Please select users to view chat history</span></p>
            </div>
            {{-- Typing indicator --}}
            {{-- <div class="typing-indicator">
                <div class="message-card typing">
                    <p>
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </p>
                </div>
            </div> --}}
            <!-- {{-- Send Message Form --}}
            @include('Chatify::layouts.sendForm') -->
        </div>
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {{-- user info and avatar --}}
        <div class="avatar av-l upload-avatar-preview"
            style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user1->avatar) }}');"
        ></div>
        <p class="upload-avatar-details"></p>
        <label class="app-btn a-btn-primary update"></label>

        {{-- Dark/Light Mode  --}}
        <p class="divider"></p>
        <p class="app-modal-header">First Name:  {{$user1['first_name']}}</p>
        <p class="divider"></p>
        <p class="app-modal-header">Last Name  {{$user1['last_name']}}</p>
        {{-- change messenger color  --}}
        <p class="divider"></p>
        <p class="app-modal-header">Email:  {{$user1['email']}}</p>
        <p class="divider"></p>
        <div class="update-messengerColor">

    </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')


{{-- <mc-sender></mc-sender> --}}
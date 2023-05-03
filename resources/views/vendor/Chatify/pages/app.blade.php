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
                    <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            <input type="text" class="messenger-search" placeholder="Search" />
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

               {{-- Saved Messages --}}
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}


               <h4 class="head-text">Contacts</h4>
               <div class="listOfContacts"></div>

            @if(Auth::user()->type !== \UserType::COUNSELLOR)
                <hr>
                <h4 class="head-text">All Users</h4>
                @foreach ($counsellor as $counsellor)
                    @if($counsellor['is_active'] == 1)
                        <table class="messenger-list-item" data-contact="{{ $counsellor['id'] }}">
                            <tr data-action="0">
                                <td>
                                <div class="avatar av-m"
                                style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.$counsellor['avatar']) }}');">
                                </div>
                                </td>
                                <td>
                                    <p data-id="{{ $counsellor['id'] }}" data-type="user">
                                    {{ strlen($counsellor['first_name']) > 12 ? trim(substr($counsellor['first_name'],0,12)).'..' : $counsellor['first_name'] }}
                                </td>
                            </tr>
                        </table>
                    @endif
                @endforeach
            @endif

               
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
                    <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                    <a href="/home"><i class="fas fa-home"></i></a>
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
                <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <p>
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </p>
                </div>
            </div>
            {{-- Send Message Form --}}
            @include('Chatify::layouts.sendForm')
        </div>
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    <div class="messenger-infoView app-scroll">
        {{-- nav actions --}}
        <nav>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        <div class="avatar1 av-l upload-avatar-preview" style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.Auth::user()->avatar) }}');"></div>
            <p class="info-name">{{Auth::user()->first_name}}</p>
            <div class="messenger-infoView-btns">
                <a href="#" class="default"><i class="fas fa-camera"></i> default</a>
                <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>
            </div>
            {{-- shared photos --}}
            <div class="messenger-infoView-shared">
                <p class="messenger-title">shared photos</p>
                <div class="shared-photos-list"></div>
            </div>
        </div>
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')

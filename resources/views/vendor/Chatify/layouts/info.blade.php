{{-- user info and avatar --}}
<div class="avatar av-l upload-avatar-preview" style="background-image: url('{{ asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user1->avatar) }}');"></div>
<p class="info-name">user1</p>
<div class="messenger-infoView-btns">
    <a href="#" class="default"><i class="fas fa-camera"></i> default</a>
    <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> Delete Conversation</a>
</div>
{{-- shared photos --}}
<div class="messenger-infoView-shared">
    <p class="messenger-title">shared photos</p>
    <div class="shared-photos-list"></div>
</div>
<div class="actionBox" style="width:90%; margin-top:2em;">
    <ul id="commentList" style="list-style-type: none;">
        <li></li>
        @foreach($show_comments as $comment)
        <li>
            <div class="commenterImage">
              <img src="{{ asset($comment->user->avatar_url) }}" />
            </div>
            <div class="commentText">
                <b style="color:#8b9dc3"> {{ $comment->user->name }} </b>
                <p class="">{{ nl2br($comment->content) }}</p> <span class="date sub-text">{{ViewHelper::time_elapsed_string($comment->created_at)}} ago</span>

            </div>
            <hr>
        </li>
        @endforeach
    </ul>
</div>

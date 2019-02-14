<div onclick="toggleLike({{$event->id}}, $(this));" style="cursor: pointer;" data-liked="{{$event->hasLiked(Auth::id()) ? 'true' : 'false'}}" data-likes="{{$event->userLikes()->count()}}">
    @if($event->hasLiked(Auth::User()->id))
    <img src="https://img.icons8.com/material/24/000000/like.png" alt="dislike">
    @else
    <img src="https://img.icons8.com/material-outlined/24/000000/hearts.png" alt="like">
    @endif
    <span class="likes1">{{count($event->userLikes)}}</span>
</div>
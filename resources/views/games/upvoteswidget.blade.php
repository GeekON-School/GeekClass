<style scoped>
            .icon
        {
            padding: 0 10px;
            color: #444;
        }
        a:hover
        {
            text-decoration: none;
        }
        .upvoted
        {
            color: green;
        }
        .downvoted
        {
            color: crimson;
        }
</style>
<span> Голосов:</span>
<a href="{{$game->hasUpvoted(\Auth::id())?'#':'/insider/games/'.$game->id.'/upvote'}}">
    <i class="icon ion-chevron-up {{$game->hasUpvoted(\Auth::id())?'upvoted':''}}"></i>
</a>
{!! $game->upvotes() > 0 ? ('<span class="text-success">'.$game->upvotes().'</span>') : ($game->upvotes() == 0 ? '<span class="text-secondary">'.$game->upvotes().'</span>' : '<span class="text-danger">'.$game->upvotes().'</span>') !!}
<a href="/insider/games/{{$game->id}}/downvote">
    <i class="icon ion-chevron-down {{$game->hasDownvoted(\Auth::id())?'downvoted':''}}"></i>
</a>
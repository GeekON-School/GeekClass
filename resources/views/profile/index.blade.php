@extends('layouts.full')

@section('content')
<div class="row" style="margin-top: 0;margin-left: 0;margin-right: 0;">
    @foreach($users->sortByDesc(function ($user) {return $user->score();}) as $user)
    @if (!$user->is_hidden)
    <div class="col-md-2 col-sm-3 col-6 col-lg-2 col-xl-2" style="margin: 0; padding: 0;">

        <div class="card bg-dark text-white" style="margin: 0; box-shadow: 0;">
            @if ($user->image!=null)
            <img src="{{url('/media/'.$user->image)}}" class="card-img" alt="..."
                style="border-radius: 0; object-fit: cover;">
            @else
            <img src="http://api.adorable.io/avatars/256/{{$user->id}}" class="card-img" alt="..."
            style="border-radius: 0; object-fit: cover;">

            @endif
            <div class="card-img-overlay" style="height: 12rem;">

                <h5 class="card-title"><a style="color:white !important; background-color: #0A6187;"
                        href="{{url('/insider/profile/'.$user->id)}}">{{$user->name}}</a></h5>
                <p class="card-text"><a tabindex="0" data-toggle="popover" data-trigger="focus" title="Ранги"
                        data-html="true" data-content="{{\App\Rank::getRanksListHTML($user->rank())}}"><span
                            style="font-size: 15px;" class="badge badge-pill badge-success"><i
                                class="icon ion-ios-arrow-up"></i> {{$user->rank()->name}}</span></a>
                    <br>

                    @if ($user->is_trainee)
                    <span class="badge badge-pill badge-info">Стажер</span>
                    @endif
                    @if ($user->is_teacher)
                    <span class="badge badge-pill badge-info">Преподаватель</span>
                    @endif</p>

            </div>


        </div>

    </div>
    @endif
    @endforeach
</div>

<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    });
    $('.popover-dismiss').popover({
        trigger: 'focus'
    });
</script>
@endsection
@extends('layouts.app')

@section('title')
    GeekClass
@endsection

@section('content')
    <div class="row" style="margin-top: 15px;">
        <div class="col">
            <h2> Магазин</h2>
        </div>
        <div class="col">
            @if ($user->role=='teacher')
                <a class="float-right btn btn-success btn-sm" href="{{url('/insider/market/create/')}}"><i
                            class="icon ion-plus-round"></i>&nbsp;Добавить товар</a>
            @endif
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="card-deck">

            @foreach($goods as $good)
                <div class="card"
                     style="min-width: 280px; max-width: 350px; background-size: cover;">
                    @if ($good->image != null)
                        <img class="card-img-top" src="{{$good->image}}" style="max-width: 335px;"/>
                    @endif

                    <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                        @if ($good->number > 0)
                            <p><span class="badge badge-success">В наличии: {{$good->number}}x</span></p>
                        @else
                            <p><span class="badge badge-danger">Закончился</span></p>
                        @endif
                        <h5 style="margin-top: 15px; font-weight: 300;"
                            class="card-title">{{$good->name}} @if ($user->role=='teacher') <span class="float-right"><a
                                        href="{{url('/insider/market/'.$good->id.'/edit')}}"
                                        class="btn btn-primary btn-sm"><i
                                            class="icon ion-android-create"></i></a></span> @endif </h5>
                        <p class="card-text" style="font-size: 0.8rem;">{{$good->description}}</p>

                        @if ($good->number > 0 and $good->price <= $user->balance())
                            <a href="{{url('/insider/market/'.$good->id.'/buy')}}" class="btn btn-primary">Купить за {{$good->price}} <img style="height: 20px;" src="https://png.icons8.com/color/50/000000/coins.png" /></a>
                        @else
                            <a href="#" class="disabled btn btn-primary">Купить за {{$good->price}} <img style="height: 20px;" src="https://png.icons8.com/color/50/000000/coins.png" /></a>
                        @endif



                    </div>

                </div>
            @endforeach
        </div>

    </div>
    @if ($user->role=='teacher')

        <div class="row" style="margin-top: 15px;">
            <div class="col">
                <h2> Активные заказы</h2>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="card-deck">

                @foreach($active_orders as $order)
                    <div class="card"
                         style="min-width: 280px; background-size: cover;">

                        <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                            <h5 style="margin-top: 15px; font-weight: 300;"
                                class="card-title">{{$order->good->name}} <span class="float-right"><a
                                            href="{{url('/insider/market/ship/'.$order->id)}}"
                                            class="btn btn-primary btn-sm">Доставлено</a></span></h5>
                            <p class="card-text" style="font-size: 0.8rem;">{{$order->user->name}}</p>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

        <div class="row" style="margin-top: 15px;">
            <div class="col">
                <h2> Архив</h2>
            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            <div class="card-deck">

                @foreach($archive as $good)
                    <div class="card"
                         style="min-width: 280px; background-size: cover;">

                        <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                        <div class="card-body" style="background-color: rgba(255,255,255,0.9);">
                            @if ($good->image != null)
                                <img src="{{$good->image}}" style="margin-top: 15px; max-width: 200px;"/>
                            @endif
                            <h5 style="margin-top: 15px; font-weight: 300;"
                                class="card-title">{{$good->name}} <span class="float-right"><a
                                            href="{{url('/insider/market/'.$good->id.'/edit')}}"
                                            class="btn btn-primary btn-sm"><i
                                                class="icon ion-android-create"></i></a></span></h5>
                            <p class="card-text" style="font-size: 0.8rem;">{{$good->description}}</p>
                            <p><span class="badge badge-default">Снят с продажи</span></p>




                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    @endif



@endsection

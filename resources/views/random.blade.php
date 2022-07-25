@extends('layout')
<div class="container">

    <div class="row row-conformity row-centered">
        <div class="card" style="max-width:40rem; ">
            <img src="{{request()->getSchemeAndHttpHost()}}/storage/{{$image->image}}"  class="img-fluid" alt="{{$image->color_name}}">
            <div class="card-body">
                <h5 class="card-title">{{$image->color_name}}</h5>
            </div>
        </div>
    </div>
</div>


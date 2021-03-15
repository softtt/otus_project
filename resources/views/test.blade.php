@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                   {{$data->firstname . ' ' . $data->lastname}}
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-sub-header">
                        <h3 class="page-title">Welcome {{auth()->user()->name}}</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Admin</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.partials.admin.statistics')

        @include('dashboard.partials.admin.analysis')

        @include('dashboard.partials.admin.latest')

        @livewire('calendar.calendar')


        @include('dashboard.partials.admin.social')




    </div>



</div>


<footer>
    <p>Copyright © 2022 Dreamguys.</p>
</footer>
</div>
@endsection
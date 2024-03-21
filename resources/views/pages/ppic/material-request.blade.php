@extends('layouts.master')

@section('header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Material Request
                    </h2>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('ppic.material-request')
@endsection

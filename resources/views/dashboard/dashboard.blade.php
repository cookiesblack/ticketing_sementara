@extends('layout.template')

@section('content')
    <div class="content">
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            @include('dashboard.buttonMenu')
            <!-- END Row #1 -->
        </div>
        <!-- Bars Chart -->
        <div class="block" hidden>
            <div class="block-header block-header-default">
                <h3 class="block-title">Schema Ticketing</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                        data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full text-center">
                <!-- Bars Chart Container -->
                <canvas id="chart-area"></canvas>
            </div>
        </div>
        <!-- END Bars Chart -->
        <!-- END Bars -->

        

        <!-- END Table Sections -->
    </div>
\
@endsection

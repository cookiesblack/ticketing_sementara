@extends('layout.template')

@section('content')

    <div class="content">
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            @include('dashboard.buttonMenu')
            <!-- END Row #1 -->
        </div>
        <!-- END Bars -->
        <div class="row">
            <div class="col-md-12">

                <!-- Simple Line Icons -->
                <div class="block" id="inputdata">
                    <div class="block-header block-header-default">
                        
                        <h3 class="block-title"><button onclick="Codebase.blocks('#inputdata', 'content_toggle');">Entry
                                Data</button></h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-toggle="block-option"
                                data-action="content_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content">
                        {{ Form::open(['url' => route($post), 'files' => true]) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block">
                                    <table class="js-table-sections table table-hover">
                                        <tbody>
                                            @php
                                                $kolomTanggal = ['start', 'end', 'post_date'];
                                                // $kolomImage = ['gambar'];
                                            @endphp
                                            @foreach ($kolomTable as $key => $item)
                                                <tr>
                                                    {{-- <th>{{ strtoupper($item) }}</th> --}}
                                                    <th>{{ $kolomCaption[$key] }}</th>
                                                    <td class="font-w600">
                                                        @if ($item == $image)
                                                            <input type="file" name="{{ $item }}"
                                                                id="{{ $item }}">
                                                        @elseif (in_array($item, $kolomTanggal))
                                                            <input required class="form-control block" type="date"
                                                                name="{{ $item }}">
                                                        @elseif ($item == 'post_content')
                                                            <textarea required class="form-control block" name="{{ $item }}" id="{{ $item }}" cols="30"
                                                                rows="10"></textarea>
                                                        @else
                                                            <input required class="form-control block" type="text"
                                                                name="{{ $item }}">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="block">
                                    <button type="submit" class="btn btn-primary btn-block text-white">Tambah</button>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <code>Daftar</code>
                        </h3>
                    </div>
                    <div class="block-content" style="overflow-x:auto;">
                        {{-- <table class="table table-bordered table-striped table-vcenter js-dataTable-full"> --}}
                        <div style="overflow-x:auto;">
                            <table class="js-table-sections table table-hover  table-vcenter js-dataTable-full">
                                <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-center">No</th>

                                        @foreach ($kolomTable as $key => $itemName)
                                            <th style="width: 25%">{{ $kolomCaption[$key] }}</th>
                                        @endforeach
                                        <th style="width: 5%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            @foreach ($kolomTable as $itemName)
                                                @if ($itemName == $image)
                                                    <td class="text-left"><a target="_blank"
                                                            href="{{ asset('') . $item->$itemName }}"><img loading="lazy"
                                                                style="max-width:200px"
                                                                src="{{ asset('') . $item->$itemName }}"
                                                                alt="{{ $item->$itemName }}"></a></td>
                                                @else
                                                    @php
                                                        $kolomTanggal = ['start', 'end', 'post_date'];
                                                    @endphp
                                                    @if (in_array($itemName, $kolomTanggal))
                                                        <td class="text-left">
                                                            {{ date('d M Y', strtotime($item->$itemName)) }}</td>
                                                    @else
                                                        <td class="text-left">{{ $item->$itemName }}</td>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td class="text-center"><a style="color: red"
                                                    onclick="return confirm('Yakin akan menghapus data ini?');"
                                                    href="{{ route($delete, $item->id) }}"><i class="fa fa-trash"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- END Table Sections -->
    </div>


@endsection

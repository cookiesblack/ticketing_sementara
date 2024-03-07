@extends('layout.template')

@section('content')
    <div class="content">
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            {{-- @include('dashboard.buttonMenu') --}}
            <!-- END Row #1 -->
        </div>
        <!-- END Bars -->
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <code>{{ $subtitle }}</code>
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
                                        <th style="width: 5%" class="text-center">#</th>
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
                                                        $kolomTanggal = ['created_at'];
                                                    @endphp
                                                    @if (in_array($itemName, $kolomTanggal))
                                                        <td class="text-left">
                                                            {{ date('d F Y', strtotime($item->$itemName)) }}</td>
                                                    @else
                                                        <td class="text-left">{{ $item->$itemName }}</td>
                                                    @endif
                                                @endif
                                            @endforeach
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-danger text-white"
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

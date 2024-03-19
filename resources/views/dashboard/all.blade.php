@extends('layout.template-new')
@php
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
@endphp
@section('content')
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="row invisible" data-toggle="appear">
                <!-- Row #1 -->
                {{-- @include('dashboard.buttonMenu') --}}
                <!-- END Row #1 -->
            </div>
            <!-- END Bars -->
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="d-flex justify-content-between block-header block-header-default my-2">
                            <h3 class="block-title">
                                <code>{{ $subtitle }}</code>
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </h3>
                            <a href="{{ route('create_ticket') }}" class="btn btn-rounded btn-primary">+ Create</a>
                        </div>
                        <div class="block-content" style="overflow-x:auto;">
                            {{-- <table class="table table-bordered table-striped table-vcenter js-dataTable-full"> --}}
                            <div style="overflow-x:auto;">
                                <table class="js-table-sections table table-hover  table-vcenter js-dataTable-full">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%" class="text-center">No</th>

                                            @foreach ($kolomTable as $key => $itemName)
                                                <th>{{ $kolomCaption[$key] }}</th>
                                            @endforeach
                                            <th style="width: 100px" class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            <tr>
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                @foreach ($kolomTable as $itemName)
                                                    @if ($itemName == $image)
                                                        <td class="text-left"><a target="_blank"
                                                                href="{{ asset('') . $item->$itemName }}"><img
                                                                    loading="lazy" style="max-width:200px"
                                                                    src="{{ asset('') . $item->$itemName }}"
                                                                    alt="{{ $item->$itemName }}"></a></td>
                                                    @else
                                                        @php
                                                            $kolomTanggal = ['created_at'];
                                                        @endphp
                                                        @if (in_array($itemName, $kolomTanggal))
                                                            <td class="text-left">
                                                                {{ date('Y-m-d H:i', strtotime($item->$itemName)) }}</td>
                                                        @elseif ($itemName == 'subject')
                                                            <td class="text-left">
                                                                <a
                                                                    href="{{ route('reply', $item->id) }}">{{ $item->subject }}</a>
                                                            </td>
                                                        @elseif ($itemName == 'status')
                                                            <td class="text-left">
                                                                <span class="badge badge-info">{{ $item->status }}</span>
                                                            </td>
                                                        @elseif ($itemName == 'assigned')
                                                            <td class="text-left">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-outline-primary btn-xs">{{ $item->assigned }}</a>
                                                            </td>
                                                        @elseif ($itemName == 'last_reply')
                                                            @if ($item->$itemName != null)
                                                                <td class="text-center">
                                                                    {{ time_elapsed_string($item->$itemName) }}
                                                                </td>
                                                            @else
                                                                <td class="text-center">-
                                                                </td>
                                                            @endif
                                                        @else
                                                            <td class="text-left">{{ $item->$itemName }}</td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('reply', $item->id) }}"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fa fa-reply"></i></a>
                                                        <a href="{{ route($delete, $item->id) }}"
                                                            onclick="return confirm('Yakin akan menghapus data ini?');"
                                                            class="btn btn-danger shadow btn-xs sharp"><i
                                                                class="fa fa-trash"></i></a>
                                                    </div>

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
    </div>
@endsection

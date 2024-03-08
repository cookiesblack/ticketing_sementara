@extends('layout.template-new')

@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row invisible" data-toggle="appear">
            <!-- Row #1 -->
            {{-- @include('dashboard.buttonMenu') --}}
            <!-- END Row #1 -->
        </div>
        <!-- END Bars -->
        <div class="row">
            <div class="col-md-12">

                <!-- Simple Line Icons -->
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Create a Ticket</h3>
                        <div class="block-options">
                        </div>
                    </div>
                    <div class="block-content">
                        {{ Form::open(['url' => route($post), 'files' => true]) }}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="block">
                                    <table class="table table-hover table-borderless">
                                        <tbody>
                                            @php
                                                $kolomTanggal = ['created_at'];
                                            @endphp
                                            @foreach ($kolomTable as $key => $item)
                                                <tr>
                                                    {{-- <th>{{ strtoupper($item) }}</th> --}}
                                                    <th class="d-none d-sm-block" style="max-width:80px">
                                                        {{ $kolomCaption[$key] }}</th>
                                                    <td class="font-w600">
                                                        @if ($item == 'attachment')
                                                            <input type="file" name="{{ $item }}"
                                                                id="{{ $item }}">
                                                        @elseif (in_array($item, $kolomTanggal))
                                                            <input required class="form-control block" type="date"
                                                                name="{{ $item }}">
                                                        @elseif ($item == 'id_category')
                                                            <select required class="form-control block"
                                                                name="{{ $item }}" id="{{ $item }}">
                                                                @foreach ($category as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif ($item == 'id_assign')
                                                            <select required class="form-control block"
                                                                name="{{ $item }}" id="{{ $item }}">
                                                                @foreach ($assign as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->fullname }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif ($item == 'priority')
                                                            <select required class="form-control block"
                                                                name="{{ $item }}" id="{{ $item }}">
                                                                <option value="low">Low</option>
                                                                <option value="medium">Medium</option>
                                                                <option value="high">High</option>
                                                                <option value="Urgent">Urgent</option>
                                                            </select>
                                                        @elseif ($item == 'description')
                                                            <textarea required id="ckeditor" class="form-control block" name="{{ $item }}" id="{{ $item }}"
                                                                cols="30" rows="10"></textarea>
                                                        @else
                                                            <input required class="form-control block" type="text"
                                                                placeholder="{{ $kolomCaption[$key] }}"
                                                                name="{{ $item }}">
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="submit"
                                                        class="btn btn-primary text-white">Submit</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="block">

                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- END Table Sections -->
    </div>
@endsection

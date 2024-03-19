@extends('layout.template-new')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="block">
            <div class="block-header block-header-default mb-2">
                <h3 class="block-title">{{ $ticket[0]->subject }} [{{ $ticket[0]->status }}] - {{ $ticket[0]->uniq_id }}</h3>
                <div class="block-options">
                    <a class="btn btn-rounded btn-primary" href="{{ route('all_ticket') }}">
                        <i class="fa fa-reply"></i> Back
                    </a>
                </div>
            </div>
            <div class="block-content">
                <!-- Discussion -->
                <table class="table table-borderless">
                    <tbody>
                        <tr class="table-active">
                            <td class="d-none d-sm-table-cell"></td>
                            <td class="font-size-sm text-muted">
                                Requested by <a href="be_pages_generic_profile.html"> {{ $ticket[0]->user }}</a> on
                                <em>{{ $ticket[0]->created_at }}</em>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                <div class="mb-10">
                                    <a href="be_pages_generic_profile.html">
                                        <img class="img-avatar" src="{{ asset('assets') }}/media/avatars/avatar6.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <small>{{ $ticket[0]->category }}<br>{{ $ticket[0]->priority }}</small>
                            </td>
                            <td>
                                <p><?= $ticket[0]->description ?></p>
                                <hr>
                                <p class="font-size-sm text-muted">Attachment : @if ($ticket[0]->attachment)
                                        <a target="_blank"
                                            href="{{ url('upload_manual') . '/' . $ticket[0]->attachment }}">{{ $ticket[0]->attachment }}</a>
                                </p>
                            @else
                                <i>no attachment</i>
                                @endif
                            </td>
                        </tr>
                        @foreach ($replay as $item)
                            <tr class="table-active">
                                <td class="d-none d-sm-table-cell"></td>
                                <td class="font-size-sm text-muted">
                                    Reply by <a href="be_pages_generic_profile.html">{{ $item->user }}</a> on
                                    <em>{{ $item->created_at }}
                                        10:09</em>
                                </td>
                            </tr>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center" style="width: 140px;">
                                    <div class="mb-10">
                                        <a href="be_pages_generic_profile.html">
                                            <img class="img-avatar" src="{{ asset('assets') }}/media/avatars/avatar9.jpg"
                                                alt="">
                                        </a>
                                    </div>

                                </td>
                                <td>
                                    <p><?= $item->reply ?></p>
                                    <hr>
                                    <p class="font-size-sm text-muted"></p>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="table-active" id="forum-reply-form">
                            <td class="d-none d-sm-table-cell"></td>
                            <td class="font-size-sm text-muted">
                                <a href="be_pages_generic_profile.html">Reply as {{ session('fullname') }}</a> Just now
                            </td>
                        </tr>
                        <tr>
                            <td class="d-none d-sm-table-cell text-center">


                            </td>
                            <td>
                                {{ Form::open(['url' => route($post), 'files' => true]) }}
                                <div class="form-group row">
                                    <div class="col-12">
                                        <!-- CKEditor (js-ckeditor id is initialized in Helpers.ckeditor()) -->
                                        <!-- For more info and examples you can check out http://ckeditor.com -->
                                        <textarea required id="js-ckeditor" name="reply" class="form-control"></textarea>
                                        <input required hidden type="text" name="id_ticket" value="{{ $id_ticket }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-rounded btn-primary">
                                        <i class="fa fa-paper-plane"></i> Send
                                    </button>

                                </div>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Discussion -->
            </div>
        </div>
    </div>
    <!-- END Page Content -->
@endsection

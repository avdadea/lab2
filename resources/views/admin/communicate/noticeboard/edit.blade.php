@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ url('public/plugins/select2/css/select2.min.css') }}">

<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-selection__rendered {
        line-height: 36px !important;
    }
    .select2-selection {
        height: 38px !important;
    }
    .select2-selection__arrow {
        height: 38px !important;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Notice Board</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form method="post" action="">
                            {{ csrf_field() }}

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user">Select User</label>
                                    <select id="user" name="user" class="form-control select2" required>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == old('user', $selectedUser) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $getRecord->title }}" required placeholder="Title">
                                </div>
                                <div class="form-group">
                                    <label>Notice Date</label>
                                    <input type="date" class="form-control" value="{{ $getRecord->notice_date }}" name="notice_date" required>
                                </div>
               
                                @php
                                $message_to_student = $getRecord->getMessageToSingle($getRecord->id, 3);
                                $message_to_parent = $getRecord->getMessageToSingle($getRecord->id, 4);
                                $message_to_teacher = $getRecord->getMessageToSingle($getRecord->id, 2);
                                @endphp

                                <div class="form-group">
                                    <label style="display: block;">Message To</label>
                                    <label style="margin-right: 50px;">
                                        <input {{ !empty($message_to_student) ? 'checked' : '' }} type="checkbox" value="3" name="message_to[]">
                                        Student
                                    </label>

                                    <label style="margin-right: 50px;">
                                        <input {{ !empty($message_to_parent) ? 'checked' : '' }} type="checkbox" value="4" name="message_to[]">
                                        Parent
                                    </label>

                                    <label>
                                        <input {{ !empty($message_to_teacher) ? 'checked' : '' }} type="checkbox" value="2" name="message_to[]">
                                        Teacher
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea id="compose-textarea" name="message" class="form-control" style="height: 300px">{{ $getRecord->message }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ url('public/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ url('public/plugins/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $(function () {
        // Initialize select2
        $('.select2').select2();

        // Initialize summernote
        $('#compose-textarea').summernote({
            height: 200,
        });
    });
</script>
@endsection

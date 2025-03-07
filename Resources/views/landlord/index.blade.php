@extends(route_prefix().'admin.admin-master')
@section('title') {{__('View Agents')}} @endsection

@section('style')
    <x-media-upload.css/>
    <x-datatable.css/>
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-error-msg/>
                        <x-flash-msg/>
                        <h4 class="header-title mb-4">{{__('All Agents')}}</h4>
                        <div class="table-wrap recent_order_logs">
                            <table class="table table-default table-striped table-bordered">
                                <thead class="text-white" style="background-color: #b66dff">
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Phone')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_user as $data)
                                    <tr>
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>
                                            @php
                                            $img = get_attachment_image_by_id($data->image,null,true);
                                            @endphp
                                            @if (!empty($img))
                                                <div class="attachment-preview">
                                                    <div class="thumbnail">
                                                        <div class="centered">
                                                            <img class="avatar user-thumb" src="{{$img['img_url']}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                @php  $img_url = $img['img_url']; @endphp
                                            @endif
                                        </td>
                                        <td>{{ $data->email }}</td>
                                        <td>{{ $data->mobile }}</td>
                                        <td>
                                            <x-delete-popover :url="route('landlord.admin.agent.delete',$data->id)"/>
                                            <a href="{{route('landlord.admin.agent.edit',$data->id)}}" class="btn btn-lg btn-primary btn-sm mb-3 mr-1 user_edit_btn">
                                                <i class="las la-edit"></i>
                                            </a>
                                            <a href="#"
                                               data-id="{{$data->id}}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#user_change_password_modal"
                                               class="btn btn-lg btn-info btn-sm mb-3 mr-1 user_change_password_btn">
                                                {{__("Change Password")}}
                                            </a>
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
    </div>

    <div class="modal fade" id="user_change_password_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Change Agent Password')}}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal"><span>×</span></button>
                </div>
                <x-error-msg/>
                <form action="{{route('landlord.agent.password.change')}}" id="user_password_change_modal_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ch_user_id" id="ch_user_id">
                        <div class="form-group">
                            <label for="password">{{__('Password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{__('Enter Password')}}">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{__('Confirm Password')}}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{__('Confirm Password')}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Change Password')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-media-upload.markup/>
@endsection
@section('scripts')
    <!-- Start datatable js -->
    <x-datatable.js/>
   <x-media-upload.js/>
    <script>
    (function($){
    "use strict";
    $(document).ready(function() {
        $(document).on('click','.user_change_password_btn',function(e){
            e.preventDefault();
            var el = $(this);
            var form = $('#user_password_change_modal_form');
            form.find('#ch_user_id').val(el.data('id'));
        });
        $('#all_user_table').DataTable( {
            "order": [[ 0, "desc" ]]
        } );

    } );

    })(jQuery);
    </script>
@endsection

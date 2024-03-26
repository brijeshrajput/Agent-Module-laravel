@extends(route_prefix().'admin.admin-master')
@section('title')
    {{__('Edit Agent')}}
@endsection
@section('style')
   <x-media-upload.css/>
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                       <div class="header-wrap d-flex justify-content-between mb-4">
                           <h4 class="header-title mb-4">{{__('Edit Agent')}}</h4>
                           <div class="btn-wrapper">
                               <a class="btn btn-secondary" href="{{route('landlord.admin.agent.view')}}">{{__("All Agents")}}</a>
                           </div>
                       </div>
                        <x-error-msg/>
                        <x-flash-msg/>
                        <form action="{{route('landlord.admin.agent.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="agent_id" value="{{$agent->id}}">
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control"  value="{{$agent->name}}" name="name" placeholder="{{__('Enter name')}}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{__('Email')}}</label>
                                <input type="text" class="form-control"  value="{{$agent->email}}" name="email" placeholder="{{__('Email')}}">
                            </div>

                                 <div class="form-group">
                                <label for="email">{{__('Mobile')}}</label>
                                <input type="text" class="form-control"  value="{{$agent->mobile}}" name="mobile" placeholder="{{__('Mobile')}}">
                            </div>

                            
                            <div class="form-group">
                                <label for="site_favicon">{{__('Image')}}</label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @php
                                            $image = get_attachment_image_by_id($agent->image,null,true);
                                            $image_btn_label = __( 'Upload Image');
                                        @endphp
                                        @if (!empty($image))
                                            <div class="attachment-preview">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img class="avatar user-thumb" src="{{$image['img_url']}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $image_btn_label = __('Change Image'); @endphp
                                        @endif
                                    </div>
                                    <input type="hidden" id="image" name="image" value="{{$agent->image}}">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="{{__('Select Image')}}" data-modaltitle="{{__('Upload Image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__($image_btn_label)}}
                                    </button>
                                </div>
                                <small class="form-text text-muted">{{__('allowed image format: jpg,jpeg,png')}}</small>
                            </div>
                            <button id="update" type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <x-media-upload.markup/>

@endsection
@section('scripts')
<x-media-upload.js/>
@endsection

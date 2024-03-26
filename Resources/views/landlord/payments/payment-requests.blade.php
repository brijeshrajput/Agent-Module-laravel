@extends('landlord.admin.admin-master')
@section('title') {{__('Agent Payment Requests')}} @endsection

@section('style')
    <x-datatable.css/>
    <x-summernote.css/>
@endsection

@section('title')
    {{__('Agent Payment Requests')}}
@endsection

@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <x-error-msg/>
                        <x-flash-msg/>
                        <h4 class="header-title mb-4">{{__('All Requests')}}</h4>
                       <div class="d-flex flex-wrap justify-content-between">
                           
                           <div class="filter-order-wrapper">
                               <div class="select-box-wrap mt-3">
                                   <select name="filter_order" id="filter_order">
                                       <option value="all">{{{__('All Order')}}}</option>
                                       <option
                                           value="pending" {{request()->filter == 'pending' ? 'selected' : ''}}>{{{__('Pending')}}}</option>
                                       <option
                                           value="in_progress" {{request()->filter == 'in_progress' ? 'selected' : ''}}>{{{__('In Progress')}}}</option>
                                       <option
                                           value="cancel" {{request()->filter == 'cancel' ? 'selected' : ''}}>{{{__('Cancel')}}}</option>
                                       <option
                                           value="complete" {{request()->filter == 'complete' ? 'selected' : ''}}>{{{__('Complete')}}}</option>
                                   </select>
                                   <button class="btn btn-primary btn-sm" id="filter_btn">{{__('Filter')}}</button>
                               </div>
                           </div>
                       </div>

                        <div class="table-wrap table-responsive">
                            <table class="table table-default table-striped table-bordered">
                                <thead class="text-white" style="background-color: #b66dff">
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Agent Name')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th>{{__('Message')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created At')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($all_requests as $data)
                                    <tr>
                                        <td>{{$data->id}}</td>
                                        <td>{{ $data->agent->name }}</td>
                                        <td>{{amount_with_currency_symbol($data->amount)}}</td>
                                        <td>{{$data->message}}</td>
                                        <td>
                                            <div>
                                                @if($data->status == 0)
                                                    <span class="alert alert-warning text-capitalize">{{ __('Pending') }}</span>
                                                @elseif($data->status == 1)
                                                    <span class="alert alert-success text-capitalize">{{__('Approved')}}</span>
                                                @elseif($data->status == 2)
                                                <span class="alert alert-danger text-capitalize">{{ __('Rejected') }}</span>
                                                @endif
                                            </div>

                                            @if($data->viewed == 2)
                                                
                                                    <div class="mt-3">
                                                        <small>{{__('This request is already viewed')}}</small>
                                                    </div>
                                                
                                            @endif
                                        </td>

                                        <td>{{date('d-m-Y',strtotime($data->updated_at))}}</td>
                                        
                                        <td>
                                            @if($data->status == 0)
                                            <a href="javascript:void(0);"
                                               class="btn btn-lg btn-info btn-sm mb-3 mr-1 agent_pay_btn" data-agid="{{ $data->id }}">
                                                <i class="las la-money-bill"></i>
                                            </a>
                                            @else
                                            <a href="javascript:void(0);" onclick="alert('Already Paid')" class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn">
                                                <i class="las la-eye"></i>
                                            </a>
                                            @endif
                                            {{-- <a href="" class="btn btn-lg btn-primary btn-sm mb-3 mr-1 view_order_details_btn">
                                                <i class="las la-eye"></i>
                                            </a> --}}
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

   <div class="modal" tabindex="-1" id="agent_payment_modal">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
  </div>


@endsection

@section('scripts')
    <x-datatable.js/>
    
    <x-summernote.js/>
    <script>
        (function($){
        "use strict";
        $(document).ready(function() {
            $(document).on('click','.order_status_change_btn',function(e){
                e.preventDefault();
                var el = $(this);
                var form = $('#order_status_change_modal');
                form.find('#order_id').val(el.data('id'));
                form.find('#order_status option[value="'+el.data('status')+'"]').attr('selected',true);
            });
            $('#all_user_table').DataTable( {
                "order": [[ 1, "desc" ]],
                'columnDefs' : [{
                    'targets' : 'no-sort',
                    'orderable' : false
                }]
            } );
            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            $(document).on('click', '#filter_btn', function () {
                let type = $('#filter_order').val();

                location.href = '{{route('landlord.admin.package.order.manage.all').'?filter='}}' + type;
            });
        });
        })(jQuery);


        //ajax agent payment modal
        $(document).on('click','.agent_pay_btn', function(e){
            e.preventDefault();
            var el = $(this);
            var id = el.data('agid');
            var url = '{{route('landlord.admin.agent.payments.request.modal')}}';
            $.ajax({
                url:url,
                type:"POST",
                data:{
                    id:id,
                    _token:'{{csrf_token()}}'
                },
                success:function(data){
                    $('#agent_payment_modal .modal-content').html(data);
                    $('#agent_payment_modal').modal('show');
                }
            });
        });
    </script>

@endsection


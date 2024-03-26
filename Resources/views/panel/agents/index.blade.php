@extends('agent::layouts.app')

@section('title')
    {{ __('My Referrals') }}
@endsection

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('My Referrals') }}</h1>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                @if($refee!=null)
                    <h5 class="mb-md-0 h6">{{ $refee->name.'\'s Referrals' }} </h5>
                @else
                <h5 class="mb-md-0 h6">{{ __('All Agents') }}</h5>
                @endif
            </div>
            <div class="col-md-4">
                <form class="" id="sort_brands" action="" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ __('Search agent') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="30%">{{ __('Name')}}</th>
                        <th data-breakpoints="md">{{ __('Email')}}</th>
                        <th data-breakpoints="md">{{ __('Phone')}}</th>
                        <th data-breakpoints="md">{{ __('Joined')}}</th>
                        <th data-breakpoints="md">{{ __('Activation')}}</th>
                        <th data-breakpoints="md" class="text-right">{{ __('Options')}}</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($agents) > 0 )
                    @foreach ($agents as $key => $agent)
                        <tr>
                            <td>{{ ($key+1) + ($agents->currentPage() - 1)*$agents->perPage() }}</td>
                            <td>
                                <a href="{{route('landlord.agent.myreferrals', 'ref='.$agent->referral_code)}}" class="text-reset tlinkh">
                                    {{ $agent->name }}
                                </a>
                            </td>
                            <td>
                                @if ($agent->email != null)
                                    {{ $agent->email }}
                                @endif
                            </td>
                            <td>
                                @if ($agent->mobile != null)
                                    {{ $agent->mobile }}
                                @endif
                            </td>
                            <td>{{ $agent->created_at }}</td>
                            
                            <td>
                                    @if ($agent->is_active == 1)
                                        <span class="badge badge-inline badge-success">{{ __('Approved')}}</span>
                                    @else
                                        <span class="badge badge-inline badge-info">{{ __('Pending')}}</span>
                                    @endif
                            </td>
                            
                            <td class="text-right">
		                      <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="javascript:void(0);" onclick="updateData({{ $agent }})" data-toggle="modal" data-target="#agent_view_modal" title="{{ __('View') }}">
		                          <i class="las la-eye"></i>
		                      </a>
                          </td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">{{ __('No data found')}}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $agents->links() }}
          	</div>
        </div>
    </div>

@endsection

@section('modal')
<div class="modal fade" id="agent_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title strong-600 heading-5">{{ __('Agent Information')}}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body px-3 pt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>{{ __('Name')}}</td>
                                        <td id="agent_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Email')}}</td>
                                        <td id="agent_email"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Phone')}}</td>
                                        <td id="agent_phone"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Address')}}</td>
                                        <td id="agent_address"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Joined')}}</td>
                                        <td id="agent_joined"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Status')}}</td>
                                        <td id="agent_status">
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Verified')}}</td>
                                        <td id="agent_balance">
                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
              </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function updateData(data){
            $('#agent_name').html(data.name);
            $('#agent_email').html(data.email);
            $('#agent_phone').html(data.mobile);
            $('#agent_address').html(data.address);
            $('#agent_joined').html(data.created_at);
            if(data.is_active == 1){
                $('#agent_status').html('<span class="badge badge-inline badge-success">{{ __('Approved')}}</span>');
            }else{
                $('#agent_status').html('<span class="badge badge-inline badge-danger">{{ __('Pending')}}</span>');
            }
            if(data.verification_status == 1){
                $('#agent_balance').html('<span class="badge badge-inline badge-success">{{ __('Verifed')}}</span>');
            }else{
                $('#agent_balance').html('<span class="badge badge-inline badge-info">{{ __('Unverified')}}</span>');
            }
        }
        // function update_featured(el){
        //     if(el.checked){
        //         var status = 1;
        //     }
        //     else{
        //         var status = 0;
        //     }
        //     $.post('', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
        //         if(data == 1){
        //             AIZ.plugins.notify('success', '{{ __('Featured agents updated successfully') }}');
        //         }
        //         else{
        //             AIZ.plugins.notify('danger', '{{ __('Something went wrong') }}');
        //             location.reload();
        //         }
        //     });
        // }

        // function update_published(el){
        //     if(el.checked){
        //         var status = 1;
        //     }
        //     else{
        //         var status = 0;
        //     }
        //     $.post('', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
        //         if(data == 1){
        //             AIZ.plugins.notify('success', '{{ __('Published agents updated successfully') }}');
        //         }
        //         else if(data == 2){
        //             AIZ.plugins.notify('danger', '{{ __('Please upgrade your package.') }}');
        //             location.reload();
        //         }
        //         else{
        //             AIZ.plugins.notify('danger', '{{ __('Something went wrong') }}');
        //             location.reload();
        //         }
        //     });
        // }
    </script>
@endsection

@extends('agent::layouts.app')

@section('title')
    {{ __('My Clients') }}
@endsection

@section('panel_content')

    <div class="aiz-titlebar mt-2 mb-4">
      <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ __('My Clients') }}</h1>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ __('All clients') }}</h5>
            </div>
            <div class="col-md-4">
                <form class="" id="sort_brands" action="" method="GET">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" id="search" name="search" @isset($search) value="{{ $search }}" @endisset placeholder="{{ __('Search client') }}">
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
                    @if(count($clients) > 0 )
                    @foreach ($clients as $key => $client)
                        <tr>
                            <td>{{ ($key+1) + ($clients->currentPage() - 1)*$clients->perPage() }}</td>
                            <td>
                                {{ $client->name }}
                            </td>
                            <td>
                                @if ($client->email != null)
                                    {{ $client->email }}
                                @endif
                            </td>
                            <td>
                                @if ($client->mobile != null)
                                    {{ $client->mobile }}
                                @endif
                            </td>
                            <td>{{ $client->created_at }}</td>
                            
                            <td>
                                    @if ($client->email_verified != null)
                                        <span class="badge badge-inline badge-success">{{ __('Approved')}}</span>
                                    @else
                                        <span class="badge badge-inline badge-info">{{ __('Pending')}}</span>
                                    @endif
                            </td>
                            
                            <td class="text-right">
		                      <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="javascript:void(0);" onclick="updateData({{ $client }})" data-toggle="modal" data-target="#client_view_modal" title="{{ __('View') }}">
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
                {{ $clients->links() }}
          	</div>
        </div>
    </div>

@endsection

@section('modal')
<div class="modal fade" id="client_view_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title strong-600 heading-5">{{ __('client Information')}}</h5>
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
                                        <td id="client_name"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Email')}}</td>
                                        <td id="client_email"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Phone')}}</td>
                                        <td id="client_phone"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Address')}}</td>
                                        <td id="client_address"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Joined')}}</td>
                                        <td id="client_joined"></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Status')}}</td>
                                        <td id="client_status">
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Verified')}}</td>
                                        <td id="client_balance">
                                            
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
            $('#client_name').html(data.name);
            $('#client_email').html(data.email);
            $('#client_phone').html(data.mobile);
            $('#client_address').html(data.address);
            $('#client_joined').html(data.created_at);
            if(0){
                $('#client_status').html('<span class="badge badge-inline badge-success">{{ __('Approved')}}</span>');
            }else{
                $('#client_status').html('<span class="badge badge-inline badge-danger">{{ __('Pending')}}</span>');
            }
            if(data.verification_status == 1){
                $('#client_balance').html('<span class="badge badge-inline badge-success">{{ __('Verifed')}}</span>');
            }else{
                $('#client_balance').html('<span class="badge badge-inline badge-info">{{ __('Unverified')}}</span>');
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
        //             AIZ.plugins.notify('success', '{{ __('Featured clients updated successfully') }}');
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
        //             AIZ.plugins.notify('success', '{{ __('Published clients updated successfully') }}');
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

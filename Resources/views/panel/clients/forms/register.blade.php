<div class="resp-errors"></div>
<form class="" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="client-form">
    <div class="row gutters-5">
        <div class="col-lg-8">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{__('Client Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Name*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('Enter Client Name') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Email*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email"
                                placeholder="{{ __('Enter Email') }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Phone*')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="mobile"
                                placeholder="{{ __('Enter Phone') }}" required>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="gender">
                        <label class="col-md-3 col-from-label">{{__('Gender*')}}</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="gender" id="gender"
                                data-live-search="true" required>
                                <option value="Male" selected>{{ __('Male') }}</option>
                                <option value="Female">{{ __('Female') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{__('Password')}}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="password"
                                placeholder="{{ __('It will be shared on client email  (Auto Generated)') }}" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
            

        </div>
        <div class="col-8">
            <div class="mar-all text-right mb-2">
                <button id="client-submit-btn" type="submit" name="button"
                    class="btn btn-primary">{{ __('Create') }}</button>
            </div>
        </div>
    </div>

</form>

<script>
function show_err(msg) {
    $('.resp-errors').append('<div class="alert alert-danger">' + msg + '</div>');
}

// ajax login form submit
$(document).ready(function () {
        $('#client-form').on('submit', function (e) {
            showLoader('Please wait we are processing..');
            e.preventDefault();
            $.ajax({
                url: "{{route('landlord.agent.client.store')}}",
                type: "POST",
                data: $("#client-form").serialize(),
                success: function (response) {
                    if (response.status == 'success' && response.client_id!=null) {
                        showLoader('Registration Success, moving to next step..');
                        var id = parseInt(response.client_id);
                        callform(2, id);
                    } else {
                        let error = response.responseJSON;
                        hideLoader();
                        alert('Error Occured: ' + response.message);
                        for (const property in error.errors) {
                            if (error.errors.hasOwnProperty(property)) {
                                show_err(error.errors[property][0]);
                            }
                        }
                    }
                },
                error: function (response) {
                    let error = response.responseJSON;
                    hideLoader();
                    alert('Error: ' + error.message);
                    for (const property in error.errors) {
                        if (error.errors.hasOwnProperty(property)) {
                            show_err(error.errors[property][0]);
                        }
                    }
                }
            });
        });
    });
</script>
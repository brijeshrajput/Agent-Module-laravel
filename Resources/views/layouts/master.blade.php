<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Module Agent</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ Module::asset('agent:css/agent.css') }}"> --}}

       <link href="{{ global_asset('assets/bvendor/vendors.css') }}" rel="stylesheet">
       <link href="{{ global_asset('assets/bvendor/aiz-seller.css') }}" rel="stylesheet">
       

    </head>
    <body>

        @include('agent::layouts.nav')
        @yield('content')

        {{-- @dd(Module::asset('agent:css')) --}}


        <script src="{{global_asset('assets/bvendor/vendors.js')}}"></script>
        <script src="{{global_asset('assets/bvendor/aiz-core.js')}}"></script>
        
        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/agent.js') }}"></script> --}}
    </body>
</html>

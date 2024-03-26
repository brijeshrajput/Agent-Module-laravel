<div class="theme-section">
    <div class="row">
        <div class="col">
            <h4 class="mb-3">{{__('Themes')}}</h4>
            <span></span>
        </div>
    </div>
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 theme-row mb-5">
        @php
            $theme_list = $order_details?->plan_themes?->pluck('theme_slug')->toArray() ?? [];
            $default_theme = get_static_option('default_theme');
        @endphp

        @foreach(getPricePlanBasedAllThemeData($theme_list) as $theme)
            @php
                $theme_slug = $theme->slug;
                $theme_data = getIndividualThemeDetails($theme_slug);
                $theme_image = loadScreenshot($theme_slug);

                $theme_custom_name = get_static_option_central($theme_data['slug'].'_theme_name');
                $theme_custom_url = get_static_option_central($theme_data['slug'].'_theme_url');
                $theme_custom_image = get_static_option_central($theme_data['slug'].'_theme_image');
            @endphp

            <div class="col" style="position: relative">
                <div class="theme-wrapper {{$default_theme == $theme_slug ? 'selected_theme' : ''}}"
                     data-theme="{{$theme_data['slug']}}" data-name="{{!empty($theme_custom_name) ? $theme_custom_name : $theme_data['name']}}">
                    <div class="theme-wrapper-bg" style="background-image: url({{ !empty($theme_custom_image) ? $theme_custom_image : $theme_image}})"></div>
                    <h4 class="text-center mt-2">{{ !empty($theme_custom_name) ? $theme_custom_name : $theme_data['name']}}</h4>

                    @if($default_theme == $theme_slug)
                        <h4 class="selected_text"><i class="las la-check"></i></h4>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="from-t-container">
        <form action="javascript:void(0)" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="theme_slug" id="theme-slug" value="{{$default_theme}}">
            <div class="col-10">
                <button id="client-theme-btn" type="submit" name="button" class="btn btn-primary">{{ __('Next') }}</button>
            </div>
        </form>
    </div>
</div>

<style>
.theme-wrapper {
    cursor: pointer;
}
.theme-wrapper-bg {
    height: 400px;
    background-position: top center;
    background-repeat: no-repeat;
    background-size: cover;
    transition: all linear 2s;
}
.theme-wrapper:hover .theme-wrapper-bg {
    background-position: bottom center;
}
</style>


    <link rel="stylesheet" href="{{global_asset('assets/common/css/toastr.css')}}">

    <style>
        .from-t-container{
            margin: 5vh;
        }
        .add_new-domain {
            margin-bottom: 10px;
        }

        .add_new-domain i {
            border: 2px solid #00000052;
            padding: 0 20px;
            font-size: 30px;
            border-radius: 5px;
            color: #00000073;
        }

        .payment-gateway-wrapper ul {
            flex-wrap: wrap;
            display: flex;
        }

        .payment-gateway-wrapper ul li {
            max-width: 100px;
            cursor: pointer;
            box-sizing: border-box;
            height: 50px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .payment-gateway-wrapper ul li {
            margin: 3px;
            border: 1px solid #ddd;
        }

        @media only screen and (max-width: 375px) {
            /*.payment-gateway-wrapper ul li {*/
            /*    width: calc(100% / 3);*/
            /*}*/
        }


        .payment-gateway-wrapper ul li.selected:after, .payment-gateway-wrapper ul li.selected:before {
            visibility: visible;
            opacity: 1;
        }

        .payment-gateway-wrapper ul li:before {
            border: 2px solid var(--main-color-one);
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            height: 100%;
            content: '';
            visibility: hidden;
            opacity: 0;
            transition: all .3s;
        }

        .payment-gateway-wrapper ul li.selected:after, .payment-gateway-wrapper ul li.selected:before {
            visibility: visible;
            opacity: 1;
        }

        .payment-gateway-wrapper ul li:after {
            position: absolute;
            right: 0;
            top: 0;
            width: 15px;
            height: 15px;
            background-color: var(--main-color-one);
            content: "\f00c";
            font-weight: 900;
            color: #fff;
            font-family: 'Line Awesome Free';
            font-weight: 900;
            font-size: 10px;
            line-height: 10px;
            text-align: center;
            padding-top: 2px;
            padding-left: 2px;
            visibility: hidden;
            opacity: 0;
            transition: all .3s;
        }

        .plan_warning small {
            font-size: 15px;
        }

        .order-btn:disabled {
            background-color: transparent;
            color: var(--main-color-one);
            border: 2px solid var(--main-color-one);
        }

        .loader.loader_page_single {
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255, .9);
            position: fixed;
            display: none;
        }

        .loader_bottom_title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 80px;
            width: 100%;
            text-align: center;
        }

        .alert_list_inline {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert_list_inline .close {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            color: red;
            font-size: 20px;
            height: 30px;
            width: 30px;
            border: 0;
            outline: none;
        }
        .input-group-text{
            background: #fff;
        }
        .package-description p{
            text-align: justify;
            line-height: 28px;
            padding-inline: 3px;
        }

        .theme-wrapper-bg {
            height: 200px;
        }
        .theme-wrapper {
            border: 1px solid transparent;
            outline: 1px solid transparent;
            padding: 10px;
        }
        .selected_theme {
            transition: 0.5s;
            border-color: var(--main-color-one);
            outline-color: var(--main-color-one);
        }

        .selected_text {
            top: 0;
            left: 11px;
            background-color: var(--main-color-one);
            padding: 10px;
            position: absolute;
            color: white;
            transition: 0.3s;
        }
        .selected_text i {
            font-size: 20px;
        }
    </style>

<script>
$(document).on('click', '.theme-wrapper', function (e) {
    let el = $(this);
    let theme_slug = el.data('theme');

    $('.theme-wrapper').removeClass('selected_theme');
    el.addClass('selected_theme');

    let text = '<h4 class="selected_text"><i class="las la-check"></i></h4>';
    $('.selected_text').remove();
    el.append(text);

    $('input#theme-slug').val(theme_slug);
});

$(document).on('click', '#client-theme-btn', function (e) {
    showLoader("Good Theme choice :).....moving to next step");
    callform(4, {{ $client_id }}, {{ $plan_id }}, $('input#theme-slug').val());
});
</script>

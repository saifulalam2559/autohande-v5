@extends('frontend.layouts.master')
@section('content')



            <!-- slider  -->
            
            @include('frontend.layouts.listimage')
            <!-- end slider  -->



            <section class="flat-title ">
                <div class="container2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-inner style">
                                <div class="title-group fs-12"><a class="home fw-6 text-color-3"
                                        href="index.html">Home</a><span>Used cars for sale</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <form action="{{route('fahrzeug.post.filter')}}" method="post"> 
                @csrf
                
                <input type="hidden" name="sort" id="sort" value="{{ request('sort', '') }}" >

            <section class="listing-grid tf-section3">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="heading-section">
                                <h2> Total Auto ({{$autopost->total()}})</h2>
                                <p class="mt-20">
                                    
                     <div id="applied_filter">
                        <ul style="">
                            <span id="filter" class="btn btn-darkXX" style="background-color:#000; color:#fff;">Ausgewählt Filter</span>
                        </ul>
                    </div>
                                
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-12 flex gap-30 text-start">
                            
                            <div class="sidebar-right-listing style-2">
                                <div class="sidebar-title flex-two flex-wrap">

                                </div>
                                <div class="form-filter-siderbar">
                                  
                                        <div class="wd-find-select">

<!-- =========================================================
     VEHICLE CONDITION FILTER
========================================================= -->

<div class="widget-facet wd-categories">

    <div class="facet-title"
         data-bs-target="#vehicleConditions"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="vehicleConditions">

        <span class="title">Fahrzeugzustand</span>

        <span class="icon icon-arrow-up"></span>

    </div>


    <div id="vehicleConditions" class="collapse show">

        <ul
            class="tf-filter-group current-scrollbar mb_36"
            style="padding-left: 5px;"
        >

            @foreach($vehicleConditions as $condition)

                <div class="form-check">

                    <input
                        class="form-check-input condition-checkbox"
                        type="checkbox"
                        onchange="this.form.submit();"
                        name="condition[]"

                        value="{{ $condition->slug }}"

                        id="condition_{{ $condition->id }}"

                        @checked(
                            in_array(
                                $condition->slug,
                                $filter_condition ?? [],
                                true
                            )
                        )
                    >

                    <label
                        class="form-check-label filter-checkbox-label"
                        for="condition_{{ $condition->id }}"
                    >

                        <span class="filter-label-name">
                            {{ $condition->name }}
                        </span>

                        <span class="filter-count">
                            ({{ $condition->autos->count() }})
                        </span>

                    </label>

                </div>

            @endforeach

        </ul>

    </div>

</div>

<!-- =========================================================
     END VEHICLE CONDITION FILTER
========================================================= -->
<br><br><br>
 <!-- =========================================================
     BRAND FILTER
========================================================= -->

<div class="widget-facet wd-categories">

    <div class="facet-title"
         data-bs-target="#material"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="material">

        <span class="title">Marke</span>

        <span class="icon icon-arrow-up"></span>

    </div>


    <div id="material" class="collapse show">

        <ul class="tf-filter-group current-scrollbar mb_36"
            style="padding-left: 5px;">


            @foreach($brands as $row)

                <div class="form-check">

                    <input
                        class="form-check-input brand-checkbox"
                        type="checkbox"

                        name="brand[]"

                        value="{{ $row->slug }}"

                        id="brand_{{ $row->id }}"

                        data-brand-id="{{ $row->id }}"

                        @checked(
                            in_array(
                                $row->slug,
                                $filter_brand,
                                true
                            )
                        )
                        
                       
                    >


                    <label
                        class="form-check-label filter-checkbox-label"
                        for="brand_{{ $row->id }}"
                    >
                        <span class="filter-label-name">
                            {{ $row->name }}
                        </span>

                        <span class="filter-count">
                            ({{ $row->autoPostWithBrand->count() }})
                        </span>
                    </label>

                </div>

            @endforeach


        </ul>

    </div>

</div>

                                            <br>
<!-- =========================================================
     MODEL FILTER
========================================================= -->

<div id="model-filter" class="widget-facet wd-categories" style="display: none;">

    <div
        class="facet-title"
        data-bs-target="#vehicleModels"
        data-bs-toggle="collapse"
        aria-expanded="true"
        aria-controls="vehicleModels"
    >
        <span class="title">Modell</span>
        <span class="icon icon-arrow-up"></span>
    </div>

    <div id="vehicleModels" class="collapse show">
        <ul class="tf-filter-group current-scrollbar mb_36" style="padding-left: 5px;">

            @foreach($models as $model)

                <li
                    class="model-item"
                    data-brand-id="{{ (string) $model->brand_id }}"
                    style="display: none;"
                >
                    <div class="form-check">
                        <input
                            class="form-check-input model-checkbox"
                            type="checkbox"
                            name="model[]"
                            value="{{ $model->slug }}"
                            id="model_{{ $model->id }}"
                            data-brand-id="{{ (string) $model->brand_id }}"
                            @checked(
                                in_array(
                                    $model->slug,
                                    $filter_model ?? [],
                                    true
                                )
                            )
                        >

                        <label
                            class="form-check-label filter-checkbox-label"
                            for="model_{{ $model->id }}"
                        >
                            <span class="filter-label-name">
                                {{ $model->name }}
                            </span>

                            <span class="filter-count">
                                ({{ $model->autoPostWithModel->count() }})
                            </span>
                        </label>
                    </div>
                </li>

            @endforeach

        </ul>
    </div>
</div>



<!-- =========================================================
     END MODEL FILTER
========================================================= -->

<br><br>

<!-- =========================================================
     BODY TYPE FILTER
========================================================= -->

<div class="widget-facet wd-categories">

    <div class="facet-title"
         data-bs-target="#bodyTypes"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="bodyTypes">

       <span class="title">Fahrzeugtyp</span>

        <span class="icon icon-arrow-up"></span>

    </div>


    <div id="bodyTypes" class="collapse show">

        <ul class="tf-filter-group current-scrollbar mb_36"
            style="padding-left: 5px;">

            @foreach($bodyTypes as $bodyType)

                <div class="form-check">

                    <input
                        class="form-check-input body-type-checkbox"
                        type="checkbox"

                        name="body_type[]"

                        value="{{ $bodyType->slug }}"

                        id="body_type_{{ $bodyType->id }}"

                        @checked(
                            in_array(
                                $bodyType->slug,
                                $filter_body_type,
                                true
                            )
                        )
                    >

                    <label
                        class="form-check-label filter-checkbox-label"
                        for="body_type_{{ $bodyType->id }}"
                    >
                        <span class="filter-label-name">
                            {{ $bodyType->name }}
                        </span>

                        <span class="filter-count">
                            ({{ $bodyType->autos->count() }})
                        </span>
                    </label>

                </div>

            @endforeach

        </ul>

    </div>

</div>

<!-- =========================================================
     END BODY TYPE FILTER
========================================================= -->






<br><br>

<!-- =========================================================
     PRICE RANGE FILTER
========================================================= -->

<!-- =========================================================
     PRICE RANGE FILTER
========================================================= -->

<div class="form-group wg-box3">
     <span class="title">Preis</span>
    <div class="widget widget-price">

        <div class="price_slider_wrapper">

            <!-- Price values ABOVE slider -->
            <div class="price-slider-top">

                <div class="price-slider-value">
                    <span class="price-slider-label">Min</span>
                    <span id="price-min-display">€ 0</span>
                </div>

                <div class="price-slider-value price-slider-value-right">
                    <span class="price-slider-label">Max</span>
                    <span id="price-max-display">€ 0</span>
                </div>

            </div>


            <!-- Slider -->
            <div
                id="slider_range3"
                class="price_slider"
                data-label-reasult="Range:"
                data-min="{{ \App\Helpers\Helper::minPrice() }}"
                data-max="{{ \App\Helpers\Helper::maxPrice() }}"
                data-unit="€"
                data-value-min="{{ \App\Helpers\Helper::minPrice() }}"
                data-value-max="{{ \App\Helpers\Helper::maxPrice() }}"
            ></div>


            <!-- Hidden value used by Laravel -->
            <input
                type="hidden"
                name="price_range"
                id="price_range"
                value="{{ request('price_range', '') }}"
            >


            <!-- Button -->
            <div class="price-slider-button-wrapper">

                <button
                    type="submit"
                    class="btn btn-dark price-filter-button"
                >
                    Klicken
                </button>

            </div>

        </div>

    </div>
</div>

<!-- =========================================================
     END PRICE RANGE FILTER
========================================================= -->



              
               <br><br>
                    

<!-- =========================================================
     MILEAGE / KILOMETER RANGE FILTER
========================================================= -->

<div class="form-group wg-box3">
     <span class="title">Kilometerstand</span>
    <div class="widget widget-price">

        <div class="price_slider_wrapper">

            <!-- Mileage values ABOVE slider -->
            <div class="price-slider-top">

                <div class="price-slider-value">

                    <span class="price-slider-label">
                        Min. KM
                    </span>

                    <span id="mileage-min-display">
                        0 km
                    </span>

                </div>


                <div class="price-slider-value price-slider-value-right">

                    <span class="price-slider-label">
                        Max. KM
                    </span>

                    <span id="mileage-max-display">
                        0 km
                    </span>

                </div>

            </div>


            <!-- Mileage Slider -->
            <div
                id="mileage_slider"
                class="price_slider mileage_slider"

                data-label-reasult="Mileage:"
                data-min="{{ \App\Helpers\Helper::minMileage() }}"
                data-max="{{ \App\Helpers\Helper::maxMileage() }}"
                data-unit="km"

                data-value-min="{{ \App\Helpers\Helper::minMileage() }}"
                data-value-max="{{ \App\Helpers\Helper::maxMileage() }}"
            ></div>


            <!-- Hidden value used by Laravel -->
            <input
                type="hidden"
                name="mileage_range"
                id="mileage_range"
                value="{{ request('mileage_range', '') }}"
            >


            <!-- Button -->
            <div class="price-slider-button-wrapper">

                <button
                    type="submit"
                    class="btn btn-dark price-filter-button"
                >
                    Klicken
                </button>

            </div>

        </div>

    </div>
</div>

<!-- =========================================================
     END MILEAGE RANGE FILTER
========================================================= -->

<br><br>

<!-- =========================================================
     FIRST REGISTRATION RANGE FILTER
========================================================= -->

<div class="form-group wg-box3">
     <span class="title">Erstzulassung</span>
    <div class="widget widget-price">

        <div class="price_slider_wrapper">

            <!-- Registration values ABOVE slider -->
            <div class="price-slider-top">

                <div class="price-slider-value">

                    <span class="price-slider-label">
                        Von
                    </span>

                    <span id="registration-min-display">
                        {{ \App\Helpers\Helper::minRegistrationYear() }}
                    </span>

                </div>


                <div class="price-slider-value price-slider-value-right">

                    <span class="price-slider-label">
                        Bis
                    </span>

                    <span id="registration-max-display">
                        {{ \App\Helpers\Helper::maxRegistrationYear() }}
                    </span>

                </div>

            </div>


            <!-- Slider -->
            <div
                id="registration_slider"
                class="price_slider"

                data-min="{{ \App\Helpers\Helper::minRegistrationYear() }}"

                data-max="{{ \App\Helpers\Helper::maxRegistrationYear() }}"

                data-value-min="{{ \App\Helpers\Helper::minRegistrationYear() }}"

                data-value-max="{{ \App\Helpers\Helper::maxRegistrationYear() }}"
            ></div>


            <!-- Hidden value used by Laravel -->
            <input
                type="hidden"
                name="first_registration_range"
                id="first_registration_range"
                value="{{ request('first_registration_range', '') }}"
            >


            <!-- Button -->
            <div class="price-slider-button-wrapper">

                <button
                    type="submit"
                    class="btn btn-dark price-filter-button"
                >
                    Klicken
                </button>

            </div>

        </div>

    </div>
</div>

<!-- =========================================================
     END FIRST REGISTRATION RANGE FILTER
========================================================= -->

<br><br>
<!-- =========================================================
     FUEL TYPE FILTER
========================================================= -->

<div class="widget-facet wd-categories">

    <div class="facet-title"
         data-bs-target="#fuelTypes"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="fuelTypes">

       <span class="title">Kraftstoff</span>

        <span class="icon icon-arrow-up"></span>

    </div>


    <div id="fuelTypes" class="collapse show">

        <ul
            class="tf-filter-group current-scrollbar mb_36"
            style="padding-left: 5px;"
        >

            @foreach($fuelTypes as $fuelType)

                <div class="form-check">

                    <input
                        class="form-check-input fuel-type-checkbox"
                        type="checkbox"

                        name="fuel_type[]"

                        value="{{ $fuelType->slug }}"

                        id="fuel_type_{{ $fuelType->id }}"

                        @checked(
                            in_array(
                                $fuelType->slug,
                                $filter_fuel_type,
                                true
                            )
                        )
                    >

                    <label
                        class="form-check-label filter-checkbox-label"
                        for="fuel_type_{{ $fuelType->id }}"
                    >
                        <span class="filter-label-name">
                            {{ $fuelType->name }}
                        </span>

                        @if(method_exists($fuelType, 'autos'))
                            <span class="filter-count">
                                ({{ $fuelType->autos->count() }})
                            </span>
                        @endif
                    </label>

                </div>

            @endforeach

        </ul>

    </div>

</div>

<!-- =========================================================
     END FUEL TYPE FILTER
========================================================= -->
<br><br>

<!-- =========================================================
     POWER HP RANGE FILTER
========================================================= -->

<div class="form-group wg-box3">
     <span class="title">Leistung</span>
    <div class="widget widget-price">

        <div class="price_slider_wrapper">

            <!-- Power HP values ABOVE slider -->
            <div class="price-slider-top">

                <div class="price-slider-value">

                    <span class="price-slider-label">
                        Min
                    </span>

                    <span id="power-hp-min-display">
                        0 PS
                    </span>

                </div>


                <div class="price-slider-value price-slider-value-right">

                    <span class="price-slider-label">
                        Max
                    </span>

                    <span id="power-hp-max-display">
                        0 PS
                    </span>

                </div>

            </div>


            <!-- Slider -->
            <div
                id="slider_power_hp"
                class="price_slider"

                data-min="{{ \App\Helpers\Helper::minPowerHp() }}"

                data-max="{{ \App\Helpers\Helper::maxPowerHp() }}"

                data-unit="PS"

                data-value-min="{{ \App\Helpers\Helper::minPowerHp() }}"

                data-value-max="{{ \App\Helpers\Helper::maxPowerHp() }}"
            ></div>


            <!-- Hidden value used by Laravel -->
            <input
                type="hidden"
                name="power_hp_range"
                id="power_hp_range"
                value="{{ request('power_hp_range', '') }}"
            >


            <!-- Button -->
            <div class="price-slider-button-wrapper">

                <button
                    type="submit"
                    class="btn btn-dark price-filter-button"
                >
                    Klicken
                </button>

            </div>

        </div>

    </div>
</div>

<!-- =========================================================
     END POWER HP RANGE FILTER
========================================================= -->

<br><br>

<!-- =========================================================
     TRANSMISSION FILTER
========================================================= -->

<div class="widget-facet wd-categories">

    <div class="facet-title"
         data-bs-target="#transmissions"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="transmissions">

       <span class="title">Getriebe</span>

        <span class="icon icon-arrow-up"></span>

    </div>


    <div id="transmissions" class="collapse show">

        <ul class="tf-filter-group current-scrollbar mb_36"
            style="padding-left: 5px;">

            @foreach($transmissions as $transmission)

                <div class="form-check">

                    <input
                        class="form-check-input transmission-checkbox"
                        type="checkbox"

                        name="transmission[]"

                        value="{{ $transmission->slug }}"

                        id="transmission_{{ $transmission->id }}"

                        @checked(
                            in_array(
                                $transmission->slug,
                                $filter_transmission ?? [],
                                true
                            )
                        )
                    >

                    <label
                        class="form-check-label filter-checkbox-label"
                        for="transmission_{{ $transmission->id }}"
                    >

                        <span class="filter-label-name">
                            {{ $transmission->name }}
                        </span>

                        <span class="filter-count">
                            ({{ $transmission->autos->count() }})
                        </span>

                    </label>

                </div>

            @endforeach

        </ul>

    </div>

</div>

<!-- =========================================================
     END TRANSMISSION FILTER
========================================================= -->


<br><br>

<!-- =========================================================
     COLOR FILTER
========================================================= -->

<div class="widget-facet wd-categories color-filter-widget">

    <div class="facet-title"
         data-bs-target="#vehicleColors"
         data-bs-toggle="collapse"
         aria-expanded="true"
         aria-controls="vehicleColors">

   <span class="title">Außenfarbe</span>

        <span class="icon icon-arrow-up"></span>

    </div>

    <div id="vehicleColors" class="collapse show">

        <div class="color-filter-list">

            @foreach($colors as $color)

                <div class="color-filter-item">

                    <label
                        class="color-filter-option"
                        for="color_{{ $color->id }}"
                    >

                        <!-- Real checkbox -->
                        <input
                            type="checkbox"
                            class="color-checkbox"
                            name="color[]"
                            value="{{ $color->slug }}"
                            id="color_{{ $color->id }}"
                            @checked(
                                in_array(
                                    $color->slug,
                                    $filter_color,
                                    true
                                )
                            )
                        >

                        <!-- Color display -->
                        <span
                            class="color-filter-swatch"
                            style="background-color: {{ $color->hex_code }};"
                            aria-hidden="true"
                        ></span>

                        <!-- Color name -->
                        <span class="color-filter-name">
                            {{ $color->name }}
                        </span>

                        @if(method_exists($color, 'autos'))

                            <span class="color-filter-count">
                                ({{ $color->autos->count() }})
                            </span>

                        @endif

                    </label>

                </div>

            @endforeach

        </div>

    </div>

</div>

<!-- =========================================================
     END COLOR FILTER
========================================================= -->

          


                                          
                                        </div>
                                 
                                </div>

                            </div>
                            
                      <!-- end sidebar -->
                      <!-- end sidebar -->
                      <!-- end sidebar -->
                      <!-- end sidebar -->
                      
                      
                            <div class="sidebar-left-listing">
                                <div class="row">
                                    <div class="col-lg-12 listing-list-car-wrap">
                                        <div
                                            class="category-filter flex justify-space align-center mb-30 flex-wrap gap-8">
                                            <div class="box-1 flex align-center flex-wrap gap-8">
                                             
                                                
                                              <form
                                                    action="{{ route('fahrzeug.post.filter') }}"
                                                    method="GET"
                                                    class="search-form w-full"
                                                >
                                                    <div class="search-box">
                                                        <input
                                                            type="text"
                                                            name="search"
                                                            value="{{ $search ?? request('search') }}"
                                                            class="form-control"
                                                            placeholder="Marke, Modell, Variante, Fahrzeugnummer..."
                                                            autocomplete="off"
                                                        >

                                                        <button type="submit" class="search-btn">
                                                            <i class="icon-search"></i>
                                                            Suchen
                                                        </button>
                                                    </div>
                                                </form>
                                              
                                              
                                               <div class="filter-mobie">
                                                <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" class="filter">Filter<i class="icon-autodeal-filter"></i></a>
                                               </div>
                                            </div>
                                            <div class="box-2 flex flex-wrap gap-8">
                                                <a href="#" class="btn-view grid ">
                                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M5.04883 6.40508C5.04883 5.6222 5.67272 5 6.41981 5C7.16686 5 7.7908 5.62221 7.7908 6.40508C7.7908 7.18801 7.16722 7.8101 6.41981 7.8101C5.67241 7.8101 5.04883 7.18801 5.04883 6.40508Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M11.1045 6.40508C11.1045 5.62221 11.7284 5 12.4755 5C13.2229 5 13.8466 5.6222 13.8466 6.40508C13.8466 7.18789 13.2227 7.8101 12.4755 7.8101C11.7284 7.8101 11.1045 7.18794 11.1045 6.40508Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M19.9998 6.40514C19.9998 7.18797 19.3757 7.81016 18.6288 7.81016C17.8818 7.81016 17.2578 7.18794 17.2578 6.40508C17.2578 5.62211 17.8813 5 18.6288 5C19.3763 5 19.9998 5.62215 19.9998 6.40514Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M7.74249 12.5097C7.74249 13.2926 7.11849 13.9147 6.37133 13.9147C5.62411 13.9147 5 13.2926 5 12.5097C5 11.7267 5.62419 11.1044 6.37133 11.1044C7.11842 11.1044 7.74249 11.7266 7.74249 12.5097Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M13.7976 12.5097C13.7976 13.2927 13.1736 13.9147 12.4266 13.9147C11.6795 13.9147 11.0557 13.2927 11.0557 12.5097C11.0557 11.7265 11.6793 11.1044 12.4266 11.1044C13.1741 11.1044 13.7976 11.7265 13.7976 12.5097Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M19.9516 12.5097C19.9516 13.2927 19.328 13.9147 18.5807 13.9147C17.8329 13.9147 17.209 13.2925 17.209 12.5097C17.209 11.7268 17.8332 11.1044 18.5807 11.1044C19.3279 11.1044 19.9516 11.7265 19.9516 12.5097Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M5.04297 18.5947C5.04297 17.8118 5.66709 17.1896 6.4143 17.1896C7.16137 17.1896 7.78523 17.8116 7.78523 18.5947C7.78523 19.3778 7.16139 19.9997 6.4143 19.9997C5.66714 19.9997 5.04297 19.3773 5.04297 18.5947Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M11.0986 18.5947C11.0986 17.8118 11.7227 17.1896 12.47 17.1896C13.2169 17.1896 13.8409 17.8117 13.8409 18.5947C13.8409 19.3778 13.2169 19.9997 12.47 19.9997C11.7225 19.9997 11.0986 19.3774 11.0986 18.5947Z"
                                                            stroke="CurrentColor"></path>
                                                        <path
                                                            d="M17.252 18.5947C17.252 17.8117 17.876 17.1896 18.6229 17.1896C19.3699 17.1896 19.9939 17.8117 19.9939 18.5947C19.9939 19.3778 19.3702 19.9997 18.6229 19.9997C17.876 19.9997 17.252 19.3774 17.252 18.5947Z"
                                                            stroke="CurrentColor"></path>
                                                    </svg>
                                                </a>
                                                <a href="#" class="btn-view list active">
                                                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M19.7016 18.3317H9.00246C8.5615 18.3317 8.2041 17.9743 8.2041 17.5333C8.2041 17.0923 8.5615 16.7349 9.00246 16.7349H19.7013C20.1423 16.7349 20.4997 17.0923 20.4997 17.5333C20.4997 17.9743 20.1426 18.3317 19.7016 18.3317Z"
                                                            fill="CurrentColor"></path>
                                                        <path
                                                            d="M19.7016 13.3203H9.00246C8.5615 13.3203 8.2041 12.9629 8.2041 12.5219C8.2041 12.081 8.5615 11.7236 9.00246 11.7236H19.7013C20.1423 11.7236 20.4997 12.081 20.4997 12.5219C20.5 12.9629 20.1426 13.3203 19.7016 13.3203Z"
                                                            fill="CurrentColor"></path>
                                                        <path
                                                            d="M19.7016 8.30919H9.00246C8.5615 8.30919 8.2041 7.95179 8.2041 7.51083C8.2041 7.06986 8.5615 6.71246 9.00246 6.71246H19.7013C20.1423 6.71246 20.4997 7.06986 20.4997 7.51083C20.4997 7.95179 20.1426 8.30919 19.7016 8.30919Z"
                                                            fill="CurrentColor"></path>
                                                        <path
                                                            d="M5.5722 8.64465C6.16436 8.64465 6.6444 8.16461 6.6444 7.57245C6.6444 6.98029 6.16436 6.50024 5.5722 6.50024C4.98004 6.50024 4.5 6.98029 4.5 7.57245C4.5 8.16461 4.98004 8.64465 5.5722 8.64465Z"
                                                            fill="CurrentColor"></path>
                                                        <path
                                                            d="M5.5722 13.5942C6.16436 13.5942 6.6444 13.1141 6.6444 12.522C6.6444 11.9298 6.16436 11.4498 5.5722 11.4498C4.98004 11.4498 4.5 11.9298 4.5 12.522C4.5 13.1141 4.98004 13.5942 5.5722 13.5942Z"
                                                            fill="CurrentColor"></path>
                                                        <path
                                                            d="M5.5722 18.5438C6.16436 18.5438 6.6444 18.0637 6.6444 17.4716C6.6444 16.8794 6.16436 16.3994 5.5722 16.3994C4.98004 16.3994 4.5 16.8794 4.5 17.4716C4.5 18.0637 4.98004 18.5438 5.5722 18.5438Z"
                                                            fill="CurrentColor"></path>
                                                    </svg>
                                                </a>
                                         


<div class="wd-find-select flex gap-8">

    <div class="group-select" style=" border: 1px solid #000; border-radius: 6px 6px 6px 6px;">
        <div class="nice-select" tabindex="0">

            <span class="current">
                @if($sort == 'Niedrigster-Preis')
                    Niedrigster Preis
                @elseif($sort == 'Höchster-Preis')
                    Höchster Preis
                @else
                    Sortieren nach
                @endif
            </span>

            <ul class="list style">

                <li data-value=""
                    class="option @if(empty($sort)) selected @endif"
                    onclick="this.closest('form').submit();">
                    Sortieren nach
                </li>

                <li data-value="Niedrigster-Preis"
                    class="option @if($sort == 'Niedrigster-Preis') selected @endif"
                    onclick="this.closest('form').querySelector('[name=sortBy]').value=this.dataset.value; this.closest('form').submit();">
                    Niedrigster Preis
                </li>

                <li data-value="Höchster-Preis"
                    class="option @if($sort == 'Höchster-Preis') selected @endif"
                    onclick="this.closest('form').querySelector('[name=sortBy]').value=this.dataset.value; this.closest('form').submit();">
                    Höchster Preis
                </li>

            </ul>

        </div>
    </div>

    <input type="hidden" name="sortBy" value="{{ $sort }}">

</div>





                                            </div>
                                        </div>
                                        <div class="list-car-list-1">
                                            
                                        <!--  start  loop-->
                                         <!--  start  loop-->
                                         
                                           @if( count($autopost)> 0 )
                                           
                                           
                                      <?php
                                      
                                        $crn = ($autopost->currentpage() - 1) * $autopost->perpage() + 1;
                                        $counter = 2;

                                      ?>
                                         
                                         @foreach ($autopost as $row) 
                                         
                                            <div class="box-car-list style-2 hv-onegray">
                                                <div class="image-group relative ">
                                                    <div class="top flex-two">
                                                        <ul class="d-flex gap-8">
                                                            <li class="flag-tag success">{{ $row->brand->name }}</li>
                                                            <li class="flag-tag style-1">
                                                                <div class="icon">
                                                                    <svg width="16" height="13" viewBox="0 0 16 13"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M1.5 9L4.93933 5.56067C5.07862 5.42138 5.24398 5.31089 5.42597 5.2355C5.60796 5.16012 5.80302 5.12132 6 5.12132C6.19698 5.12132 6.39204 5.16012 6.57403 5.2355C6.75602 5.31089 6.92138 5.42138 7.06067 5.56067L10.5 9M9.5 8L10.4393 7.06067C10.5786 6.92138 10.744 6.81089 10.926 6.7355C11.108 6.66012 11.303 6.62132 11.5 6.62132C11.697 6.62132 11.892 6.66012 12.074 6.7355C12.256 6.81089 12.4214 6.92138 12.5607 7.06067L14.5 9M2.5 11.5H13.5C13.7652 11.5 14.0196 11.3946 14.2071 11.2071C14.3946 11.0196 14.5 10.7652 14.5 10.5V2.5C14.5 2.23478 14.3946 1.98043 14.2071 1.79289C14.0196 1.60536 13.7652 1.5 13.5 1.5H2.5C2.23478 1.5 1.98043 1.60536 1.79289 1.79289C1.60536 1.98043 1.5 2.23478 1.5 2.5V10.5C1.5 10.7652 1.60536 11.0196 1.79289 11.2071C1.98043 11.3946 2.23478 11.5 2.5 11.5ZM9.5 4H9.50533V4.00533H9.5V4ZM9.75 4C9.75 4.0663 9.72366 4.12989 9.67678 4.17678C9.62989 4.22366 9.5663 4.25 9.5 4.25C9.4337 4.25 9.37011 4.22366 9.32322 4.17678C9.27634 4.12989 9.25 4.0663 9.25 4C9.25 3.9337 9.27634 3.87011 9.32322 3.82322C9.37011 3.77634 9.4337 3.75 9.5 3.75C9.5663 3.75 9.62989 3.77634 9.67678 3.82322C9.72366 3.87011 9.75 3.9337 9.75 4Z"
                                                                            stroke="white" stroke-width="1.5"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" />
                                                                    </svg>
                                                                </div>
                                                                {{ $row->images_count }}
                                                            </li>
                                                        </ul>
                                                        <div class="year flag-tag">{{ number_format($row->mileage, 0, ',', '.') }} km</div>
                                                    </div>
                                                    
                                             
                                                    
                                                <div class="img-style">
                                                    @if($row->primaryImage)
                                                        <img class="lazyload"
                                                             data-src="{{ asset('autoimages/' . $row->primaryImage->image_path) }}"
                                                             src="{{ asset('autoimages/' . $row->primaryImage->image_path) }}"
                                                             alt="{{ $row->primaryImage->alt_text ?? $row->title }}">
                                                    @else
                                                        <img class="lazyload"
                                                             data-src="{{ asset('frontend/assets/images/car-list/car8.jpg') }}"
                                                             src="{{ asset('frontend/assets/images/car-list/car8.jpg') }}"
                                                             alt="{{ $row->title }}">
                                                    @endif
                                                </div>
                                                </div>
                                                <div class="content">
                                                    <div class="inner1">
                                                        <div class="text-address">
                                                            <p class="text-color-3 font" style="font-size:18px;font-weight:600;">{{ $row->brand->name }} </p>
                                                        </div>
                                                        <h4 class="link-style-1">
                                                            <a href="{{route('fahrzeugDetailPageSlug',$row->slug)}}"><span style="font-weight:900;">{{ $row->title }}</span>
                                                                </a>
                                                        </h4>
                                                        <br>
                                                        <div class="icon-box flex flex-wrap">
                                                            <div class="icons flex-three" style="margin-right:17px;">
                                                                <i class="icon-autodeal-km1"></i>
                                                                <span><div class="year flag-tag">{{ number_format($row->mileage, 0, ',', '.') }} km</div></span>
                                                            </div>
                                                            <div class="icons flex-three" style="margin-right:17px;">
                                                                <i class="icon-autodeal-diesel"></i>
                                                                <span>{{ $row->fuelType?->name ?? 'N/A' }}</span>
                                                            </div>
                                                            <div class="icons flex-three" style="margin-right:17px;">
                                                                <i class="icon-autodeal-automatic"></i>
                                                                 <span>{{ $row->transmission?->name ?? 'N/A' }}</span>
                                                            </div>
                                                            
                                                           <div class="icons flex-three" style="margin-right:17px;">
                                                              <div class="icon">
                                                               EZ&nbsp;
                                                                </div> 
                                                                <span>  {{ $row->first_registration?->format('m/Y') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="money price">€ {{ number_format($row->price, 2, ',', '.') }}</div>
                                                        <br>
                                                       <div class="view-details">
                                                        <a href="{{ url('listing-detail-v1/' . $row->id) }}">
                                                            <span>Zu den Fahrzeugen</span>
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                    </div>
                                                        <div class="inner2xx sha">

                                                            <div class="detail-row">
                                                                <span class="detail-label">Erstzulassung</span>
                                                                <span class="detail-value">{{ $row->first_registration?->format('m/Y') }}</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Kilometerstand</span>
                                                                <span class="detail-value">{{ number_format($row->mileage, 0, ',', '.') }} km</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Kraftstoffart</span>
                                                                <span class="detail-value">{{ $row->fuelType->name }}</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Getriebe</span>
                                                                <span class="detail-value">{{ $row->transmission?->name ?? 'N/A'  }}</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Leistung</span>
                                                                <span class="detail-value">{{ $row->power_hp }} PS</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Kategorie</span>
                                                                <span class="detail-value">{{ $row->bodyType->name }}</span>
                                                            </div>

                                                            <div class="detail-row">
                                                                <span class="detail-label">Fahrzeugzustand</span>
                                                                <span class="detail-value">{{ $row->condition?->name ?? 'N/A'  }}</span>
                                                            </div>

                                                        </div>
                                                </div>
                                            </div>
                                         
                                           
                                           
                                         @endforeach  
                                         
                                                @else
                                               <div id="centernofound">
                                                   <h5 style="padding:50px 0 0 0;color:red;">Keine Einträge gefunden!!</h5>
                                               </div>

                                               @endif
                                         
                                        <!-- end start  loop-->
                                         <!--end  start  loop-->
                                        <!-- end start  loop-->
                                         <!--end  start  loop-->
                                            

                                            
                                        </div>
                                        <br><br>
                                        <div class="themesflat-pagination clearfix mt-40">
                                          
                                                      {{$autopost->appends($_GET)->links('pagination-links')}}
                                        
                                        </div>

                                    </div>
                                </div>

                            </div>
                      
                      
                      
                        </div>
                    </div>
                </div>
            </section>

            </form>
            <!-- form end -->
            
            
            
            <style>
                
                .form-check-input,
                .form-check-input:checked {
                    border: 1px solid #000 !important;
                }
                
                
       .title {
            font-weight: 900;
            font-size: 22px;
        }         
                
  /* =========================================================
   PRICE RANGE SLIDER
========================================================= */
 /* =========================================================
   PROFESSIONAL PRICE RANGE SLIDER
========================================================= */

.price_slider_wrapper {
    width: 100%;
    padding: 0;
}


/* ---------------------------------------------------------
   PRICE VALUES ABOVE SLIDER
--------------------------------------------------------- */

.price-slider-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;

    width: 100%;

    margin-bottom: 14px;
}

.price-slider-value {
    display: flex;
    flex-direction: column;

    line-height: 1.2;
}

.price-slider-value-right {
    text-align: right;
    align-items: flex-end;
}

.price-slider-label {
    font-size: 12px;
    font-weight: 500;
    color: #777;

    margin-bottom: 3px;
}

#price-min-display,
#price-max-display,
#mileage-min-display,
#mileage-max-display,
#registration-min-display,
#registration-max-display,
#power-hp-min-display,
#power-hp-max-display{
    font-size: 16px;
    font-weight: 700;
    color: #000;
    white-space: nowrap;
}


/* ---------------------------------------------------------
   SLIDER
--------------------------------------------------------- */

.price_slider {
    position: relative;

    width: calc(100% - 20px);
    height: 6px;

    margin: 0 10px 22px;

    background: #ddd;

    border: none;
    border-radius: 10px;
}


/* Blue selected range */

.price_slider .ui-slider-range {
    position: absolute;

    top: 0;

    height: 100%;

    background: #2696FC;

    border: none;
    border-radius: 10px;
}


/* ---------------------------------------------------------
   SLIDER HANDLES
--------------------------------------------------------- */

.price_slider .ui-slider-handle {
    position: absolute !important;

    width: 20px !important;
    height: 20px !important;

    margin-left: -10px !important;
    margin-top: -7px !important;

    background: #2696FC !important;

    border: 3px solid #fff !important;
    border-radius: 50% !important;

    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.30) !important;

    cursor: pointer !important;

    z-index: 10 !important;

    outline: none !important;

    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}


/* Hover */

.price_slider .ui-slider-handle:hover,
.price_slider .ui-slider-handle:focus {
    background: #2696FC !important;

    border: 3px solid #fff !important;

    box-shadow:
        0 0 0 3px rgba(38, 150, 252, 0.15),
        0 1px 5px rgba(0, 0, 0, 0.30) !important;
}


/* ---------------------------------------------------------
   SUBMIT BUTTON
--------------------------------------------------------- */

.price-slider-button-wrapper {
    margin-top: 5px;
}

.price-filter-button {
    margin-top: 0;
    color: #fff;
}





/* =========================================================
   CHECKBOX FILTERS
   Marke / Modell / Fahrzeugtyp / Kraftstoff
========================================================= */

.filter-checkbox-label {
    display: flex !important;
    align-items: center !important;

    width: 100%;

    margin: 0 !important;
    padding: 3px 0 !important;

    line-height: 1.4;

    cursor: pointer;

    box-sizing: border-box;
}


/*
|--------------------------------------------------------------------------
| Name - left side
|--------------------------------------------------------------------------
*/

.filter-label-name {
    flex: 1 1 auto;

    min-width: 0;

    margin: 0;
    padding: 0;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;
}


/*
|--------------------------------------------------------------------------
| Count - right side
|--------------------------------------------------------------------------
*/

.filter-count {
    flex: 0 0 auto;

    margin-left: auto;
    padding-left: 10px;

    white-space: nowrap;

    font-size: inherit;
    font-weight: 400;

    color: #777;

    text-align: right;
}


/*
|--------------------------------------------------------------------------
| Checkbox alignment
|--------------------------------------------------------------------------
*/

.form-check {
    display: flex !important;
    align-items: center !important;
    flex-wrap: nowrap !important;

    width: 100%;
    margin-bottom: 6px;
    padding-left: 0 !important;
}

.form-check .form-check-input {
    position: static !important;
    float: none !important;

    flex: 0 0 auto !important;

    margin: 0 8px 0 0 !important;
}

.form-check .form-check-label {
    flex: 1 1 auto;
    min-width: 0;
}



.form-check {
    display: flex;
    align-items: center;

    width: 100%;

    margin-bottom: 6px;
    padding-left: 0;
}

.form-check .form-check-input {
    flex: 0 0 auto;

    margin-top: 0;
    margin-right: 8px;
    margin-left: 0;

    float: none;
}



.model-item {
    display: none !important;
}

.model-item.model-visible {
    display: block !important;
}


/*
|--------------------------------------------------------------------------
| Hover
|--------------------------------------------------------------------------
*/

.filter-checkbox-label:hover .filter-label-name {
    text-decoration: none;
}





/* =========================================================
   COLOR FILTER
========================================================= */

.color-filter-widget {
    width: 100%;
}

.color-filter-list {
    width: 100%;
    margin: 0;
    padding: 0 !important;
    list-style: none;
}

.color-filter-item {
    width: 100%;
    margin: 0;
    padding: 0;
}

/*
|--------------------------------------------------------------------------
| One complete horizontal row
|--------------------------------------------------------------------------
*/

.color-filter-option {
    display: flex !important;

    flex-direction: row !important;
    align-items: center !important;

    width: 100%;

    min-height: 34px;

    margin: 0;
    padding: 3px 0;

    gap: 10px;

    cursor: pointer;

    line-height: 1;

    box-sizing: border-box;
}


/*
|--------------------------------------------------------------------------
| Checkbox
|--------------------------------------------------------------------------
*/

.color-filter-option .color-checkbox {
    position: relative !important;

    flex: 0 0 18px;

    width: 18px !important;
    height: 18px !important;

    min-width: 18px;
    min-height: 18px;

    margin: 0 !important;
    padding: 0 !important;

    appearance: auto;

    cursor: pointer;

    vertical-align: middle;
}


/*
|--------------------------------------------------------------------------
| Color Swatch
|--------------------------------------------------------------------------
*/

.color-filter-swatch {
    display: block;

    flex: 0 0 28px;

    width: 28px;
    height: 28px;

    min-width: 28px;
    min-height: 28px;

    border: 1px solid #d5d5d5;
    border-radius: 4px;

    box-sizing: border-box;

    vertical-align: middle;
}


/*
|--------------------------------------------------------------------------
| Color Name
|--------------------------------------------------------------------------
*/

.color-filter-name {
    display: block;

    flex: 1 1 auto;

    min-width: 0;

    margin: 0;
    padding: 0;

    font-size: 19px;
    font-weight: 400;

    line-height: 28px;

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;

    vertical-align: middle;
}


/*
|--------------------------------------------------------------------------
| Count
|--------------------------------------------------------------------------
*/

.color-filter-count {
    display: block;

    flex: 0 0 auto;

    margin-left: auto;

    font-size: 19px;

    line-height: 28px;

    white-space: nowrap;

    color: #000;

    vertical-align: middle;
}



/*
|--------------------------------------------------------------------------
| Hover
|--------------------------------------------------------------------------
*/

.color-filter-option:hover .color-filter-name {
    text-decoration: underline;
}


/*
|--------------------------------------------------------------------------
| Selected Color
|--------------------------------------------------------------------------
*/

.color-filter-option:has(.color-checkbox:checked)
.color-filter-swatch {
    border: 2px solid #000;

    box-shadow:
        inset 0 0 0 2px #fff;
}


/*
|--------------------------------------------------------------------------
| Selected Text
|--------------------------------------------------------------------------
*/

.color-filter-option:has(.color-checkbox:checked)
.color-filter-name {
    font-weight: 600;
}


/*
|--------------------------------------------------------------------------
| White / very light colors
|--------------------------------------------------------------------------
*/

.color-filter-swatch[style*="#fff"],
.color-filter-swatch[style*="#FFF"],
.color-filter-swatch[style*="#ffffff"],
.color-filter-swatch[style*="#FFFFFF"] {
    border-color: #999;
}



.search-form {
    width: 450px !important;
    max-width: 100%;
    margin: 0;
}

.search-box {
    display: flex;
    align-items: stretch;
    width: 450px !important;
    height: 44px;
}

.search-box .form-control {
    flex: 1 1 auto;
    min-width: 0;
    height: 44px;
    margin: 0;
    padding: 0 14px;
    border: 1px solid #000;
    border-right: 0;
    border-radius: 6px 0 0 6px;
    outline: none;
    box-sizing: border-box;
}

.search-box .search-btn {
    flex: 0 0 auto;
    height: 44px;
    margin: 0;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
     border: 1px solid #000;
    border-radius: 0 6px 6px 0;
    white-space: nowrap;
    box-sizing: border-box;
    cursor: pointer;
}

/* Tablet / smaller screens */
@media (max-width: 767px) {
    .search-form {
        width: 100%;
    }

    .search-box {
        width: 100%;
    }
}

/* Very small mobile screens */
@media (max-width: 480px) {
    .search-box .search-btn {
        padding: 0 12px;
    }

    .search-box .search-btn i {
        margin-right: 0;
    }
}




/*
|--------------------------------------------------------------------------
| Mobile
|--------------------------------------------------------------------------
*/

@media (max-width: 767px) {

    .color-filter-option {
        min-height: 36px;

        gap: 9px;
    }

    .color-filter-option .color-checkbox {
        width: 18px !important;
        height: 18px !important;
    }

    .color-filter-swatch {
        width: 28px;
        height: 28px;
        min-width: 28px;
    }

    .color-filter-name {
        font-size: 14px;
        line-height: 28px;
    }

}







           </style>

          



@endsection





@section('scripts')



<script>
    window.autoFilterConfig = {
        minPrice: @json(\App\Helpers\Helper::minPrice()),
        maxPrice: @json(\App\Helpers\Helper::maxPrice()),

        minMileage: @json(\App\Helpers\Helper::minMileage()),
        maxMileage: @json(\App\Helpers\Helper::maxMileage())
    };
</script>











<script>
document.addEventListener('DOMContentLoaded', function () {

    const brandCheckboxes = document.querySelectorAll('.brand-checkbox');
    const modelItems = document.querySelectorAll('.model-item');
    const modelCheckboxes = document.querySelectorAll('.model-checkbox');

    const bodyTypeCheckboxes =
        document.querySelectorAll('.body-type-checkbox');

    const fuelTypeCheckboxes =
        document.querySelectorAll('.fuel-type-checkbox');

    const colorCheckboxes =
        document.querySelectorAll('.color-checkbox');

    const modelFilter =
        document.getElementById('model-filter');

   const transmissionCheckboxes =
    document.querySelectorAll('.transmission-checkbox');


    /*
    |--------------------------------------------------------------------------
    | Update Models
    |--------------------------------------------------------------------------
    */

    function updateModels() {

        // Get ONLY checked brands
        const selectedBrandIds = Array.from(
            document.querySelectorAll('.brand-checkbox:checked')
        ).map(function (checkbox) {
            return String(
                checkbox.getAttribute('data-brand-id')
            );
        });

        console.log(
            'Selected Brand IDs:',
            selectedBrandIds
        );


        // No brand selected
        if (selectedBrandIds.length === 0) {

            modelFilter.style.display = 'none';

            modelItems.forEach(function (item) {

                item.classList.remove('model-visible');

                const checkbox =
                    item.querySelector('.model-checkbox');

                if (checkbox) {
                    checkbox.checked = false;
                }
            });

            return;
        }


        // At least one brand selected
        modelFilter.style.display = 'block';


        modelItems.forEach(function (item) {

            const modelBrandId =
                String(
                    item.getAttribute('data-brand-id')
                );


            // Show only models belonging
            // to selected brands
            if (
                selectedBrandIds.includes(modelBrandId)
            ) {

                item.classList.add('model-visible');

            } else {

                item.classList.remove('model-visible');

                // Uncheck models belonging
                // to unselected brands
                const checkbox =
                    item.querySelector('.model-checkbox');

                if (checkbox) {
                    checkbox.checked = false;
                }
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Brand Checkbox
    |--------------------------------------------------------------------------
    */

    brandCheckboxes.forEach(function (brandCheckbox) {

        brandCheckbox.addEventListener(
            'change',
            function () {

                const changedBrandId =
                    String(
                        this.getAttribute('data-brand-id')
                    );


                // If brand was unchecked,
                // uncheck its models
                if (!this.checked) {

                    modelCheckboxes.forEach(
                        function (modelCheckbox) {

                            const modelBrandId =
                                String(
                                    modelCheckbox.getAttribute(
                                        'data-brand-id'
                                    )
                                );


                            if (
                                modelBrandId ===
                                changedBrandId
                            ) {
                                modelCheckbox.checked = false;
                            }

                        }
                    );
                }


                // Update models first
                updateModels();


                // Submit form
                this.form.submit();
            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Model Checkbox
    |--------------------------------------------------------------------------
    */

    modelCheckboxes.forEach(function (modelCheckbox) {

        modelCheckbox.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Fahrzeugtyp Checkbox
    |--------------------------------------------------------------------------
    */

    bodyTypeCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Kraftstoff Checkbox
    |--------------------------------------------------------------------------
    */

    fuelTypeCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Außenfarbe Checkbox
    |--------------------------------------------------------------------------
    */

    colorCheckboxes.forEach(function (checkbox) {

        checkbox.addEventListener(
            'change',
            function () {

                this.form.submit();

            }
        );

    });
    
    
    /*
|--------------------------------------------------------------------------
| Getriebe Checkbox
|--------------------------------------------------------------------------
*/

transmissionCheckboxes.forEach(function (checkbox) {

    checkbox.addEventListener(
        'change',
        function () {

            this.form.submit();

        }
    );

});


    /*
    |--------------------------------------------------------------------------
    | Initial Model State
    |--------------------------------------------------------------------------
    */

    updateModels();

});
</script>









<script type="text/javascript" src="{{asset('frontend/js/listing.js')}}"></script>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const slider = document.getElementById('slider_range3');

    const minDisplay =
        document.getElementById('price-min-display');

    const maxDisplay =
        document.getElementById('price-max-display');

    const priceRangeInput =
        document.getElementById('price_range');


    /*
    |--------------------------------------------------------------------------
    | Safety checks
    |--------------------------------------------------------------------------
    */

    if (
        !slider ||
        !minDisplay ||
        !maxDisplay ||
        !priceRangeInput
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery UI
    |--------------------------------------------------------------------------
    */

    if (typeof jQuery === 'undefined') {

        console.error('jQuery is not loaded.');

        return;
    }


    if (typeof jQuery.fn.slider === 'undefined') {

        console.error(
            'jQuery UI Slider is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Database min / max
    |--------------------------------------------------------------------------
    */

    const dbMinPrice =
        parseFloat(slider.dataset.min);

    const dbMaxPrice =
        parseFloat(slider.dataset.max);


    if (
        isNaN(dbMinPrice) ||
        isNaN(dbMaxPrice) ||
        dbMinPrice > dbMaxPrice
    ) {

        console.error(
            'Invalid price range:',
            dbMinPrice,
            dbMaxPrice
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Read existing URL range
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | ?price_range=725-999
    |
    */

    const urlParams =
        new URLSearchParams(window.location.search);

    const existingRange =
        urlParams.get('price_range');


    let selectedMin = dbMinPrice;
    let selectedMax = dbMaxPrice;


    /*
    |--------------------------------------------------------------------------
    | Restore existing price filter
    |--------------------------------------------------------------------------
    */

    if (existingRange) {

        const parts =
            existingRange.split('-');


        if (parts.length === 2) {

            const urlMin =
                parseFloat(parts[0]);

            const urlMax =
                parseFloat(parts[1]);


            if (!isNaN(urlMin)) {

                selectedMin = Math.max(
                    dbMinPrice,
                    Math.min(
                        urlMin,
                        dbMaxPrice
                    )
                );

            }


            if (!isNaN(urlMax)) {

                selectedMax = Math.max(
                    dbMinPrice,
                    Math.min(
                        urlMax,
                        dbMaxPrice
                    )
                );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Safety
    |--------------------------------------------------------------------------
    */

    if (selectedMin > selectedMax) {

        selectedMin = dbMinPrice;
        selectedMax = dbMaxPrice;

    }


    /*
    |--------------------------------------------------------------------------
    | Format EUR
    |--------------------------------------------------------------------------
    |
    | 23525 => 23.525 €
    | 999   => 999 €
    |
    */

    function formatPrice(value) {

        return new Intl.NumberFormat('de-DE', {

            style: 'currency',

            currency: 'EUR',

            minimumFractionDigits: 0,

            maximumFractionDigits: 0

        }).format(value);

    }


    /*
    |--------------------------------------------------------------------------
    | Update displayed prices + hidden Laravel value
    |--------------------------------------------------------------------------
    */

    function updatePriceValues(
        minValue,
        maxValue
    ) {

        minValue =
            Math.round(minValue);

        maxValue =
            Math.round(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Display above slider
        |--------------------------------------------------------------------------
        */

        minDisplay.textContent =
            formatPrice(minValue);


        maxDisplay.textContent =
            formatPrice(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Hidden value for Laravel
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | Display:
        | €23.525 -- €45.999
        |
        | Hidden:
        | 23525-45999
        |
        */

        if (
            minValue === Math.round(dbMinPrice) &&
            maxValue === Math.round(dbMaxPrice)
        ) {

            priceRangeInput.value = '';

        } else {

            priceRangeInput.value =
                minValue + '-' + maxValue;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize slider
    |--------------------------------------------------------------------------
    */

    const $slider =
        jQuery(slider);


    $slider.slider({

        range: true,


        /*
        |--------------------------------------------------------------------------
        | Real DB minimum
        |--------------------------------------------------------------------------
        */

        min: Math.round(dbMinPrice),


        /*
        |--------------------------------------------------------------------------
        | Real DB maximum
        |--------------------------------------------------------------------------
        */

        max: Math.round(dbMaxPrice),


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | Allows every €1 value.
        |
        | Therefore:
        |
        | 725
        | 726
        | 727
        | ...
        | 998
        | 999
        |
        */

        step: 1,


        /*
        |--------------------------------------------------------------------------
        | Initial handles
        |--------------------------------------------------------------------------
        */

        values: [

            Math.round(selectedMin),

            Math.round(selectedMax)

        ],


        /*
        |--------------------------------------------------------------------------
        | While dragging
        |--------------------------------------------------------------------------
        */

        slide: function (event, ui) {

            updatePriceValues(

                ui.values[0],

                ui.values[1]

            );

        },


        /*
        |--------------------------------------------------------------------------
        | After changing
        |--------------------------------------------------------------------------
        */

        change: function (event, ui) {

            updatePriceValues(

                ui.values[0],

                ui.values[1]

            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Initial display
    |--------------------------------------------------------------------------
    */

    const initialValues =
        $slider.slider('values');


    updatePriceValues(

        initialValues[0],

        initialValues[1]

    );


});


</script>



<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const slider =
        document.getElementById('mileage_slider');

    const minDisplay =
        document.getElementById('mileage-min-display');

    const maxDisplay =
        document.getElementById('mileage-max-display');

    const mileageRangeInput =
        document.getElementById('mileage_range');


    /*
    |--------------------------------------------------------------------------
    | Safety checks
    |--------------------------------------------------------------------------
    */

    if (
        !slider ||
        !minDisplay ||
        !maxDisplay ||
        !mileageRangeInput
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery
    |--------------------------------------------------------------------------
    */

    if (typeof jQuery === 'undefined') {

        console.error(
            'jQuery is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery UI Slider
    |--------------------------------------------------------------------------
    */

    if (
        typeof jQuery.fn.slider === 'undefined'
    ) {

        console.error(
            'jQuery UI Slider is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Database minimum / maximum mileage
    |--------------------------------------------------------------------------
    */

    const dbMinMileage =
        parseFloat(slider.dataset.min);

    const dbMaxMileage =
        parseFloat(slider.dataset.max);


    /*
    |--------------------------------------------------------------------------
    | Validate database values
    |--------------------------------------------------------------------------
    */

    if (
        isNaN(dbMinMileage) ||
        isNaN(dbMaxMileage) ||
        dbMinMileage > dbMaxMileage
    ) {

        console.error(
            'Invalid mileage range:',
            dbMinMileage,
            dbMaxMileage
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Read existing URL mileage range
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | ?mileage_range=25000-150000
    |
    */

    const urlParams =
        new URLSearchParams(
            window.location.search
        );


    const existingRange =
        urlParams.get('mileage_range');


    /*
    |--------------------------------------------------------------------------
    | Default values
    |--------------------------------------------------------------------------
    */

    let selectedMin =
        dbMinMileage;

    let selectedMax =
        dbMaxMileage;


    /*
    |--------------------------------------------------------------------------
    | Restore existing mileage filter
    |--------------------------------------------------------------------------
    */

    if (existingRange) {

        const parts =
            existingRange.split('-');


        if (parts.length === 2) {

            const urlMin =
                parseFloat(parts[0]);

            const urlMax =
                parseFloat(parts[1]);


            if (!isNaN(urlMin)) {

                selectedMin =
                    Math.max(
                        dbMinMileage,
                        Math.min(
                            urlMin,
                            dbMaxMileage
                        )
                    );

            }


            if (!isNaN(urlMax)) {

                selectedMax =
                    Math.max(
                        dbMinMileage,
                        Math.min(
                            urlMax,
                            dbMaxMileage
                        )
                    );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Safety
    |--------------------------------------------------------------------------
    */

    if (selectedMin > selectedMax) {

        selectedMin =
            dbMinMileage;

        selectedMax =
            dbMaxMileage;

    }


    /*
    |--------------------------------------------------------------------------
    | Format mileage
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | 25000  => 25.000 km
    | 150000 => 150.000 km
    |
    */

    function formatMileage(value) {

        return new Intl.NumberFormat(
            'de-DE'
        ).format(value) + ' km';

    }


    /*
    |--------------------------------------------------------------------------
    | Update mileage values
    |--------------------------------------------------------------------------
    */

    function updateMileageValues(
        minValue,
        maxValue
    ) {

        minValue =
            Math.round(minValue);

        maxValue =
            Math.round(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Display values above slider
        |--------------------------------------------------------------------------
        */

        minDisplay.textContent =
            formatMileage(minValue);


        maxDisplay.textContent =
            formatMileage(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Hidden Laravel value
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | 25000-150000
        |
        */

        if (
            minValue === Math.round(dbMinMileage) &&
            maxValue === Math.round(dbMaxMileage)
        ) {

            mileageRangeInput.value = '';

        } else {

            mileageRangeInput.value =
                minValue + '-' + maxValue;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize slider
    |--------------------------------------------------------------------------
    */

    const $slider =
        jQuery(slider);


    $slider.slider({

        range: true,


        /*
        |--------------------------------------------------------------------------
        | Real DB minimum
        |--------------------------------------------------------------------------
        */

        min:
            Math.round(dbMinMileage),


        /*
        |--------------------------------------------------------------------------
        | Real DB maximum
        |--------------------------------------------------------------------------
        */

        max:
            Math.round(dbMaxMileage),


        /*
        |--------------------------------------------------------------------------
        | Every 1 kilometer
        |--------------------------------------------------------------------------
        */

        step: 1,


        /*
        |--------------------------------------------------------------------------
        | Initial handles
        |--------------------------------------------------------------------------
        */

        values: [

            Math.round(selectedMin),

            Math.round(selectedMax)

        ],


        /*
        |--------------------------------------------------------------------------
        | While dragging
        |--------------------------------------------------------------------------
        */

        slide: function (event, ui) {

            updateMileageValues(

                ui.values[0],

                ui.values[1]

            );

        },


        /*
        |--------------------------------------------------------------------------
        | After changing
        |--------------------------------------------------------------------------
        */

        change: function (event, ui) {

            updateMileageValues(

                ui.values[0],

                ui.values[1]

            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Initial display
    |--------------------------------------------------------------------------
    */

    const initialValues =
        $slider.slider('values');


    updateMileageValues(

        initialValues[0],

        initialValues[1]

    );

});

</script>




<script>

document.addEventListener('DOMContentLoaded', function () {

    const slider =
        document.getElementById('registration_slider');

    const minDisplay =
        document.getElementById(
            'registration-min-display'
        );

    const maxDisplay =
        document.getElementById(
            'registration-max-display'
        );

    const registrationRangeInput =
        document.getElementById(
            'first_registration_range'
        );


    /*
    |--------------------------------------------------------------------------
    | Safety checks
    |--------------------------------------------------------------------------
    */

    if (
        !slider ||
        !minDisplay ||
        !maxDisplay ||
        !registrationRangeInput
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery
    |--------------------------------------------------------------------------
    */

    if (typeof jQuery === 'undefined') {

        console.error(
            'jQuery is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery UI Slider
    |--------------------------------------------------------------------------
    */

    if (
        typeof jQuery.fn.slider === 'undefined'
    ) {

        console.error(
            'jQuery UI Slider is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Database min / max registration year
    |--------------------------------------------------------------------------
    */

    const dbMinYear =
        parseInt(
            slider.dataset.min,
            10
        );

    const dbMaxYear =
        parseInt(
            slider.dataset.max,
            10
        );


    /*
    |--------------------------------------------------------------------------
    | Validate database range
    |--------------------------------------------------------------------------
    */

    if (
        isNaN(dbMinYear) ||
        isNaN(dbMaxYear) ||
        dbMinYear > dbMaxYear
    ) {

        console.error(
            'Invalid registration year range:',
            dbMinYear,
            dbMaxYear
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Read existing URL range
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | ?first_registration_range=2018-2024
    |
    */

    const urlParams =
        new URLSearchParams(
            window.location.search
        );


    const existingRange =
        urlParams.get(
            'first_registration_range'
        );


    let selectedMin =
        dbMinYear;

    let selectedMax =
        dbMaxYear;


    /*
    |--------------------------------------------------------------------------
    | Restore existing registration filter
    |--------------------------------------------------------------------------
    */

    if (existingRange) {

        const parts =
            existingRange.split('-');


        if (parts.length === 2) {

            const urlMin =
                parseInt(
                    parts[0],
                    10
                );

            const urlMax =
                parseInt(
                    parts[1],
                    10
                );


            if (!isNaN(urlMin)) {

                selectedMin =
                    Math.max(
                        dbMinYear,
                        Math.min(
                            urlMin,
                            dbMaxYear
                        )
                    );

            }


            if (!isNaN(urlMax)) {

                selectedMax =
                    Math.max(
                        dbMinYear,
                        Math.min(
                            urlMax,
                            dbMaxYear
                        )
                    );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Safety
    |--------------------------------------------------------------------------
    */

    if (selectedMin > selectedMax) {

        selectedMin =
            dbMinYear;

        selectedMax =
            dbMaxYear;

    }


    /*
    |--------------------------------------------------------------------------
    | Update display + hidden Laravel value
    |--------------------------------------------------------------------------
    */

    function updateRegistrationValues(
        minValue,
        maxValue
    ) {

        minValue =
            Math.round(minValue);

        maxValue =
            Math.round(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Display
        |--------------------------------------------------------------------------
        */

        minDisplay.textContent =
            minValue;

        maxDisplay.textContent =
            maxValue;


        /*
        |--------------------------------------------------------------------------
        | Hidden Laravel value
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | 2018-2024
        |
        */

        if (
            minValue === dbMinYear &&
            maxValue === dbMaxYear
        ) {

            registrationRangeInput.value = '';

        } else {

            registrationRangeInput.value =
                minValue + '-' + maxValue;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize jQuery UI slider
    |--------------------------------------------------------------------------
    */

    const $slider =
        jQuery(slider);


    $slider.slider({

        /*
        |--------------------------------------------------------------------------
        | Two handles
        |--------------------------------------------------------------------------
        */

        range: true,


        /*
        |--------------------------------------------------------------------------
        | Database minimum year
        |--------------------------------------------------------------------------
        */

        min:
            dbMinYear,


        /*
        |--------------------------------------------------------------------------
        | Database maximum year
        |--------------------------------------------------------------------------
        */

        max:
            dbMaxYear,


        /*
        |--------------------------------------------------------------------------
        | One year at a time
        |--------------------------------------------------------------------------
        */

        step: 1,


        /*
        |--------------------------------------------------------------------------
        | Initial handles
        |--------------------------------------------------------------------------
        */

        values: [

            selectedMin,

            selectedMax

        ],


        /*
        |--------------------------------------------------------------------------
        | While dragging
        |--------------------------------------------------------------------------
        */

        slide: function (
            event,
            ui
        ) {

            updateRegistrationValues(

                ui.values[0],

                ui.values[1]

            );

        },


        /*
        |--------------------------------------------------------------------------
        | After changing
        |--------------------------------------------------------------------------
        */

        change: function (
            event,
            ui
        ) {

            updateRegistrationValues(

                ui.values[0],

                ui.values[1]

            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Initial display
    |--------------------------------------------------------------------------
    */

    const initialValues =
        $slider.slider('values');


    updateRegistrationValues(

        initialValues[0],

        initialValues[1]

    );

});

</script>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const slider =
        document.getElementById('slider_power_hp');

    const minDisplay =
        document.getElementById('power-hp-min-display');

    const maxDisplay =
        document.getElementById('power-hp-max-display');

    const powerHpRangeInput =
        document.getElementById('power_hp_range');


    /*
    |--------------------------------------------------------------------------
    | Safety checks
    |--------------------------------------------------------------------------
    */

    if (
        !slider ||
        !minDisplay ||
        !maxDisplay ||
        !powerHpRangeInput
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery
    |--------------------------------------------------------------------------
    */

    if (typeof jQuery === 'undefined') {

        console.error('jQuery is not loaded.');

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check jQuery UI Slider
    |--------------------------------------------------------------------------
    */

    if (typeof jQuery.fn.slider === 'undefined') {

        console.error(
            'jQuery UI Slider is not loaded.'
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Database min / max
    |--------------------------------------------------------------------------
    */

    const dbMinPowerHp =
        parseFloat(slider.dataset.min);

    const dbMaxPowerHp =
        parseFloat(slider.dataset.max);


    if (
        isNaN(dbMinPowerHp) ||
        isNaN(dbMaxPowerHp) ||
        dbMinPowerHp > dbMaxPowerHp
    ) {

        console.error(
            'Invalid Power HP range:',
            dbMinPowerHp,
            dbMaxPowerHp
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Read existing URL range
    |--------------------------------------------------------------------------
    |
    | Example:
    |
    | ?power_hp_range=100-250
    |
    */

    const urlParams =
        new URLSearchParams(window.location.search);

    const existingRange =
        urlParams.get('power_hp_range');


    let selectedMin = dbMinPowerHp;
    let selectedMax = dbMaxPowerHp;


    /*
    |--------------------------------------------------------------------------
    | Restore existing Power HP filter
    |--------------------------------------------------------------------------
    */

    if (existingRange) {

        const parts =
            existingRange.split('-');


        if (parts.length === 2) {

            const urlMin =
                parseFloat(parts[0]);

            const urlMax =
                parseFloat(parts[1]);


            if (!isNaN(urlMin)) {

                selectedMin = Math.max(
                    dbMinPowerHp,
                    Math.min(
                        urlMin,
                        dbMaxPowerHp
                    )
                );

            }


            if (!isNaN(urlMax)) {

                selectedMax = Math.max(
                    dbMinPowerHp,
                    Math.min(
                        urlMax,
                        dbMaxPowerHp
                    )
                );

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Safety
    |--------------------------------------------------------------------------
    */

    if (selectedMin > selectedMax) {

        selectedMin = dbMinPowerHp;
        selectedMax = dbMaxPowerHp;

    }


    /*
    |--------------------------------------------------------------------------
    | Format Power HP
    |--------------------------------------------------------------------------
    */

    function formatPowerHp(value) {

        return new Intl.NumberFormat('de-DE', {

            maximumFractionDigits: 0

        }).format(value) + ' PS';

    }


    /*
    |--------------------------------------------------------------------------
    | Update displayed values + hidden Laravel value
    |--------------------------------------------------------------------------
    */

    function updatePowerHpValues(
        minValue,
        maxValue
    ) {

        minValue =
            Math.round(minValue);

        maxValue =
            Math.round(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Display above slider
        |--------------------------------------------------------------------------
        */

        minDisplay.textContent =
            formatPowerHp(minValue);

        maxDisplay.textContent =
            formatPowerHp(maxValue);


        /*
        |--------------------------------------------------------------------------
        | Hidden value for Laravel
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | 100-250
        |
        */

        if (
            minValue === Math.round(dbMinPowerHp) &&
            maxValue === Math.round(dbMaxPowerHp)
        ) {

            powerHpRangeInput.value = '';

        } else {

            powerHpRangeInput.value =
                minValue + '-' + maxValue;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Initialize slider
    |--------------------------------------------------------------------------
    */

    const $slider =
        jQuery(slider);


    $slider.slider({

        range: true,


        /*
        |--------------------------------------------------------------------------
        | Real DB minimum
        |--------------------------------------------------------------------------
        */

        min:
            Math.round(dbMinPowerHp),


        /*
        |--------------------------------------------------------------------------
        | Real DB maximum
        |--------------------------------------------------------------------------
        */

        max:
            Math.round(dbMaxPowerHp),


        /*
        |--------------------------------------------------------------------------
        | Every 1 PS
        |--------------------------------------------------------------------------
        */

        step: 1,


        /*
        |--------------------------------------------------------------------------
        | Initial handles
        |--------------------------------------------------------------------------
        */

        values: [

            Math.round(selectedMin),

            Math.round(selectedMax)

        ],


        /*
        |--------------------------------------------------------------------------
        | While dragging
        |--------------------------------------------------------------------------
        */

        slide: function (event, ui) {

            updatePowerHpValues(

                ui.values[0],

                ui.values[1]

            );

        },


        /*
        |--------------------------------------------------------------------------
        | After changing
        |--------------------------------------------------------------------------
        */

        change: function (event, ui) {

            updatePowerHpValues(

                ui.values[0],

                ui.values[1]

            );

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Initial display
    |--------------------------------------------------------------------------
    */

    const initialValues =
        $slider.slider('values');


    updatePowerHpValues(

        initialValues[0],

        initialValues[1]

    );

});

</script>




@endsection


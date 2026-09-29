<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auto;
use App\Models\Brand;
use App\Models\VehicleModel;
use App\Models\BodyType;
use App\Models\FuelType;
use App\Models\Color;
use App\Models\Transmission;
use App\Models\VehicleCondition;
use App\Models\AutoImage;


class FrontendListController extends Controller
{
    
    
 public function FrontendFahrzeugListing(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | Selected Brands
    |--------------------------------------------------------------------------
    */

    $filter_brand = $request->input('brand', []);

    if (!is_array($filter_brand)) {
        $filter_brand = explode(',', $filter_brand);
    }

    $filter_brand = array_filter($filter_brand);

    $brand_ids = [];

    if (!empty($filter_brand)) {

        $brand_ids = Brand::whereIn('slug', $filter_brand)
            ->pluck('id')
            ->toArray();

        if (!empty($brand_ids)) {
            $autopost5 = Auto::query()
                ->whereIn('brand_id', $brand_ids);
        } else {
            $autopost5 = Auto::query();
        }

    } else {
        $autopost5 = Auto::query();
    }


    /*
    |--------------------------------------------------------------------------
    | Model Filter
    |--------------------------------------------------------------------------
    */

    $filter_model = $request->input('model', []);

    if (!is_array($filter_model)) {
        $filter_model = explode(',', $filter_model);
    }

    $filter_model = array_filter($filter_model);

    if (!empty($filter_model)) {

        $model_ids = VehicleModel::whereIn('slug', $filter_model)
            ->pluck('id')
            ->toArray();

        if (!empty($model_ids)) {
            $autopost5->whereIn(
                'vehicle_model_id',
                $model_ids
            );
        }
    }
    
    
        /*
    |--------------------------------------------------------------------------
    | Selected Body Types
    |--------------------------------------------------------------------------
    */

    $filter_body_type = $request->input('body_type', []);

    if (!is_array($filter_body_type)) {
        $filter_body_type = explode(',', $filter_body_type);
    }

    $filter_body_type = array_filter($filter_body_type);
    
    
        if (!empty($filter_body_type)) {

        $body_type_ids = BodyType::whereIn(
                'slug',
                $filter_body_type
            )
            ->pluck('id')
            ->toArray();

        if (!empty($body_type_ids)) {

            $autopost5->whereIn(
                'body_type_id',
                $body_type_ids
            );

        }
    }
    
    
    
/*
|--------------------------------------------------------------------------
| Price Range Filter
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Price Range Filter
|--------------------------------------------------------------------------
*/

$priceRange = $request->input('price_range');

if (!empty($priceRange)) {

    $priceParts = explode('-', $priceRange);

    if (count($priceParts) === 2) {

        /*
        |--------------------------------------------------------------------------
        | Convert German formatted numbers
        |--------------------------------------------------------------------------
        |
        | 23.525  -> 23525
        | 23,525  -> 23525
        | 23525   -> 23525
        | 725     -> 725
        |
        */

        $minPriceString = str_replace(
            ['.', ','],
            '',
            trim($priceParts[0])
        );

        $maxPriceString = str_replace(
            ['.', ','],
            '',
            trim($priceParts[1])
        );


        if (
            is_numeric($minPriceString) &&
            is_numeric($maxPriceString)
        ) {

            $minPrice = (int) $minPriceString;
            $maxPrice = (int) $maxPriceString;


            /*
            |--------------------------------------------------------------------------
            | Make sure min <= max
            |--------------------------------------------------------------------------
            */

            if ($minPrice > $maxPrice) {

                [$minPrice, $maxPrice] =
                    [$maxPrice, $minPrice];

            }


            /*
            |--------------------------------------------------------------------------
            | Filter Cars
            |--------------------------------------------------------------------------
            */

            $autopost5->whereBetween(
                'price',
                [$minPrice, $maxPrice]
            );

        }
    }
}




/*
|--------------------------------------------------------------------------
| Mileage / Kilometer Range Filter
|--------------------------------------------------------------------------
*/

$mileageRange =
    $request->input('mileage_range');


if (!empty($mileageRange)) {

    $mileageParts =
        explode('-', $mileageRange);


    if (count($mileageParts) === 2) {

        /*
        |--------------------------------------------------------------------------
        | Convert formatted numbers
        |--------------------------------------------------------------------------
        |
        | 25.000 -> 25000
        | 150.000 -> 150000
        | 25000 -> 25000
        |
        */

        $minMileageString =
            str_replace(
                ['.', ','],
                '',
                trim($mileageParts[0])
            );


        $maxMileageString =
            str_replace(
                ['.', ','],
                '',
                trim($mileageParts[1])
            );


        if (
            is_numeric($minMileageString) &&
            is_numeric($maxMileageString)
        ) {

            $minMileage =
                (int) $minMileageString;


            $maxMileage =
                (int) $maxMileageString;


            /*
            |--------------------------------------------------------------------------
            | Make sure min <= max
            |--------------------------------------------------------------------------
            */

            if ($minMileage > $maxMileage) {

                [
                    $minMileage,
                    $maxMileage
                ] = [
                    $maxMileage,
                    $minMileage
                ];

            }


            /*
            |--------------------------------------------------------------------------
            | Filter Cars
            |--------------------------------------------------------------------------
            */

            $autopost5->whereBetween(
                'mileage',
                [
                    $minMileage,
                    $maxMileage
                ]
            );

        }

    }

}



        /*
        |--------------------------------------------------------------------------
        | First Registration Range Filter
        |--------------------------------------------------------------------------
        */

        $registrationRange = $request->input('first_registration_range');

        if (!empty($registrationRange)) {

            $registrationParts = explode(
                '-',
                $registrationRange
            );

            if (count($registrationParts) === 2) {

                $minRegistrationYear =
                    (int) trim($registrationParts[0]);

                $maxRegistrationYear =
                    (int) trim($registrationParts[1]);


                /*
                |--------------------------------------------------------------------------
                | Make sure min <= max
                |--------------------------------------------------------------------------
                */

                if (
                    $minRegistrationYear > 0 &&
                    $maxRegistrationYear > 0
                ) {

                    if (
                        $minRegistrationYear >
                        $maxRegistrationYear
                    ) {

                        [
                            $minRegistrationYear,
                            $maxRegistrationYear
                        ] = [
                            $maxRegistrationYear,
                            $minRegistrationYear
                        ];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Convert Years To Full Dates
                    |--------------------------------------------------------------------------
                    |
                    | Example:
                    |
                    | 2018 -> 2018-01-01
                    | 2024 -> 2024-12-31
                    |
                    */

                    $registrationStart =
                        $minRegistrationYear . '-01-01';

                    $registrationEnd =
                        $maxRegistrationYear . '-12-31';


                    /*
                    |--------------------------------------------------------------------------
                    | Filter Cars
                    |--------------------------------------------------------------------------
                    */

                    $autopost5->whereBetween(
                        'first_registration',
                        [
                            $registrationStart,
                            $registrationEnd
                        ]
                    );

                }

            }

        }



        /*
        |--------------------------------------------------------------------------
        | Selected Fuel Types
        |--------------------------------------------------------------------------
        */

        $filter_fuel_type = $request->input('fuel_type', []);

        if (!is_array($filter_fuel_type)) {
            $filter_fuel_type = explode(',', $filter_fuel_type);
        }

        $filter_fuel_type = array_filter($filter_fuel_type);


        /*
        |--------------------------------------------------------------------------
        | Fuel Type Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($filter_fuel_type)) {

            $fuel_type_ids = FuelType::whereIn(
                'slug',
                $filter_fuel_type
            )
            ->pluck('id')
            ->toArray();


            if (!empty($fuel_type_ids)) {

                $autopost5->whereIn(
                    'fuel_type_id',
                    $fuel_type_ids
                );

            }
        }



        /*
        |--------------------------------------------------------------------------
        | Power HP Range Filter
        |--------------------------------------------------------------------------
        */

        $powerHpRange = $request->input('power_hp_range');

        if (!empty($powerHpRange)) {

            $powerHpParts = explode('-', $powerHpRange);

            if (count($powerHpParts) === 2) {

                /*
                |--------------------------------------------------------------------------
                | Convert values to numbers
                |--------------------------------------------------------------------------
                */

                $minPowerHpString = str_replace(
                    ['.', ','],
                    '',
                    trim($powerHpParts[0])
                );

                $maxPowerHpString = str_replace(
                    ['.', ','],
                    '',
                    trim($powerHpParts[1])
                );


                if (
                    is_numeric($minPowerHpString) &&
                    is_numeric($maxPowerHpString)
                ) {

                    $minPowerHp = (int) $minPowerHpString;
                    $maxPowerHp = (int) $maxPowerHpString;


                    /*
                    |--------------------------------------------------------------------------
                    | Make sure min <= max
                    |--------------------------------------------------------------------------
                    */

                    if ($minPowerHp > $maxPowerHp) {

                        [$minPowerHp, $maxPowerHp] = [
                            $maxPowerHp,
                            $minPowerHp
                        ];

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Filter Cars
                    |--------------------------------------------------------------------------
                    */

                    $autopost5->whereBetween(
                        'power_hp',
                        [$minPowerHp, $maxPowerHp]
                    );

                }
            }
        }



        /*
        |--------------------------------------------------------------------------
        | Selected Colors
        |--------------------------------------------------------------------------
        */

        $filter_color = $request->input('color', []);

        if (!is_array($filter_color)) {
            $filter_color = explode(',', $filter_color);
        }

        $filter_color = array_filter($filter_color);


        /*
        |--------------------------------------------------------------------------
        | Color Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($filter_color)) {

            $color_ids = Color::whereIn(
                'slug',
                $filter_color
            )
            ->pluck('id')
            ->toArray();


            if (!empty($color_ids)) {

                $autopost5->whereIn(
                    'color_id',
                    $color_ids
                );

            }
        }




        /*
        |--------------------------------------------------------------------------
        | Selected Transmissions
        |--------------------------------------------------------------------------
        */

        $filter_transmission = $request->input('transmission', []);

        if (!is_array($filter_transmission)) {
            $filter_transmission = explode(',', $filter_transmission);
        }

        $filter_transmission = array_filter($filter_transmission);


        /*
        |--------------------------------------------------------------------------
        | Transmission Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($filter_transmission)) {

            $transmission_ids = Transmission::whereIn(
                'slug',
                $filter_transmission
            )
            ->pluck('id')
            ->toArray();


            if (!empty($transmission_ids)) {

                $autopost5->whereIn(
                    'transmission_id',
                    $transmission_ids
                );

            }
        }
        
        
        
        
               // Sort by filter     
    
        if (!empty($_GET['sortBy'])) {
            $sort = $_GET['sortBy'];
            switch ($sort) {
                case 'Niedrigster-Preis':
                    $autopost5->orderBy('price', 'ASC');
                    break;
                case 'Höchster-Preis':
                    $autopost5->orderBy('price', 'DESC');
                    break;

            }
        }


        
         /*
    |--------------------------------------------------------------------------
    | General Search
    |--------------------------------------------------------------------------
    */

    $search = trim($request->input('search', ''));

    if ($search !== '') {

        $autopost5->where(function ($query) use ($search) {

            /*
            |--------------------------------------------------------------------------
            | Auto table fields
            |--------------------------------------------------------------------------
            */

            $query->where('title', 'LIKE', '%' . $search . '%')
                ->orWhere('stock_number', 'LIKE', '%' . $search . '%')
                ->orWhere('variant', 'LIKE', '%' . $search . '%')
                ->orWhere('vin', 'LIKE', '%' . $search . '%');


            /*
            |--------------------------------------------------------------------------
            | Brand
            |--------------------------------------------------------------------------
            */

            $query->orWhereHas('brand', function ($brandQuery) use ($search) {

                $brandQuery->where(
                    'name',
                    'LIKE',
                    '%' . $search . '%'
                );

            });


            /*
            |--------------------------------------------------------------------------
            | Vehicle Model
            |--------------------------------------------------------------------------
            */

            $query->orWhereHas('model', function ($modelQuery) use ($search) {

                $modelQuery->where(
                    'name',
                    'LIKE',
                    '%' . $search . '%'
                );

            });

        });

    }
    
    
    
            /*
        |--------------------------------------------------------------------------
        | Selected Vehicle Conditions
        |--------------------------------------------------------------------------
        */

        $filter_condition = $request->input('condition', []);

        if (!is_array($filter_condition)) {
            $filter_condition = explode(',', $filter_condition);
        }

        $filter_condition = array_filter($filter_condition);


        /*
        |--------------------------------------------------------------------------
        | Vehicle Condition Filter
        |--------------------------------------------------------------------------
        */

        if (!empty($filter_condition)) {

            $condition_ids = VehicleCondition::whereIn(
                'slug',
                $filter_condition
            )
            ->pluck('id')
            ->toArray();


            if (!empty($condition_ids)) {

                $autopost5->whereIn(
                    'condition_id',
                    $condition_ids
                );

            }
        }


    /*
    |--------------------------------------------------------------------------
    | Vehicle Listing
    |--------------------------------------------------------------------------
    */

    $autopost = $autopost5
        ->withCount('images')
        ->orderByDesc('id')
        ->paginate(20)
        ->withQueryString();


    /*
    |--------------------------------------------------------------------------
    | ALL Brands
    |--------------------------------------------------------------------------
    */

    $brands = Brand::with('autoPostWithBrand')
        ->whereHas('autos')
        ->withCount('autos')
        ->orderBy('name', 'ASC')
        ->get();


    /*
    |--------------------------------------------------------------------------
    | ALL Models
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Do NOT filter models by selected brands here.
    |
    | JavaScript will show/hide models according
    | to the selected Brand.
    |
    */

    $models = VehicleModel::with('autoPostWithModel')
        ->whereHas('autos')
        ->withCount('autos')
        ->orderBy('name', 'ASC')
        ->get();
    
    
        /*
    |--------------------------------------------------------------------------
    | ALL Body Types
    |--------------------------------------------------------------------------
    */

    $bodyTypes = BodyType::with('autos')
        ->whereHas('autos')
        ->withCount('autos')
        ->where('is_active', true)
        ->orderBy('sort_order', 'ASC')
        ->orderBy('name', 'ASC')
        ->get();
    
    
    /*
    |--------------------------------------------------------------------------
    | ALL Fuel Types
    |--------------------------------------------------------------------------
    */

    $fuelTypes = FuelType::orderBy(
        'name',
        'ASC'
    )
         ->whereHas('autos')
        ->withCount('autos')
         ->get();
    
    
    
    /*
    |--------------------------------------------------------------------------
    | ALL Colors
    |--------------------------------------------------------------------------
    */

    $colors = Color::orderBy('name', 'ASC')
             ->whereHas('autos')
             ->withCount('autos')
             ->get();
    
    
    /*
|--------------------------------------------------------------------------
| ALL Transmissions
|--------------------------------------------------------------------------
*/

$transmissions = Transmission::where('is_active', true)
         ->whereHas('autos')
        ->withCount('autos')
    ->orderBy('sort_order', 'ASC')
    ->orderBy('name', 'ASC')
    ->get();



      // sort by filter input by request
     $sort = $request->sortBy;
     
         /*
    |--------------------------------------------------------------------------
    | General Search
    |--------------------------------------------------------------------------
    */

    $search = trim($request->input('search', ''));
    
    
    /*
    |--------------------------------------------------------------------------
    | ALL Vehicle Conditions
    |--------------------------------------------------------------------------
    */

    $vehicleConditions = VehicleCondition::where('is_active', true)
        ->whereHas('autos')
        ->withCount('autos')
        ->orderBy('name', 'ASC')
        ->get();
     
    return view(
        'frontend.pages.fahrzeugliste',
        compact(
            'autopost',
            'brands',
            'models',
            'bodyTypes',
             'fuelTypes',
             'colors',
            'transmissions',
            'vehicleConditions',
            'filter_brand',
            'filter_model',
            'filter_body_type',
            'filter_fuel_type',
            'filter_color',
            'filter_transmission',
            'sort',
            'search',
            'filter_condition',
        )
    );
}




    public function FrontendSockenPostFilter(Request $request) {


        $data = $request->all();
        
        
        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

                
         $sortByUrl = '';
         if(!empty($data['sortBy'])){        // ['sortBy'] is select name
             
              $sortByUrl .= '&sortBy='.$data['sortBy'] ;
             
         }

        ////  START  brand

        $brandUrl = '';

        if (!empty($data['brand'])) {         // ['brand'] is checkbox input field name
            //   dd($data);
            foreach ($data['brand'] as $brand) {

                if (!empty($brandUrl)) {

                    $brandUrl .= ',' . $brand;
                } else {

                    $brandUrl .= '&brand=' . $brand;
                }
            }
        }

        ////  END  brand
        ////  START  model

        $modelUrl = '';

        if (!empty($data['model'])) {         // ['model'] is checkbox input field name
            //   dd($data);
            foreach ($data['model'] as $model) {

                if (!empty($modelUrl)) {

                    $modelUrl .= ',' . $model;
                } else {

                    $modelUrl .= '&model=' . $model;
                }
            }
        }

        ////  END  model
        
        
       ////  Body Type

        $body_typeUrl = '';

        if (!empty($data['body_type'])) {         // ['body_type'] is checkbox input field name
            //   dd($data);
            foreach ($data['body_type'] as $model) {

                if (!empty($body_typeUrl)) {

                    $body_typeUrl .= ',' . $model;
                } else {

                    $body_typeUrl .= '&body_type=' . $model;
                }
            }
        }

        ////  Body Type
        
        
           ////  START get Price range 
         
        ///  START get kauf Price range filtering based on URL 
         
            $priceRangeURL='';
            
            if(!empty($data['price_range'])){   // ['price_range'] is requested input field name
                
                $priceRangeURL .= '&price_range=' . $data['price_range'];
            }
        
         ////  END get kaufPrice range 
            
            
            $mileageRangeURL = ''; 
            
            if (!empty($data['mileage_range'])) { 
                
                $mileageRangeURL = '&mileage_range=' . $data['mileage_range']; 
                
            }
               
            
            
                            /*
                |--------------------------------------------------------------------------
                | START First Registration range
                |--------------------------------------------------------------------------
                */

                $registrationRangeURL = '';

                if (!empty($data['first_registration_range'])) {

                    $registrationRangeURL .=
                        '&first_registration_range=' .
                        $data['first_registration_range'];

                }

                /*
                |--------------------------------------------------------------------------
                | END First Registration range
                |--------------------------------------------------------------------------
                */
            
                
                
                /*
            |--------------------------------------------------------------------------
            | START Fuel Type
            |--------------------------------------------------------------------------
            */

            $fuel_typeUrl = '';

            if (!empty($data['fuel_type'])) {

                foreach ($data['fuel_type'] as $fuelType) {

                    if (!empty($fuel_typeUrl)) {

                        $fuel_typeUrl .= ',' . $fuelType;

                    } else {

                        $fuel_typeUrl .= '&fuel_type=' . $fuelType;

                    }

                }
            }

            /*
            |--------------------------------------------------------------------------
            | END Fuel Type
            |--------------------------------------------------------------------------
            */
            
            
            
            /*
        |--------------------------------------------------------------------------
        | START Color
        |--------------------------------------------------------------------------
        */

        $colorUrl = '';

        if (!empty($data['color'])) {

            foreach ($data['color'] as $color) {

                if (!empty($colorUrl)) {

                    $colorUrl .= ',' . $color;

                } else {

                    $colorUrl .= '&color=' . $color;

                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | END Color
        |--------------------------------------------------------------------------
        */
            
            
            
        /* 
         |--------------------------------------------------------------------------
         | Power HP Range 
         |--------------------------------------------------------------------------
          */ 


        $powerHpRangeURL = ''; 

        if (!empty($data['power_hp_range'])) 
        { 
            $powerHpRangeURL .= '&power_hp_range=' . $data['power_hp_range']; 
        }
        
        
        
        
        /*
        |--------------------------------------------------------------------------
        | START Transmission
        |--------------------------------------------------------------------------
        */

        $transmissionUrl = '';

        if (!empty($data['transmission'])) {

            foreach ($data['transmission'] as $transmission) {

                if (!empty($transmissionUrl)) {

                    $transmissionUrl .= ',' . $transmission;

                } else {

                    $transmissionUrl .= '&transmission=' . $transmission;

                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | END Transmission
        |--------------------------------------------------------------------------
        */
        
        
        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $searchUrl = '';

        if (!empty($data['search'])) {

            $searchUrl =
                '&search=' . urlencode(trim($data['search']));
        }
        
        
        
        /*
    |--------------------------------------------------------------------------
    | START Vehicle Condition
    |--------------------------------------------------------------------------
    */

    $conditionUrl = '';

    if (!empty($data['condition'])) {

        foreach ($data['condition'] as $condition) {

            if (!empty($conditionUrl)) {

                $conditionUrl .= ',' . $condition;

            } else {

                $conditionUrl .= '&condition=' . $condition;

            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | END Vehicle Condition
    |--------------------------------------------------------------------------
    */



        return redirect()->route('fahrzeug.post.listing', $brandUrl . $modelUrl .$body_typeUrl .$priceRangeURL
                .$mileageRangeURL.$registrationRangeURL .$fuel_typeUrl .$powerHpRangeURL . $colorUrl .$transmissionUrl .$sortByUrl .$searchUrl.$conditionUrl);
        
        
    }
    
    
    
    
        public function FrontendPageSlug($slug)
        {
            $fahrzeugpostdetail = Auto::where('slug', $slug)->first();

            if ($fahrzeugpostdetail) {

                $fahrzeugpostimages = AutoImage::where(
                    'auto_id',
                    $fahrzeugpostdetail->id
                )
                ->orderByDesc('is_primary')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

                return view(
                    'frontend.pages.fahrzeugdetail',
                    compact(
                        'fahrzeugpostdetail',
                        'fahrzeugpostimages'
                    )
                );

            } else {

                return redirect()->route('fronthome');
            }
        }
    
    
    


    
}  // END

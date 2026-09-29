/* JS Document */

/******************************
[Table of Contents]

1. Applied filter

******************************/


    
    /* start Applied fiter Tag */
        
    /* start Applied fiter Tag */
        
    /* start Applied fiter Tag */

$(document).ready(function() {
    appliedFiters();

    function appliedFiters() {

        let possibleParameters = [
            
            "brand",
            
            "model",
            "body_type",
            "price_range",
            "mileage_range",
             "first_registration_range",
             "fuel_type",
             "power_hp_range",
             "color",
             "transmission",
             "sortBy",
             "search",
             "condition"
            
  
        ];

        // Mapping custom texts for specific parameters (optional)
        let customTexts = {
            "brand": "Marke",
            "model": "Modell",
            "body_type": "Fahrzeugtyp ",

        };

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Function to replace hyphens with spaces for non-price parameters
        function formatParameterValue(value) {
            return value.replace(/-/g, ' ');  // Replace all hyphens with spaces
        }

        let params = new URL(location).searchParams; 
        let element = $("#applied_filter ul");
        let clearTag = `<li class="btn btn-danger btn-sm" style="margin:5px;" onclick="removeFilter()" style="background:firebrick"><span>Alles löschen</span></li>`;
        
        let isAny = false;
        
        for (let index = 0; index < possibleParameters.length; index++) {
            const x = possibleParameters[index];
            var tag = "";
            
            if (!params.has(x) || !params.get(x)) {
                continue;
            }

            isAny = true;
            
            var selected = params.get(x).split(",");
            let formattedValue = "";

            // Handle price and price1 specially (two values with hyphen between them)
            if (x === "price" || x === "price1") {
                if (selected.length === 2) {
                    // Join the two values with a hyphen (min-max)
                    formattedValue = `${selected[0]} - ${selected[1]}`;
                } else {
                    formattedValue = selected.join(" - "); // Fallback if more than two values
                }
            } else {
                // For other parameters, decode and format the values normally
                selected.forEach(val => {
                    val = decodeURIComponent(val);
                    val = formatParameterValue(val);  // Replace hyphens with spaces
                    formattedValue += `${capitalizeFirstLetter(val)}, `;
                });

                // Remove trailing comma and space
                formattedValue = formattedValue.slice(0, -2);
            }

            // Check if there's a custom text for the current parameter
            let customText = customTexts[x] ? customTexts[x] : capitalizeFirstLetter(x);
            
            // Use the custom text or the value itself if no custom text is set
            tag = `<li class="btn btn-secondaryXX btn-sm" style="margin:5px;background-color:#d6d6d6;" onclick="removeFilter('${x}','${formattedValue}')">
                        <span style="margin-right:4px;">${customText}: ${formattedValue}</span>
                        <i class="fa fa-times"></i>
                    </li>`;
            
            element.append(tag);
        }
        
        if (isAny) {
            element.append(clearTag);
        }
    }
});






    function removeFilter(filter, val) {

        let possibleParameters = [
                "brand",
                "model",
                "body_type",
                "price_range",
                "mileage_range",
                "first_registration_range",
                 "fuel_type",
                 "power_hp_range",
                 "color",
                 "transmission",
                 "sortBy",
                 "search",
                 "condition"

        ];
        let url = new URL(location);
        if (filter) {

            if (filter.includes("jahresumsatz_price")) {
                url.searchParams.delete(filter);
            } 
           else if (filter.includes("langzeitvertrage_price")) {
                url.searchParams.delete(filter);
            }
           else if (filter.includes("operatives_price")) {
                url.searchParams.delete(filter);
            }
            else if (filter.includes("mitarbeiter")) {
                url.searchParams.delete(filter);
            }
            else {
                let all = url.searchParams.get(filter).split(",");
                all.splice(all.indexOf(val), 1);
                url.searchParams.set(filter, all.join(","));
            }
        } else {
            possibleParameters.forEach(x => {
                url.searchParams.delete(x)
            });
        }

        window.location = url.href;
    }
    
    
     /* end Applied fiter Tag */
     /* end Applied fiter Tag */
     /* end Applied fiter Tag */
     
    

  /* Ausgewählt Filter Tag hide and show */
  
        $(document).ready(function() {
            // Function to get URL parameters
            function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
                return false;
            }

            // List of parameters to check
            var parametersToCheck = ['brand', 'model','body_type','price_range', 'mileage_range', 'first_registration_range', 
                'fuel_type', 'power_hp_range','color','transmission','sortBy','search','condition'];

            // Flag to check if any parameter is found
            var parameterFound = false;

            // Check if any of the parameters are present in the URL
            for (var i = 0; i < parametersToCheck.length; i++) {
                if (getUrlParameter(parametersToCheck[i])) {
                    parameterFound = true;
                    break;
                }
            }


         

            // If any parameter is found, display the div
            if (parameterFound) {
                $('#filter').removeClass('none');
                $('#filter').show();
            }else {
                $('#filter').hide();
            }
        });
 
 /* end Ausgewählt Filter Tag hide and show */
    
       
    /* start price range */    
    
      

    
    /* end price range */  
    
    
    
     /* start discount range */    
    
         
$(document).ready(function(){
    if ($("#slider_range1").length > 0) {
        const max_value = parseInt( $("#slider_range1").data('max') ) || 500;
        const min_value = parseInt($("#slider_range1").data('min')) || 0;
        const currency = $("#slider_range1").data('currency') || '';
        let price_range1 = min_value + '-' + max_value;
        if($("#price_range1").length > 0 && $("#price_range1").val()){
            price_range1 = $("#price_range1").val().trim();
        }

        let price1 = price_range1.split('-');
        $("#slider_range1").slider({
            range: true,
            min: min_value,
            max: max_value,
            values: price1,
            slide: function (event, ui) {
                $("#amount1").val(ui.values[0] + '% - ' + ui.values[1] + '%');
                $("#price_range1").val(ui.values[0] + "-" + ui.values[1]);
            }
        });
    }

    if ($("#amount1").length > 0) {
        const m_currency = $("#slider_range1").data('currency') || '';
        $("#amount1").val($("#slider_range1").slider("values", 0) + '% - ' + 
                          $("#slider_range1").slider("values", 1) + '%');
    }
});

    
    /* end discount range */  
       

    
   
   

      
         
         
         
         
       
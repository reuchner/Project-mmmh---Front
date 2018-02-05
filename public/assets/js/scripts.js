(function($) {


    // OUR OWN JS SCRIPTS
    function evenementIngredient() {
        $("#ingredientButton").click(function() {
            let nbInput = $("#listeInputIngredient input").length + 1;
            let codeHtml = '<div class="row"><div class="col-md-11" style=" padding: 0px; margin: 1% 0%; "> <input class="form-control" id="ingredient' + nbInput + '" name="ingredient' + nbInput + '" placeholder="Ajoutez un ingrédient ici" ></div><div class="col-md-1"> <button type="button" class="btn btn-primary float-right" id="ingredientButton" style="margin: 12% 0%;">+</button></div></div>';

            $("#listeInputIngredient").append(codeHtml);
            $(this).remove();
            evenementIngredient();
        });
    }
    evenementIngredient();

    function evenementEtape() {
        $("#etapeButton").click(function() {
            let nbInput = $("#listeInputEtape textarea").length;
            let nomSteps = nbInput / 3;
            let codeHtml = '<div class="row" style=" margin-top: 2%; "><div class="col-md-11"><div class="row">';
            for(let i = 1; i < 4; i++)
            codeHtml += '<div class="col-md-4"> <textarea rows="10" cols="50" class="form-control" id="step'+nomSteps+'-'+(nbInput+i)+'" name="step'+nomSteps+'-'+(nbInput+i)+'" placeholder="Une délicieuse tarte à déguster en été, accompagnée d\'une petite limonade" ></textarea> </div>';

            codeHtml += '</div> </div> <div class="col-md-1"> <button type="button" class="btn btn-primary float-right" id="etapeButton">+</button> </div> </div>';
            
            $("#listeInputEtape").append(codeHtml);
            $(this).remove();
            evenementEtape();
        });
    }                                  
    evenementEtape();

    function evenementPhoto() {
        $("#photoButton").click(function() {
            let nbInput = $("#listeInputPhoto input").length + 1;
            let codeHtml = '<div class="col-md-10"><div class="row"><div class="col-md-11"><input type="file" class="form-control" id="photo' + nbInput + '"name="photo' + nbInput + '"placeholder="Format .jpg ou .png" ></div><div class="col-md-1"><button type="button" class="btn btn-primary float-right">+</button></div></div></div>';

            $("#listeInputPhoto").append(codeHtml);
            $(this).remove();
            evenementPhoto();
        });
    }
    evenementPhoto();




    'use strict';

    // TEMPLATE JS SCRIPTS

    $(document).ready(function() {
        // Initializes search overlay plugin.
        // Replace onSearchSubmit() and onKeyEnter() with 
        // your logic to perform a search and display results
        $(".list-view-wrapper").scrollbar();

        $('[data-pages="search"]').search({
            // Bind elements that are included inside search overlay
            searchField: '#overlay-search',
            closeButton: '.overlay-close',
            suggestions: '#overlay-suggestions',
            brand: '.brand',
            // Callback that will be run when you hit ENTER button on search box
            onSearchSubmit: function(searchString) {
                console.log("Search for: " + searchString);
            },
            // Callback that will be run whenever you enter a key into search box. 
            // Perform any live search here.  
            onKeyEnter: function(searchString) {
                console.log("Live search for: " + searchString);
                var searchField = $('#overlay-search');
                var searchResults = $('.search-results');

                /* 
                    Do AJAX call here to get search results
                    and update DOM and use the following block 
                    'searchResults.find('.result-name').each(function() {...}'
                    inside the AJAX callback to update the DOM
                */

                // Timeout is used for DEMO purpose only to simulate an AJAX call
                clearTimeout($.data(this, 'timer'));
                searchResults.fadeOut("fast"); // hide previously returned results until server returns new results
                var wait = setTimeout(function() {

                    searchResults.find('.result-name').each(function() {
                        if (searchField.val().length != 0) {
                            $(this).html(searchField.val());
                            searchResults.fadeIn("fast"); // reveal updated results
                        }
                    });
                }, 500);
                $(this).data('timer', wait);

            }
        })

    });


    $('.panel-collapse label').on('click', function(e) {
        e.stopPropagation();
    })

})(window.jQuery);
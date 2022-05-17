jQuery(function ($) {

    'use strict';

 let filtersRes;
 let filtersJson;

    $(document).on("change", ".filter_params", function (e) {
        e.preventDefault();
        $( this ).attr( 'checked', 'checked' );
        let page = $( ".active" ).data("page");
        let phrase = getPhrase();
        console.log(phrase);
        changeFilters(this,page,phrase);
    });

    $(document).on("click", ".filters-delete", function (e) {
        e.preventDefault();
      let cssClass = $( this ).data("param");

      if(cssClass == "phrase_phrase")
      {
          $(".hidden-phrase").val('');
      }

        $("."+cssClass).click();
        let page = $( ".active" ).data("page");
        let phrase = getPhrase();
        //$('.'+cssClass).remove();

        changeFilters(this,page,phrase);
    });

    $(document).on("click", ".page-item a", function (e) {
        e.preventDefault();
        //let page = $( this ).data("page");
        var page = $(this).attr('href').split('page=')[1];
        let phrase = getPhrase();
        changeFilters(this,page,phrase);
    });

    function changeFilters(obj,page=1,phrase ='')
    {
        filtersRes = getFilters(obj);
        filtersJson = JSON.stringify(filtersRes);
        //  console.log(filtersJson);


        $.ajax({
            type: "GET",
            url: "/courses-ajax?=page"+page,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            //dataType: "json",
            data: {
                data : serialize(filtersRes) + "&page="+page + "&phrase="+phrase
            },
            success: function (content) {
                // console.log(content.html);

                let positionParameters = location.pathname.indexOf('?');
                let url = location.pathname.substring(positionParameters,location.pathname.length)
                let newUrl = url + "?";
                newUrl += "page="+page;

                if(phrase)
                {
                    newUrl += "&phrase="+phrase;
                }
                newUrl += "&"+serialize(filtersRes);

                console.log(page);

                window.history.pushState({},'', newUrl);


                $('.courses-ajax').html(content.html);
                $('.filter-ajax').html(content.filters);
            }
        });
    }


    function getFilters(obj)
    {

        let filters = {
            categories: [],
            levels: [],
            langs: [],

        };

        $('input:checkbox.cat_params:checked').each(function () {
            filters.categories[$(this).val()] = $(this).val();
        });

        $('input:checkbox.level_params:checked').each(function () {
            filters.levels[$(this).val()] = $(this).val();
        });

        $('input:checkbox.lang_params:checked').each(function () {
            filters.langs[$(this).val()] = $(this).val();
        });

        return filters;
    }


    //search
    $(document).on("keyup", ".checkShowResult", function (e) {
   // $(".checkShowResult").keyup(function() {
        let page=1
        let result = $(".showResult");

        let val = $(this).val();
        let phrase = val;
        console.log(phrase);
        if (val.length > 1) {

            $.ajax({
                type: "GET",
                url: "/search-courses-ajax?=page"+page,

                //dataType: "json",
                data: {
                    data : "&page="+page + "&phrase="+phrase
                },
                success: function (content) {
                    // console.log(content.html);

                    $('.search-course-ajax').html(content.html);
                    result.show();
                }
            });

        } else {
            result.hide();
        }
    });


    // subscribe
    $(document).on("click", ".subscribe", function (e) {
        e.preventDefault();

        let email = $(".email").val();

        $.ajax({
            type: "POST",
            url: "/subscribe",

            //dataType: "json",
            data: {
                email : email
            },
            success: function (content) {
                // console.log(content.html);
                $('.subscribe-success').html('');
                $('.subscribe-error').html('');
                if(content.status == 1) {
                    $('.subscribe-success').html(content.mess);
                }
                else{
                    $('.subscribe-error').html(content.mess);
                }
            }
        });
    });

});

serialize = function(obj) {
    var str = [];
    for (var p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

function getPhrase(cssClass="phrase_phrase")
{
    let  actualLink = window.location.href;

    let url = new URL(actualLink);
   // let phrase = url.searchParams.get("phrase");
    let phrase = $(".hidden-phrase").val();

    return phrase;
}


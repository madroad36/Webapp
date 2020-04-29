/*LightSlider Setting */
// Call lightslider
$(document).ready(function() {
    $("#lightSlider").lightSlider({
        item: 6,
        autoWidth: false,
        slideMargin: 30,
        keyPress: true,
        responsive : [
            {
                breakpoint:1200,
                settings: {
                    item: 5
                }
            },
            {
                breakpoint:1000,
                settings: {
                    item: 4
                }
            },
            {
                breakpoint:700,
                settings: {
                    item: 3
                }
            },
            {
                breakpoint:550,
                settings: {
                    item: 2
                }
            }
        ]
    }); 
});
// call property slider 
$(document).ready(function() {
    $("#propertyslider").lightSlider({
        item: 3,
        autoWidth: false,
        slideMargin: 30,
        keyPress: true,
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
        responsive : [
            {
                breakpoint:900,
                settings: {
                    item: 2
                }
            },
            {
                breakpoint:550,
                settings: {
                    item: 1
                }
            }
        ]
    }); 
});
// call product category slider
$(document).ready(function() {
    $("#productCategory").lightSlider({
        item: 6,
        autoWidth: false,
        slideMargin: 30,
        keyPress: true,
        responsive : [
            {
                breakpoint:1200,
                settings: {
                    item: 5
                }
            },
            {
                breakpoint:1000,
                settings: {
                    item: 4
                }
            },
            {
                breakpoint:700,
                settings: {
                    item: 3
                }
            },
            {
                breakpoint:550,
                settings: {
                    item: 2
                }
            }
        ]
    }); 
});
// call services slider
$(document).ready(function() {
    $("#services").lightSlider({
        adaptiveHeight:true,
        item: 6,
        autoWidth: false,
        slideMargin: 30,
        keyPress: true,
        responsive : [
            {
                breakpoint:1200,
                settings: {
                    item: 5
                }
            },
            {
                breakpoint:1000,
                settings: {
                    item: 4
                }
            },
            {
                breakpoint:700,
                settings: {
                    item: 3
                }
            },
            {
                breakpoint:550,
                settings: {
                    item: 2
                }
            }
        ]
    }); 
});
$(document).ready(function() {
    $('#showImage').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:9,
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {
            el.lightGallery({
                selector: '#imageGallery .lslide'
            });
        }   
    });  
  });
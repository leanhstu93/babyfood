 $(document).ready(function() {
              $('#lindo_logo').owlCarousel({
                loop: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                  0: {
                    items: 2,
                    nav: true
                  },
                  600: {
                    items: 5,
                    nav: false
                  },
                  1000: {
                    items: 8,
                    nav: true,
                    loop: false,
                    margin: 10
                  }
                }
              })
})

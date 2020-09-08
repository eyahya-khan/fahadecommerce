        <!-- footer -->
        <div class="row bg-dark text-white p-2 text-center">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <strong>Address:</strong><br><a href="" target="" class="text-white"> Chapainababgonj<br>Bangladesh</a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <label for="myemail"><strong>Contact us:</strong></label><br>
                <a href="mailto:sweden.bangla.trade.venture2020@gmail.com?subject=Mymail&body=hello" title="my email address" id="myemail">sweden.bangla.trade.venture2020@gmail.com</a>
                <label for="mycell"></label>
                <a href="tel:+8801712902140" title="contact number" id="mycell">+8801712902140</a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <strong>Follow us:</strong><br>
                <a href="#"><i class="fa fa-facebook-square fa-2x"></i></a>
                <a href="#"><i class="fa fa-twitter-square fa-2x"></i></a>
                <a href="#"><i class="fa fa-instagram fa-2x"></i></a>
                <a href="#"><i class="fa fa-pinterest-square fa-2x"></i></a>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a href="#" target="" class="text-white">Cookies</a><br>
                <a href="#" target="" class="text-white">Privacy Policy</a><br>
                <a href="#" target="" class="text-white">Terms and Conditions</a>
                <br><strong>@Copyright 2020</strong>
            </div>
        </div>



<!--carousel start-->
        <script>
            $(document).ready(function() {
                // Activate Carousel
                $("#myCarousel").carousel();

                // Enable Carousel Indicators
                $(".item1").click(function() {
                    $("#myCarousel").carousel(0);
                });
                $(".item2").click(function() {
                    $("#myCarousel").carousel(1);
                });
                $(".item3").click(function() {
                    $("#myCarousel").carousel(2);
                });

                // Enable Carousel Controls
                $(".carousel-control-prev").click(function() {
                    $("#myCarousel").carousel("prev");
                });
                $(".carousel-control-next").click(function() {
                    $("#myCarousel").carousel("next");
                });
            });

        </script>



        </body>

        </html>

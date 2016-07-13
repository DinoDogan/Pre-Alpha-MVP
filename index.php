<!-- Get header from header.php -->

<?php $home_style = true; ?>
<?php include "inc/header.php"; ?>


<section id="home">
    <div class="home-background"></div>
    <div class="call-to-action content">
        <div class="cloud-upload" data-toggle="modal" data-target="#upl-modal1">
            <div class="cloud-upload-src">
                <span>PDF</span>

                <!--<img src="img/cloud-icon-active.png">-->
                <img src="img/cloud-icon.png">
                <!--<i class="fa fa-cloud-upload" aria-hidden="true"></i>-->
            </div>
        </div>
        <div class="cloud-arrow">
            <img src="img/arrow-icon.png">
            <!--<i class="fa fa-long-arrow-right" aria-hidden="true"></i>-->
        </div>
        <div class="cloud-carousel">
            <div class="cloud-carousel-inner">
                <img src="img/page-icon.png">

                <div class="cloud-carousel-dest">
                    <span>WordPress</span>
                    <span>Facebook<small>coming soon</small></span>
                    <span>Medium<small>coming soon</small></span>
                </div>

                <div class="cloud-carousel-btns">
                    <!-- Populated by JavaScript -->
                </div>
                <!--<i class="fa fa-file-o" aria-hidden="true"></i>-->
            </div>
        </div>
    </div>
</section>

<div id="upl-modals">

    <!----------------------------------------------------------------------------------------
        Upload File Modals
    ----------------------------------------------------------------------------------------->

    <!--
        Modal 1 (Choose files)
    -->
    <div class="modal fade" id="upl-modal1" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-large">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <i class="modal-header-hint fa fa-question-circle-o"
                       data-help="<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>"></i>
                    <h4 class="modal-title">Upload to Magnificent</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Choose a PDF you would like Magnificent to process. Please choose a file
                                less than 25 MB so we can process your document as efficiently as possible.
                            </p>
                        </div>
                    </div>

                    <p>&nbsp;</p>

                    <div class="row">
                        <div class="col-xs-9 text-right align-middle">
                            <a href="#" data-dismiss="modal" class="small">Close</a>
                        </div>

                        <div class="col-xs-3 text-right align-middle">
                            <a class="btn btn-default" id="upl-modal1-browse">Choose File</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer xs">
                    <div class="col-xs-6 text-left">
                        Step 1 of 3
                    </div>
                    <div class="col-xs-6 text-right">
                        Next Step: Enter Email
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        Modal 2 (Enter email)
    -->

    <div class="modal fade" id="upl-modal2" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-large">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <i class="modal-header-hint fa fa-question-circle-o"></i>
                    <h4 class="modal-title">Enter Your Email</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <input type="text" placeholder="name@example.com" autofocus id="upl-modal2-input">
                        </div>
                    </div>

                    <div class="row" style="margin-top: 40px;">
                        <div class="col-xs-9 text-right align-middle">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#upl-modal1"
                               class="small">Previous</a>
                        </div>

                        <div class="col-xs-3 text-right align-middle">
                            <a class="btn btn-default" data-dismiss="modal" data-toggle="modal"
                               data-target="#upl-modal3" id="upl-modal2-next">Next</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer xs">
                    <div class="col-xs-6 text-left">
                        Step 2 of 3
                    </div>
                    <div class="col-xs-6 text-right">
                        Next Step: Enter Email
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        Modal 3 (Special Instructions)
    -->

    <div class="modal fade" id="upl-modal3" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-large">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <i class="modal-header-hint fa fa-question-circle-o"></i>
                    <h4 class="modal-title">Special Instructions</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                                <textarea placeholder="Enter your extraction desires here..." autofocus
                                          id="upl-modal3-input" maxlength="500"></textarea>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 40px;">
                        <div class="col-xs-9 text-right align-middle">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#upl-modal2"
                               class="small">Previous</a>
                        </div>

                        <div class="col-xs-3 text-right align-middle">
                            <a class="btn btn-default" id="upl-modal3-next" data-dismiss="modal"
                               data-toggle="modal" data-target="#upl-modal4">Submit</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer xs">
                    <div class="col-xs-6 text-left">
                        Step 3 of 3
                    </div>
                    <div class="col-xs-6 text-right">
                        Next Step: Celebrate
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        Modal 4 (Upload Progress)
    -->

    <div class="modal fade" id="upl-modal4" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-large">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" id="upl-modal4-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="upl-modal4-title">Uploading...</h4>

                    <div id="upl-modal4-progress">
                        <div id="upl-modal4-progress-bar"></div>
                    </div>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <p>
                                Your PDF will be extracted and formated for easy-publishing on your WordPress
                                website. It takes 24 hrs for our machine-learning engine to explicate the contents
                                of your PDF, interpret your instructions, and format the output. Each outcome is
                                then checked by a real, live person before the results are sent to you.
                            </p>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 40px;">
                        <div class="col-xs-9 text-right align-middle">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#upl-modal1"
                               class="small">Start Over</a>
                        </div>

                        <div class="col-xs-3 text-right align-middle">
                            <a class="btn btn-default" id="upl-modal4-next" data-dismiss="modal"
                               data-toggle="modal" data-target="#upl-modal5">Share</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer xs">
                    <div class="col-xs-6 text-left">
                        You've reached the finish line
                    </div>
                    <div class="col-xs-6 text-right">
                        Next Step: Share the love
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--
        Modal 5 (Upload Progress)
    -->

    <div class="modal fade" id="upl-modal5" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-large">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Share</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12" id="upl-modal5-icons">
                            <a target="_blank" title="Share on Facebook"
                               href="http://www.facebook.com/sharer.php?u=http%3A%2F%2Fmagnificent.com%2Fpdf2wp%2F"><i
                                    class="fa fa-facebook"></i></a>
                            <a target="_blank" title="Share on Twitter"
                               href="http://www.twitter.com/share?url=http%3A%2F%2Fmagnificent.com%2Fpdf2wp%2F"><i
                                    class="fa fa-twitter"></i></a>
                            <a target="_blank" title="Share on Google+"
                               href="https://plus.google.com/share?url=http%3A%2F%2Fmagnificent.com%2Fpdf2wp%2F"><i
                                    class="fa fa-google-plus"></i></a>
                            <a target="_blank" title="Share on Pinterest"
                               href="http://pinterest.com/pin/create/button/?url=http%3A%2F%2Fmagnificent.com%2Fpdf2wp%2F"><i
                                    class="fa fa-pinterest"></i></a>
                            <a target="_blank" title="Share on LinkedIn"
                               href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fmagnificent.com%2Fpdf2wp%2F"><i
                                    class="fa fa-linkedin"></i></a>
                            <a target="_blank" title="Share on Product Hunt"
                               href="https://www.producthunt.com/tech/new"><i
                                    class="fa fa-product-hunt"></i></a>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 40px;">
                        <div class="col-xs-9 text-right align-middle">
                            <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#upl-modal4"
                               class="small">Previous</a>
                        </div>

                        <div class="col-xs-3 text-right align-middle">
                            <a class="btn btn-default" data-dismiss="modal">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Get footer from footer.php -->

<?php include "inc/footer.php"; ?>
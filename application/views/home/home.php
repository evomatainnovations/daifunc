<style type="text/css">
    html, body, h1, h2, h3, h4, h5, h6, a {
        font-family: 'Muli', sans-serif !important;
    }

    #myCarousel > ol > li {
        color: #666 !important;
        background-color: #666 !important;
    }

    #myCarousel > ol > .active {
        width: 40px !important;
    }

    @media only screen and (max-width: 767px) {
        .closing_tag {
            font-size: 2.3em;
            font-weight: bold;
        }

        .gs_text_title {
            font-size: 2em;
        }

        .gs_text_description {
            font-size: 1.3em;
        }

        .gs_text_description_secondary {
            font-size: 1.2em;
            line-height: 1.5em;
        }
    }

    .gs_text {
        text-align: justify;
    }

    .gs_image {
        width: auto;
        height: 40vh;
    }
    .po-mark > .popover {
        width: 300px;
        left: 30px;
        max-width: 90%;
        margin-right: 10px;
    }
</style>
<div class="mdl-grid" style="width: 100%;text-align: right;">
    <div class="po-mark" style="width: 100%;text-align: right;">
        <button class="mdl-button mdl-js-ripple-effect mdl-js-button" id="change_view" style="margin: 0px;"><i class="material-icons">settings</i> Change view</button>
        <div class="po-content_home" style="display: none;">
            <div class="po-body_home">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button mdl-button--colored change_view" id="default_view">Default View</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button change_view" id="manager_view">Manager View</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button change_view" id="employee_view">Employee View</button>
                    </div>
                    <div class="mdl-cell mdl-cell--12-col">
                        <button class="mdl-button change_view" id="inventory_view">Inventory Dashboard</button>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>
<div class="mdl-grid home_view" style="width: 100%;"></div>
<div id="getting_started" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="text-align: left;">
                <h4>
                    Getting Started
                </h4>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="4000" data-wrap="false" style="padding: 10%;">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                        <li data-target="#myCarousel" data-slide-to="5"></li>
                        <li data-target="#myCarousel" data-slide-to="6"></li>
                        <li data-target="#myCarousel" data-slide-to="7"></li>
                        <li data-target="#myCarousel" data-slide-to="8"></li>
                        <li data-target="#myCarousel" data-slide-to="9"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Welcome <?php echo $name; ?>,</b></h2>
                                    <h4 class="gs_text_description">Daifunc is a ecosystem designed to make businesss operations as simple as pressing a button, <b>because we value the passion and sweat people put in making it successful.</b></h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>start.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Effortless orgnization</b></h2>
                                    <h4 class="gs_text_description">Plan your schedules, make notes, categorise them so that you stay organized effortlessly.</h4>
                                    <br>
                                    <p>Access activities directly from the Home screen.</p>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>planning.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>One-click Access to Everything</b></h2>
                                    <h4 class="gs_text_description">The menu present on the top left corner, gives you access to your Modules, Your Groups, Collections & Settings.
                                    </h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>easy_access.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Your Modules</b></h2>
                                    <h4 class="gs_text_description">Modules are operational blocks that get your work done. They communicate with each other, so that you get a lot of work done just at a press of a button.<br><br>You'll understand more about modules next.</h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>block_module.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Collections</b></h2>
                                    <h4 class="gs_text_description">It is a place where you can find a variety of applications designed to suit various business operations.</h4>
                                    <h5 class="gs_text_description_secondary">You maybe a small business that may need managing sales, inventory, accounting, subscriptions/maintainance, support or a freelancer having just to manage projects and billing or a large corporation trying to simplify all your operations, everything is available in collections</h5>
                                    <p>If you need something specific, you can always write to us, and we will get you sorted as fast as possible.</p>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>blocks.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Your Groups</b></h2>
                                    <h4 class="gs_text_description">Once you have purchased a set of modules, you can share them with your team or contractors so that who ever is incharge can easily get things. </h4>
                                    <p>Create as many as groups as you want, all data within that group belong to that group only. But you can access all the information directly from your account.</p>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>connect_blocks.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Daifunc Search</b></h2>
                                    <h4 class="gs_text_description">Do any kind of work in Daifunc either using Modules or Activities, just type a keyword and you shall find everything related to it.</h4>
                                    <h4 class="gs_text_description_secondary">For e.g. Evomata is your favorite company because of the innovation, you can just type innovation and everything related to Evomata will show. Is'nt that Great?</h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>search.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Freedom from location and time, guaranteed!</b></h2>
                                    <h4 class="gs_text_description">Daifunc has apps for Desktop, Mac, Android, IOS as well as directly from browsers. So wherever you go around the world, expanding your business, your business goes with you.</h4>
                                    <h4><b>"Your office in your Pocket!"</b></h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>free_location.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--6-col gs_text">
                                    <h2 class="gs_text_title"><b>Your data is secured!!</b></h2>
                                    <h4 class="gs_text_description ">Daifunc uses complex cryptographic patterns to secure and lock your data, so that you can stay stress-free about it 24*7*365.</h4>
                                </div>
                                <div class="mdl-cell mdl-cell--6-col">
                                    <img src="<?php echo base_url().'assets/images/'; ?>security.png" class="gs_image">
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col" style="">
                                    <h4 class="gs_text_description">We thank you from the bottom of our hearts for joining the Daifunc platform &hearts;. We will always keep updating and finding solutions to make sure your operations are as smooth as butter.</h4>
                                    <h1 class="closing_tag" style="color: #ff0000;">Let's Revolutionize your Enterprise</h1>
                                    <p>Feel free to explore the application, purchase what you need, give us a call or leave us a email, we will get back to you!</p>

                                    <button style="border-radius: 10px; box-shadow: 0px 5px 10px #666; border: 0px; background-color: #ff0000; color: #fff; padding: 40px; font-size: 2em;" id="next_modal">Next > </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev" style="background-image: none; color: #666; width: 0px;">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next" style="background-image: none; color: #666; width: 0px;">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="purchase_modules" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <img src="<?php echo base_url().'assets/images/'; ?>block_module.png" class="gs_image">
                <h4>Search & Add Modules to your Daifunc Account</h4>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised proceed_col">Proceed <i class="material-icons">play_arrow</i></button>
                <h4 style="color: #aaa;">Or you can go to the <b style="color: #000;"><i class="material-icons">menu</i> Menu</b>, and click on <b style="color: #000;"> Collections</b></h4>
            </div>
        </div>
    </div>
</div>
<div id="accounting_year" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <h4> Add accounting year</h4>
                <h5>click on button </h5>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised add_acc_yr">Proceed <i class="material-icons">play_arrow</i></button>
            </div>
        </div>
    </div>
</div>
<div id="email_setting" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center;">
                <h4> Now, </h4>
                <h4> Add email setting</h4>
                <h5> click on button</h5>
                <button class="mdl-button mdl-js-button mdl-button--colored mdl-button--raised add_email_set">Proceed <i class="material-icons">play_arrow</i></button>
            </div>
        </div>
    </div>
</div>
<script>
    var v_type = 'default_view';
    <?php
        if (isset($v_type)) {
            if ($v_type == 'manager_view') {
                echo "v_type = 'manager_view';";
                echo "$('.change_view').removeClass('mdl-button--colored');";
                echo "$('#manager_view').addClass('mdl-button--colored');";
            }else if ($v_type == 'employee_view'){
                echo "v_type = 'employee_view';";
                echo "$('.change_view').removeClass('mdl-button--colored');";
                echo "$('#employee_view').addClass('mdl-button--colored');";
            }else if ($v_type == 'inventory_view'){
                echo "v_type = 'inventory_view';";
                echo "$('.change_view').removeClass('mdl-button--colored');";
                echo "$('#inventory_view').addClass('mdl-button--colored');";
            }else{
                echo "$('.change_view').removeClass('mdl-button--colored');";
                echo "$('#default_view').addClass('mdl-button--colored');";
            }
        }
    ?>
    $(document).ready(function() {
        change_view(v_type);
        $('.po-mark > #change_view').popover({
            trigger: 'click',
            html: true,
            title: function() {
                return $(this).parent().find('.po-title_home').html();
            },
            content: function() {
                return $(this).parent().find('.po-body_home').html();
            },
            placement: 'bottom'
        }).on('shown.bs.popover', function () {
            $('.change_view').removeClass('mdl-button--colored');
            $('#'+v_type).addClass('mdl-button--colored');

            $('.change_view').click(function (e) {
                e.preventDefault();
                v_type = $(this).prop('id');
                $('#change_view').popover('hide');
                change_view(v_type);
            });
        });

        function change_view(type) {
            $('.loader').css('display','block');
            $.post('<?php echo base_url()."Home/change_view/".$code.'/'; ?>'+type
            , function(d, s,x) {
                $('.loader').css('display','none');
                $('.home_view').empty();
                $('.home_view').append(d);
            }, "text");
        }
    });
</script>
</html>
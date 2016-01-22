<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>FSI-BSI</title>
        <link href="<?php echo CONST_PATH_ASSETS_FRONT_CSS; ?>style.css" rel="stylesheet" type="text/css" />

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Orbitron:400,500,700,900' rel='stylesheet' type='text/css'>

        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body class="main_home">
        <div class="main_wrap">

            <!-- Header Start -->
            <?php $this->load->view()?>
            <!-- Header End -->

            <!-- Body Start -->
            <main>
                <div class="container">
                    <!-- Body Top Start -->
                    <div class="body_top clearfix">
                        <div class="body_top_left">
                            <h1>WELCOME TO <span>FSI-BSI.IN</span></h1>
                            <p>FSI - BSI began with the vision of setting a new benchmark for student design competitions held in India. We host inventive and engaging events for engineering students that conform to international standards. What sets us apart from the rest is our stringent application of global rules. We are sticklers for complete transparency and fairness. No bureaucracy. No red tape. Just healthy competition.</p>
                            <p>We're all about bringing a change and introducing a new culture to India. From our preliminary efforts to present day, we have only one agenda - to provide a platform for students to innovate and excel on a scale that is truly international. From four guys with laptops way back in 2013, we are now  a battalion of spirited volunteers, learning and growing every year. It can only get bigger and better.</p>
                        </div>
                        <div class="body_top_right">
                            <h3>OUR EVENTS</h3>
                            <ul>
                                <li>
                                    <strong>Baja Student India™</strong>
                                    Jamshedpur<br>
                                    7-11 January,2015<br>
                                    8am-7pm
                                </li>
                                <li>
                                    <strong>Formula Student India™</strong>
                                    14-18 Jan, 2015<br>
                                    8am-7pm
                                </li>
                                <li>
                                    <strong>Delta Training Seminar</strong>
                                    Details Coming soon<br>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Body Top End -->

                    <!-- Sponsor Start -->
                    <div class="home_sponsor">
                        <h2>OUR SPONSORS</h2>
                        <div class="logos">
                            <ul class="bxslider">
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_1.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_2.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_3.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_4.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_5.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_6.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="table">
                                        <div class="table_cell">
                                            <a href="#"><img src="<?PHP echo CONST_PATH_ASSETS_FRONT_IMAGES;?>sponsor_7.jpg" /></a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Sponsor End -->
                </div>
            </main>
            <!-- Body End -->

            <!-- Footer Start -->
            <footer>
                <div class="container clearfix">
                    <ul>                                                    
                        <li><a href="<?php echo CONST_APP_SITE_LINK; ?>">Home</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Gallery</a></li>
                        <li><a href="<?php echo CONST_FSI_LINK; ?>">Formula Student India™</a></li>
                        <li><a href="<?php echo CONST_BSI_LINK; ?>">Baja Student India™</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                    <p class="copy">
                        <!--All Right Reserved @ FSI-BSI.in 2015 I Designed &amp; developed by <a href="<?php echo CONST_DEVELOPER_LINK; ?>"><?php echo CONST_DEVELOPER_NAME; ?></a>-->
                        All Right Reserved @&nbsp;<?php echo CONST_APP_SITE_TITLE; ?>&nbsp;<?php echo date('Y'); ?> I Designed &amp; developed by <a href="<?php echo CONST_DEVELOPER_LINK; ?>"><?php echo CONST_DEVELOPER_NAME; ?></a>
                    </p>
                </div>
            </footer>
            <!-- Footer End -->
        </div>

    </body>
    <link href="<?php echo CONST_PATH_ASSETS_FRONT_CSS; ?>jquery.bxslider.css" rel="stylesheet" type="text/css" />
    
</html>


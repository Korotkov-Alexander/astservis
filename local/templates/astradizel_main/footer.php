<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
    <?if ($APPLICATION->GetCurPage() != "/") {?>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <?}?>
    <div class="footer-top-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-about-us">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "EDIT_TEMPLATE" => "",
                                "COMPONENT_TEMPLATE" => ".default",
                                "PATH" => "include/footer-info.php"
                            ),
                            false
                        );?>
                        <?/*
                        <div class="footer-social">
                            <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-youtube"></i></a>
                            <a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </div>
                        */?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Навигация</h2>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom",
                            array(
                                "ROOT_MENU_TYPE" => "bottom",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "left",
                                "DELAY" => "N"
                            ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        );?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu">
                        <h2 class="footer-wid-title">Категории</h2>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "bottom",
                            array(
                                "ROOT_MENU_TYPE" => "bottom_category",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "1",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "bottom",
                                "DELAY" => "N"
                            ),
                            false,
                            array(
                                "ACTIVE_COMPONENT" => "Y"
                            )
                        );?>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="footer-newsletter">
                        <h2 class="footer-wid-title">Обратный звонок</h2>
                        <p>Вы можете заказать обратный звонок и мы Вам перезвоним</p>
                        <div class="newsletter-form">
							<?$APPLICATION->IncludeComponent("bitrix:form.result.new","ord_phone",Array(
								"SEF_MODE" => "Y",
								"WEB_FORM_ID" => 3,
									"LIST_URL" => "",
									"EDIT_URL" => "result_edit.php",
									"SUCCESS_URL" => "",
									"CHAIN_ITEM_TEXT" => "",
									"CHAIN_ITEM_LINK" => "",
									"IGNORE_CUSTOM_TEMPLATE" => "Y",
									"USE_EXTENDED_ERRORS" => "Y",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "3600",
									"SEF_FOLDER" => "/",
									"VARIABLE_ALIASES" => Array(
							)
								)
							);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End footer top area -->

    <div class="footer-bottom-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="copyright">
                        <p>&copy; 2017 </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Здесь можно расположить иконки для счетчиков-->
                    <!--<div class="footer-card-icon">
                        <i class="fa fa-cc-discover"></i>
                        <i class="fa fa-cc-mastercard"></i>
                        <i class="fa fa-cc-paypal"></i>
                        <i class="fa fa-cc-visa"></i>
                    </div>-->
                </div>
            </div>
        </div>
    </div> <!-- End footer bottom area -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <!-- Latest jQuery form server -->
<!--    <script src="https://code.jquery.com/jquery.min.js"></script>-->

    <!-- Bootstrap JS form CDN -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <!-- jQuery sticky menu -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/owl.carousel.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.sticky.js"></script>

    <!-- jQuery easing -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.easing.1.3.min.js"></script>

    <!-- Main Script -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/main.js"></script>

    <script src="<?=SITE_TEMPLATE_PATH?>/js/scriptbreaker-multiple-accordion-1.js"></script>
	
	<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.inputmask.js"></script>

</body>
</html>
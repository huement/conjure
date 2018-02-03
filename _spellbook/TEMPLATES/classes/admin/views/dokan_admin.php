<?php
/**
 *  DokanMyriad Main HTML
 *
 * @since 2.4
 *
 * @package dokan
 */
//$manurl = wp_redirect(admin_url('/admin.php?page=dm_ss&forcecheck=yes'), 301);
$manurl = admin_url('/admin.php?page=dm_ss&forcecheck=yes');
?>
<div class='setbox' id='UPSHOTADMIN'>

    <div class='container-fluid'>
        <div class='row row-break row-first' style='margin: 0!important;padding: 0 !important;'>
            <div class='col-md-12' style='margin: 0!important;padding: 0 !important;'>

                <div class='page-header' style='border-bottom:none;background: #f5f5f5;padding: 10px 10px 0 10px;margin:25px auto 40px auto;'>
<!--                <a class='btn btn-primary btn-lg btn-block w-100 text-center text-uppercase p-2 my-3 my-2' href=' //echo $manurl; '>
                       Manually Check
                    </a>-->
                    <h1 class='my-2'><span>D</span>okan <span>U</span>pshot <small>Subscriber Upselling</small></h1>

                    <br/>
                </div>
            </div>
        </div>
    </div>

    <div class='container-fluid'>
        <div class='row row-break'>
            <div class='col-sm-7'>
                <form class='' method='post' action='options.php'>
                    <?php settings_fields( 'dokan-upshot' ); ?>
                    <?php do_settings_sections( 'dokan-upshot' ); ?>

                    <label for='dokan_up_days' class='control-label'>Dokan Subscriber TopTier Package ID</label>

                    <div class='input-group'>
                        <input type='text' name='dokan-upshot-maxid' class='form-control' placeholder='0' value='<?php echo get_option( 'dokan-upshot-maxid' ); ?>'>
                        <span class='input-group-btn'>
                            <button id='upshotHelp' class='btn btn-info' type='button' data-toggle='modal' data-target='#myModal'>HELP</button>
                        </span>
                    </div>


                    <hr/>

                    <div class='form-group' style='margin-top:20px;'>
                        <label for='dokan_up_days' class='control-label'>Send every [X] days</label>
                        <input type='number' name='dokan-upshot-sentdays' class='form-control' value='<?php echo get_option( 'dokan-upshot-sentdays' ); ?>'
                               placeholder='7'/>
                    </div>
                    <div class='form-group' style='margin-top:20px;'>
                        <label for='dokan_up_subject' class='control-label'>Message Subject:</label>
                        <input type='text' name='dokan-upshot-subjects' class='form-control' value='<?php echo get_option( 'dokan-upshot-subjects' );
                        ?>'
                               placeholder='Email Summary'/>
                    </div>
                    <div class='form-group' style='margin-top:30px;'>
                        <label for='dokan-upshot-body' class='control-label'>Message Body:</label>
                       <?php wp_editor( get_option( 'dokan-upshot-body' ), 'dokanUpshotBody', array( 'wpautop' => false, 'textarea_rows'=>12, 'textarea_name' => 'dokan-upshot-body', 'editor_class'=>'upshotEditor' ) ); ?>

                    </div>

                    <div class='sb' style='margin-top:20px;'>
                        <?php submit_button(); ?>
                    </div>
                </form>
            </div>

            <div class='col-sm-4 col-sm-offset-1'>
                <div class='well' style="border:none;">
                    <p class="lead">Email Details</p>
                    <button id='upshotPreview' class='btn btn-default btn-lg btn-block' type='button' data-toggle='modal' data-target='#emailPrevModal'>EMAIL PREVIEW</button>
                    <div class='col-sm-12' style='height:30px'></div>
                    <p>To learn more about the email preview:<br/> <button id='upshotHelp' class='btn btn-info btn-xs' type='button' data-toggle='modal' data-target='#emailHelpModal'>Preview Help</button></p>
                </div>

                <div class='col-sm-12' style='height:10px'></div>
                <!--                <img class='img-fluid d-block h-75' style='width:100%;max-width:500px;margin:0 auto;position: relative;display:block;' src='../wp-content/plugins/dokan-upshot/admin/assets/demo.png'>-->
                <div class='card' style='width:100%;margin-top:25px;background: #f5f5f5;'>
                    <div class='card-header'>
                        <h3 style='margin-top:20px;text-align:center;text-transform: uppercase'>Vendor Summary</h3>
                    </div>
                    <div class='card-body h-50'>
                        <div class='col-sm-12' style='height:30px'></div>
                        <p class='big_p'>Active  <span class='label label-info'><?php if(isset($dts) && isset($dts['active'])){ echo $dts['active']; } ?></span></p>
                        <p class='big_p'>Inactive <span class='label label-danger'><?php if(isset($dts) && isset($dts['inactive'])){ echo $dts['inactive']; } ?></span></p>
                        <p class='big_p'>Total <span class='label label-primary'><?php if(isset($dts) && isset($dts['total'])){ echo $dts['total']; } ?></span></p>
                        <div class='col-sm-12' style='height:30px'></div>
                        <p class='big_p'>Subscribers <span class='label label-success'><?php if(isset($dts) && isset($dts['subscribers'])){ echo $dts['subscribers']; } ?></span></p>
                        <div class='col-sm-12' style='height:30px'></div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class='container-fluid'>
        <div class='row row-break'>
            <div class='col-sm-12' style='height:20px'></div>
        </div>
        <hr/>
        <div class='row row-break'>
            <div class='col-sm-12' style='height:100px'></div>
        </div>
    </div>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col-sm-12'>
                <img class='img-fluid d-block h-75' style='width:100%;max-width:400px;margin:120px auto 0 auto;position: relative;display:block;' src='../wp-content/plugins/dokan-upshot/admin/assets/mm-logo.jpg'>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div class='modal fade' id='emailPrevModal' tabindex='-1' role='dialog' aria-labelledby='emailPrevModal'>
        <div class='modal-dialog modal-lg email-modal hm' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='emailPrevModalLabel'>Upshot Email Preview</h4>
                </div>
                <div class='modal-body email-modal' style="min-height:560px;">
                    <div class='container-fluid' id='PREVIEWFRAME'>
                        <div class='row row-break'>
                            <iframe id='email_preview' src='about:blank' style='width:100%;display:block;margin: 20px auto 0 auto; height:540px;'></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Help Modal -->
    <div class='modal fade' id='emailHelpModal' tabindex='-1' role='dialog' aria-labelledby='emailHelpModal'>
        <div class='modal-dialog hm' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='emailHelpModalLabel'>Email Preview</h4>
                </div>
                <div class='modal-body help-modal'>
                    <p class="lead"><strong>Emails may appear differently depending on receivers Email client.</strong></p>
                    <p style='font-size:18px;line-height:20px;margin:20px auto 20px auto;'>This is only showing a preview of the template.</p>
                    <p style='font-size:18px;line-height:20px;margin:10px auto;'>You can configure the template by visiting the 'Appearance' section in the admin sidebar menu. Then click on 'Email Template', and customize the template that will be used.</p>
                    <p>&nbsp;</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-info' data-dismiss='modal'>| CLOSE |</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Modal -->
    <div class='modal fade' id='myModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
        <div class='modal-dialog hm' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Dokan Upshot</h4>
                </div>
                <div class='modal-body help-modal'>
                    <p>&nbsp;</p>
                    <p>This plugin can be configured to email everyone, EXCEPT those people who have updated to the 'Top Tier' subscription package.</p>
                    <p>Due to the nature of how Wordpress creates posts, there is no 'hierarchy'.</p>
                    <p>So while it may be obvious to the end user that <strong>GOLD</strong> is better than <strong>SILVER</strong> or <strong>BRONZE</strong>, its not declared programmatically. </p>
                    <p>To ensure you're not trying to 'Up-sell' users who already have your most advanced package, you can simply add the <strong>POST ID</strong> of the maximum package offered.</p>
                    <p>To find the POST ID of any package, you can either load up the package in the WYSIWYG editor, or mouse over the package name anywhere it is linked, *(such as the Dokan Subscriber Table in the Dokan Admin area)*</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>Thanks for reading!</p>
                    <p>&nbsp;</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-info' data-dismiss='modal'>| CLOSE |</button>
                </div>
            </div>
        </div>
    </div>

</div>


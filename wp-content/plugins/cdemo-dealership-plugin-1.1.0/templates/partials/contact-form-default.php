<?php

namespace cdemo;


$form_action = admin_url( 'admin-post.php?action=cdemo_submit_contact_form' );

?>

<div class="contact-form-default">

    <?php if ( isset( $_GET['request'] ) && $_GET['request'] == 'sent' ) : ?>

        <p class="request-conformation"><?php esc_html_e( get_option( Options::CONTACT_FORM_MSG ) ); ?></p>

    <?php else : ?>

        <div class="panel-group" id="contact-form">

            <div class="panel panel-primary">

                <div class="panel-heading">

                    <p class="panel-title">
                        <a class="collapsed cdemo-text-hover"
                           data-toggle="collapse"
                           data-parent="#contact-form"
                           href="#contact">
                            <?php _e( 'Contact', 'cdemo' ); ?>
                        </a>
                    </p>

                </div>

                <div id="contact" class="panel-collapse collapse collapsed">

                    <div class="panel-body">

                        <form method="post" action="<?php echo esc_url( $form_action ); ?>">

                            <div class="form-group">
                                <input required
                                       placeholder="<?php _e( 'Your name', 'cdemo' ); ?>"
                                       type="text" class="form-control"
                                       name="contact[name]">
                            </div>

                            <div class="form-group">

                                <label><?php _e('Preferred contact method', 'cdemo' ); ?></label>

                                <label>
                                    <input required
                                           checked
                                           type="radio"
                                           name="contact[preferred]"
                                           value="phone"> <?php _e( 'Phone', 'cdemo' ); ?>
                                </label>

                                <label>
                                    <input required
                                           type="radio"
                                           name="contact[preferred]"
                                           value="email"> <?php _e( 'Email', 'cdemo' ); ?>
                                </label>

                            </div>

                            <div class="form-group">

                                <input required
                                       type="tel"
                                       class="form-control preferred-contact"
                                       placeholder="<?php _e( 'Phone', 'cdemo' ); ?>"
                                       name="contact[phone]">

                                <input type="email"
                                       class="form-control preferred-contact" name="contact[email]"
                                       placeholder="<?php _e( 'Email', 'cdemo' ); ?>"
                                       style="display: none">

                            </div>

                            <div class="form-group">

                                <?php $max_chars = get_option( Options::CONTACT_FORM_MAXLENGTH ); ?>

                                <label for="comments"><?php _e( 'What would you like to know?', 'cdemo' );?></label>

                                <textarea required
                                          id="comments"
                                          class="comments form-control"
                                          name="contact[comments]"
                                          maxlength="<?php esc_attr_e( $max_chars ); ?>"></textarea>

                                <span class="char-count">
                                    <span class="current-count">0</span> / <?php esc_attr_e( $max_chars ); ?>
                                </span>

                            </div>

                            <input type="hidden" name="type" value="contact" />
                            <input type="hidden" name="id" value="<?php echo esc_attr_e( get_the_ID() ); ?>" />

                            <?php wp_nonce_field( 'contact_form_submit', 'contact_form_nonce' ); ?>

                            <button type="submit" class="btn btn-primary submit"><?php _e( 'Submit', 'cdemo' ); ?></button>

                        </form>
                    </div>
                </div>

            </div>

            <div class="panel panel-primary">

                <div class="panel-heading">

                    <p class="panel-title">
                        <a class="collapsed cdemo-text-hover"
                           data-toggle="collapse"
                           data-parent="#contact-form"
                           href="#test-drive">
                            <?php _e( 'Test Drive', 'cdemo' ); ?>
                        </a>
                    </p>

                </div>

                <div id="test-drive" class="panel-collapse collapse">

                    <div class="panel-body">

                        <form method="post" action="<?php echo esc_url( $form_action ); ?>">

                            <div class="form-group">
                                <input required
                                       placeholder="<?php _e( 'Your name', 'cdemo' ); ?>"
                                       type="text"
                                       class="form-control"
                                       name="contact[name]">
                            </div>

                            <div class="form-group">

                                <label><?php _e('Preferred contact method', 'cdemo' ); ?></label>

                                <label>
                                    <input required
                                           checked
                                           type="radio"
                                           name="contact[preferred]"
                                           value="phone"> <?php _e( 'Phone', 'cdemo' ); ?>
                                </label>

                                <label>
                                    <input type="radio"
                                           name="contact[preferred]"
                                           value="email"> <?php _e( 'Email', 'cdemo' ); ?>
                                </label>

                            </div>

                            <div class="form-group">

                                <input required
                                       type="tel"
                                       class="form-control preferred-contact"
                                       placeholder="<?php _e( 'Phone', 'cdemo' ); ?>"
                                       name="contact[phone]">

                                <input type="email"
                                       class="form-control preferred-contact"
                                       placeholder="<?php _e( 'Email', 'cdemo' ); ?>"
                                       name="contact[email]"
                                       style="display: none">

                            </div>

                            <div class="form-group">

                                <label for="date-time"><?php _e( 'Your requested date and time', 'cdemo' );?></label>

                                <div class="input-group date datetime-picker">

                                    <input id="date-time" required type='text' class="form-control" name="contact[time]" />

                                    <span class="input-group-addon">

                                    <span class="glyphicon glyphicon-calendar"></span>

                                </span>

                                </div>

                            </div>

                            <input type="hidden" name="type" value="test_drive" />
                            <input type="hidden" name="id" value="<?php echo esc_attr_e( get_the_ID() ); ?>" />

                            <?php wp_nonce_field( 'contact_form_submit', 'contact_form_nonce' ); ?>

                            <button type="submit" class="btn btn-primary submit"><?php _e( 'Submit', 'cdemo' ); ?></button>

                        </form>
                    </div>
                </div>

            </div>

        </div>

    <?php endif; ?>

</div>
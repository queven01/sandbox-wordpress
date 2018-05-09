<?php

namespace cdemo;

$feature_sections = feature_sections( get_post_type() );

?>

<div id="features">

    <div id="feature-sections" class="panel-group">

        <?php foreach ( $feature_sections as $id => $title ) : $features = get_post_meta( get_the_ID(), "features-$id" ); ?>

            <?php if ( !empty( $features ) ) : ?>

                <div class="panel panel-primary">

                    <div class="panel-heading">

                        <p class="panel-title">

                            <a data-parent="#feature-sections"
                               data-toggle="collapse"
                               class="collapsed cdemo-text-hover"
                               href="#<?php esc_attr_e( $id ); ?>-collapse">

                                <?php esc_html_e( $title ); ?>

                            </a>

                        </p>

                    </div>

                    <div id="<?php esc_attr_e( $id ); ?>-collapse" class="panel-collapse collapse collapsed">

                        <div class="list-group">

                            <?php foreach ( $features as $feature ) : ?>

                                <div class="list-group-item"><?php esc_html_e( $feature ); ?></div>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    </div>

</div>








<!--<div class="row title-bar">-->
<!---->
<!--    <div class="col-sm-6">-->
<!--        <h4>--><?php //_e( 'Vehicle Details', 'cdemo' ); ?><!--</h4>-->
<!--    </div>-->
<!---->
<!--    <div class="col-sm-6">-->
<!---->
<!--        <ul class="nav nav-pills tabs pull-right">-->
<!--            <li class="active">-->
<!--                <a href="#features" data-toggle="tab">--><?php //_e( 'Features', 'cdemo' ); ?><!--</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#warranty" data-toggle="tab">--><?php //_e( 'Warranty', 'cdemo' ); ?><!--</a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a href="#safety" data-toggle="tab">--><?php //_e( 'Safety', 'cdemo' ); ?><!--</a>-->
<!--            </li>-->
<!--        </ul>-->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->
<!---->
<!--<div class="row">-->
<!---->
<!--    <div class="col-sm-12">-->
<!---->
<!--        <div class="tabs-content">-->
<!---->
<!--            <div id="features" class="tab-pane fade in panel panel-primary active">-->
<!---->
<!--                <div class="panel-heading">-->
<!--                    <h3 class="panel-title">-->
<!--                        <span class="glyphicon glyphicon-list"></span>-->
<!--                        <a data-toggle="collapse" href="#features-collapse" class="collapsed">-->
<!--                            --><?php //_e( 'Features', 'cdemo' ); ?>
<!--                        </a>-->
<!--                    </h3>-->
<!--                </div>-->
<!---->
<!--                <div id="features-collapse" class="panel-collapse collapse">-->
<!--                    <div class="panel-body">-->
<!--                        <ul>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Moonroof</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Driver Heated Seat</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Power Driver Seat</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Passenger Heated Seat</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Power Passenger Seat</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Air Conditioning</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Electronic Climate Control</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Tilt Steering Wheel</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Cruise Control</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Power Windows</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Power Locks</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Traction Control</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Electronic Stability Program</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Keyless Remote</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Alarm Fob -OEM</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">AM/FM Stereo</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">CD Player</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">CD Changer</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Satellite Radio</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Bluetooth Stereo Adapter</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Alloy Wheels</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Chrome Alloy Wheels</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Bucket Seats</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Fog Lights</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Driver and Passenger Power Mirrors</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Heated Mirrors</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Rear Window Defrost</li>-->
<!--                            <li class="col-xs-12 col-sm-4 col-md-3 col-lg-3">Garage Door Opener</li>-->
<!--                        </ul>-->
<!--                        <div class="clearfix"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div id="warranty" class="tab-pane fade panel panel-primary">-->
<!---->
<!--                <div class="panel-heading">-->
<!--                    <h3 class="panel-title">-->
<!--                        <span class="glyphicon glyphicon-check"></span>-->
<!--                        <a data-toggle="collapse" href="#warranty-collapse" class="collapsed">-->
<!--                            --><?php //_e( 'Warranty', 'cdemo' ); ?>
<!--                        </a>-->
<!--                    </h3>-->
<!--                </div>-->
<!---->
<!--                <div id="warranty-collapse" class="panel-collapse collapse">-->
<!--                    <table class="table">-->
<!--                        <tr>-->
<!--                            <th>Basic Years</th>-->
<!--                            <td>4</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Basic Miles/km</th>-->
<!--                            <td>80,000</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Drivetrain Years</th>-->
<!--                            <td>100,000</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Corrosion Years</th>-->
<!--                            <td>12</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Corrosion Miles/km</th>-->
<!--                            <td>Unlimited</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Roadside Assistance Years</th>-->
<!--                            <td>4</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Roadside Assistance Miles/km</th>-->
<!--                            <td>80,000</td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!---->
<!--            <div id="safety" class="tab-pane fade panel panel-primary">-->
<!---->
<!--                <div class="panel-heading">-->
<!--                    <h3 class="panel-title">-->
<!--                        <span class="glyphicon glyphicon-certificate"></span>-->
<!--                        <a data-toggle="collapse" href="#safety-collapse" class="collapsed">-->
<!--                            --><?php //_e( 'Safety', 'cdemo' ); ?>
<!--                        </a>-->
<!--                    </h3>-->
<!--                </div>-->
<!---->
<!--                <div id="safety-collapse" class="panel-collapse collapse">-->
<!--                    <table class="table">-->
<!--                        <tr>-->
<!--                            <th>Overall Rating</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Overall Frontal Barrier Crash Rating</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Frontal Barrier Crash Rating Driver</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Frontal Barrier Crash Rating Passenger</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Frontal Crash Test Note</th>-->
<!--                            <td>	The frontal safety ratings assigned to this vehicle apply to those that were manufactured after November 27, 2011 or have received repairs under Volkswagen Customer Service Action Notice 72D9/V7. Owners of vehicles manufactured on or before November 27, 2011 should check to be sure their vehicles have been serviced under this service campaign as those that have not may not earn the same frontal safety ratings.</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Note</th>-->
<!--                            <td>Not Applicable</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Overall Side Crash Rating</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Side Barrier Rating</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Side Barrier Rating Driver</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Side Barrier Rating Passenger Rear Seat</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Side Barrier Rating Note</th>-->
<!--                            <td>Not Applicable</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Side Pole Rating Driver Front Seat</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Male/Female Dummy Note</th>-->
<!--                            <td>Not ApplicableMale: Average sized adult male dummy in 35-MPH crash into fixed barrier. Rating is evaluation of injury to head, neck, chest, legs. Female: Small-sized adult female dummy in 35-mph crash into fixed barrier. Rating is evaluation of injury to head, neck, chest, legs.-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <th>Combined Side Rating Front Seat</th>-->
<!--                            <td>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                                <span class="glyphicon glyphicon-star"></span>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!---->
<!--</div>-->

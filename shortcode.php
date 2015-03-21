<?php
/**
 * @author 		Sanskript Solutions
 * @version     1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function neigbourhoodio_wp_enqueue_scripts() {
    wp_enqueue_script('jsapi','https://www.google.com/jsapi');
}
add_action('wp_enqueue_scripts', 'neigbourhoodio_wp_enqueue_scripts');

function neigbourhoodio_google_chart($atts, $content = null, $code = "") {
    global $wp_query;
    global $wpdb;
    global $id;

    $defaults = array(
        'id'	 => 'ni',
        'before' => '',
        'after'  => '',
        'wrap'	 => 'div',
        'lat'  => '',
        'lon' => '',
        'postmetalat'  => '',
        'postmetalon' => '',
    );

    extract( shortcode_atts( $defaults, $atts ) );


    $isValid = false;
    if(!empty($lat)){
        if(!empty($lon)){
            $latitude = $lat;
            $longitude = $lon;
            $isValid = true;
        }
    }
    if(!$isValid)
    {
        global $post;
        $latitude =get_post_meta($post->id,$postmetalat);
        $longitude =get_post_meta($post->id,$postmetalon);
        if(!empty($latitude)) {
            if(!empty($longitude)) {
                $isValid = true;
            }
        }
    }

    if($isValid)
    {

        $key = get_option('neighbourhoodio-key', false);
        if(!empty($key)) {
            $ni_json = "";
            if (empty($ni_json)) {
                $latitude = $lat;
                $longitude = $lon;
                if (!empty($latitude)) {
                    $url = "https://neighbourhoodio.azurewebsites.net/v11/api/Neighbournood?Latitude={$latitude}&Longitude={$longitude}&key={$key}";
                    $response = wp_remote_get($url, array('timeout' => 15));
                    if ( is_wp_error( $response ) ) {
                    }
                    else{
                        if ($response ['response'] ['code'] == 200) {
                            $ni_json =  wp_remote_retrieve_body($response);
                        }
                        else{
                            $ni_json ="";
                        }
                    }
                }
            }

            if (!empty($ni_json)) {
                $json = json_decode($ni_json, true);

                ob_start();

                ?>

                <script type="text/javascript">
                    google.load('visualization', '1.0', {'packages': ['corechart']});
                    google.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Age"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Age'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_age_chart_div'));
                        chart.draw(data, options);
                    }

                    google.setOnLoadCallback(drawChartMotherTounge);
                    function drawChartMotherTounge() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["MotherTongue"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Mother Tounge'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_mothertounge_chart_div'));
                        chart.draw(data, options);
                    }

                    google.setOnLoadCallback(drawChartMotherGender);
                    function drawChartMotherGender() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Gender"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Gender'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_gender_chart_div'));
                        chart.draw(data, options);
                    }

                    google.setOnLoadCallback(drawChartMaritalStatus);
                    function drawChartMaritalStatus() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["MaritalStatus"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'MaritalStatus'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_maritalstatus_chart_div'));
                        chart.draw(data, options);
                    }

                    google.setOnLoadCallback(drawChartEducation);
                    function drawChartEducation() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Education"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Education'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_education_chart_div'));
                        chart.draw(data, options);
                    }

                    google.setOnLoadCallback(drawChartEmployment);
                    function drawChartEmployment() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Employment"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Employment'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_employment_chart_div'));
                        chart.draw(data, options);
                    }

                    <?php if( !empty($json["Income"]["Data"] )){ ?>
                    google.setOnLoadCallback(drawChartIncome);
                    function drawChartIncome() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Income"]["Data"] as $key=>$value)
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Income'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_income_chart_div'));
                        chart.draw(data, options);
                    }
                    <?php } ?>

                    google.setOnLoadCallback(drawChartReligion);
                    function drawChartReligion() {
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Range');
                        data.addColumn('number', 'People');
                        data.addRows([
                            <?php
                                 foreach($json["Religion"]["Data"] as $key=>$value) //Religion
                                 {
                                        $niKey = $value["Key"];
                                        $niValue = $value["Value"];
                                        echo "['$niKey ', $niValue],";
                                 }
                            ?>
                        ]);
                        var options = {
                            'title': 'Religion'/* ,
                             /*  'width':400,
                             'height':300*/
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('<?php echo $id;?>_religion_chart_div'));
                        chart.draw(data, options);
                    }

                </script>
                <div id="<?php echo $id;?>_age_chart_div"></div>
                <div id="<?php echo $id;?>_mothertounge_chart_div"></div>
                <div id="<?php echo $id;?>_gender_chart_div"></div>
                <div id="<?php echo $id;?>_maritalstatus_chart_div"></div>
                <div id="<?php echo $id;?>_education_chart_div"></div>
                <div id="<?php echo $id;?>_employment_chart_div"></div>
                <div id="<?php echo $id;?>_income_chart_div"></div>
                <div id="<?php echo $id;?>_religion_chart_div"></div>
            <?PHP
            }
        }
        return ob_get_clean();
    }
    return "";
}

add_shortcode("neigbourhoodio-chart","neigbourhoodio_google_chart");
?>
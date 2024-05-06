<?php
/*
Plugin Name: Where's that Station?
Description: Display the time zone and current time of a US TV station based on call letters.
Version: 1.0.1
Author: Chris Stelly
Author URI: https://github.com/heliogoodbye
License: GPL3
*/

// Add shortcode to display TV station time zone and current time
function wheres_that_station_shortcode() {
    ob_start(); ?>
    <style>
        #wheres-that-station-form {
            text-align: center;
            border: 2px solid #007bff;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto;
		}
			
		#result p {
            margin: 0 auto;
        }
		
		#result h4 {
            margin: 0 auto;
        }
		
		#result h1 {
            margin: 0 auto;
        }
    </style>
    <div id="wheres-that-station-form">
        <form id="station-form" method="post">
            <label for="call_letters">Call Letters:</label>
            <input type="text" id="call_letters" name="call_letters" required maxlength="4">
            <input type="submit" value="Submit">
        </form>
        <div id="result"></div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('#station-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: formData + '&action=get_station_timezone',
                    success: function(response) {
                        $('#result').html(response);
                    }
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('wheres_that_station', 'wheres_that_station_shortcode');

// Function to get time zone based on call letters
function get_station_time_zone() {
    $call_letters = isset($_POST['call_letters']) ? strtoupper(sanitize_text_field($_POST['call_letters'])) : ''; // Convert input to uppercase
    $station_time_zones = array(
		'WIAT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Birmingham', 'state' => 'AL'),
		'WDHN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Dothan', 'state' => 'AL'),
		'WHNT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Huntsville', 'state' => 'AL'),
		'WHDF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Huntsville', 'state' => 'AL'),
		'WKRG' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Mobile', 'state' => 'AL'),
		'WFNA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Mobile', 'state' => 'AL'),
		'KNWA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Fort Smith–Fayetteville–Springdale–Rogers', 'state' => 'AR'),
		'KFTA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Fort Smith–Fayetteville–Springdale–Rogers', 'state' => 'AR'),
		'KXNW' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Fort Smith–Fayetteville–Springdale–Rogers', 'state' => 'AR'),
		'KARK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Little Rock', 'state' => 'AR'),
		'KARZ' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Little Rock', 'state' => 'AR'),
		'KASN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Little Rock', 'state' => 'AR'),
		'KLRT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Little Rock', 'state' => 'AR'),
		'KAZT' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Phoenix', 'state' => 'AZ'),
		'KGET' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Bakersfield', 'state' => 'CA'),
		'KKEY' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Bakersfield', 'state' => 'CA'),
		'KSEE' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Fresno', 'state' => 'CA'),
		'KGPE' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Fresno', 'state' => 'CA'),
		'KKEY' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Bakersfield', 'state' => 'CA'),
		'KTLA' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Los Angeles', 'state' => 'CA'),
		'KTXL' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Sacramento', 'state' => 'CA'),
		'KSWB' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'San Diego', 'state' => 'CA'),
		'KUSI' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'San Diego', 'state' => 'CA'),
		'KRON' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'San Francisco', 'state' => 'CA'),
		'KRON' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'San Francisco', 'state' => 'CA'),
		'KXRM' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Colorado Springs', 'state' => 'CO'),
		'KXTU' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Colorado Springs', 'state' => 'CO'),
		'KWGN' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Denver', 'state' => 'CO'),
		'KDVR' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Denver', 'state' => 'CO'),
		'KWGN' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Denver', 'state' => 'CO'),
		'KFCT' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Cheyenne', 'state' => 'WY'),
		'KFQX' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Grand Junction', 'state' => 'CO'),
		'KREX' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Grand Junction', 'state' => 'CO'),
		'KGJT' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Grand Junction', 'state' => 'CO'),
		'KREY' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Montrose', 'state' => 'CO'),
		'WTNH' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'New Haven-Hartford', 'state' => 'CT'),
		'WCTX' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'New Haven-Hartford', 'state' => 'CT'),
		'WDCW' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Washington', 'state' => 'DC'),
		'WDVM' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Washington', 'state' => 'DC'),
		'WMBB' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Panama City', 'state' => 'FL'),
		'WFLA' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Tampa', 'state' => 'FL'),
		'WTTA' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Tampa', 'state' => 'FL'),
		'WSNN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Tampa', 'state' => 'FL'),
		'WJBF' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Augusta', 'state' => 'GA'),
		'WRBL' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Columbus', 'state' => 'GA'),
		'WSAV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Savannah', 'state' => 'GA'),
		'KHON' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Honolulu', 'state' => 'HI'),
		'KHII' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Honolulu', 'state' => 'HI'),
		'KHAW' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Hilo', 'state' => 'HI'),
		'KGMD' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Hilo', 'state' => 'HI'),
		'KAII' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Wailuku', 'state' => 'HI'),
		'KGMV' => array('timezone' => 'Pacific/Honolulu', 'name' => 'Hawaii-Aleutian Time', 'city' => 'Wailuku', 'state' => 'HI'),
		'WCIA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Champaign–Urbana–Springfield–Decatur', 'state' => 'IL'),
		'WCIX' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Champaign–Urbana–Springfield–Decatur', 'state' => 'IL'),
		'WGN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Chicago', 'state' => 'IL'),
		'WMBD' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Peoria', 'state' => 'IL'),
		'WYZZ' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Peoria', 'state' => 'IL'),
		'WQRF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Rockford', 'state' => 'IL'),
		'WTVO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Rockford', 'state' => 'IL'),
		'WHBF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Davenport–Burlington–Rock Island,', 'state' => 'IL'),
		'KLJB' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Davenport–Burlington–Rock Island,', 'state' => 'IL'),
		'KGCW' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Davenport–Burlington–Rock Island,', 'state' => 'IL'),
		'WEHT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Evansville', 'state' => 'IN'),
		'WTVW' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Evansville', 'state' => 'IN'),
		'WANE' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Fort Wayne', 'state' => 'IN'),
		'WXIN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Indianapolis', 'state' => 'IN'),
		'WTTV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Indianapolis', 'state' => 'IN'),
		'WTTK' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Kokomo', 'state' => 'IN'),
		'WTWO' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Terre Haute', 'state' => 'IN'),
		'WAWV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Terre Haute', 'state' => 'IN'),
		'WHO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Des Moines', 'state' => 'IA'),
		'KCAU' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Sioux City', 'state' => 'IA'),
		'KSNT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Topeka', 'state' => 'KS'),
		'KTMJ' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Topeka', 'state' => 'KS'),
		'KTKA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Topeka', 'state' => 'KS'),
		'KSNW' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Wichita', 'state' => 'KS'),
		'KSNC' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Great Bend', 'state' => 'KS'),
		'KSNG' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Garden City', 'state' => 'KS'),
		'KSNK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'McCook', 'state' => 'NE'),
		'KSNL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Salina', 'state' => 'KS'),
		'WDKY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Lexington', 'state' => 'KY'),
		'WGMB' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Baton Rouge', 'state' => 'LA'),
		'WVLA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Baton Rouge', 'state' => 'LA'),
		'WBRL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Baton Rouge', 'state' => 'LA'),
		'KZUP' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Baton Rouge', 'state' => 'LA'),
		'KLFY' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Lafayette', 'state' => 'LA'),
		'KARD' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Monroe-West Monroe', 'state' => 'LA'),
		'KTVE' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Monroe-West Monroe', 'state' => 'LA'),
		'WGNO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'New Orleans', 'state' => 'LA'),
		'WNOL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'New Orleans', 'state' => 'LA'),
		'KTAL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Shreveport', 'state' => 'LA'),
		'KMSS' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Shreveport', 'state' => 'LA'),
		'KSHV' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Shreveport', 'state' => 'LA'),
		'WWLP' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Springfield', 'state' => 'MA'),
		'WFXQ' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Springfield', 'state' => 'MA'),
		'WJMN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Marquette', 'state' => 'MI'),
		'WOOD' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Grand Rapids', 'state' => 'MI'),
		'WXSP' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Grand Rapids', 'state' => 'MI'),
		'WOTV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Battle Creek', 'state' => 'MI'),
		'WLNS' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Lansing', 'state' => 'MI'),
		'WLAJ' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Lansing', 'state' => 'MI'),
		'WJTV' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Jackson', 'state' => 'MS'),
		'WHLT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Hattiesburg-Laurel', 'state' => 'MS'),
		'WNTZ' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Alexandria', 'state' => 'LA'),
		'KSNF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Joplin', 'state' => 'MO'),
		'KODE' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Joplin', 'state' => 'MO'),
		'WDAF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Kansas City', 'state' => 'MO'),
		'KTVI' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'St. Louis', 'state' => 'MO'),
		'KPLR' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'St. Louis', 'state' => 'MO'),
		'KOZL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Springfield-Branson', 'state' => 'MO'),
		'KRBK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Springfield-Branson', 'state' => 'MO'),
		'KOLR' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Springfield-Branson', 'state' => 'MO'),
		'KSVI' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Billings', 'state' => 'MT'),
		'KHMT' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Billings', 'state' => 'MT'),
		'KLAS' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Las Vegas', 'state' => 'NV'),
		'KRQE' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Albuquerque', 'state' => 'NM'),
		'KWBQ' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Albuquerque', 'state' => 'NM'),
		'KASY' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Albuquerque', 'state' => 'NM'),
		'KBIM' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Roswell', 'state' => 'NM'),
		'KRWB' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Roswell', 'state' => 'NM'),
		'KREZ' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Durango', 'state' => 'CO'),
		'WTEN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Albany–Schenectady–Troy', 'state' => 'NY'),
		'WXXA' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Albany–Schenectady–Troy', 'state' => 'NY'),
		'WIVT' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Binghamton', 'state' => 'NY'),
		'WBGH' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Binghamton', 'state' => 'NY'),
		'WIVB' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Buffalo', 'state' => 'NY'),
		'WNLO' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Buffalo', 'state' => 'NY'),
		'WETM' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Elmira', 'state' => 'NY'),
		'WPIX' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'New York', 'state' => 'NY'),
		'WROC' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Rochester', 'state' => 'NY'),
		'WSYR' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Syracuse', 'state' => 'NY'),
		'WUTR' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Utica', 'state' => 'NY'),
		'WFXV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Utica', 'state' => 'NY'),
		'WPNY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Utica', 'state' => 'NY'),
		'WWTI' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Watertown', 'state' => 'NY'),
		'WJZY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Charlotte', 'state' => 'NC'),
		'WMYT' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Charlotte', 'state' => 'NC'),
		'WGHP' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'High Point–Greensboro–Winston-Salem', 'state' => 'NC'),
		'WNCT' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Greenville–New Bern–Washington', 'state' => 'NC'),
		'WNCN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Raleigh–Durham–Fayetteville', 'state' => 'NC'),
		'KXMB' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Bismarck', 'state' => 'ND'),
		'KXMA' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Dickinson', 'state' => 'ND'),
		'KXMC' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Minot', 'state' => 'ND'),
		'KXMD' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Williston', 'state' => 'ND'),
		'WJW' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Cleveland', 'state' => 'OH'),
		'WCMH' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Columbus', 'state' => 'OH'),
		'WDTN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Dayton', 'state' => 'OH'),
		'WBDT' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Dayton', 'state' => 'OH'),
		'WKBN' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Youngstown', 'state' => 'OH'),
		'WYFX' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Youngstown', 'state' => 'OH'),
		'WYTV' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Youngstown', 'state' => 'OH'),
		'KFOR' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Oklahoma City', 'state' => 'OK'),
		'KAUT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Oklahoma City', 'state' => 'OK'),
		'KOIN' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Portland', 'state' => 'OR'),
		'KRCW' => array('timezone' => 'America/Los_Angeles', 'name' => 'Pacific Time', 'city' => 'Portland', 'state' => 'OR'),
		'WTAJ' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Altoona-State College-Johnstown', 'state' => 'PA'),
		'WJET' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Erie', 'state' => 'PA'),
		'WFXP' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Erie', 'state' => 'PA'),
		'WHTM' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Harrisburg–Lancaster–Lebanon–York', 'state' => 'PA'),
		'WPHL' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Philadelphia', 'state' => 'PA'),
		'WBRE' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Wilkes Barre-Scranton', 'state' => 'PA'),
		'WYOU' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Wilkes Barre-Scranton', 'state' => 'PA'),
		'WPRI' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Providence', 'state' => 'RI'),
		'WNAC' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Providence', 'state' => 'RI'),
		'WCBD' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Charleston', 'state' => 'SC'),
		'WBTW' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Florence-Myrtle Beach', 'state' => 'SC'),
		'WSPA' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Greenville–Spartanburg–Anderson', 'state' => 'SC'),
		'WYCW' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Greenville–Spartanburg–Anderson', 'state' => 'SC'),
		'KELO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Sioux Falls', 'state' => 'SD'),
		'KDLO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Florence-Aberdeen', 'state' => 'SD'),
		'KPLO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Pierre', 'state' => 'SD'),
		'KCLO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Rapid City', 'state' => 'SD'),
		'WJKT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Jackson', 'state' => 'TN'),
		'WJHL' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Johnson City-Kingsport-Bristol', 'state' => 'TN/VA'),
		'WATE' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Knoxville', 'state' => 'TN'),
		'WREG' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Memphis', 'state' => 'TN'),
		'WKRN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Nashville', 'state' => 'TN'),
		'KTAB' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Abilene', 'state' => 'TX'),
		'KRBC' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Abilene', 'state' => 'TX'),
		'KAMR' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Amarillo', 'state' => 'TX'),
		'KCIT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Amarillo', 'state' => 'TX'),
		'KCPN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Amarillo', 'state' => 'TX'),
		'KXAN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Austin', 'state' => 'TX'),
		'KNVA' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Austin', 'state' => 'TX'),
		'KBVO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Austin', 'state' => 'TX'),
		'KGBT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Brownsville–Harlingen–McAllen', 'state' => 'TX'),
		'KVEO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Brownsville–Harlingen–McAllen', 'state' => 'TX'),
		'KDAF' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Dallas-Fort Worth', 'state' => 'TX'),
		'KTSM' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'El Paso', 'state' => 'TX'),
		'KIAH' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Houston', 'state' => 'TX'),
		'KETK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Tyler-Longview-Lufkin-Nacogdoches', 'state' => 'TX'),
		'KFXK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Tyler-Longview-Lufkin-Nacogdoches', 'state' => 'TX'),
		'KTPN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Tyler-Longview-Lufkin-Nacogdoches', 'state' => 'TX'),
		'KFXL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Tyler-Longview-Lufkin-Nacogdoches', 'state' => 'TX'),
		'KLBK' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Lubbock', 'state' => 'TX'),
		'KAMC' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Lubbock', 'state' => 'TX'),
		'KLST' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'San Angelo', 'state' => 'TX'),
		'KSAN' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Lubbock', 'state' => 'TX'),
		'KWKT' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Waco-Temple-Bryan-College Station', 'state' => 'TX'),
		'KYLE' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Waco-Temple-Bryan-College Station', 'state' => 'TX'),
		'KFDX' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Wichita Falls', 'state' => 'TX'),
		'KJTL' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Wichita Falls', 'state' => 'TX'),
		'KJBO' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Wichita Falls', 'state' => 'TX'),
		'KTVX' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Salt Lake City', 'state' => 'UT'),
		'KUCW' => array('timezone' => 'America/Denver', 'name' => 'Mountain Time', 'city' => 'Salt Lake City', 'state' => 'UT'),
		'WFFF' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Burlington-Plattsburgh', 'state' => 'VT/NY'),
		'WVNY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Burlington-Plattsburgh', 'state' => 'VT/NY'),
		'WAVY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Norfolk–Portsmouth–Virginia Beach', 'state' => 'VA'),
		'WVBT' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Norfolk–Portsmouth–Virginia Beach', 'state' => 'VA'),
		'WRIC' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Norfolk–Portsmouth–Virginia Beach', 'state' => 'VA'),
		'WFXR' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Norfolk–Portsmouth–Virginia Beach', 'state' => 'VA'),
		'WWCW' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Norfolk–Portsmouth–Virginia Beach', 'state' => 'VA'),
		'WBOY' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Clarksburg–Fairmont–Morgantown', 'state' => 'WV'),
		'WOWK' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Huntington-Charleston', 'state' => 'WV'),
		'WVNS' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Bluefield-Beckley', 'state' => 'WV'),
		'WTRF' => array('timezone' => 'America/New_York', 'name' => 'Eastern Time', 'city' => 'Wheeling-Steubenville', 'state' => 'WV/OH'),
		'WFRV' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Green Bay-Appleton', 'state' => 'WI'),
		'WLAX' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'La Crosse', 'state' => 'WI'),
		'WEUX' => array('timezone' => 'America/Chicago', 'name' => 'Central Time', 'city' => 'Eau Claire', 'state' => 'WI'),
    );

    if (array_key_exists($call_letters, $station_time_zones)) {
        $station_info = $station_time_zones[$call_letters];
        $time = new DateTime('now', new DateTimeZone($station_info['timezone']));
        $formatted_time = $time->format('h:i A');
        $result = "<hr /><p>$call_letters is located in</p> <h4>{$station_info['city']}, {$station_info['state']}</h4> <p>which is in</p> <h4>{$station_info['name']}</h4></p><hr /><p>The current time at $call_letters is:</p> <h1>{$formatted_time}</h1>";
    } else {
        $result = "<h4>Station not found</h4>";
    }

    echo $result;
    wp_die(); // This is important to terminate the script after AJAX call
}

add_action('wp_ajax_get_station_timezone', 'get_station_time_zone');
add_action('wp_ajax_nopriv_get_station_timezone', 'get_station_time_zone'); // Allow non-logged-in users to access the AJAX endpoint

// Enqueue plugin stylesheet
function wheres_that_station_enqueue_styles() {
    wp_enqueue_style('wheres-that-station-style', plugins_url('css/wheres-that-station.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'wheres_that_station_enqueue_styles');

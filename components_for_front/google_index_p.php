<?php

// Sample code to test a site via GTmetrix using the Web Testing
// Framework (WTF) API.

// Load the web test framework class.
require_once("Services_WTF_Test.php");
// Create your web test object. You pass in your username and password. For
// GTmetrix, your username is your email, and your password is your API key. You
// can get an API key at https://gtmetrix.com/api/
$test = new Services_WTF_Test("poring.m@mail.ru", "87db4dc259dd9266a461eacb7f65fac6");

// To test a site, run the test() method, and pass in at minimum a url to test. Returns
// the testid on success, or false and error messsage in $test->error if failure.
$url_to_test = "https://lightup.su/";
echo "Testing $url_to_test\n";
$testid = $test->test(array(
    'url' => $url_to_test
));
// if ($testid) {
//     echo "Test started with $testid\n";
// }
// else {
//     die("Test failed: " . $test->error() . "\n");
// }

// Other options include:
//
//      location => 4  - test from the San Antonio test location (see locations below)
//      login-user => 'foo',
//      login-pass => 'bar',  - the test requires http authentication
//      x-metrix-adblock => 1 - use the adblock plugin during this test
//
// For more information on options, see https://gtmetrix.com/api/

// After calling the test method, your URL will begin testing. You can call:
echo "Waiting for test to finish\n";
$test->get_results();

// which will block and return once your test finishes. Alternatively, can call:
//     $state = $test->state() 
// which will return the current state. Please don't check more than once per second.

// Once your test is finished, chech that it completed ok, otherwise get the results.
// Note: you must check twice. The first ->test() method can fail if url is malformed, or
// other immediate error. However, if you get a job id, the test itself may fail if the url
// can not be reached, or some pagespeed error.
if ($test->error()) {
    die($test->error());
}
$testid = $test->get_test_id();
echo "Test completed succesfully with ID  $testid\n <br>";
$results = $test->results();
foreach ($results as $result => $data) {
    echo "$result => $data\n <br>";
}


// Each test has a unique test id. You can load an existing / old test result using:
// echo "Loading test id $testid\n";
// $test->load($testid);

// If you no longer need a test, you can delete it:
// echo "Deleting test id $testid\n";
$result = $test->delete();
if (! $result) { die("error deleting test: " . $test->error()); }

// To list possible testing locations, use locations() method:
// echo "\nLocations GTmetrix can test from:\n";
// $locations = $test->locations();
// Returns an array of associative arrays:
// foreach ($locations as $location) {
//     echo "GTmetrix can run tests from: " . $location["name"] . " using id: " . $location["id"] . " default (" . $location["default"] . ")\n";


// }
echo " <br>";
echo " <br>";
echo " <br>";
echo '<div class="api-table-wrapper">
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Type</th>
                  <th>Required</th>
                  <th>Default</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>url</th>
                  <td>The URL of the page to test</td>
                  <td>string</td>
                  <td>Yes</td>
                  <td></td>
                </tr>
                <tr>
                  <th>location</th>
                  <td>Test location ID</td>
                  <td>string</td>
                  <td>No</td>
                  <td>1</td>
                </tr>
                <tr>
                  <th>browser</th>
                  <td>Browser ID</td>
                  <td>string</td>
                  <td>No</td>
                  <td>3</td>
                </tr>
                <tr>
                  <th>login-user</th>
                  <td>Username for the test page HTTP access authentication — <span class="api-table-note"><strong>this is not the <a href="#api-authentication">API authentication</a>.</strong></span></td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>login-pass</th>
                  <td>Password for the test page HTTP access authentication — <span class="api-table-note"><strong>this is not the <a href="#api-authentication">API authentication</a>.</strong></span></td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-adblock</th>
                  <td>Enable AdBlock</td>
                  <td>integer (0, 1)</td>
                  <td>No</td>
                  <td>0</td>
                </tr>
                <tr>
                  <th>x-metrix-cookies</th>
                  <td>Cookies to send with the request.  This uses the same syntax as the web front end.</td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-video</th>
                  <td>Enable generation of video — <span class="api-table-note"><strong>due to extra storage and processing requirements, a video test requires 3.5 api credits</strong></span></td>
                  <td>integer (0, 1)</td>
                  <td>No</td>
                  <td>0</td>
                </tr>
                <tr>
                  <th>x-metrix-stop-onload</th>
                  <td>Stop the test at window.onload instead of after the page has fully loaded (ie. 2 seconds of network inactivity).</td>
                  <td>integer (0, 1)</td>
                  <td>No</td>
                  <td>0</td>
                </tr>
                <tr>
                  <th>x-metrix-throttle</th>
                  <td>Throttle the connection.  Speed measured in Kbps, latency in ms. See <a href="#api-conn-throttling">Connection Throttling</a> reference section for sample values.</td>
                  <td>string (down/up/latency)</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-allow-url</th>
                  <td>Only load resources that match one of the URLs on this list.  This uses the same syntax as the web front end.</td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-block-url</th>
                  <td>Prevent loading of resources that match one of the URLs on this list.  This occurs after the Only Allow URLs are applied.  This uses the same syntax as the web front end.</td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-dns<span class="api-devtoolkit">*</span></th>
                  <td>Use a custom DNS host and IP to run the test with.</td>
                  <td>string (host:ip_address)</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-simulate-device<span class="api-devtoolkit">*</span></th>
                  <td>Simulate the display of your site on a variety of devices using a pre-selected combination of Screen Resolutions, User Agents, and Device Pixel Ratios. See <a href="#api-sim-devices">Simulated Devices</a> reference section for sample ID values.</td>
                  <td>string (device Id)</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-user-agent<span class="api-devtoolkit">*</span></th>
                  <td>Use a custom User Agent string</td>
                  <td>string</td>
                  <td>No</td>
                  <td></td>
                </tr>
                <tr>
                  <th>x-metrix-browser-width<span class="api-devtoolkit">*</span></th>
                  <td>Set the width of the viewport (in pixels) for the analysis.  Also requires x-metrix-browser-height to be set.</td>
                  <td>string</td>
                  <td>No</td>
                  <td>1366</td>
                </tr>
                <tr>
                  <th>x-metrix-browser-height<span class="api-devtoolkit">*</span></th>
                  <td>Set the height of the viewport (in pixels) for the analysis.  Also requires x-metrix-browser-width to be set.</td>
                  <td>string</td>
                  <td>No</td>
                  <td>768</td>
                </tr>
                <tr>
                  <th>x-metrix-browser-dppx<span class="api-devtoolkit">*</span></th>
                  <td>Set the device pixel ratio for the analysis.  Decimals are allowed.</td>
                  <td>Number (1 - 5)</td>
                  <td>No</td>
                  <td>1</td>
                </tr>
                <tr>
                  <th>x-metrix-browser-rotate<span class="api-devtoolkit">*</span></th>
                  <td>Swaps the width and height of the viewport for the analysis.</td>
                  <td>integer (0, 1)</td>
                  <td>No</td>
                  <td>0</td>
                </tr>
              </tbody>
            </table>
            <p class="api-devtoolkit-info"><span class="api-devtoolkit">*</span> These parameters are only available with a GTmetrix PRO plan. <a href="/pricing.html">Learn more.</a></p><p>
          </p></div>';



/* Sample output:

Testing https://gtmetrix.com/
Test started with PnV4kAr2
Waiting for test to finish
Test completed succesfully with ID PnV4kAr2
  page_load_time => 480
  html_bytes => 3346
  page_elements => 16
  report_url => https://gtmetrix.com/reports/gtmetrix.com/1r5AHf9E/
  html_load_time => 28
  page_bytes => 90094
  pagespeed_score => 95
  yslow_score => 98

Resources
  Resource: report_pdf https://gtmetrix.com/api/0.1/test/PnV4kAr2/report-pdf
  Resource: pagespeed https://gtmetrix.com/api/0.1/test/PnV4kAr2/pagespeed
  Resource: har https://gtmetrix.com/api/0.1/test/PnV4kAr2/har
  Resource: pagespeed_files https://gtmetrix.com/api/0.1/test/PnV4kAr2/pagespeed-files
  Resource: yslow https://gtmetrix.com/api/0.1/test/PnV4kAr2/yslow
  Resource: screenshot https://gtmetrix.com/api/0.1/test/PnV4kAr2/screenshot
Loading test id PnV4kAr2
Deleting test id PnV4kAr2

Locations GTmetrix can test from:
GTmetrix can run tests from: Vancouver, Canada using id: 1 default (1)
GTmetrix can run tests from: London, UK using id: 2 default ()
GTmetrix can run tests from: Sydney, Australia using id: 3 default ()
GTmetrix can run tests from: San Antonio, USA using id: 4 default ()
GTmetrix can run tests from: Mumbai, India using id: 5 default ()

*/

<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Unit tests for date element.
 *
 * @package    certificateelement_date
 * @category   test
 * @copyright  2018 Daniel Neis Araujo <daniel@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Unit tests for date element.
 *
 * @package    certificateelement_date
 * @group      tool_certificate
 * @copyright  2018 Daniel Neis Araujo <daniel@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_certificate_date_element_test_testcase extends advanced_testcase {

    /**
     * Test set up.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Get tenant generator
     * @return tool_tenant_generator
     */
    protected function get_generator() : tool_certificate_generator {
        return $this->getDataGenerator()->get_plugin_generator('tool_certificate');
    }

    /**
     * Test render_html
     */
    public function test_render_html() {
        $certificate1 = $this->get_generator()->create_template((object)['name' => 'Certificate 1']);
        $pageid = $certificate1->add_page();
        $data = json_encode(['dateitem' => \certificateelement_date\element::CUSTOMCERT_DATE_ISSUE, 'dateformat' => 0]);
        $formdata = (object)['name' => 'Date element', 'data' => $data,  'element' => 'date', 'pageid' => $pageid];
        $e = \tool_certificate\element_factory::get_element_instance($formdata);
        $this->assertFalse(empty($e->render_html()));

        $data = json_encode(['dateitem' => \certificateelement_date\element::CUSTOMCERT_DATE_EXPIRY, 'dateformat' => 0]);
        $formdata->data = $data;
        $e = \tool_certificate\element_factory::get_element_instance($formdata);
        $this->assertFalse(empty($e->render_html()));
    }

    /**
     * Test save_unique_data
     */
    public function test_save_unique_data() {
        $certificate1 = $this->get_generator()->create_template((object)['name' => 'Certificate 1']);
        $pageid = $certificate1->add_page();
        $element = $certificate1->new_element_for_page_id($pageid, 'date');
        $e = \tool_certificate\element_factory::get_element_instance($element);
        $newdata = (object)['dateitem' => \certificateelement_date\element::CUSTOMCERT_DATE_ISSUE,
                            'dateformat' => 'strftimedate'];
        $this->assertEquals(json_encode($newdata), $e->save_unique_data($newdata));
    }

    /**
     * Test get_date_formats
     */
    public function test_get_date_formats() {
        $this->assertFalse(empty(\certificateelement_date\element::get_date_formats()));
    }
}
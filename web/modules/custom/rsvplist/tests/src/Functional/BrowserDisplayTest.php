<?php

namespace Drupal\Tests\rsvplist\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests that the RSVPlist Display.
 */
class BrowserDisplayTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['rsvplist'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test user can view rsvpList.
   */
  public function testViewRsvpList() {
    $this->doTest(['access rsvplist report'], "200");
  }

  /**
   * Test user cannot view rsvpList.
   */
  public function testEnableViewRsvpList() {
    $this->doTest(['administer rsvplist'], "403");
    $this->doTest(['view rsvplist'], "403");
    $this->doTest([], "403");
  }

  /**
   * The function for test method.
   */
  private function doTest(array $permission, string $statusCode) {
    $account = $this->drupalCreateUser($permission);
    $this->drupalLogin($account);
    $this->drupalGet('admin/reports/rsvplist');
    $this->assertSession()->statusCodeEquals($statusCode);
  }

}

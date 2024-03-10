<?php

namespace Drupal\Tests\rsvplist\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests that the RSVPlist Display.
 */

class BrowserDisplayTest extends BrowserTestBase{
  protected static $modules = ['rsvplist'];
  protected $defaultTheme = 'stark';

  public function testViewRSVPList() {
    $this->doTest(['access rsvplist report'], "200");
  }

  public function testEnableViewRSVPList() {
    $this->doTest(['administer rsvplist'], "403");
    $this->doTest(['view rsvplist'], "403");
    $this->doTest([], "403");
  }

  private function doTest(array $permission, string $statusCode) {
    $account = $this->drupalCreateUser($permission);
    $this->drupalLogin($account);
    $this->drupalGet('admin/reports/rsvplist');
    $this->assertSession()->statusCodeEquals($statusCode);
  }
}
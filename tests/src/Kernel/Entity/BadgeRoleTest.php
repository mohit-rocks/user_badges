<?php

namespace Drupal\Tests\user_badges\Kernel\Entity;

use Drupal\KernelTests\KernelTestBase;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\user_badges\Entity\Badge;

/**
 * Test role_id behavior on badges.
 *
 * @group user_badges
 */
class BadgeRoleTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['user', 'system', 'user_badges', 'field', 'options', 'file', 'image'];

  /**
   * @var array
   */
  protected $rids = [];

  /**
   * @var array
   */
  protected $badgeIds = [];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Installing needed schema.
    $this->installConfig(['user_badges']);
    $this->installEntitySchema('user');
    $this->installEntitySchema('badge');
    $this->installSchema('system', 'sequences');

    $role = Role::create(['id' => $this->randomMachineName()]);
    $role->save();
    $this->rids[] = $role->id();
    $role = Role::create(['id' => $this->randomMachineName()]);
    $role->save();
    $this->rids[] = $role->id();
    foreach ([[], $this->rids[0], $this->rids] as $rids) {
      $badge = Badge::create([
        'type' => 'image_badge',
        'name' => $this->randomString(),
        'role_id' => $rids,
      ]);
      $badge->save();
      $this->badgeIds[] = $badge->id();
    }
  }

  public function testUserPresave() {
    /** @var \Drupal\user\Entity\User $user */
    $user = User::create(['name' => $this->randomMachineName()]);
    $user->save();
    $this->assertTrue($user->get('field_user_badges')->isEmpty());
    $user->addRole($this->rids[1]);
    $user->save();
    $this->assertSame($user->get('field_user_badges')->count(), 1);
    $this->assertSame($user->get('field_user_badges')->get(0)->getValue(), ['target_id' => $this->badgeIds[2]]);
    $user->removeRole($this->rids[1]);
    $user->save();
    $this->assertTrue($user->get('field_user_badges')->isEmpty());
    $user->addRole($this->rids[0]);
    $user->save();
    $this->assertSame($user->get('field_user_badges')->count(), 2);
    $this->assertSame($user->get('field_user_badges')->get(0)->getValue(), ['target_id' => $this->badgeIds[1]]);
    $this->assertSame($user->get('field_user_badges')->get(1)->getValue(), ['target_id' => $this->badgeIds[2]]);
    $user->get('field_user_badges')->appendItem($this->badgeIds[0]);
    $user->save();
    $this->assertSame($user->get('field_user_badges')->count(), 3);
    for ($i = 0; $i < 3; $i++) {
      $this->assertSame($user->get('field_user_badges')->get($i)->getValue(), ['target_id' => $this->badgeIds[$i]]);
    }
  }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Robot;
use App\Models\Title;
use App\Models\Entry;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data hierarchy
        $this->user = User::factory()->create(['is_admin' => false]);
        $this->robot = Robot::factory()->create(['user_id' => $this->user->id]);
        $this->title = Title::factory()->create(['robot_id' => $this->robot->id]);
        $this->entry = Entry::factory()->create([
            'title_id' => $this->title->id,
            'robot_id' => $this->robot->id,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function user_has_many_robots()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->user->robots);
        $this->assertTrue($this->user->robots->contains($this->robot));
        $this->assertEquals(1, $this->user->robots->count());
    }

    /** @test */
    public function robot_belongs_to_user()
    {
        $this->assertInstanceOf(User::class, $this->robot->user);
        $this->assertEquals($this->user->id, $this->robot->user->id);
    }

    /** @test */
    public function robot_has_many_titles()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->robot->titles);
        $this->assertTrue($this->robot->titles->contains($this->title));
        $this->assertEquals(1, $this->robot->titles->count());
    }

    /** @test */
    public function title_belongs_to_robot()
    {
        $this->assertInstanceOf(Robot::class, $this->title->robot);
        $this->assertEquals($this->robot->id, $this->title->robot->id);
    }

    /** @test */
    public function robot_has_many_entries()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->robot->entries);
        $this->assertTrue($this->robot->entries->contains($this->entry));
        $this->assertEquals(1, $this->robot->entries->count());
    }

    /** @test */
    public function title_has_many_entries()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->title->entries);
        $this->assertTrue($this->title->entries->contains($this->entry));
        $this->assertEquals(1, $this->title->entries->count());
    }

    /** @test */
    public function entry_belongs_to_title()
    {
        $this->assertInstanceOf(Title::class, $this->entry->title);
        $this->assertEquals($this->title->id, $this->entry->title->id);
    }

    /** @test */
    public function entry_belongs_to_robot()
    {
        $this->assertInstanceOf(Robot::class, $this->entry->robot);
        $this->assertEquals($this->robot->id, $this->entry->robot->id);
    }

    /** @test */
    public function entry_belongs_to_user()
    {
        $this->assertInstanceOf(User::class, $this->entry->user);
        $this->assertEquals($this->user->id, $this->entry->user->id);
    }

    /** @test */
    public function can_load_nested_relationships()
    {
        $userWithRelations = User::with('robots.titles.entries')->find($this->user->id);
        
        $this->assertNotNull($userWithRelations->robots);
        $this->assertNotNull($userWithRelations->robots->first()->titles);
        $this->assertNotNull($userWithRelations->robots->first()->titles->first()->entries);
        
        // Verify the relationship chain: User -> Robot -> Title -> Entry
        $this->assertEquals(
            $this->entry->id,
            $userWithRelations->robots->first()->titles->first()->entries->first()->id
        );
    }

    /** @test */
    public function admin_relationships_work()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        // Admin created robot
        $adminRobot = Robot::factory()->create([
            'user_id' => $this->user->id,
            'created_by_admin_id' => $admin->id,
            'created_by_admin_at' => now()
        ]);

        // Admin created title
        $adminTitle = Title::factory()->create([
            'robot_id' => $this->robot->id,
            'created_by_admin_id' => $admin->id
        ]);

        // Admin approved entry
        $adminEntry = Entry::factory()->create([
            'title_id' => $this->title->id,
            'robot_id' => $this->robot->id,
            'user_id' => $this->user->id,
            'approved_by_admin_id' => $admin->id,
            'moderation_status' => 'approved',
            'approved_at' => now()
        ]);

        // Test admin relationships
        $this->assertInstanceOf(User::class, $adminRobot->createdByAdmin);
        $this->assertEquals($admin->id, $adminRobot->createdByAdmin->id);
        
        $this->assertInstanceOf(User::class, $adminTitle->createdByAdmin);
        $this->assertEquals($admin->id, $adminTitle->createdByAdmin->id);
        
        $this->assertInstanceOf(User::class, $adminEntry->approvedByAdmin);
        $this->assertEquals($admin->id, $adminEntry->approvedByAdmin->id);
    }

    /** @test */
    public function cascade_deletes_work()
    {
        $entryId = $this->entry->id;
        $titleId = $this->title->id;
        $robotId = $this->robot->id;

        // When robot is deleted, titles and entries should cascade delete
        $this->robot->delete();

        $this->assertDatabaseMissing('robots', ['id' => $robotId]);
        $this->assertDatabaseMissing('titles', ['id' => $titleId]);
        $this->assertDatabaseMissing('entries', ['id' => $entryId]);
    }
}

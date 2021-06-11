<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$user1 = User::factory()->create([
			'email' => 'john@doe.com'
		]);
		$user2 = User::factory()->create([
			'email' => 'jane@doe.com'
		]);

		$channel1 = Channel::factory()->create([
			'user_id' => $user1->id
		]);
		$channel2 = Channel::factory()->create([
			'user_id' => $user2->id
		]);

		$channel1->subscriptions()->create([
			'user_id' => $user2->id
		]);
		$channel2->subscriptions()->create([
			'user_id' => $user1->id
		]);

		Subscription::factory()->count(100)->create([
			'channel_id' => $channel1->id
		]);
		Subscription::factory()->count(100)->create([
			'channel_id' => $channel2->id
		]);
    }
}

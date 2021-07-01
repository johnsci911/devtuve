<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

        $video = Video::factory()->create([
            'channel_id' => $channel1->id
        ]);

        $userIds = User::all()->pluck('id')->toArray();
        $userCount = User::count();

        Comment::factory()->count(50)
            ->state(new Sequence(
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
            )) 
            ->create([
                'video_id' => $video->id
            ]);

        $comment = Comment::first();

        Comment::factory()->count(50)
            ->state(new Sequence(
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
                ['user_id' => $userIds[rand(1, $userCount)]],
            )) 
            ->create([
                'video_id' => $video->id,
                'comment_id' => $comment->id
            ]);
    }
}

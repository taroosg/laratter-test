<?php

namespace App\Services;

use App\Models\Tweet;
use App\Models\User;

class TweetLikeService
{

  public function isTweetLiked(Tweet $tweet, User $user)
  {
    return $tweet->liked()->where('user_id', $user->id)->exists();
  }

  public function likeTweet(Tweet $tweet, User $user)
  {
    if (!$this->isTweetLiked($tweet, $user)) {
      $tweet->liked()->attach($user->id);
    }
    return $tweet->liked()->count();
  }

  public function dislikeTweet(Tweet $tweet, User $user)
  {
    return $tweet->liked()->detach($user->id);
  }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Services\TweetService;
use App\Http\Requests\TweetCreateRequest;
use App\Http\Requests\TweetUpdateRequest;

class TweetController extends Controller
{
  protected $tweetService;

  public function __construct(TweetService $tweetService)
  {
    $this->tweetService = $tweetService;
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $this->authorize('viewAny', Tweet::class);

    $tweets = $this->tweetService->allTweets();
    return response()->json($tweets);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(TweetCreateRequest $request)
  {
    $this->authorize('create', Tweet::class);

    $tweet = $this->tweetService->createTweet($request->only('tweet'), $request->user());
    return response()->json($tweet, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(Tweet $tweet)
  {
    $this->authorize('view', $tweet);

    return response()->json($tweet);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(TweetUpdateRequest $request, Tweet $tweet)
  {
    $this->authorize('update', $tweet);

    $updatedTweet = $this->tweetService->updateTweet($tweet, $request->all());

    return response()->json($tweet);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Tweet $tweet)
  {
    $this->authorize('delete', $tweet);

    $this->tweetService->deleteTweet($tweet);
    return response()->json(['message' => 'Tweet deleted successfully']);
  }
}

<?php
namespace App\Http\Controllers;

use Atymic\Twitter\Facade\Twitter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Exception;

class TwitterController extends Controller
{
    /**
     * တွစ်တင်ခြင်း
     * @return JsonResponse
     */
    public function postTweet(): JsonResponse
    {
        try {
            $response = Twitter::forApiV2()->getQuerier()->post('tweets', [
                'text' => 'Hello from Laravel 12 using Twitter API!',
            ]);
            return response()->json(['message' => 'Tweet posted successfully!', 'response' => $response]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * အသုံးပြုသူတွစ်များကို ဖတ်ယူခြင်း
     * @return JsonResponse
     */
    public function getUserTweets2(): JsonResponse
    {
        try {
            $tweets = Twitter::forApiV2()->getQuerier()->get('users/by/username/@yan_wai29427
/tweets', [
                'max_results' => 10,
            ]);
            return response()->json(['tweets' => $tweets]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * မီဒီယာပါသော တွစ်တင်ခြင်း
     * @return JsonResponse
     */
    public function postTweetWithMedia(): JsonResponse
    {
        try {
            $uploadedMedia = Twitter::uploadMedia(['media' => File::get(public_path('image.jpg'))]);
            $response = Twitter::forApiV2()->getQuerier()->post('tweets', [
                'text' => 'Tweet with media from Laravel 12!',
                'media' => ['media_ids' => [$uploadedMedia->media_id_string]],
            ]);
            return response()->json(['message' => 'Tweet with media posted successfully!', 'response' => $response]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * အသုံးပြုသူစုစုပေါင်းကို ဖတ်ယူခြင်း
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        try {
            $users = Twitter::forApiV2()->getQuerier()->get('users', [
                'max_results' => 10,
            ]);
            return response()->json(['users' => $users]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * အသုံးပြုသူကို ဖတ်ယူခြင်း
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        try {
            $user = Twitter::forApiV2()->getQuerier()->get('users/' . $request->id);
            return response()->json(['user' => $user]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * အသုံးပြုသူ၏ တွစ်များကို ဖတ်ယူခြင်း
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserTweets(Request $request): JsonResponse
    {
        try {
            $tweets = Twitter::forApiV2()->getQuerier()->get('users/' . $request->id . '/tweets', [
                'max_results' => 10,
            ]);
            return response()->json(['tweets' => $tweets]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

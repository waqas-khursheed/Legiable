<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Member,
    ExecutiveLeader,
    Bill,
    BillCosponsor,
    MemberTerm,
    SaveRepresentative,
    LikeRepresentative,
    LikeExecutive,
    SaveExecutive
};
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Members\MemberResource;
use App\Http\Resources\Members\MemberDetailResource;
use App\Http\Resources\Bills\BillResource;
use App\Http\Resources\ExecutiveLeaderResource;
use App\Http\Resources\ExecutiveLeaderDetailResource;

use Illuminate\Support\Facades\DB;

use App\Traits\ApiResponser;

class CongressMemberController extends Controller
{
    use ApiResponser;

    // Representatives
    // public function getRepresentative(Request $request)
    // {
    //     $this->validate($request, [
    //         'latitude' => 'required',
    //         'longitude' => 'required',
    //     ]);

    //     $executiveLeader = ExecutiveLeader::get();
    //     $allRepresentative = Member::limit(10)->get();
    //     $myRepresentative = collect();

    //     $apiKey = config('services.google.api_key');
    //     $url = "https://maps.googleapis.com/maps/api/geocode/json";
    //     $latitude = $request->latitude;
    //     $longitude = $request->longitude;

    //     $response = Http::get($url, [
    //         'latlng' => "{$latitude},{$longitude}",
    //         'key' => $apiKey,
    //     ]);

    //     if ($response->successful()) {
    //         $results = $response->json()['results'];

    //         foreach ($results as $result) {
    //             foreach ($result['address_components'] as $component) {
    //                 if (in_array('administrative_area_level_1', $component['types'])) {
    //                     $state = $component['long_name'];
    //                     $myRepresentative = Member::where('currentMember', '1')->where('state', $state)
    //                         ->limit(10)
    //                         ->get();
    //                     break 2;
    //                 }
    //             }
    //         }
    //     }

    //     $data = [
    //         'executive_leader' => ExecutiveLeaderResource::collection($executiveLeader),
    //         'all_representative' => MemberResource::collection($allRepresentative),
    //         'my_representative' => MemberResource::collection($myRepresentative),
    //     ];

    //     return $this->successDataResponse('Representative found successfully.', $data, 200);
    // }

    public function getRepresentative(Request $request)
    {
        $this->validate($request, [
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $executiveLeader = ExecutiveLeader::get();
        $allRepresentative = Member::limit(10)->get();
        $myRepresentative = collect();

        if ($request->latitude && $request->longitude) {
            $apiKey = config('services.google.api_key');
            $url = "https://maps.googleapis.com/maps/api/geocode/json";
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $response = Http::get($url, [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $apiKey,
            ]);

            if ($response->successful()) {
                $results = $response->json()['results'];

                foreach ($results as $result) {
                    foreach ($result['address_components'] as $component) {
                        if (in_array('administrative_area_level_1', $component['types'])) {
                            $state = $component['long_name'];

                            $myRepresentative = Member::where('currentMember', '1')
                                ->where('state', $state)
                                ->limit(10)
                                ->get();

                            if ($myRepresentative->isNotEmpty()) {
                                break 2;
                            }
                        }
                    }
                }
            }
        }

        if ($myRepresentative->isEmpty()) {
            $myRepresentative = Member::where('currentMember', '1')
                ->inRandomOrder()
                ->limit(10)
                ->get();
        }

        $data = [
            'executive_leader' => ExecutiveLeaderResource::collection($executiveLeader),
            'all_representative' => MemberResource::collection($allRepresentative),
            'my_representative' => MemberResource::collection($myRepresentative),
        ];

        return $this->successDataResponse('Representative found successfully.', $data, 200);
    }


    // Get All Representative
    public function getAllRepresentative(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $members = Member::where('currentMember', '1')
            ->skip($request->offset)
            ->take(10)
            ->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);
            return $this->successDataResponse('All representative found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No representative found.', 400);
        }
    }

    // Representative Detail
    public function representativeDetail(Request $request)
    {
        $this->validate($request, [
            'member_id' => 'required|exists:members,id',
        ]);
        try {
            $member = Member::with(['member_leaderships', 'member_party_histories', 'member_terms'])
                ->where('id', $request->member_id)->first();
            $data = new MemberDetailResource($member);

            return $this->successDataResponse('Representative detail found successfully.', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Representative Bills
    public function representativeBill(Request $request)
    {
        $this->validate($request, [
            'bioguideId' => 'required|exists:members,bioguideId',
            'offset' => 'required|numeric',
        ]);

        $billIds = BillCosponsor::where('bioguideId', $request->bioguideId)->pluck('bill_id');

        $bills = Bill::with(['bill_pdfs'])->whereIn('id', $billIds)->skip($request->offset)
            ->take(10)
            ->get();
        if (count($bills) > 0) {
            $data = BillResource::collection($bills);
            return $this->successDataResponse('Representative bill found successfully', $data, 200);
        } else {
            return $this->errorResponse('Representative bill not found.', 400);
        }
    }

    // Senate & House Representative Count
    public function representativeHouseSenate(Request $request)
    {
        $this->validate($request, [
            'member_type' => 'required|in:Senator,Representative',
        ]);

        $terms = MemberTerm::where('memberType', $request->member_type)
            ->groupBy('member_id')
            ->pluck('member_id');

        $partyCounts = Member::whereIn('id', $terms)
            ->select('partyName', DB::raw('count(*) as count'))
            ->where('currentMember', '1')
            ->groupBy('partyName')
            ->pluck('count', 'partyName');

        $democraticCount = $partyCounts['Democratic'] ?? 0;
        $republicanCount = $partyCounts['Republican'] ?? 0;
        $IndependentCount = $partyCounts['Independent'] ?? 0;

        $data = [
            'Democratic' => $democraticCount,
            'Republican' => $republicanCount,
            'Independent' => $IndependentCount,
        ];

        return $this->successDataResponse('Representative found successfully', $data, 200);
    }

    // Filter State Representative
    public function representativeFilterState(Request $request)
    {
        $this->validate($request, [
            'member_type' => 'required|in:Senator,Representative',
            'state' => 'required',
            'offset' => 'required|numeric',
        ]);

        $terms = MemberTerm::where('memberType', $request->member_type)
            ->groupBy('member_id')
            ->pluck('member_id');

        $members = Member::whereIn('id', $terms)
            ->where('currentMember', '1')
            ->where('state', $request->state)
            ->skip($request->offset)
            ->take(10)->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);
            return $this->successDataResponse('Representative found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No representative found.', 400);
        }
    }

    // Representative Save & Remove
    public function representativeSaveRemove(Request $request)
    {

        $this->validate($request, [
            'member_id' => 'required|exists:members,id',
        ]);

        $authId = auth()->user()->id;

        try {

            $saveExists = SaveRepresentative::where(['user_id' => $authId, 'member_id' => $request->member_id])->first();

            if (!empty($saveExists)) {
                $saveExists->delete();
                return $this->successResponse('Removed representative.');
            } else {
                SaveRepresentative::create([
                    'user_id' => $authId,
                    'member_id'   => $request->member_id
                ]);

                return $this->successResponse('Saved representative successfully.');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    // Representative Saved List
    public function representativeSaveList(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
        ]);

        $authId = auth()->user()->id;

        $savedIds = SaveRepresentative::where('user_id', $authId)->pluck('member_id');

        $members = Member::whereIn('id', $savedIds)->skip($request->offset)
            ->take(10)->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);
            return $this->successDataResponse('Saved representative found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No saved representative found.', 400);
        }
    }

    // Search Representative
    public function searchRepresentative(Request $request)
    {
        $this->validate($request, [
            'offset' => 'required|numeric',
            'search_text' => 'required',
        ]);

        $members = Member::where('directOrderName', 'LIKE', '%' . $request->search_text . '%')
            ->where('currentMember', '1')
            ->skip($request->offset)->take(10)->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);
            return $this->successDataResponse('Search representative found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No representative found.', 400);
        }
    }

    // Compare Representative Memeber
    public function compareRepresentative(Request $request)
    {
        $this->validate($request, [
            'member_ids' => 'required|array',
            'member_ids.*' => 'required|exists:members,id',
        ]);

        $members = Member::whereIn('id', $request->member_ids)->get();

        if (count($members) > 0) {
            $data = MemberResource::collection($members);
            return $this->successDataResponse('Compare representative found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No representative found.', 400);
        }
    }

    // Representative Like & Dislike
    public function representativeLikeDislike(Request $request)
    {
        $this->validate($request, [
            'react_type' => 'required|in:like,dislike',
            'member_id' => 'required|exists:members,id',
            'state' => 'required|string',
        ]);

        $authId = auth()->user()->id;

        try {
            // Check if the user has already reacted to this member
            $existingReaction = LikeRepresentative::where('user_id', $authId)
                ->where('member_id', $request->member_id)->where('state', $request->state)
                ->first();

            // If the reaction already exists
            if ($existingReaction) {
                if (($existingReaction->is_like && $request->react_type == 'like') || (!$existingReaction->is_like && $request->react_type == 'dislike')) {
                    // User clicked the same reaction twice (remove the reaction)
                    $existingReaction->delete();
                    return $this->successResponse('Reaction removed.');
                } else {
                    // User is changing their reaction (like -> dislike or dislike -> like)
                    $existingReaction->is_like = $request->react_type == 'like' ? '1' : '0';
                    $existingReaction->save();

                    return $this->successResponse('Reaction updated.');
                }
            } else {
                // No existing reaction, create a new one
                LikeRepresentative::create([
                    'user_id' => $authId,
                    'member_id' => $request->member_id,
                    'state' => $request->state,
                    'is_like' => $request->react_type == 'like' ? '1' : '0',
                ]);
                return $this->successResponse('Reaction added.');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Representative Like Dislike List
    public function representativeLikeDislikeList(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'state' => 'required|string',
            'member_id' => 'required|exists:members,id',
        ]);

        try {
            // Get total reactions (likes + dislikes), total likes, and total dislikes state-wise
            $totalReactions = LikeRepresentative::where('member_id', $request->member_id)
                ->where('state', $request->state)->count();

            $totalLikes = LikeRepresentative::where('member_id', $request->member_id)
                ->where('state', $request->state)
                ->where('is_like', '1')
                ->count();

            $totalDislikes = LikeRepresentative::where('member_id', $request->member_id)
                ->where('state', $request->state)
                ->where('is_like', '0')
                ->count();

            // Calculate percentage of likes and dislikes
            $percentageLikes = $totalReactions > 0 ? ($totalLikes / $totalReactions) * 100 : 0;
            $percentageDislikes = $totalReactions > 0 ? ($totalDislikes / $totalReactions) * 100 : 0;

            $data = [
                'total_reactions' => $totalReactions,
                'total_likes' => $totalLikes,
                'total_dislikes' => $totalDislikes,
                'percentage_likes' => round($percentageLikes, 2), // Round to 2 decimal places
                'percentage_dislikes' => round($percentageDislikes, 2), // Round to 2 decimal places
            ];

            return $this->successDataResponse('Representative like dislike list found successfully.', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Executive Leader List
    public function executiveLeaderList()
    {
        $executiveLeader = ExecutiveLeader::get();

        if (count($executiveLeader) > 0) {
            $data = ExecutiveLeaderResource::collection($executiveLeader);
            return $this->successDataResponse('Executive leader found successfully.', $data, 200);
        } else {
            return $this->errorResponse('No executive leader found.', 400);
        }
    }

    // Executive Leader Detail
    public function executiveLeaderDetail(Request $request)
    {
        $this->validate($request, [
            'executive_id' => 'required|exists:executive_leaders,id',
        ]);

        try {
            $executiveLeader = ExecutiveLeader::whereId($request->executive_id)->first();

            $data = new ExecutiveLeaderDetailResource($executiveLeader);
            return $this->successDataResponse('Executive leader detail found successfully.', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Executive Leader Save & Remove
    public function executiveLeaderSaveRemove(Request $request)
    {
        $this->validate($request, [
            'executive_id' => 'required|exists:executive_leaders,id',
        ]);

        $authId = auth()->user()->id;

        try {
            $saveExists = SaveExecutive::where(['user_id' => $authId, 'executive_id' => $request->executive_id])->first();

            if (!empty($saveExists)) {
                $saveExists->delete();
                return $this->successResponse('Removed executive.');
            } else {
                SaveExecutive::create([
                    'user_id' => $authId,
                    'executive_id'   => $request->executive_id
                ]);

                return $this->successResponse('Saved executive successfully.');
            }
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    // Executive Leader Like & Dislike
    public function executiveLeaderLikeDislike(Request $request)
    {

        $this->validate($request, [
            'react_type' => 'required|in:like,dislike',
            'executive_id' => 'required|exists:executive_leaders,id',
            'state' => 'required|string',
        ]);

        $authId = auth()->user()->id;

        try {
            // Check if the user has already reacted to this member
            $existingReaction = LikeExecutive::where('user_id', $authId)
                ->where('executive_id', $request->executive_id)->where('state', $request->state)
                ->first();

            // If the reaction already exists
            if ($existingReaction) {
                if (($existingReaction->is_like && $request->react_type == 'like') || (!$existingReaction->is_like && $request->react_type == 'dislike')) {
                    // User clicked the same reaction twice (remove the reaction)
                    $existingReaction->delete();
                    return $this->successResponse('Reaction removed.');
                } else {
                    // User is changing their reaction (like -> dislike or dislike -> like)
                    $existingReaction->is_like = $request->react_type == 'like' ? '1' : '0';
                    $existingReaction->save();

                    return $this->successResponse('Reaction updated.');
                }
            } else {
                // No existing reaction, create a new one
                LikeExecutive::create([
                    'user_id' => $authId,
                    'executive_id' => $request->executive_id,
                    'state' => $request->state,
                    'is_like' => $request->react_type == 'like' ? '1' : '0',
                ]);
                return $this->successResponse('Reaction added.');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    // Executive Leader Like & Dislike List update
    public function executiveLeaderLikeDislikeList(Request $request)
    {
        // Validate the incoming request
        $this->validate($request, [
            'state' => 'required|string',
            'executive_id' => 'required|exists:executive_leaders,id',
        ]);

        try {
            // Get total reactions (likes + dislikes), total likes, and total dislikes state-wise
            $totalReactions = LikeExecutive::where('executive_id', $request->executive_id)
                ->where('state', $request->state)
                ->count();

            $totalLikes = LikeExecutive::where('executive_id', $request->executive_id)
                ->where('state', $request->state)
                ->where('is_like', '1')
                ->count();

            $totalDislikes = LikeExecutive::where('executive_id', $request->executive_id)
                ->where('state', $request->state)
                ->where('is_like', '0')
                ->count();

            // Calculate percentage of likes and dislikes
            $percentageLikes = $totalReactions > 0 ? ($totalLikes / $totalReactions) * 100 : 0;
            $percentageDislikes = $totalReactions > 0 ? ($totalDislikes / $totalReactions) * 100 : 0;

            $data = [
                'total_reactions' => $totalReactions,
                'total_likes' => $totalLikes,
                'total_dislikes' => $totalDislikes,
                'percentage_likes' => round($percentageLikes, 2), // Round to 2 decimal places
                'percentage_dislikes' => round($percentageDislikes, 2), // Round to 2 decimal places
            ];

            return $this->successDataResponse('Executive like dislike list found successfully.', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }
}

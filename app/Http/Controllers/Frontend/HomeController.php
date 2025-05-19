<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Biodata;
use App\Models\Course;
use App\Models\Review;
use App\Models\Subcourse;
use App\Models\UserFavourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function home()
    {
        // try {
        //     $courses = Course::with('reviews')
        //         ->select('courses.*')
        //         ->addSelect([
        //             'adjusted_avg_rating' => function ($query) {
        //                 $query->selectRaw('AVG(COALESCE(rating, 0))')
        //                     ->from('reviews')
        //                     ->whereColumn('reviews.course_id', 'courses.id');
        //             }
        //         ])
        //         ->when(request('search'), function ($query) {
        //             $query->where('name', 'like', '%' . request('search') . '%');
        //         })
        //         ->orderByDesc('adjusted_avg_rating') // Order using null-as-zero rating
        //         ->paginate(12);
        //     return view('frontend.pages.home', compact('courses'));
        // } catch (\Throwable $th) {
        //     Log::error('Home view Failed', ['error' => $th->getMessage()]);
        //     return redirect()->back()->with('error', "Something went wrong! Please try again later");
        //     throw $th;
        // }
        try {
            $courses = Course::with('reviews')
                ->select('courses.*')
                ->addSelect([
                    'review_count' => function ($query) {
                        $query->selectRaw('COUNT(*)')
                            ->from('reviews')
                            ->whereColumn('reviews.course_id', 'courses.id');
                    },
                    'adjusted_avg_rating' => function ($query) {
                        $query->selectRaw('AVG(COALESCE(rating, 0))')
                            ->from('reviews')
                            ->whereColumn('reviews.course_id', 'courses.id');
                    }
                ])
                ->when(request('search'), function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                })
                ->orderByDesc('review_count')           // First priority: Most reviews
                ->orderByDesc('adjusted_avg_rating')    // Second priority: Highest rating
                ->paginate(12);

            return view('frontend.pages.home', compact('courses'));

        } catch (\Throwable $th) {
            Log::error('Home view Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
        }

    }

    public function myFavourites()
    {
        try {
            $userFavourites = UserFavourite::with('course.reviews')->where('user_id', auth()->user()->id)->paginate(12);

            return view('frontend.pages.my-favourites', compact('userFavourites'));
        } catch (\Throwable $th) {
            Log::error('Home view Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function newEpisodes()
    {
        try {
            $biodatas = Biodata::with('course','subcourse')->where('is_new', 1)->limit(12)->orderBy('id','desc')->get();
            return view('frontend.pages.new_episodes', compact('biodatas'));
        } catch (\Throwable $th) {
            Log::error('New Episodes view Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function novelDetails($id)
    {
        try {
            $course = Course::with('reviews.user.profile','subcourses')->findOrFail($id);
            $relatedCourses = Course::where('id', '!=', $course->id)
                ->inRandomOrder()
                ->limit(5)
                ->get();
            return view('frontend.pages.novel-details', compact('course','relatedCourses'));
        } catch (\Throwable $th) {
            Log::error('Novel Details view Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function subcourseDetails($id)
    {
        try {
            $subcourse = Subcourse::with('course','biodatas')->findOrFail($id);
            $biodatas = Biodata::where('sub_course_id', $id)->get();
            $relatedCourses = Course::where('id', '!=', $subcourse->course->id)
                ->inRandomOrder()
                ->limit(5)
                ->get();
            return view('frontend.pages.subcourse-details', compact('subcourse','relatedCourses','biodatas'));
        } catch (\Throwable $th) {
            Log::error('Subcourse Details view Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function readNovel($id)
    {
        try {
            $file = Biodata::findOrFail($id);
            return view('frontend.pages.read_novel', compact('file'));
        } catch (\Throwable $th) {
            Log::error('Read Novel Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function storeReview(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|max:5',
            'review' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all())->with('error', 'Validation Error!');
        }
        try {
            $review = new Review();
            $review->user_id = auth()->user()->id;
            $review->course_id = $id;
            $review->rating = $request->rating;
            $review->review = $request->review;
            $review->save();

            return redirect()->route('frontend.novel.details', $id)->with('success', 'Review submitted successfully');
        } catch (\Throwable $th) {
            Log::error('Review Submission Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
    public function addFavourite($id)
    {
        try {
            $course = Course::findOrFail($id);
            $userFavourite = UserFavourite::where('course_id', $course->id)->where('user_id', auth()->user()->id)->first();
            if($userFavourite)
            {
                $userFavourite->delete();
                return redirect()->back()->with('success', 'Removed from Favourite successfully');
            }else{
                $userFavourite = new UserFavourite();
                $userFavourite->user_id = auth()->user()->id;
                $userFavourite->course_id = $course->id;
                $userFavourite->save();
                return redirect()->back()->with('success', 'Added to Favourite successfully');
            }

        } catch (\Throwable $th) {
            Log::error('Add to Favourite Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }
}

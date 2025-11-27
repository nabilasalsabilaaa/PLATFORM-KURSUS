<div class="bg-white rounded-xl shadow-md mt-6">
    <div class="border-b border-neutral-100 px-6 py-4 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <i class="fas fa-star mr-2 text-yellow-400"></i> Course Reviews
            </h3>
            <p class="text-sm text-gray-600 mt-1">
                Average rating: 
                <span class="font-semibold text-gray-900">{{ $avgRating }}/5</span>
                ({{ $reviews->count() }} review{{ $reviews->count() === 1 ? '' : 's' }})
            </p>
        </div>

        @if($reviews->count() > 0)
            <div class="flex items-center space-x-1 text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                @endfor
            </div>
        @endif
    </div>

    <div class="p-6 space-y-6">
        @auth
            @if($isStudent && $isEnrolled)
                <div class="border border-primary-100 rounded-lg p-4 bg-primary-50/40">
                    <h4 class="text-sm font-semibold text-primary-800 mb-2 flex items-center">
                        <i class="fas fa-pen mr-2 text-primary-500"></i>
                        {{ $userReview ? 'Update Your Review' : 'Write a Review' }}
                    </h4>

                    <form action="{{ route('reviews.store', $course) }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Your Rating</label>
                            <select name="rating"
                                    class="w-full md:w-40 border border-neutral-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}"
                                        {{ old('rating', $userReview->rating ?? 5) == $i ? 'selected' : '' }}>
                                        {{ $i }} star{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Your Review (optional)</label>
                            <textarea name="comment" rows="3"
                                        class="w-full border border-neutral-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500"
                                        placeholder="Share your experience with this course...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg font-medium transition">
                            <i class="fas fa-paper-plane mr-2 text-xs"></i>
                            {{ $userReview ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </form>
                </div>
            @elseif($isStudent && ! $isEnrolled)
                <p class="text-sm text-gray-500">
                    Enroll in this course to leave a review.
                </p>
            @endif
        @endauth
        <div class="space-y-4">
            @forelse ($reviews as $review)
                <div class="border border-neutral-100 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-1">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $review->user->name ?? 'Student' }}
                            </p>
                            <p class="text-[11px] text-gray-400">
                                {{ $review->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="flex items-center space-x-1 text-yellow-400 text-xs">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </div>

                    @if ($review->comment)
                        <p class="text-sm text-gray-700 mt-1">
                            {{ $review->comment }}
                        </p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">
                    No reviews yet. Be the first to review this course!
                </p>
            @endforelse
        </div>
    </div>
</div>
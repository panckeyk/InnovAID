{{-- Define necessary variables for calculations --}}
@php
    // Assuming you have current_amount and goal_amount fields
    $fundedAmount = $campaign->current_amount;
    $goalAmount = $campaign->goal_amount;

    // Calculate percentage funded, handling division by zero for safety
    $progressPercent = $goalAmount > 0 ? round(($fundedAmount / $goalAmount) * 100) : 0;

    // Calculate days left using Carbon (Laravel's default date library)
// Use diffInDays with absolute flag to get positive days, then check if deadline has passed
$deadlineDate = \Carbon\Carbon::parse($campaign->deadline);
$now = \Carbon\Carbon::now();
$daysLeft = (int) $now->diffInDays($deadlineDate, false);
$isExpired = $deadlineDate->isPast();

// Determine status for the badge (using your colors)
$categoryClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'; // Default category color

    // Access the creator object
    $creator = $campaign->creator;
@endphp


<div class="w-[20rem] bg-white border border-gray-200 rounded-lg shadow-sm 
            dark:bg-gray-800 dark:border-gray-700 overflow-hidden 
            transform transition duration-100 ease-in-out 
            hover:scale-105 hover:shadow-2xl hover:border-blue-300"
    {{-- CRITICAL: Directs to the specific campaign's show page --}} onclick="window.location.href='{{ route('campaigns.show', $campaign) }}'">

    <div class="h-40 w-full overflow-hidden">
        {{-- Use asset('storage/...') for image path (assuming local storage is linked) --}}
        <x-cloudinary::image public-id="{{ $campaign->image_public_id }}" width="320" height="160"
            class="w-full h-full object-cover" />
    </div>

    <div class="p-5">
        {{-- DYNAMIC: Category Badge --}}
        <span class="text-md font-medium px-2.5 py-0.5 rounded-sm {{ $categoryClass }}">
            {{ $campaign->category }}
        </span>

        {{-- DYNAMIC: Project Title (Line clamp for brevity) --}}
        <h5 class="my-5 text-2xl font-bold tracking-tight text-gray-900 dark:text-white line-clamp-2">
            {{ $campaign->title }}
        </h5>

        <div class="mt-5">
            <div class="flex items-center gap-3">

                @if ($creator->avatar)
                    <img src="{{ asset('storage/' . $creator->avatar) }}" alt="Creator Avatar"
                        class="w-10 h-10 rounded-full object-cover">
                @else
                    <div
                        class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($creator->firstname ?? 'U', 0, 1)) }}
                    </div>
                @endif

                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-gray-900">{{ $creator->firstname }} {{ $creator->lastname }}</span>
                    {{-- Assuming creator role is 'student', display their department if available --}}
                    <span
                        class="text-sm text-gray-500">{{ $creator->department ?? ucfirst($creator->role ?? 'Student') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="flex justify-between gap-2 mb-1">
                {{-- DYNAMIC: Current Amount --}}
                <span
                    class="text-sm font-medium text-blue-700 dark:text-white">${{ number_format($fundedAmount, 0) }}</span>
                {{-- DYNAMIC: Goal Amount --}}
                <span class="text-sm font-medium opacity-60 dark:text-white">of
                    ${{ number_format($goalAmount, 0) }}</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                {{-- DYNAMIC: Progress Bar Width --}}
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(100, $progressPercent) }}%"></div>
            </div>

            <div class="flex justify-between">
                <div class="flex gap-2 mb-1">
                    {{-- DYNAMIC: Percentage Funded --}}
                    <span class="text-sm font-medium text-blue-700 dark:text-white">{{ $progressPercent }}%</span>
                    <span class="text-sm font-medium text-blue-700 dark:text-white">Funded</span>
                </div>

                <div class="flex items-center gap-1">
                    <x-icons.calendaricon class="w-5 h-5 text-blue-700 dark:text-white" />
                    {{-- DYNAMIC: Days Left (Handle expired campaigns) --}}
                    @if ($isExpired || $daysLeft < 0)
                        <span class="text-sm font-medium text-red-500">Expired</span>
                    @elseif ($daysLeft == 0)
                        <span class="text-sm font-medium text-red-500">Last day!</span>
                    @else
                        <span class="text-sm font-medium opacity-60 dark:text-white">{{ $daysLeft }}
                            {{ $daysLeft == 1 ? 'day' : 'days' }} left</span>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

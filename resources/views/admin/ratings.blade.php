@extends('layouts.app')
@section('content')
    <style>
        .comment {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .comment img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .comment-body {
            margin-left: 10px;
            background: #f0f2f5;
            padding: 10px 12px;
            border-radius: 15px;
            max-width: 500px;
        }

        .comment-author {
            font-weight: bold;
            font-size: 13px;
        }

        .comment-author .verified {
            color: #1877f2;
            font-size: 12px;
            margin-left: 3px;
        }

        .comment-text {
            margin: 3px 0 0 0;
            font-size: 14px;
        }

        .comment-footer {
            font-size: 12px;
            color: #65676b;
            margin-top: 3px;
        }

        .nested-comment {
            margin-left: 50px;
            margin-top: 5px;
        }
    </style>
    <div id="content" class="app-content">
        <!-- BEGIN breadcrumb -->
        <ol class="breadcrumb float-xl-end">
            <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            <li class="breadcrumb-item active">Ratings</li>
        </ol>
        <!-- END breadcrumb -->
        <!-- BEGIN page-header -->
        <h1 class="page-header">Ratings </h1>
        <!-- END page-header -->
        @php
            $i = 1;
        @endphp
        @foreach ($ratings as $rating)
            <div class="panel panel-inverse">

                <div class="list-group list-group-flush rounded-bottom overflow-hidden panel-body p-1px">
                    <div class="list-group-item d-flex border-top-0">
                        <div class="me-3 fs-16px w-lg-150px w-150px">
                            <img src="/assets/img/gallery/gallery-2.jpg" alt="" class="mw-100 rounded" />
                        </div>
                        <div class="flex-fill">
                            <div class="fs-16px fw-500">{{ $rating->service_name }}</div>

                            <hr class="mb-10px bg-gray-600" />
                            <div class="d-flex align-items-center mb-5px">

                                @php

                                    $ratingValue = $rating->rating ?? 0; // e.g. 4.0, 3.5, etc.
                                    $fullStars = floor($ratingValue);
                                    $halfStar = $ratingValue - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                <div class="d-flex align-items-center">
                                    {{-- Full Stars --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <span class="text-warning fs-3">&#9733;</span> {{-- solid star --}}
                                    @endfor

                                    {{-- Half Star --}}
                                    @if ($halfStar)
                                        <span class="text-warning fs-3">&#189;</span> {{-- optional: use half-star icon or use fontawesome --}}
                                    @endif

                                    {{-- Empty Stars --}}
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <span class="text-secondary fs-3">&#9733;</span> {{-- empty/gray star --}}
                                    @endfor
                                </div>
                                <div class="fs-15px fw-bold">&nbsp;&nbsp;{{ $fullStars }}</div>

                                @if ($rating->type == 'service')
                                    <div class="ms-auto">
                                        <a href="#"
                                            class="btn btn-outline-default text-gray-600 btn-xs rounded-pill fs-12px px-2"
                                            data-bs-toggle="collapse" data-bs-target="#todoBoard{{ $i }}">
                                            {{ count(get_service_comment_populate($rating->reference_id)) }}
                                            {{ count(get_service_comment_populate($rating->reference_id)) === 1 ? 'comment' : 'comments' }}
                                        </a>
                                    </div>
                                @endif

                            </div>
                            <div class="form-group mb-1 fs-13px">

                                <div class="collapse " id="todoBoard{{ $i }}">
                                    @if ($rating->type == 'service')
                                        @php
                                            $comments = get_service_comment_populate($rating->reference_id);
                                        @endphp
                                        @foreach ($comments as $comment)
                                            <!-- Top-level comment -->
                                            <div class="comment">
                                                <img src="/assets/img/user/user-2.jpg" alt="Profile">
                                                <div class="comment-body">
                                                    <div class="comment-author">
                                                        {{ $comment->fullname }}  <span
                                                        class="badge bg-red text-white"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#rep-{{ $comment->comment_id }}"
                                                        aria-expanded="false"
                                                        aria-controls="rep-{{ $comment->comment_id }}">
                                                        {{count(get_service_comment_reply_populate($comment->comment_id))}}
                                                    </span>
                                                    </div>
                                                    <div class="comment-text">{{ $comment->comment }}</div>
                                                    <div class="comment-footer">
                                                        {{ humanReadableTime($comment->created_at) }} · <a
                                                            href="javascript:void(0);"
                                                            onclick="toggleReply({{ $comment->comment_id }})">Reply


                                                        </a>
                                                    </div>



                                                </div>
                                            </div>

                                            @php
                                                $comment_replies = get_service_comment_reply_populate($comment->comment_id);
                                            @endphp
                                                <div
                                                id="rep-{{ $comment->comment_id }}"
                                                class="collapse append-rep-{{ $comment->comment_id }}">
                                                @foreach ($comment_replies as $comment_reply)
                                                <!-- Nested reply -->
                                                <div class="comment nested-comment">
                                                    <img src="/assets/img/user/user-1.jpg" alt="Profile">
                                                    <div class="comment-body">
                                                        <div class="comment-author">
                                                            {{ $comment_reply->fullname }}
                                                        </div>
                                                        <div class="comment-text">
                                                            {{ $comment_reply->reply }}
                                                        </div>
                                                        <div class="comment-footer">
                                                            {{ humanReadableTime($comment_reply->created_at) }} ·
                                                            <a href="javascript:void(0);" onclick="toggleReply({{ $comment->comment_id }})">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        <!-- Hidden reply box -->
                                        <div id="reply-box-{{ $comment->comment_id }}" class="reply-box"
                                            style="display: none; margin-top: 10px;">
                                            <textarea rows="2" class="form-control" style="width: 100%;" id="text-reply-{{ $comment->comment_id }}"
                                                placeholder="Write a reply..."></textarea>
                                            <button
                                                onclick="submitReply({{ $comment->comment_id }}, {{ auth()->user()->id }})"
                                                class="btn btn-primary btn-xs me-1 mb-1  "
                                                style="margin-top: 5px; margin-left: 2px;">Reply</button>
                                        </div>

                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            @php
                $i++;
            @endphp
        @endforeach



        <!-- END row -->
    </div>
    <!-- END #content -->
    <script>
        $("#ratings").addClass('active')

        function toggleReply(commentId) {
            const box = document.getElementById('reply-box-' + commentId);
            const textarea = document.getElementById('text-reply-' + commentId);

            if (box.style.display === 'none' || box.style.display === '') {
                box.style.display = 'block';
                textarea.focus();
            } else {
                box.style.display = 'none';
                textarea.value = ''; // Clear the textarea
            }
        }

        // Auto-hide all reply boxes when clicking outside
        document.addEventListener('click', function(event) {
            const replyBoxes = document.querySelectorAll('.reply-box');
            replyBoxes.forEach(box => {
                const textarea = box.querySelector('textarea');
                if (!box.contains(event.target) && !event.target.matches('a[onclick^="toggleReply"]')) {
                    box.style.display = 'none';
                    if (textarea) textarea.value = ''; // Clear content when hidden
                }
            });
        });

        function submitReply(commentId, userId) {
            const replyText = document.getElementById('text-reply-' + commentId).value;
            const box = document.getElementById('reply-box-' + commentId);
            const textarea = document.getElementById('text-reply-' + commentId);

            var append = $('.append-rep-'+commentId);
            var html = ``;

            if (replyText.trim() === '') {
                alert("Reply can't be empty!");
                return;
            }

            $.ajax({
                url: "{{ route('comment.reply') }}", // Laravel route name
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    comment_id: commentId,
                    user_id: userId,
                    reply: replyText,
                },
                success: function(response) {

                    console.log(response);


                    if (response.status == 200) {

                        html = `
                        <div class="comment nested-comment">
                            <img src="/assets/img/user/user-1.jpg" alt="Profile">
                            <div class="comment-body">
                                <div class="comment-author">
                                    ${response.data.fullname}
                                </div>
                                <div class="comment-text">
                                    ${response.data.reply}
                                </div>
                                <div class="comment-footer">
                                    ${response.data.created_at} · Like ·
                                    <a href="javascript:void(0);" onclick="toggleReply(${response.data.comment_id})">Reply</a></div>
                            </div>
                        </div>

                        `
                        append.append(html);
                        box.style.display = 'none';
                        textarea.value = ''; // Clear the textarea

                    }



                    // alert('Reply sent successfully!');
                    // $('#text-reply-' + commentId).val('');
                    // $('#reply-box-' + commentId).hide();

                    // Optional: You can also append the new reply to a replies list dynamically
                    // $('#replies-for-' + commentId).append('<div>' + response.reply + '</div>');
                },
                error: function(xhr) {
                    alert('Error sending reply.');
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection

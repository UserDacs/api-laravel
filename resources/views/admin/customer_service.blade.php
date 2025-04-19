@extends('layouts.app')
@section('content')
    <style>
        .widget-chat-body {

            justify-content: flex-end;

        }

        #typing {
            color: gray;
            font-style: italic;
        }

        .dropdown-custom-list {
            max-height: 300px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .dropdown-item:hover {
            background-color: #f1f1f1;
        }
    </style>
    <div id="content" class="app-content p-0">
        <div class="messenger" id="messenger">
            <div class="messenger-chat">
                <div class="messenger-chat-header d-flex">
                    <!-- Search Container -->
                    <div class="position-relative w-100" style="max-width: 400px;">
                        <div class="flex-1 position-relative">
                            <input type="text" id="searchUser" class="form-control border-0 bg-light ps-30px"
                                placeholder="Search..." autocomplete="off" />
                            <i
                                class="fa fa-search position-absolute start-0 top-0 h-100 ps-2 ms-3px d-flex align-items-center justify-content-center"></i>
                        </div>

                        <!-- Search Results Dropdown -->
                        <div id="searchResults"
                            class="dropdown-custom-list position-absolute bg-white shadow-sm border rounded mt-1 w-100"
                            style="z-index: 999; display: none;">
                            <!-- AJAX results go here -->
                        </div>
                    </div>

                    <!-- Optional add button -->
                    <div class="ps-2">
                        <a href="#" class="btn border-0 bg-light shadow-none">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="messenger-chat-body">
                    <div data-scrollbar="true" data-height="100%">
                        <div class="messenger-chat-list">


                        </div>
                    </div>
                </div>
            </div>
            <div class="messenger-content">
                <div class="widget-chat">
                    <!-- BEGIN widget-chat-header -->
                    <div class="widget-chat-header">
                        <div class="d-block d-lg-none">
                            <button type="button" class="btn border-0 shadow-none"
                                data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
                                <i class="fa fa-chevron-left fa-lg"></i>
                            </button>
                        </div>
                        <div class="widget-chat-header-content">
                            <div class="fs-5 fw-bold">Customer Service</div>
                        </div>
                        <div class="">
                            <button type="button" class="btn border-0 shadow-none" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis fa-lg"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Another action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END widget-chat-header -->
                    <!-- BEGIN widget-chat-body -->
                    <div class="widget-chat-body " data-scrollbar="true" data-height="100%">


                    </div>
                    {{--
                    <form id="sendMessageForm">
                        <input type="hidden" name="receiver_id" value="8">
                        <input type="hidden" name="reply_to_id" id="reply_to_id">
                        <textarea name="message" placeholder="Type your message..."></textarea>
                        <br>
                        <input type="file" name="image" id="image">
                        <br>
                        <button type="submit">Send</button>
                    </form> --}}
                    <!-- END widget-chat-body -->
                    <!-- BEGIN widget-input -->
                    <form id="sendMessageForm">
                        <div class="widget-chat-input d-flex align-items-center">

                            <input type="hidden" name="receiver_id" id="receiver_id" value="0">
                            <input type="hidden" name="reply_to_id" id="reply_to_id">
                            <textarea name="message" class="form-control messageInput" id="messageInput" placeholder="Type a message..."></textarea>
                            <button type="submit" class="btn btn-primary" style="margin-right: 10px">
                                <i class="fa fa-paper-plane"></i>
                            </button>

                        </div>
                    </form>
                    <!-- END widget-input -->
                </div>
            </div>
        </div>
    </div>
    <!-- END #content -->
    {{-- app-sidebar-minified app-content-full-height  --}}
    {{-- TYping  --}}

    {{-- <div class="widget-chat-item with-media start">
        <div class="widget-chat-media">
            <img alt="" src="../assets/img/user/user-4.jpg">
        </div>
        <div class="widget-chat-info">
            <div class="widget-chat-info-container">
                <div class="widget-chat-message" id="typing">typing ...</div>

            </div>
        </div>
    </div> --}}

    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>

    {{-- Socket --}}
    <script>
        const chatBody = document.querySelector('.widget-chat-body');


        const socket = io("http://13.210.217.37:3000");

        let typingTimeout;
        let isTyping = false;

        socket.on("connect", () => {
            console.log("✅ Connected to server:", socket.id);
        });

        socket.on("receive-message", (data) => {
            console.log("📥 Received message from server:", data);

            var receiver_id = parseInt('{{ Auth::user()->id }}', 10);
            if (receiver_id == data.receiver_id) {
                $(".sammp").remove();

                $('.widget-chat-body').append(`
                            <div class="widget-chat-item with-media start">
								<div class="widget-chat-media">
									<img alt="" src="${data.image_path}">
								</div>
								<div class="widget-chat-info">
									<div class="widget-chat-info-container">
										<div class="widget-chat-name text-blue">${data.sender_name}</div>
										<div class="widget-chat-message"> ${data.message} </div>
										<div class="widget-chat-time">${data.created_at_human}</div>
									</div>
								</div>
							</div>
                `)

            }




            chatBody.scrollTop = chatBody.scrollHeight;
            // const messageList = document.getElementById("messages");
            // const item = document.createElement("li");
            console.log(`From ${data.sender_id} to ${data.receiver_id}: ${data.message}`);

            // item.textContent = `From ${data.sender_id} to ${data.receiver_id}: ${data.message}`;
            // messageList.appendChild(item);
        });

        socket.on("typing", (data) => {
            console.log(data);

            var sender_id = $('#receiver_id').val();

            console.log(`✏️ [typing event received] ${data} is typing...`);
            var receiver_id = '{{ Auth::user()->id }}';
            if (receiver_id == data.receiver_id && sender_id == data.sender_id) {
                $('.widget-chat-body').append(`
                <div class="widget-chat-item with-media start sammp">
                    <div class="widget-chat-media">
                        <img alt="" src="${data.image_path}">
                    </div>
                    <div class="widget-chat-info">
                        <div class="widget-chat-info-container">
                            <div class="widget-chat-message" id="typing">typing ...</div>

                        </div>
                    </div>
                </div>
                `);
                chatBody.scrollTop = chatBody.scrollHeight;
            }



        });

        socket.on("stop-typing", (data) => {
            console.log(`🛑 [stop-typing event received] ${data.sender_name} stopped typing.`);
            var receiver_id = '{{ Auth::user()->id }}';
            if (receiver_id == data.receiver_id) {
                $(".sammp").remove();
                chatBody.scrollTop = chatBody.scrollHeight;
            }

        });

        const messageInput = document.getElementById("messageInput");

        messageInput.addEventListener("input", () => {
            console.log("⌨️ User input detected");
            //   document.getElementById("typing").innerHTML = 'typing...';

            if (!isTyping) {
                isTyping = true;
                var receiver_id = $('#receiver_id').val();
                console.log("🚀 Emitting 'typing' event");
                socket.emit("typing", {
                    receiver_id: receiver_id,
                    sender_id: '{{ Auth::user()->id }}',
                    sender_name: "{{ Auth::user()->firstname . '  ' .  Auth::user()->lastname }}",
                    image_path: '{{ Auth::user()->image_path }}'
                });
            }

            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
                var receiver_id = $('#receiver_id').val();
                isTyping = false;
                console.log("⌛ Timeout reached, emitting 'stop-typing'");
                // document.getElementById("typing").innerHTML = '';
                socket.emit("stop-typing", {
                    receiver_id: receiver_id,
                    sender_id: '{{ Auth::user()->id }}',
                    sender_name: "{{ Auth::user()->firstname . '  ' .  Auth::user()->lastname }}",
                    image_path: '{{ Auth::user()->image_path }}'
                });
            }, 1500);
        });

        function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) {
                console.log("⚠️ Cannot send empty message.");
                return;
            }

            const messageData = {
                id: Math.floor(Math.random() * 1000),
                sender_id: 2,
                receiver_id: "6",
                message: message,
                image_path: null,
                reply_to_id: null,
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString()
            };

            console.log("📤 Sending message:", messageData);
            socket.emit("send-message", messageData);
            messageInput.value = "";
        }
    </script>
    <script>
        const currentUserId = {{ auth()->id() }};
        const currentUserImage = "{{ auth()->user()->image_path }}"
    </script>
    <script>
        $("#users-customer_service").addClass('active')
        $("#app").addClass('app-content-full-height')


        function clickConvo(user_id = 0,array_data={image_path:'',name:''}) {
            const messageInput = document.getElementById("messageInput");
            messageInput.value = ""

            $('.messenger-chat-item').removeClass('active');
            $('.messenger-chat-item-' + user_id).addClass('active');

            const chatBody = document.querySelector('.widget-chat-body');




            $('#receiver_id').val(user_id)

            $.get('/api/message/conversation/' + user_id, function(res) {
                $('.widget-chat-body').html('');

                console.log("Conversation response:", res); // 👈 Log response in console

                if (res.length === 0) {
                    $('.widget-chat-body').html(`
                       <div class="text-center text-muted mt-3">
                            <img alt="" src="${array_data.image_path}"
                                class="mx-auto d-block rounded-circle mb-2"
                                style="width: 80px; height: 80px; object-fit: cover;">

                            <div class="fw-bold">${array_data.name}</div>
                            <div class="mt-1">You haven't started a conversation with this user yet.</div>
                        </div>
                    `);
                    return;
                }

                res.forEach(msg => {
                    if (msg.is_read == 0 && msg.sender_id == {{Auth::id()}}) {
                        $.ajax({
                            url: '/web/message/read/' + msg.id ,  // Your route URL
                            method: 'PATCH', // HTTP method
                            success: function(response) {
                                console.log(response);
                            },
                            error: function(xhr) {
                                console.log(xhr);


                            }
                        });
                    }
                    let isCurrentUser = (msg.sender_id === currentUserId);
                    let alignmentClass = isCurrentUser ? 'end' : 'start';

                    console.log("Receiver Image:", msg.receiver_image); // 👈 Log receiver image

                    let profileImage = msg.sender_image;
                    let displayName = msg.sender_name;
                    let showName = !isCurrentUser ?
                        `<div class="widget-chat-name text-blue">${displayName}</div>` : '';

                    let messageHTML = `
                        <div class="widget-chat-item with-media ${alignmentClass}">
                            <div class="widget-chat-media">
                                <img alt="" src="${profileImage}">
                            </div>
                            <div class="widget-chat-info">
                                <div class="widget-chat-info-container">
                                    ${showName}
                                    <div class="widget-chat-message">${msg.message}</div>
                                    <div class="widget-chat-time">${msg.created_at_human}</div>
                                </div>
                            </div>
                        </div>
                    `;

                    $('.widget-chat-body').append(messageHTML);
                });

                // Auto-scroll to bottom
                const chatBody = document.querySelector('.widget-chat-body');
                chatBody.scrollTop = chatBody.scrollHeight;
            });



        }
        $('#sendMessageForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: '/api/message/send',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: res => {
                    // alert(res.message);
                    console.log(res);

                    // $('#sendMessageForm')[0].reset();
                    clickConvos()

                    const message = messageInput.value.trim();
                    if (!message) {
                        console.log("⚠️ Cannot send empty message.");
                        return;
                    }

                    const messageData = {
                        id: res.data.id,
                        sender_name: res.data.sender_name,
                        sender_id: res.data.sender_id,
                        receiver_id: res.data.receiver_id,
                        message: res.data.message,
                        image_path: res.data.sender_image,
                        reply_to_id: res.data.reply_to_id,
                        created_at: res.data.created_at,
                        created_at_human: res.data.created_at_human,
                        updated_at: res.data.updated_at
                    };

                    console.log("📤 Sending message:", messageData);

                    $('.widget-chat-body').append(`
                            <div class="widget-chat-item with-media end">
								<div class="widget-chat-media">
									<img alt="" src="${res.data.sender_image}">
								</div>
								<div class="widget-chat-info">
									<div class="widget-chat-info-container">
										<div class="widget-chat-message"> ${res.data.message} </div>
										<div class="widget-chat-time"> ${res.data.created_at_human} </div>
									</div>
								</div>
							</div>
                    `)

                    socket.emit("send-message", messageData);
                    messageInput.value = "";
                },
                error: err => {
                    alert('Error sending message');
                }
            });
        });





        function clickConvos() {

            $('.messenger-chat-list').html('');

            $.get('/api/message/constac', function(res) {


                res.forEach((msg, index) => {
                    if (index === 0) {
                        console.log(msg.user_id);
                        clickConvo(msg.user_id)
                    }
                    $('.messenger-chat-list').append(`
                    <div class="messenger-chat-item ${index === 0 ? 'active' : ''} messenger-chat-item-${ msg.user_id}" onclick="clickConvo(${ msg.user_id })">
                    <a href="javascript:;" class="messenger-chat-link"
                        data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
                        <div class="messenger-chat-media">
                            <img alt="" src="${ msg.user_image_path }" />
                        </div>
                        <div class="messenger-chat-content">
                            <div class="messenger-chat-title">
                                <div>${ msg.user_name }</div>
                                <div class="messenger-chat-time">
                                    ${msg.created_at_human}
                                </div>
                            </div>
                            <div class="messenger-chat-desc">${ msg.message_content }</div>
                        </div>
                    </a>
                    </div>
                `);
                });


            });


        }
        clickConvos();
    </script>
    <script>
        $(document).ready(function() {
            $("#searchUser").on("input", function() {
                const keyword = $(this).val().trim();
                console.log(keyword);


                if (keyword.length === 0) {
                    $("#searchResults").hide().empty();
                    return;
                }

                $.ajax({
                    url: "/api/search-users", // replace this with your actual endpoint
                    method: "GET",
                    data: {
                        q: keyword
                    },
                    success: function(res) {
                        $("#searchResults").empty();

                        if (res.length === 0) {
                            $("#searchResults").append(
                                `<div class="dropdown-item px-3 py-2 text-muted">No results found</div>`
                                );
                        } else {
                            res.forEach(user => {
                                $("#searchResults").append(`
                      <div class="dropdown-item d-flex align-items-center px-3 py-2" onclick="clickConvo(${user.id},array_data={image_path:'${user.image_path}',name:'${user.name}'})" style="cursor: pointer;">
                        <img src="${user.image_path || 'https://via.placeholder.com/30'}" class="rounded-circle me-2" width="30" height="30" />
                        <div>
                          <div class="fw-bold">${user.name}</div>
                          <small class="text-muted">${user.email}</small>
                        </div>
                      </div>
                    `);
                            });
                        }

                        $("#searchResults").show();
                    },
                    error: function() {
                        $("#searchResults").hide().empty();
                    }
                });
            });

            // Hide results when clicking outside
            $(document).on("click", function(e) {
                if (!$(e.target).closest("#searchUser, #searchResults").length) {
                    $("#searchResults").hide();
                }
            });
        });
    </script>
@endsection

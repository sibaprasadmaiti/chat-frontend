<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting Tool</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/chat-tool.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div class="page-wraper">
        <div class="chat_tool">
            <div class="chat_window">
                <div class="welcome_page">
                    <div class="chat_win_intro">
                        <h3>Welcome to Chat Tool</h3>
                        <p>
                            Search the Help Center or start a chat. We're here to help you 24x7.
                        </p>
                    </div>

                    <div class="ch_theme_button">
                        <button class="gotoForm">
                            <ion-icon class="ion-android-send n_con_icon"></ion-icon>
                            New Conversation
                        </button>
                    </div>
                </div>
                <div class="user_form">
                    <div class="chat_header">
                        <div class="chat_header_inner">
                            <button class="chat_back_button" data-toggle="tooltip" data-placement="bottom" title="Back">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <form id="firstForm" method="post" onsubmit="return false">
                        <div class="user_form_inner">
                            <div class="fieldrow">
                                <input class="user_form_input" type="text" name="name" placeholder="Name" required onkeydown="this.value = this.value.trim()" onkeyup="this.value = this.value.trim()" />
                                <span class="error_note d-none">Name is required</span>
                            </div>
                            <div class="fieldrow">
                                <input class="user_form_input" type="email" name="email" placeholder="Email" required />
                                <span class="error_note d-none">Email is required</span>
                            </div>
                            <div class="fieldrow">
                                <input class="user_form_input" type="text" name="contact_no" pattern="[6789][0-9]{9}" placeholder="Contact No." required />
                                <span class="error_note d-none">Contact No. is required</span>
                            </div>
                            <div class="fieldrow">
                                <textarea class="user_form_input" name="first_message" rows="3" placeholder="write message here..." required onkeydown="this.value = this.value.trim()" onkeyup="this.value = this.value.trim()"></textarea>
                            </div>
                        </div>
                        <div class="ch_theme_button">
                            <button class="chatSMS" type="submit">
                                <ion-icon class="ion-android-send n_con_icon"></ion-icon>
                                Start Chat
                            </button>
                        </div>
                    </form>
                </div>

                <div class="chat_con">
                    <div class="chat_header">
                        <div class="chat_header_inner">
                            <button class="chat_back_button" data-toggle="tooltip" data-placement="bottom" title="Back">
                                <i class="fa fa-angle-left" aria-hidden="true"></i>
                            </button>
                            <!-- <button data-toggle="tooltip" data-placement="bottom" title="Options">
                              <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                          </button> -->
                        </div>
                    </div>
                    <div class="chat_con_body">
                        <div class="chat_con_inner">

                        </div>
                    </div>
                    <div class="chat_footer">
                        <form class="chat-form" action="">
                            <div class="chat_footer_inner">
                                <input type="text" id="m" class="chat_reply_input" placeholder="Write message here..." required />
                                <input type="hidden" name="userId" id="userId" value="">
                                <input type="hidden" name="storeId" id="storeId" value="">
                                <button class="chat_reply_submit" data-toggle="tooltip" data-placement="bottom" title="Submit">
                                    <ion-icon class="ion-android-send"></ion-icon>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button class="call_button">
                <i class="fa fa-comments" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <script src="js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.0/socket.io.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $(".chat_back_button").click(function() {
            $(".chat_window").slideToggle(200);
            // $(".user_form").hide(0);
            // $(".welcome_page").hide(0);            
            // $(".chat_con").hide(0);
            // $('.chat_con_inner').html("");
        });
        // $(".call_button").click(function () {
        //     $(".chat_window").slideToggle(200);
        // });

        // $(".gotoForm").click(function () {
        //     $(".user_form").show(0);
        //     $(".welcome_page").hide(0);            
        //     $(".chat_con").hide(0);
        // });

        // $(".chatSMS").click(function () {            
        //     $(".chat_con").show(0);
        //     $(".user_form").hide(0);
        //     $(".welcome_page").hide(0);    
        // });
        document.getElementById("m").addEventListener('keydown', function(e) {
            if (this.value.length === 0 && e.which === 32) e.preventDefault();
        });
    </script>

    <script>
        var ENDPOINT = "http://localhost:3309"
        var socket = io(ENDPOINT);
        socket.emit('site visit', null);
        var name = "";

        $('#firstForm').submit(function() {
            var values = {};
            $.each($('#firstForm').serializeArray(), function(i, field) {
                values[field.name] = field.value;
            });
            socket.emit('joining msg', values);
            name = values.name;
            var firstmessage = "";
            if (values.first_message) {
                firstmessage = '<p>Message:  ' + values.first_message + '</p>';
            }
            $('.chat_con_inner').append($('<div class="chat_messages visitor">').html('<h3>Name:  ' + values.name + '</h3>' + '<p>Email:  ' + values.email + '</p><p>Contact No:  ' + values.contact_no + '</p>' + firstmessage));
            $('.chat_con_inner').append($('<div class="clearfix">'));
            $('#m').val('');
            $(".chat_con").show(0);
            $(".user_form").hide(0);
            $(".welcome_page").hide(0);
        });


        $('.chat-form').submit(function(e) {
            e.preventDefault(); // will prevent page reloading
            // socket.emit('chat message', (name + ':  ' + $('#m').val()));
            socket.emit('chat message', ({
                "userId": $('#userId').val(),
                "storeId": $('#storeId').val(),
                "clientMsg": $('#m').val(),
                "msgType": "receiver"
            }));
            $('#messages').append($('<li id="list">').text($('#m').val()));
            $('.chat_con_inner').append($('<div class="chat_messages visitor">').html('<h3>' + name + '</h3><p>' + $('#m').val() + '</p><span>12:01</span>'));
            $('.chat_con_inner').append($('<div class="clearfix">'));
            $('#m').val('');
            $(".chat_con_body").stop().animate({
                scrollTop: $(".chat_con_body")[0].scrollHeight
            }, 1000);
            return false;
        });

        socket.on('chat message', function(msg) {
            var chatDate = new Date();
            var cHour = chatDate.getHours();
            var cMin = chatDate.getMinutes();
            $('.chat_con_inner').append($('<div class="chat_messages">').html('<h3>' + msg.adminName + '</h3><p>' + msg.message + '</p><span>' + cHour + ':' + cMin + '</span>'));
            $('.chat_con_inner').append($('<div class="clearfix">'));
            $(".chat_con_body").stop().animate({
                scrollTop: $(".chat_con_body")[0].scrollHeight
            }, 1000);
            let x = document.cookie;
            console.log(x);
        });

        socket.on('first message', function(msg) {
            console.log(msg);
            $('#userId').val(msg.userId);
            $('#storeId').val(msg.storeId);

            document.cookie = "userId=" + msg.userId;
            document.cookie = "storeId=" + msg.storeId;

        });

        $(".call_button").click(function() {

            let getCookie = document.cookie;
            let userId = 0;
            let storeId = 0;

            if (getCookie != null && getCookie != "undefined" && getCookie != 0) {
                if (getCookie.includes("userId")) {
                    let getCookieArr = getCookie.split(";");
                    $.each(getCookieArr, function(key, value) {
                        var strCookie = value.trim();
                        var inCookeArr = strCookie.split("=");
                        if (inCookeArr[inCookeArr.indexOf("userId")] == "userId") {
                            userId = inCookeArr[1];
                        }
                        if (inCookeArr[inCookeArr.indexOf("storeId")] == "storeId") {
                            storeId = inCookeArr[1];
                        }
                    });
                }
            }
            console.log(userId);
            console.log(storeId);
            socket.emit('check message', {
                "user_id": userId,
                "store_id": storeId
            });

            $(".chat_window").slideToggle(200);

            socket.on('check client chat data', function(msg) {
                console.log(msg);
                if (getCookie && msg.length > 0) {
                    $(".welcome_page").hide(0);
                    $(".user_form").hide(0);
                    console.log("Cookies already have set");
                    //$('#messages').append($('<li id="list">').html('<span>Name:  ' + msg[0].name + '</span></br>' + '<span>Email:  ' + msg[0].email + '</span></br><span>Contact No:  ' + msg[0].mobile_no + '</span></br><span>Message:  ' + msg[0].message + '</span>'));
                    name = msg[0].name;
                    $('#userId').val(userId);
                    $('#storeId').val(storeId);
                    $('.chat_con_inner').html("");

                    var html = "";
                    $.each(msg[0].chatmessages, function(key, val) {
                        var chatDate = new Date(val.createdAt);
                        var cHour = chatDate.getHours();
                        var cMin = chatDate.getMinutes();
                        //var cSec = today.getSeconds();
                        if (val.type == "receiver") {
                            $('.chat_con_inner').append($('<div class="chat_messages visitor">').html('<h3>' + name + '</h3><p>' + val.message + '</p><span>' + cHour + ':' + cMin + '</span>'));
                            $('.chat_con_inner').append($('<div class="clearfix">'));
                        } else {
                            $('.chat_con_inner').append($('<div class="chat_messages">').html('<h3>' + val.adminUserName + '</h3><p>' + val.message + '</p><span>' + cHour + ':' + cMin + '</span>'));
                            $('.chat_con_inner').append($('<div class="clearfix">'));
                        }
                    });
                    $(".chat_con").show(0);

                } else {
                    console.log("Cookies have not set");
                    $(".user_form").hide(0);
                    $(".chat_con").hide(0);
                    $(".welcome_page").show(0);
                }
            });
        });


        $(".gotoForm").click(function() {
            $(".user_form").show(0);
            $(".chat_con").hide(0);
            $(".welcome_page").hide(0);
        });

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
    </script>

</html>